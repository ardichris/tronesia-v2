<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\NilaiSiswa;
use App\Siswa;
use App\Kelas;
use App\Kompetensi;
use App\Mapel;
use App\KelasAnggota;
use App\Http\Resources\NilaiSiswaCollection;

class NilaiSiswaController extends Controller
{
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
            if($request->kd != ''){
                $nilai = $nilai->where('kompetensi_id', request()->kd);
            }
            $nilaisiswa[$key]['id_nilai'] = $nilai->value('id');
            $nilaisiswa[$key]['ns_tes'] = $nilai->value('ns_tes');
            $nilaisiswa[$key]['ns_remidi'] = $nilai->value('ns_remidi');
            if(request()->jenis=='NTT'){
                $nilaisiswa[$key]['ns_tugas'] = $nilai->value('ns_tugas');
                $nilaisiswa[$key]['ns_nilai'] = '=IFERROR(ROUND(IF(ISBLANK(F'.$counter.'),AVERAGE(D'.$counter.':E'.$counter.'),IF(F'.$counter.'>75,AVERAGE(D'.$counter.',75),AVERAGE(D'.$counter.',MAX(E'.$counter.':F'.$counter.')))),0),"")';
            } else {
                $nilaisiswa[$key]['ns_nilai'] = '=IF(ISBLANK(D'.$counter.'),"",ROUND(IF(D'.$counter.'>75,D'.$counter.',IF(MAX(D'.$counter.':E'.$counter.')>75,75,MAX(D'.$counter.':E'.$counter.'))),0))';
            }
            //$nilaisiswa[$key]['sisipan'] = $nilai->value('ns_sisipan');
            //$row = array("nilai" => $nilai->ns_nilai);
        }


        return response()->json(['status' => 'success', 'data' => $nilaisiswa], 200);

    }


    public function store(Request $request){
        $user = $request->user();
        foreach($request->nilai as $row){

            $ns_final=null;

            if(!is_null($row[1]) && is_null($row[0]) && (!is_null($row[3])||!is_null($row[4]))){
                if($row[3]>100||$row[4]>100||$row[5]>100||$row[3]<0||$row[4]<0||$row[5]<0){
                    continue;
                }
                if($request->jenis['value']=='NTT'){
                    $ns_remidi_test=null;
                    if(!is_null($row[4])&&!is_null($row[5])){
                        $ns_remidi_test = max($row[4],$row[5]);
                        if($ns_remidi_test>75) $ns_remidi_test=75;
                    }
                    if(!is_null($row[3])||!is_null($row[4])){
                        if(!is_null($row[3])&&!is_null($row[4])){
                            $array_nilai= [$row[3],$row[4]];
                            $ns_final = round(array_sum($array_nilai)/count($array_nilai));
                        } else {
                            $ns_final = max($row[3],$row[4]);
                        }
                        if(!is_null($ns_remidi_test)){
                            $ns_final = round(($row[3]+$ns_remidi_test)/2,0);
                        }
                    }

                    NilaiSiswa::create(['siswa_id' => $row[1],
                                        'mapel_id' => $request->kelas['mapel_id'],
                                        'kompetensi_id' =>  $request->kd['id'],
                                        'ns_jenis_nilai' => $request->jenis['value'],
                                        'ns_tugas' => $row[3],
                                        'ns_tes' => $row[4],
                                        'ns_remidi' => $row[4]<75?$row[5]:null,
                                        'ns_nilai' => $ns_final?round($ns_final,0):null,
                                        //'ns_sisipan' => $row[4],
                                        'periode_id' => $user->periode,
                                        'user_id' => $user->id,
                                        'unit_id' => $user->unit_id]);
                } else {
                    $ns_remidi_test=null;
                    if($row[3]>100||$row[4]>100||$row[3]<0||$row[4]<0){
                        continue;
                    }
                    if(!is_null($row[3])&&!is_null($row[4])){
                        $ns_remidi_test = max($row[3],$row[4]);
                        if($ns_remidi_test>75&&$row[3]<75) $ns_remidi_test=75;
                    }
                    NilaiSiswa::create(['siswa_id' => $row[1],
                                        'mapel_id' => $request->kelas['mapel_id'],
                                        'ns_jenis_nilai' => $request->jenis['value'],
                                        'ns_tes' => $row[3],
                                        'ns_remidi' => $row[3]<75?$row[4]:null,
                                        'ns_nilai' => $ns_remidi_test?round($ns_remidi_test,0):$row[3],
                                        //'ns_sisipan' => $row[4],
                                        'periode_id' => $user->periode,
                                        'user_id' => $user->id,
                                        'unit_id' => $user->unit_id]);
                }
            }

            if(!is_null($row[0])){
                $nilai = NilaiSiswa::where('id',$row[0]);
                if($row[3]>100||$row[4]>100||$row[5]>100||$row[3]<0||$row[4]<0||$row[5]<0){
                    continue;
                }
                if($request->jenis['value']=='NTT'){
                    $ns_remidi_test=null;
                    if(!is_null($row[4])&&!is_null($row[5])){
                        $ns_remidi_test = max($row[4],$row[5]);
                        if($ns_remidi_test>75) $ns_remidi_test=75;
                    }
                    if(!is_null($row[3])||!is_null($row[4])){
                        if(!is_null($row[3])&&!is_null($row[4])){
                            $array_nilai= [$row[3],$row[4]];
                            $ns_final = round(array_sum($array_nilai)/count($array_nilai));
                        } else {
                            $ns_final = max($row[3],$row[4]);
                        }
                        if(!is_null($ns_remidi_test)){
                            $ns_final = round(($row[3]+$ns_remidi_test)/2,0);
                        }
                    }
                    $nilai->update(['ns_tugas' => $row[3],
                                    'ns_tes' => $row[4],
                                    'ns_remidi' => $row[4]<75?$row[5]:null,
                                    'ns_nilai' => $ns_final?round($ns_final,0):null
                                ]);
                } else {
                    $ns_remidi_test=null;
                    if($row[3]>100||$row[4]>100||$row[3]<0||$row[4]<0){
                        continue;
                    }
                    if(!is_null($row[3])&&!is_null($row[4])){
                        $ns_remidi_test = max($row[3],$row[4]);
                        if($ns_remidi_test>75&&$row[3]<75) $ns_remidi_test=75;
                    }
                    $nilai->update(['ns_tes' => $row[3],
                                    'ns_remidi' => $row[3]<75?$row[4]:null,
                                    'ns_nilai' => $ns_remidi_test?round($ns_remidi_test,0):$row[3]]);
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
