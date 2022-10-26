<?php

namespace App\Imports;

use App\RaporSisipan;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Ramsey\Uuid\Uuid;
use App\Siswa;
use App\KelasAnggota;
use App\User;

class RaporSisipansImport implements ToCollection, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row)
        {
            $siswa = Siswa::where('s_nis',$row['2'])->where('unit_id',$this->rapor_id['unit'])->value('id');
            if(!is_null($siswa)){
                $cekdata = null;
                $unit = $this->rapor_id['unit'];
                $cekdata = RaporSisipan::where('siswa_id',$siswa)->where('periode_id', $this->rapor_id['periode'])->first();
                $kelas = KelasAnggota::with('kelas')
                                     ->where('siswa_id',$siswa)
                                     ->where('periode_id', $this->rapor_id['periode'])
                                     ->whereHas('kelas', function($query) use($unit){
                                            $query->where('unit_id',$unit)
                                                ->where('k_jenis', 'REGULER');
                                        })
                                     ->first();
                $walikelas = User::where('id', $kelas->kelas->kelas_wali)->value('full_name');
                if(is_null($cekdata)){
                    RaporSisipan::create([
                        'id'  => Uuid::Uuid4(),
                        'siswa_id' => $siswa,
                        'periode_id' => $this->rapor_id['periode'],
                        'unit_id' =>  $this->rapor_id['unit'],
                        'user_id' =>  $this->rapor_id['user'],
                        'rs_tanggal' => null,
                        'rs_walikelas' => $walikelas ? $walikelas:null,
                        'rs_spiritual_nilai' => null,
                        'rs_spiritual_predikat' => $row[7] ? $row[7]:null,
                        'rs_spiritual_deskripsi' => $row[6] ? $row[6]:null,
                        'rs_sosial_nilai' => null,
                        'rs_sosial_predikat' => $row[9] ? $row[9]:null,
                        'rs_sosial_deskripsi' => $row[8] ? $row[8]:null,
                        'rs_pak_uh1' => $row[109] != '0'? $row[109]:null,
                        'rs_pak_uh2' => $row[110] != '0'? $row[110]:null,
                        'rs_pak_uh3' => $row[111] != '0'? $row[111]:null,
                        'rs_pak_tgs1' => $row[112] != '0'? $row[112]:null,
                        'rs_pak_tgs2' => $row[113] != '0'? $row[113]:null,
                        'rs_pak_tgs3' => $row[114] != '0'? $row[114]:null,
                        'rs_pak_pts' => $row[115] != '0'? $row[115]:null,
                        'rs_pak_prk' => $row[116] != '0'? $row[116]:null,
                        'rs_pak_prd' => $row[118] != '0'? $row[118]:null,
                        'rs_pak_pry' => $row[117] != '0'? $row[117]:null,
                        'rs_pak_prt' => $row[119] != '0'? $row[119]:null,
                        'rs_pkn_uh1' => $row[131] != '0' ? $row[131]:null,
                        'rs_pkn_uh2' => $row[132] != '0' ? $row[132]:null,
                        'rs_pkn_uh3' => $row[133] != '0' ? $row[133]:null,
                        'rs_pkn_tgs1' => $row[134] != '0' ? $row[134]:null,
                        'rs_pkn_tgs2' => $row[135] != '0' ? $row[135]:null,
                        'rs_pkn_tgs3' => $row[136] != '0' ? $row[136]:null,
                        'rs_pkn_pts' => $row[137] != '0' ? $row[137]:null,
                        'rs_pkn_prk' => $row[138] != '0' ? $row[138]:null,
                        'rs_pkn_prd' => $row[140] != '0' ? $row[140]:null,
                        'rs_pkn_pry' => $row[139] != '0' ? $row[139]:null,
                        'rs_pkn_prt' => $row[141] != '0' ? $row[141]:null,
                        'rs_bin_uh1' => $row[10] != '0' ? $row[10]:null,
                        'rs_bin_uh2' => $row[11] != '0' ? $row[11]:null,
                        'rs_bin_uh3' => $row[12] != '0' ? $row[12]:null,
                        'rs_bin_tgs1' => $row[13] != '0' ? $row[13]:null,
                        'rs_bin_tgs2' => $row[14] != '0' ? $row[14]:null,
                        'rs_bin_tgs3' => $row[15] != '0' ? $row[15]:null,
                        'rs_bin_pts' => $row[16] != '0' ? $row[16]:null,
                        'rs_bin_prk' => $row[17] != '0' ? $row[17]:null,
                        'rs_bin_prd' => $row[19] != '0' ? $row[19]:null,
                        'rs_bin_pry' => $row[18] != '0' ? $row[18]:null,
                        'rs_bin_prt' => $row[20] != '0' ? $row[20]:null,
                        'rs_big_uh1' => $row[21] != '0' ? $row[21]:null,
                        'rs_big_uh2' => $row[22] != '0' ? $row[22]:null,
                        'rs_big_uh3' => $row[23] != '0' ? $row[23]:null,
                        'rs_big_tgs1' => $row[24] != '0' ? $row[24]:null,
                        'rs_big_tgs2' => $row[25] != '0' ? $row[25]:null,
                        'rs_big_tgs3' => $row[26] != '0' ? $row[26]:null,
                        'rs_big_pts' => $row[27] != '0' ? $row[27]:null,
                        'rs_big_prk' => $row[28] != '0' ? $row[28]:null,
                        'rs_big_prd' => $row[30] != '0' ? $row[30]:null,
                        'rs_big_pry' => $row[29] != '0' ? $row[29]:null,
                        'rs_big_prt' => $row[31] != '0' ? $row[31]:null,
                        'rs_mat_uh1' => $row[98] != '0' ? $row[98]:null,
                        'rs_mat_uh2' => $row[99] != '0' ? $row[99]:null,
                        'rs_mat_uh3' => $row[100] != '0' ? $row[100]:null,
                        'rs_mat_tgs1' => $row[101] != '0' ? $row[101]:null,
                        'rs_mat_tgs2' => $row[102] != '0' ? $row[102]:null,
                        'rs_mat_tgs3' => $row[103] != '0' ? $row[103]:null,
                        'rs_mat_pts' => $row[104] != '0' ? $row[104]:null,
                        'rs_mat_prk' => $row[105] != '0' ? $row[105]:null,
                        'rs_mat_prd' => $row[107] != '0' ? $row[107]:null,
                        'rs_mat_pry' => $row[106] != '0' ? $row[106]:null,
                        'rs_mat_prt' => $row[108] != '0' ? $row[108]:null,
                        'rs_bio_uh1' => $row[54] != '0' ? $row[54]:null,
                        'rs_bio_uh2' => $row[55] != '0' ? $row[55]:null,
                        'rs_bio_uh3' => $row[56] != '0' ? $row[56]:null,
                        'rs_bio_tgs1' => $row[57] != '0' ? $row[57]:null,
                        'rs_bio_tgs2' => $row[58] != '0' ? $row[58]:null,
                        'rs_bio_tgs3' => $row[59] != '0' ? $row[59]:null,
                        'rs_bio_pts' => $row[60] != '0' ? $row[60]:null,
                        'rs_bio_prk' => $row[61] != '0' ? $row[61]:null,
                        'rs_bio_prd' => $row[63] != '0' ? $row[63]:null,
                        'rs_bio_pry' => $row[62] != '0' ? $row[62]:null,
                        'rs_bio_prt' => $row[64] != '0' ? $row[64]:null,
                        'rs_fis_uh1' => $row[76] != '0' ? $row[76]:null,
                        'rs_fis_uh2' => $row[77] != '0' ? $row[77]:null,
                        'rs_fis_uh3' => $row[78] != '0' ? $row[78]:null,
                        'rs_fis_tgs1' => $row[79] != '0' ? $row[79]:null,
                        'rs_fis_tgs2' => $row[80] != '0' ? $row[80]:null,
                        'rs_fis_tgs3' =>$row[81] != '0' ? $row[81]:null,
                        'rs_fis_pts' => $row[82] != '0' ? $row[82]:null,
                        'rs_fis_prk' => $row[83] != '0' ? $row[83]:null,
                        'rs_fis_prd' => $row[85] != '0' ? $row[85]:null,
                        'rs_fis_pry' => $row[84] != '0' ? $row[84]:null,
                        'rs_fis_prt' => $row[86] != '0' ? $row[86]:null,
                        'rs_geo_uh1' => $row[87] != '0' ? $row[87]:null,
                        'rs_geo_uh2' => $row[88] != '0' ? $row[88]:null,
                        'rs_geo_uh3' => $row[89] != '0' ? $row[89]:null,
                        'rs_geo_tgs1' => $row[90] != '0' ? $row[90]:null,
                        'rs_geo_tgs2' =>$row[91] != '0' ? $row[91]:null,
                        'rs_geo_tgs3' =>$row[92] != '0' ? $row[92]:null,
                        'rs_geo_pts' => $row[93] != '0' ? $row[93]:null,
                        'rs_geo_prk' => $row[94] != '0' ? $row[94]:null,
                        'rs_geo_prd' => $row[96] != '0' ? $row[96]:null,
                        'rs_geo_pry' => $row[95] != '0' ? $row[95]:null,
                        'rs_geo_prt' => $row[97] != '0' ? $row[97]:null,
                        'rs_eko_uh1' => $row[65]!= '0'  ? $row[65]:null,
                        'rs_eko_uh2' => $row[66]!= '0'  ? $row[66]:null,
                        'rs_eko_uh3' => $row[67]!= '0'  ? $row[67]:null,
                        'rs_eko_tgs1' => $row[68]!= '0'  ? $row[68]:null,
                        'rs_eko_tgs2' => $row[69] != '0' ? $row[69]:null,
                        'rs_eko_tgs3' => $row[70] != '0' ? $row[70]:null,
                        'rs_eko_pts' => $row[71] != '0' ? $row[71]:null,
                        'rs_eko_prk' => $row[72] != '0' ? $row[72]:null,
                        'rs_eko_prd' => $row[74] != '0' ? $row[74]:null,
                        'rs_eko_pry' => $row[73] != '0' ? $row[73]:null,
                        'rs_eko_prt' => $row[75] != '0' ? $row[75]:null,
                        'rs_sej_uh1' => $row[153] != '0' ? $row[153]:null,
                        'rs_sej_uh2' => $row[154] != '0' ? $row[154]:null,
                        'rs_sej_uh3' => $row[155] != '0' ? $row[155]:null,
                        'rs_sej_tgs1' => $row[156] != '0' ? $row[156]:null,
                        'rs_sej_tgs2' => $row[157] != '0' ? $row[157]:null,
                        'rs_sej_tgs3' => $row[158] != '0' ? $row[158]:null,
                        'rs_sej_pts' => $row[159] != '0' ? $row[159]:null,
                        'rs_sej_prk' => $row[160] != '0' ? $row[160]:null,
                        'rs_sej_prd' => $row[162] != '0' ? $row[162]:null,
                        'rs_sej_pry' => $row[161] != '0' ? $row[161]:null,
                        'rs_sej_prt' => $row[163] != '0' ? $row[163]:null,
                        'rs_snr_uh1' => $row[175] != '0' ? $row[175]:null,
                        'rs_snr_uh2' => $row[176] != '0' ? $row[176]:null,
                        'rs_snr_uh3' => $row[177] != '0' ? $row[177]:null,
                        'rs_snr_tgs1' => $row[178] != '0' ? $row[178]:null,
                        'rs_snr_tgs2' => $row[179] != '0' ? $row[179]:null,
                        'rs_snr_tgs3' => $row[180] != '0' ? $row[180]:null,
                        'rs_snr_pts' => $row[181] != '0' ? $row[181]:null,
                        'rs_snr_prk' => $row[182] != '0' ? $row[182]:null,
                        'rs_snr_prd' => $row[184] != '0' ? $row[184]:null,
                        'rs_snr_pry' => $row[183] != '0' ? $row[183]:null,
                        'rs_snr_prt' => $row[185] != '0' ? $row[185]:null,
                        'rs_snm_uh1' => $row[164] != '0' ? $row[164]:null,
                        'rs_snm_uh2' => $row[165] != '0' ? $row[165]:null,
                        'rs_snm_uh3' => $row[166] != '0' ? $row[166]:null,
                        'rs_snm_tgs1' => $row[167] != '0' ? $row[167]:null,
                        'rs_snm_tgs2' => $row[168] != '0' ? $row[168]:null,
                        'rs_snm_tgs3' => $row[169] != '0' ? $row[169]:null,
                        'rs_snm_pts' => $row[170] != '0' ? $row[170]:null,
                        'rs_snm_prk' => $row[171] != '0' ? $row[171]:null,
                        'rs_snm_prd' => $row[173] != '0' ? $row[173]:null,
                        'rs_snm_pry' => $row[172] != '0' ? $row[172]:null,
                        'rs_snm_prt' => $row[174] != '0' ? $row[174]:null,
                        'rs_org_uh1' => $row[120] != '0' ? $row[120]:null,
                        'rs_org_uh2' => $row[121] != '0' ? $row[121]:null,
                        'rs_org_uh3' => $row[122] != '0' ? $row[122]:null,
                        'rs_org_tgs1' => $row[123] != '0' ? $row[123]:null,
                        'rs_org_tgs2' => $row[124] != '0' ? $row[124]:null,
                        'rs_org_tgs3' => $row[125] != '0' ? $row[125]:null,
                        'rs_org_pts' => $row[126] != '0' ? $row[126]:null,
                        'rs_org_prk' => $row[127] != '0' ? $row[127]:null,
                        'rs_org_prd' => $row[129] != '0' ? $row[129]:null,
                        'rs_org_pry' => $row[128] != '0' ? $row[128]:null,
                        'rs_org_prt' => $row[130] != '0' ? $row[130]:null,
                        'rs_pky_uh1' => $row[142] != '0' ? $row[142]:null,
                        'rs_pky_uh2' => $row[143] != '0' ? $row[143]:null,
                        'rs_pky_uh3' => $row[144] != '0' ? $row[144]:null,
                        'rs_pky_tgs1' => $row[145] != '0' ? $row[145]:null,
                        'rs_pky_tgs2' => $row[146] != '0' ? $row[146]:null,
                        'rs_pky_tgs3' => $row[147] != '0' ? $row[147]:null,
                        'rs_pky_pts' => $row[148] != '0' ? $row[148]:null,
                        'rs_pky_prk' => $row[149] != '0' ? $row[149]:null,
                        'rs_pky_prd' => $row[151] != '0' ? $row[151]:null,
                        'rs_pky_pry' => $row[150] != '0' ? $row[150]:null,
                        'rs_pky_prt' => $row[152] != '0' ? $row[152]:null,
                        'rs_jwa_uh1' => $row[32] != '0' ? $row[32]:null,
                        'rs_jwa_uh2' => $row[33] != '0' ? $row[33]:null,
                        'rs_jwa_uh3' => $row[34] != '0' ? $row[34]:null,
                        'rs_jwa_tgs1' => $row[35] != '0' ? $row[35]:null,
                        'rs_jwa_tgs2' => $row[36] != '0' ? $row[36]:null,
                        'rs_jwa_tgs3' => $row[37] != '0' ? $row[37]:null,
                        'rs_jwa_pts' => $row[38] != '0' ? $row[38]:null,
                        'rs_jwa_prk' => $row[39] != '0' ? $row[39]:null,
                        'rs_jwa_prd' => $row[41] != '0' ? $row[41]:null,
                        'rs_jwa_pry' => $row[40] != '0' ? $row[40]:null,
                        'rs_jwa_prt' => $row[42] != '0' ? $row[42]:null,
                        'rs_man_uh1' => $row[43] != '0' ? $row[43]:null,
                        'rs_man_uh2' => $row[44] != '0' ? $row[44]:null,
                        'rs_man_uh3' => $row[45] != '0' ? $row[45]:null,
                        'rs_man_tgs1' => $row[46] != '0' ? $row[46]:null,
                        'rs_man_tgs2' => $row[47] != '0' ? $row[47]:null,
                        'rs_man_tgs3' => $row[48] != '0' ? $row[48]:null,
                        'rs_man_pts' => $row[49] != '0' ? $row[49]:null,
                        'rs_man_prk' => $row[50] != '0' ? $row[50]:null,
                        'rs_man_prd' => $row[52] != '0' ? $row[52]:null,
                        'rs_man_pry' => $row[51] != '0' ? $row[51]:null,
                        'rs_man_prt' => $row[53] != '0' ? $row[53]:null,
                        'rs_absensi_sakit' => $row[186] ? $row[186]:null,
                        'rs_absensi_ijin' => $row[187] ? $row[187]:null,
                        'rs_absensi_alpha' => $row[188] ? $row[188]:null,
                        //'rs_catatan_ayat' => $row[178] ? $row[178]:null,
                        //'rs_catatan_isi' => $row[179] ? $row[179]:null,
                        'rs_catatan_pesan' => $row[189] ? $row[189]:null,
                    ]);
                } else {
                    $cekdata->update([
                        'user_id' =>  $this->rapor_id['user'],
                        'rs_tanggal' => null,
                        'rs_walikelas' => $walikelas ? $walikelas:null,
                        'rs_spiritual_nilai' => null,
                        'rs_spiritual_predikat' => $row[7] ? $row[7]:null,
                        'rs_spiritual_deskripsi' => $row[6] ? $row[6]:null,
                        'rs_sosial_nilai' => null,
                        'rs_sosial_predikat' => $row[9] ? $row[9]:null,
                        'rs_sosial_deskripsi' => $row[8] ? $row[8]:null,
                        'rs_pak_uh1' => $row[109] != '0'? $row[109]:null,
                        'rs_pak_uh2' => $row[110] != '0'? $row[110]:null,
                        'rs_pak_uh3' => $row[111] != '0'? $row[111]:null,
                        'rs_pak_tgs1' => $row[112] != '0'? $row[112]:null,
                        'rs_pak_tgs2' => $row[113] != '0'? $row[113]:null,
                        'rs_pak_tgs3' => $row[114] != '0'? $row[114]:null,
                        'rs_pak_pts' => $row[115] != '0'? $row[115]:null,
                        'rs_pak_prk' => $row[116] != '0'? $row[116]:null,
                        'rs_pak_prd' => $row[118] != '0'? $row[118]:null,
                        'rs_pak_pry' => $row[117] != '0'? $row[117]:null,
                        'rs_pak_prt' => $row[119] != '0'? $row[119]:null,
                        'rs_pkn_uh1' => $row[131] != '0' ? $row[131]:null,
                        'rs_pkn_uh2' => $row[132] != '0' ? $row[132]:null,
                        'rs_pkn_uh3' => $row[133] != '0' ? $row[133]:null,
                        'rs_pkn_tgs1' => $row[134] != '0' ? $row[134]:null,
                        'rs_pkn_tgs2' => $row[135] != '0' ? $row[135]:null,
                        'rs_pkn_tgs3' => $row[136] != '0' ? $row[136]:null,
                        'rs_pkn_pts' => $row[137] != '0' ? $row[137]:null,
                        'rs_pkn_prk' => $row[138] != '0' ? $row[138]:null,
                        'rs_pkn_prd' => $row[140] != '0' ? $row[140]:null,
                        'rs_pkn_pry' => $row[139] != '0' ? $row[139]:null,
                        'rs_pkn_prt' => $row[141] != '0' ? $row[141]:null,
                        'rs_bin_uh1' => $row[10] != '0' ? $row[10]:null,
                        'rs_bin_uh2' => $row[11] != '0' ? $row[11]:null,
                        'rs_bin_uh3' => $row[12] != '0' ? $row[12]:null,
                        'rs_bin_tgs1' => $row[13] != '0' ? $row[13]:null,
                        'rs_bin_tgs2' => $row[14] != '0' ? $row[14]:null,
                        'rs_bin_tgs3' => $row[15] != '0' ? $row[15]:null,
                        'rs_bin_pts' => $row[16] != '0' ? $row[16]:null,
                        'rs_bin_prk' => $row[17] != '0' ? $row[17]:null,
                        'rs_bin_prd' => $row[19] != '0' ? $row[19]:null,
                        'rs_bin_pry' => $row[18] != '0' ? $row[18]:null,
                        'rs_bin_prt' => $row[20] != '0' ? $row[20]:null,
                        'rs_big_uh1' => $row[21] != '0' ? $row[21]:null,
                        'rs_big_uh2' => $row[22] != '0' ? $row[22]:null,
                        'rs_big_uh3' => $row[23] != '0' ? $row[23]:null,
                        'rs_big_tgs1' => $row[24] != '0' ? $row[24]:null,
                        'rs_big_tgs2' => $row[25] != '0' ? $row[25]:null,
                        'rs_big_tgs3' => $row[26] != '0' ? $row[26]:null,
                        'rs_big_pts' => $row[27] != '0' ? $row[27]:null,
                        'rs_big_prk' => $row[28] != '0' ? $row[28]:null,
                        'rs_big_prd' => $row[30] != '0' ? $row[30]:null,
                        'rs_big_pry' => $row[29] != '0' ? $row[29]:null,
                        'rs_big_prt' => $row[31] != '0' ? $row[31]:null,
                        'rs_mat_uh1' => $row[98] != '0' ? $row[98]:null,
                        'rs_mat_uh2' => $row[99] != '0' ? $row[99]:null,
                        'rs_mat_uh3' => $row[100] != '0' ? $row[100]:null,
                        'rs_mat_tgs1' => $row[101] != '0' ? $row[101]:null,
                        'rs_mat_tgs2' => $row[102] != '0' ? $row[102]:null,
                        'rs_mat_tgs3' => $row[103] != '0' ? $row[103]:null,
                        'rs_mat_pts' => $row[104] != '0' ? $row[104]:null,
                        'rs_mat_prk' => $row[105] != '0' ? $row[105]:null,
                        'rs_mat_prd' => $row[107] != '0' ? $row[107]:null,
                        'rs_mat_pry' => $row[106] != '0' ? $row[106]:null,
                        'rs_mat_prt' => $row[108] != '0' ? $row[108]:null,
                        'rs_bio_uh1' => $row[54] != '0' ? $row[54]:null,
                        'rs_bio_uh2' => $row[55] != '0' ? $row[55]:null,
                        'rs_bio_uh3' => $row[56] != '0' ? $row[56]:null,
                        'rs_bio_tgs1' => $row[57] != '0' ? $row[57]:null,
                        'rs_bio_tgs2' => $row[58] != '0' ? $row[58]:null,
                        'rs_bio_tgs3' => $row[59] != '0' ? $row[59]:null,
                        'rs_bio_pts' => $row[60] != '0' ? $row[60]:null,
                        'rs_bio_prk' => $row[61] != '0' ? $row[61]:null,
                        'rs_bio_prd' => $row[63] != '0' ? $row[63]:null,
                        'rs_bio_pry' => $row[62] != '0' ? $row[62]:null,
                        'rs_bio_prt' => $row[64] != '0' ? $row[64]:null,
                        'rs_fis_uh1' => $row[76] != '0' ? $row[76]:null,
                        'rs_fis_uh2' => $row[77] != '0' ? $row[77]:null,
                        'rs_fis_uh3' => $row[78] != '0' ? $row[78]:null,
                        'rs_fis_tgs1' => $row[79] != '0' ? $row[79]:null,
                        'rs_fis_tgs2' => $row[80] != '0' ? $row[80]:null,
                        'rs_fis_tgs3' =>$row[81] != '0' ? $row[81]:null,
                        'rs_fis_pts' => $row[82] != '0' ? $row[82]:null,
                        'rs_fis_prk' => $row[83] != '0' ? $row[83]:null,
                        'rs_fis_prd' => $row[85] != '0' ? $row[85]:null,
                        'rs_fis_pry' => $row[84] != '0' ? $row[84]:null,
                        'rs_fis_prt' => $row[86] != '0' ? $row[86]:null,
                        'rs_geo_uh1' => $row[87] != '0' ? $row[87]:null,
                        'rs_geo_uh2' => $row[88] != '0' ? $row[88]:null,
                        'rs_geo_uh3' => $row[89] != '0' ? $row[89]:null,
                        'rs_geo_tgs1' => $row[90] != '0' ? $row[90]:null,
                        'rs_geo_tgs2' =>$row[91] != '0' ? $row[91]:null,
                        'rs_geo_tgs3' =>$row[92] != '0' ? $row[92]:null,
                        'rs_geo_pts' => $row[93] != '0' ? $row[93]:null,
                        'rs_geo_prk' => $row[94] != '0' ? $row[94]:null,
                        'rs_geo_prd' => $row[96] != '0' ? $row[96]:null,
                        'rs_geo_pry' => $row[95] != '0' ? $row[95]:null,
                        'rs_geo_prt' => $row[97] != '0' ? $row[97]:null,
                        'rs_eko_uh1' => $row[65]!= '0'  ? $row[65]:null,
                        'rs_eko_uh2' => $row[66]!= '0'  ? $row[66]:null,
                        'rs_eko_uh3' => $row[67]!= '0'  ? $row[67]:null,
                        'rs_eko_tgs1' => $row[68]!= '0'  ? $row[68]:null,
                        'rs_eko_tgs2' => $row[69] != '0' ? $row[69]:null,
                        'rs_eko_tgs3' => $row[70] != '0' ? $row[70]:null,
                        'rs_eko_pts' => $row[71] != '0' ? $row[71]:null,
                        'rs_eko_prk' => $row[72] != '0' ? $row[72]:null,
                        'rs_eko_prd' => $row[74] != '0' ? $row[74]:null,
                        'rs_eko_pry' => $row[73] != '0' ? $row[73]:null,
                        'rs_eko_prt' => $row[75] != '0' ? $row[75]:null,
                        'rs_sej_uh1' => $row[153] != '0' ? $row[153]:null,
                        'rs_sej_uh2' => $row[154] != '0' ? $row[154]:null,
                        'rs_sej_uh3' => $row[155] != '0' ? $row[155]:null,
                        'rs_sej_tgs1' => $row[156] != '0' ? $row[156]:null,
                        'rs_sej_tgs2' => $row[157] != '0' ? $row[157]:null,
                        'rs_sej_tgs3' => $row[158] != '0' ? $row[158]:null,
                        'rs_sej_pts' => $row[159] != '0' ? $row[159]:null,
                        'rs_sej_prk' => $row[160] != '0' ? $row[160]:null,
                        'rs_sej_prd' => $row[162] != '0' ? $row[162]:null,
                        'rs_sej_pry' => $row[161] != '0' ? $row[161]:null,
                        'rs_sej_prt' => $row[163] != '0' ? $row[163]:null,
                        'rs_snr_uh1' => $row[175] != '0' ? $row[175]:null,
                        'rs_snr_uh2' => $row[176] != '0' ? $row[176]:null,
                        'rs_snr_uh3' => $row[177] != '0' ? $row[177]:null,
                        'rs_snr_tgs1' => $row[178] != '0' ? $row[178]:null,
                        'rs_snr_tgs2' => $row[179] != '0' ? $row[179]:null,
                        'rs_snr_tgs3' => $row[180] != '0' ? $row[180]:null,
                        'rs_snr_pts' => $row[181] != '0' ? $row[181]:null,
                        'rs_snr_prk' => $row[182] != '0' ? $row[182]:null,
                        'rs_snr_prd' => $row[184] != '0' ? $row[184]:null,
                        'rs_snr_pry' => $row[183] != '0' ? $row[183]:null,
                        'rs_snr_prt' => $row[185] != '0' ? $row[185]:null,
                        'rs_snm_uh1' => $row[164] != '0' ? $row[164]:null,
                        'rs_snm_uh2' => $row[165] != '0' ? $row[165]:null,
                        'rs_snm_uh3' => $row[166] != '0' ? $row[166]:null,
                        'rs_snm_tgs1' => $row[167] != '0' ? $row[167]:null,
                        'rs_snm_tgs2' => $row[168] != '0' ? $row[168]:null,
                        'rs_snm_tgs3' => $row[169] != '0' ? $row[169]:null,
                        'rs_snm_pts' => $row[170] != '0' ? $row[170]:null,
                        'rs_snm_prk' => $row[171] != '0' ? $row[171]:null,
                        'rs_snm_prd' => $row[173] != '0' ? $row[173]:null,
                        'rs_snm_pry' => $row[172] != '0' ? $row[172]:null,
                        'rs_snm_prt' => $row[174] != '0' ? $row[174]:null,
                        'rs_org_uh1' => $row[120] != '0' ? $row[120]:null,
                        'rs_org_uh2' => $row[121] != '0' ? $row[121]:null,
                        'rs_org_uh3' => $row[122] != '0' ? $row[122]:null,
                        'rs_org_tgs1' => $row[123] != '0' ? $row[123]:null,
                        'rs_org_tgs2' => $row[124] != '0' ? $row[124]:null,
                        'rs_org_tgs3' => $row[125] != '0' ? $row[125]:null,
                        'rs_org_pts' => $row[126] != '0' ? $row[126]:null,
                        'rs_org_prk' => $row[127] != '0' ? $row[127]:null,
                        'rs_org_prd' => $row[129] != '0' ? $row[129]:null,
                        'rs_org_pry' => $row[128] != '0' ? $row[128]:null,
                        'rs_org_prt' => $row[130] != '0' ? $row[130]:null,
                        'rs_pky_uh1' => $row[142] != '0' ? $row[142]:null,
                        'rs_pky_uh2' => $row[143] != '0' ? $row[143]:null,
                        'rs_pky_uh3' => $row[144] != '0' ? $row[144]:null,
                        'rs_pky_tgs1' => $row[145] != '0' ? $row[145]:null,
                        'rs_pky_tgs2' => $row[146] != '0' ? $row[146]:null,
                        'rs_pky_tgs3' => $row[147] != '0' ? $row[147]:null,
                        'rs_pky_pts' => $row[148] != '0' ? $row[148]:null,
                        'rs_pky_prk' => $row[149] != '0' ? $row[149]:null,
                        'rs_pky_prd' => $row[151] != '0' ? $row[151]:null,
                        'rs_pky_pry' => $row[150] != '0' ? $row[150]:null,
                        'rs_pky_prt' => $row[152] != '0' ? $row[152]:null,
                        'rs_jwa_uh1' => $row[32] != '0' ? $row[32]:null,
                        'rs_jwa_uh2' => $row[33] != '0' ? $row[33]:null,
                        'rs_jwa_uh3' => $row[34] != '0' ? $row[34]:null,
                        'rs_jwa_tgs1' => $row[35] != '0' ? $row[35]:null,
                        'rs_jwa_tgs2' => $row[36] != '0' ? $row[36]:null,
                        'rs_jwa_tgs3' => $row[37] != '0' ? $row[37]:null,
                        'rs_jwa_pts' => $row[38] != '0' ? $row[38]:null,
                        'rs_jwa_prk' => $row[39] != '0' ? $row[39]:null,
                        'rs_jwa_prd' => $row[41] != '0' ? $row[41]:null,
                        'rs_jwa_pry' => $row[40] != '0' ? $row[40]:null,
                        'rs_jwa_prt' => $row[42] != '0' ? $row[42]:null,
                        'rs_man_uh1' => $row[43] != '0' ? $row[43]:null,
                        'rs_man_uh2' => $row[44] != '0' ? $row[44]:null,
                        'rs_man_uh3' => $row[45] != '0' ? $row[45]:null,
                        'rs_man_tgs1' => $row[46] != '0' ? $row[46]:null,
                        'rs_man_tgs2' => $row[47] != '0' ? $row[47]:null,
                        'rs_man_tgs3' => $row[48] != '0' ? $row[48]:null,
                        'rs_man_pts' => $row[49] != '0' ? $row[49]:null,
                        'rs_man_prk' => $row[50] != '0' ? $row[50]:null,
                        'rs_man_prd' => $row[52] != '0' ? $row[52]:null,
                        'rs_man_pry' => $row[51] != '0' ? $row[51]:null,
                        'rs_man_prt' => $row[53] != '0' ? $row[53]:null,
                        'rs_absensi_sakit' => $row[186] ? $row[186]:null,
                        'rs_absensi_ijin' => $row[187] ? $row[187]:null,
                        'rs_absensi_alpha' => $row[188] ? $row[188]:null,
                        //'rs_catatan_ayat' => $row[178] ? $row[178]:null,
                        //'rs_catatan_isi' => $row[179] ? $row[179]:null,
                        'rs_catatan_pesan' => $row[189] ? $row[189]:null
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
