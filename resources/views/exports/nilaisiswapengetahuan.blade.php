<table>
    <thead>
        <tr>
            <!-- <th rowspan="2" style="width:10px; text-align:center; font-weight: bold">Kelas</th> -->
            <th rowspan="2" style="width:15px; text-align:center; font-weight: bold">Code</th>
            <th rowspan="2" style="width:30px; text-align:center; font-weight: bold; vertical-align: middle ">Nama</th>
            @foreach($data['header']['KD'] as $rowheader)
                <th colspan="7" style="width:15px; text-align:center; font-weight: bold">KD {{$rowheader}}</th>
            @endforeach
            <th colspan="3" style="width:10px; text-align:center; font-weight: bold">PTS</th>
            <th colspan="3" style="width:10px; text-align:center; font-weight: bold">PAS</th>
            <th rowspan="2" style="width:10px; text-align:center; font-weight: bold">av<br>PT</th>
            <th rowspan="2" style="width:10px; text-align:center; font-weight: bold">av<br>UH</th>
            <th rowspan="2" style="width:10px; text-align:center; font-weight: bold">NR</th>
        </tr>
        <tr>
            @foreach($data['header']['KD'] as $rowheader)
                <th style="width:5px; text-align:center; font-weight: bold">PT</th>
                <th style="width:5px; text-align:center; font-weight: bold">R</th>
                <th style="width:5px; text-align:center; font-weight: bold">NA<br>PT</th>
                <th style="width:5px; text-align:center; font-weight: bold">UH</th>
                <th style="width:5px; text-align:center; font-weight: bold">R</th>
                <th style="width:5px; text-align:center; font-weight: bold">NA<br>UH</th>
                <th style="width:5px; text-align:center; font-weight: bold">NA<br>KD</th>
            @endforeach
            <th style="width:5px; text-align:center; font-weight: bold">TES</th>
            <th style="width:5px; text-align:center; font-weight: bold">R</th>
            <th style="width:5px; text-align:center; font-weight: bold">NA</th>
            <th style="width:5px; text-align:center; font-weight: bold">TES</th>
            <th style="width:5px; text-align:center; font-weight: bold">R</th>
            <th style="width:5px; text-align:center; font-weight: bold">NA</th>
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
                    <td style="text-align:center">{{$rownilai['na_tgs']}}</td>
                    <td style="text-align:center">{{$rownilai['ns_tes']}}</td>
                    <td style="text-align:center">{{$rownilai['ns_remidi']}}</td>
                    <td style="text-align:center">{{$rownilai['na_tes']}}</td>
                    <td style="text-align:center">{{$rownilai['na_kd']}}</td>
                @endforeach
                <td style="text-align:center">{{$rowsiswa['PTS']['ns_tes']}}</td>
                <td style="text-align:center">{{$rowsiswa['PTS']['ns_remidi']}}</td>
                <td style="text-align:center">{{$rowsiswa['PTS']['na_pts']}}</td>
                <td style="text-align:center">{{$rowsiswa['PAS']['ns_tes']}}</td>
                <td style="text-align:center">{{$rowsiswa['PAS']['ns_remidi']}}</td>
                <td style="text-align:center">{{$rowsiswa['PAS']['na_pas']}}</td>
                <td style="text-align:center; font-weight: bold">{{$rowsiswa['avPT']}}</td>
                <td style="text-align:center; font-weight: bold">{{$rowsiswa['avUH']}}</td>
                <td style="text-align:center; font-weight: bold">{{$rowsiswa['NR']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
