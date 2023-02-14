<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use PDF;

use App\KurmerReport;
use App\KelasAnggota;
use App\User;
use App\Mapel;
use App\Periode;
use App\LingkupMateri;
use App\NilaiSiswa;
use App\KmrDetail;

function predikatEkstra($huruf){
    if($huruf == 'A') return 'Sangat Baik';
    if($huruf == 'B') return 'Baik';
    if($huruf == 'C') return 'Cukup';
    if($huruf == 'D') return 'Kurang';
}

function getMapelPilihan($siswa, $periode){
    $kelaspilihan = KelasAnggota::where('siswa_id', $siswa)
                                ->where('periode_id', $periode)
                                ->with('kelas')
                                ->whereHas('kelas', function($query) {
                                        $query->where('k_jenis','PILIHAN');
                                    })
                                ->first();
    $mapelpilihan = $kelaspilihan->kelas->k_mapel;
    return $mapelpilihan;
}

function lcfirst($str)
    {
        $str = is_string($str) ? $str : '';
        if(mb_strlen($str) > 0) {
            $str[0] = mb_strtolower($str[0]);
        }
        return $str;
    }

function detail_report($id, $periode, $jenjang, $siswa){
    $mapel = ['PAK', 'PKN', 'BIN', 'BIG', 'MAT', 'IPA', 'IPS', 'ORG', 'TIK', 'JWA', 'MAN', 'PIL'];
    $dbmapel = Mapel::get();
    $semester = substr(Periode::whereId($periode)->value('p_semester'),0,1);
    $lingkupmateri = LingkupMateri::where('lm_semester', $semester)
                                    ->where('lm_grade', $jenjang)
                                    ->get();

    foreach($mapel as $row){
        $nilai = null;
        $lm_id = null;
        $selectMapel = null;
        $mapel_id = null;
        $max = null;
        $min = null;
        if($row == 'PIL'){
            $select = getMapelPilihan($siswa,$periode);
            $selectMapel = $dbmapel->where('mapel_kode', $select)->first();
        } else {
            $selectMapel = $dbmapel->where('mapel_kode', $row)->first();
        }
        $mapel_id = $selectMapel->id;
        $lm_id = $lingkupmateri->where('mapel_id', $mapel_id)->pluck('id');
        $dbnilai = NilaiSiswa::where('siswa_id', $siswa)
                            ->where('periode_id', $periode)
                            ->whereIn('lingkupmateri_id', $lm_id)
                            ->get();

        $countlm = 0;
        $avg = 0;
        $nilai['avg'] = null;
        //$nilai['avg'] = $dbnilai->avg('ns_nilai');
        $nilaideskmax=0;
        $nilaideskmin=100;
        $deskmax=$deskmin='';
        foreach($lm_id as $rowlm){
            $avglm = 0;
            if($dbnilai->where('lingkupmateri_id',$rowlm)->count() > 0){
                $avglm = $dbnilai->where('lingkupmateri_id',$rowlm)->avg('ns_nilai');
                //$countlm++;
                $avg = $avg + $avglm;
                //$nilai['avg']= $avg/$countlm;
            }

            $desclm = $lingkupmateri->where('id', $rowlm)->first();
            if($nilaideskmax==0&&$nilaideskmin==100){
                $nilaideskmax=$nilaideskmin=$avglm;
                $deskmax = lcfirst($desclm->lm_description).", ";
                $deskmin = lcfirst($desclm->lm_description).", ";
            } else {
                if($avglm>$nilaideskmax&&$avglm>0){
                    $nilaideskmax = $avglm;
                    $deskmax = lcfirst($desclm->lm_description).", ";
                }elseif($avglm<$nilaideskmin&&$avglm>0){
                    $nilaideskmin = $avglm;
                    $deskmin = lcfirst($desclm->lm_description).", ";
                } elseif($avglm==$nilaideskmax&&$avglm>0){
                    $deskmax = $deskmax.lcfirst($desclm->lm_description).", ";
                } elseif($avglm==$nilaideskmin&&$avglm>0){
                    $deskmin = $deskmin.lcfirst($desclm->lm_description).", ";
                }
            }
        }
        $nilai['avg']= $avg/count($lm_id);
        if($row=='IPA'){
            $mapel=['BIO','FIS'];
            $idMapel = $dbmapel->whereIn('mapel_kode', $mapel)->pluck('id');
            $sas = NilaiSiswa::where('siswa_id', $siswa)
                                ->where('periode_id', $periode)
                                ->whereIn('mapel_id', $idMapel)
                                ->where('ns_jenis_nilai', 'SAS')
                                ->avg('ns_nilai');
        } elseif($row=='IPS'){
            $mapel=['EKO','GEO','SEJ'];
            $idMapel = $dbmapel->whereIn('mapel_kode', $mapel)->pluck('id');
            $sas = NilaiSiswa::where('siswa_id', $siswa)
                                ->where('periode_id', $periode)
                                ->whereIn('mapel_id', $idMapel)
                                ->where('ns_jenis_nilai', 'SAS')
                                ->avg('ns_nilai');
        } else{
            $sas = NilaiSiswa::where('siswa_id', $siswa)
                                ->where('periode_id', $periode)
                                ->where('mapel_id', $mapel_id)
                                ->where('ns_jenis_nilai', 'SAS')
                                ->value('ns_nilai');
        }
        $nilaiRapor = round(($nilai['avg']+$sas)/2,0);
        if($nilaiRapor>=93){
            $nilai['predicate']= 'A';
        } elseif($nilaiRapor>=84){
            $nilai['predicate']= 'B';
        } elseif($nilaiRapor>=75){
            $nilai['predicate']= 'C';
        } elseif($nilaiRapor<75) {
            $nilai['predicate']= 'D';
        } else {
            $nilai['predicate']= null;
        }

        $max= $dbnilai->max('ns_nilai');
        $min= $dbnilai->min('ns_nilai');
        $lm_max= $max?$dbnilai->where('ns_nilai', $max)->first():null;
        $lm_min= $min?$dbnilai->where('ns_nilai', $min)->first():null;
        $descmax = $lm_max?$lingkupmateri->where('id',$lm_max->lingkupmateri_id)->first():null;
        $descmin= $lm_min?$lingkupmateri->where('id',$lm_min->lingkupmateri_id)->last():null;
        if($max>=93){
            $nilai['max']= $deskmax?'Menunjukkan penguasaan yang sangat baik dalam '.substr(lcfirst($deskmax), 0, -2).'.':null;
        } elseif($max>=84){
            $nilai['max']= $deskmax?'Menunjukkan penguasaan yang baik dalam '.substr(lcfirst($deskmax), 0, -2).'.':null;
        } elseif($max>=75){
            $nilai['max']= $deskmax?'Menunjukkan penguasaan yang cukup baik dalam '.substr(lcfirst($deskmax), 0, -2).'.':null;
        } elseif($max<75) {
            $nilai['max']= $deskmax?'Kurang menguasai dalam '.substr(lcfirst($deskmax), 0, -2).'.':null;
        } else {
            $nilai['max']= null;
        }
        if($min>=93){
            $nilai['min']= $deskmin?'Perlu penguatan dalam '.substr(lcfirst($deskmin), 0, -2).'.':null;
        } elseif($min>=84){
            $nilai['min']= $deskmin?'Perlu peningkatan dalam '.substr(lcfirst($deskmin), 0, -2).'.':null;
        } elseif($min>=75){
            $nilai['min']= $deskmin?'Perlu bimbingan dalam '.substr(lcfirst($deskmin), 0, -2).'.':null;
        } elseif($min<75) {
            $nilai['min']= $deskmin?'Perlu pendampingan dalam '.substr(lcfirst($deskmin), 0, -2).'.':null;
        } else {
            $nilai['min']= null;
        }

        $cek = KmrDetail::where('kmr_id',$id)
                        ->where('mapel_id',$mapel_id)
                        ->count();

        if($cek==0&&$nilaiRapor!=0){
            KmrDetail::create([
                                'kmr_id' => $id,
                                'mapel_id' => $mapel_id,
                                'kmr_score' => $nilaiRapor,
                                'kmr_predicate' => $nilai['predicate'],
                                'kmr_description1' => $nilai['max'],
                                'kmr_description2' => $nilai['min']
                            ]);
        } elseif($cek==1){
            KmrDetail::where('kmr_id', $id)->where('mapel_id', $mapel_id)
                        ->update([
                                    'kmr_score' => $nilaiRapor,
                                    'kmr_predicate' => $nilai['predicate'],
                                    'kmr_description1' => $nilai['max'],
                                    'kmr_description2' => $nilai['min']
                                ]);
        }

        $rapor[$row] = $nilai;
    }

    return $id;
}

function kurmerReportShow($user, $idRapor){
    $unit = $user->unit_id;
    $raporkurmer = [
        'PAK' => [],
        'PKN' => [],
        'BIN' => [],
        'BIG' => [],
        'MAT' => [],
        'IPA' => [],
        'IPS' => [],
        'ORG' => [],
        'MAN' => [],
        'TIK' => [],
        'JWA' => [],
        'PIL' => []
    ];
    $listMapel = ['PAK', 'PKN', 'BIN', 'BIG', 'MAT', 'IPA', 'IPS', 'ORG', 'TIK', 'JWA', 'MAN', 'PIL'];
    $dbMapel = Mapel::get();
    $dbRapor = KurmerReport::with('detail', 'siswa', 'hrteacher')
                            ->where('id', $idRapor)
                            ->first();
    $kelas = KelasAnggota::whereSiswa_id($dbRapor['siswa']['id'])
            ->where('periode_id',$user->periode)
            ->with('kelas')
            ->whereHas('kelas', function($query) use($unit){
                $query->where('unit_id', $unit)
                ->where('k_jenis', "REGULER");
            })
            ->first();

    detail_report($idRapor, $user->periode, $kelas['kelas']['kelas_jenjang'], $dbRapor['siswa']['id']);
    $dbRapor = KurmerReport::with('detail', 'siswa', 'hrteacher')
                            ->where('id', $idRapor)
                            ->first();

    $raporkurmer['id'] = $dbRapor['id'];
    $raporkurmer['nama_siswa'] = $dbRapor['siswa']['s_nama'];
    $raporkurmer['code'] = $dbRapor['siswa']['s_code'];
    $raporkurmer['nisn'] = $dbRapor['siswa']['s_nisn'];
    $raporkurmer['nis'] = $dbRapor['siswa']['s_nis'];
    $raporkurmer['kelas'] = $kelas['kelas']['kelas_nama'];
    $raporkurmer['absen'] = $kelas['absen'];
    $raporkurmer['walikelas'] = $dbRapor['hrteacher']['full_name'];
    $raporkurmer['kmr_attedance_sick'] = $dbRapor['kmr_attedance_sick'];
    $raporkurmer['kmr_attedance_excuse'] = $dbRapor['kmr_attedance_excuse'];
    $raporkurmer['kmr_attedance_alpha'] = $dbRapor['kmr_attedance_alpha'];
    $raporkurmer['kmr_note'] = $dbRapor['kmr_note'];
    $raporkurmer['kmr_note_verse'] = $dbRapor['kmr_note_verse'];
    $raporkurmer['kmr_note_godword'] = $dbRapor['kmr_note_godword'];
    $raporkurmer['kmr_extracurricular1'] = $dbRapor['kmr_extracurricular1'];
    $raporkurmer['kmr_extracurricular1_score'] = $dbRapor['kmr_extracurricular1_score'];
    $raporkurmer['kmr_extracurricular1_predicate'] = $dbRapor['kmr_extracurricular1_predicate'];
    $raporkurmer['kmr_extracurricular2'] = $dbRapor['kmr_extracurricular2'];
    $raporkurmer['kmr_extracurricular2_score'] = $dbRapor['kmr_extracurricular2_score'];
    $raporkurmer['kmr_extracurricular2_predicate'] = $dbRapor['kmr_extracurricular2_predicate'];
    $raporkurmer['kmr_extracurricular3'] = $dbRapor['kmr_extracurricular3'];
    $raporkurmer['kmr_extracurricular3_score'] = $dbRapor['kmr_extracurricular3_score'];
    $raporkurmer['kmr_extracurricular3_predicate'] = $dbRapor['kmr_extracurricular3_predicate'];

    foreach($listMapel as $rowListMapel){
        $mapel_id=null;
        if($rowListMapel=='PIL'){
            $selectMapel = $dbMapel->where('mapel_kode', getMapelPilihan($dbRapor['siswa']['id'],$user->periode))->first();
            $raporkurmer['pilihan'] = $selectMapel->mapel_nama;
        } else {
            $selectMapel = $dbMapel->where('mapel_kode', $rowListMapel)->first();
        }
        $mapel_id = $selectMapel->id;
        // foreach($dbMapel as $rowDbMapel){
        //     if($rowDbMapel->mapel_kode == $rowListMapel){
        //         $mapel_id = $rowDbMapel->id;
        //     }
        // }
        foreach($dbRapor->detail as $rowDetail){
            if($rowDetail->mapel_id == $mapel_id){
                $raporkurmer[$rowListMapel] = $rowDetail;
            }
        }
    }

    return $raporkurmer;
}

function kurmerReportUpdate($id, $periode, $unit, $user, $request){
    if(strlen($id)<30){
        $kelas = KelasAnggota::with('kelas')
                                 ->where('siswa_id',$id)
                                 ->where('periode_id', $periode)
                                 ->whereHas('kelas', function($query) use($unit){
                                        $query->where('unit_id',$unit)
                                            ->where('k_jenis', 'REGULER');
                                    })
                                 ->first();
        $walikelas = User::where('id', $kelas->kelas->kelas_wali)->value('id');
        $raporkurmer = KurmerReport::create([
                        'id'  => Uuid::Uuid4(),
                        'siswa_id' => $id,
                        'periode_id' => $periode,
                        'unit_id' =>  $unit,
                        'creator_id' =>  $user,
                        'kmr_date' => null,
                        'hrteacher_id' => $walikelas,
                        'kmr_attedance_sick' => $request->kmr_attedance_sick?$request->kmr_attedance_sick:null,
                        'kmr_attedance_excuse' => $request->kmr_attedance_excuse?$request->kmr_attedance_excuse:null,
                        'kmr_attedance_alpha' => $request->kmr_attedance_alpha?$request->kmr_attedance_alpha:null,
                        'kmr_note_verse' => $request->kmr_note_verse?$request->kmr_note_verse:null,
                        'kmr_note_godword' => $request->kmr_note_godword?$request->kmr_note_godword:null,
                        'kmr_note' => $request->kmr_note?$request->kmr_note:null,
                        'kmr_extracurricular1' => $request->kmr_extracurricular1?$request->kmr_extracurricular1:null,
                        'kmr_extracurricular1_score' => $request->kmr_extracurricular1_score?$request->kmr_extracurricular1_score:null,
                        'kmr_extracurricular1_predicate' => $request->kmr_extracurricular1_score?predikatEkstra($request->kmr_extracurricular1_score):null,
                        'kmr_extracurricular2' => $request->kmr_extracurricular2?$request->kmr_extracurricular2:null,
                        'kmr_extracurricular2_score' => $request->kmr_extracurricular2_score?$request->kmr_extracurricular2_score:null,
                        'kmr_extracurricular2_predicate' => $request->kmr_extracurricular2_score?predikatEkstra($request->kmr_extracurricular2_score):null,
                        'kmr_extracurricular3' => $request->kmr_extracurricular3?$request->kmr_extracurricular3:null,
                        'kmr_extracurricular3_score' => $request->kmr_extracurricular3_score?$request->kmr_extracurricular3_score:null,
                        'kmr_extracurricular3_predicate' => $request->kmr_extracurricular3_score?predikatEkstra($request->kmr_extracurricular3_score):null,
                        ]);

        $data = detail_report($raporkurmer->id, $periode, $kelas->kelas->kelas_jenjang, $raporkurmer->siswa_id);

    } else {
        $raporkurmer = KurmerReport::whereId($id);
        $kelas = KelasAnggota::with('kelas')
                                 ->where('siswa_id',$raporkurmer->value('siswa_id'))
                                 ->where('periode_id', $periode)
                                 ->whereHas('kelas', function($query) use($unit){
                                        $query->where('unit_id',$unit)
                                            ->where('k_jenis', 'REGULER');
                                    })
                                 ->first();
        $walikelas = User::where('id', $kelas->kelas->kelas_wali)->value('id');

        $raporkurmer->update(['creator_id' =>  $user,
                               'hrteacher_id' => $walikelas,
                               'kmr_attedance_sick' => $request->kmr_attedance_sick?$request->kmr_attedance_sick:null,
                                'kmr_attedance_excuse' => $request->kmr_attedance_excuse?$request->kmr_attedance_excuse:null,
                                'kmr_attedance_alpha' => $request->kmr_attedance_alpha?$request->kmr_attedance_alpha:null,
                                'kmr_note_verse' => $request->kmr_note_verse?$request->kmr_note_verse:null,
                                'kmr_note_godword' => $request->kmr_note_godword?$request->kmr_note_godword:null,
                                'kmr_note' => $request->kmr_note?$request->kmr_note:null,
                                'kmr_extracurricular1' => $request->kmr_extracurricular1?$request->kmr_extracurricular1:null,
                                'kmr_extracurricular1_score' => $request->kmr_extracurricular1_score?$request->kmr_extracurricular1_score:null,
                                'kmr_extracurricular1_predicate' => $request->kmr_extracurricular1_score?predikatEkstra($request->kmr_extracurricular1_score):null,
                                'kmr_extracurricular2' => $request->kmr_extracurricular2?$request->kmr_extracurricular2:null,
                                'kmr_extracurricular2_score' => $request->kmr_extracurricular2_score?$request->kmr_extracurricular2_score:null,
                                'kmr_extracurricular2_predicate' => $request->kmr_extracurricular2_score?predikatEkstra($request->kmr_extracurricular2_score):null,
                                'kmr_extracurricular3' => $request->kmr_extracurricular3?$request->kmr_extracurricular3:null,
                                'kmr_extracurricular3_score' => $request->kmr_extracurricular3_score?$request->kmr_extracurricular3_score:null,
                                'kmr_extracurricular3_predicate' => $request->kmr_extracurricular3_score?predikatEkstra($request->kmr_extracurricular3_score):null,
                            ]);
            $data = detail_report($raporkurmer->value('id'), $periode, $kelas->kelas->kelas_jenjang, $raporkurmer->value('siswa_id'));

    }
}

class KurmerReportController extends Controller
{
    public function downloadPDF(Request $request){
        $user = User::where('id', $request->user)->first();
        $idRapor = $request->rapor;
        $unit = $request->unit;
        $raporKurmer = kurmerReportShow($user, $idRapor);
        // return response()->json($raporKurmer,200);
        $pdf = PDF::loadView('kurmerReport', compact('raporKurmer'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
        return $pdf->stream($raporKurmer['code'].".pdf");
        // if($unit == 1) {
        //     $pdf = PDF::loadView('sisipan', compact('raporSisipan'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
        //     return $pdf->stream($studentCode.".pdf");
        // }elseif($unit == 3) {
        //     $pdf = PDF::loadView('sisipanp2', compact('raporSisipan'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
        //     return $pdf->stream($studentCode.".pdf");
        // }
    }

    public function show(Request $request){
        //return response()->json(['data' => 'tes'],200);
        $user = $request->user();
        $idRapor = $request->uuid;
        $raporKurmer = kurmerReportShow($user, $idRapor, $user->unit);
        return response()->json(['data' => $raporKurmer],200);
    }

    public function update(Request $request, $id){
        $user = $request->user();
        kurmerReportUpdate($id, $user->periode, $user->unit_id, $user->id, $request);
        return response()->json(['status' => 'SUCCESS'], 200);
    }
}
