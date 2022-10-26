<table>
    <thead>
        <tr>
            <th rowspan="2" style="width:10px; text-align:center; font-weight: bold">Kelas</th>
            <th rowspan="2" style="width:15px; text-align:center; font-weight: bold">Code</th>
            <th rowspan="2" style="width:30px; text-align:center; font-weight: bold; ">Nama</th>
            @foreach($data['header']['TP'] as $rowheader)
                <th colspan="3" style="width:15px; text-align:center; font-weight: bold">{{$rowheader}}</th>
            @endforeach
            <th colspan="2" style="width:10px; text-align:center; font-weight: bold">STS</th>
            <th colspan="2" style="width:10px; text-align:center; font-weight: bold">SAS</th>
        </tr>
        <tr>
            @foreach($data['header']['TP'] as $rowheader)
                <th style="width:5px; text-align:center; font-weight: bold">TGS</th>
                <th style="width:5px; text-align:center; font-weight: bold">TES</th>
                <th style="width:5px; text-align:center; font-weight: bold">R</th>
            @endforeach
            <th style="width:5px; text-align:center; font-weight: bold">TES</th>
            <th style="width:5px; text-align:center; font-weight: bold">R</th>
            <th style="width:5px; text-align:center; font-weight: bold">TES</th>
            <th style="width:5px; text-align:center; font-weight: bold">R</th>
        <tr>
    </thead>
    <tbody>
        @foreach($data['siswa'] as $rowsiswa)
            <tr>
                <td style="text-align:center">{{$rowsiswa['kelas']['kelas_nama']}}/{{$rowsiswa['absen']}}</td>
                <td style="text-align:center">{{$rowsiswa['siswa']['s_code']}}</td>
                <td>{{$rowsiswa['siswa']['s_nama']}}</td>
                @foreach($rowsiswa['nilai'] as $rownilai)
                    <td style="text-align:center">{{$rownilai['ns_tugas']}}</td>
                    <td style="text-align:center">{{$rownilai['ns_tes']}}</td>
                    <td style="text-align:center">{{$rownilai['ns_remidi']}}</td>
                @endforeach
                <td style="text-align:center">{{$rowsiswa['STS']['ns_tes']}}</td>
                <td style="text-align:center">{{$rowsiswa['STS']['ns_remidi']}}</td>
                <td style="text-align:center">{{$rowsiswa['SAS']['ns_tes']}}</td>
                <td style="text-align:center">{{$rowsiswa['SAS']['ns_remidi']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
