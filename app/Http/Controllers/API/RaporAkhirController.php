<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\RaporAkhirsImport;
use App\Imports\RaporSisipansImport;
use App\Imports\WalikelasImport;
use App\Imports\SpiritualSosialImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\RaporAkhirCollection;
use App\RaporAkhir;
use App\RaporSisipan;
use App\RaporPetra;
use App\Kelas;
use App\KelasAnggota;
use App\Siswa;
use App\User;
use App\Unit;
use App\Periode;
use App\NilaiSiswa;
use App\Mapel;
use App\SisipanField;
use App\KurmerReport;
use App\Kompetensi;
use App\LingkupMateri;
use App\PancasilaReport;
use PDF;
use Ramsey\Uuid\Uuid;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Jenssegers\Date\Date;
use SimpleSoftwareIO\QrCode\Generator;
use App\Exports\RaporsExport;
use App\Exports\RaporsSisipanExport;
use App\Exports\RaporsSisipanKurmerExport;
use App\Exports\RaporsPetraExport;
use App\Exports\KurmerReportExport;

function predikatEkstra($huruf){
    if($huruf == 'A') return 'Sangat Baik';
    if($huruf == 'B') return 'Baik';
    if($huruf == 'C') return 'Cukup';
    if($huruf == 'D') return 'Kurang';
}

function capitalize_after_delimiters($string){
    preg_match_all("/\.\s*\w/", $string, $matches);

    foreach($matches[0] as $match){
        $string = str_replace($match, strtoupper($match), $string);
    }
    return $string;
}
function nilaiSisipanKurmer($id, $unit) {
    $rapor = RaporSisipan::whereId($id)
                                ->with(['siswa' => function ($query) {
                                    $query->select('id','s_nama', 's_nis','s_code');
                                    }])
                                ->select(['id',
                                            'siswa_id',
                                            'rs_absensi_sakit',
                                            'rs_absensi_ijin',
                                            'rs_absensi_alpha',
                                            'rs_catatan_ayat',
                                            'rs_catatan_isi',
                                            'rs_catatan_pesan',
                                            'rs_walikelas',
                                            'periode_id'])
                                ->first();

    $kelas = KelasAnggota::whereSiswa_id($rapor['siswa']['id'])
                                ->where('periode_id',$rapor['periode_id'])
                                ->with('kelas')
                                ->whereHas('kelas', function($query) use($unit){
                                    $query->where('unit_id', $unit)
                                    ->where('k_jenis', "REGULER");
                                })
                                ->first();

    $raporSisipan = [
                        'PAK' => [],
                        'PKN' => [],
                        'BIN' => [],
                        'BIG' => [],
                        'MAT' => [],
                        'BIO' => [],
                        'FIS' => [],
                        'EKO' => [],
                        'GEO' => [],
                        'SEJ' => [],
                        'ORG' => [],
                        'MAN' => [],
                        'TIK' => [],
                        'JWA' => [],
                        'DC' => [],
                    ];

    $kelompok = [1,2,3,4];
    foreach($raporSisipan as $key=>$value){
        $mapelid = Mapel::where('mapel_kode', $key)->value('id');
        $lm = LingkupMateri::where('mapel_id',$mapelid)
                            ->where('lm_grade',7)
                            ->where('lm_semester', 2)
                            ->get();
        foreach($kelompok as $valkelompok){
            $raporSisipan[$key][$valkelompok]=[
                                                'ns_tugas' => null,
                                                'ns_tes' => null,
                                                'ns_jenis' => null,
                                                'LM' =>  null
                                                ];
        }
        $valuekelompok = 1;
        foreach($lm as $valuelm) {
            $nilaisiswa = NilaiSiswa::where('siswa_id', $rapor['siswa']['id'])
                                    ->where('periode_id',$rapor['periode_id'])
                                    ->where('lingkupmateri_id',$valuelm['id'])
                                    ->with(['lingkupmateri','mapel'])
                                    ->first();

            if($nilaisiswa){
                $raporSisipan[$key][$valuekelompok]=[
                                                    'ns_tugas' => $nilaisiswa['ns_tugas'],
                                                    'ns_tes' => $nilaisiswa['ns_tes'],
                                                    'ns_jenis' => $nilaisiswa['ns_jenis_nilai'],
                                                    'LM' =>  $valuelm['lm_order']
                                                    ];
                $raporSisipan[$key][$valuekelompok]['ns_tugas']=='0' ? $raporSisipan[$key][$valuekelompok]['ns_tugas']=' 0 ': $raporSisipan[$key][$valuekelompok]['ns_tugas'];
                $raporSisipan[$key][$valuekelompok]['ns_tes']=='0' ? $raporSisipan[$key][$valuekelompok]['ns_tes']=' 0 ': $raporSisipan[$key][$valuekelompok]['ns_tes'];

            } //else {
            //     $raporSisipan[$key][$valuekelompok]=[
            //                                         'ns_tugas' => '-',
            //                                         'ns_tes' => '-',
            //                                         'ns_jenis' => '-',
            //                                         'LM' =>  $valuelm['lm_order']
            //                                         ];
            // }
            $valuekelompok++;
        }


        // foreach($kelompok as $valuekelompok){
        //     if($lm[$valuekelompok-1]['id']){
        //         $nilaisiswa = NilaiSiswa::where('siswa_id', $rapor['siswa']['id'])
        //                             ->where('periode_id',$rapor['periode_id'])
        //                             ->where('lingkupmateri_id',$lm[$valuekelompok-1]['id'])
        //                             ->with(['lingkupmateri','mapel'])
        //                             ->first();

        //         if($nilaisiswa){
        //             $raporSisipan[$key][$valuekelompok]=[
        //                                                 'ns_tugas' => $nilaisiswa['ns_tugas'],
        //                                                 'ns_tes' => $nilaisiswa['ns_tes'],
        //                                                 'ns_jenis' => $nilaisiswa['ns_jenis_nilai'],
        //                                                 'LM' =>  $lm[$valuekelompok-1]['lm_order']
        //                                                 ];
        //         $raporSisipan[$key][$valuekelompok]['ns_tugas']=='0' ? $raporSisipan[$key][$valuekelompok]['ns_tugas']=' 0 ': $raporSisipan[$key][$valuekelompok]['ns_tugas'];
        //         $raporSisipan[$key][$valuekelompok]['ns_tes']=='0' ? $raporSisipan[$key][$valuekelompok]['ns_tes']=' 0 ': $raporSisipan[$key][$valuekelompok]['ns_tes'];

        //         } else {
        //             $raporSisipan[$key][$valuekelompok]=[
        //                                                 'ns_tugas' => '-',
        //                                                 'ns_tes' => '-',
        //                                                 'ns_jenis' => '-',
        //                                                 'LM' =>  $lm[$valuekelompok-1]['lm_order']
        //                                                 ];
        //         }

        //     } else {
        //         $raporSisipan[$key][$valuekelompok]=[
        //                                             'ns_tugas' => null,
        //                                             'ns_tes' => null,
        //                                             'ns_jenis' => null,
        //                                             'LM' =>  null
        //                                             ];
        //     }

        // }
        //}

    }

    $kelaspilihan = KelasAnggota::where('siswa_id', $rapor['siswa']['id'])
                                ->where('periode_id', $rapor['periode_id'])
                                ->with('kelas')
                                ->whereHas('kelas', function($query) {
                                    $query->where('k_jenis','PILIHAN');
                                })
                                ->first();
    $mapelpilihan = $kelaspilihan->kelas->k_mapel;
    $dbmapel = Mapel::where('mapel_kode', $mapelpilihan)->first();
    $raporSisipan['PIL'] = [];
    $raporSisipan['PIL']['KET'] = $dbmapel->mapel_nama;
    $lm = LingkupMateri::where('mapel_id',$dbmapel->id)
                        ->where('lm_grade',7)
                        ->where('lm_semester', 2)
                        ->get();
    foreach($kelompok as $valkelompok){
        $raporSisipan['PIL'][$valkelompok]=[
                                            'ns_tugas' => null,
                                            'ns_tes' => null,
                                            'ns_jenis' => null,
                                            'LM' =>  null
                                            ];
    }
    $valuekelompok = 1;
    foreach($lm as $valuelm){

        //if(!is_null($lm[$valuekelompok-1])){
            $nilaisiswa = NilaiSiswa::where('siswa_id', $rapor['siswa']['id'])
                                ->where('periode_id',$rapor['periode_id'])
                                ->where('lingkupmateri_id',$valuelm['id'])
                                ->with(['lingkupmateri','mapel'])
                                ->first();

            if($nilaisiswa){
                $raporSisipan['PIL'][$valuekelompok]=[
                                                    'ns_tugas' => $nilaisiswa['ns_tugas'],
                                                    'ns_tes' => $nilaisiswa['ns_tes'],
                                                    'ns_jenis' => $nilaisiswa['ns_jenis_nilai'],
                                                    'LM' =>  $lm[$valuekelompok-1]['lm_order']
                                                    ];
                $raporSisipan['PIL'][$valuekelompok]['ns_tugas']=='0' ? $raporSisipan['PIL'][$valuekelompok]['ns_tugas']=' 0 ': $raporSisipan['PIL'][$valuekelompok]['ns_tugas'];
                $raporSisipan['PIL'][$valuekelompok]['ns_tes']=='0' ? $raporSisipan['PIL'][$valuekelompok]['ns_tes']=' 0 ': $raporSisipan['PIL'][$valuekelompok]['ns_tes'];
                $valuekelompok++;
            } //else {
            //     $raporSisipan['PIL'][$valuekelompok]=[
            //                                         'ns_tugas' => '-',
            //                                         'ns_tes' => '-',
            //                                         'ns_jenis' => '-',
            //                                         'LM' =>  $lm[$valuekelompok-1]['lm_order']
            //                                         ];
            // }

        // } else {
        //     $raporSisipan['PIL'][$valuekelompok]=[
        //                                         'ns_tugas' => null,
        //                                         'ns_tes' => null,
        //                                         'ns_jenis' => null,
        //                                         'LM' =>  null
        //                                         ];
        // }
    }
    $rapor['kelas'] = $kelas;
    $rapor['ttd'] = User::whereId($kelas['kelas']['kelas_wali'])->value('ttd');
    $rapor['stamp'] = Unit::whereId($unit)->value('unit_stamp');
    $rapor['kop'] = Unit::whereId($unit)->value('unit_kop');
    $rapor['nilai'] = $raporSisipan;

    return $rapor;
}

function detail_rapor($id, $periode, $jenjang, $siswa){
    $mapel = ['PAK', 'PKN', 'BIN', 'BIG', 'MAT', 'IPA', 'IPS', 'ORG', 'JWA', 'MAN', 'MEK', 'BDY'];
    $kik13 = ['3','4'];
    $dbmapel = Mapel::get();
    $semester = substr(Periode::whereId($periode)->value('p_semester'),0,1);
    $kompetensi = Kompetensi::where('kompetensi_jenjang', $jenjang)
                            ->where('is_active',1)
                            ->get();

    foreach($mapel as $row){
        foreach($kik13 as $rowki){
            $kompetensiki = $kompetensi->where('k_inti',$rowki);
            $nilai = null;
            $lm_id = null;
            $selectMapel = null;
            $mapel_id = null;
            $max = null;
            $min = null;
            $kd_id = $kompetensiki->where('kompetensi_mapel', $row)->pluck('id');
            $dbnilai = NilaiSiswa::where('siswa_id', $siswa)
                                ->where('periode_id', $periode)
                                ->whereIn('kompetensi_id', $kd_id)
                                //->groupBy('ns_nilai', 'ASC')
                                ->get();

            $countkd = 0;
            $avg = $avgkd = 0;
            $nilai['avg'] = null;
            $descmerge = $desckd = $descA = $descB = $descC = $descD = '';
            $nilaideskmax=0;
            $nilaideskmin=100;
            $deskmax=$deskmin='';
            foreach($kd_id as $rowkd){
                $avgkd = 0;
                if($dbnilai->where('kompetensi_id',$rowkd)->count() > 0){
                    $avgkd = $dbnilai->where('kompetensi_id',$rowkd)->avg('ns_nilai');
                    $countkd++;
                    $avg = $avg + $avgkd;
                    $nilai['avg']= $avg/$countkd;
                }
                $desckd = $kompetensi->where('id', $rowkd)->first();
                if($nilaideskmax==0&&$nilaideskmin==100){
                    $nilaideskmax=$nilaideskmin=$avgkd;
                    $deskmax = lcfirst($desckd->kompetensi_deskripsi).", ";
                    $deskmin = lcfirst($desckd->kompetensi_deskripsi).", ";
                } else {
                    if($avgkd>$nilaideskmax&&$avgkd>0){
                        $nilaideskmax = $avgkd;
                        $deskmax = lcfirst($desckd->kompetensi_deskripsi).", ";
                    }elseif($avgkd<$nilaideskmin&&$avgkd>0){
                        $nilaideskmin = $avgkd;
                        $deskmin = lcfirst($desckd->kompetensi_deskripsi).", ";
                    } elseif($avgkd==$nilaideskmax&&$avgkd>0){
                        $deskmax = $deskmax.lcfirst($desckd->kompetensi_deskripsi).", ";
                    } elseif($avgkd==$nilaideskmin&&$avgkd>0){
                        $deskmin = $deskmin.lcfirst($desckd->kompetensi_deskripsi).", ";
                    }
                }
                // $desckd = $kompetensi->where('id', $rowkd)->first();
                // if($avgkd>=93){
                //     $descA = $descA.$desckd->kompetensi_deskripsi.", ";
                // } elseif($avgkd>=84){
                //     $descB = $descB.$desckd->kompetensi_deskripsi.", ";
                // } elseif($avgkd>=75){
                //     $descC = $descC.$desckd->kompetensi_deskripsi.", ";
                // } elseif($avgkd > 0) {
                //     $descD = $descD.$desckd->kompetensi_deskripsi.", ";
                // }
            }
            // $descA = $descA!=''?"Mampu ".substr($descA, 0, -2)." dengan sangat baik. ":"";
            // $descB = $descB!=''?"Mampu ".substr($descB, 0, -2)." dengan baik. ":"";
            // $descC = $descC!=''?"Cukup mampu ".substr($descC, 0, -2).". ":"";
            // $descD = $descD!=''?"Perlu bimbingan dalam ".substr($descD, 0, -2).". ":"";
            // $descmerge = $descA.$descB.$descC.$descD;
            if($rowki==3){
                if($row=='IPA') {
                    $mapel=['BIO','FIS'];
                    $idMapel = $dbmapel->whereIn('mapel_kode', $mapel)->pluck('id');
                    $pas = NilaiSiswa::where('siswa_id', $siswa)
                                        ->where('periode_id', $periode)
                                        ->whereIn('mapel_id', $idMapel)
                                        ->where('ns_jenis_nilai', 'PAS')
                                        ->avg('ns_nilai');
                    $pts = NilaiSiswa::where('siswa_id', $siswa)
                                        ->where('periode_id', $periode)
                                        ->whereIn('mapel_id', $idMapel)
                                        ->where('ns_jenis_nilai', 'PTS')
                                        ->avg('ns_nilai');
                } elseif($row=='IPS') {
                    $mapel=['EKO','GEO','SEJ'];
                    $idMapel = $dbmapel->whereIn('mapel_kode', $mapel)->pluck('id');
                    $pas = NilaiSiswa::where('siswa_id', $siswa)
                                        ->where('periode_id', $periode)
                                        ->whereIn('mapel_id', $idMapel)
                                        ->where('ns_jenis_nilai', 'PAS')
                                        ->avg('ns_nilai');
                    $pts = NilaiSiswa::where('siswa_id', $siswa)
                                        ->where('periode_id', $periode)
                                        ->whereIn('mapel_id', $idMapel)
                                        ->where('ns_jenis_nilai', 'PTS')
                                        ->avg('ns_nilai');
                } elseif($row=='BDY') {
                    $mapel=['SNR','SNM'];
                    $idMapel = $dbmapel->whereIn('mapel_kode', $mapel)->pluck('id');
                    $pas = NilaiSiswa::where('siswa_id', $siswa)
                                        ->where('periode_id', $periode)
                                        ->whereIn('mapel_id', $idMapel)
                                        ->where('ns_jenis_nilai', 'PAS')
                                        ->avg('ns_nilai');
                    $pts = NilaiSiswa::where('siswa_id', $siswa)
                                        ->where('periode_id', $periode)
                                        ->whereIn('mapel_id', $idMapel)
                                        ->where('ns_jenis_nilai', 'PTS')
                                        ->avg('ns_nilai');
                } else {
                    $idMapel = $dbmapel->whereIn('mapel_kode', $row)->first();
                    $pas = NilaiSiswa::where('siswa_id', $siswa)
                                        ->where('periode_id', $periode)
                                        ->where('mapel_id', $idMapel['id'])
                                        ->where('ns_jenis_nilai', 'PAS')
                                        ->value('ns_nilai');
                    $pts = NilaiSiswa::where('siswa_id', $siswa)
                                        ->where('periode_id', $periode)
                                        ->where('mapel_id', $idMapel['id'])
                                        ->where('ns_jenis_nilai', 'PTS')
                                        ->value('ns_nilai');
                }

                $nilai['score'] = round((round($nilai['avg'],0)*2+$pts+$pas)/4,0)!=0?round((round($nilai['avg'],0)*2+$pts+$pas)/4,0):null;
                $max= $dbnilai->max('ns_nilai');
                $min= $dbnilai->min('ns_nilai');
                $kd_max= $max?$dbnilai->where('ns_nilai', $max)->first():null;
                $kd_min= $min?$dbnilai->where('ns_nilai', $min)->first():null;
                $descmax = $kd_max?$kompetensi->where('id',$kd_max->kompetensi_id)->first():null;
                $descmin= $kd_min?$kompetensi->where('id',$kd_min->kompetensi_id)->last():null;
                // if($nilai['score']>=93){
                //     $nilai['description']= 'Sangat baik dalam menguasai dan memahami semua kompetensi, terutama '.lcfirst($descmax->kompetensi_deskripsi).'.';
                // } elseif($nilai['score']>=84){
                //     $nilai['description']= 'Menguasai sebagian besar kompetensi yang dipersyaratkan dengan baik. Perlu ditingkatkan pemahaman pada kompetensi '.lcfirst($descmin->kompetensi_deskripsi).' perlu ditingkatkan.';
                // } elseif($nilai['score']>=75){
                //     $nilai['description']= 'Beberapa kompetensi telah dikuasai dengan cukup baik. Kompetensi '.lcfirst($descmin->kompetensi_deskripsi).' perlu ditingkatkan.';
                // } elseif($nilai['score']>0) {
                //     $nilai['description']= 'Belum menguasai sebagian besar kompetensi yang dipersyaratkan.';
                // } else {
                //     $nilai['description']= null;
                // }
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
                $nilai['min']= null;
                if($nilaideskmax!=$nilaideskmin){
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
                }
                $nilai['description'] = $nilai['max']."\r\n".$nilai['min'];
            } else {
                $nilai['score'] = round($nilai['avg'],0)!=0?round($nilai['avg'],0):null;
                $max= $dbnilai->max('ns_nilai');
                $min= $dbnilai->min('ns_nilai');
                $kd_max= $max?$dbnilai->where('ns_nilai', $max)->first():null;
                $kd_min= $min?$dbnilai->where('ns_nilai', $min)->last():null;
                $descmax = $kd_max?$kompetensi->where('id',$kd_max->kompetensi_id)->first():null;
                $descmin= $kd_min?$kompetensi->where('id',$kd_min->kompetensi_id)->first():null;
                // if($nilai['score']>=93){
                //     $nilai['description']= 'Sangat baik dalam keterampilan dan mahir dalam semua kompetensi, terutama '.lcfirst($descmax->kompetensi_deskripsi).'.';
                // } elseif($nilai['score']>=84){
                //     $nilai['description']= 'Terampil pada sebagian besar kompetensi yang dipersyaratkan. Perlu ditingkatkan keterampilan pada kompetensi '.lcfirst($descmin->kompetensi_deskripsi).' perlu ditingkatkan.';
                // } elseif($nilai['score']>=75){
                //     $nilai['description']= 'Cukup terampil dalam beberapa kompetensi. Kompetensi '.lcfirst($descmin->kompetensi_deskripsi).' perlu ditingkatkan.';
                // } elseif($nilai['score']>0) {
                //     $nilai['description']= 'Belum terampil pada sebagian besar kompetensi yang dipersyaratkan.';
                // } else {
                //     $nilai['description']= null;
                // }
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
                $nilai['min']= null;
                if($nilaideskmax!=$nilaideskmin){
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
                }
                $nilai['description'] = $nilai['max']."\r\n".$nilai['min'];
            }
            //$nilai['description'] = $descmerge;
            if($nilai['score']>=93){
                $nilai['predicate']= 'A';
            } elseif($nilai['score']>=84){
                $nilai['predicate']= 'B';
            } elseif($nilai['score']>=75){
                $nilai['predicate']= 'C';
            } elseif($nilai['score']>0) {
                $nilai['predicate']= 'D';
            } else {
                $nilai['predicate']= null;
            }
            $nilaiki[$rowki] = $nilai;
        }
        $nilaiK13[$row] = $nilaiki;
    }

    $rapor = RaporAkhir::where('id',$id)
                        ->update([  'ra_pak_pengetahuan_nilai' => $nilaiK13['PAK'][3]['score'],
                                    'ra_pak_pengetahuan_predikat' => $nilaiK13['PAK'][3]['predicate'],
                                    'ra_pak_pengetahuan_deskripsi' => $nilaiK13['PAK'][3]['description'],
                                    'ra_pak_keterampilan_nilai' => $nilaiK13['PAK'][4]['score'],
                                    'ra_pak_keterampilan_predikat' => $nilaiK13['PAK'][4]['predicate'],
                                    'ra_pak_keterampilan_deskripsi' => $nilaiK13['PAK'][4]['description'],
                                    'ra_pkn_pengetahuan_nilai' => $nilaiK13['PKN'][3]['score'],
                                    'ra_pkn_pengetahuan_predikat' => $nilaiK13['PKN'][3]['predicate'],
                                    'ra_pkn_pengetahuan_deskripsi' => $nilaiK13['PKN'][3]['description'],
                                    'ra_pkn_keterampilan_nilai' => $nilaiK13['PKN'][4]['score'],
                                    'ra_pkn_keterampilan_predikat' => $nilaiK13['PKN'][4]['predicate'],
                                    'ra_pkn_keterampilan_deskripsi' => $nilaiK13['PKN'][4]['description'],
                                    'ra_bin_pengetahuan_nilai' => $nilaiK13['BIN'][3]['score'],
                                    'ra_bin_pengetahuan_predikat' => $nilaiK13['BIN'][3]['predicate'],
                                    'ra_bin_pengetahuan_deskripsi' => $nilaiK13['BIN'][3]['description'],
                                    'ra_bin_keterampilan_nilai' => $nilaiK13['BIN'][4]['score'],
                                    'ra_bin_keterampilan_predikat' => $nilaiK13['BIN'][4]['predicate'],
                                    'ra_bin_keterampilan_deskripsi' => $nilaiK13['BIN'][4]['description'],
                                    'ra_big_pengetahuan_nilai' => $nilaiK13['BIG'][3]['score'],
                                    'ra_big_pengetahuan_predikat' => $nilaiK13['BIG'][3]['predicate'],
                                    'ra_big_pengetahuan_deskripsi' => $nilaiK13['BIG'][3]['description'],
                                    'ra_big_keterampilan_nilai' => $nilaiK13['BIG'][4]['score'],
                                    'ra_big_keterampilan_predikat' => $nilaiK13['BIG'][4]['predicate'],
                                    'ra_big_keterampilan_deskripsi' => $nilaiK13['BIG'][4]['description'],
                                    'ra_mat_pengetahuan_nilai' => $nilaiK13['MAT'][3]['score'],
                                    'ra_mat_pengetahuan_predikat' => $nilaiK13['MAT'][3]['predicate'],
                                    'ra_mat_pengetahuan_deskripsi' => $nilaiK13['MAT'][3]['description'],
                                    'ra_mat_keterampilan_nilai' => $nilaiK13['MAT'][4]['score'],
                                    'ra_mat_keterampilan_predikat' => $nilaiK13['MAT'][4]['predicate'],
                                    'ra_mat_keterampilan_deskripsi' => $nilaiK13['MAT'][4]['description'],
                                    'ra_ipa_pengetahuan_nilai' => $nilaiK13['IPA'][3]['score'],
                                    'ra_ipa_pengetahuan_predikat' => $nilaiK13['IPA'][3]['predicate'],
                                    'ra_ipa_pengetahuan_deskripsi' => $nilaiK13['IPA'][3]['description'],
                                    'ra_ipa_keterampilan_nilai' => $nilaiK13['IPA'][4]['score'],
                                    'ra_ipa_keterampilan_predikat' => $nilaiK13['IPA'][4]['predicate'],
                                    'ra_ipa_keterampilan_deskripsi' => $nilaiK13['IPA'][4]['description'],
                                    'ra_ips_pengetahuan_nilai' => $nilaiK13['IPS'][3]['score'],
                                    'ra_ips_pengetahuan_predikat' => $nilaiK13['IPS'][3]['predicate'],
                                    'ra_ips_pengetahuan_deskripsi' => $nilaiK13['IPS'][3]['description'],
                                    'ra_ips_keterampilan_nilai' => $nilaiK13['IPS'][4]['score'],
                                    'ra_ips_keterampilan_predikat' => $nilaiK13['IPS'][4]['predicate'],
                                    'ra_ips_keterampilan_deskripsi' => $nilaiK13['IPS'][4]['description'],
                                    'ra_bdy_pengetahuan_nilai' => $nilaiK13['BDY'][3]['score'],
                                    'ra_bdy_pengetahuan_predikat' => $nilaiK13['BDY'][3]['predicate'],
                                    'ra_bdy_pengetahuan_deskripsi' => $nilaiK13['BDY'][3]['description'],
                                    'ra_bdy_keterampilan_nilai' => $nilaiK13['BDY'][4]['score'],
                                    'ra_bdy_keterampilan_predikat' => $nilaiK13['BDY'][4]['predicate'],
                                    'ra_bdy_keterampilan_deskripsi' => $nilaiK13['BDY'][4]['description'],
                                    'ra_org_pengetahuan_nilai' => $nilaiK13['ORG'][3]['score'],
                                    'ra_org_pengetahuan_predikat' => $nilaiK13['ORG'][3]['predicate'],
                                    'ra_org_pengetahuan_deskripsi' => $nilaiK13['ORG'][3]['description'],
                                    'ra_org_keterampilan_nilai' => $nilaiK13['ORG'][4]['score'],
                                    'ra_org_keterampilan_predikat' => $nilaiK13['ORG'][4]['predicate'],
                                    'ra_org_keterampilan_deskripsi' => $nilaiK13['ORG'][4]['description'],
                                    'ra_pky_pengetahuan_nilai' => $nilaiK13['MEK'][3]['score'],
                                    'ra_pky_pengetahuan_predikat' => $nilaiK13['MEK'][3]['predicate'],
                                    'ra_pky_pengetahuan_deskripsi' => $nilaiK13['MEK'][3]['description'],
                                    'ra_pky_keterampilan_nilai' => $nilaiK13['MEK'][4]['score'],
                                    'ra_pky_keterampilan_predikat' => $nilaiK13['MEK'][4]['predicate'],
                                    'ra_pky_keterampilan_deskripsi' => $nilaiK13['MEK'][4]['description'],
                                    'ra_jwa_pengetahuan_nilai' => $nilaiK13['JWA'][3]['score'],
                                    'ra_jwa_pengetahuan_predikat' => $nilaiK13['JWA'][3]['predicate'],
                                    'ra_jwa_pengetahuan_deskripsi' => $nilaiK13['JWA'][3]['description'],
                                    'ra_jwa_keterampilan_nilai' => $nilaiK13['JWA'][4]['score'],
                                    'ra_jwa_keterampilan_predikat' => $nilaiK13['JWA'][4]['predicate'],
                                    'ra_jwa_keterampilan_deskripsi' => $nilaiK13['JWA'][4]['description'],
                                    'ra_man_pengetahuan_nilai' => $nilaiK13['MAN'][3]['score'],
                                    'ra_man_pengetahuan_predikat' => $nilaiK13['MAN'][3]['predicate'],
                                    'ra_man_pengetahuan_deskripsi' => $nilaiK13['MAN'][3]['description'],
                                    'ra_man_keterampilan_nilai' => $nilaiK13['MAN'][4]['score'],
                                    'ra_man_keterampilan_predikat' => $nilaiK13['MAN'][4]['predicate'],
                                    'ra_man_keterampilan_deskripsi' => $nilaiK13['MAN'][4]['description'],
                                ]);

    return $nilaiK13;
}

function raporAkhirUpdate($id, $periode, $unit, $user, $request){
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
        $raporkurtilas = RaporAkhir::create([
                        'id'  => Uuid::Uuid4(),
                        'siswa_id' => $id,
                        'periode_id' => $periode,
                        'unit_id' =>  $unit,
                        'user_id' =>  $user,
                        'ra_tanggal' => null,
                        'ra_walikelas' => $walikelas,
                        'ra_catatan_sakit' => $request->attedance_sick?$request->attedance_sick:null,
                        'ra_catatan_ijin' => $request->attedance_excuse?$request->attedance_excuse:null,
                        'ra_catatan_alpha' => $request->attedance_alpha?$request->attedance_alpha:null,
                        'ra_catatan_ayat' => $request->note_verse?$request->note_verse:null,
                        'ra_catatan_isi' => $request->note_godword?$request->note_godword:null,
                        'ra_catatan_pesan' => $request->note?$request->note:null,
                        'ra_ekstra1_kegiatan' => $request->extracurricular1?$request->extracurricular1:null,
                        'ra_ekstra1_nilai' => $request->extracurricular1_score?$request->extracurricular1_score:null,
                        'ra_ekstra1_predikat' => $request->extracurricular1_score?predikatEkstra($request->extracurricular1_score):null,
                        'ra_ekstra2_kegiatan' => $request->extracurricular2?$request->extracurricular2:null,
                        'ra_ekstra2_nilai' => $request->extracurricular2_score?$request->extracurricular2_score:null,
                        'ra_ekstra2_predikat' => $request->extracurricular2_score?predikatEkstra($request->extracurricular2_score):null,
                        'ra_ekstra3_kegiatan' => $request->extracurricular3?$request->extracurricular3:null,
                        'ra_ekstra3_nilai' => $request->extracurricular3_score?$request->extracurricular3_score:null,
                        'ra_ekstra3_predikat' => $request->extracurricular3_score?predikatEkstra($request->extracurricular3_score):null,
                        ]);

        $data = detail_rapor($raporkurtilas->id, $periode, $kelas->kelas->kelas_jenjang, $raporkurtilas->siswa_id);

    } else {
        $raporkurtilas = RaporAkhir::whereId($id);
        $kelas = KelasAnggota::with('kelas')
                                 ->where('siswa_id',$raporkurtilas->value('siswa_id'))
                                 ->where('periode_id', $periode)
                                 ->whereHas('kelas', function($query) use($unit){
                                        $query->where('unit_id',$unit)
                                            ->where('k_jenis', 'REGULER');
                                    })
                                 ->first();
        $walikelas = User::where('id', $kelas->kelas->kelas_wali)->value('id');

        $raporkurtilas->update(['user_id' =>  $user,
                                'ra_walikelas' => $walikelas,
                                'ra_catatan_sakit' => $request->attedance_sick?$request->attedance_sick:null,
                                'ra_catatan_ijin' => $request->attedance_excuse?$request->attedance_excuse:null,
                                'ra_catatan_alpha' => $request->attedance_alpha?$request->attedance_alpha:null,
                                'ra_catatan_ayat' => $request->note_verse?$request->note_verse:null,
                                'ra_catatan_isi' => $request->note_godword?$request->note_godword:null,
                                'ra_catatan_pesan' => $request->note?$request->note:null,
                                'ra_ekstra1_kegiatan' => $request->extracurricular1?$request->extracurricular1:null,
                                'ra_ekstra1_nilai' => $request->extracurricular1_score?$request->extracurricular1_score:null,
                                'ra_ekstra1_predikat' => $request->extracurricular1_score?predikatEkstra($request->extracurricular1_score):null,
                                'ra_ekstra2_kegiatan' => $request->extracurricular2?$request->extracurricular2:null,
                                'ra_ekstra2_nilai' => $request->extracurricular2_score?$request->extracurricular2_score:null,
                                'ra_ekstra2_predikat' => $request->extracurricular2_score?predikatEkstra($request->extracurricular2_score):null,
                                'ra_ekstra3_kegiatan' => $request->extracurricular3?$request->extracurricular3:null,
                                'ra_ekstra3_nilai' => $request->extracurricular3_score?$request->extracurricular3_score:null,
                                'ra_ekstra3_predikat' => $request->extracurricular3_score?predikatEkstra($request->extracurricular3_score):null,
                            ]);
            $data = detail_rapor($raporkurtilas->value('id'), $periode, $kelas->kelas->kelas_jenjang, $raporkurtilas->value('siswa_id'));

    }
    return response()->json(['data' => $data],200);
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
class RaporAkhirController extends Controller
{
    public function downloadPDF(Request $request){
        $user = User::where('id', $request->user)->first();
        $idRapor = $request->rapor;
        $unit = $request->unit;
        $raporAkhir = RaporAkhir::whereId($request->rapor)
                                ->with(['siswa' => function ($query) {
                                        $query->select('id','s_nama', 's_nis','s_code','s_nisn');
                                    }])->first();
        $kelas = KelasAnggota::whereSiswa_id($raporAkhir['siswa']['id'])
                                            ->where('periode_id',$raporAkhir['periode_id'])
                                            ->with('kelas')
                                            ->first();
        $raporAkhir['kelas'] = $kelas;
        $ttd = User::whereId($raporAkhir['kelas']['kelas']['kelas_wali'])->first();
        $kasek = Unit::whereId($user->unit_id)->first();
        $raporAkhir['email'] = $ttd->email;
        $raporAkhir['ttd'] = $ttd->ttd;
        $raporAkhir['walikelas'] = $ttd->full_name;
        $raporAkhir['kasek'] = $kasek->unit_head;
        $raporAkhir['periode'] = Periode::whereId($raporAkhir['periode_id']);
        $pdf = PDF::loadView('raporAkhir', compact('raporAkhir'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
        return $pdf->stream($raporAkhir['siswa']['s_code'].".pdf");
        // if($unit == 1) {
        //     $pdf = PDF::loadView('sisipan', compact('raporSisipan'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
        //     return $pdf->stream($studentCode.".pdf");
        // }elseif($unit == 3) {
        //     $pdf = PDF::loadView('sisipanp2', compact('raporSisipan'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
        //     return $pdf->stream($studentCode.".pdf");
        // }
    }

    public function exportRapor(Request $request) {
        $user = $request->user();
        $siswa = KelasAnggota::with('kelas')
                                ->where('periode_id', $user->periode)
                                ->whereHas('kelas', function($query) use($user){
                                    $query->where('unit_id',$user->unit_id)
                                          ->where('k_jenis', 'REGULER');
                                });

        if(request()->grup=='Jenjang'){
            $siswa = $siswa->whereHas('kelas', function($query) use($request){
                                        $query->where('kelas_jenjang',$request->detail);
                                    });
        }

        if(request()->grup=='Kelas'){
            $siswa = $siswa->whereHas('kelas', function($query) use($request,$user){
                                        $query->where('kelas_nama',$request->detail)
                                        ->where('periode_id',$user->periode);
                                    });
        }

        $siswa = $siswa->pluck('siswa_id');

        if(request()->rapor=='Sisipan'){
            $rapor = RaporSisipan::whereIn('siswa_id',$siswa)
                                 ->with(['siswa' => function ($query) {
                                    $query->select('id','s_nama', 's_nis','s_code');
                                    }])
                                 ->where('periode_id',$user->periode)->get();
        }

        if(request()->rapor=='Akhir'){
            if(request()->grup=='Jenjang'&&request()->detail=='7'){
                $rapor = KurmerReport::whereIn('siswa_id',$siswa)->with(['siswa','detail'])->where('periode_id',$user->periode)->get();
                $dbMapel = Mapel::get();
                $listMapel = ['PAK','PKN','BIN','MAT','IPA','IPS','BIG','ORG','TIK','PIL','JWA','MAN'];
                foreach($rapor as $rowrapor){
                    // $rowrapor = [
                    //     'PAK' => [],
                    //     'PKN' => [],
                    //     'BIN' => [],
                    //     'BIG' => [],
                    //     'MAT' => [],
                    //     'IPA' => [],
                    //     'IPS' => [],
                    //     'ORG' => [],
                    //     'MAN' => [],
                    //     'TIK' => [],
                    //     'JWA' => [],
                    //     'PIL' => []
                    // ];
                    foreach($listMapel as $rowListMapel){
                        $mapel_id=null;
                        if($rowListMapel=='PIL'){
                            $selectMapel = $dbMapel->where('mapel_kode', getMapelPilihan($rowrapor['siswa']['id'],$user->periode))->first();
                            $rowrapor['pilihan'] = $selectMapel->mapel_nama;
                        } else {
                            $selectMapel = $dbMapel->where('mapel_kode', $rowListMapel)->first();
                        }
                        $mapel_id = $selectMapel->id;

                        foreach($rowrapor->detail as $rowDetail){
                            if($rowDetail->mapel_id == $mapel_id){
                                $rowrapor[$rowListMapel] = $rowDetail;
                            }
                        }
                    }
                }
            } else {
                $rapor = RaporAkhir::whereIn('siswa_id',$siswa)->with('siswa')->where('periode_id',$user->periode)->get();
            }
        }

        if(request()->rapor=='Petra'){
            $rapor = RaporPetra::whereIn('siswa_id',$siswa)->with('siswa')->where('periode_id',$user->periode)->get();
        }

        foreach($rapor as $row) {
            $kelas = KelasAnggota::with('kelas')->where('siswa_id',$row->siswa_id)->where('periode_id',$user->periode)->first();
            $row['kelas'] = $kelas?Kelas::where('id',$kelas['kelas_id'])->value('kelas_nama'):'-';
            $row['absen'] = $kelas?$kelas['absen']:'-';
            $row['walikelas'] = $kelas?User::whereId($kelas['kelas']['kelas_wali'])->value('full_name'):'-';
            $jenjang = $kelas?Kelas::where('id',$kelas['kelas_id'])->value('kelas_jenjang'):'-';
            if($jenjang==7){
                //$row['nilai'] = nilaiSisipanKurmer($row['id'], $user->unit_id);
            }
        }

        // Date::setLocale('id');
        // $siswa = Siswa::where('s_keterangan','AKTIF')->where('unit_id',$user->unit_id)->orderBy('s_nama')->get();
        // foreach($siswa as $row) {
        //     $kelas = KelasAnggota::where('siswa_id',$row->id)->where('periode_id',$user->periode)->first();
        //     //return response()->json(['data' => $kelas['kelas_id']]);
        //     $row['kelas'] = $kelas?Kelas::where('id',$kelas['kelas_id'])->value('kelas_nama'):'-';
        //     $row['absen'] = $kelas?$kelas['absen']:'-';
        //     $row['s_tanggal_lahir'] = Date::parse($row['s_tanggal_lahir'])->format('j F Y');
        // }
        // //$siswa = collect($siswa)->sortBy('s_nama')->sortBy('kelas')->toArray();
        $rapor = $rapor->toArray();
        //$nama = array_column($rapor->siswa, 's_nama');
        $kelas = array_column($rapor, 'kelas');
        $absen = array_column($rapor, 'absen');
        array_multisort($kelas, SORT_ASC, $absen, SORT_ASC, $rapor);
        if(request()->rapor=='Akhir'){
            if($jenjang==7){
                return Excel::download(new KurmerReportExport($rapor), 'raporkurmer-'.request()->grup.request()->detail.'-'.date('y').date('m').date('d').'.xlsx');
            } else {
                return Excel::download(new RaporsExport($rapor), 'raporakhir-'.request()->grup.request()->detail.'-'.date('y').date('m').date('d').'.xlsx');
            }
        } elseif(request()->rapor=='Sisipan'){
            if($jenjang==7){
                return Excel::download(new RaporsSisipanKurmerExport($rapor), 'raporsisipan-'.request()->grup.request()->detail.'-'.date('y').date('m').date('d').'.xlsx');
            } else {
                return Excel::download(new RaporsSisipanExport($rapor), 'raporsisipan-'.request()->grup.request()->detail.'-'.date('y').date('m').date('d').'.xlsx');
            }
        } elseif(request()->rapor=='Petra'){
            return Excel::download(new RaporsPetraExport($rapor), 'raporpetra-'.request()->grup.request()->detail.'-'.date('y').date('m').date('d').'.xlsx');
        }
        //return response()->json(['status' => 'sukses'],200);
    }

    public function raporSisipanStore(Request $request, $id) {
        // $this->validate($request, [
        //     'rs_catatan_pesan' => 'required|string',
        // ]);

        $user = $request->user();
        if(strlen($id)<30){
            $kelas = KelasAnggota::with('kelas')
                                     ->where('siswa_id',$id)
                                     ->where('periode_id', $user->periode)
                                     ->whereHas('kelas', function($query) use($user){
                                            $query->where('unit_id',$user->unit_id)
                                                ->where('k_jenis', 'REGULER');
                                        })
                                     ->first();
            $walikelas = User::where('id', $kelas->kelas->kelas_wali)->value('full_name');

            $raporsisipan = RaporSisipan::create([
                            'id'  => Uuid::Uuid4(),
                            'siswa_id' => $id,
                            'periode_id' => $user->periode,
                            'unit_id' =>  $user->unit_id,
                            'user_id' =>  $user->id,
                            'rs_tanggal' => null,
                            'rs_walikelas' => $walikelas,
                            'rs_absensi_sakit' => $request->rs_absensi_sakit?$request->rs_absensi_sakit:null,
                            'rs_absensi_ijin' => $request->rs_absensi_ijin?$request->rs_absensi_ijin:null,
                            'rs_absensi_alpha' => $request->rs_absensi_alpha?$request->rs_absensi_alpha:null,
                            'rs_catatan_ayat' => $request->rs_catatan_ayat?$request->rs_catatan_ayat:null,
                            'rs_catatan_isi' => $request->rs_catatan_isi?$request->rs_catatan_isi:null,
                            'rs_catatan_pesan' => $request->rs_catatan_pesan?$request->rs_catatan_pesan:null,
                            ]);
        } else {
            $raporsisipan = RaporSisipan::whereId($id);
            $kelas = KelasAnggota::with('kelas')
                                     ->where('siswa_id',$raporsisipan->value('siswa_id'))
                                     ->where('periode_id', $user->periode)
                                     ->whereHas('kelas', function($query) use($user){
                                            $query->where('unit_id',$user->unit_id)
                                                ->where('k_jenis', 'REGULER');
                                        })
                                     ->first();
            $walikelas = User::where('id', $kelas->kelas->kelas_wali)->value('full_name');
            $raporsisipan->update(['rs_walikelas' => $walikelas,
                                   'rs_absensi_sakit' => $request->rs_absensi_sakit?$request->rs_absensi_sakit:null,
                                    'rs_absensi_ijin' => $request->rs_absensi_ijin?$request->rs_absensi_ijin:null,
                                    'rs_absensi_alpha' => $request->rs_absensi_alpha?$request->rs_absensi_alpha:null,
                                    'rs_catatan_ayat' => $request->rs_catatan_ayat?$request->rs_catatan_ayat:null,
                                    'rs_catatan_isi' => $request->rs_catatan_isi?$request->rs_catatan_isi:null,
                                    'rs_catatan_pesan' => $request->rs_catatan_pesan?$request->rs_catatan_pesan:null]);
        }
        return response()->json(['status' => 'success'], 200);
    }

    public function raporSisipanView(Request $request)
    {
        $user = $request->user();
        $unit = $user->unit_id;

        if($request->kurikulum == 'merdeka'){
            $rapor = nilaiSisipanKurmer($request->uuid, $unit);

            return response()->json(['message' => 'success', 'data' => $rapor], 200);
            // $rapor = RaporSisipan::whereId($request->uuid)
            //                             ->with(['siswa' => function ($query) {
            //                                 $query->select('id','s_nama', 's_nis','s_code');
            //                                 }])
            //                             ->select(['id',
            //                                       'siswa_id',
            //                                       'rs_absensi_sakit',
            //                                       'rs_absensi_ijin',
            //                                       'rs_absensi_alpha',
            //                                       'rs_catatan_ayat',
            //                                       'rs_catatan_isi',
            //                                       'rs_catatan_pesan',
            //                                       'rs_walikelas'])
            //                             ->first();

            // $fieldrapor = SisipanField::where('periode_id',$user->periode)
            //                           ->where('unit_id', $user->unit_id)
            //                           ->get()->toArray();

            // $kelas = KelasAnggota::whereSiswa_id($rapor['siswa']['id'])
            //                             ->where('periode_id',$user->periode)
            //                             ->with('kelas')
            //                             ->whereHas('kelas', function($query) use($unit){
            //                                 $query->where('unit_id', $unit)
            //                                 ->where('k_jenis', "REGULER");
            //                             })
            //                             ->first();
            // $rapor['kelas'] = $kelas;
            // $rapor['ttd'] = User::whereId($kelas['kelas']['kelas_wali'])->value('ttd');
            // $rapor['stamp'] = Unit::whereId($unit)->value('unit_stamp');
            // $rapor['kop'] = Unit::whereId($unit)->value('unit_kop');
            // $raporSisipan = [
            //                     'PAK' => [],
            //                     'PKN' => [],
            //                     'BIN' => [],
            //                     'BIG' => [],
            //                     'MAT' => [],
            //                     'BIO' => [],
            //                     'FIS' => [],
            //                     'EKO' => [],
            //                     'GEO' => [],
            //                     'SEJ' => [],
            //                     'ORG' => [],
            //                     'MAN' => [],
            //                     'TIK' => [],
            //                     'JWA' => [],
            //                     'DC' => [],
            //                 ];

            // $kelompok = ['1','2','3','4','STS'];
            // foreach($raporSisipan as $key=>$value){
            //     foreach($kelompok as $valuekelompok){
            //         if($valuekelompok=='STS'){
            //             $nilaisiswa = NilaiSiswa::where('siswa_id', $rapor['siswa']['id'])
            //                                     ->where('periode_id',$user->periode)
            //                                     ->where('ns_jenis_nilai', 'STS')
            //                                     ->with(['mapel'])
            //                                     ->whereHas('mapel', function($query) use($key){
            //                                         $query->where('mapel_kode', $key);
            //                                     })
            //                                     ->first();

            //             $raporSisipan[$key][$valuekelompok]= ['ns_tes' => $nilaisiswa?$nilaisiswa['ns_tes']:null];

            //         } else {
            //         $komp = SisipanField::where('periode_id',$user->periode)
            //                           ->where('unit_id', $user->unit_id)
            //                           ->where('mapel', $key)
            //                           ->where('field', $valuekelompok)
            //                           ->with('kompetensi')
            //                           ->first();

            //         if($komp){
            //             $kompetensi = explode('.', $komp->kompetensi->kd_kode);
            //             $nilaisiswa = NilaiSiswa::where('siswa_id', $rapor['siswa']['id'])
            //                                 ->where('periode_id',$user->periode)
            //                                 ->where('kompetensi_id',$komp['kompetensi_id'])
            //                                 ->with(['kompetensi','mapel'])
            //                                 ->first();

            //             if($nilaisiswa){
            //                 $raporSisipan[$key][$valuekelompok]=[
            //                                                     'ns_tugas' => $nilaisiswa['ns_tugas'],
            //                                                     'ns_tes' => $nilaisiswa['ns_tes'],
            //                                                     'ns_jenis' => $nilaisiswa['ns_jenis_nilai'],
            //                                                     'TP' =>  $kompetensi[1]
            //                                                     ];
            //             } else {
            //                 $raporSisipan[$key][$valuekelompok]=[
            //                                                     'ns_tugas' => '-',
            //                                                     'ns_tes' => '-',
            //                                                     'ns_jenis' => '-',
            //                                                     'TP' =>  $kompetensi[1]
            //                                                     ];
            //             }

            //         } else {
            //             $raporSisipan[$key][$valuekelompok]=[
            //                                                 'ns_tugas' => null,
            //                                                 'ns_tes' => null,
            //                                                 'ns_jenis' => null,
            //                                                 'TP' =>  null
            //                                                 ];
            //         }

            //         }
            //     }

            // }
            // $kelaspilihan = KelasAnggota::where('siswa_id', $rapor['siswa']['id'])
            //                             ->where('periode_id', $user->periode)
            //                             ->with('kelas')
            //                             ->whereHas('kelas', function($query) {
            //                                 $query->where('k_jenis','PILIHAN');
            //                             })
            //                             ->first();
            // $mapelpilihan = $kelaspilihan->kelas->k_mapel;
            // $raporSisipan['PIL'] = [];
            // $raporSisipan['PIL']['KET'] = Mapel::where('mapel_kode', $mapelpilihan)->value('mapel_nama');

            // foreach($kelompok as $valuekelompok){
            //     if($valuekelompok=='STS'){
            //         $nilaisiswa = NilaiSiswa::where('siswa_id', $rapor['siswa']['id'])
            //                                 ->where('periode_id',$user->periode)
            //                                 ->where('ns_jenis_nilai', 'STS')
            //                                 ->with(['mapel'])
            //                                 ->whereHas('mapel', function($query) use($mapelpilihan){
            //                                     $query->where('mapel_kode', $mapelpilihan);
            //                                 })
            //                                 ->first();

            //         $raporSisipan['PIL'][$valuekelompok]= ['ns_tes' => $nilaisiswa?$nilaisiswa['ns_tes']:null];

            //     } else {
            //     $komp = SisipanField::where('periode_id',$user->periode)
            //                       ->where('unit_id', $user->unit_id)
            //                       ->where('mapel', $mapelpilihan)
            //                       ->where('field', $valuekelompok)
            //                       ->with('kompetensi')
            //                       ->first();

            //     if($komp){
            //         $kompetensi = explode('.', $komp->kompetensi->kd_kode);
            //         $nilaisiswa = NilaiSiswa::where('siswa_id', $rapor['siswa']['id'])
            //                             ->where('periode_id',$user->periode)
            //                             ->where('kompetensi_id',$komp['kompetensi_id'])
            //                             ->with(['kompetensi','mapel'])
            //                             ->first();

            //         if($nilaisiswa){
            //             $raporSisipan['PIL'][$valuekelompok]=[
            //                                                 'ns_tugas' => $nilaisiswa['ns_tugas'],
            //                                                 'ns_tes' => $nilaisiswa['ns_tes'],
            //                                                 'ns_jenis' => $nilaisiswa['ns_jenis_nilai'],
            //                                                 'TP' =>  $kompetensi[1]
            //                                                 ];
            //         } else {
            //             $raporSisipan['PIL'][$valuekelompok]=[
            //                                                 'ns_tugas' => '-',
            //                                                 'ns_tes' => '-',
            //                                                 'ns_jenis' => '-',
            //                                                 'TP' =>  $kompetensi[1]
            //                                                 ];
            //         }

            //     } else {
            //         $raporSisipan['PIL'][$valuekelompok]=[
            //                                             'ns_tugas' => null,
            //                                             'ns_tes' => null,
            //                                             'ns_jenis' => null,
            //                                             'TP' =>  null
            //                                             ];
            //     }

            //     }
            // }

            // $rapor['nilai'] = $raporSisipan;

            // return response()->json(['message' => 'success', 'data' => $rapor], 200);

        } else {
        $raporSisipan = RaporSisipan::whereId($request->uuid)
                                        ->with(['siswa' => function ($query) {
                                            $query->select('id','s_nama', 's_nis');
                                            }])
                                        ->first();
        $raporSisipan['kelas'] = KelasAnggota::whereSiswa_id($raporSisipan['siswa']['id'])
                                                ->where('periode_id',$raporSisipan['periode_id'])
                                                ->with('kelas')
                                                ->whereHas('kelas', function($query) use($unit){
                                                    $query->where('unit_id', $unit)
                                                    ->where('k_jenis', "REGULER");
                                                })
                                                ->first();
            $ttd = User::whereId($raporSisipan['kelas']['kelas']['kelas_wali'])->first();
            $raporSisipan['email'] = $ttd->email;
            $raporSisipan['ttd'] = $ttd->ttd;
            $raporSisipan['walikelas'] = $ttd->full_name;
            $raporSisipan['stamp'] = Unit::whereId($unit)->value('unit_stamp');
            $raporSisipan['kop'] = Unit::whereId($unit)->value('unit_kop');
            $raporSisipan['periode'] = Periode::whereId($raporSisipan['periode_id']);
        }
        return response()->json(['message' => 'success', 'data' => $raporSisipan], 200);

    }

    public function raporSisipanPDF(Request $request)
    {
        $user = $request->user();
        $idSisipan = $request->rapor;
        $unit = $request->unit;
        $raporSisipan = RaporSisipan::whereId($idSisipan)
                                    ->with(['siswa' => function ($query) {
                                        $query->select('id','s_nama','s_nis','s_code');
                                    }])->first();
        $raporSisipan['kelas'] = KelasAnggota::whereSiswa_id($raporSisipan['siswa']['id'])
                                                ->where('periode_id',$raporSisipan['periode_id'])
                                                ->with('kelas')
                                                ->first();
        $ttd = User::whereId($raporSisipan['kelas']['kelas']['kelas_wali'])->first();
        $raporSisipan['rs_spiritual_deskripsi'] = ucfirst(capitalize_after_delimiters($raporSisipan['rs_spiritual_deskripsi'])).'.';
        $raporSisipan['rs_sosial_deskripsi'] = ucfirst(capitalize_after_delimiters($raporSisipan['rs_sosial_deskripsi'])).'.';
        $raporSisipan['email'] = $ttd->email;
        $raporSisipan['ttd'] = $ttd->ttd;
        $raporSisipan['walikelas'] = $ttd->full_name;
        $raporSisipan['periode'] = Periode::whereId($raporSisipan['periode_id']);
        //$qrcode = new Generator;
        //$raporSisipan['qrcode'] = $qrcode->size(200)->generate('test');//QrCode::size(100)->generate('test');
        //return response()->json(['message' => 'success', 'data' => $raporSisipan], 200);
        //$studentCode = Siswa::whereId($raporSisipan->siswa_id)->value('s_code');
        $studentCode = $raporSisipan['siswa']['s_code'];
        if($unit == 1) {
            $pdf = PDF::loadView('sisipan', compact('raporSisipan'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
            return $pdf->stream($studentCode.".pdf");
        }elseif($unit == 3) {
            $pdf = PDF::loadView('sisipanp2', compact('raporSisipan'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
            return $pdf->stream($studentCode.".pdf");
        }


    }

    public function import(Request $request){

        $request->validate([
            'import_file' => 'required|file|mimes:xls,xlsx'
        ]);

        $user = $request->user();
        $path = $request->file('import_file');
        $jenis = $request->rapor;
        $rapor['periode'] = $user->periode;
        $rapor['user'] = $user->id;
        $rapor['unit'] = $user->unit_id;
        $rapor['jenis'] = $request->jenis_file;
        if ($jenis=='akhir') {
            if($request->jenis=='ledger'){
                $data = Excel::import(new RaporAkhirsImport($rapor), $path);
            } elseif( $request->jenis_file=='walikelas') {
                $data = Excel::import(new WalikelasImport($rapor), $path);
            } elseif(in_array($request->jenis_file,['ki1','ki2'])) {
                $data = Excel::import(new SpiritualSosialImport($rapor), $path);
            }
        }
        if ($jenis=='sisipan') {
            $data = Excel::import(new RaporSisipansImport($rapor), $path);
        }
        return response()->json(['message' => 'uploaded successfully'], 200);
    }

    public function index(Request $request) {
        $user = $request->user();
        $unit = $user->unit_id;
        $kelasAnggota = KelasAnggota::wherePeriode_id($user->periode)
                                    ->with('kelas')
                                    ->whereHas('kelas', function($query) use($unit){
                                        $query->where('unit_id', $unit)
                                        ->where('k_jenis', 'REGULER');
                                    })
                                    ->orderBy('kelas_id')
                                    ->orderBy('absen');
        if($user->role!=0){
            $kelas = Kelas::whereKelas_wali($user->id)->where('periode_id',$user->periode)->value('id');
            $kelasAnggota = $kelasAnggota->whereKelas_id($kelas);
        }

        $kelasAnggota = $kelasAnggota->with(['siswa' => function ($query) {
                                        $query->select('id','s_nama','uuid');
                                      }]);

        if (request()->q != '') {
            $q = request()->q;
            $kelasAnggota = $kelasAnggota->where(function ($query) use ($q) {
                                            $query->whereHas('siswa', function($query) use($q){
                                                        $query->where('s_nama','like','%'.$q.'%');
                                                    });
                                            });
        }
        $kelasAnggota = $kelasAnggota->paginate(40);
        foreach ($kelasAnggota as $row){
            $raporSisipan = RaporSisipan::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->select('id')->first();
            $raporAkhir = RaporAkhir::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->select('id')->first();
            $raporKurmer = KurmerReport::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->select('id')->first();
            $raporPetra = RaporPetra::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->select('id')->first();
            $pancasilaReport = PancasilaReport::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->select('id')->first();
            $row['RaporSisipan'] = $raporSisipan?$raporSisipan:'-';
            $row['RaporAkhir'] = $raporAkhir?$raporAkhir:'-';
            $row['RaporKurmer'] = $raporKurmer?$raporKurmer:'-';
            $row['RaporPetra'] = $raporPetra?$raporPetra:'-';
            $row['PancasilaReport'] = $pancasilaReport?$pancasilaReport:'-';
        }

        return new RaporAkhirCollection($kelasAnggota);
    }

    // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //         'raporakhir_kode' => 'required',
    //         'raporakhir_nama' => 'required|string'
    //     ]);

    //     RaporAkhir::create($request->all());
    //     return response()->json(['status' => 'success'], 200);
    // }

    // public function edit($id)
    // {
    //     $raporakhir = RaporAkhir::whereRaporAkhir_kode($id)->first();
    //     return response()->json(['status' => 'success', 'data' => $raporakhir], 200);
    // }

    public function show(Request $request) {
        $user = $request->user();
        //$data = raporAkhirUpdate($request->uuid, $user->periode, $user->unit_id, $user->id, $request);
        $raporAkhir = RaporAkhir::whereId($request->uuid)
                                ->with(['siswa' => function ($query) {
                                        $query->select('id','s_nama', 's_nis');
                                    }])->first();
        $kelas = KelasAnggota::whereSiswa_id($raporAkhir['siswa']['id'])
                                            ->where('periode_id',$raporAkhir['periode_id'])
                                            ->with('kelas')
                                            ->first();
        $data = detail_rapor($request->uuid, $user->periode, $kelas['kelas']['kelas_jenjang'], $raporAkhir['siswa_id']);
        $raporAkhir = RaporAkhir::whereId($request->uuid)
                                ->with(['siswa' => function ($query) {
                                        $query->select('id','s_nama', 's_nis');
                                    }])->first();
        $raporAkhir['kelas'] = $kelas;
        $ttd = User::whereId($raporAkhir['kelas']['kelas']['kelas_wali'])->first();
        $kasek = Unit::whereId($user->unit_id)->first();
        $raporAkhir['email'] = $ttd->email;
        $raporAkhir['ttd'] = $ttd->ttd;
        $raporAkhir['walikelas'] = $ttd->full_name;
        $raporAkhir['kasek'] = $kasek->unit_head;
        $raporAkhir['periode'] = Periode::whereId($raporAkhir['periode_id']);
        return response()->json(['message' => 'success', 'data' => $raporAkhir], 200);
    }

    public function update(Request $request, $id) {
        $user = $request->user();
        //$data = raporAkhirUpdate($id, $user->periode, $user->unit_id, $user->id, $request);
        if(strlen($id)<30){
            $kelas = KelasAnggota::with('kelas')
                                     ->where('siswa_id',$id)
                                     ->where('periode_id', $user->periode)
                                     ->whereHas('kelas', function($query) use($user){
                                            $query->where('unit_id',$user->unit_id)
                                                ->where('k_jenis', 'REGULER');
                                        })
                                     ->first();
            $walikelas = User::where('id', $kelas->kelas->kelas_wali)->value('id');
            $raporkurtilas = RaporAkhir::create([
                            'id'  => Uuid::Uuid4(),
                            'siswa_id' => $id,
                            'periode_id' => $user->periode,
                            'unit_id' =>  $user->unit_id,
                            'user_id' =>  $user->id,
                            'ra_tanggal' => null,
                            'ra_walikelas' => $walikelas,
                            'ra_catatan_sakit' => $request->ra_catatan_sakit?$request->ra_catatan_sakit:null,
                            'ra_catatan_ijin' => $request->ra_catatan_ijin?$request->ra_catatan_ijin:null,
                            'ra_catatan_alpha' => $request->ra_catatan_alpha?$request->ra_catatan_alpha:null,
                            'ra_catatan_ayat' => $request->ra_catatan_ayat?$request->ra_catatan_ayat:null,
                            'ra_catatan_isi' => $request->ra_catatan_isi?$request->ra_catatan_isi:null,
                            'ra_catatan_pesan' => $request->ra_catatan_pesan?$request->ra_catatan_pesan:null,
                            'ra_ekstra1_kegiatan' => $request->ra_ekstra1_kegiatan?$request->ra_ekstra1_kegiatan:null,
                            'ra_ekstra1_nilai' => $request->ra_ekstra1_nilai?$request->ra_ekstra1_nilai:null,
                            'ra_ekstra1_predikat' => $request->ra_ekstra1_predikat?predikatEkstra($request->ra_ekstra1_predikat):null,
                            'ra_ekstra2_kegiatan' => $request->ra_ekstra2_kegiatan?$request->ra_ekstra2_kegiatan:null,
                            'ra_ekstra2_nilai' => $request->ra_ekstra2_nilai?$request->ra_ekstra2_nilai:null,
                            'ra_ekstra2_predikat' => $request->ra_ekstra2_predikat?predikatEkstra($request->ra_ekstra2_predikat):null,
                            'ra_ekstra3_kegiatan' => $request->ra_ekstra3_kegiatan?$request->ra_ekstra3_kegiatan:null,
                            'ra_ekstra3_nilai' => $request->ra_ekstra3_nilai?$request->ra_ekstra3_nilai:null,
                            'ra_ekstra3_predikat' => $request->ra_ekstra3_predikat?predikatEkstra($request->ra_ekstra3_predikat):null,
                            ]);

            $data = detail_rapor($raporkurtilas->id, $user->periode, $kelas->kelas->kelas_jenjang, $raporkurtilas->siswa_id);

        } else {
            $raporkurtilas = RaporAkhir::whereId($id);
            $kelas = KelasAnggota::with('kelas')
                                     ->where('siswa_id',$raporkurtilas->value('siswa_id'))
                                     ->where('periode_id', $user->periode)
                                     ->whereHas('kelas', function($query) use($user){
                                            $query->where('unit_id',$user->unit_id)
                                                ->where('k_jenis', 'REGULER');
                                        })
                                     ->first();
            $walikelas = User::where('id', $kelas->kelas->kelas_wali)->value('id');

            $raporkurtilas->update(['user_id' =>  $user->id,
                                    'ra_walikelas' => $walikelas,
                                    'ra_catatan_sakit' => $request->ra_catatan_sakit?$request->ra_catatan_sakit:null,
                                    'ra_catatan_ijin' => $request->ra_catatan_ijin?$request->ra_catatan_ijin:null,
                                    'ra_catatan_alpha' => $request->ra_catatan_alpha?$request->ra_catatan_alpha:null,
                                    'ra_catatan_ayat' => $request->ra_catatan_ayat?$request->ra_catatan_ayat:null,
                                    'ra_catatan_isi' => $request->ra_catatan_isi?$request->ra_catatan_isi:null,
                                    'ra_catatan_pesan' => $request->ra_catatan_pesan?$request->ra_catatan_pesan:null,
                                    'ra_ekstra1_kegiatan' => $request->ra_ekstra1_kegiatan?$request->ra_ekstra1_kegiatan:null,
                                    'ra_ekstra1_nilai' => $request->ra_ekstra1_nilai?$request->ra_ekstra1_nilai:null,
                                    'ra_ekstra1_predikat' => $request->ra_ekstra1_predikat?predikatEkstra($request->ra_ekstra1_predikat):null,
                                    'ra_ekstra2_kegiatan' => $request->ra_ekstra2_kegiatan?$request->ra_ekstra2_kegiatan:null,
                                    'ra_ekstra2_nilai' => $request->ra_ekstra2_nilai?$request->ra_ekstra2_nilai:null,
                                    'ra_ekstra2_predikat' => $request->ra_ekstra2_predikat?predikatEkstra($request->ra_ekstra2_predikat):null,
                                    'ra_ekstra3_kegiatan' => $request->ra_ekstra3_kegiatan?$request->ra_ekstra3_kegiatan:null,
                                    'ra_ekstra3_nilai' => $request->ra_ekstra3_nilai?$request->ra_ekstra3_nilai:null,
                                    'ra_ekstra3_predikat' => $request->ra_ekstra3_predikat?predikatEkstra($request->ra_ekstra3_predikat):null,
                                ]);
                $data = detail_rapor($raporkurtilas->value('id'), $user->periode, $kelas->kelas->kelas_jenjang, $raporkurtilas->value('siswa_id'));

        }
        return response()->json(['status' => 'SUKSES'], 200);
    }

    // public function destroy($id)
    // {
    //     $raporakhir = RaporAkhir::find($id);
    //     $raporakhir->delete();
    //     return response()->json(['status' => 'success'], 200);
    // }
}
