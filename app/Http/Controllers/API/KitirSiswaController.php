<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\KitirSiswaCollection;
use App\KitirSiswa;
use App\Siswa;
use App\Kelas;
use App\KelasAnggota;

class KitirSiswaController extends Controller
{
    public function index(Request $request)
    {
        if (request()->q != '') {
            $q = $request->q;
            $kitirsiswas = KitirSiswa::with(['creator','approve'])
                                     ->with(['siswa' => function ($query) {
                                            $query->select('id', 's_nama', 'uuid');
                                        }])
                                     ->whereHas('siswa', function($query) use($q){
                                            $query->where('siswa_nama','like','%'.$q.'%');
                                        });
        } else {
            $kitirsiswas = KitirSiswa::with(['creator','approve'])
                                        ->with(['siswa' => function ($query) {
                                            $query->select('id', 's_nama', 'uuid');
                                            }])
                                        ->orderBy('created_at', 'DESC');
        }
        $user = $request->user();
        // if($user->role!=0){
        //     $kitirsiswas = $kitirsiswas->where('user_id',$user->id);
        // }
        $kitirsiswas = $kitirsiswas->paginate(10);
        foreach ($kitirsiswas as $row){
                $kelas = KelasAnggota::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->first();
                $row['kelas'] = $kelas?Kelas::where('id',$kelas['kelas_id'])->value('kelas_nama'):'-';
                $row['absen'] = $kelas?$kelas['absen']:'-';
        }
        return new KitirSiswaCollection($kitirsiswas);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'ks_keterangan' => 'required',
            'ks_tanggal' => 'required|date',
            'ks_jenis' => 'required|string|max:150'
        ]);
        $user = $request->user();
        if(empty($request->siswa)){
            $getKS = KitirSiswa::orderBy('id', 'DESC');
            $rowCount = $getKS->count();
            $lastId = $getKS->first();

            if($rowCount==0) {
                $kode = "KS".date('y').date('m').date('d')."001";
            } else {
                if(substr($lastId->ks_kode,2,6) == date('y').date('m').date('d')) {
                $counter = (int)substr($lastId->ks_kode,-3) + 1 ;
                    if($counter < 10) {
                        $kode = "KS".date('y').date('m').date('d')."00".$counter;
                    } elseif ($counter < 100) {
                        $kode = "KS".date('y').date('m').date('d')."0".$counter;
                    } else {
                        $kode = "KS".date('y').date('m').date('d').$counter;
                    }
                } else {
                    $kode = "KS".date('y').date('m').date('d')."001";
                }
            }
            KitirSiswa::create([
                'ks_kode' => $kode,
                'siswa_id' => $request->siswa_id['id'],
                'ks_tanggal' => $request->ks_tanggal,
                'ks_jenis' => $request->ks_jenis,
                'ks_start' => $request->ks_start,
                'ks_end' => $request->ks_end,
                'ks_keterangan' => $request->ks_keterangan,
                'ks_status' => 0,
                'creator_id' => $user->id,
                'last_at' => date('d-m-y H:i')
            ]);
        } else {
            foreach($request->siswa as $row) {
                $getKS = KitirSiswa::orderBy('id', 'DESC');
                $rowCount = $getKS->count();
                $lastId = $getKS->first();

                if($rowCount==0) {
                    $kode = "KS".date('y').date('m').date('d')."001";
                } else {
                    if(substr($lastId->ks_kode,2,6) == date('y').date('m').date('d')) {
                    $counter = (int)substr($lastId->ks_kode,-3) + 1 ;
                        if($counter < 10) {
                            $kode = "KS".date('y').date('m').date('d')."00".$counter;
                        } elseif ($counter < 100) {
                            $kode = "KS".date('y').date('m').date('d')."0".$counter;
                        } else {
                            $kode = "KS".date('y').date('m').date('d').$counter;
                        }
                    } else {
                        $kode = "KS".date('y').date('m').date('d')."001";
                    }
                }
                KitirSiswa::create([
                    'ks_kode' => $kode,
                    'siswa_id' => $row['siswa']['id'],
                    'ks_tanggal' => $request->ks_tanggal,
                    'ks_jenis' => $request->ks_jenis,
                    'ks_start' => $request->ks_start,
                    'ks_end' => $request->ks_end,
                    'ks_keterangan' => $request->ks_keterangan,
                    'ks_status' => 0,
                    'creator_id' => $user->id,
                    'last_at' => date('d-m-y H:i')
                ]);
            }

        }
        return response()->json(['status' => 'success']);
    }

    public function view($id)
    {
        $kitirsiswas = KitirSiswa::whereKitirSiswa_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $kitirsiswa], 200);
    }

    public function edit($id)
    {
        $kitirsiswas = KitirSiswa::with('siswa')->whereKs_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $kitirsiswas], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'siswa_id' => 'required',
            'ks_tanggal' => 'required|date',
            'ks_keterangan' => 'required',
            'ks_jenis' => 'required|string|max:150'
        ]);

        $user = $request->user();
        $kitirsiswa = KitirSiswa::whereKs_kode($request->ks_kode);
        $kitirsiswa->update([
                        'ks_tanggal' => $request->ks_tanggal,
                        'ks_jenis' => $request->ks_jenis,
                        'ks_start' => $request->ks_start,
                        'ks_end' => $request->ks_end,
                        'ks_keterangan' => $request->ks_keterangan,
                        'ks_status' => 0,
                        'creator_id' => $user->id,
                        'last_at' => date('d-m-y H:i'),
                        'approve_by' => null,
                        'approve_at' => null
                    ]);
        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $kitirsiswa = KitirSiswa::find($id);
        $kitirsiswa->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function changeStatus(Request $request,$kode) {
        $user = $request->user();
        $ks = KitirSiswa::whereKs_kode($kode)->first();
            $ks->update(['ks_status' => $request->status,
                         'approve_by' => $user->id,
                         'approve_at' => date('d-m-y H:i'),]);
        return response()->json(['status' => 'success'], 200);
    }
}
