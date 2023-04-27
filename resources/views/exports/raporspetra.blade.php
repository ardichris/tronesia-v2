<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Kelas</th>
            <th>Nama</th>
            <th>Code</th>
            <th>NISN</th>
            <th>NIS</th>
            <th>Walikelas</th>
            <th>physical_desc</th>
            <th>emotional_desc</th>
            <th>talent_desc</th>
            <th>religious_desc</th>
            <!-- <th>religious_desc1</th>
            <th>religious_desc2</th> -->
            <th>academic_desc</th>

        </tr>
    </thead>
    <tbody>
        @foreach($rapor as $row)
            <tr>
                <td>{{$row['id']}}</td>
                <td>{{$row['kelas']}}/{{$row['absen']}}</td>
                <td>{{$row['siswa']['s_nama']}}</td>
                <td>{{$row['siswa']['s_code']}}</td>
                <td>{{$row['siswa']['s_nisn']}}</td>
                <td>{{$row['siswa']['s_nis']}}</td>
                <td>{{$row['walikelas']}}</td>
                <td>{{$row['rp_physical_desc']}}</td>
                <td>{{$row['rp_emotional_desc']}}</td>
                <td>{{$row['rp_talent_desc']}}</td>
                <td>{{$row['rp_religious_desc']}}</td>
                <!-- <td>{{substr($row['rp_religious_desc'],0,200)}}</td>
                <td>{{substr($row['rp_religious_desc'],200,200)}}</td> -->
                <td>{{$row['rp_academic_desc']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
