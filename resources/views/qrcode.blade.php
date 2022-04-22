<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QR Code Siswa</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
       
    </style>
</head>
<body>
    <div class="container">
        @foreach($siswa->chunk(2) as $chunk)
        <div class="col-12 col-sm-6">
            <table style="width: 100%">
                <tr>
            @foreach($chunk as $siswas)
                <td>
                    <div class="card" style="width: 18rem;">
                        <center><img class="card-img-top" src="{{ public_path('storage/qr/'.$siswas['uuid'].'.svg') }}" alt="Card image cap"></center>
                        <div class="card-body">
                            <p class="card-text" style="text-align: center">{{$siswas['s_code']}}<br>{{$siswas['s_nama']}}</p>
                        </div>
                    </div>
                </td>
            @endforeach
            </tr>
            </table>
            </div>
        </div>
        @endforeach
    </div>
</body>
</html>
