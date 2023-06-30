<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>RAPOR PROJEK PENGUATAN PROFIL PELAJAR PANCASILA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style scoped>
            @page {
                    margin-top: 0;
                    margin-bottom: 0;
                }
                .footer {   width: 100%;
                            text-align: left;
                            position: fixed;
                            bottom: 25px;
                            font-size:8px;
                            margin-left: 20px }
                body{
                    font-family:'Gill Sans', 'Gill Sans MT', 'Calibri', 'Trebuchet MS', 'sans-serif';
                    color:#333;
                    text-align:left;
                    font-size:10px;
                    margin-left:0px;
                    margin-top:0px;
                }
                .container{
                    margin-left:0;
                    margin-top:25px;
                    padding:5px;
                    width:auto;
                    height:auto;
                    background-color:#fff;
                }
                table.subrapor {
                    margin-left: auto;
                    margin-right: auto;
                    margin-top: 10px;
                    font-size: 13px;
                    width: 100%;
                }
                table.ki1ki2 {
                    font-size:13px;
                    margin-left: auto;
                    margin-right: auto;
                    margin-top: 7px;
                    margin-bottom: 7px;
                    border: 1px solid black;
                    border-collapse: collapse;
                    width: 90%;
                }
                table.ki1ki2 td, th {
                    border: 1px solid black;
                    padding: 5px;
                }
                table.identitas {
                    margin-left: 40px;
                    margin-bottom: 20px;
                    margin-top: 20px;
                    font-size:14px;
                    width: 95%;
                }
                table.identitas td, th {
                    padding: 0px;
                }
                table.identitas caption{
                    font-size:25px;
                    margin-top:15px;
                    margin-bottom:15px;

                }
                table.absensi {
                    margin-left:auto;
                    margin-right:auto;
                    font-size:13px;
                    border: 1px solid black;
                    border-collapse: collapse;
                    width: 100%;
                }
                table.absensi td, th {
                    border: 1px solid black;
                    padding: 5px;
                    text-align:center;
                }
                table.catatan-proses {
                    margin-left:auto;
                    margin-right:auto;
                    font-size:13px;
                    border-collapse: collapse;
                    width: 100%;
                }
                table.catatan-proses td, th {
                    padding: 5px;
                    text-align: justify
                }

                table.nilai {
                    margin-left:auto;
                    margin-right:auto;
                    font-size:13px;
                    border-collapse: collapse;
                    width: 100%;
                }
                table.nilai td, th {
                    border: 1px solid black;
                    padding: 5px;
                }
                table.nilai td.nilai {
                    text-align: center;
                    font-size:13px;
                    /* font-family: Verdana; */
                    border: 1px solid black;
                    padding: 5px;
                }
                table.nilai td.nilaikkm {
                    text-align: center;
                    background-color: #ff6666;
                    font-size:13px;
                    /* font-family: Verdana; */
                    border: 1px solid black;
                    padding: 5px;
                }
                table.nilai td.project {
                    border-style: none;
                    font-size: 20px;
                    font-family:monospace;

                }

                table.nilai td.score-title {

                }

                table.data caption{
                    font-size:18px;
                    margin-top:15px;
                    margin-bottom:15px;
                }
                table.data {
                    border:1px solid #333;
                    border-collapse:collapse;
                    margin:0 auto;
                    width: 100%;
                }
                table.data td, tr, th{
                    padding:12px;
                    border-collapse:collapse;
                    border:1px solid #333;
                    width:auto;
                }
                table.data th{
                    background-color: #f0f0f0;
                    border-collapse:collapse;
                    border:1px solid #333;
                }
                table.data h4, p{
                    margin:0px;
                }
                table.TTD {
                    font-size: 13px;
                    margin-right: auto;
                    margin-left: auto;
                    margin-top: 15px;
                    border: none;
                    width: 100%;
                }
                table.TTD td, tr, th{
                    padding:3px;
                    width:auto;
                    border: none;

                }
                .page-break {
                    page-break-after: always;
                }

        </style>
    </head>
    <body>
        <div class="container">
            <img src="{{public_path('storage/header/'.$pancasilaReport['unit']['unit_kop'].'.png')}}" style="width: 100%">
            <br>
            <br>
            <center><h3 style="font-family:'Verdana'; font-size: 25px">RAPOR PROJEK PENGUATAN<br>PROFIL PELAJAR PANCASILA</h3></center>
            <table class="identitas">
                <tr>
                    <td style="width:20%">Nama Sekolah</td>
                    <td style="width:3%">:</td>
                    <td style="width:50%">{{$pancasilaReport['unit']['unit_nama']}}</td>
                    <td style="width:15%">Kelas</td>
                    <td style="width:3%">:   </td>
                    <td style="width:15%">{{$pancasilaReport['kelas']['kelas']['kelas_nama']}} / {{$pancasilaReport['kelas']['absen']}}</td>
                </tr>
                <tr>
                    <td style="width:20%">Alamat</td>
                    <td style="width:3%">:   </td>
                    <td style="width:40%">{{$pancasilaReport['unit']['unit_address']}}</td>
                    <td style="width:15%">Fase</td>
                    <td style="width:3%">:   </td>
                    <td style="width:15%">D</td>
                </tr>
                <tr>
                    <td style="width:20%">Nama Siswa</td>
                    <td style="width:3%">:   </td>
                    <td style="width:40%">{{$pancasilaReport['siswa']['s_nama']}}</td>
                    <td style="width:15%">Tahun Ajaran</td>
                    <td style="width:3%">:   </td>
                    <td style="width:15%">2022/2023</td>
                </tr>
                <tr>
                    <td>NISN</td>
                    <td>:</td>
                    <td>{{$pancasilaReport['siswa']['s_nisn']}}</td>
                </tr>
            </table>
            @foreach ($pancasilaReport->pr_project as $row)
                <table class="identitas" style="margin-top:20px">
                    <tr>
                        <td><b>Projek {{$loop->index+1}} | {{$row->pp_name}}</b></td>
                    </tr>
                    <tr>
                        <td>{{$row->pp_desc}}</td>
                    </tr>
                </table>
            @endforeach
            @foreach ($pancasilaReport->pr_project as $rowproject)

                <div class="page-break"></div>
                <table class="nilai" style="margin-top:50px">
                    <tr>
                        <td class="project" colspan=5><b>{{$loop->index+1}}. {{$rowproject->pp_name}}</b></td>
                    <tr>
                        <td class="score-title" style="width:70%; text-align:center"><b>Dimensi dan Elemen</b></td>
                        <td class="score-title" style="text-align:center">MB</td>
                        <td class="score-title" style="text-align:center">SB</td>
                        <td class="score-title" style="text-align:center">BSH</td>
                        <td class="score-title" style="text-align:center">SAB</td>

                    </tr>
                @if($rowproject->element['d1']!=null)
                    <tr>
                        <td colspan="5"  style="padding-left:5px; background-color: #D6EEEE"><b>Beriman, Bertakwa kepada Tuhan Yang Maha Esa, dan Berakhlak Mulia</b></td>
                    </tr>
                    @foreach ($rowproject->element['d1'] as $rowdimensisatu)
                    <tr>
                        <td style="padding-left:15px"><b>{{$rowdimensisatu->pe_subelement==$rowdimensisatu->pe_fased?$rowdimensisatu->pe_element:$rowdimensisatu->pe_subelement}}</b><br>{{$rowdimensisatu->pe_fased}}</td>
                        <td style="text-align:center">@if($rowdimensisatu->score=='MB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensisatu->score=='SB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensisatu->score=='BSH')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensisatu->score=='SAB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                    </tr>
                    @endforeach
                @endif
                @if($rowproject->element['d2']!=null)
                    <tr>
                        <td colspan="5"  style="padding-left:5px; background-color: #D6EEEE"><b>Berkebinekaan Global</b></td>
                    </tr>
                    @foreach ($rowproject->element['d2'] as $rowdimensidua)
                    <tr>
                        <td style="padding-left:15px"><b>{{$rowdimensidua->pe_subelement==$rowdimensidua->pe_fased?$rowdimensidua->pe_element:$rowdimensidua->pe_subelement}}</b><br>{{$rowdimensidua->pe_fased}}</td>
                        <td style="text-align:center">@if($rowdimensidua->score=='MB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensidua->score=='SB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensidua->score=='BSH')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensidua->score=='SAB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                    </tr>
                    @endforeach
                @endif
                @if($rowproject->element['d3']!=null)
                    <tr>
                        <td colspan="5" style="padding-left:5px; background-color: #D6EEEE"><b>Bergotong Royong</b></td>
                    </tr>
                    @foreach ($rowproject->element['d3'] as $rowdimensitiga)
                    <tr>
                        <td style="padding-left:15px"><b>{{$rowdimensitiga->pe_subelement==$rowdimensitiga->pe_fased?$rowdimensitiga->pe_element:$rowdimensitiga->pe_subelement}}</b><br>{{$rowdimensitiga->pe_fased}}</td>
                        <td style="text-align:center">@if($rowdimensitiga->score=='MB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensitiga->score=='SB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensitiga->score=='BSH')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensitiga->score=='SAB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                    </tr>
                    @endforeach
                @endif
                @if($rowproject->element['d4']!=null)
                    <tr>
                        <td colspan="5" style="padding-left:5px; background-color: #D6EEEE"><b>Mandiri</b></td>
                    </tr>
                    @foreach ($rowproject->element['d4'] as $rowdimensiempat)
                    <tr>
                        <td style="padding-left:15px"><b>{{$rowdimensiempat->pe_subelement==$rowdimensiempat->pe_fased?$rowdimensiempat->pe_element:$rowdimensiempat->pe_subelement}}</b><br>{{$rowdimensiempat->pe_fased}}</td>
                        <td style="text-align:center">@if($rowdimensiempat->score=='MB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensiempat->score=='SB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensiempat->score=='BSH')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensiempat->score=='SAB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                    </tr>
                    @endforeach
                @endif
                @if($rowproject->element['d5']!=null)
                    <tr>
                        <td colspan="5" style="padding-left:5px; background-color: #D6EEEE"><b>Bernalar Kritis</b></td>
                    </tr>
                    @foreach ($rowproject->element['d5'] as $rowdimensilima)
                    <tr>
                        <td style="padding-left:15px"><b>{{$rowdimensilima->pe_subelement==$rowdimensilima->pe_fased?$rowdimensilima->pe_element:$rowdimensilima->pe_subelement}}</b><br>{{$rowdimensilima->pe_fased}}</td>
                        <td style="text-align:center">@if($rowdimensilima->score=='MB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensilima->score=='SB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensilima->score=='BSH')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensilima->score=='SAB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                    </tr>
                    @endforeach
                @endif
                @if($rowproject->element['d6']!=null)
                    <tr>
                        <td colspan="5" style="padding-left:5px; background-color: #D6EEEE"><b>Kreatif</b></td>
                    </tr>
                    @foreach ($rowproject->element['d6'] as $rowdimensienam)
                    <tr>
                        <td style="padding-left:15px"><b>{{$rowdimensienam->pe_subelement==$rowdimensienam->pe_fased?$rowdimensienam->pe_element:$rowdimensienam->pe_subelement}}</b><br>{{$rowdimensienam->pe_fased}}</td>
                        <td style="text-align:center">@if($rowdimensienam->score=='MB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensienam->score=='SB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensienam->score=='BSH')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                        <td style="text-align:center">@if($rowdimensienam->score=='SAB')<img src="{{public_path('storage/assets/Check.png')}}" style="width:15px; height:15px">@endif</td>
                    </tr>
                    @endforeach
                @endif
                </table>
                <br>
                <table class="catatan-proses" style="border-style:none">
                    <tr>
                        <td><b>Catatan Proses :</b></td>
                    </tr>
                    <tr>
                        <td>{{$rowproject->comment}}<td>
                    </tr>
                </table>
                <div class="footer">
                    <i>{{$pancasilaReport['siswa']['s_nama']}} - {{$pancasilaReport['kelas']['kelas']['kelas_nama']}}/{{$pancasilaReport['kelas']['absen']}}</i>
                </div>
            @endforeach
            <table class="TTD" style="margin-top:50px">
                    <tr>
                        <td colspan="2"></td>
                        <td style="text-align:left; width:30%">Surabaya, 22 Juni 2023</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align:left">Mengetahui,</td>
                    </tr>
                    <tr>
                        <td>Orang Tua Siswa/Wali</td>
                        <td style="width:50%;text-align:center">Walikelas</td>
                        <td style="width:20%;">Kepala Sekolah</td>
                    </tr>
                    <tr>
                        <td><br><br><br><br><br><br></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>..................................</td>
                        <td style="text-align:center;">{{$pancasilaReport['walikelas']}}</td>
                        <td>{{$pancasilaReport['unit']['unit_head']}}</td>
                    </tr>
                </table>
        </div>
    </body>
