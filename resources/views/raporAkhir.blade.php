<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>LAPORAN HASIL BELAJAR AKHIR SEMESTER</title>
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
                table.nilai {
                    margin-left:auto;
                    margin-right:auto;
                    font-size:13px;
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
            <center><h1 style="font-family:'Verdana'; font-size: 16px">LAPORAN HASIL BELAJAR AKHIR SEMESTER</h1></center>
            <table class="identitas">
                <tr>
                    <td style="width:100px">Nama Sekolah</td>
                    <td style="width:10px">:</td>
                    <td style="width:250px">SMP KRISTEN PETRA 1</td>
                    <td style="width:150px">Kelas</td>
                    <td style="width:10px">:</td>
                    <td style="width:300px">{{$raporAkhir['kelas']['kelas']['kelas_nama']}} / {{$raporAkhir['kelas']['absen']}}</td>

                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>Jl. H.R. Muhammad kav.808</td>
                    <td>Semester</td>
                    <td>:</td>
                    <td>1 (Satu)</td>
                </tr>
                <tr>
                    <td>Nama Siswa</td>
                    <td>:</td>
                    <td>{{$raporAkhir['siswa']['s_nama']}}</td>
                    <td>Tahun Pelajaran</td>
                    <td>:</td>
                    <td>2022 - 2023</td>
                </tr>
                <tr>
                    <td>NIS / NISN</td>
                    <td>:</td>
                    <td>{{$raporAkhir['siswa']['s_nis']}} / {{$raporAkhir['siswa']['s_nisn']}}</td>
                </tr>
            </table>
            <table class="subrapor">
                <tr>
                    <td style="width:675px; font-weight: bold">A. PENILAIAN SIKAP</td>
                </tr>
            </table>
            <table class="nilai">
                <tr style="text-align:center; font-weight: bold">
                    <td style="width:50px">PREDIKAT</td>
                    <td>SPIRITUAL (KI-1)</td>
                </tr>
                <tr>
                    <td style="text-align:center">{{$raporAkhir['ra_spiritual_predikat']}}</td>
                    <td class="nilai" style="text-align:center">{{$raporAkhir['ra_spiritual_deskripsi']}}</td>
                </tr>
            </table>
            <br>
            <table class="nilai">
                <tr style="text-align:center; font-weight: bold">
                    <td style="width:50px">PREDIKAT</td>
                    <td>SOSIAL (KI-2)</td>
                </tr>
                <tr>
                    <td style="text-align:center">{{$raporAkhir['ra_sosial_predikat']}}</td>
                    <td class="nilai" style="text-align:center">{{$raporAkhir['ra_sosial_deskripsi']}}</td>
                </tr>

            </table>
            <table class="subrapor">
                <tr>
                    <td style="width:675px; font-weight: bold">B. PENILAIAN PENGETAHUAN DAN KETERAMPILAN</td>
                </tr>
                <tr>
                    <td style="width:660px; padding-left:15px">Ketuntasan Belajar Minimal : 75</td>
                </tr>
            </table>
            <table class="nilai">
                <tr>
                    <td rowspan="2" style="width:20px; text-align:center; font-weight: bold">No</td>
                    <td rowspan="2" style="width:150px; text-align:center; font-weight: bold">MATA PELAJARAN</td>
                    <td colspan="3" style="text-align:center; font-weight: bold">PENGETAHUAN</td>
                </tr>
                <tr>
                    <td style="width:30px; text-align:center; font-weight: bold">Nilai</td>
                    <td style="width:30px; text-align:center; font-weight: bold">Predikat</td>
                    <td style="text-align:center; font-weight: bold">Deskripsi</td>
                </tr>
                <tr>
                    <td colspan="5" style="font-weight: bold">Kelompok A</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Pendidikan Agama dan Budi Pekerti</td>
                    <td style="text-align:center">{{$raporAkhir['ra_pak_pengetahuan_nilai']}}</td>
                    <td style="text-align:center">{{$raporAkhir['ra_pak_pengetahuan_predikat']}}</td>
                    <td>{!!nl2br($raporAkhir['ra_pak_pengetahuan_deskripsi'])!!}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Pendidikan Pancasila dan Kewarganegaraan</td>
                    <td style="text-align:center">{{$raporAkhir['ra_pkn_pengetahuan_nilai']}}</td>
                    <td style="text-align:center">{{$raporAkhir['ra_pkn_pengetahuan_predikat']}}</td>
                    <td>{!!nl2br($raporAkhir['ra_pkn_pengetahuan_deskripsi'])!!}</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Bahasa Indonesia</td>
                    <td style="text-align:center">{{$raporAkhir['ra_bin_pengetahuan_nilai']}}</td>
                    <td style="text-align:center">{{$raporAkhir['ra_bin_pengetahuan_predikat']}}</td>
                    <td>{!!nl2br($raporAkhir['ra_bin_pengetahuan_deskripsi'])!!}</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Matematika</td>
                    <td style="text-align:center">{{$raporAkhir['ra_mat_pengetahuan_nilai']}}</td>
                    <td style="text-align:center">{{$raporAkhir['ra_mat_pengetahuan_predikat']}}</td>
                    <td>{!!nl2br($raporAkhir['ra_mat_pengetahuan_deskripsi'])!!}</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Ilmu Pengetahuan Alam</td>
                    <td style="text-align:center">{{$raporAkhir['ra_ipa_pengetahuan_nilai']}}</td>
                    <td style="text-align:center">{{$raporAkhir['ra_ipa_pengetahuan_predikat']}}</td>
                    <td>{!!nl2br($raporAkhir['ra_ipa_pengetahuan_deskripsi'])!!}</td>
                </tr>
            </table>
            <br>
            <div class="page-break"></div>
            <div class="container">
                <table class="nilai">
                    <tr>
                        <td rowspan="2" style="width:20px; text-align:center; font-weight: bold">No</td>
                        <td rowspan="2" style="width:150px; text-align:center; font-weight: bold">MATA PELAJARAN</td>
                        <td colspan="3" style="text-align:center; font-weight: bold">PENGETAHUAN</td>
                    </tr>
                    <tr>
                        <td style="width:30px; text-align:center; font-weight: bold">Nilai</td>
                        <td style="width:30px; text-align:center; font-weight: bold">Predikat</td>
                        <td style="text-align:center; font-weight: bold">Deskripsi</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="font-weight: bold">Kelompok A</td>
                    </tr>

                    <tr>
                        <td>6</td>
                        <td>Ilmu Pengetahuan Sosial</td>
                        <td style="text-align:center">{{$raporAkhir['ra_ips_pengetahuan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_ips_pengetahuan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_ips_pengetahuan_deskripsi'])!!}</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Bahasa Inggris</td>
                        <td style="text-align:center">{{$raporAkhir['ra_big_pengetahuan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_big_pengetahuan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_big_pengetahuan_deskripsi'])!!}</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="font-weight: bold">Kelompok B</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>Seni Budaya</td>
                        <td style="text-align:center">{{$raporAkhir['ra_bdy_pengetahuan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_bdy_pengetahuan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_bdy_pengetahuan_deskripsi'])!!}</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>Pendidikan Jasmani dan Kesehatan</td>
                        <td style="text-align:center">{{$raporAkhir['ra_org_pengetahuan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_org_pengetahuan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_org_pengetahuan_deskripsi'])!!}</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>Prakarya</td>
                        <td style="text-align:center">{{$raporAkhir['ra_pky_pengetahuan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_pky_pengetahuan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_pky_pengetahuan_deskripsi'])!!}</td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td>Bahasa Jawa</td>
                        <td style="text-align:center">{{$raporAkhir['ra_jwa_pengetahuan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_jwa_pengetahuan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_jwa_pengetahuan_deskripsi'])!!}</td>
                    </tr>
                    <tr>
                        <td>12</td>
                        <td>Mandarin</td>
                        <td style="text-align:center">{{$raporAkhir['ra_man_pengetahuan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_man_pengetahuan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_man_pengetahuan_deskripsi'])!!}</td>
                    </tr>
                </table>
            </div>
            <div class="footer">
                <i>{{$raporAkhir['siswa']['s_nama']}} - {{$raporAkhir['kelas']['kelas']['kelas_nama']}}/{{$raporAkhir['kelas']['absen']}}</i>
            </div>
            <div class="page-break"></div>
            <div class="container">
                <table class="nilai">
                    <tr>
                        <td rowspan="2" style="width:20px; text-align:center; font-weight: bold">No</td>
                        <td rowspan="2" style="width:150px; text-align:center; font-weight: bold">MATA PELAJARAN</td>
                        <td colspan="3" style="text-align:center; font-weight: bold">KETERAMPILAN</td>
                    </tr>
                    <tr>
                        <td style="width:30px; text-align:center; font-weight: bold">Nilai</td>
                        <td style="width:30px; text-align:center; font-weight: bold">Predikat</td>
                        <td style="text-align:center; font-weight: bold">Deskripsi</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="font-weight: bold">Kelompok A</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Pendidikan Agama dan Budi Pekerti</td>
                        <td style="text-align:center">{{$raporAkhir['ra_pak_keterampilan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_pak_keterampilan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_pak_keterampilan_deskripsi'])!!}</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Pendidikan Pancasila dan Kewarganegaraan</td>
                        <td style="text-align:center">{{$raporAkhir['ra_pkn_keterampilan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_pkn_keterampilan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_pkn_keterampilan_deskripsi'])!!}</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Bahasa Indonesia</td>
                        <td style="text-align:center">{{$raporAkhir['ra_bin_keterampilan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_bin_keterampilan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_bin_keterampilan_deskripsi'])!!}</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Matematika</td>
                        <td style="text-align:center">{{$raporAkhir['ra_mat_keterampilan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_mat_keterampilan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_mat_keterampilan_deskripsi'])!!}</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Ilmu Pengetahuan Alam</td>
                        <td style="text-align:center">{{$raporAkhir['ra_ipa_keterampilan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_ipa_keterampilan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_ipa_keterampilan_deskripsi'])!!}</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Ilmu Pengetahuan Sosial</td>
                        <td style="text-align:center">{{$raporAkhir['ra_ips_keterampilan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_ips_keterampilan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_ips_keterampilan_deskripsi'])!!}</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Bahasa Inggris</td>
                        <td style="text-align:center">{{$raporAkhir['ra_big_keterampilan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_big_keterampilan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_big_keterampilan_deskripsi'])!!}</td>
                    </tr>
                </table>
                </div>
            <div class="footer">
                <i>{{$raporAkhir['siswa']['s_nama']}} - {{$raporAkhir['kelas']['kelas']['kelas_nama']}}/{{$raporAkhir['kelas']['absen']}}</i>
            </div>
            <div class="page-break"></div>
            <div class="container">
                <table class="nilai">
                    <tr>
                        <td rowspan="2" style="width:20px; text-align:center; font-weight: bold">No</td>
                        <td rowspan="2" style="width:150px; text-align:center; font-weight: bold">MATA PELAJARAN</td>
                        <td colspan="3" style="text-align:center; font-weight: bold">KETERAMPILAN</td>
                    </tr>
                    <tr>
                        <td style="width:30px; text-align:center; font-weight: bold">Nilai</td>
                        <td style="width:30px; text-align:center; font-weight: bold">Predikat</td>
                        <td style="text-align:center; font-weight: bold">Deskripsi</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="font-weight: bold">Kelompok B</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>Seni Budaya</td>
                        <td style="text-align:center">{{$raporAkhir['ra_bdy_keterampilan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_bdy_keterampilan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_bdy_keterampilan_deskripsi'])!!}</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>Pendidikan Jasmani dan Kesehatan</td>
                        <td style="text-align:center">{{$raporAkhir['ra_org_keterampilan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_org_keterampilan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_org_keterampilan_deskripsi'])!!}</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>Prakarya</td>
                        <td style="text-align:center">{{$raporAkhir['ra_pky_keterampilan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_pky_keterampilan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_pky_keterampilan_deskripsi'])!!}</td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td>Bahasa Jawa</td>
                        <td style="text-align:center">{{$raporAkhir['ra_jwa_keterampilan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_jwa_keterampilan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_jwa_keterampilan_deskripsi'])!!}</td>
                    </tr>
                    <tr>
                        <td>12</td>
                        <td>Mandarin</td>
                        <td style="text-align:center">{{$raporAkhir['ra_man_keterampilan_nilai']}}</td>
                        <td style="text-align:center">{{$raporAkhir['ra_man_keterampilan_predikat']}}</td>
                        <td>{!!nl2br($raporAkhir['ra_man_keterampilan_deskripsi'])!!}</td>
                    </tr>
                </table>
                <table class="subrapor">
                    <tr>
                        <td style="width:675px; font-weight: bold">C. PENGEMBANGAN DIRI</td>
                    </tr>
                </table>
                <table class="absensi">
                    <tr>
                        <td><b>No</b></td>
                        <td><b>Jenis Kegiatan</b></td>
                        <td><b>Predikat</b></td>
                        <td><b>Keterangan</b></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>{{ucwords(strtolower($raporAkhir['ra_ekstra1_kegiatan']))}}</td>
                        <td>{{$raporAkhir['ra_ekstra1_nilai']}}</td>
                        <td>{{$raporAkhir['ra_ekstra1_predikat']}}</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>{{$raporAkhir['ra_ekstra2_kegiatan']}}</td>
                        <td>{{$raporAkhir['ra_ekstra2_nilai']}}</td>
                        <td>{{$raporAkhir['ra_ekstra2_predikat']}}</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>{{$raporAkhir['ra_ekstra3_kegiatan']}}</td>
                        <td>{{$raporAkhir['ra_ekstra3_nilai']}}</td>
                        <td>{{$raporAkhir['ra_ekstra3_predikat']}}</td>
                    </tr>
                </table>
                <table class="subrapor">
                    <tr>
                        <td style="width:675px; font-weight: bold">D. KETIDAKHADIRAN</td>
                    </tr>
                </table>
                <table class="absensi">
                    <tr>
                        <td style="width:33%"><b>Sakit</b></td>
                        <td style="width:33%"><b>Ijin</b></td>
                        <td style="width:33%"><b>Tanpa Keterangan</b></td>
                    </tr>
                    <tr>
                        <td>{{$raporAkhir['ra_catatan_sakit']>0?raporAkhir['ra_catatan_sakit']+" hari":"-"}}</td>
                        <td>{{$raporAkhir['ra_catatan_ijin']>0?raporAkhir['ra_catatan_ijin']+" hari":"-"}}</td>
                        <td>{{$raporAkhir['ra_catatan_alpha']>0?raporAkhir['ra_catatan_alpha']+" hari":"-"}}</td>
                    </tr>
                </table>
                <table class="subrapor">
                    <tr>
                        <td style="width:675px; font-weight: bold">E. CATATAN WALIKELAS</td>
                    </tr>
                </table>
                <table class="nilai">
                    <tr>
                        <td colspan="3"><center><i>{{$raporAkhir["ra_catatan_isi"]}}</i><br><b>{{$raporAkhir["ra_catatan_ayat"]}}</b></center><br>{{$raporAkhir["ra_catatan_pesan"]}}</td>
                    </tr>
                </table>
                <table class="TTD">
                    <tr>
                        <td colspan="2"></td>
                        <td style="text-align:left; width:30%">Surabaya, 20 Desember 2022</td>
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
                        <td><br><br><br><br></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>..................................</td>
                        <td style="text-align:center;">{{$raporAkhir['walikelas']}}</td>
                        <td>{{$raporAkhir["kasek"]}}</td>
                    </tr>
                </table>
                <div class="footer">
                <i>{{$raporAkhir['siswa']['s_nama']}} - {{$raporAkhir['kelas']['kelas']['kelas_nama']}}/{{$raporAkhir['kelas']['absen']}}</i>
            </div>
            <!-- <div class="page-break"></div>
            <div class="container">

            </div>
            <div class="footer">
                <i>{{$raporAkhir['siswa']['s_nama']}} - {{$raporAkhir['kelas']['kelas']['kelas_nama']}}/{{$raporAkhir['kelas']['absen']}}</i>
            </div> -->
        </div>
    </body>
