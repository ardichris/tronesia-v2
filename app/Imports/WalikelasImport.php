<?php

namespace App\Imports;

use App\RaporAkhir;
use App\KurmerReport;
use App\Kelas;
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
function predikatEkstra($huruf){
    if($huruf == 'A') return 'Sangat Baik';
    if($huruf == 'B') return 'Baik';
    if($huruf == 'C') return 'Cukup';
    if($huruf == 'D') return 'Kurang';
}

class WalikelasImport implements ToCollection, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        $kelas = Kelas::where('kelas_wali', $this->rapor_id['user'])
                        ->where('periode_id',$this->rapor_id['periode'])
                        ->value('kelas_jenjang');
        foreach ($rows as $row)
        {
            $siswa = Siswa::where('s_code',$row['0'])->value('id');
            if(!is_null($siswa)){
                $ayat = $row[25]?explode("_",$row[25]):null;
                $cekdata = null;
                if($kelas==7){
                    $cekdata = KurmerReport::where('siswa_id',$siswa)->where('periode_id', $this->rapor_id['periode'])->first();
                } else {
                    $cekdata = RaporAkhir::where('siswa_id',$siswa)->where('periode_id', $this->rapor_id['periode'])->first();
                }
                if(is_null($cekdata)){
                    if($kelas=='7'){
                        KurmerReport::create([
                                'id'  => Uuid::Uuid4(),
                                'siswa_id' => $siswa,
                                'periode_id' => $this->rapor_id['periode'],
                                'unit_id' =>  $this->rapor_id['unit'],
                                'creator_id' =>  $this->rapor_id['user'],
                                'hrteacher_id' => $this->rapor_id['user'],
                                'kmr_extracurricular1' => $row[2],
                                'kmr_extracurricular1_score' => $row[3],
                                'kmr_extracurricular1_predicate' => predikatEkstra($row[3]),
                                'kmr_extracurricular2' => $row[4],
                                'kmr_extracurricular2_score' => $row[5],
                                'kmr_extracurricular2_predicate' => predikatEkstra($row[5]),
                                'kmr_extracurricular3' => $row[6],
                                'kmr_extracurricular3_score' => $row[7],
                                'kmr_extracurricular3_predicate' => predikatEkstra($row[7]),
                                'kmr_attedance_sick' => $row[22],
                                'kmr_attedance_excuse' => $row[23],
                                'kmr_attedance_alpha' => $row[24],
                                'kmr_note_verse' => $ayat?$ayat[0]:null,
                                'kmr_note_godword' => $ayat?$ayat[1]:null,
                                'kmr_note' => $row[26],
                            ]);
                    } else {
                        //$ayat = $row[25]?explode("_",$row[25]):null;
                        RaporAkhir::create([
                            'id'  => Uuid::Uuid4(),
                            'siswa_id' => $siswa,
                            'periode_id' => $this->rapor_id['periode'],
                            'unit_id' =>  $this->rapor_id['unit'],
                            'user_id' =>  $this->rapor_id['user'],
                            'ra_walikelas' => $this->rapor_id['user'],
                            'ra_ekstra1_kegiatan' => $row[2],
                            'ra_ekstra1_nilai' => $row[3],
                            'ra_ekstra1_predikat' => predikatEkstra($row[3]),
                            'ra_ekstra2_kegiatan' => $row[4],
                            'ra_ekstra2_nilai' => $row[5],
                            'ra_ekstra2_predikat' => predikatEkstra($row[5]),
                            'ra_ekstra3_kegiatan' => $row[6],
                            'ra_ekstra3_nilai' => $row[7],
                            'ra_ekstra3_predikat' => predikatEkstra($row[7]),
                            'ra_catatan_sakit' => $row[22],
                            'ra_catatan_ijin' => $row[23],
                            'ra_catatan_alpha' => $row[24],
                            'ra_catatan_ayat' => $ayat?$ayat[0]:null,
                            'ra_catatan_isi' => $ayat?$ayat[1]:null,
                            'ra_catatan_pesan' => $row[26],
                        ]);
                    }
                } else {
                    if($kelas=='7'){
                        $cekdata->update([  'creator_id' =>  $this->rapor_id['user'],
                                            'hrteacher_id' => $this->rapor_id['user'],
                                            'kmr_extracurricular1' => $row[2],
                                            'kmr_extracurricular1_score' => $row[3],
                                            'kmr_extracurricular1_predicate' => predikatEkstra($row[3]),
                                            'kmr_extracurricular2' => $row[4],
                                            'kmr_extracurricular2_score' => $row[5],
                                            'kmr_extracurricular2_predicate' => predikatEkstra($row[5]),
                                            'kmr_extracurricular3' => $row[6],
                                            'kmr_extracurricular3_score' => $row[7],
                                            'kmr_extracurricular3_predicate' => predikatEkstra($row[7]),
                                            'kmr_attedance_sick' => $row[22],
                                            'kmr_attedance_excuse' => $row['23'],
                                            'kmr_attedance_alpha' => $row[24],
                                            'kmr_note_verse' => $ayat?$ayat[0]:null,
                                            'kmr_note_godword' => $ayat?$ayat[1]:null,
                                            'kmr_note' => $row[26],
                                        ]);
                    } else {
                        $cekdata->update([
                                            'user_id' =>  $this->rapor_id['user'],
                                            'ra_walikelas' => $this->rapor_id['user'],
                                            'ra_ekstra1_kegiatan' => $row[2],
                                            'ra_ekstra1_nilai' => $row[3],
                                            'ra_ekstra1_predikat' => predikatEkstra($row[3]),
                                            'ra_ekstra2_kegiatan' => $row[4],
                                            'ra_ekstra2_nilai' => $row[5],
                                            'ra_ekstra2_predikat' => predikatEkstra($row[5]),
                                            'ra_ekstra3_kegiatan' => $row[6],
                                            'ra_ekstra3_nilai' => $row[7],
                                            'ra_ekstra3_predikat' => predikatEkstra($row[7]),
                                            'ra_catatan_sakit' => $row[22],
                                            'ra_catatan_ijin' => $row[23],
                                            'ra_catatan_alpha' => $row[24],
                                            'ra_catatan_ayat' => $ayat?$ayat[0]:null,
                                            'ra_catatan_isi' => $ayat?$ayat[1]:null,
                                            'ra_catatan_pesan' => $row[26],
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
