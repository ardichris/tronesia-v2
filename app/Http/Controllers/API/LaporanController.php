<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Absensi;
use App\Kelas;
use App\KelasAnggota;
use App\Siswa;
use App\Http\Resources\AbsensiCollection;


class LaporanController extends Controller
{
    public function absensi(Request $request){

        $this->validate($request, [
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $user = $request->user();
        $absen = Absensi::with(['siswa' => function ($query) {
                                $query->select('id', 's_nama', 'uuid');
                            }])
                        ->whereBetween('absensi_tanggal',[$request->start,$request->end])
                        ->where('ab_status', 'Approved');

        if($request->siswa!=''){
            $q = $request->siswa;
            $absen = $absen->where(function ($query) use ($q) {
                            $query->whereHas('siswa', function($query) use($q){
                                        $query->where('uuid','like','%'.$q.'%');
                                    });
                        });
        }
        if($request->kelas!=''){
            $q = $request->kelas;
            $anggota = KelasAnggota::with('kelas')
                                    ->where(function ($query) use ($q) {
                                        $query->whereHas('kelas', function($query) use($q){
                                                    $query->where('kelas_nama',$q);
                                                });
                                        })
                                    ->where('periode_id',$user->periode)
                                    ->pluck('siswa_id');
            $absen = $absen->whereIn('siswa_id',$anggota);
        }

        $absen = $absen->get();
        $total = array('kelas7_total'=> 0,
                        'kelas7_sakit' => 0,
                        'kelas7_ijin' => 0,
                        'kelas7_alpha' => 0,
                        'kelas7_covid' => 0,
                        'kelas8_total'=> 0,
                        'kelas8_sakit' => 0,
                        'kelas8_ijin' => 0,
                        'kelas8_alpha' => 0,
                        'kelas8_covid' => 0,
                        'kelas9_total'=> 0,
                        'kelas9_sakit' => 0,
                        'kelas9_ijin' => 0,
                        'kelas9_alpha' => 0,
                        'kelas9_covid' => 0,
                    );
        $rekap = [];
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
                if($row->absensi_jenis=="Covid")
                    $total['kelas7_covid']++;
            }
            elseif($kelasdetail['kelas_jenjang']==8){
                $total['kelas8_total']++;
                if($row->absensi_jenis=="Sakit")
                    $total['kelas8_sakit']++;
                if($row->absensi_jenis=="Ijin")
                    $total['kelas8_ijin']++;
                if($row->absensi_jenis=="Alpha")
                    $total['kelas8_alpha']++;
                if($row->absensi_jenis=="Covid")
                    $total['kelas8_covid']++;
            }
            elseif($kelasdetail['kelas_jenjang']==9){
                $total['kelas9_total']++;
                if($row->absensi_jenis=="Sakit")
                    $total['kelas9_sakit']++;
                if($row->absensi_jenis=="Ijin")
                    $total['kelas9_ijin']++;
                if($row->absensi_jenis=="Alpha")
                    $total['kelas9_alpha']++;
                if($row->absensi_jenis=="Covid")
                    $total['kelas9_covid']++;
            }
            $row['kelas'] = $kelas?$kelasdetail['kelas_nama']:'-';
            $row['absen'] = $kelas?$kelas['absen']:'-';
            if(!collect($rekap)->contains('id',$row->siswa->id)){
                array_push($rekap, (object)[
                    'id' => $row->siswa->id,
                    'Nama' => $row->siswa->s_nama,
                    'Kelas' => $row->kelas,
                    'Absen' => $kelas['absen'],
                    'Sakit' => 0,
                    'Ijin' => 0,
                    'Alpha' => 0,
                    'Covid' => 0
                ]);
            }

            foreach($rekap as $rowrekap){
                if($rowrekap->id==$row->siswa_id){
                    $rowrekap->{$row->absensi_jenis}++;
                }

            }
        }
        return response()->json(['status' => 'success', 'data' => $absen, 'total' => $total, 'rekap' => $rekap], 200);

    }
}
