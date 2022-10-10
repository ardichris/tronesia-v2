<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
use PDF;

function capitalize_after_delimiters($string)
    {
        preg_match_all("/\.\s*\w/", $string, $matches);

        foreach($matches[0] as $match){
            $string = str_replace($match, strtoupper($match), $string);
        }
        return $string;
    }

function nilaiSisipanKurmer($id, $unit){
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

    $fieldrapor = SisipanField::where('periode_id',$rapor['periode_id'])
                                ->where('unit_id', $unit)
                                ->get()->toArray();

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

    $kelompok = ['1','2','3','4','STS'];
    foreach($raporSisipan as $key=>$value){
        foreach($kelompok as $valuekelompok){
            if($valuekelompok=='STS'){
                $nilaisiswa = NilaiSiswa::where('siswa_id', $rapor['siswa']['id'])
                                        ->where('periode_id',$rapor['periode_id'])
                                        ->where('ns_jenis_nilai', 'STS')
                                        ->with(['mapel'])
                                        ->whereHas('mapel', function($query) use($key){
                                            $query->where('mapel_kode', $key);
                                        })
                                        ->first();

                $raporSisipan[$key][$valuekelompok]= ['ns_nilai' => $nilaisiswa?$nilaisiswa['ns_nilai']:null];

            } else {
            $komp = SisipanField::where('periode_id',$rapor['periode_id'])
                                ->where('unit_id', $unit)
                                ->where('mapel', $key)
                                ->where('field', $valuekelompok)
                                ->with('kompetensi')
                                ->first();

            if($komp){
                $kompetensi = explode('.', $komp->kompetensi->kd_kode);
                $nilaisiswa = NilaiSiswa::where('siswa_id', $rapor['siswa']['id'])
                                    ->where('periode_id',$rapor['periode_id'])
                                    ->where('kompetensi_id',$komp['kompetensi_id'])
                                    ->with(['kompetensi','mapel'])
                                    ->first();

                if($nilaisiswa){
                    $raporSisipan[$key][$valuekelompok]=[
                                                        'ns_tugas' => $nilaisiswa['ns_tugas'],
                                                        'ns_tes' => $nilaisiswa['ns_tes'],
                                                        'ns_jenis' => $nilaisiswa['ns_jenis_nilai'],
                                                        'TP' =>  $kompetensi[1]
                                                        ];
                } else {
                    $raporSisipan[$key][$valuekelompok]=[
                                                        'ns_tugas' => '-',
                                                        'ns_tes' => '-',
                                                        'ns_jenis' => '-',
                                                        'TP' =>  $kompetensi[1]
                                                        ];
                }

            } else {
                $raporSisipan[$key][$valuekelompok]=[
                                                    'ns_tugas' => null,
                                                    'ns_tes' => null,
                                                    'ns_jenis' => null,
                                                    'TP' =>  null
                                                    ];
            }

            }
        }

    }
    $kelaspilihan = KelasAnggota::where('siswa_id', $rapor['siswa']['id'])
                                ->where('periode_id', $rapor['periode_id'])
                                ->with('kelas')
                                ->whereHas('kelas', function($query) {
                                    $query->where('k_jenis','PILIHAN');
                                })
                                ->first();

    $mapelpilihan = $kelaspilihan->kelas->k_mapel;
    $raporSisipan['PIL'] = [];
    $raporSisipan['PIL']['KET'] = Mapel::where('mapel_kode', $mapelpilihan)->value('mapel_nama');

    foreach($kelompok as $valuekelompok){
        if($valuekelompok=='STS'){
            $nilaisiswa = NilaiSiswa::where('siswa_id', $rapor['siswa']['id'])
                                    ->where('periode_id',$rapor['periode_id'])
                                    ->where('ns_jenis_nilai', 'STS')
                                    ->with(['mapel'])
                                    ->whereHas('mapel', function($query) use($mapelpilihan){
                                        $query->where('mapel_kode', $mapelpilihan);
                                    })
                                    ->first();

            $raporSisipan['PIL'][$valuekelompok]= ['ns_nilai' => $nilaisiswa?$nilaisiswa['ns_nilai']:null];

        } else {
        $komp = SisipanField::where('periode_id',$rapor['periode_id'])
                            ->where('unit_id', $unit)
                            ->where('mapel', $mapelpilihan)
                            ->where('field', $valuekelompok)
                            ->with('kompetensi')
                            ->first();

        if($komp){
            $kompetensi = explode('.', $komp->kompetensi->kd_kode);
            $nilaisiswa = NilaiSiswa::where('siswa_id', $rapor['siswa']['id'])
                                ->where('periode_id',$rapor['periode_id'])
                                ->where('kompetensi_id',$komp['kompetensi_id'])
                                ->with(['kompetensi','mapel'])
                                ->first();

            if($nilaisiswa){
                $raporSisipan['PIL'][$valuekelompok]=[
                                                    'ns_tugas' => $nilaisiswa['ns_tugas'],
                                                    'ns_tes' => $nilaisiswa['ns_tes'],
                                                    'ns_jenis' => $nilaisiswa['ns_jenis_nilai'],
                                                    'TP' =>  $kompetensi[1]
                                                    ];
            } else {
                $raporSisipan['PIL'][$valuekelompok]=[
                                                    'ns_tugas' => '-',
                                                    'ns_tes' => '-',
                                                    'ns_jenis' => '-',
                                                    'TP' =>  $kompetensi[1]
                                                    ];
            }

        } else {
            $raporSisipan['PIL'][$valuekelompok]=[
                                                'ns_tugas' => null,
                                                'ns_tes' => null,
                                                'ns_jenis' => null,
                                                'TP' =>  null
                                                ];
        }

        }
    }

    $rapor['kelas'] = $kelas;
    $rapor['ttd'] = User::whereId($kelas['kelas']['kelas_wali'])->value('ttd');
    $rapor['stamp'] = Unit::whereId($unit)->value('unit_stamp');
    $rapor['kop'] = Unit::whereId($unit)->value('unit_kop');
    $rapor['nilai'] = $raporSisipan;

    return $rapor;
}

class RaporSisipanController extends Controller
{
    public function raporSisipanView(Request $request)
    {
        $user = $request->user();
        $unit = $user->unit_id;

        if($request->kurikulum == 'merdeka'){

            $rapor = nilaiSisipanKurmer($request->uuid, $request->unit);

            return response()->json(['message' => 'success', 'data' => $rapor], 200);

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
        if($request->kurikulum == 'merdeka'){
            $raporSisipan = nilaiSisipanKurmer($idSisipan, $unit);
            //return response()->json(["data" => compact('raporSisipan')],200);
            if($unit == 1){
                $pdf = PDF::loadView('sisipankurmer', compact('raporSisipan'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
                return $pdf->stream($raporSisipan['siswa']['s_code'].".pdf");
            } else {
                $pdf = PDF::loadView('sisipankurmerplain', compact('raporSisipan'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
                return $pdf->stream($raporSisipan['siswa']['s_code'].".pdf");
            }

        } else {
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
            $raporSisipan['stamp'] = Unit::whereId($unit)->value('unit_stamp');
            $raporSisipan['kop'] = Unit::whereId($unit)->value('unit_kop');
            $raporSisipan['walikelas'] = $ttd->full_name;
            $raporSisipan['periode'] = Periode::whereId($raporSisipan['periode_id']);
            $studentCode = $raporSisipan['siswa']['s_code'];
            if($unit == 1) {
                $pdf = PDF::loadView('sisipan', compact('raporSisipan'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
                return $pdf->stream($studentCode.".pdf");
            }elseif($unit == 3) {
                $pdf = PDF::loadView('sisipanp2', compact('raporSisipan'))->setPaper([0, 0, 612.283, 935.433], 'portrait');
                return $pdf->stream($studentCode.".pdf");
            }
        }

    }
}
