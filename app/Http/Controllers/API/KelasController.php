<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\KelasCollection;
use App\Kelas;
use App\User;
use App\Siswa;
use App\KelasAnggota;

class KelasController extends Controller
{
    public function getAnggota($id)
    {
        $anggota = Siswa::whereKelas_id($id)->orderBy('s_nama', 'ASC');
        return new KelasCollection($anggota->paginate(40));
    }

    public function tambahAnggota(Request $request)
    {
        if (request()->key == 'tambahAnggotaKelas') {
            $siswa = Siswa::whereId(request()->siswa)->first();
            $siswa->update(['kelas_id'=> 11]);
        }
        return response()->json(['status' => 'success'], 200);
    }

    public function index(Request $request) {
        $user = $request->user();
        $kelas = Kelas::with(['user','mentor'])->orderBy('kelas_nama', 'ASC')->where('periode_id', $user->periode)->where('unit_id', $user->unit_id);
        if (request()->q != '') {
            $kelas = $kelas->where('kelas_nama', 'LIKE', '%' . request()->q . '%');
        }
        if (request()->key == 'nama') {
            $kelas = $kelas->pluck('kelas_nama');
        } else {
            $kelas = $kelas->paginate(10);
        }
        return new KelasCollection($kelas);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kelas_nama' => 'required|string',
            'kelas_jenjang' => 'required'
        ]);
        $user = $request->user();
        Kelas::create([
            'kelas_nama' => $request->kelas_nama,
            'kelas_jenjang' => $request->kelas_jenjang,
            'kelas_wali' => $request->kelas_wali?$request->kelas_wali['id']:null,
            'k_mentor' => $request->k_mentor?$request->k_mentor['id']:null,
            'unit_id' => $user->unit_id,
            'periode_id' => $user->periode,
        ]);
        return response()->json(['status' => 'success'], 200);
    }

    public function edit(Request $request, $id)
    {
        $user = $request->user();
        $kelas = Kelas::with(['user','mentor'])->whereId($id)->first();
        $anggota = KelasAnggota::where('kelas_id',$id)
                                ->where('periode_id',$user->periode)
                                ->with(array('siswa' => function($query) {
                                    $query->select('id','s_nama');
                                }))
                                //->where('periode_id',$user->periode)
                                ->orderBy('absen')
                                ->get();


        $kelas['anggota'] = $anggota;
        // $kelas['anggota'] = KelasAnggota::where('kelas_id',$id)
        //                                 ->with('siswa')
        //                                 ->get()
        //                                 ->sortBy(function($urut){
        //                                     return $urut->siswa->s_nama;
        //                                 });

        return response()->json(['status' => 'success', 'data' => $kelas], 200);
    }

    public function view($id)
    {
        $kelas = Kelas::whereKelas_nama($id)->first();
        return response()->json(['status' => 'success', 'data' => $kelas], 200);
    }

    public function update(Request $request, $id)
    {


        $this->validate($request, [
            'kelas_jenjang' => 'required|string',
        ]);
        $user = $request->user();
        $kelas = Kelas::whereId($id)->first();
        $jenisKelas = $request->k_jenis;
        $kelas->update([
                'kelas_jenjang' => $request->kelas_jenjang,
                'kelas_wali' => $request->kelas_wali?$request->kelas_wali['id']:null,
                'k_mentor' => $request->k_mentor?$request->k_mentor['id']:null
        ]);
        foreach($request->anggota as $key=>$row){
            if(!is_null($row['siswa_id'])){
                KelasAnggota::whereId($row['id'])
                            ->where('periode_id',$user->periode)
                            ->update(['absen' => $row['absen']]);
            } else {
                $cek = KelasAnggota::with('kelas')
                                   ->where('siswa_id',$row['siswa']['id'])
                                   ->where('periode_id',$user->periode)
                                   ->whereHas('kelas', function($query) use($jenisKelas){
                                        $query->where('k_jenis',$jenisKelas);
                                   });
                $cekcount = $cek->count();
                if($cekcount>0){
                    $cek->update(['kelas_id' => $id,
                                'absen' => $row['absen']]);
                } else {
                    KelasAnggota::create(['kelas_id' => $id,
                                        'siswa_id'=> $row['siswa']['id'],
                                        'absen' => $row['absen'],
                                        'periode_id' => $user->periode]);
                }
            }
        }

        $anggota = KelasAnggota::where('kelas_id', $id)->get();
        foreach($anggota as $rowanggota){
            $match = true;
            foreach($request->anggota as $key=>$row){
                if($rowanggota['siswa_id']==$row['siswa']['id']){
                    $match = false;
                }
            }
            if($match){
                KelasAnggota::find($rowanggota['id'])->delete();
            }

        }

        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $kelas = Kelas::find($id);
        $kelas->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
