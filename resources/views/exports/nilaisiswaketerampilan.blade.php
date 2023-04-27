<table>
    <thead>
        <tr>
            <!-- <th rowspan="2" style="width:10px; text-align:center; font-weight: bold">Kelas</th> -->
            <th rowspan="2" style="width:15px; text-align:center; font-weight: bold">Code</th>
            <th rowspan="2" style="width:30px; text-align:center; font-weight: bold; vertical-align: middle ">Nama</th>
            @foreach($data['header']['KD'] as $rowheader)
                <th colspan="5" style="width:15px; text-align:center; font-weight: bold">KD {{$rowheader}}</th>
            @endforeach
            <th rowspan="2" style="width:10px; text-align:center; font-weight: bold">av<br>PRK</th>
            <th rowspan="2" style="width:10px; text-align:center; font-weight: bold">av<br>PRY</th>
            <th rowspan="2" style="width:10px; text-align:center; font-weight: bold">av<br>PRD</th>
            <th rowspan="2" style="width:10px; text-align:center; font-weight: bold">av<br>PRT</th>
            <th rowspan="2" style="width:10px; text-align:center; font-weight: bold">NR</th>
        </tr>
        <tr>
            @foreach($data['header']['KD'] as $rowheader)
                <th style="width:5px; text-align:center; font-weight: bold">PRK</th>
                <th style="width:5px; text-align:center; font-weight: bold">PRY</th>
                <th style="width:5px; text-align:center; font-weight: bold">PRD</th>
                <th style="width:5px; text-align:center; font-weight: bold">PRT</th>
                <th style="width:5px; text-align:center; font-weight: bold">NA<br>KD</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($data['siswa'] as $rowsiswa)
            <tr>
                <!-- <td style="text-align:center">{{$rowsiswa['kelas']['kelas_nama']}}/{{$rowsiswa['absen']}}</td> -->
                <td style="text-align:center">{{$rowsiswa['siswa']['s_code']}}</td>
                <td>{{$rowsiswa['siswa']['s_nama']}}</td>
                @foreach($rowsiswa['nilai'] as $rownilai)
                    <td style="text-align:center">{{$rownilai['ns_tugas']}}</td>
                    <td style="text-align:center">{{$rownilai['ns_perbaikan']}}</td>
                    <td style="text-align:center">{{$rownilai['ns_tes']}}</td>
                    <td style="text-align:center">{{$rownilai['ns_remidi']}}</td>
                    <td style="text-align:center">{{$rownilai['na_kd']}}</td>
                @endforeach
                <td style="text-align:center; font-weight: bold">{{$rowsiswa['avPRK']}}</td>
                <td style="text-align:center; font-weight: bold">{{$rowsiswa['avPRY']}}</td>
                <td style="text-align:center; font-weight: bold">{{$rowsiswa['avPRD']}}</td>
                <td style="text-align:center; font-weight: bold">{{$rowsiswa['avPRT']}}</td>
                <td style="text-align:center; font-weight: bold">{{$rowsiswa['NR']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
