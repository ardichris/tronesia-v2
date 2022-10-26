<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Jurnal Mengajar</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin-top: 5;
            margin-bottom: 5;
        }
        body{
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color:#333;
            text-align:left;
            font-size:10px;
            margin:0;
        }
        .container{
            margin:0 auto;
            margin-top:0px;
            padding:5px;
            width:auto;
            height:auto;
            background-color:#fff;
        }
        table.data caption{
            font-size:18px;
            margin-top:15px;
            margin-bottom:15px;
        }
        table.data {
            border:1px solid #333;
            border-collapse:collapse;
            margin-top:10px;
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
            width: 100%;
            margin:0 auto;
            border: none;
        }
        table.TTD td, tr, th{
            padding:12px;
            border:none;
            width:auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <center><h1>Laporan Jurnal Mengajar</h1></center>
        Nama Guru : <strong>{{$jurnals['guru'][0]}}</strong><br>
        Tanggal :  <strong>{{$jurnals['start']}}</strong>
        s/d  <strong>{{$jurnals['end']}}</strong><br><br>
        <table class="data">
            <thead>
            </thead>
            <tbody>
                <tr>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Kelas</th>
                    <th>Kompetensi</th>
                    <th>Materi</th>
                    <th>Catatan</th>
                </tr>
                @foreach ($jurnals['list'] as $row)
                <tr>
                    <td><p style="text-align:center;">{{\Carbon\Carbon::parse($row->jm_tanggal)->translatedFormat('d F Y')}}</p></td>
                    <td><p style="text-align:center;">{{ $row->jm_jampel }}</p></td>
                    <td><p style="text-align:center;">{{ $row->kelas->kelas_nama }}</p></td>
                    <td><p style="text-align:center;">{{ $row->kompetensi ? $row->kompetensi->kd_kode:'-' }}</p></td>
                    <td>{{ $row->jm_materi }}</td>
                    <td>{{ $row->jm_keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
            </tfoot>
        </table>
        <br>
        <br>
        <table class="TTD">
            <thead>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <p style="text-align:center;"><b>Surabaya, {{$jurnals['tanggal']}}
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        {{$jurnals['signature']}}</b></p>
                    </td>
                </tr>
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
</body>
</html>
