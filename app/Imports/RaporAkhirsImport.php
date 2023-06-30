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

class RaporAkhirsImport implements ToCollection, WithStartRow
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
            $ayat = explode("_", $row[133]);
            if(!is_null($siswa)){
                $cekdata = null;
                $cekdata = RaporAkhir::where('siswa_id',$siswa)->where('periode_id', $this->rapor_id['periode'])->first();
                if(is_null($cekdata)){
                    RaporAkhir::create([
                        'id'  => Uuid::Uuid4(),
                        'siswa_id' => $siswa,
                        'periode_id' => $this->rapor_id['periode'],
                        'unit_id' =>  $this->rapor_id['unit'],
                        'user_id' =>  $this->rapor_id['user'],
                        'ra_walikelas' => $row[10],
                        'ra_spiritual_nilai' => null,
                        'ra_spiritual_predikat' => $row[11]=='A'?'SB':$row[11],
                        'ra_spiritual_deskripsi' => ucfirst(capitalize_after_delimiters($row[12])).'.',
                        'ra_sosial_nilai' => null,
                        'ra_sosial_predikat' => $row[13]=='A'?'SB':$row[13],
                        'ra_sosial_deskripsi' => ucfirst(capitalize_after_delimiters($row[14])).'.',
                        'ra_pak_pengetahuan_nilai' => $row[39],
                        'ra_pak_pengetahuan_predikat' => $row[40],
                        'ra_pak_pengetahuan_deskripsi' => $row[41],
                        'ra_pkn_pengetahuan_nilai' => $row[45],
                        'ra_pkn_pengetahuan_predikat' => $row[46],
                        'ra_pkn_pengetahuan_deskripsi' => $row[47],
                        'ra_bin_pengetahuan_nilai' => $row[15],
                        'ra_bin_pengetahuan_predikat' => $row[16],
                        'ra_bin_pengetahuan_deskripsi' => $row[17],
                        'ra_mat_pengetahuan_nilai' => $row[36],
                        'ra_mat_pengetahuan_predikat' => $row[37],
                        'ra_mat_pengetahuan_deskripsi' => $row[38],
                        'ra_ipa_pengetahuan_nilai' => $row[30],
                        'ra_ipa_pengetahuan_predikat' => $row[31],
                        'ra_ipa_pengetahuan_deskripsi' => $row[32],
                        'ra_ips_pengetahuan_nilai' => $row[33],
                        'ra_ips_pengetahuan_predikat' => $row[34],
                        'ra_ips_pengetahuan_deskripsi' => $row[35],
                        'ra_big_pengetahuan_nilai' => $row[18],
                        'ra_big_pengetahuan_predikat' => $row[19],
                        'ra_big_pengetahuan_deskripsi' => $row[20],
                        'ra_bdy_pengetahuan_nilai' => $row[51],
                        'ra_bdy_pengetahuan_predikat' => $row[52],
                        'ra_bdy_pengetahuan_deskripsi' => $row[53],
                        'ra_snm_pengetahuan_nilai' => $row[54],
                        'ra_snm_pengetahuan_predikat' => $row[55],
                        'ra_snm_pengetahuan_deskripsi' => $row[56],
                        'ra_snr_pengetahuan_nilai' => $row[57],
                        'ra_snr_pengetahuan_predikat' => $row[58],
                        'ra_snr_pengetahuan_deskripsi' => $row[59],
                        'ra_org_pengetahuan_nilai' => $row[42],
                        'ra_org_pengetahuan_predikat' => $row[43],
                        'ra_org_pengetahuan_deskripsi' => $row[44],
                        'ra_pky_pengetahuan_nilai' => $row[48],
                        'ra_pky_pengetahuan_predikat' => $row[49],
                        'ra_pky_pengetahuan_deskripsi' => $row[50],
                        'ra_jwa_pengetahuan_nilai' => $row[21],
                        'ra_jwa_pengetahuan_predikat' => $row[22],
                        'ra_jwa_pengetahuan_deskripsi' => $row[23],
                        'ra_man_pengetahuan_nilai' => $row[24],
                        'ra_man_pengetahuan_predikat' => $row[25],
                        'ra_man_pengetahuan_deskripsi' => $row[26],
                        'ra_tik_pengetahuan_nilai' => $row[27],
                        'ra_tik_pengetahuan_predikat' => $row[28],
                        'ra_tik_pengetahuan_deskripsi' => $row[29],
                        'ra_ekstra1_kegiatan' => ucfirst(strtolower($row[105])),
                        'ra_ekstra1_nilai' => $row[106],
                        'ra_ekstra1_predikat' => ucwords($row[107]),
                        'ra_ekstra2_kegiatan' => $row[108],
                        'ra_ekstra2_nilai' => $row[109],
                        'ra_ekstra2_predikat' => ucwords($row[110]),
                        'ra_ekstra3_kegiatan' => $row[111],
                        'ra_ekstra3_nilai' => $row[112],
                        'ra_ekstra3_predikat' => ucwords($row[113]),
                        'ra_catatan_sakit' => $row[130]!='0' ? $row[130]:'-',
                        'ra_catatan_ijin' => $row[131]!='0' ? $row[131]:'-',
                        'ra_catatan_alpha' => $row[132]!='0' ? $row[132]:'-',
                        'ra_catatan_ayat' => $ayat[0],
                        'ra_catatan_isi' => $ayat[1],
                        'ra_catatan_pesan' => $row[134],
                    ]);
                } else {
                    $cekdata->update(['ra_walikelas' => $row[10],
                                    'ra_spiritual_nilai' => null,
                                    'ra_spiritual_predikat' => $row[11]=='A'?'SB':$row[11],
                                    'ra_spiritual_deskripsi' => ucfirst(capitalize_after_delimiters($row[12])).'.',
                                    'ra_sosial_nilai' => null,
                                    'ra_sosial_predikat' => $row[13]=='A'?'SB':$row[13],
                                    'ra_sosial_deskripsi' => ucfirst(capitalize_after_delimiters($row[14])).'.',
                                    'ra_pak_pengetahuan_nilai' => $row[39],
                                    'ra_pak_pengetahuan_predikat' => $row[40],
                                    'ra_pak_pengetahuan_deskripsi' => $row[41],
                                    'ra_pkn_pengetahuan_nilai' => $row[45],
                                    'ra_pkn_pengetahuan_predikat' => $row[46],
                                    'ra_pkn_pengetahuan_deskripsi' => $row[47],
                                    'ra_bin_pengetahuan_nilai' => $row[15],
                                    'ra_bin_pengetahuan_predikat' => $row[16],
                                    'ra_bin_pengetahuan_deskripsi' => $row[17],
                                    'ra_mat_pengetahuan_nilai' => $row[36],
                                    'ra_mat_pengetahuan_predikat' => $row[37],
                                    'ra_mat_pengetahuan_deskripsi' => $row[38],
                                    'ra_ipa_pengetahuan_nilai' => $row[30],
                                    'ra_ipa_pengetahuan_predikat' => $row[31],
                                    'ra_ipa_pengetahuan_deskripsi' => $row[32],
                                    'ra_ips_pengetahuan_nilai' => $row[33],
                                    'ra_ips_pengetahuan_predikat' => $row[34],
                                    'ra_ips_pengetahuan_deskripsi' => $row[35],
                                    'ra_big_pengetahuan_nilai' => $row[18],
                                    'ra_big_pengetahuan_predikat' => $row[19],
                                    'ra_big_pengetahuan_deskripsi' => $row[20],
                                    'ra_bdy_pengetahuan_nilai' => $row[51],
                                    'ra_bdy_pengetahuan_predikat' => $row[52],
                                    'ra_bdy_pengetahuan_deskripsi' => $row[53],
                                    'ra_snm_pengetahuan_nilai' => $row[54],
                                    'ra_snm_pengetahuan_predikat' => $row[55],
                                    'ra_snm_pengetahuan_deskripsi' => $row[56],
                                    'ra_snr_pengetahuan_nilai' => $row[57],
                                    'ra_snr_pengetahuan_predikat' => $row[58],
                                    'ra_snr_pengetahuan_deskripsi' => $row[59],
                                    'ra_org_pengetahuan_nilai' => $row[42],
                                    'ra_org_pengetahuan_predikat' => $row[43],
                                    'ra_org_pengetahuan_deskripsi' => $row[44],
                                    'ra_pky_pengetahuan_nilai' => $row[48],
                                    'ra_pky_pengetahuan_predikat' => $row[49],
                                    'ra_pky_pengetahuan_deskripsi' => $row[50],
                                    'ra_jwa_pengetahuan_nilai' => $row[21],
                                    'ra_jwa_pengetahuan_predikat' => $row[22],
                                    'ra_jwa_pengetahuan_deskripsi' => $row[23],
                                    'ra_man_pengetahuan_nilai' => $row[24],
                                    'ra_man_pengetahuan_predikat' => $row[25],
                                    'ra_man_pengetahuan_deskripsi' => $row[26],
                                    'ra_tik_pengetahuan_nilai' => $row[27],
                                    'ra_tik_pengetahuan_predikat' => $row[28],
                                    'ra_tik_pengetahuan_deskripsi' => $row[29],
                                    'ra_ekstra1_kegiatan' => ucfirst(strtolower($row[105])),
                                    'ra_ekstra1_nilai' => $row[106],
                                    'ra_ekstra1_predikat' => ucwords($row[107]),
                                    'ra_ekstra2_kegiatan' => $row[108],
                                    'ra_ekstra2_nilai' => $row[109],
                                    'ra_ekstra2_predikat' => ucwords($row[110]),
                                    'ra_ekstra3_kegiatan' => $row[111],
                                    'ra_ekstra3_nilai' => $row[112],
                                    'ra_ekstra3_predikat' => ucwords($row[113]),
                                    'ra_catatan_sakit' => $row[130]!='0' ? $row[130]:'-',
                                    'ra_catatan_ijin' => $row[131]!='0' ? $row[131]:'-',
                                    'ra_catatan_alpha' => $row[132]!='0' ? $row[132]:'-',
                                    'ra_catatan_ayat' => $ayat[0],
                                    'ra_catatan_isi' => $ayat[1],
                                    'ra_catatan_pesan' => $row[134],
                                ]);
                }

                $siswa = null;
            }

        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function  __construct($rapor_id)
    {
        $this->rapor_id= $rapor_id;
    }
}
