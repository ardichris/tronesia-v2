<?php

namespace App\Imports;

use App\RaporAkhir;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Ramsey\Uuid\Uuid;
use App\Siswa;

function capitalize_after_delimiters($string)
    {
        preg_match_all("/\.\s*\w/", $string, $matches);

        foreach($matches[0] as $match){
            $string = str_replace($match, strtoupper($match), $string);
        }
        return $string;
    }
function predikatKI12($nilai){
    if($nilai >= 93) return 'A';
    if($nilai >= 82) return 'B';
    if($nilai >= 75) return 'C';
    if($nilai < 75) return 'D';
}

class SpiritualSosialImport implements ToCollection, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $siswa = Siswa::where('s_code',$row['0'])->value('id');
            $month = ['JUL','AUG','SEP','OKT','NOV','DES','JAN','FEB','MAR','APR','MEI','JUN'];
            $descki2 = (object)[
                        '1' => 'jujur',
                        '2' => 'disiplin & tanggung jawab',
                        '3' => 'toleransi',
                        '4' => 'gotong royong',
                        '5' => 'salam, senyum, sapa, sopan, dan santun',
                        '6' => 'percaya diri',
                        '7' => 'menjaga keindahan dan kebersihan'
                        ];
            $descki1 = (object)[
                        '1' => 'berpartisipasi aktif saat ibadah',
                        '2' => 'mengekspresikan sukacita',
                        '3' => 'mengucap syukur',
                        '4' => 'memuliakan Tuhan',
                        ];
            if(!is_null($siswa)){
                $cekdata = null;
                $cekdata = RaporAkhir::where('siswa_id',$siswa)->where('periode_id', $this->rapor_id['periode'])->first();
                if($this->rapor_id['jenis']=='ki2'){
                    $start = 2;
                    $counterki2_1=$counterki2_2=$counterki2_3=$counterki2_4=$counterki2_5=$counterki2_6=$counterki2_7=0;
                    $ki2_1=$ki2_2=$ki2_3=$ki2_4=$ki2_5=$ki2_6=$ki2_7=0;
                    $counterki2=0;
                    $scoreki2=$ki2=null;
                    foreach ($month as $rowmonth) {
                        $sumnilai=0;
                        $cntr=0;
                        foreach($descki2 as $keydescki2 => $rowdescki2){
                            ${'ki2_'.$keydescki2} =  ${'ki2_'.$keydescki2}+$row[$start+$cntr];
                            $sumnilai = $sumnilai+$row[$start+$cntr];
                            $cntr++;
                        }
                        $start = $start+7;
                        if($sumnilai>0) $counterki2++;
                    }
                    $descA=$descB=$descC=$descD='';
                    $scoreki2avg=0;
                    foreach($descki2 as $keydescki2 => $rowdescki2){
                        ${'ki2_'.$keydescki2} = ${'ki2_'.$keydescki2}/$counterki2;
                        if(${'ki2_'.$keydescki2}>=93){
                            $descA= $descA.", ".$rowdescki2;
                        } elseif(${'ki2_'.$keydescki2}>=82){
                            $descB= $descB.", ".$rowdescki2;
                        } elseif(${'ki2_'.$keydescki2}>=75){
                            $descC= $descC.", ".$rowdescki2;
                        } elseif(${'ki2_'.$keydescki2}<75){
                            $descD= $descD.", ".$rowdescki2;
                        }
                        $scoreki2avg = $scoreki2avg+${'ki2_'.$keydescki2};
                    }
                    $descA = $descA==''?'':'Sangat baik dalam'.substr($descA, 1).'. ';
                    $descB = $descB==''?'':'Baik dalam'.substr($descB, 1).'. ';
                    $descC = $descC==''?'':'Cukup dalam'.substr($descC, 1).'. ';
                    $descD = $descD==''?'':'Kurang dalam'.substr($descD, 1).'. ';
                    $descki2final = $descA.$descB.$descC.$descD;
                    $scoreki2final = round($scoreki2avg/7,0);
                    $predicateki2 = predikatKI12($scoreki2final);

                    if(is_null($cekdata)){
                        RaporAkhir::create([
                                            'id'  => Uuid::Uuid4(),
                                            'siswa_id' => $siswa,
                                            'periode_id' => $this->rapor_id['periode'],
                                            'unit_id' =>  $this->rapor_id['unit'],
                                            'user_id' =>  $this->rapor_id['user'],
                                            'ra_walikelas' => $this->rapor_id['user'],
                                            'ra_sosial_nilai' => $scoreki2final>0?$scoreki2final:null,
                                            'ra_sosial_predikat' => $scoreki2final>0?$predicateki2:null,
                                            'ra_sosial_deskripsi' => $scoreki2final>0?$descki2final:null,
                                        ]);
                    } else {
                        $cekdata->update([
                                            'user_id' =>  $this->rapor_id['user'],
                                            'ra_walikelas' => $this->rapor_id['user'],
                                            'ra_walikelas' => $this->rapor_id['user'],
                                            'ra_sosial_nilai' => $scoreki2final>0?$scoreki2final:null,
                                            'ra_sosial_predikat' => $scoreki2final>0?$predicateki2:null,
                                            'ra_sosial_deskripsi' => $scoreki2final>0?$descki2final:null,
                                        ]);
                    }
                } elseif($this->rapor_id['jenis']=='ki1') {
                    $start = 2;
                    $ki1_1=$ki1_2=$ki1_3=$ki1_4=0;
                    $counterki1=0;
                    foreach ($month as $rowmonth) {
                        $sumnilai=0;
                        $cntr=0;
                        foreach($descki1 as $keydescki1 => $rowdescki1){
                            ${'ki1_'.$keydescki1} =  ${'ki1_'.$keydescki1}+$row[$start+$cntr];
                            $sumnilai = $sumnilai+$row[$start+$cntr];
                            $cntr++;
                        }
                        $start = $start+4;
                        if($sumnilai>0) $counterki1++;
                    }
                    $descA=$descB=$descC=$descD='';
                    $scoreki1avg=0;
                    foreach($descki1 as $keydescki1 => $rowdescki1){
                        ${'ki1_'.$keydescki1} = ${'ki1_'.$keydescki1}/$counterki1;
                        if(${'ki1_'.$keydescki1}>=93){
                            $descA= $descA.", ".$rowdescki1;
                        } elseif(${'ki1_'.$keydescki1}>=82){
                            $descB= $descB.", ".$rowdescki1;
                        } elseif(${'ki1_'.$keydescki1}>=75){
                            $descC= $descC.", ".$rowdescki1;
                        } elseif(${'ki1_'.$keydescki1}<75){
                            $descD= $descD.", ".$rowdescki1;
                        }
                        $scoreki1avg = $scoreki1avg+${'ki1_'.$keydescki1};
                    }
                    $descA = $descA==''?'':'Sangat baik dalam'.substr($descA, 1).'. ';
                    $descB = $descB==''?'':'Baik dalam'.substr($descB, 1).'. ';
                    $descC = $descC==''?'':'Cukup dalam'.substr($descC, 1).'. ';
                    $descD = $descD==''?'':'Kurang dalam'.substr($descD, 1).'. ';
                    $descki1final = $descA.$descB.$descC.$descD;
                    $scoreki1final = round($scoreki1avg/4,0);
                    $predicateki1 = predikatKI12($scoreki1final);

                    if(is_null($cekdata)){
                        RaporAkhir::create([
                                            'id'  => Uuid::Uuid4(),
                                            'siswa_id' => $siswa,
                                            'periode_id' => $this->rapor_id['periode'],
                                            'unit_id' =>  $this->rapor_id['unit'],
                                            'user_id' =>  $this->rapor_id['user'],
                                            'ra_walikelas' => $this->rapor_id['user'],
                                            'ra_spiritual_nilai' => $scoreki1final>0?$scoreki1final:null,
                                            'ra_spiritual_predikat' => $scoreki1final>0?$predicateki1:null,
                                            'ra_spiritual_deskripsi' => $scoreki1final>0?$descki1final:null,
                                        ]);
                    } else {
                        $cekdata->update([
                                            'user_id' =>  $this->rapor_id['user'],
                                            'ra_walikelas' => $this->rapor_id['user'],
                                            'ra_walikelas' => $this->rapor_id['user'],
                                            'ra_spiritual_nilai' => $scoreki1final>0?$scoreki1final:null,
                                            'ra_spiritual_predikat' => $scoreki1final>0?$predicateki1:null,
                                            'ra_spiritual_deskripsi' => $scoreki1final>0?$descki1final:null,
                                        ]);
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

    public function  __construct($rapor_id)
    {
        $this->rapor_id= $rapor_id;
    }
}
