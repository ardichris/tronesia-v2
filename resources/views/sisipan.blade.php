<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Hasil Belajar</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin-top: 5;
            margin-bottom: 0;
        }
        body{
            font-family:'Gill Sans', 'Gill Sans MT', 'Calibri', 'Trebuchet MS', 'sans-serif';
            color:#333;
            text-align:left;
            font-size:10px;
            margin:0;
            margin-top:0px;
        }
        .container{
            margin:0 auto;
            margin-top:0;
            padding:5px;
            width:auto;
            height:auto;
            background-color:#fff;
        }
        table.subrapor {
            margin-left: auto;
            margin-right: auto;
            margin-top: 5px;
            font-size: 12px;
        }
        table.ki1ki2 {
            font-size:10px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 7px;
            margin-bottom: 7px;
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }
        table.ki1ki2 td, th {
            border: 1px solid black;
            padding: 5px;
        }
        table.identitas {
            margin-left: auto;
            margin-right: auto;
            font-size:13px;
            font-family: Verdana;
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
        table.nilai {
            margin-left:auto;
            margin-right:auto;
            font-size:11px;
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }
        table.nilai td, th {
            border: 1px solid black;
            padding: 3px;
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
            width: 95%;
        }
        table.TTD td, tr, th{
            padding:1px;
            border:none;
            width:auto;
        }
        td.nilai {
            text-align: center;
            font-size:12px;
            font-family: Verdana;
        }
        td.nilaikkm {
            text-align: center;
            background-color: #ff6666;
            font-size:12px;
            font-family: Verdana;
        }
        td.nomermapel{
            border: none;
            text-align: center;
            width: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{public_path('storage/header/'.$raporSisipan['kop'].'.png')}}" style="width: 100%">
        <center><h1 style="font-family:'Verdana'; font-size: 14px">LAPORAN HASIL BELAJAR TENGAH SEMESTER</h1></center>
        <table class="identitas">
            <tr>
                <td style="width:15%">Nama Siswa</td>
                <td style="width:3%">:</td>
                <td colspan="4">{{$raporSisipan['siswa']['s_nama']}}</td>
            </tr>
            <tr>
                <td style="width:15%">Kelas</td>
                <td style="width:1%">:</td>
                <td style="width:45%">{{$raporSisipan['kelas']['kelas']['kelas_nama']}} / {{$raporSisipan['kelas']['absen']}}</td>
                <td style="width:15%">Semester</td>
                <td style="width:1%">:</td>
                <td style="width:20%">1 (Satu)</td>
            </tr>
            <tr>
                <td>Nomor Induk</td>
                <td>:</td>
                <td>{{$raporSisipan['siswa']['s_nis']}}</td>
                <td>Tahun Pelajaran</td>
                <td>:</td>
                <td>2022 - 2023</td>
            </tr>
        </table>
        <table class="subrapor">
            <tr>
                <td style="width:675px; font-weight: bold">A. PENILAIAN SIKAP</td>
            </tr>
        </table>
        <table class="ki1ki2">
            <tr style="text-align:center; font-weight: bold">
                <td style="width:50px">PREDIKAT</td>
                <td style="width:550px">SPIRITUAL (KI-1)</td>
            </tr>
            <tr>
                <td style="text-align:center">{{$raporSisipan['rs_spiritual_predikat']}}</td>
                <td class="nilai">{{$raporSisipan['rs_spiritual_deskripsi']}}</td>
            </tr>
        </table>
        <table class="ki1ki2">
            <tr style="text-align:center; font-weight: bold">
                <td style="width:50px">PREDIKAT</td>
                <td style="width:550px">SOSIAL (KI-2)</td>
            </tr>
            <tr>
                <td style="text-align:center">{{$raporSisipan['rs_sosial_predikat']}}</td>
                <td class="nilai">{{$raporSisipan['rs_sosial_deskripsi']}}</td>
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
                <td rowspan="3" colspan="3" style="width:20px; text-align:center; font-weight: bold">MATA PELAJARAN</td>
                <td colspan="7" style="text-align:center; font-weight: bold">PENGETAHUAN (KI-3)</td>
                <td colspan="3" style="text-align:center; font-weight: bold">KETERAMPILAN (KI-4)</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center; font-weight: bold">PH-1</td>
                <td colspan="2" style="text-align:center; font-weight: bold">PH-2</td>
                <td colspan="2" style="text-align:center; font-weight: bold">PH-3</td>
                <td rowspan="2" style="text-align:center; width:30px; font-weight: bold">PTS</td>
                <td rowspan="2" style="text-align:center; font-weight: bold">PRAKTIK</td>
                <td rowspan="2" style="text-align:center; font-weight: bold">PRODUK</td>
                <td rowspan="2" style="text-align:center; font-weight: bold">PROYEK</td>
            </tr>
            <tr>
                <td style="width:40px; text-align:center; font-weight: bold">UH-1</td>
                <td style="width:40px; text-align:center; font-weight: bold">TGS-1</td>
                <td style="width:40px; text-align:center; font-weight: bold">UH-2</td>
                <td style="width:40px; text-align:center; font-weight: bold">TGS-2</td>
                <td style="width:40px; text-align:center; font-weight: bold">UH-3</td>
                <td style="width:40px; text-align:center; font-weight: bold">TGS-3</td>
            </tr>
            <tr>
                <td colspan="13" style="font-weight: bold">Kelompok A</td>
            </tr>
            <tr>
                <td class="nomermapel">1.</td>
                <td colspan="2" style="width: 190px">Pendidikan Agama dan Budi Pekerti</td>
                <td class='<?php echo ($raporSisipan["rs_pak_uh1"] > 74 || $raporSisipan["rs_pak_uh1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pak_uh1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pak_tgs1"] > 74 || $raporSisipan["rs_pak_tgs1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pak_tgs1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pak_uh2"] > 74 || $raporSisipan["rs_pak_uh2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pak_uh2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pak_tgs2"] > 74 || $raporSisipan["rs_pak_tgs2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pak_tgs2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pak_uh3"] > 74 || $raporSisipan["rs_pak_uh3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pak_uh3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pak_tgs3"] > 74 || $raporSisipan["rs_pak_tgs3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pak_tgs3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pak_pts"] > 74 || $raporSisipan["rs_pak_pts"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pak_pts']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pak_prk"] > 74 || $raporSisipan["rs_pak_prk"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pak_prk']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pak_prd"] > 74 || $raporSisipan["rs_pak_prd"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pak_prd']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pak_pry"] > 74 || $raporSisipan["rs_pak_pry"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pak_pry']}}</td>
            </tr>
            <tr>
                <td class="nomermapel">2.</td>
                <td colspan="2">Pendidikan Pancasila dan Kewarganegaraan</td>
                <td class='<?php echo ($raporSisipan["rs_pkn_uh1"] > 74 || $raporSisipan["rs_pkn_uh1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pkn_uh1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pkn_tgs1"] > 74 || $raporSisipan["rs_pkn_tgs1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pkn_tgs1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pkn_uh2"] > 74 || $raporSisipan["rs_pkn_uh2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pkn_uh2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pkn_tgs2"] > 74 || $raporSisipan["rs_pkn_tgs2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pkn_tgs2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pkn_uh3"] > 74 || $raporSisipan["rs_pkn_uh3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pkn_uh3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pkn_tgs3"] > 74 || $raporSisipan["rs_pkn_tgs3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pkn_tgs3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pkn_pts"] > 74 || $raporSisipan["rs_pkn_pts"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pkn_pts']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pkn_prk"] > 74 || $raporSisipan["rs_pkn_prk"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pkn_prk']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pkn_prd"] > 74 || $raporSisipan["rs_pkn_prd"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pkn_prd']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pkn_pry"] > 74 || $raporSisipan["rs_pkn_pry"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pkn_pry']}}</td>
            </tr>
            <tr>
                <td class="nomermapel">3.</td>
                <td colspan="2">Bahasa Indonesia</td>
                <td class='<?php echo ($raporSisipan["rs_bin_uh1"] > 74 || $raporSisipan["rs_bin_uh1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bin_uh1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bin_tgs1"] > 74 || $raporSisipan["rs_bin_tgs1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bin_tgs1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bin_uh2"] > 74 || $raporSisipan["rs_bin_uh2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bin_uh2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bin_tgs2"] > 74 || $raporSisipan["rs_bin_tgs2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bin_tgs2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bin_uh3"] > 74 || $raporSisipan["rs_bin_uh3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bin_uh3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bin_tgs3"] > 74 || $raporSisipan["rs_bin_tgs3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bin_tgs3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bin_pts"] > 74 || $raporSisipan["rs_bin_pts"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bin_pts']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bin_prk"] > 74 || $raporSisipan["rs_bin_prk"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bin_prk']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bin_prd"] > 74 || $raporSisipan["rs_bin_prd"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bin_prd']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bin_pry"] > 74 || $raporSisipan["rs_bin_pry"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bin_pry']}}</td>


            </tr>
            <tr>
                <td class="nomermapel">4.</td>
                <td colspan="2">Bahasa Inggris</td>
                <td class='<?php echo ($raporSisipan["rs_big_uh1"] > 74 || $raporSisipan["rs_big_uh1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_big_uh1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_big_tgs1"] > 74 || $raporSisipan["rs_big_tgs1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_big_tgs1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_big_uh2"] > 74 || $raporSisipan["rs_big_uh2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_big_uh2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_big_tgs2"] > 74 || $raporSisipan["rs_big_tgs2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_big_tgs2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_big_uh3"] > 74 || $raporSisipan["rs_big_uh3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_big_uh3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_big_tgs3"] > 74 || $raporSisipan["rs_big_tgs3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_big_tgs3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_big_pts"] > 74 || $raporSisipan["rs_big_pts"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_big_pts']}}</td>
                <td class='<?php echo ($raporSisipan["rs_big_prk"] > 74 || $raporSisipan["rs_big_prk"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_big_prk']}}</td>
                <td class='<?php echo ($raporSisipan["rs_big_prd"] > 74 || $raporSisipan["rs_big_prd"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_big_prd']}}</td>
                <td class='<?php echo ($raporSisipan["rs_big_pry"] > 74 || $raporSisipan["rs_big_pry"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_big_pry']}}</td>
            </tr>
            <tr>
                <td class="nomermapel">5.</td>
                <td colspan="2">Matematika</td>
                <td class='<?php echo ($raporSisipan["rs_mat_uh1"] > 74 || $raporSisipan["rs_mat_uh1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_mat_uh1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_mat_tgs1"] > 74 || $raporSisipan["rs_mat_tgs1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_mat_tgs1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_mat_uh2"] > 74 || $raporSisipan["rs_mat_uh2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_mat_uh2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_mat_tgs2"] > 74 || $raporSisipan["rs_mat_tgs2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_mat_tgs2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_mat_uh3"] > 74 || $raporSisipan["rs_mat_uh3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_mat_uh3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_mat_tgs3"] > 74 || $raporSisipan["rs_mat_tgs3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_mat_tgs3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_mat_pts"] > 74 || $raporSisipan["rs_mat_pts"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_mat_pts']}}</td>
                <td class='<?php echo ($raporSisipan["rs_mat_prk"] > 74 || $raporSisipan["rs_mat_prk"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_mat_prk']}}</td>
                <td class='<?php echo ($raporSisipan["rs_mat_prd"] > 74 || $raporSisipan["rs_mat_prd"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_mat_prd']}}</td>
                <td class='<?php echo ($raporSisipan["rs_mat_pry"] > 74 || $raporSisipan["rs_mat_pry"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_mat_pry']}}</td>
            </tr>
            <tr>
                <td class="nomermapel" rowspan="2">6.</td>
                <td rowspan="2" style="width:50px;">IPA</td>
                <td>Biologi</td>
                <td class='<?php echo ($raporSisipan["rs_bio_uh1"] > 74 || $raporSisipan["rs_bio_uh1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bio_uh1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bio_tgs1"] > 74 || $raporSisipan["rs_bio_tgs1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bio_tgs1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bio_uh2"] > 74 || $raporSisipan["rs_bio_uh2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bio_uh2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bio_tgs2"] > 74 || $raporSisipan["rs_bio_tgs2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bio_tgs2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bio_uh3"] > 74 || $raporSisipan["rs_bio_uh3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bio_uh3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bio_tgs3"] > 74 || $raporSisipan["rs_bio_tgs3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bio_tgs3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bio_pts"] > 74 || $raporSisipan["rs_bio_pts"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bio_pts']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bio_prk"] > 74 || $raporSisipan["rs_bio_prk"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bio_prk']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bio_prd"] > 74 || $raporSisipan["rs_bio_prd"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bio_prd']}}</td>
                <td class='<?php echo ($raporSisipan["rs_bio_pry"] > 74 || $raporSisipan["rs_bio_pry"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_bio_pry']}}</td>
            </tr>
            <tr>
                <td>Fisika</td>
                <td class='<?php echo ($raporSisipan["rs_fis_uh1"] > 74 || $raporSisipan["rs_fis_uh1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_fis_uh1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_fis_tgs1"] > 74 || $raporSisipan["rs_fis_tgs1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_fis_tgs1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_fis_uh2"] > 74 || $raporSisipan["rs_fis_uh2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_fis_uh2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_fis_tgs2"] > 74 || $raporSisipan["rs_fis_tgs2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_fis_tgs2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_fis_uh3"] > 74 || $raporSisipan["rs_fis_uh3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_fis_uh3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_fis_tgs3"] > 74 || $raporSisipan["rs_fis_tgs3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_fis_tgs3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_fis_pts"] > 74 || $raporSisipan["rs_fis_pts"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_fis_pts']}}</td>
                <td class='<?php echo ($raporSisipan["rs_fis_prk"] > 74 || $raporSisipan["rs_fis_prk"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_fis_prk']}}</td>
                <td class='<?php echo ($raporSisipan["rs_fis_prd"] > 74 || $raporSisipan["rs_fis_prd"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_fis_prd']}}</td>
                <td class='<?php echo ($raporSisipan["rs_fis_pry"] > 74 || $raporSisipan["rs_fis_pry"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_fis_pry']}}</td>
            </tr>
            <tr>
                <td class="nomermapel" rowspan="3">7.</td>
                <td rowspan="3">IPS</td>
                <td>Geografi</td>
                <td class='<?php echo ($raporSisipan["rs_geo_uh1"] > 74 || $raporSisipan["rs_geo_uh1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_geo_uh1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_geo_tgs1"] > 74 || $raporSisipan["rs_geo_tgs1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_geo_tgs1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_geo_uh2"] > 74 || $raporSisipan["rs_geo_uh2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_geo_uh2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_geo_tgs2"] > 74 || $raporSisipan["rs_geo_tgs2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_geo_tgs2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_geo_uh3"] > 74 || $raporSisipan["rs_geo_uh3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_geo_uh3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_geo_tgs3"] > 74 || $raporSisipan["rs_geo_tgs3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_geo_tgs3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_geo_pts"] > 74 || $raporSisipan["rs_geo_pts"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_geo_pts']}}</td>
                <td class='<?php echo ($raporSisipan["rs_geo_prk"] > 74 || $raporSisipan["rs_geo_prk"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_geo_prk']}}</td>
                <td class='<?php echo ($raporSisipan["rs_geo_prd"] > 74 || $raporSisipan["rs_geo_prd"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_geo_prd']}}</td>
                <td class='<?php echo ($raporSisipan["rs_geo_pry"] > 74 || $raporSisipan["rs_geo_pry"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_geo_pry']}}</td>
            </tr>
            <tr>
                <td>Ekonomi</td>
                <td class='<?php echo ($raporSisipan["rs_eko_uh1"] > 74 || $raporSisipan["rs_eko_uh1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_eko_uh1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_eko_tgs1"] > 74 || $raporSisipan["rs_eko_tgs1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_eko_tgs1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_eko_uh2"] > 74 || $raporSisipan["rs_eko_uh2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_eko_uh2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_eko_tgs2"] > 74 || $raporSisipan["rs_eko_tgs2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_eko_tgs2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_eko_uh3"] > 74 || $raporSisipan["rs_eko_uh3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_eko_uh3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_eko_tgs3"] > 74 || $raporSisipan["rs_eko_tgs3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_eko_tgs3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_eko_pts"] > 74 || $raporSisipan["rs_eko_pts"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_eko_pts']}}</td>
                <td class='<?php echo ($raporSisipan["rs_eko_prk"] > 74 || $raporSisipan["rs_eko_prk"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_eko_prk']}}</td>
                <td class='<?php echo ($raporSisipan["rs_eko_prd"] > 74 || $raporSisipan["rs_eko_prd"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_eko_prd']}}</td>
                <td class='<?php echo ($raporSisipan["rs_eko_pry"] > 74 || $raporSisipan["rs_eko_pry"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_eko_pry']}}</td>
            </tr>
            <tr>
                <td>Sejarah</td>
                <td class='<?php echo ($raporSisipan["rs_sej_uh1"] > 74 || $raporSisipan["rs_sej_uh1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_sej_uh1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_sej_tgs1"] > 74 || $raporSisipan["rs_sej_tgs1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_sej_tgs1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_sej_uh2"] > 74 || $raporSisipan["rs_sej_uh2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_sej_uh2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_sej_tgs2"] > 74 || $raporSisipan["rs_sej_tgs2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_sej_tgs2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_sej_uh3"] > 74 || $raporSisipan["rs_sej_uh3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_sej_uh3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_sej_tgs3"] > 74 || $raporSisipan["rs_sej_tgs3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_sej_tgs3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_sej_pts"] > 74 || $raporSisipan["rs_sej_pts"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_sej_pts']}}</td>
                <td class='<?php echo ($raporSisipan["rs_sej_prk"] > 74 || $raporSisipan["rs_sej_prk"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_sej_prk']}}</td>
                <td class='<?php echo ($raporSisipan["rs_sej_prd"] > 74 || $raporSisipan["rs_sej_prd"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_sej_prd']}}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="13" style="font-weight: bold">Kelompok B</td>
            </tr>
            <tr>
                <td class="nomermapel" rowspan="2">8.</td>
                <td rowspan="2">Seni</td>
                <td>Seni Rupa</td>
                <td class='<?php echo ($raporSisipan["rs_snr_uh1"] > 74 || $raporSisipan["rs_snr_uh1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snr_uh1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snr_tgs1"] > 74 || $raporSisipan["rs_snr_tgs1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snr_tgs1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snr_uh2"] > 74 || $raporSisipan["rs_snr_uh2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snr_uh2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snr_tgs2"] > 74 || $raporSisipan["rs_snr_tgs2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snr_tgs2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snr_uh3"] > 74 || $raporSisipan["rs_snr_uh3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snr_uh3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snr_tgs3"] > 74 || $raporSisipan["rs_snr_tgs3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snr_tgs3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snr_pts"] > 74 || $raporSisipan["rs_snr_pts"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snr_pts']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snr_prk"] > 74 || $raporSisipan["rs_snr_prk"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snr_prk']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snr_prd"] > 74 || $raporSisipan["rs_snr_prd"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snr_prd']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snr_pry"] > 74 || $raporSisipan["rs_snr_pry"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snr_pry']}}</td>
            </tr>
            <tr>
                <td>Seni Musik</td>
                <td class='<?php echo ($raporSisipan["rs_snm_uh1"] > 74 || $raporSisipan["rs_snm_uh1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snm_uh1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snm_tgs1"] > 74 || $raporSisipan["rs_snm_tgs1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snm_tgs1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snm_uh2"] > 74 || $raporSisipan["rs_snm_uh2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snm_uh2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snm_tgs2"] > 74 || $raporSisipan["rs_snm_tgs2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snm_tgs2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snm_uh3"] > 74 || $raporSisipan["rs_snm_uh3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snm_uh3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snm_tgs3"] > 74 || $raporSisipan["rs_snm_tgs3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snm_tgs3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snm_pts"] > 74 || $raporSisipan["rs_snm_pts"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snm_pts']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snm_prk"] > 74 || $raporSisipan["rs_snm_prk"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snm_prk']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snm_prd"] > 74 || $raporSisipan["rs_snm_prd"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snm_prd']}}</td>
                <td class='<?php echo ($raporSisipan["rs_snm_pry"] > 74 || $raporSisipan["rs_snm_pry"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_snm_pry']}}</td>
            </tr>
            <tr>
                <td class="nomermapel">9.</td>
                <td colspan="2">Pend. Jasmani, Olah Raga & Kesehatan</td>
                <td class='<?php echo ($raporSisipan["rs_org_uh1"] > 74 || $raporSisipan["rs_org_uh1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_org_uh1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_org_tgs1"] > 74 || $raporSisipan["rs_org_tgs1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_org_tgs1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_org_uh2"] > 74 || $raporSisipan["rs_org_uh2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_org_uh2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_org_tgs2"] > 74 || $raporSisipan["rs_org_tgs2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_org_tgs2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_org_uh3"] > 74 || $raporSisipan["rs_org_uh3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_org_uh3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_org_tgs3"] > 74 || $raporSisipan["rs_org_tgs3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_org_tgs3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_org_pts"] > 74 || $raporSisipan["rs_org_pts"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_org_pts']}}</td>
                <td class='<?php echo ($raporSisipan["rs_org_prk"] > 74 || $raporSisipan["rs_org_prk"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_org_prk']}}</td>
                <td class='<?php echo ($raporSisipan["rs_org_prd"] > 74 || $raporSisipan["rs_org_prd"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_org_prd']}}</td>
                <td class='<?php echo ($raporSisipan["rs_org_pry"] > 74 || $raporSisipan["rs_org_pry"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_org_pry']}}</td>
            </tr>
            <tr>
                <td class="nomermapel">10.</td>
                <td colspan="2">Prakarya</td>
                <td class='<?php echo ($raporSisipan["rs_pky_uh1"] > 74 || $raporSisipan["rs_pky_uh1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pky_uh1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pky_tgs1"] > 74 || $raporSisipan["rs_pky_tgs1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pky_tgs1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pky_uh2"] > 74 || $raporSisipan["rs_pky_uh2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pky_uh2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pky_tgs2"] > 74 || $raporSisipan["rs_pky_tgs2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pky_tgs2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pky_uh3"] > 74 || $raporSisipan["rs_pky_uh3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pky_uh3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pky_tgs3"] > 74 || $raporSisipan["rs_pky_tgs3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pky_tgs3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pky_pts"] > 74 || $raporSisipan["rs_pky_pts"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pky_pts']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pky_prk"] > 74 || $raporSisipan["rs_pky_prk"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pky_prk']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pky_prd"] > 74 || $raporSisipan["rs_pky_prd"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pky_prd']}}</td>
                <td class='<?php echo ($raporSisipan["rs_pky_pry"] > 74 || $raporSisipan["rs_pky_pry"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_pky_pry']}}</td>
            </tr>
            <tr>
                <td class="nomermapel">11.</td>
                <td colspan="2">Bahasa Jawa</td>
                <td class='<?php echo ($raporSisipan["rs_jwa_uh1"] > 74 || $raporSisipan["rs_jwa_uh1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_jwa_uh1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_jwa_tgs1"] > 74 || $raporSisipan["rs_jwa_tgs1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_jwa_tgs1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_jwa_uh2"] > 74 || $raporSisipan["rs_jwa_uh2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_jwa_uh2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_jwa_tgs2"] > 74 || $raporSisipan["rs_jwa_tgs2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_jwa_tgs2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_jwa_uh3"] > 74 || $raporSisipan["rs_jwa_uh3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_jwa_uh3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_jwa_tgs3"] > 74 || $raporSisipan["rs_jwa_tgs3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_jwa_tgs3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_jwa_pts"] > 74 || $raporSisipan["rs_jwa_pts"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_jwa_pts']}}</td>
                <td class='<?php echo ($raporSisipan["rs_jwa_prk"] > 74 || $raporSisipan["rs_jwa_prk"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_jwa_prk']}}</td>
                <td class='<?php echo ($raporSisipan["rs_jwa_prd"] > 74 || $raporSisipan["rs_jwa_prd"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_jwa_prd']}}</td>
                <td class='<?php echo ($raporSisipan["rs_jwa_pry"] > 74 || $raporSisipan["rs_jwa_pry"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_jwa_pry']}}</td>
            </tr>
            <tr>
                <td class="nomermapel">12.</td>
                <td colspan="2">Mandarin</td>
                <td class='<?php echo ($raporSisipan["rs_man_uh1"] > 74 || $raporSisipan["rs_man_uh1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_man_uh1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_man_tgs1"] > 74 || $raporSisipan["rs_man_tgs1"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_man_tgs1']}}</td>
                <td class='<?php echo ($raporSisipan["rs_man_uh2"] > 74 || $raporSisipan["rs_man_uh2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_man_uh2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_man_tgs2"] > 74 || $raporSisipan["rs_man_tgs2"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_man_tgs2']}}</td>
                <td class='<?php echo ($raporSisipan["rs_man_uh3"] > 74 || $raporSisipan["rs_man_uh3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_man_uh3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_man_tgs3"] > 74 || $raporSisipan["rs_man_tgs3"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_man_tgs3']}}</td>
                <td class='<?php echo ($raporSisipan["rs_man_pts"] > 74 || $raporSisipan["rs_man_pts"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_man_pts']}}</td>
                <td class='<?php echo ($raporSisipan["rs_man_prk"] > 74 || $raporSisipan["rs_man_prk"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_man_prk']}}</td>
                <td class='<?php echo ($raporSisipan["rs_man_prd"] > 74 || $raporSisipan["rs_man_prd"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_man_prd']}}</td>
                <td class='<?php echo ($raporSisipan["rs_man_pry"] > 74 || $raporSisipan["rs_man_pry"] == null ) ? "nilai" : "nilaikkm" ?>'>{{$raporSisipan['rs_man_pry']}}</td>
            </tr>
            <tr>
                <td colspan="9" style="text-align:center; font-weight: bold">CATATAN WALIKELAS</td>
                <td colspan="4" style="text-align:center; font-weight: bold">ABSENSI</td>
            </tr>
            <tr>
                <td colspan="9" rowspan="3" style="padding-top:2px; padding-bottom:2px; padding-left:5px"><center><i>{{$raporSisipan["rs_catatan_isi"]}}</i><br><b>{{$raporSisipan["rs_catatan_ayat"]}}</b></center><br>{{$raporSisipan["rs_catatan_pesan"]}}</td>
                <td colspan="2" style="text-align:center">Sakit</td>
                <td style="border-right:none; text-align:right">{{$raporSisipan["rs_absensi_sakit"] ? $raporSisipan["rs_absensi_sakit"]:"-"}} </td>
                <td style="border-left:none">hari</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center">Ijin</td>
                <td style="border-right:none; text-align:right">{{$raporSisipan["rs_absensi_ijin"] ? $raporSisipan["rs_absensi_ijin"]:"-"}} </td>
                <td style="border-left:none">hari</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center">Tanpa Keterangan</td>
                <td style="border-right:none; text-align:right">{{$raporSisipan["rs_absensi_alpha"] ? $raporSisipan["rs_absensi_alpha"]:"-"}} </td>
                <td style="border-left:none">hari</td>
            </tr>
        </table>
        <table class="TTD">
            <tr>
                <td colspan="2"></td>
                <td style="text-align:center; width:30%">Surabaya, 14 Oktober 2022</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:left"><td>
            </tr>
            <tr>
                <td style="width:25%"></td>
                <td style="width:50%; text-align:center; padding:1px" rowspan="3"><img src="{{public_path('storage/stamps/'.$raporSisipan['stamp'].'.png')}}" style="width: 100px"></td>
                <td style="width:20%; text-align:center;">a.n. Kepala Sekolah</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left:10px; text-align:center;"><img src="{{public_path('storage/signs/'.$raporSisipan['ttd'].'.png')}}" style="width: 100px"></td>
            </tr>
            <tr>
                <td style="padding:1px"></td>
                <td style="padding:1px; text-align:center;">{{$raporSisipan["rs_walikelas"]}}</td>
            </tr>
        </table>
    </div>
</body>
</html>
