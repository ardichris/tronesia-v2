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
use App\KelasAnggota;
use Ramsey\Uuid\Uuid;

class SiswaController extends Controller
{
    public function exportSiswa(Request $request) {
        $user = $request->user();
        $siswa = Siswa::where('s_keterangan','AKTIF')->orderBy('s_nama')->get();
        foreach($siswa as $row) {
            $kelas = KelasAnggota::where('siswa_id',$row->id)->where('periode_id',$user->periode)->first();
            //return response()->json(['data' => $kelas['kelas_id']]);
            $row['kelas'] = $kelas?Kelas::where('id',$kelas['kelas_id'])->value('kelas_nama'):'-';
            $row['absen'] = $kelas?$kelas['absen']:'-';
        }
        //$siswa = collect($siswa)->sortBy('s_nama')->sortBy('kelas')->toArray();
        $siswa = $siswa->toArray();
        $nama = array_column($siswa, 's_nama');
        $kelas = array_column($siswa, 'kelas');
        $absen = array_column($siswa, 'absen');
        array_multisort($kelas, SORT_ASC, $absen, SORT_ASC, $nama, SORT_ASC, $siswa);
        return Excel::download(new SiswasExport($siswa), 'siswa-'.date('y').date('m').date('d').'.xlsx');
    }
    
    public function index(Request $request)
    {
        $user = $request->user();
        $siswas = Siswa::orderBy('s_nama', 'ASC')->where('unit_id',$user->unit_id);
       if (request()->kelas != '') {
            $siswas = $siswas->where('kelas_id', '=' , request()->kelas);
                                //->where('s_nama', 'LIKE', '%' . request()->q . '%');
        }
        if (request()->key == 'addAnggotaKelas') {
            $kelas = KelasAnggota::where('kelas_id',request()->kelas)->pluck('siswa_id');
            $siswas = Siswa::whereNotIn('id',$kelas)
                           ->where('s_keterangan','AKTIF')
                           ->orderBy('s_nama', 'ASC');
        }
        if (request()->q != '') {
            $q = $request->q;
            $siswas = $siswas->where('s_nama', 'LIKE', '%' . request()->q . '%')
                            ->orwhereHas('kelas', function($query) use($q){
                                $query->where('kelas_nama','like','%'.$q.'%');
                            })
                            ->select(['id','s_nama','s_nis','s_kelamin','s_keterangan','uuid']);
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
        foreach($siswas as $row){
            $kelas = KelasAnggota::where('siswa_id',$row['id'])
                                    ->where('periode_id', $user->periode)
                                    ->with('kelas')->first();
            $row['kelas'] = $kelas?$kelas['kelas']['kelas_nama']:'-';
            $row['absen'] = $kelas?$kelas['absen']:'-';
        }

        return new SiswaCollection($siswas);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $this->validate($request, [
            's_kelamin' => 'required',
            's_nama' => 'required|string',
            's_code' => 'required'
        ]);

        Siswa::create([ 'uuid' => Uuid::Uuid4(),
                        's_nama' => $request->s_nama,
                        's_code' => $request->s_code,
                        's_kelamin' => $request->s_kelamin,
                        'unit_id' => $user->unit_id,
                        's_keterangan' => 'AKTIF']);
        return response()->json('sukses');
    }

    public function edit($id)
    {
        $siswa = Siswa::whereUuid($id)->with('kelas')->first();
        return response()->json(['status' => 'success', 'data' => $siswa], 200);
    }

    public function view($id)
    {
        $siswa = Siswa::whereUuid($id)->first();
        return response()->json(['status' => 'success', 'data' => $siswa], 200);
    }
    
    public function update(Request $request, $id)
    {
        if(is_null($request['s_nama'])){
            $siswa = Siswa::whereUuid($id)->first();
            $siswa->update(['s_kelas'=> '-']);
        } else {
            $this->validate($request, [
                //'s_kelamin' => 'required',
                's_nama' => 'required|string',
                //'s_kelas' => 'required|string',
                //'s_tempat_lahir' => 'required|string',
                //'s_tanggal_lahir' => 'required|date'
            ]);
    
            $siswa = Siswa::whereUuid($id)->first();
            $siswa->update([
                's_nama' => $request->s_nama,
                's_nisn' => $request->s_nisn,
                's_nik' => $request->s_nik,
                's_kelamin' => $request->s_kelamin,
                's_tempat_lahir' => $request->s_tempat_lahir,
                's_tanggal_lahir' => $request->s_tanggal_lahir,
                's_status' => $request->s_status,
                's_sekolahasal' => $request->s_sekolahasal,
                's_notelp' => $request->s_notelp,
                's_nohandphone' => $request->s_nohandphone,
                's_poin' => $request->s_poin,
                's_anak_ke' => $request->s_anak_ke,
                's_ibu_nama' => $request->s_ibu_nama,
                's_ibu_tanggal_lahir' => $request->s_ibu_tanggal_lahir,
                's_ibu_nik' => $request->s_ibu_nik,
                's_ibu_pekerjaan' => $request->s_ibu_pekerjaan,
                's_ayah_nama' => $request->s_ayah_nama,
                's_ayah_tanggal_lahir' => $request->s_ayah_tanggal_lahir,
                's_ayah_nik' => $request->s_ayah_nik,
                's_ayah_pekerjaan' => $request->s_ayah_pekerjaan,
                's_kk_alamat' => $request->s_alamat,
                's_wali_nama' => $request->s_wali_nama,
                's_wali_pekerjaan' => $request->s_wali_pekerjaan,
                's_agama' => $request->s_agama,
                's_jarak_rumah' => $request->s_jarak_rumah,
                's_jarak_rumah_km' => $request->s_jarak_rumah_km,
                's_jenis_tinggal' => $request->s_jenis_tinggal,
                's_transportasi' => $request->s_transportasi,
                's_email' => $request->s_email,
                's_akta_nama' => $request->s_akta_nama,
                's_akta_nomor' => $request->s_akta_nomor,
                's_akta_tempat_lahir' => $request->s_akta_tempat_lahir,
                's_akta_tanggal_lahir' => $request->s_akta_tanggal_lahir,
                's_akta_nama_ayah' => $request->s_akta_nama_ayah,
                's_akta_nama_ibu' => $request->s_akta_nama_ibu,
                's_ayah_pendidikan' => $request->s_ayah_pendidikan,
                's_ayah_penghasilan' => $request->s_ayah_penghasilan,
                's_ibu_pendidikan' => $request->s_ibu_pendidikan,
                's_ibu_penghasilan' => $request->s_ibu_penghasilan,
                's_kk_nomor' => $request->s_kk_nomor,
                's_wali_nik' => $request->s_wali_nik,
                's_wali_pendidikan' => $request->s_wali_pendidikan,
                's_wali_penghasilan' => $request->s_wali_penghasilan,
                's_wali_tanggal_lahir' => $request->s_wali_tanggal_lahir,
                's_kk_rt' => $request->s_kk_rt,
                's_kk_rw' => $request->s_kk_rw,
                's_kk_kodepos' => $request->s_kk_kodepos,
                's_kk_kelurahan' => $request->s_kk_kelurahan,
                's_kk_kecamatan' => $request->s_kk_kecamatan,
                's_kk_kota' => $request->s_kk_kota,
                's_domisili_rt' => $request->s_domisili_rt,
                's_domisili_rw' => $request->s_domisili_rw,
                's_domisili_kodepos' => $request->s_domisili_kodepos,
                's_domisili_kelurahan' => $request->s_domisili_kelurahan,
                's_domisili_kecamatan' => $request->s_domisili_kecamatan,
                's_domisili_kota' => $request->s_domisili_kota,
                's_ayah_perusahaan' => $request->s_ayah_perusahaan,
                's_ayah_jabatan' => $request->s_ayah_jabatan,
                's_ibu_perusahaan' => $request->s_ibu_perusahaan,
                's_ibu_jabatan' => $request->s_ibu_jabatan
            ]);
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
