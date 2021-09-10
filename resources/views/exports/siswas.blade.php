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
            <th>No. Induk</th>
            <th>Nama Siswa</th>
            <th>NISN</th>
            <th>Kelas</th>
            <th>P/L</th>
            <th>Tempat lahir</th>
            <th>Tanggal lahir</th>
            <th>Agama</th>
            <th>Status</th>
            <th>Anak Ke</th>
            <th>Sekolah Asal</th>
            <th>Alamat Domisili</th>
            <th>Nama Ayah</th>
            <th>Pekerjaan Ayah</th>
            <th>Nama Ibu</th>
            <th>Pekerjaan Ibu</th>
            <th>Alamat Kartu Keluarga</th>
            <th>Nama Wali</th>
            <th>Pekerjaan Wali</th>
        </tr>
    </thead>
    <tbody>
        @foreach($siswa as $row)
            <tr>
                <td>{{$row['s_code']}}</td>
                <td>{{$row['s_nis']}}</td>
                <td>{{$row['s_nama']}}</td>
                <td>{{$row['s_nisn']}}</td>
                <td>{{$row['kelas']}}</td>
                <td>{{$row['s_kelamin']}}</td>
                <td>{{$row['s_tempat_lahir']}}</td>
                <td>{{\Carbon\Carbon::parse($row['s_tanggal_lahir'])->format('d/m/Y')}}</td>
                <td>{{$row['s_agama']}}</td>
                <td>{{$row['s_status']}}</td>
                <td>{{$row['s_anak_ke']}}</td>
                <td>{{$row['s_sekolahasal']}}</td>
                <td>{{$row['s_domisili_alamat']}}</td>
                <td>{{$row['s_ayah_nama']}}</td>
                <td>{{$row['s_ayah_pekerjaan']}}</td>
                <td>{{$row['s_ibu_nama']}}</td>
                <td>{{$row['s_ibu_pekerjaan']}}</td>
                <td>{{$row['s_kk_alamat']}}</td>
                <td>{{$row['s_wali_nama']}}</td>
                <td>{{$row['s_wali_pekerjaan']}}</td>

            </tr>
        @endforeach
    </tbody>
</table>