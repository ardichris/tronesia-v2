<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PelanggaranCollection;
use App\Pelanggaran;
use App\MasterPelanggaran;
use App\JamMengajar;
use App\User;
use App\Kelas;
use App\KelasAnggota;
use App\KitirSiswa;
use DB;

class PelanggaranController extends Controller
{
    function createKitirMasuk($id_siswa, $tanggal, $jenis, $user, $keterangan){
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
                    'siswa_id' => $id_siswa,
                    'ks_tanggal' => $tanggal,
                    'ks_jenis' => $jenis,
                    'ks_start' => 0,
                    'ks_end' => null,
                    'ks_keterangan' => $keterangan,
                    'ks_status' => 0,
                    'creator_id' => $user,
                    'last_at' => date('d-m-y H:i')
                ]);
    }

    public function total(Request $request)
    {
        $total = Pelanggaran::where('siswa_id',$request->siswa)->count();
        return response()->json(['status' => 'success', 'data' => $total], 200);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $pelanggarans = Pelanggaran::with(['user','jurnal','siswa.kelas','masterpelanggaran'])
                                    ->with(['siswa' => function ($query) {
                                            $query->select('id', 's_nama', 'uuid');
                                        }])
                                    ->where('unit_id',$user->unit_id)
                                    ->orderBy('created_at', 'DESC');
        if (request()->q != '') {
            $q = request()->q;
            $pelanggarans = $pelanggarans->where(function ($query) use ($q) {
                                            $query  ->whereHas('siswa', function($query) use($q){
                                                        $query->where('s_nama','like','%'.$q.'%');
                                                        })
                                                    ->orWhere('pelanggaran_jenis','like','%'.$q.'%')
                                                    ->orWhere('pelanggaran_keterangan','like','%'.$q.'%');
                                                });
        }
        $gurubk = JamMengajar::where('mapel_id',22)->where('guru_id',$user->id)->pluck('kelas_id');
        // if($user->role==2){
        //     $pelanggarans = $pelanggarans->where(function ($query) use ($gurubk, $user) {
        //                                     $query  ->whereHas('siswa.kelas', function($query) use($user){
        //                                                 $query->where('kelas_wali',$user->id);
        //                                                 })
        //                                             ->orwhereHas('siswa.kelas', function($query) use($user){
        //                                                 $query->where('k_mentor', $user->id);
        //                                                 })
        //                                             ->orwhereHas('siswa', function($query) use($gurubk){
        //                                                 $query->whereIn('kelas_id', $gurubk);
        //                                                 });
        //                                 });
        // }
       // return response()->json(['status' => $pelanggarans->get()], 200);
       $pelanggarans = $pelanggarans->paginate(10);
       foreach ($pelanggarans as $row){
            $kelas = KelasAnggota::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->first();
            $row['kelas'] = $kelas?Kelas::where('id',$kelas['kelas_id'])->value('kelas_nama'):'-';
            $row['absen'] = $kelas?$kelas['absen']:'-';
       }

        return new PelanggaranCollection($pelanggarans);
    }

    public function store(Request $request)
    {
        //BUAT VALIDASI DATA
        $this->validate($request, [
            'pelanggaran_tanggal' => 'required|date',
        ]);
        $user = $request->user();
        if(empty($request->pelanggar)){
            $getPL = Pelanggaran::orderBy('id', 'DESC');
            $rowCount = $getPL->count();
            $lastId = $getPL->first();

            if($rowCount==0) {
                $kode = "PL".date('y').date('m').date('d')."001";
            } else {
                if(substr($lastId->pelanggaran_kode,2,6) == date('y').date('m').date('d')) {
                $counter = (int)substr($lastId->pelanggaran_kode,-3) + 1 ;
                    if($counter < 10) {
                        $kode = "PL".date('y').date('m').date('d')."00".$counter;
                    } elseif ($counter < 100) {
                        $kode = "PL".date('y').date('m').date('d')."0".$counter;
                    } else {
                        $kode = "PL".date('y').date('m').date('d').$counter;
                    }
                } else {
                    $kode = "PL".date('y').date('m').date('d')."001";
                }
            }
            Pelanggaran::create([
                'pelanggaran_kode' => $kode,
                'siswa_id' => $request->siswa_id['id'],
                'mp_id' => $request->mp_id['id'],
                'pelanggaran_tanggal' => $request->pelanggaran_tanggal,
                'pelanggaran_keterangan' => $request->pelanggaran_keterangan,
                'user_id' => $user->id,
                'unit_id' => $user->unit_id,
                'periode_id' => $user->periode
            ]);
            if( $request->mp_id['mp_pelanggaran'] == "Terlambat") {
                $this->createKitirMasuk($request->siswa_id['id'],$request->pelanggaran_tanggal,"Masuk Kelas",$user->id,"Terlambat");
            }
        } else {
            foreach($request->pelanggar as $row) {
                $getPL = Pelanggaran::orderBy('id', 'DESC');
                $rowCount = $getPL->count();
                $lastId = $getPL->first();

                if($rowCount==0) {
                    $kode = "PL".date('y').date('m').date('d')."001";
                } else {
                    if(substr($lastId->pelanggaran_kode,2,6) == date('y').date('m').date('d')) {
                    $counter = (int)substr($lastId->pelanggaran_kode,-3) + 1 ;
                        if($counter < 10) {
                            $kode = "PL".date('y').date('m').date('d')."00".$counter;
                        } elseif ($counter < 100) {
                            $kode = "PL".date('y').date('m').date('d')."0".$counter;
                        } else {
                            $kode = "PL".date('y').date('m').date('d').$counter;
                        }
                    } else {
                        $kode = "PL".date('y').date('m').date('d')."001";
                    }
                }


                Pelanggaran::create([
                    'pelanggaran_kode' => $kode,
                    'siswa_id' => $row['siswa']['id'],
                    'mp_id' => $row['mp_id']['id'],
                    'pelanggaran_tanggal' => $request->pelanggaran_tanggal,
                    'user_id' => $user->id,
                    'unit_id' => $user->unit_id,
                    'periode_id' => $user->periode
                ]);
                if( $row['mp_id']['mp_pelanggaran'] == "Terlambat") {
                    $this->createKitirMasuk($row['siswa']['id'],$request->pelanggaran_tanggal,"Masuk Kelas",$user->id,"Terlambat");
                }

            }
        }
        return response()->json(['status' => 'success']);
    }

    public function view($id)
    {
        $pelanggaran = Pelanggaran::wherePelanggaran_kode($id)->first();
        return response()->json(['status' => 'success', 'data' => $pelanggaran], 200);
    }

    public function edit($kode)
    {
        $pelanggaran = Pelanggaran::with(['siswa','user'])->wherePelanggaran_kode($kode)->first();
        return response()->json(['status' => 'success', 'data' => $pelanggaran], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'siswa_id' => 'required',
            'pelanggaran_tanggal' => 'required|date',
            'pelanggaran_jenis' => 'required|string|max:150'
        ]);
        $user = $request->user();
        $pelanggaran = Pelanggaran::wherePelanggaran_kode($request->pelanggaran_kode);
        $pelanggaran->update(['siswa_id' => $request->siswa_id['id'],
                              'mp_id' => $request->mp_id['id'],
                              'pelanggaran_tanggal' => $request->pelanggaran_tanggal,
                              'pelanggaran_keterangan' => $request->pelanggaran_keterangan,
                              'user_id' => $user->id,
                              'unit_id' => $user->unit_id,
                            ]);
        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $pelanggaran = Pelanggaran::find($id);
        $pelanggaran->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
