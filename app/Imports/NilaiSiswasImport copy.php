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
        return round(($non_tes+$tes)/2,0);
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
        if($this->nilai['jenjang']==7){
            $lmid = LingkupMateri::where('mapel_id', $this->nilai['mapel'])
                                ->where('lm_grade', $this->nilai['jenjang'])
                                ->get();
        } elseif($this->nilai['jenis']=='KI-3'){
            $lmid = Kompetensi::where('mapel_id', $this->nilai['mapel'])
                                ->where('kompetensi_jenjang', $this->nilai['jenjang'])
                                ->where('k_inti', 3)
                                ->where('is_active', 1)
                                ->get();
        } elseif($this->nilai['jenis']=='KI-4'){
            $lmid = Kompetensi::where('mapel_id', $this->nilai['mapel'])
                                ->where('kompetensi_jenjang', $this->nilai['jenjang'])
                                ->where('k_inti', 4)
                                ->where('is_active', 1)
                                ->get();
        }
        foreach ($rows as $row)
        {
            $colcounter = 2;
            $siswa = Siswa::where('s_code',$row[0])->value('id');

            if(!is_null($siswa)){
                foreach($lmid as $rowlm){
                    $cekdata = null;
                    $na_non_tes = null;
                    $na_tes = null;
                    $na_sumatif = null;
                    if($row[$colcounter]=='0') $tugas = 0;  else $tugas = $row[$colcounter]?(int)$row[$colcounter]:null;
                    if($row[$colcounter+1]=='0') $perbaikan = 0;  else $perbaikan = $row[$colcounter+1]?(int)$row[$colcounter+1]:null;
                    if($row[$colcounter+3]=='0') $tes = 0;  else $tes = $row[$colcounter+3]?(int)$row[$colcounter+3]:null;
                    if($row[$colcounter+4]=='0') $remidi = 0;  else $remidi = $row[$colcounter+4]?(int)$row[$colcounter+4]:null;
                    $cekdata = NilaiSiswa::where('siswa_id',$siswa)
                                            ->where('periode_id', $this->nilai['periode'])
                                            ->where('mapel_id', $this->nilai['mapel'])
                                            ->where('lingkupmateri_id', $rowlm->id)
                                            ->first();
                    $na_non_tes = nilaiFinal($tugas,$perbaikan);
                    $na_tes = nilaiFinal($tes,$remidi);
                    if(is_null($na_non_tes)){$na_sumatif = $na_tes;}
                    elseif(is_null($na_tes)){$na_sumatif = $na_non_tes;}
                    else {$na_sumatif = nilaiAkhir($na_non_tes,$na_tes);}
                    if(is_null($cekdata)){
                        if($na_sumatif>0){
                            NilaiSiswa::create(['siswa_id' => $siswa,
                                                'lingkupmateri_id' => $rowlm->id,
                                                'mapel_id' => $this->nilai['mapel'],
                                                'ns_tugas' => $tugas,
                                                'ns_perbaikan' => $perbaikan,
                                                'ns_tes' => $tes,
                                                'ns_remidi' => $remidi,
                                                'ns_nilai' => round($na_sumatif,2),
                                                'ns_jenis_nilai' => 'SUM',
                                                'user_id' => $this->nilai['guru'],
                                                'unit_id' => $this->nilai['unit'],
                                                'periode_id' => $this->nilai['periode'],
                                                ]);
                        }

                    } else {
                        if($na_sumatif>0){
                        $cekdata->update([  'ns_tugas' => $tugas,
                                            'ns_perbaikan' => $perbaikan,
                                            'ns_tes' => $tes,
                                            'ns_remidi' => $remidi,
                                            'ns_nilai' => round($na_sumatif,2),
                                            'user_id' => $this->nilai['guru'],
                                        ]);
                        } else {$cekdata->delete();}
                    }
                    $colcounter = $colcounter+7;
                }
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
