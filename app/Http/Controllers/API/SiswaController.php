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
use App\Imports\SiswasImport;
use Jenssegers\Date\Date;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class SiswaController extends Controller
{
    public function exportQRCode(Request $request){
        $user = $request->user();
        $siswa = Siswa::where('s_keterangan', "AKTIF")
                        ->where('unit_id',$user->unit_id)
                        ->where('id','<',100)
                        ->select('s_nama','uuid','id','s_code')
                        ->get();

        foreach($siswa as $row) {
            QrCode::size(300)->generate($row->uuid, 'storage/qr/'.$row->uuid.'.svg');
            $img_url = 'storage/qr/'.$row->uuid.'.svg';
            \Session::put('qrImage', $img_url);
        }
        $pdf = PDF::loadView('qrcode', compact('siswa'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
            return $pdf->stream("QRCode.pdf");
    }

    public function import(Request $request)
    {
        $user = $request->user();
        $path = $request->file('import_file');
        $siswa['user'] = $user->id;
        $siswa['unit'] = $user->unit_id;
        $data = Excel::import(new SiswasImport($siswa), $path);

        return response()->json(['status' => 'success'], 200);
    }

    public function exportSiswa(Request $request) {
        $user = $request->user();
        Date::setLocale('id');
        $siswa = Siswa::where('s_keterangan','AKTIF')->where('unit_id',$user->unit_id)->orderBy('s_nama')->get();
        if($user->role!=0) {
            $listKelas = Kelas::where('kelas_wali',$user->id)->orWhere('k_mentor',$user->id)->pluck('id');
            $listSiswa = KelasAnggota::where('periode_id',$user->periode)->whereIn('kelas_id',$listKelas)->pluck('siswa_id');
            $siswa = $siswa->whereIn('id',$listSiswa);
        }
        foreach($siswa as $row) {
            $kelas = KelasAnggota::where('siswa_id',$row->id)->where('periode_id',$user->periode)->first();
            //return response()->json(['data' => $kelas['kelas_id']]);
            $row['kelas'] = $kelas?Kelas::where('id',$kelas['kelas_id'])->value('kelas_nama'):'-';
            $row['absen'] = $kelas?$kelas['absen']:'-';
            $row['s_tanggal_lahir'] = Date::parse($row['s_tanggal_lahir'])->format('j F Y');
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
        $siswas = Siswa::orderBy('s_nama', 'ASC')->where('unit_id',$user->unit_id)->select('id','uuid','s_nama','s_code','s_kelamin','s_keterangan');
        if (request()->s != '') {
            $siswas = $siswas->where('s_keterangan','LIKE', '%' . request()->s . '%');

        }
        if (request()->kelasnama != '') {
            $k = request()->kelasnama;
            $filterkelas = Kelas::where('kelas_nama',$k)->where('periode_id',$user->periode)->value('id');
            $anggotakelas = KelasAnggota::where('kelas_id',$filterkelas)->where('periode_id',$user->periode)->pluck('siswa_id');
            $siswas = $siswas->whereIn('id',$anggotakelas);
        }
        if (request()->kelas != '') {
           $anggota = KelasAnggota::where('periode_id',$user->periode)->where('kelas_id',request()->kelas)->pluck('siswa_id');
            $siswas = $siswas->whereIn('id',$anggota);
                                //where('kelas_id', '=' , request()->kelas);
                                //->where('s_nama', 'LIKE', '%' . request()->q . '%');
                                // where('kelas', function($query) use($user){
                                //     $query->where('id', request()->kelas);
                                //     });
        }
        if (request()->key == 'addAnggotaKelas') {
            $kelas = KelasAnggota::where('kelas_id',request()->kelas)->pluck('siswa_id');
            $siswas = Siswa::whereNotIn('id',$kelas)
                           ->where('s_keterangan','AKTIF')
                           ->where('unit_id', $user->unit_id)
                           ->orderBy('s_nama', 'ASC');
        }
        if (request()->q != '') {
            $q = $request->q;
            $siswas = $siswas->where(function ($query) use ($q) {
                                $query->where('s_nama', 'LIKE', '%' . request()->q . '%')
                                        ->orWhere('uuid', $q);
                            });
            // ->orwhere('uuid', 'LIKE', '%' . request()->q . '%')
                            // ->orwhereHas('kelas', function($query) use($q){
                            //     $query->where('kelas_nama','like','%'.$q.'%');
                            // })
                            //->select(['id','s_nama','s_nis','s_kelamin','s_keterangan','uuid']);
        }

        if (request()->seragam != '') {
            $siswas = $siswas->whereIn('s_keterangan',['SISWA BARU','AKTIF']);
        }
        //$gurubk = JamMengajar::where('mapel_id',22)->where('guru_id',$user->id)->where('periode_id',$user->periode)->pluck('kelas_id');
        if ($user->role != 0 && request()->kelas == '' && request()->kelasnama == ''){
            $listKelas = Kelas::where('kelas_wali',$user->id)->orWhere('k_mentor',$user->id)->pluck('id');
            $listSiswa = KelasAnggota::where('periode_id',$user->periode)->whereIn('kelas_id',$listKelas)->pluck('siswa_id');
            $siswas = $siswas->whereIn('id',$listSiswa);
            // $siswas = $siswas->whereHas('kelas', function($query) use($user){
            //                     $query->where('kelas_wali', $user->id);
            //                     })
            //                 ->orwhereHas('kelas', function($query) use($user){
            //                     $query->where('k_mentor', $user->id);
            //                     })
            //                 ->orwhereIn('kelas_id', $gurubk);
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
            's_code' => 'required',
        ]);

        Siswa::create([ 'uuid' => Uuid::Uuid4(),
                        's_nama' => $request->s_nama,
                        's_code' => $request->s_code,
                        's_nisn' => $request->s_nisn,
                        's_nik' => $request->s_nik,
                        's_nis' => $request->s_nis,
                        's_kelamin' => $request->s_kelamin,
                        's_tempat_lahir' => $request->s_tempat_lahir,
                        's_tanggal_lahir' => $request->s_tanggal_lahir,
                        's_status' => $request->s_status,
                        's_sekolahasal' => $request->s_sekolahasal,
                        's_notelp' => $request->s_notelp,
                        's_nohandphone' => $request->s_nohandphone,
                        's_sekolahasal' => $request->s_sekolahasal,
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
                        's_wali_nik' => $request->s_wali_nik,
                        's_wali_pendidikan' => $request->s_wali_pendidikan,
                        's_wali_penghasilan' => $request->s_wali_penghasilan,
                        's_wali_tanggal_lahir' => $request->s_wali_tanggal_lahir,
                        's_wali_alamat' => $request->s_wali_alamat,
                        's_wali_notelp' => $request->s_wali_notelp,
                        's_kk_nomor' => $request->s_kk_nomor,
                        's_kk_alamat' => $request->s_kk_alamat,
                        's_kk_rt' => $request->s_kk_rt,
                        's_kk_rw' => $request->s_kk_rw,
                        's_kk_kodepos' => $request->s_kk_kodepos,
                        's_kk_kelurahan' => $request->s_kk_kelurahan,
                        's_kk_kecamatan' => $request->s_kk_kecamatan,
                        's_kk_kota' => $request->s_kk_kota,
                        's_domisili_alamat' => $request->s_domisili_alamat,
                        's_domisili_rt' => $request->s_domisili_rt,
                        's_domisili_rw' => $request->s_domisili_rw,
                        's_domisili_kodepos' => $request->s_domisili_kodepos,
                        's_domisili_kelurahan' => $request->s_domisili_kelurahan,
                        's_domisili_kecamatan' => $request->s_domisili_kecamatan,
                        's_domisili_kota' => $request->s_domisili_kota,
                        's_ayah_perusahaan' => $request->s_ayah_perusahaan,
                        's_ayah_jabatan' => $request->s_ayah_jabatan,
                        's_ayah_tempat_lahir' => $request->s_ayah_tempat_lahir,
                        's_ayah_agama' => $request->s_ayah_agama,
                        's_ayah_warga_negara' => $request->s_ayah_warga_negara,
                        's_ibu_perusahaan' => $request->s_ibu_perusahaan,
                        's_ibu_jabatan' => $request->s_ibu_jabatan,
                        's_ibu_tempat_lahir' => $request->s_ibu_tempat_lahir,
                        's_ibu_agama' => $request->s_ibu_agama,
                        's_ibu_warga_negara' => $request->s_ibu_warga_negara,
                        's_ortu_alamat' => $request->s_ortu_alamat,
                        's_nama_panggilan' => $request->s_nama_panggilan,
                        's_golongan_darah' => $request->s_golongan_darah,
                        's_warga_negara' => $request->s_warga_negara,
                        's_saudara_kandung' => $request->s_saudara_kandung,
                        's_saudara_tiri' => $request->s_saudara_tiri,
                        's_saudara_angkat' => $request->s_saudara_angkat,
                        's_status_anak' => $request->s_status_anak,
                        's_bahasa' => $request->s_bahasa,
                        's_pengeluaran' => $request->s_pengeluaran,
                        's_keterangan' => 'AKTIF',
                        'unit_id' => $user->unit_id]);
        return response()->json('sukses');
    }

    public function edit($id)
    {
        $siswa = Siswa::whereUuid($id)->first();
        $siswa->kelas=$siswa->kelas_id?Kelas::where('id',$siswa->kelas_id)->value('kelas_nama'):"-";
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
                's_nis' => $request->s_nis,
                's_kelamin' => $request->s_kelamin,
                's_tempat_lahir' => $request->s_tempat_lahir,
                's_tanggal_lahir' => $request->s_tanggal_lahir,
                's_status' => $request->s_status,
                's_sekolahasal' => $request->s_sekolahasal,
                's_notelp' => $request->s_notelp,
                's_nohandphone' => $request->s_nohandphone,
                's_sekolahasal' => $request->s_sekolahasal,
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
                's_ayah_perusahaan' => $request->s_ayah_perusahaan,
                's_ayah_jabatan' => $request->s_ayah_jabatan,
                's_ayah_tempat_lahir' => $request->s_ayah_tempat_lahir,
                's_ayah_agama' => $request->s_ayah_agama,
                's_ayah_warga_negara' => $request->s_ayah_warga_negara,
                's_ibu_pendidikan' => $request->s_ibu_pendidikan,
                's_ibu_penghasilan' => $request->s_ibu_penghasilan,
                's_ibu_perusahaan' => $request->s_ibu_perusahaan,
                's_ibu_jabatan' => $request->s_ibu_jabatan,
                's_ibu_tempat_lahir' => $request->s_ibu_tempat_lahir,
                's_ibu_agama' => $request->s_ibu_agama,
                's_ibu_warga_negara' => $request->s_ibu_warga_negara,
                's_wali_nik' => $request->s_wali_nik,
                's_wali_pendidikan' => $request->s_wali_pendidikan,
                's_wali_penghasilan' => $request->s_wali_penghasilan,
                's_wali_tanggal_lahir' => $request->s_wali_tanggal_lahir,
                's_wali_alamat' => $request->s_wali_alamat,
                's_wali_notelp' => $request->s_wali_notelp,
                's_kk_nomor' => $request->s_kk_nomor,
                's_kk_alamat' => $request->s_kk_alamat,
                's_kk_rt' => $request->s_kk_rt,
                's_kk_rw' => $request->s_kk_rw,
                's_kk_kodepos' => $request->s_kk_kodepos,
                's_kk_kelurahan' => $request->s_kk_kelurahan,
                's_kk_kecamatan' => $request->s_kk_kecamatan,
                's_kk_kota' => $request->s_kk_kota,
                's_domisili_alamat' => $request->s_domisili_alamat,
                's_domisili_rt' => $request->s_domisili_rt,
                's_domisili_rw' => $request->s_domisili_rw,
                's_domisili_kodepos' => $request->s_domisili_kodepos,
                's_domisili_kelurahan' => $request->s_domisili_kelurahan,
                's_domisili_kecamatan' => $request->s_domisili_kecamatan,
                's_domisili_kota' => $request->s_domisili_kota,
                's_ortu_alamat' => $request->s_ortu_alamat,
                's_nama_panggilan' => $request->s_nama_panggilan,
                's_golongan_darah' => $request->s_golongan_darah,
                's_warga_negara' => $request->s_warga_negara,
                's_saudara_kandung' => $request->s_saudara_kandung,
                's_saudara_tiri' => $request->s_saudara_tiri,
                's_saudara_angkat' => $request->s_saudara_angkat,
                's_status_anak' => $request->s_status_anak,
                's_bahasa' => $request->s_bahasa,
                's_pengeluaran' => $request->s_pengeluaran
            ]);
        }
        return response()->json(['status' => 'success'], 200);

    }

    public function destroy($id)
    {
        $siswa = Siswa::whereUuid($id);
        $siswa->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
