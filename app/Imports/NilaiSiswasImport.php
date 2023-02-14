<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Ramsey\Uuid\Uuid;
use App\Siswa;
use App\NilaiSiswa;
use App\LingkupMateri;
use App\Kompetensi;
use App\Mapel;

function capitalize_after_delimiters($string)
    {
        preg_match_all("/\.\s*\w/", $string, $matches);

        foreach($matches[0] as $match){
            $string = str_replace($match, strtoupper($match), $string);
        }
        return $string;
    }
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
        return round(($non_tes+$tes)/2,2);
    } else {
        if(is_null($non_tes)) return $tes;
        if(is_null($tes)) return $non_tes;
    }
}
class NilaiSiswasImport implements ToCollection, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        $mapel = Mapel::get();
        $mapel_kode = $mapel->where('id',$this->nilai['mapel'])->first();
        if($this->nilai['jenjang']==7){
            if(in_array($this->nilai['mapel'],[6,7])){
                $mapel_kode->id = 8;
            } elseif (in_array($this->nilai['mapel'],[9,10,11])){
                $mapel_kode->id = 12;
            }
            $lmid = LingkupMateri::where('mapel_id', $mapel_kode->id)
                                ->where('lm_grade', $this->nilai['jenjang'])
                                ->get();
            $jenis = 'SUM';
        } elseif($this->nilai['jenis']=='KI3'){
            if(in_array($this->nilai['mapel'],[13,14])){
                $mapel_kode->mapel_kode = 'BDY';
            } elseif ($this->nilai['mapel']==21){
                $mapel_kode->mapel_kode = 'BIG';
            } elseif (in_array($this->nilai['mapel'],[6,7])){
                $mapel_kode->mapel_kode = 'IPA';
            } elseif (in_array($this->nilai['mapel'],[9,10,11])){
                $mapel_kode->mapel_kode = 'IPS';
            }
            $lmid = Kompetensi::where('kompetensi_mapel', $mapel_kode->mapel_kode)
                                ->where('kompetensi_jenjang', $this->nilai['jenjang'])
                                ->where('k_inti', 3)
                                ->where('is_active', 1)
                                ->get();
            $jenis = 'KI3';
        } elseif($this->nilai['jenis']=='KI4'){
            if(in_array($this->nilai['mapel'],[13,14])){
                $mapel_kode->mapel_kode = 'BDY';
            } elseif ($this->nilai['mapel']==21){
                $mapel_kode->mapel_kode = 'BIG';
            } elseif (in_array($this->nilai['mapel'],[6,7])){
                $mapel_kode->mapel_kode = 'IPA';
            } elseif (in_array($this->nilai['mapel'],[9,10,11])){
                $mapel_kode->mapel_kode = 'IPS';
            }
            $lmid = Kompetensi::where('kompetensi_mapel', $mapel_kode->mapel_kode)
                                ->where('kompetensi_jenjang', $this->nilai['jenjang'])
                                ->where('k_inti', 4)
                                ->where('is_active', 1)
                                ->get();
            $jenis = 'KI4';
        }
        foreach ($rows as $row)
        {
            $colcounter = 2;
            $siswa = Siswa::where('s_code',$row[0])->value('id');

            if(!is_null($siswa)){
                foreach($lmid as $rowlm){
                    $cekdata = $na_non_tes = $na_tes = $na_sumatif = null;

                    if($this->nilai['jenjang']==7){
                        $cekdata = NilaiSiswa::where('siswa_id',$siswa)
                                            ->where('periode_id', $this->nilai['periode'])
                                            ->where('mapel_id', $this->nilai['mapel'])
                                            ->where('lingkupmateri_id', $rowlm->id)
                                            ->first();
                        $lmselect = $rowlm->id;
                        $kdselect = null;
                    } else {
                        $cekdata = NilaiSiswa::where('siswa_id',$siswa)
                                            ->where('periode_id', $this->nilai['periode'])
                                            ->where('mapel_id', $this->nilai['mapel'])
                                            ->where('kompetensi_id', $rowlm->id)
                                            ->first();
                        $lmselect = null;
                        $kdselect = $rowlm->id;
                    }


                    if($this->nilai['jenis']=='KI4'){
                        $praktek = nilaiFinal($row[$colcounter],$row[$colcounter+1]);
                        $proyek = nilaiFinal($row[$colcounter+3],$row[$colcounter+4]);
                        $produk = nilaiFinal($row[$colcounter+6],$row[$colcounter+7]);
                        $portofolio = nilaiFinal($row[$colcounter+9],$row[$colcounter+10]);
                        $nilaiKI4 = [$praktek,$proyek,$produk,$portofolio];
                        $nilaiKI4 = array_filter($nilaiKI4);
                        $nsKI4 = count($nilaiKI4)>0?array_sum($nilaiKI4)/count($nilaiKI4):null;
                        if(is_null($cekdata)){
                            if($nsKI4>0){
                                NilaiSiswa::create(['siswa_id' => $siswa,
                                                    'mapel_id' => $this->nilai['mapel'],
                                                    'kompetensi_id' => $kdselect,
                                                    'ns_tugas' => $praktek,
                                                    'ns_perbaikan' => $proyek,
                                                    'ns_tes' => $produk,
                                                    'ns_remidi' => $portofolio,
                                                    'ns_nilai' => round($nsKI4,2),
                                                    'ns_jenis_nilai' => $jenis,
                                                    'user_id' => $this->nilai['guru'],
                                                    'unit_id' => $this->nilai['unit'],
                                                    'periode_id' => $this->nilai['periode'],
                                                    ]);
                            }

                        } else {
                            if($nsKI4>0){
                                $cekdata->update([  'ns_tugas' => $praktek,
                                                    'ns_perbaikan' => $proyek,
                                                    'ns_tes' => $produk,
                                                    'ns_remidi' => $portofolio,
                                                    'ns_nilai' => round($nsKI4,2),
                                                    'user_id' => $this->nilai['guru'],
                                                ]);
                            } else {$cekdata->delete();}
                        }
                        $colcounter = $colcounter+13;
                    } else {
                        if($row[$colcounter]=='0') $tugas = 0;  else $tugas = $row[$colcounter]?(int)$row[$colcounter]:null;
                        if($row[$colcounter+1]=='0') $perbaikan = 0;  else $perbaikan = $row[$colcounter+1]?(int)$row[$colcounter+1]:null;
                        if($row[$colcounter+3]=='0') $tes = 0;  else $tes = $row[$colcounter+3]?(int)$row[$colcounter+3]:null;
                        if($row[$colcounter+4]=='0') $remidi = 0;  else $remidi = $row[$colcounter+4]?(int)$row[$colcounter+4]:null;
                        $na_non_tes = nilaiFinal($tugas,$perbaikan);
                        $na_tes = nilaiFinal($tes,$remidi);
                        if(is_null($na_non_tes)){$na_sumatif = $na_tes;}
                        elseif(is_null($na_tes)){$na_sumatif = $na_non_tes;}
                        else {$na_sumatif = nilaiAkhir($na_non_tes,$na_tes);}
                        if(is_null($cekdata)){
                            if($na_sumatif>0){
                                if($this->nilai['jenis']=='KI3'){
                                    NilaiSiswa::create(['siswa_id' => $siswa,
                                                        'lingkupmateri_id' => $lmselect,
                                                        'kompetensi_id' => $kdselect,
                                                        'mapel_id' => $this->nilai['mapel'],
                                                        'ns_tes' => $tugas,
                                                        'ns_remidi' => $perbaikan,
                                                        'ns_tugas' => $tes,
                                                        'ns_perbaikan' => $remidi,
                                                        'ns_nilai' => round($na_sumatif,2),
                                                        'ns_jenis_nilai' => $jenis,
                                                        'user_id' => $this->nilai['guru'],
                                                        'unit_id' => $this->nilai['unit'],
                                                        'periode_id' => $this->nilai['periode'],
                                                        ]);
                                } else {
                                    NilaiSiswa::create(['siswa_id' => $siswa,
                                                        'lingkupmateri_id' => $lmselect,
                                                        'kompetensi_id' => $kdselect,
                                                        'mapel_id' => $this->nilai['mapel'],
                                                        'ns_tugas' => $tugas,
                                                        'ns_perbaikan' => $perbaikan,
                                                        'ns_tes' => $tes,
                                                        'ns_remidi' => $remidi,
                                                        'ns_nilai' => round($na_sumatif,2),
                                                        'ns_jenis_nilai' => $jenis,
                                                        'user_id' => $this->nilai['guru'],
                                                        'unit_id' => $this->nilai['unit'],
                                                        'periode_id' => $this->nilai['periode'],
                                                        ]);
                                }
                            }

                        } else {
                            if($na_sumatif>0){
                                if($this->nilai['jenis']=='KI3'){
                                    $cekdata->update([  'ns_tes' => $tugas,
                                                        'ns_remidi' => $perbaikan,
                                                        'ns_tugas' => $tes,
                                                        'ns_perbaikan' => $remidi,
                                                        'ns_nilai' => round($na_sumatif,2),
                                                        'user_id' => $this->nilai['guru'],
                                                        'mapel_id' => $this->nilai['mapel'],
                                                    ]);
                                } else {
                                    $cekdata->update([  'ns_tugas' => $tugas,
                                                        'ns_perbaikan' => $perbaikan,
                                                        'ns_tes' => $tes,
                                                        'ns_remidi' => $remidi,
                                                        'ns_nilai' => round($na_sumatif,2),
                                                        'mapel_id' => $this->nilai['mapel'],
                                                        'user_id' => $this->nilai['guru'],
                                                    ]);
                                }
                            } else {$cekdata->delete();}
                        }
                        $colcounter = $colcounter+7;
                    }
                }
                if($this->nilai['jenjang']==7){

                    $cekdata = NilaiSiswa::where('siswa_id',$siswa)
                                                ->where('periode_id', $this->nilai['periode'])
                                                ->where('mapel_id', $this->nilai['mapel'])
                                                ->where('ns_jenis_nilai', 'SAS')
                                                ->first();
                    if($row[$colcounter]=='0') $nilaiSAS = 0;  else $nilaiSAS = $row[$colcounter]?(int)$row[$colcounter]:null;
                    if($row[$colcounter+1]=='0') $remidiSAS = 0;  else $remidiSAS = $row[$colcounter+1]?(int)$row[$colcounter+1]:null;
                    $naSAS = nilaiFinal($nilaiSAS,$remidiSAS);
                    if(is_null($cekdata)){
                        if($naSAS>0) {
                            NilaiSiswa::create(['siswa_id' => $siswa,
                                                'mapel_id' => $this->nilai['mapel'],
                                                'ns_tes' => $nilaiSAS,
                                                'ns_remidi' => $remidiSAS,
                                                'ns_nilai' => round($naSAS,2),
                                                'ns_jenis_nilai' => 'SAS',
                                                'user_id' => $this->nilai['guru'],
                                                'unit_id' => $this->nilai['unit'],
                                                'periode_id' => $this->nilai['periode'],
                                            ]);
                        }
                    } else {
                        if($naSAS>0) {
                            $cekdata->update([  'ns_tes' => $nilaiSAS,
                                                'ns_remidi' => $remidiSAS,
                                                'ns_nilai' => round($naSAS,2),
                                                'user_id' => $this->nilai['guru'],
                                            ]);
                        } else {
                            $cekdata->delete();
                        }
                    }
                } elseif($this->nilai['jenis']=='KI3') {
                    $ujian = ['PTS','PAS'];
                    foreach($ujian as $rowujian){
                        $cekdata = NilaiSiswa::where('siswa_id',$siswa)
                                                ->where('periode_id', $this->nilai['periode'])
                                                ->where('mapel_id', $this->nilai['mapel'])
                                                ->where('ns_jenis_nilai', $rowujian)
                                                ->first();
                        if($row[$colcounter]=='0') $nilaiujian = 0;  else $nilaiujian = $row[$colcounter]?(int)$row[$colcounter]:null;
                        if($row[$colcounter+1]=='0') $remidiujian = 0;  else $remidiujian = $row[$colcounter+1]?(int)$row[$colcounter+1]:null;
                        $naujian = nilaiFinal($nilaiujian,$remidiujian);
                        if(is_null($cekdata)){
                            if($naujian>0) {
                                NilaiSiswa::create(['siswa_id' => $siswa,
                                                    'mapel_id' => $this->nilai['mapel'],
                                                    'ns_tes' => $nilaiujian,
                                                    'ns_remidi' => $remidiujian,
                                                    'ns_nilai' => round($naujian,2),
                                                    'ns_jenis_nilai' => $rowujian,
                                                    'user_id' => $this->nilai['guru'],
                                                    'unit_id' => $this->nilai['unit'],
                                                    'periode_id' => $this->nilai['periode'],
                                                ]);
                            }
                        } else {
                            if($naujian>0) {
                                $cekdata->update([  'ns_tes' => $nilaiujian,
                                                    'ns_remidi' => $remidiujian,
                                                    'ns_nilai' => round($naujian,2),
                                                    'user_id' => $this->nilai['guru'],
                                                ]);
                            } else {
                                $cekdata->delete();
                            }
                        }

                        $colcounter = $colcounter+3;
                    }
                }


                $siswa = null;
            }

        }
    }

    public function startRow(): int
    {
        return 3;
    }

    public function  __construct($nilai)
    {
        $this->nilai= $nilai;
    }
}
