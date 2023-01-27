<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <br><br><title>RAPOR KURIKULUM MERDEKA</title>
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
                margin-top:0;
                padding:5px;
                width:auto;
                height:auto;
                background-color:#fff;
            }
            table.subrapor {
                margin-left: auto;
                margin-right: auto;
                margin-top: 10px;
                font-size: 12px;
                width: 100%;
            }
            table.ki1ki2 {
                font-size:10px;
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
                margin-left: auto;
                margin-right: auto;
                font-size:14px;
                width: 90%;
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
                font-size:12px;
                border: 1px solid black;
                border-collapse: collapse;
                width: 100%;
            }
            table.absensi td, th {
                border: 1px solid black;
                padding: 5px;
                text-align:center;
            }
            table.nilai {
                margin-left:auto;
                margin-right:auto;
                font-size:12px;
                border: 1px solid black;
                border-collapse: collapse;
                width: 100%;
            }
            table.nilai td, th {
                border: 1px solid black;
                padding: 5px;
            }
            table.nilai td.nilai {
                text-align: center;
                font-size:11px;
                /* font-family: Verdana; */
                border: 1px solid black;
                padding: 5px;
            }
            table.nilai td.nilaikkm {
                text-align: center;
                background-color: #ff6666;
                font-size:11px;
                /* font-family: Verdana; */
                border: 1px solid black;
                padding: 5px;
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
                font-size: 12px;
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
        <center><h1 style="font-family:'Verdana'"><b>RAPOR KURIKULUM MERDEKA</b></h1></center>
        <table class="identitas">
            <tr>
                <td style="width:15%">Sekolah</td>
                <td style="width:1%">:</td>
                <td style="padding-left:5px">SMP KRISTEN PETRA 1 SURABAYA</td>
            </tr>
            <tr>
                <td style="width:15%">Nama Siswa</td>
                <td style="width:1%">:</td>
                <td style="padding-left:5px">{{$raporKurmer['nama_siswa']}}</td>
                <td style="width:20%">Fase</td>
                <td style="width:1%">:</td>
                <td style="width:20%; padding-left:5px">D</td>
            </tr>
            <tr>
                <td style="width:15%">Kelas / Absen</td>
                <td style="width:1%">:</td>
                <td style="width:45%; padding-left:5px">{{$raporKurmer['kelas']}} / {{$raporKurmer['absen']}}</td>
                <td style="width:20%">Semester</td>
                <td style="width:1%">:</td>
                <td style="width:20%; padding-left:5px">1 (Satu)</td>
            </tr>
            <tr>
                <td>NIS / NISN</td>
                <td>:</td>
                <td style="padding-left:5px">{{$raporKurmer['nis']}} / {{$raporKurmer['nisn']}}</td>
                <td>Tahun Pelajaran</td>
                <td>:</td>
                <td style="padding-left:5px">2022 - 2023</td>
            </tr>
        </table>
        <table class="subrapor">
            <tr>
                <td style="width:660px; font-weight: bold">A. PENILAIAN AKADEMIK</td>
            </tr>
            <tr>
                <td style="width:660px; padding-left:15px">Kriteria Ketercapaian Tujuan Pembelajaran : 75</td>
            </tr>
        </table>
        <table class="nilai">
            <tr>
                <td style="width:20px; text-align:center; font-weight: bold">No</td>
                <td colspan="2" style="width:150px; text-align:center; font-weight: bold">MATA PELAJARAN</td>
                <td style="width:30px; text-align:center; font-weight: bold">NILAI</td>
                <td style="width:30px; text-align:center; font-weight: bold">PREDIKAT</td>
                <td style="text-align:center; font-weight: bold">DESKRIPSI</td>
            </tr>
            <tr>
                <td style="text-align:center">1</td>
                <td colspan="2">Pendidikan Agama dan Budi Pekerti</td>
                <td class="nilai">{{$raporKurmer['PAK']['kmr_score']}}</td>
                <td style="text-align:center">{{$raporKurmer['PAK']['kmr_predicate']}}</td>
                <td>{{$raporKurmer['PAK']['kmr_description1']}}<br>{{$raporKurmer['PAK']['kmr_description2']}}</td>
            </tr>
            <tr>
                <td style="text-align:center">2</td>
                <td colspan="2">Pendidikan Pancasila dan Kewarganegaraan</td>
                <td class="nilai">{{$raporKurmer['PKN']['kmr_score']}}</td>
                <td style="text-align:center">{{$raporKurmer['PKN']['kmr_predicate']}}</td>
                <td>{{$raporKurmer['PKN']['kmr_description1']}}<br>{{$raporKurmer['PKN']['kmr_description2']}}</td>
            </tr>
            <tr>
                <td style="text-align:center">3</td>
                <td colspan="2">Bahasa Indonesia</td>
                <td class="nilai">{{$raporKurmer['BIN']['kmr_score']}}</td>
                <td style="text-align:center">{{$raporKurmer['BIN']['kmr_predicate']}}</td>
                <td>{{$raporKurmer['BIN']['kmr_description1']}}<br>{{$raporKurmer['BIN']['kmr_description2']}}</td>
            </tr>
            <tr>
                <td style="text-align:center">4</td>
                <td colspan="2">Bahasa Inggris</td>
                <td class="nilai">{{$raporKurmer['BIG']['kmr_score']}}</td>
                <td style="text-align:center">{{$raporKurmer['BIG']['kmr_predicate']}}</td>
                <td>{{$raporKurmer['BIG']['kmr_description1']}}<br>{{$raporKurmer['BIG']['kmr_description2']}}</td>
            </tr>
            <tr>
                <td style="text-align:center">5</td>
                <td colspan="2">Matematika</td>
                <td class="nilai">{{$raporKurmer['MAT']['kmr_score']}}</td>
                <td style="text-align:center">{{$raporKurmer['MAT']['kmr_predicate']}}</td>
                <td>{{$raporKurmer['MAT']['kmr_description1']}}<br>{{$raporKurmer['MAT']['kmr_description2']}}</td>
            </tr>
            <tr>
                <td style="text-align:center">6</td>
                <td colspan="2">Ilmu Pengetahuan Alam</td>
                <td class="nilai">{{$raporKurmer['IPA']['kmr_score']}}</td>
                <td style="text-align:center">{{$raporKurmer['IPA']['kmr_predicate']}}</td>
                <td>{{$raporKurmer['IPA']['kmr_description1']}}<br>{{$raporKurmer['IPA']['kmr_description2']}}</td>
            </tr>
            <tr>
                <td style="text-align:center">7</td>
                <td colspan="2">Ilmu Pengetahuan Sosial</td>
                <td class="nilai">{{$raporKurmer['IPS']['kmr_score']}}</td>
                <td style="text-align:center">{{$raporKurmer['IPS']['kmr_predicate']}}</td>
                <td>{{$raporKurmer['IPS']['kmr_description1']}}<br>{{$raporKurmer['IPS']['kmr_description2']}}</td>
            </tr>
        </table>
    </div>
    <div class="page-break"></div>
    <div class="container">
        <table class="nilai" style="margin-top:50px">
            <tr>
                <td style="width:20px; text-align:center; font-weight: bold">No</td>
                <td colspan="2" style="width:150px; text-align:center; font-weight: bold">MATA PELAJARAN</td>
                <td style="width:30px; text-align:center; font-weight: bold">NILAI</td>
                <td style="width:30px; text-align:center; font-weight: bold">PREDIKAT</td>
                <td style="text-align:center; font-weight: bold">DESKRIPSI</td>
            </tr>
            <tr>
                <td style="text-align:center">8</td>
                <td colspan="2">Mapel Pilihan :<br>{{$raporKurmer['pilihan']}}</td>
                <td class="nilai" style="text-align:center">{{$raporKurmer['PIL']['kmr_score']}}</td>
                <td style="text-align:center">{{$raporKurmer['PIL']['kmr_predicate']}}</td>
                <td>{{$raporKurmer['PIL']['kmr_description1']}}<br>{{$raporKurmer['PIL']['kmr_description2']}}</td>
            </tr>
            <tr>
                <td style="text-align:center">9</td>
                <td colspan="2">Pend. Jasmani, Olah Raga & Kesehatan</td>
                <td class="nilai">{{$raporKurmer['ORG']?$raporKurmer['ORG']['kmr_score']:null}}</td>
                <td style="text-align:center">{{$raporKurmer['ORG']?$raporKurmer['ORG']['kmr_predicate']:null}}</td>
                <td>{{$raporKurmer['ORG']?$raporKurmer['ORG']['kmr_description1']:null}}<br>{{$raporKurmer['ORG']?$raporKurmer['ORG']['kmr_description2']:null}}</td>
            </tr>
            <tr>
                <td style="text-align:center">10</td>
                <td colspan="2">Informatika</td>
                <td class="nilai">{{$raporKurmer['TIK']['kmr_score']}}</td>
                <td style="text-align:center">{{$raporKurmer['TIK']['kmr_predicate']}}</td>
                <td>{{$raporKurmer['TIK']['kmr_description1']}}<br>{{$raporKurmer['TIK']['kmr_description2']}}</td>
            </tr>
            <tr>
                <td style="text-align:center">11</td>
                <td colspan="2">Bahasa Jawa</td>
                <td class="nilai">{{$raporKurmer['JWA']?$raporKurmer['JWA']['kmr_score']:null}}</td>
                <td style="text-align:center">{{$raporKurmer['JWA']?$raporKurmer['JWA']['kmr_predicate']:null}}</td>
                <td>{{$raporKurmer['JWA']?$raporKurmer['JWA']['kmr_description1']:null}}<br>{{$raporKurmer['JWA']?$raporKurmer['JWA']['kmr_description2']:null}}</td>
            </tr>
            <tr>
                <td style="text-align:center">12</td>
                <td colspan="2">Mandarin</td>
                <td class="nilai">{{$raporKurmer['MAN']['kmr_score']}}</td>
                <td style="text-align:center">{{$raporKurmer['MAN']['kmr_predicate']}}</td>
                <td>{{$raporKurmer['MAN']['kmr_description1']}}<br>{{$raporKurmer['MAN']['kmr_description2']}}</td>
            </tr>
        </table>
        <table class="subrapor" style="margin-top:50px">
            <tr>
                <td style="width:675px; font-weight: bold;">B. PENGEMBANGAN DIRI</td>
            </tr>
        </table>
        <table class="absensi">
            <tr>
                <td style="width:5%"><b>No</b></td>
                <td style="width:55%"><b>Jenis Kegiatan</b></td>
                <td style="width:10%"><b>Predikat</b></td>
                <td style="width:30%"><b>Keterangan</b></td>
            </tr>
            <tr>
                <td>1</td>
                <td>{{$raporKurmer['kmr_extracurricular1']?$raporKurmer['kmr_extracurricular1']:null}}</td>
                <td>{{$raporKurmer['kmr_extracurricular1_score']?$raporKurmer['kmr_extracurricular1_score']:null}}</td>
                <td>{{$raporKurmer['kmr_extracurricular1_predicate']?$raporKurmer['kmr_extracurricular1_predicate']:null}}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>{{$raporKurmer['kmr_extracurricular2']?$raporKurmer['kmr_extracurricular2']:null}}</td>
                <td>{{$raporKurmer['kmr_extracurricular2_score']?$raporKurmer['kmr_extracurricular2_score']:null}}</td>
                <td>{{$raporKurmer['kmr_extracurricular2_predicate']?$raporKurmer['kmr_extracurricular2_predicate']:null}}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>{{$raporKurmer['kmr_extracurricular3']?$raporKurmer['kmr_extracurricular3']:null}}</td>
                <td>{{$raporKurmer['kmr_extracurricular3_score']?$raporKurmer['kmr_extracurricular3_score']:null}}</td>
                <td>{{$raporKurmer['kmr_extracurricular3_predicate']?$raporKurmer['kmr_extracurricular3_predicate']:null}}</td>
            </tr>
        </table>

        <table class="subrapor">
            <tr>
                <td style="width:675px; font-weight: bold">C. KETIDAKHADIRAN</td>
            </tr>
        </table>
        <table class="absensi">
            <tr>
                <td style="width:33%"><b>Sakit</b></td>
                <td style="width:33%"><b>Ijin</b></td>
                <td style="width:33%"><b>Tanpa Keterangan</b></td>
            </tr>
            <tr>
                <td>{{$raporKurmer['kmr_attedance_sick']?$raporKurmer['kmr_attedance_sick'].' hari':'-'}}</td>
                <td>{{$raporKurmer['kmr_attedance_excuse']?$raporKurmer['kmr_attedance_excuse'].' hari':'-'}}</td>
                <td>{{$raporKurmer['kmr_attedance_alpha']?$raporKurmer['kmr_attedance_alpha'].' hari':'-'}}</td>
            </tr>
        </table>

        <table class="subrapor">
            <tr>
                <td style="width:675px; font-weight: bold">D. CATATAN WALIKELAS</td>
            </tr>
        </table>
        <table class="nilai">
            <tr>
                <td colspan="3" style="padding: 10px;"><center><i>{{$raporKurmer["kmr_note_godword"]}}</i><br><b>{{$raporKurmer["kmr_note_verse"]}}</b></center><br>{{$raporKurmer["kmr_note"]}}</td>
            </tr>
        </table>
        <table class="TTD">
            <tr>
                <td colspan="2"></td>
                <td style="text-align:left; width:30%">Surabaya, 15 Desember 2022</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:left">Mengetahui,</td>
            </tr>
            <tr>
                <td style="width:30%;">Orang Tua Siswa/Wali</td>
                <td style="width:50%;text-align:center">Walikelas</td>
                <td style="width:20%;">Kepala Sekolah</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><br><br><br><br><br></td>
            </tr>
            <tr>
                <td>..................................</td>
                <td style="text-align:center;">{{$raporKurmer['walikelas']}}</td>
                <td>Yurui, S.Pd., M.M.</td>
            </tr>
        </table>
        <div class="footer">
            <i>{{$raporKurmer['nama_siswa']}} - {{$raporKurmer['kelas']}}/{{$raporKurmer['absen']}}</i>
        </div>
    </div>
</body>
