<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Absensi;
use App\Kelas;
use App\KelasAnggota;
use App\Http\Resources\AbsensiCollection;


class LaporanController extends Controller
{
    public function absensi(Request $request){
        $user = $request->user();
        $absen = Absensi::with(['siswa' => function ($query) {
                                $query->select('id', 's_nama', 'uuid');
                            }])
                        ->whereBetween('absensi_tanggal',[$request->start,$request->end])
                        ->where('ab_status', 'Approved')
                        ->get();
        if($request->siswa!=''){
            $absen = $absen->where('siswa.uuid', $request->siswa);
        }
        $total = array('kelas7_total'=> 0,
                        'kelas7_sakit' => 0,
                        'kelas7_ijin' => 0,
                        'kelas7_alpha' => 0,
                        'kelas8_total'=> 0,
                        'kelas8_sakit' => 0,
                        'kelas8_ijin' => 0,
                        'kelas8_alpha' => 0,
                        'kelas9_total'=> 0,
                        'kelas9_sakit' => 0,
                        'kelas9_ijin' => 0,
                        'kelas9_alpha' => 0,
                    );

        foreach ($absen as $row){
            $kelas = KelasAnggota::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->first();
            $kelasdetail = Kelas::where('id',$kelas['kelas_id'])->first();
            if($kelasdetail['kelas_jenjang']==7){
                $total['kelas7_total']++;
                if($row->absensi_jenis=="Sakit")
                    $total['kelas7_sakit']++;
                if($row->absensi_jenis=="Ijin")
                    $total['kelas7_ijin']++;
                if($row->absensi_jenis=="Alpha")
                    $total['kelas7_alpha']++;
            }
            elseif($kelasdetail['kelas_jenjang']==8){
                $total['kelas8_total']++;
                if($row->absensi_jenis=="Sakit")
                    $total['kelas8_sakit']++;
                if($row->absensi_jenis=="Ijin")
                    $total['kelas8_ijin']++;
                if($row->absensi_jenis=="Alpha")
                    $total['kelas8_alpha']++;
            }
            elseif($kelasdetail['kelas_jenjang']==9){
                $total['kelas9_total']++;
                if($row->absensi_jenis=="Sakit")
                    $total['kelas9_sakit']++;
                if($row->absensi_jenis=="Ijin")
                    $total['kelas9_ijin']++;
                if($row->absensi_jenis=="Alpha")
                    $total['kelas9_alpha']++;
            }
            $row['kelas'] = $kelas?$kelasdetail['kelas_nama']:'-';
            $row['absen'] = $kelas?$kelas['absen']:'-';
        }
        //return new AbsensiCollection($absen);
        return response()->json(['status' => 'success', 'data' => $absen, 'total' => $total], 200);

    }
}
