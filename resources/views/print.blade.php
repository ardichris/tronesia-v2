<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Jurnal Mengajar</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body{
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color:#333;
            text-align:left;
            font-size:18px;
            margin:0;
        }
        .container{
            margin:0 auto;
            margin-top:35px;
            padding:40px;
            width:750px;
            height:auto;
            background-color:#fff;
        }
        caption{
            font-size:28px;
            margin-bottom:15px;
        }
        table{
            border:1px solid #333;
            border-collapse:collapse;
            margin:0 auto;
            width:740px;
        }
        td, tr, th{
            padding:12px;
            border:1px solid #333;
            width:185px;
        }
        th{
            background-color: #f0f0f0;
        }
        h4, p{
            margin:0px;
        }
    </style>
</head>
<body>
    <div class="container">
        <center><h1>Laporan Jurnal Mengajar</h1></center>
        Nama Guru : <strong>{{$jurnals->guru}}</strong><br>
        Tanggal :  <strong>{{$jurnals->start}}</strong>
                 s/d  <strong>{{$jurnals->end}}</strong><br>
        <table>
            <thead>
            </thead>
            <tbody>
                <tr>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Kelas</th>
                    <th>KD</th>
                    <th>Materi</th>
                    <th>Catatan</th>
                </tr>
                @foreach ($jurnals->list as $row)
                <tr>
                    <td>{{ $row->jm_tanggal }}</td>
                    <td>{{ $row->jm_jampel }}</td>
                    <td>{{ $row->kelas->kelas_nama }}</td>
                    <td>{{ $row->kompetensi->kd_kode }}</td>
                    <td>{{ $row->jm_materi }}</td>
                    <td>{{ $row->jm_keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
            </tfoot>
        </table>
        Surabaya, {{new Date() | formatDate}}
        <br>
        <br>
        <br>
        <br>
        Yurui, S.Pd., M.M.
    </div>
</body>
</html>