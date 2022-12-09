<table>
    <thead>
        <tr>
            <th colspan="2"><strong>Daftar Siswa Aktif</strong></th>
        </tr>
        <tr>
            <th colspan="2"></th>
        </tr>
        <tr>
            <th>Kode</th>
            <th>Kelas</th>
            <th>No. Induk</th>
            <th>NISN</th>
            <th>NIK</th>
            <th>Nama Siswa</th>
            <th>P/L</th>
            <th>Tempat lahir</th>
            <th>Tanggal lahir</th>
            <th>Agama</th>
            <th>Status</th>
            <th>Anak Ke</th>
            <th>Sekolah Asal</th>
            <th>Alamat Domisili</th>
            <th>No Telp</th>
            <th>Kontak Ortu</th>
            <th>Nama Ayah</th>
            <th>Pekerjaan Ayah</th>
            <th>Nama Ibu</th>
            <th>Pekerjaan Ibu</th>
            <th>Alamat Orang Tua</th>
            <th>Nama Wali</th>
            <th>No Telp Wali</th>
            <th>Alamat Wali</th>
            <th>Pekerjaan Wali</th>
        </tr>
    </thead>
    <tbody>
        @foreach($siswa as $row)
            <tr>
                <td>{{$row['s_code']}}</td>
                <td>{{$row['kelas']}}/{{$row['absen']}}</td>
                <td>{{$row['s_nis']}}</td>
                <td>{{$row['s_nisn']}}</td>
                <td>'{{$row['s_nik']}}</td>
                <td>{{$row['s_nama']}}</td>
                <td>{{substr($row['s_kelamin'],0,1)}}</td>
                <td>{{$row['s_tempat_lahir']}}</td>
                <td>{{$row['s_tanggal_lahir']}}</td>
                <td>{{$row['s_agama']}}</td>
                <td>{{$row['s_status']}}</td>
                <td>{{$row['s_anak_ke']}}</td>
                <td>{{$row['s_sekolahasal']}}</td>
                <td>{{$row['s_domisili_alamat']}}</td>
                <td>'{{$row['s_notelp']}}</td>
                <td>'{{$row['s_nohandphone']}}</td>
                <td>{{$row['s_ayah_nama']}}</td>
                <td>{{$row['s_ayah_pekerjaan']}}</td>
                <td>{{$row['s_ibu_nama']}}</td>
                <td>{{$row['s_ibu_pekerjaan']}}</td>
                <td>{{$row['s_ortu_alamat']}}</td>
                <td>{{$row['s_wali_nama']}}</td>
                <td>'{{$row['s_wali_notelp']}}</td>
                <td>{{$row['s_wali_alamat']}}</td>
                <td>{{$row['s_wali_pekerjaan']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
