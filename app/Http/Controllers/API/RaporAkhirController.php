<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\RaporAkhirsImport;
use App\Imports\RaporSisipansImport;
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
use PDF;
use Ramsey\Uuid\Uuid;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Jenssegers\Date\Date;
use SimpleSoftwareIO\QrCode\Generator;
use App\Exports\RaporsExport;
use App\Exports\RaporsSisipanExport;
use App\Exports\RaporsSisipanKurmerExport;
use App\Exports\RaporsPetraExport;

function capitalize_after_delimiters($string)
    {
        preg_match_all("/\.\s*\w/", $string, $matches);

        foreach($matches[0] as $match){
            $string = str_replace($match, strtoupper($match), $string);
        }
        return $string;
    }
function nilaiSisipanKurmer($id, $unit)
    {
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
                    $raporSisipan[$key][$valuekelompok]= ['ns_tes' => $nilaisiswa?$nilaisiswa['ns_tes']:null];
                    $raporSisipan[$key][$valuekelompok]['ns_tes']=='0' ? $raporSisipan[$key][$valuekelompok]['ns_tes']=' 0 ': $raporSisipan[$key][$valuekelompok]['ns_tes'];

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
                    $raporSisipan[$key][$valuekelompok]['ns_tugas']=='0' ? $raporSisipan[$key][$valuekelompok]['ns_tugas']=' 0 ': $raporSisipan[$key][$valuekelompok]['ns_tugas'];
                    $raporSisipan[$key][$valuekelompok]['ns_tes']=='0' ? $raporSisipan[$key][$valuekelompok]['ns_tes']=' 0 ': $raporSisipan[$key][$valuekelompok]['ns_tes'];

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

                $raporSisipan['PIL'][$valuekelompok]= ['ns_tes' => $nilaisiswa?$nilaisiswa['ns_tes']:null];

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
                    $raporSisipan['PIL'][$valuekelompok]['ns_tugas']=='0' ? $raporSisipan['PIL'][$valuekelompok]['ns_tugas']=' 0 ': $raporSisipan['PIL'][$valuekelompok]['ns_tugas'];
                    $raporSisipan['PIL'][$valuekelompok]['ns_tes']=='0' ? $raporSisipan['PIL'][$valuekelompok]['ns_tes']=' 0 ': $raporSisipan['PIL'][$valuekelompok]['ns_tes'];

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

        $rapor = $raporSisipan;

        return $rapor;
    }

class RaporAkhirController extends Controller
{

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
            $rapor = RaporAkhir::whereIn('siswa_id',$siswa)->with('siswa')->where('periode_id',$user->periode)->get();
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
                $row['nilai'] = nilaiSisipanKurmer($row['id'], $user->unit_id);
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
            return Excel::download(new RaporsExport($rapor), 'raporakhir-'.request()->grup.request()->detail.'-'.date('y').date('m').date('d').'.xlsx');
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
            $rapor = RaporSisipan::whereId($request->uuid)
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
                                                  'rs_walikelas'])
                                        ->first();

            $fieldrapor = SisipanField::where('periode_id',$user->periode)
                                      ->where('unit_id', $user->unit_id)
                                      ->get()->toArray();

            $kelas = KelasAnggota::whereSiswa_id($rapor['siswa']['id'])
                                        ->where('periode_id',$user->periode)
                                        ->with('kelas')
                                        ->whereHas('kelas', function($query) use($unit){
                                            $query->where('unit_id', $unit)
                                            ->where('k_jenis', "REGULER");
                                        })
                                        ->first();
            $rapor['kelas'] = $kelas;
            $rapor['ttd'] = User::whereId($kelas['kelas']['kelas_wali'])->value('ttd');
            $rapor['stamp'] = Unit::whereId($unit)->value('unit_stamp');
            $rapor['kop'] = Unit::whereId($unit)->value('unit_kop');
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
                                                ->where('periode_id',$user->periode)
                                                ->where('ns_jenis_nilai', 'STS')
                                                ->with(['mapel'])
                                                ->whereHas('mapel', function($query) use($key){
                                                    $query->where('mapel_kode', $key);
                                                })
                                                ->first();

                        $raporSisipan[$key][$valuekelompok]= ['ns_tes' => $nilaisiswa?$nilaisiswa['ns_tes']:null];

                    } else {
                    $komp = SisipanField::where('periode_id',$user->periode)
                                      ->where('unit_id', $user->unit_id)
                                      ->where('mapel', $key)
                                      ->where('field', $valuekelompok)
                                      ->with('kompetensi')
                                      ->first();

                    if($komp){
                        $kompetensi = explode('.', $komp->kompetensi->kd_kode);
                        $nilaisiswa = NilaiSiswa::where('siswa_id', $rapor['siswa']['id'])
                                            ->where('periode_id',$user->periode)
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
                                        ->where('periode_id', $user->periode)
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
                                            ->where('periode_id',$user->periode)
                                            ->where('ns_jenis_nilai', 'STS')
                                            ->with(['mapel'])
                                            ->whereHas('mapel', function($query) use($mapelpilihan){
                                                $query->where('mapel_kode', $mapelpilihan);
                                            })
                                            ->first();

                    $raporSisipan['PIL'][$valuekelompok]= ['ns_tes' => $nilaisiswa?$nilaisiswa['ns_tes']:null];

                } else {
                $komp = SisipanField::where('periode_id',$user->periode)
                                  ->where('unit_id', $user->unit_id)
                                  ->where('mapel', $mapelpilihan)
                                  ->where('field', $valuekelompok)
                                  ->with('kompetensi')
                                  ->first();

                if($komp){
                    $kompetensi = explode('.', $komp->kompetensi->kd_kode);
                    $nilaisiswa = NilaiSiswa::where('siswa_id', $rapor['siswa']['id'])
                                        ->where('periode_id',$user->periode)
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

            $rapor['nilai'] = $raporSisipan;

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

    public function import(Request $request)
    {

        $request->validate([
            'import_file' => 'required|file|mimes:xls,xlsx'
        ]);

        $user = $request->user();
        $path = $request->file('import_file');
        $jenis = $request->rapor;
        $rapor['periode'] = $user->periode;
        $rapor['user'] = $user->id;
        $rapor['unit'] = $user->unit_id;
        if ($jenis=='akhir') {
            $data = Excel::import(new RaporAkhirsImport($rapor), $path);
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
            $raporPetra = RaporPetra::where('siswa_id',$row->siswa->id)->where('periode_id',$user->periode)->select('id')->first();
            $row['RaporSisipan'] = $raporSisipan?$raporSisipan:'-';
            $row['RaporAkhir'] = $raporAkhir?$raporAkhir:'-';
            $row['RaporPetra'] = $raporPetra?$raporPetra:'-';
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

    public function show(Request $request)
    {
        $user = $request->user();
        $raporAkhir = RaporAkhir::whereId($request->uuid)
                                    ->with(['siswa' => function ($query) {
                                        $query->select('id','s_nama', 's_nis');
                                    }])->first();
                                    $raporAkhir['kelas'] = KelasAnggota::whereSiswa_id($raporAkhir['siswa']['id'])
                                    ->where('periode_id',$raporAkhir['periode_id'])
                                    ->with('kelas')
                                    ->first();
        $ttd = User::whereId($raporAkhir['kelas']['kelas']['kelas_wali'])->first();
        $kasek = Unit::whereId($user->unit_id)->first();
        $raporAkhir['email'] = $ttd->email;
        $raporAkhir['ttd'] = $ttd->ttd;
        $raporAkhir['walikelas'] = $ttd->full_name;
        $raporAkhir['kasek'] = $kasek->unit_head;
        $raporAkhir['periode'] = Periode::whereId($raporAkhir['periode_id']);
        return response()->json(['message' => 'success', 'data' => $raporAkhir], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'ra_catatan_ayat' => 'required|string',
            'ra_catatan_isi' => 'required|string'
        ]);

        $user = $request->user();
        $raporakhir = RaporAkhir::whereId($id)
                                    ->update(['ra_catatan_ayat' => $request->ra_catatan_ayat,
                                                'ra_catatan_isi' => $request->ra_catatan_isi]);
        return response()->json(['status' => 'success'], 200);
    }

    // public function destroy($id)
    // {
    //     $raporakhir = RaporAkhir::find($id);
    //     $raporakhir->delete();
    //     return response()->json(['status' => 'success'], 200);
    // }
}
