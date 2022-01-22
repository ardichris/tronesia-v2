<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SiswaPtmCollection;
use App\SiswaPtm;
use App\AbsensiPtm;
use App\Kelas;
use App\KelasAnggota;
use Carbon\Carbon;

class SiswaPtmController extends Controller
{
    public function dijemput(Request $request, $kode){
        $absensi = AbsensiPtm::where('siswa_id', $kode)->where('aptm_tanggal', Carbon::today());
        $absensi->update(['aptm_status' => 'Dijemput']);
        return response()->json('sukses');

    }
    public function suhupulang(Request $request, $kode){
        $absensi = AbsensiPtm::where('siswa_id', $kode)->where('aptm_tanggal', Carbon::today());
        $absensi->update(['aptm_suhu_pulang' => $request->suhu]);
        return response()->json('sukses');

    }
    
    public function absenmasuk(Request $request){
        $user = $request->user();
        $absensi = AbsensiPtm::create([
                    'siswa_id' => $request->siswaid,
                    'aptm_tanggal' => Carbon::today(),
                    'aptm_suhu_datang' => $request->suhu,
                    'aptm_status' => 'Masuk',
                    'periode_id' => $user->periode,
                    'unit_id' => $user->unit_id,
                    'user_id' => $user->id
                    ]);
        
        return response()->json('sukses');
        
    }
    
    public function index(Request $request) {
        $user = $request->user();
        $siswaptms = SiswaPtm::with(['siswa' => function ($query) {
                                    $query->select('id', 's_nama', 'kelas_id');
                                }])
                                ->orderBy('id', 'ASC');
        if (request()->q != '') {
            $q = request()->q;
            $siswaptms = $siswaptms->where(function ($query) use ($q) {
                                    $query->whereHas('siswa', function($query) use($q){
                                                $query->where('s_nama','like','%'.$q.'%');
                                            });
                            });
        }
        if (request()->kelas != '') {
            $k = request()->kelas;
            $filterkelas = Kelas::where('kelas_nama',$k)->value('id');
            $anggotakelas = KelasAnggota::where('kelas_id',$filterkelas)->pluck('siswa_id');
            $siswaptms = $siswaptms->whereIn('id',$anggotakelas);
        }
        
        $siswaptms=$siswaptms->paginate(10);
        foreach ($siswaptms as $row){
            $kelas = KelasAnggota::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->first();
            $row['kelas'] = $kelas?Kelas::where('id',$kelas['kelas_id'])->value('kelas_nama'):'-';
            $row['absen'] = $kelas?$kelas['absen']:'-';
            $absen = AbsensiPtm::where('siswa_id',$row->siswa_id)->where('aptm_tanggal', Carbon::today())->first();
            $row['status'] = $absen?$absen->aptm_status:'Daring';
            $row['absensi'] = $absen?$absen:'-';

        }
        

        return new SiswaPtmCollection($siswaptms);
    }
}
