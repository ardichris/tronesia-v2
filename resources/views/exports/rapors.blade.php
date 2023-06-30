<table>
    <thead>
        <tr>
            <th style="width:10px;">Kelas</th>
            <th style="width:10px;">Nama</th>
            <th style="width:10px;">Code</th>
            <th style="width:10px;">NISN</th>
            <th style="width:10px;">NIS</th>
            <th style="width:10px;">Walikelas</th>
            <th style="width:10px;">spiritual_predikat</th>
            <th style="width:10px;">spiritual_deskripsi</th>
            <th style="width:10px;">sosial_predikat</th>
            <th style="width:10px;">sosial_deskripsi</th>
            <th style="width:10px;">pak_ki3_nilai</th>
            <th style="width:10px;">pak_ki3_predikat</th>
            <th style="width:10px;">pak_ki3_deskripsi</th>
            <th style="width:10px;">pkn_ki3_nilai</th>
            <th style="width:10px;">pkn_ki3_predikat</th>
            <th style="width:10px;">pkn_ki3_deskripsi</th>
            <th style="width:10px;">bin_ki3_nilai</th>
            <th style="width:10px;">bin_ki3_predikat</th>
            <th style="width:10px;">bin_ki3_deskripsi</th>
            <th style="width:10px;">mat_ki3_nilai</th>
            <th style="width:10px;">mat_ki3_predikat</th>
            <th style="width:10px;">mat_ki3_deskripsi</th>
            <th style="width:10px;">ipa_ki3_nilai</th>
            <th style="width:10px;">ipa_ki3_predikat</th>
            <th style="width:10px;">ipa_ki3_deskripsi</th>
            <th style="width:10px;">ips_ki3_nilai</th>
            <th style="width:10px;">ips_ki3_predikat</th>
            <th style="width:10px;">ips_ki3_deskripsi</th>
            <th style="width:10px;">big_ki3_nilai</th>
            <th style="width:10px;">big_ki3_predikat</th>
            <th style="width:10px;">big_ki3_deskripsi</th>
            <th style="width:10px;">bdy_ki3_nilai</th>
            <th style="width:10px;">bdy_ki3_predikat</th>
            <th style="width:10px;">bdy_ki3_deskripsi</th>
            <th style="width:10px;">org_ki3_nilai</th>
            <th style="width:10px;">org_ki3_predikat</th>
            <th style="width:10px;">org_ki3_deskripsi</th>
            <th style="width:10px;">pky_ki3_nilai</th>
            <th style="width:10px;">pky_ki3_predikat</th>
            <th style="width:10px;">pky_ki3_deskripsi</th>
            <th style="width:10px;">snm_ki3_nilai</th>
            <th style="width:10px;">snm_ki3_predikat</th>
            <th style="width:10px;">snm_ki3_deskripsi</th>
            <th style="width:10px;">snr_ki3_nilai</th>
            <th style="width:10px;">snr_ki3_predikat</th>
            <th style="width:10px;">snr_ki3_deskripsi</th>
            <th style="width:10px;">jwa_ki3_nilai</th>
            <th style="width:10px;">jwa_ki3_predikat</th>
            <th style="width:10px;">jwa_ki3_deskripsi</th>
            <th style="width:10px;">man_ki3_nilai</th>
            <th style="width:10px;">man_ki3_predikat</th>
            <th style="width:10px;">man_ki3_deskripsi</th>
            <th style="width:10px;">tik_ki3_nilai</th>
            <th style="width:10px;">tik_ki3_predikat</th>
            <th style="width:10px;">tik_ki3_deskripsi</th>
            <th style="width:10px;">ekstra1_kegiatan</th>
            <th style="width:10px;">ekstra1_nilai</th>
            <th style="width:10px;">ekstra1_predikat</th>
            <th style="width:10px;">ekstra2_kegiatan</th>
            <th style="width:10px;">ekstra2_nilai</th>
            <th style="width:10px;">ekstra2_predikat</th>
            <th style="width:10px;">ekstra3_kegiatan</th>
            <th style="width:10px;">ekstra3_nilai</th>
            <th style="width:10px;">ekstra3_predikat</th>
            <th style="width:10px;">catatan_sakit</th>
            <th style="width:10px;">catatan_ijin</th>
            <th style="width:10px;">catatan_alpha</th>
            <th style="width:10px;">catatan_ayat</th>
            <th style="width:10px;">catatan_isi</th>
            <th style="width:10px;">catatan_pesan</th>

        </tr>
    </thead>
    <tbody>
        @foreach($rapor as $row)
            <tr>
                <td>{{$row['kelas']}}/{{$row['absen']}}</td>
                <td>{{$row['siswa']['s_nama']}}</td>
                <td>{{$row['siswa']['s_code']}}</td>
                <td>{{$row['siswa']['s_nisn']}}</td>
                <td>{{$row['siswa']['s_nis']}}</td>
                <td>{{$row['walikelas']}}</td>
                <td>{{$row['ra_spiritual_predikat']}}</td>
                <td>{{$row['ra_spiritual_deskripsi']}}</td>
                <td>{{$row['ra_sosial_predikat']}}</td>
                <td>{{$row['ra_sosial_deskripsi']}}</td>
                <td>{{$row['ra_pak_pengetahuan_nilai']}}</td>
                <td>{{$row['ra_pak_pengetahuan_predikat']}}</td>
                <td>{{$row['ra_pak_pengetahuan_deskripsi']}}</td>
                <td>{{$row['ra_pkn_pengetahuan_nilai']}}</td>
                <td>{{$row['ra_pkn_pengetahuan_predikat']}}</td>
                <td>{{$row['ra_pkn_pengetahuan_deskripsi']}}</td>
                <td>{{$row['ra_bin_pengetahuan_nilai']}}</td>
                <td>{{$row['ra_bin_pengetahuan_predikat']}}</td>
                <td>{{$row['ra_bin_pengetahuan_deskripsi']}}</td>
                <td>{{$row['ra_mat_pengetahuan_nilai']}}</td>
                <td>{{$row['ra_mat_pengetahuan_predikat']}}</td>
                <td>{{$row['ra_mat_pengetahuan_deskripsi']}}</td>
                <td>{{$row['ra_ipa_pengetahuan_nilai']}}</td>
                <td>{{$row['ra_ipa_pengetahuan_predikat']}}</td>
                <td>{{$row['ra_ipa_pengetahuan_deskripsi']}}</td>
                <td>{{$row['ra_ips_pengetahuan_nilai']}}</td>
                <td>{{$row['ra_ips_pengetahuan_predikat']}}</td>
                <td>{{$row['ra_ips_pengetahuan_deskripsi']}}</td>
                <td>{{$row['ra_big_pengetahuan_nilai']}}</td>
                <td>{{$row['ra_big_pengetahuan_predikat']}}</td>
                <td>{{$row['ra_big_pengetahuan_deskripsi']}}</td>
                <td>{{$row['ra_bdy_pengetahuan_nilai']}}</td>
                <td>{{$row['ra_bdy_pengetahuan_predikat']}}</td>
                <td>{{$row['ra_bdy_pengetahuan_deskripsi']}}</td>
                <td>{{$row['ra_org_pengetahuan_nilai']}}</td>
                <td>{{$row['ra_org_pengetahuan_predikat']}}</td>
                <td>{{$row['ra_org_pengetahuan_deskripsi']}}</td>
                <td>{{$row['ra_pky_pengetahuan_nilai']}}</td>
                <td>{{$row['ra_pky_pengetahuan_predikat']}}</td>
                <td>{{$row['ra_pky_pengetahuan_deskripsi']}}</td>
                <td>{{$row['ra_snm_pengetahuan_nilai']}}</td>
                <td>{{$row['ra_snm_pengetahuan_predikat']}}</td>
                <td>{{$row['ra_snm_pengetahuan_deskripsi']}}</td>
                <td>{{$row['ra_snr_pengetahuan_nilai']}}</td>
                <td>{{$row['ra_snr_pengetahuan_predikat']}}</td>
                <td>{{$row['ra_snr_pengetahuan_deskripsi']}}</td>
                <td>{{$row['ra_jwa_pengetahuan_nilai']}}</td>
                <td>{{$row['ra_jwa_pengetahuan_predikat']}}</td>
                <td>{{$row['ra_jwa_pengetahuan_deskripsi']}}</td>
                <td>{{$row['ra_man_pengetahuan_nilai']}}</td>
                <td>{{$row['ra_man_pengetahuan_predikat']}}</td>
                <td>{{$row['ra_man_pengetahuan_deskripsi']}}</td>
                <td>{{$row['ra_tik_pengetahuan_nilai']}}</td>
                <td>{{$row['ra_tik_pengetahuan_predikat']}}</td>
                <td>{{$row['ra_tik_pengetahuan_deskripsi']}}</td>
                <td>{{$row['ra_ekstra1_kegiatan']}}</td>
                <td>{{$row['ra_ekstra1_nilai']}}</td>
                <td>{{$row['ra_ekstra1_predikat']}}</td>
                <td>{{$row['ra_ekstra2_kegiatan']}}</td>
                <td>{{$row['ra_ekstra2_nilai']}}</td>
                <td>{{$row['ra_ekstra2_predikat']}}</td>
                <td>{{$row['ra_ekstra3_kegiatan']}}</td>
                <td>{{$row['ra_ekstra3_nilai']}}</td>
                <td>{{$row['ra_ekstra3_predikat']}}</td>
                <td>{{$row['ra_catatan_sakit']}}</td>
                <td>{{$row['ra_catatan_ijin']}}</td>
                <td>{{$row['ra_catatan_alpha']}}</td>
                <td>{{$row['ra_catatan_ayat']}}</td>
                <td>{{$row['ra_catatan_isi']}}</td>
                <td>{{$row['ra_catatan_pesan']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
