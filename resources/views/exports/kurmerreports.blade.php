<table>
    <thead>
        <tr>
            <th>Kelas</th>
            <th>Nama</th>
            <th>Code</th>
            <th>NISN</th>
            <th>NIS</th>
            <th>Walikelas</th>
            <th>pak_score</th>
            <th>pak_desc1</th>
            <th>pak_desc2</th>
            <th>pkn_score</th>
            <th>pkn_desc1</th>
            <th>pkn_desc2</th>
            <th>bin_score</th>
            <th>bin_desc1</th>
            <th>bin_desc2</th>
            <th>mat_score</th>
            <th>mat_desc1</th>
            <th>mat_desc2</th>
            <th>ipa_score</th>
            <th>ipa_desc1</th>
            <th>ipa_desc2</th>
            <th>ips_score</th>
            <th>ips_desc1</th>
            <th>ips_desc2</th>
            <th>big_score</th>
            <th>big_desc1</th>
            <th>big_desc2</th>
            <th>org_score</th>
            <th>org_desc1</th>
            <th>org_desc2</th>
            <th>tik_score</th>
            <th>tik_desc1</th>
            <th>tik_desc2</th>
            <th>pil_name</th>
            <th>pil_score</th>
            <th>pil_desc1</th>
            <th>pil_desc2</th>
            <th>jwa_score</th>
            <th>jwa_desc1</th>
            <th>jwa_desc2</th>
            <th>man_score</th>
            <th>man_desc1</th>
            <th>man_desc2</th>
            <th>ekstra1_kegiatan</th>
            <th>ekstra1_nilai</th>
            <th>ekstra1_predikat</th>
            <th>ekstra2_kegiatan</th>
            <th>ekstra2_nilai</th>
            <th>ekstra2_predikat</th>
            <th>ekstra3_kegiatan</th>
            <th>ekstra3_nilai</th>
            <th>ekstra3_predikat</th>
            <th>catatan_sakit</th>
            <th>catatan_ijin</th>
            <th>catatan_alpha</th>
            <th>catatan_ayat</th>
            <th>catatan_isi</th>
            <th>catatan_pesan</th>

        </tr>
    </thead>
    <tbody>
        @foreach($rapor as $row)
            <tr>
                <td style="width:10px">{{$row['kelas']}}/{{$row['absen']}}</td>
                <td style="width:10px">{{$row['siswa']['s_nama']}}</td>
                <td style="width:10px">{{$row['siswa']['s_code']}}</td>
                <td style="width:10px">{{$row['siswa']['s_nisn']}}</td>
                <td style="width:10px">{{$row['siswa']['s_nis']}}</td>
                <td style="width:10px">{{$row['walikelas']}}</td>
                <td style="width:10px">{{$row['PAK']['kmr_score']}}</td>
                <td style="width:10px">{{$row['PAK']['kmr_description1']}}</td>
                <td style="width:10px">{{$row['PAK']['kmr_description2']}}</td>
                <td style="width:10px">{{$row['PKN']['kmr_score']}}</td>
                <td style="width:10px">{{$row['PKN']['kmr_description1']}}</td>
                <td style="width:10px">{{$row['PKN']['kmr_description2']}}</td>
                <td style="width:10px">{{$row['BIN']['kmr_score']}}</td>
                <td style="width:10px">{{$row['BIN']['kmr_description1']}}</td>
                <td style="width:10px">{{$row['BIN']['kmr_description2']}}</td>
                <td style="width:10px">{{$row['MAT']['kmr_score']}}</td>
                <td style="width:10px">{{$row['MAT']['kmr_description1']}}</td>
                <td style="width:10px">{{$row['MAT']['kmr_description2']}}</td>
                <td style="width:10px">{{$row['IPA']['kmr_score']}}</td>
                <td style="width:10px">{{$row['IPA']['kmr_description1']}}</td>
                <td style="width:10px">{{$row['IPA']['kmr_description2']}}</td>
                <td style="width:10px">{{$row['IPS']['kmr_score']}}</td>
                <td style="width:10px">{{$row['IPS']['kmr_description1']}}</td>
                <td style="width:10px">{{$row['IPS']['kmr_description2']}}</td>
                <td style="width:10px">{{$row['BIG']['kmr_score']}}</td>
                <td style="width:10px">{{$row['BIG']['kmr_description1']}}</td>
                <td style="width:10px">{{$row['BIG']['kmr_description2']}}</td>
                <td style="width:10px">{{$row['ORG']['kmr_score']}}</td>
                <td style="width:10px">{{$row['ORG']['kmr_description1']}}</td>
                <td style="width:10px">{{$row['ORG']['kmr_description2']}}</td>
                <td style="width:10px">{{$row['TIK']['kmr_score']}}</td>
                <td style="width:10px">{{$row['TIK']['kmr_description1']}}</td>
                <td style="width:10px">{{$row['TIK']['kmr_description2']}}</td>
                <td style="width:10px">{{$row['pilihan']}}</td>
                <td style="width:10px">{{$row['PIL']['kmr_score']}}</td>
                <td style="width:10px">{{$row['PIL']['kmr_description1']}}</td>
                <td style="width:10px">{{$row['PIL']['kmr_description2']}}</td>
                <td style="width:10px">{{$row['JWA']['kmr_score']}}</td>
                <td style="width:10px">{{$row['JWA']['kmr_description1']}}</td>
                <td style="width:10px">{{$row['JWA']['kmr_description2']}}</td>
                <td style="width:10px">{{$row['MAN']['kmr_score']}}</td>
                <td style="width:10px">{{$row['MAN']['kmr_description1']}}</td>
                <td style="width:10px">{{$row['MAN']['kmr_description2']}}</td>
                <td style="width:10px">{{$row['kmr_extracurricular1']}}</td>
                <td style="width:10px">{{$row['kmr_extracurricular1_score']}}</td>
                <td style="width:10px">{{$row['kmr_extracurricular1_predicate']}}</td>
                <td style="width:10px">{{$row['kmr_extracurricular2']}}</td>
                <td style="width:10px">{{$row['kmr_extracurricular2_score']}}</td>
                <td style="width:10px">{{$row['kmr_extracurricular2_predicate']}}</td>
                <td style="width:10px">{{$row['kmr_extracurricular3']}}</td>
                <td style="width:10px">{{$row['kmr_extracurricular3_score']}}</td>
                <td style="width:10px">{{$row['kmr_extracurricular3_predicate']}}</td>
                <td style="width:10px">{{$row['kmr_attedance_sick']==0?"-":$row['kmr_attedance_sick']}}</td>
                <td style="width:10px">{{$row['kmr_attedance_excuse']==0?"-":$row['kmr_attedance_excuse']}}</td>
                <td style="width:10px">{{$row['kmr_attedance_alpha']==0?"-":$row['kmr_attedance_alpha']}}</td>
                <td style="width:10px">{{$row['kmr_note_verse']}}</td>
                <td style="width:10px">{{$row['kmr_note_godword']}}</td>
                <td style="width:10px">{{$row['kmr_note']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
