<table>
    <thead>
        <tr>
            <!-- <th rowspan="2" style="width:10px; text-align:center; font-weight: bold">Kelas</th> -->
            <th rowspan="2" style="width:15px; text-align:center; font-weight: bold">Code</th>
            <th rowspan="2" style="width:30px; text-align:center; font-weight: bold; vertical-align: middle ">Nama</th>
            @foreach($data['header']['LM'] as $rowheader)
                <th colspan="7" style="width:15px; text-align:center; font-weight: bold">LM {{$rowheader}}</th>
            @endforeach
            <th colspan="3" style="width:10px; text-align:center; font-weight: bold">SAS</th>
            <th rowspan="2" style="width:10px; text-align:center; font-weight: bold">NR</th>
        </tr>
        <tr>
            @foreach($data['header']['LM'] as $rowheader)
                <th style="width:10px; text-align:center; font-weight: bold">Non-Tes</th>
                <th style="width:5px; text-align:center; font-weight: bold">R</th>
                <th style="width:10px; text-align:center; font-weight: bold">NA<br>Non-Tes</th>
                <th style="width:5px; text-align:center; font-weight: bold">Tes</th>
                <th style="width:5px; text-align:center; font-weight: bold">R</th>
                <th style="width:5px; text-align:center; font-weight: bold">NA<br>Tes</th>
                <th style="width:5px; text-align:center; font-weight: bold">NA<br>LM</th>
            @endforeach
            <th style="width:5px; text-align:center; font-weight: bold">TES</th>
            <th style="width:5px; text-align:center; font-weight: bold">R</th>
            <th style="width:5px; text-align:center; font-weight: bold">NA<br>SAS</th>
        </tr>
    </thead>
    <tbody>
        $colstart = 'C';
        $rowstart = 3;
        @foreach($data['siswa'] as $rowsiswa)
            <tr>
                <!-- <td style="text-align:center">{{$rowsiswa['kelas']['kelas_nama']}}/{{$rowsiswa['absen']}}</td> -->
                <td style="text-align:center">{{$rowsiswa['siswa']['s_code']}}</td>
                <td>{{$rowsiswa['siswa']['s_nama']}}</td>
                @foreach($rowsiswa['nilai'] as $rownilai)
                    <td style="text-align:center">{{$rownilai['ns_tugas']}}</td>
                    <td style="text-align:center">{{$rownilai['ns_perbaikan']}}</td>
                    <td style="text-align:center">{{$rownilai['na_nontes']}}</td>
                    <td style="text-align:center">{{$rownilai['ns_tes']}}</td>
                    <td style="text-align:center">{{$rownilai['ns_remidi']}}</td>
                    <td style="text-align:center">{{$rownilai['na_tes']}}</td>
                    <td style="text-align:center">{{$rownilai['na_lm']}}</td>
                @endforeach
                <td style="text-align:center">{{$rowsiswa['SAS']['ns_tes']}}</td>
                <td style="text-align:center">{{$rowsiswa['SAS']['ns_remidi']}}</td>
                <td style="text-align:center">{{$rowsiswa['SAS']['na_sas']}}</td>
                <td style="text-align:center; font-weight: bold">{{$rowsiswa['NR']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
