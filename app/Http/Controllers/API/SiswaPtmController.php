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
    public function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
      
        if ($unit == "K") {
          return (round($miles * 1.609344, 2));
        } else if ($unit == "N") {
            return ($miles * 0.8684);
          } else {
              return $miles;
            }
      }

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
                                ->where('unit_id',$user->unit_id)
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
            $anggotakelas = KelasAnggota::where('kelas_id',$filterkelas)->where('periode_id',$user->periode)->pluck('siswa_id');
            $siswaptms = $siswaptms->whereIn('siswa_id',$anggotakelas);
        }
        
        $siswaptms=$siswaptms->paginate(40);
        foreach ($siswaptms as $row){
            $kelas = KelasAnggota::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->first();
            $row['kelas'] = $kelas?Kelas::where('id',$kelas['kelas_id'])->value('kelas_nama'):'-';
            $row['absen'] = $kelas?$kelas['absen']:'-';
            $absen = AbsensiPtm::where('siswa_id',$row->siswa_id)->where('aptm_tanggal', Carbon::today())->first();
            $row['status'] = $absen?$absen->aptm_status:'Daring';
            $row['absensi'] = $absen?$absen:'-';
            if($absen){
                $row['distance'] = $absen->aptm_lat?$this->distance($absen->aptm_lat, $absen->aptm_lng, -7.282205, 112.684897, "K"):null;
            } else {
                $row['distance'] = null;
            }

        }
        

        return new SiswaPtmCollection($siswaptms);
    }

    public function store(Request $request){
        $user = $request->user();
        foreach($request->ptm as $row){
            $cek = SiswaPtm::where('siswa_id',$row['siswa']['id'])->where('periode_id',$user->periode)->first();
            if(is_null($cek)){
                $ptm = SiswaPtm::create(['siswa_id' => $row['siswa']['id'],
                                         'periode_id' => $user->periode,
                                         'unit_id' => $user->unit_id,
                                         'user_id' => $user->id]);
                
            }
        }
        return response()->json('sukses');

    }
}
