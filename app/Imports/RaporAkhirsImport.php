<?php

namespace App\Imports;

use App\RaporAkhir;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Ramsey\Uuid\Uuid;
use App\Siswa;

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
                        'ra_spiritual_predikat' => $row[11],
                        'ra_spiritual_deskripsi' => $row[12],
                        'ra_sosial_nilai' => null,
                        'ra_sosial_predikat' => $row[13],
                        'ra_sosial_deskripsi' => $row[14],
                        'ra_pak_pengetahuan_nilai' => $row[15],
                        'ra_pak_pengetahuan_predikat' => $row[16],
                        'ra_pak_pengetahuan_deskripsi' => $row[17],
                        'ra_pak_keterampilan_nilai' => $row[18],
                        'ra_pak_keterampilan_predikat' => $row[19],
                        'ra_pak_keterampilan_deskripsi' => $row[20],
                        'ra_pkn_pengetahuan_nilai' => $row[21],
                        'ra_pkn_pengetahuan_predikat' => $row[22],
                        'ra_pkn_pengetahuan_deskripsi' => $row[23],
                        'ra_pkn_keterampilan_nilai' => $row[24],
                        'ra_pkn_keterampilan_predikat' => $row[25],
                        'ra_pkn_keterampilan_deskripsi' => $row[26],
                        'ra_bin_pengetahuan_nilai' => $row[27],
                        'ra_bin_pengetahuan_predikat' => $row[28],
                        'ra_bin_pengetahuan_deskripsi' => $row[29],
                        'ra_bin_keterampilan_nilai' => $row[30],
                        'ra_bin_keterampilan_predikat' => $row[31],
                        'ra_bin_keterampilan_deskripsi' => $row[32],
                        'ra_mat_pengetahuan_nilai' => $row[33],
                        'ra_mat_pengetahuan_predikat' => $row[34],
                        'ra_mat_pengetahuan_deskripsi' => $row[35],
                        'ra_mat_keterampilan_nilai' => $row[36],
                        'ra_mat_keterampilan_predikat' => $row[37],
                        'ra_mat_keterampilan_deskripsi' => $row[38],
                        'ra_ipa_pengetahuan_nilai' => $row[39],
                        'ra_ipa_pengetahuan_predikat' => $row[40],
                        'ra_ipa_pengetahuan_deskripsi' => $row[41],
                        'ra_ipa_keterampilan_nilai' => $row[42],
                        'ra_ipa_keterampilan_predikat' => $row[43],
                        'ra_ipa_keterampilan_deskripsi' => $row[44],
                        'ra_ips_pengetahuan_nilai' => $row[45],
                        'ra_ips_pengetahuan_predikat' => $row[46],
                        'ra_ips_pengetahuan_deskripsi' => $row[47],
                        'ra_ips_keterampilan_nilai' => $row[48],
                        'ra_ips_keterampilan_predikat' => $row[49],
                        'ra_ips_keterampilan_deskripsi' => $row[50],
                        'ra_big_pengetahuan_nilai' => $row[51],
                        'ra_big_pengetahuan_predikat' => $row[52],
                        'ra_big_pengetahuan_deskripsi' => $row[53],
                        'ra_big_keterampilan_nilai' => $row[54],
                        'ra_big_keterampilan_predikat' => $row[55],
                        'ra_big_keterampilan_deskripsi' => $row[56],
                        'ra_bdy_pengetahuan_nilai' => $row[57],
                        'ra_bdy_pengetahuan_predikat' => $row[58],
                        'ra_bdy_pengetahuan_deskripsi' => $row[59],
                        'ra_bdy_keterampilan_nilai' => $row[60],
                        'ra_bdy_keterampilan_predikat' => $row[61],
                        'ra_bdy_keterampilan_deskripsi' => $row[62],
                        'ra_org_pengetahuan_nilai' => $row[63],
                        'ra_org_pengetahuan_predikat' => $row[64],
                        'ra_org_pengetahuan_deskripsi' => $row[65],
                        'ra_org_keterampilan_nilai' => $row[66],
                        'ra_org_keterampilan_predikat' => $row[67],
                        'ra_org_keterampilan_deskripsi' => $row[68],
                        'ra_pky_pengetahuan_nilai' => $row[69],
                        'ra_pky_pengetahuan_predikat' => $row[70],
                        'ra_pky_pengetahuan_deskripsi' => $row[71],
                        'ra_pky_keterampilan_nilai' => $row[72],
                        'ra_pky_keterampilan_predikat' => $row[73],
                        'ra_pky_keterampilan_deskripsi' => $row[74],
                        'ra_jwa_pengetahuan_nilai' => $row[75],
                        'ra_jwa_pengetahuan_predikat' => $row[76],
                        'ra_jwa_pengetahuan_deskripsi' => $row[77],
                        'ra_jwa_keterampilan_nilai' => $row[78],
                        'ra_jwa_keterampilan_predikat' => $row[79],
                        'ra_jwa_keterampilan_deskripsi' => $row[80],
                        'ra_man_pengetahuan_nilai' => $row[81],
                        'ra_man_pengetahuan_predikat' => $row[82],
                        'ra_man_pengetahuan_deskripsi' => $row[83],
                        'ra_man_keterampilan_nilai' => $row[84],
                        'ra_man_keterampilan_predikat' => $row[85],
                        'ra_man_keterampilan_deskripsi' => $row[86],
                        'ra_ekstra1_kegiatan' => $row[87],
                        'ra_ekstra1_nilai' => $row[88],
                        'ra_ekstra1_predikat' => $row[89],
                        'ra_ekstra2_kegiatan' => $row[90],
                        'ra_ekstra2_nilai' => $row[91],
                        'ra_ekstra2_predikat' => $row[92],
                        'ra_ekstra3_kegiatan' => $row[93],
                        'ra_ekstra3_nilai' => $row[94],
                        'ra_ekstra3_predikat' => $row[95],
                        'ra_catatan_sakit' => $row[102]!='0' ? $row[102]:'-',
                        'ra_catatan_ijin' => $row[103]!='0' ? $row[103]:'-',
                        'ra_catatan_alpha' => $row[104]!='0' ? $row[104]:'-',
                        //'ra_catatan_ayat' => $row[105],
                        //'ra_catatan_isi' => $row[106],
                        'ra_catatan_pesan' => $row[105],
                    ]);
                } else {
                    $cekdata->update(['ra_walikelas' => $row[10],
                                    'ra_spiritual_nilai' => null,
                                    'ra_spiritual_predikat' => $row[11],
                                    'ra_spiritual_deskripsi' => $row[12],
                                    'ra_sosial_nilai' => null,
                                    'ra_sosial_predikat' => $row[13],
                                    'ra_sosial_deskripsi' => $row[14],
                                    'ra_pak_pengetahuan_nilai' => $row[15],
                                    'ra_pak_pengetahuan_predikat' => $row[16],
                                    'ra_pak_pengetahuan_deskripsi' => $row[17],
                                    'ra_pak_keterampilan_nilai' => $row[18],
                                    'ra_pak_keterampilan_predikat' => $row[19],
                                    'ra_pak_keterampilan_deskripsi' => $row[20],
                                    'ra_pkn_pengetahuan_nilai' => $row[21],
                                    'ra_pkn_pengetahuan_predikat' => $row[22],
                                    'ra_pkn_pengetahuan_deskripsi' => $row[23],
                                    'ra_pkn_keterampilan_nilai' => $row[24],
                                    'ra_pkn_keterampilan_predikat' => $row[25],
                                    'ra_pkn_keterampilan_deskripsi' => $row[26],
                                    'ra_bin_pengetahuan_nilai' => $row[27],
                                    'ra_bin_pengetahuan_predikat' => $row[28],
                                    'ra_bin_pengetahuan_deskripsi' => $row[29],
                                    'ra_bin_keterampilan_nilai' => $row[30],
                                    'ra_bin_keterampilan_predikat' => $row[31],
                                    'ra_bin_keterampilan_deskripsi' => $row[32],
                                    'ra_mat_pengetahuan_nilai' => $row[33],
                                    'ra_mat_pengetahuan_predikat' => $row[34],
                                    'ra_mat_pengetahuan_deskripsi' => $row[35],
                                    'ra_mat_keterampilan_nilai' => $row[36],
                                    'ra_mat_keterampilan_predikat' => $row[37],
                                    'ra_mat_keterampilan_deskripsi' => $row[38],
                                    'ra_ipa_pengetahuan_nilai' => $row[39],
                                    'ra_ipa_pengetahuan_predikat' => $row[40],
                                    'ra_ipa_pengetahuan_deskripsi' => $row[41],
                                    'ra_ipa_keterampilan_nilai' => $row[42],
                                    'ra_ipa_keterampilan_predikat' => $row[43],
                                    'ra_ipa_keterampilan_deskripsi' => $row[44],
                                    'ra_ips_pengetahuan_nilai' => $row[45],
                                    'ra_ips_pengetahuan_predikat' => $row[46],
                                    'ra_ips_pengetahuan_deskripsi' => $row[47],
                                    'ra_ips_keterampilan_nilai' => $row[48],
                                    'ra_ips_keterampilan_predikat' => $row[49],
                                    'ra_ips_keterampilan_deskripsi' => $row[50],
                                    'ra_big_pengetahuan_nilai' => $row[51],
                                    'ra_big_pengetahuan_predikat' => $row[52],
                                    'ra_big_pengetahuan_deskripsi' => $row[53],
                                    'ra_big_keterampilan_nilai' => $row[54],
                                    'ra_big_keterampilan_predikat' => $row[55],
                                    'ra_big_keterampilan_deskripsi' => $row[56],
                                    'ra_bdy_pengetahuan_nilai' => $row[57],
                                    'ra_bdy_pengetahuan_predikat' => $row[58],
                                    'ra_bdy_pengetahuan_deskripsi' => $row[59],
                                    'ra_bdy_keterampilan_nilai' => $row[60],
                                    'ra_bdy_keterampilan_predikat' => $row[61],
                                    'ra_bdy_keterampilan_deskripsi' => $row[62],
                                    'ra_org_pengetahuan_nilai' => $row[63],
                                    'ra_org_pengetahuan_predikat' => $row[64],
                                    'ra_org_pengetahuan_deskripsi' => $row[65],
                                    'ra_org_keterampilan_nilai' => $row[66],
                                    'ra_org_keterampilan_predikat' => $row[67],
                                    'ra_org_keterampilan_deskripsi' => $row[68],
                                    'ra_pky_pengetahuan_nilai' => $row[69],
                                    'ra_pky_pengetahuan_predikat' => $row[70],
                                    'ra_pky_pengetahuan_deskripsi' => $row[71],
                                    'ra_pky_keterampilan_nilai' => $row[72],
                                    'ra_pky_keterampilan_predikat' => $row[73],
                                    'ra_pky_keterampilan_deskripsi' => $row[74],
                                    'ra_jwa_pengetahuan_nilai' => $row[75],
                                    'ra_jwa_pengetahuan_predikat' => $row[76],
                                    'ra_jwa_pengetahuan_deskripsi' => $row[77],
                                    'ra_jwa_keterampilan_nilai' => $row[78],
                                    'ra_jwa_keterampilan_predikat' => $row[79],
                                    'ra_jwa_keterampilan_deskripsi' => $row[80],
                                    'ra_man_pengetahuan_nilai' => $row[81],
                                    'ra_man_pengetahuan_predikat' => $row[82],
                                    'ra_man_pengetahuan_deskripsi' => $row[83],
                                    'ra_man_keterampilan_nilai' => $row[84],
                                    'ra_man_keterampilan_predikat' => $row[85],
                                    'ra_man_keterampilan_deskripsi' => $row[86],
                                    'ra_ekstra1_kegiatan' => $row[87],
                                    'ra_ekstra1_nilai' => $row[88],
                                    'ra_ekstra1_predikat' => $row[89],
                                    'ra_ekstra2_kegiatan' => $row[90],
                                    'ra_ekstra2_nilai' => $row[91],
                                    'ra_ekstra2_predikat' => $row[92],
                                    'ra_ekstra3_kegiatan' => $row[93],
                                    'ra_ekstra3_nilai' => $row[94],
                                    'ra_ekstra3_predikat' => $row[95],
                                    'ra_catatan_sakit' => $row[102]!='0' ? $row[102]:'-',
                                    'ra_catatan_ijin' => $row[103]!='0' ? $row[103]:'-',
                                    'ra_catatan_alpha' => $row[104]!='0' ? $row[104]:'-',
                                    //'ra_catatan_ayat' => $row[105],
                                    //'ra_catatan_isi' => $row[106],
                                    'ra_catatan_pesan' => $row[105]
                                ]);
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
