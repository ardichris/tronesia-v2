<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SiswaCollection;
use App\Siswa;
use App\Kelas;
use App\JamMengajar;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswasExport;

class SiswaController extends Controller
{
    public function exportSiswa(Request $request) {
        $siswa = Siswa::where('s_keterangan','AKTIF')->orderBy('s_nama')->get();
        foreach($siswa as $row) {
            $row['kelas'] = Kelas::where('id',$row->kelas_id)->value('kelas_nama');
        }
        //$siswa = collect($siswa)->sortBy('s_nama')->sortBy('kelas')->toArray();
        $siswa = $siswa->toArray();
        $nama = array_column($siswa, 's_nama');
        $kelas = array_column($siswa, 'kelas');
        array_multisort($kelas, SORT_ASC, $nama, SORT_ASC, $siswa);
        return Excel::download(new SiswasExport($siswa), 'siswa-'.date('y').date('m').date('d').'.xlsx');
    }
    
    public function index(Request $request)
    {
        $user = $request->user();
        $siswas = Siswa::with('kelas')->orderBy('s_nama', 'ASC')->where('unit_id',$user->unit_id);
       if (request()->kelas != '') {
            $siswas = $siswas->where('kelas_id', '=' , request()->kelas);
                                //->where('s_nama', 'LIKE', '%' . request()->q . '%');
        }
        if (request()->key == 'addAnggotaKelas') {
            $siswas = Siswa::orderBy('s_nama', 'ASC')
                           ->where('s_kelas', '!=' , request()->kelas);
        }
        if (request()->q != '') {
            $q = $request->q;
            $siswas = $siswas->where('s_nama', 'LIKE', '%' . request()->q . '%')
                            ->orwhereHas('kelas', function($query) use($q){
                                $query->where('kelas_nama','like','%'.$q.'%');
                            });
        }
        if (request()->s != '') {
            $siswas = $siswas->where('s_keterangan', 'LIKE', '%' . request()->s . '%');
        }
        if (request()->seragam != '') {
            $siswas = $siswas->whereIn('s_keterangan',['SISWA BARU','AKTIF']);
        }
        $gurubk = JamMengajar::where('mapel_id',22)->where('guru_id',$user->id)->pluck('kelas_id');
        if ($user->role != 0 && request()->kelas == ''){
            $siswas = $siswas->whereHas('kelas', function($query) use($user){
                                $query->where('kelas_wali', $user->id);
                                })
                            ->orwhereHas('kelas', function($query) use($user){
                                $query->where('k_mentor', $user->id);
                                })
                            ->orwhereIn('kelas_id', $gurubk);
        }
        $siswas = $siswas->paginate(40);
        return new SiswaCollection($siswas);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            's_kelamin' => 'required',
            's_nama' => 'required|string',
            's_tempatlahir' => 'required|string',
            's_tanggallahir' => 'required|date'
        ]);

        Siswa::create($request->all());
        return response()->json('sukses');
    }

    public function edit($id)
    {
        $siswa = Siswa::whereId($id)->with('kelas')->first();
        return response()->json(['status' => 'success', 'data' => $siswa], 200);
    }

    public function view($id)
    {
        $siswa = Siswa::whereSiswa_nis($id)->first();
        return response()->json(['status' => 'success', 'data' => $siswa], 200);
    }
    
    public function update(Request $request, $id)
    {

        if(is_null($request['s_nama'])){
            $siswa = Siswa::whereId($id)->first();
            $siswa->update(['s_kelas'=> '-']);
        } else {
            $this->validate($request, [
                //'s_kelamin' => 'required',
                's_nama' => 'required|string',
                //'s_kelas' => 'required|string',
                //'s_tempat_lahir' => 'required|string',
                //'s_tanggal_lahir' => 'required|date'
            ]);
    
            $siswa = Siswa::whereId($id)->first();
            $siswa->update($request->all());
        }
        return response()->json(['status' => 'success'], 200);
        
    }

    public function destroy($id)
    {
        $siswa = Siswa::find($id);
        $siswa->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
