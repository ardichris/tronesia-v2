<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Imports\NilaiSiswasImport;
use Illuminate\Http\Request;
use App\NilaiSiswa;
use App\Siswa;
use App\Kelas;
use App\Kompetensi;
use App\Mapel;
use App\KelasAnggota;
use App\JamMengajar;
use App\Http\Resources\NilaiSiswaCollection;
use App\Exports\NilaiSiswaExport;
use Jenssegers\Date\Date;
use Maatwebsite\Excel\Facades\Excel;

function nilaiFinal($nilai, $remidi){
    if($nilai>75) {
        return $nilai;
    } else {
        if(is_null($remidi)) {
            return $nilai;
        } else {
            if(!is_null($remidi)) {
                if(max($nilai,$remidi)>75){
                    return 75;
                } else {
                    return max($nilai,$remidi);
                }
            }
        }
    }
}

function nilaiAkhir ($non_tes, $tes){
    if(!is_null($non_tes)&&!is_null($tes)){
        return round(($non_tes+$tes)/2,0);
    } else {
        if(is_null($non_tes)) return $tes;
        if(is_null($tes)) return $non_tes;
    }
}

class NilaiSiswaController extends Controller
{
    public function import(Request $request){
        $request->validate([
            'import_file' => 'required|file|mimes:xls,xlsx'
        ]);
        $user = $request->user();
        $path = $request->file('import_file');
        $nilai['periode'] = $user->periode;
        $nilai['user'] = $user->id;
        $nilai['unit'] = $user->unit_id;
        $nilai['jenjang'] = $request->jenjang;
        $nilai['mapel'] = $request->mapel;
        $nilai['guru'] = $request->guru;
        $nilai['jenis'] = $request->jenis;
        $data = Excel::import(new NilaiSiswasImport($nilai), $path);
        return response()->json(['message' => 'uploaded successfully'], 200);
    }
    public function downloadNilai(Request $request){
        $user = $request->user();
        $jammengajar = JamMengajar::whereId($request->filter)
                                  ->with(['kelas','mapel'])
                                  ->first();
        if($jammengajar->mapel->mapel_kode=='DC'){
            $jammengajar->mapel->mapel_kode = 'BIG';
            $jammengajar->mapel_id = 4;
        }
        $kompetensi = Kompetensi::where('kompetensi_mapel', $jammengajar->mapel->mapel_kode)
                                ->where('kompetensi_jenjang', $jammengajar->kelas->kelas_jenjang)
                                ->where('is_active',1)
                                ->get();
        $siswa = KelasAnggota::where('kelas_id', $jammengajar->kelas_id)
                             ->with(['siswa' => function ($query) {
                                 $query->select('id','s_nama', 's_nis','s_code');
                               }])
                             ->orderBy('absen')
                             ->get();
        $siswaID = $siswa->pluck('siswa_id');
        $nilai = NilaiSiswa::whereIn('siswa_id', $siswaID)
                           ->where('mapel_id', $jammengajar->mapel_id)
                           ->where('periode_id', $jammengajar->periode_id)
                           ->get();
        $namaTP = $kompetensi->pluck('kd_kode');
        $header = ['STS' => null,'SAS'=> null, 'TP'=>$namaTP];
        $kompID = $kompetensi->pluck('id');
        $periode = $jammengajar->periode_id;
        foreach($siswa as $rowsiswa){
            $rowsiswa['STS']=['ns_tes' => null, 'ns_remidi' => null];
            $rowsiswa['SAS']=['ns_tes' => null, 'ns_remidi' => null];
            foreach($kompetensi as $rowkomp){
                $nilaisiswa[$rowkomp->kd_kode]=['ns_tugas' => null, 'ns_tes' => null, 'ns_remidi' => null];
                foreach($nilai as $rownilai) {
                    if($rownilai->siswa_id==$rowsiswa->siswa->id&&$rownilai->kompetensi_id==$rowkomp->id){
                        $nilaisiswa[$rowkomp->kd_kode] = ['ns_tugas' => $rownilai->ns_tugas, 'ns_tes' => $rownilai->ns_tes, 'ns_remidi' => $rownilai->ns_remidi];
                    }
                    if($rownilai->siswa_id==$rowsiswa->siswa->id&&$rownilai->ns_jenis_nilai=='STS'){
                        $rowsiswa['STS'] = ['ns_tes' => $rownilai->ns_tes, 'ns_remidi' => $rownilai->ns_remidi];
                    }
                    if($rownilai->siswa_id==$rowsiswa->siswa->id&&$rownilai->ns_jenis_nilai=='SAS'){
                        $rowsiswa['SAS'] = ['ns_tes' => $rownilai->ns_tes, 'ns_remidi' => $rownilai->ns_remidi];
                    }
                }
            }
            $rowsiswa['nilai'] = $nilaisiswa;
        }
        $download = ['header' => $header, 'siswa' => $siswa];
        //return response()->json(['data' => $download],200);
        return Excel::download(new NilaiSiswaExport($download), 'nilaisiswa-'.$jammengajar->kelas->kelas_nama.'-'.$jammengajar->mapel->mapel_kode.'-'.date('y').date('m').date('d').'.xlsx');
    }

    public function nilaiki12(Request $request) {
        $user = $request->user();
        foreach($request->nilai as $row){
            if(!is_null($row[3])){
                NilaiSiswa::where('id',$row[3])->update(['ns_nilai' => $row[1], 'ns_sisipan' => $row[4]]);
            }
            if(!is_null($row[1]) && is_null($row[3])){
                NilaiSiswa::create(['siswa_id' => $row[2],
                                    'mapel_id' => $request->kelas['mapel_id'],
                                    'kompetensi_id' =>  $request->kd['id'],
                                    'ns_jenis_nilai' => $request->jenis['value'],
                                    'ns_nilai' => $row[1],
                                    'ns_sisipan' => $row[4],
                                    'periode_id' => $user->periode,
                                    'user_id' => $user->id,
                                    'unit_id' => $user->unit_id]);
            }
        }
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function index(Request $request) {
        $user = $request->user();

        if(is_null(request()->kelas)){
            $ampu = Kelas::where('kelas_wali',$user->id)->value('id');
        } else {
            $ampu = request()->kelas;
        }

        $kelas = KelasAnggota::where('kelas_id', $ampu)->orderBy('absen')->get();
        $anggota = $kelas->pluck('siswa_id');
        $nilaisiswa = Siswa::whereIn('id', $anggota)
                            ->select('s_nama','id')
                            ->get();
        foreach($nilaisiswa as $key=>$row){
            foreach($kelas as $keykelas=>$rowkelas){
                if($row->id==$rowkelas->siswa_id){
                    $row['absen'] = $rowkelas->absen;
                }
            }
        }

        //return response()->json(['status' => 'success', 'data' => $nilaisiswa], 200);
        $nilaisiswa = $nilaisiswa->toArray();
        $absen = array_column($nilaisiswa, 'absen');
        array_multisort($absen, SORT_ASC, $nilaisiswa);
        $counter=0;
        foreach($nilaisiswa as $key=>$row){
            $counter++;
            $nilai = NilaiSiswa::where('siswa_id',$row['id'])
                                ->where('mapel_id', request()->mapel)
                                ->where('ns_jenis_nilai', request()->jenis)
                                ->where('periode_id', $user->periode);
            if($request->lm != ''){
                $nilai = $nilai->where('lingkupmateri_id', request()->lm);
            } elseif($request->kd != ''){
                $nilai = $nilai->where('kompetensi_id', request()->kd);
            }
            $nilaisiswa[$key]['id_nilai'] = $nilai->value('id');
            $nilaisiswa[$key]['ns_tes'] = $nilai->value('ns_tes');
            $nilaisiswa[$key]['ns_remidi'] = $nilai->value('ns_remidi');
            if(in_array(request()->jenis,['SUM','KI3'])){
                $nilaisiswa[$key]['ns_tugas'] = $nilai->value('ns_tugas');
                $nilaisiswa[$key]['ns_perbaikan'] = $nilai->value('ns_perbaikan');
                $nilaisiswa[$key]['ns_nilai'] = '=IFERROR(ROUND(AVERAGE(I'.$counter.':J'.$counter.'),2),"")';
                $nilaisiswa[$key]['ns_avg_tes'] = '=IF(F'.$counter.'>75,F'.$counter.',IF(ISBLANK(G'.$counter.'),F'.$counter.',IF(ISNUMBER(G'.$counter.'),IF(MAX(F'.$counter.',G'.$counter.')>75,75,MAX(F'.$counter.',G'.$counter.')))))';
                $nilaisiswa[$key]['ns_avg_tugas'] = '=IF(D'.$counter.'>75,D'.$counter.',IF(ISBLANK(E'.$counter.'),D'.$counter.',IF(ISNUMBER(E'.$counter.'),IF(MAX(D'.$counter.',E'.$counter.')>75,75,MAX(D'.$counter.',E'.$counter.')))))';
            } elseif(in_array(request()->jenis,['PAS','PTS','SAS'])) {
                $nilaisiswa[$key]['ns_nilai'] = '=IF(D'.$counter.'>75,D'.$counter.',IF(ISBLANK(E'.$counter.'),D'.$counter.',IF(ISNUMBER(E'.$counter.'),IF(MAX(D'.$counter.',E'.$counter.')>75,75,MAX(D'.$counter.',E'.$counter.')))))';
            } elseif(request()->jenis=='KI4'){
                $nilaisiswa[$key]['ns_tugas'] = $nilai->value('ns_tugas');
                $nilaisiswa[$key]['ns_perbaikan'] = $nilai->value('ns_perbaikan');
                $nilaisiswa[$key]['ns_nilai'] = '=IFERROR(ROUND(AVERAGE(D'.$counter.':G'.$counter.'),2),"")';
            }
            //$nilaisiswa[$key]['sisipan'] = $nilai->value('ns_sisipan');
            //$row = array("nilai" => $nilai->ns_nilai);
        }


        return response()->json(['status' => 'success', 'data' => $nilaisiswa], 200);

    }


    public function store(Request $request){
        $user = $request->user();
        //if($user->unit_id==1) return response()->json(['status' => 'ditutup'],500);
        foreach($request->nilai as $row){

            $na_sumatif=null;
            $na_non_tes=null;
            $na_tes=null;

            if(!is_null($row[1]) && is_null($row[0]) && (!is_null($row[3])||!is_null($row[4])||!is_null($row[5])||!is_null($row[6]))){
                if($row[3]>100||$row[4]>100||$row[5]>100||$row[6]>100||$row[3]<0||$row[4]<0||$row[5]<0||$row[6]<0){
                    continue;
                }
                if($request->jenis['value']=='SUM'){
                    $na_non_tes = nilaiFinal($row[3],$row[4]);
                    $na_tes = nilaiFinal($row[5],$row[6]);
                    $na_sumatif = nilaiAkhir($na_non_tes,$na_tes);
                    NilaiSiswa::create(['siswa_id' => $row[1],
                                        'mapel_id' => $request->kelas['mapel_id'],
                                        'lingkupmateri_id' =>  $request->lm['id'],
                                        'ns_jenis_nilai' => $request->jenis['value'],
                                        'ns_tugas' => $row[3],
                                        'ns_perbaikan' => $row[4],
                                        'ns_tes' => $row[5],
                                        'ns_remidi' => $row[6],
                                        'ns_nilai' => $na_sumatif,
                                        //'ns_sisipan' => $row[4],
                                        'periode_id' => $user->periode,
                                        'user_id' => $user->id,
                                        'unit_id' => $user->unit_id]);
                } else {
                    if(!is_null($row[3])||!is_null($row[4])){
                        $na_sas = nilaiFinal($row[3],$row[4]);
                        NilaiSiswa::create(['siswa_id' => $row[1],
                                            'mapel_id' => $request->kelas['mapel_id'],
                                            'ns_jenis_nilai' => $request->jenis['value'],
                                            'ns_tes' => $row[3],
                                            'ns_remidi' => $row[4],
                                            'ns_nilai' => round($na_sas,0),
                                            //'ns_sisipan' => $row[4],
                                            'periode_id' => $user->periode,
                                            'user_id' => $user->id,
                                            'unit_id' => $user->unit_id]);
                    }
                }
            }

            if(!is_null($row[0])){
                $nilai = NilaiSiswa::where('id',$row[0]);
                if($row[3]>100||$row[4]>100||$row[5]>100||$row[3]<0||$row[4]<0||$row[5]<0){
                    continue;
                }
                if($request->jenis['value']=='SUM'){
                    $na_non_tes = nilaiFinal($row[3],$row[4]);
                    $na_tes = nilaiFinal($row[5],$row[6]);
                    $na_sumatif = nilaiAkhir($na_non_tes,$na_tes);
                    $nilai->update(['ns_tugas' => $row[3],
                                    'ns_perbaikan' => $row[4],
                                    'ns_tes' => $row[5],
                                    'ns_remidi' => $row[6],
                                    'ns_nilai' => $na_sumatif,
                                    'user_id' => $user->id,
                                ]);
                } else {
                    $na_sas = nilaiFinal($row[3],$row[4]);
                    $nilai->update(['ns_tes' => $row[3],
                                    'ns_remidi' => $row[4],
                                    'ns_nilai' => round($na_sas,0),
                                    'user_id' => $user->id]);
                }

            }

        }

        // $this->validate($request, [
        //          'siswa' => 'required'
        //      ]);
        // $user = $request->user();
        // foreach( $request->siswa as $rowsiswa){
        //     $count=0;
        //     if ($request->jenis != 'PTSPAS') {
        //         foreach( $rowsiswa['nilai'] as $rownilai){
        //             $nilai = NilaiSiswa::where('siswa_id',$rowsiswa['id'])
        //                                 ->where('mapel_id',$request->mapel['id'])
        //                                 ->where('kompetensi_id',$request->kompetensi[$count]['id'])
        //                                 ->where('ns_jenis_nilai',$request->jenis)
        //                                 ->where('periode_id',$user->periode)
        //                                 ;
        //             $cek = $nilai->count();
        //             if($cek == 0 && $rownilai['ns_nilai'] != ''){
        //             //return response()->json(['status' =>  $request->kompetensi[$count]['id']], 200);
        //                 NilaiSiswa::create(['siswa_id' => $rowsiswa['id'],
        //                                     'ns_nilai' => $rownilai['ns_nilai'],
        //                                     'mapel_id' => $request->mapel['id'],
        //                                     'kompetensi_id' => $request->kompetensi[$count]['id'],
        //                                     'ns_jenis_nilai' => $request->jenis,
        //                                     'periode_id' => $user->periode,
        //                                     'user_id' => $user->id,
        //                                     'unit_id' => $user->unit_id,]);

        //             } else {
        //                 $nilai->update(['ns_nilai' => $rownilai['ns_nilai']]);

        //             }
        //             $count = $count + 1;
        //         }
        //     } else {
        //         foreach ($rowsiswa['nilai'] as $rownilai){
        //             $nilai = NilaiSiswa::where('siswa_id',$rowsiswa['id'])
        //                                 ->where('mapel_id',$request->mapel['id'])
        //                                 ->where('ns_jenis_nilai',$request->kompetensi[$count])
        //                                 ->where('periode_id',$user->periode)
        //                                 ;
        //             $cek = $nilai->count();
        //             // $cekPTS = $nilai->where('ns_jenis_nilai','PTS')->count();
        //             // $cekPAS = $nilai->where('ns_jenis_nilai','PAS')->count();
        //             if ($cek == 0 && $rowsiswa['nilai'][0]['ns_nilai'] != '') {
        //                 NilaiSiswa::create(['siswa_id' => $rowsiswa['id'],
        //                                     'ns_nilai' => $rownilai['ns_nilai'],
        //                                     'mapel_id' => $request->mapel['id'],
        //                                     'ns_jenis_nilai' => $request->kompetensi[$count],
        //                                     'periode_id' => $user->periode,
        //                                     'user_id' => $user->id,
        //                                     'unit_id' => $user->unit_id,]);
        //             } else {
        //                 $nilai->update(['ns_nilai' => $rownilai['ns_nilai']]);
        //             }
        //             $count = $count + 1;
        //         }
        //     }

        // }
        return response()->json(['status' => 'success'], 200);
    }


}
