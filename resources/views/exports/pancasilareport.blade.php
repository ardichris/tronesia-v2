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
            @foreach($rapor['header'] as $rowpp)
                <th style="width:10px;">projek{{$loop->index+1}}-name</th>
                <th style="width:10px;">projek{{$loop->index+1}}-desc</th>
                <th style="width:10px;">projek{{$loop->index+1}}-theme</th>
                <th style="width:10px;">projek{{$loop->index+1}}-comment</th>
                @php
                    $projek='projek'.($loop->index+1)
                @endphp
                @foreach($rowpp['element'] as $rowlpe)
                    @php
                        $dimensi='dimensi'.($loop->index+1)
                    @endphp
                    @if($rowlpe != null)
                        @foreach($rowlpe as $rowpe)
                            <th style="width:10px;">{{$projek}}-{{$dimensi}}-elemen{{$loop->index+1}}-dimension</th>
                            <th style="width:10px;">{{$projek}}-{{$dimensi}}-elemen{{$loop->index+1}}-element</th>
                            <th style="width:10px;">{{$projek}}-{{$dimensi}}-elemen{{$loop->index+1}}-subelement</th>
                            <th style="width:10px;">{{$projek}}-{{$dimensi}}-elemen{{$loop->index+1}}-fased</th>
                            <th style="width:10px;">{{$projek}}-{{$dimensi}}-elemen{{$loop->index+1}}-score</th>
                        @endforeach
                    @endif
                @endforeach
            @endforeach

        </tr>
    </thead>
    <tbody>
        @foreach($rapor['data'] as $row)
            <tr>
                <td>{{$row['id']}}</td>
                <td>{{$row['kelas']}}/{{$row['absen']}}</td>
                <td>{{$row['siswa']['s_nama']}}</td>
                <td>{{$row['siswa']['s_code']}}</td>
                <td>{{$row['siswa']['s_nisn']}}</td>
                <td>{{$row['siswa']['s_nis']}}</td>
                <td>{{$row['walikelas']}}</td>
                @foreach($row['project'] as $rowproject)
                    <td style="width:10px;">{{$rowproject['pp_name']}}</td>
                    <td style="width:10px;">{{$rowproject['pp_desc']}}</td>
                    <td style="width:10px;">{{$rowproject['pp_theme']}}</td>
                    <td style="width:10px;">{{$rowproject['comment']['pc_comment']}}</td>
                    @foreach($rowproject['element'] as $rowlistelement)
                        @if($rowlistelement != null)
                            @foreach($rowlistelement as $rowelement)
                                <td style="width:10px;">{{$rowelement['pe_dimension']}}</td>
                                <td style="width:10px;">{{$rowelement['pe_element']}}</td>
                                <td style="width:10px;">{{$rowelement['pe_subelement']}}</td>
                                <td style="width:10px;">{{$rowelement['pe_fased']}}</td>
                                <td style="width:10px;">{{$rowelement['score']?$rowelement['score']:''}}</td>
                            @endforeach
                        @endif
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
