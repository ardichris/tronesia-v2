<template>
    <div class="container">
        <center><img :src="'/storage/header/'+raporSisipan['kop']+'.png'" style="width:80%"> </center>
        <br>
        <center><h1 style="font-family:'Verdana'; font-size: 14px">LAPORAN HASIL BELAJAR TENGAH SEMESTER</h1></center>
        <br>
        <table class="identitas">
            <tr>
                <td style="width:15%">Nama Siswa</td>
                <td style="width:1%">:</td>
                <td colspan="4">{{raporSisipan['siswa']['s_nama']}}</td>
            </tr>
            <tr>
                <td style="width:15%">Kelas</td>
                <td style="width:1%">:</td>
                <td style="width:40%">{{raporSisipan['kelas']['kelas']['kelas_nama']}} / {{raporSisipan['kelas']['absen']}}</td>
                <td style="width:20%">Fase</td>
                <td style="width:1%">:</td>
                <td style="width:20%">D</td>
            </tr>
            <tr>
                <td>Student Code</td>
                <td>:</td>
                <td>{{raporSisipan['siswa']['s_code']}}</td>
                <td>Semester</td>
                <td>:</td>
                <td>1 (Satu)</td>
            </tr>
            <tr>
                <td>Nomor Induk</td>
                <td>:</td>
                <td>{{raporSisipan['siswa']['s_nis']}}</td>
                <td>Tahun Pelajaran</td>
                <td>:</td>
                <td>2022 - 2023</td>
            </tr>
        </table>
        <br>
        <table class="subrapor">
            <tr>
                <td style="width:675px; font-weight: bold">PENILAIAN AKADEMIK</td>
            </tr>
            <tr>
                <td style="width:660px; padding-left:15px">Kriteria Ketercapaian Tujuan Pembelajaran: 75</td>
            </tr>
        </table>
        <table class="nilai">
            <tr>
                <td colspan="2" style="width:100px; text-align:center; font-weight: bold">MATA PELAJARAN</td>
                <td style="text-align:center; font-weight: bold">TP</td>
                <td style="text-align:center; font-weight: bold">TGS</td>
                <td style="text-align:center; font-weight: bold">TES</td>
                <td style="text-align:center; font-weight: bold">TP</td>
                <td style="text-align:center; font-weight: bold">TGS</td>
                <td style="text-align:center; font-weight: bold">TES</td>
                <td style="text-align:center; font-weight: bold">TP</td>
                <td style="text-align:center; font-weight: bold">TGS</td>
                <td style="text-align:center; font-weight: bold">TES</td>
                <td style="text-align:center; font-weight: bold">TP</td>
                <td style="text-align:center; font-weight: bold">TGS</td>
                <td style="text-align:center; font-weight: bold">TES</td>
                <td style="text-align:center; font-weight: bold">STS</td>
            </tr>
            <tr>
                <td colspan="2">1. Pendidikan Agama dan Budi Pekerti</td>
                <td class="nilaitp">{{raporSisipan['nilai']['PAK'][1]['TP']}}</td>
                <td :class="raporSisipan['nilai']['PAK'][1]['ns_tugas'] > 74 || raporSisipan['nilai']['PAK'][1]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PAK'][1]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['PAK'][1]['ns_tes'] > 74 || raporSisipan['nilai']['PAK'][1]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PAK'][1]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['PAK'][2]['TP']}}</td>
                <td :class="raporSisipan['nilai']['PAK'][2]['ns_tugas'] > 74 || raporSisipan['nilai']['PAK'][2]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PAK'][2]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['PAK'][2]['ns_tes'] > 74 || raporSisipan['nilai']['PAK'][2]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PAK'][2]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['PAK'][3]['TP']}}</td>
                <td :class="raporSisipan['nilai']['PAK'][3]['ns_tugas'] > 74 || raporSisipan['nilai']['PAK'][3]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PAK'][3]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['PAK'][3]['ns_tes'] > 74 || raporSisipan['nilai']['PAK'][3]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PAK'][3]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['PAK'][4]['TP']}}</td>
                <td :class="raporSisipan['nilai']['PAK'][4]['ns_tugas'] > 74 || raporSisipan['nilai']['PAK'][4]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PAK'][4]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['PAK'][4]['ns_tes'] > 74 || raporSisipan['nilai']['PAK'][4]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PAK'][4]['ns_tes']}}</td>
                <td class="nilai">{{raporSisipan['nilai']['PAK']['STS']?raporSisipan['nilai']['PAK']['STS']['ns_nilai']:null}}</td>
            </tr>
            <tr>
                <td colspan="2">2. Pendidikan Pancasila dan Kewarganegaraan</td>
                <td class="nilaitp">{{raporSisipan['nilai']['PKN'][1]['TP']}}</td>
                <td :class="raporSisipan['nilai']['PKN'][1]['ns_tugas'] > 74 || raporSisipan['nilai']['PKN'][1]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PKN'][1]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['PKN'][1]['ns_tes'] > 74 || raporSisipan['nilai']['PKN'][1]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PKN'][1]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['PKN'][2]['TP']}}</td>
                <td :class="raporSisipan['nilai']['PKN'][2]['ns_tugas'] > 74 || raporSisipan['nilai']['PKN'][2]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PKN'][2]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['PKN'][2]['ns_tes'] > 74 || raporSisipan['nilai']['PKN'][2]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PKN'][2]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['PKN'][3]['TP']}}</td>
                <td :class="raporSisipan['nilai']['PKN'][3]['ns_tugas'] > 74 || raporSisipan['nilai']['PKN'][3]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PKN'][3]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['PKN'][3]['ns_tes'] > 74 || raporSisipan['nilai']['PKN'][3]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PKN'][3]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['PKN'][4]['TP']}}</td>
                <td :class="raporSisipan['nilai']['PKN'][4]['ns_tugas'] > 74 || raporSisipan['nilai']['PKN'][4]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PKN'][4]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['PKN'][4]['ns_tes'] > 74 || raporSisipan['nilai']['PKN'][4]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PKN'][4]['ns_tes']}}</td>
                <td class="nilai">{{raporSisipan['nilai']['PKN']['STS']?raporSisipan['nilai']['PKN']['STS']['ns_nilai']:null}}</td>
            </tr>
            <tr>
                <td colspan="2">3. Bahasa Indonesia</td>
                <td class="nilaitp">{{raporSisipan['nilai']['BIN'][1]['TP']}}</td>
                <td :class="raporSisipan['nilai']['BIN'][1]['ns_tugas'] > 74 || raporSisipan['nilai']['BIN'][1]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['BIN'][1]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['BIN'][1]['ns_tes'] > 74 || raporSisipan['nilai']['BIN'][1]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['BIN'][1]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['BIN'][2]['TP']}}</td>
                <td :class="raporSisipan['nilai']['BIN'][2]['ns_tugas'] > 74 || raporSisipan['nilai']['BIN'][2]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['BIN'][2]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['BIN'][2]['ns_tes'] > 74 || raporSisipan['nilai']['BIN'][2]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['BIN'][2]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['BIN'][3]['TP']}}</td>
                <td :class="raporSisipan['nilai']['BIN'][3]['ns_tugas'] > 74 || raporSisipan['nilai']['BIN'][3]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['BIN'][3]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['BIN'][3]['ns_tes'] > 74 || raporSisipan['nilai']['BIN'][3]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['BIN'][3]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['BIN'][4]['TP']}}</td>
                <td :class="raporSisipan['nilai']['BIN'][4]['ns_tugas'] > 74 || raporSisipan['nilai']['BIN'][4]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['BIN'][4]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['BIN'][4]['ns_tes'] > 74 || raporSisipan['nilai']['BIN'][4]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['BIN'][4]['ns_tes']}}</td>
                <td class="nilai">{{raporSisipan['nilai']['BIN']['STS']?raporSisipan['nilai']['BIN']['STS']['ns_nilai']:null}}</td>
            </tr>
            <tr>
                <td colspan="2">4. Bahasa Inggris</td>
                <td class="nilaitp">{{raporSisipan['nilai']['BIG'][1]['TP']}}</td>
                <td :class="raporSisipan['nilai']['BIG'][1]['ns_tugas'] > 74 || raporSisipan['nilai']['BIG'][1]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['BIG'][1]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['BIG'][1]['ns_tes'] > 74 || raporSisipan['nilai']['BIG'][1]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['BIG'][1]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['BIG'][2]['TP']}}</td>
                <td :class="raporSisipan['nilai']['BIG'][2]['ns_tugas'] > 74 || raporSisipan['nilai']['BIG'][2]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['BIG'][2]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['BIG'][2]['ns_tes'] > 74 || raporSisipan['nilai']['BIG'][2]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['BIG'][2]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['BIG'][3]['TP']}}</td>
                <td :class="raporSisipan['nilai']['BIG'][3]['ns_tugas'] > 74 || raporSisipan['nilai']['BIG'][3]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['BIG'][3]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['BIG'][3]['ns_tes'] > 74 || raporSisipan['nilai']['BIG'][3]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['BIG'][3]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['BIG'][4]['TP']}}</td>
                <td :class="raporSisipan['nilai']['BIG'][4]['ns_tugas'] > 74 || raporSisipan['nilai']['BIG'][4]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['BIG'][4]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['BIG'][4]['ns_tes'] > 74 || raporSisipan['nilai']['BIG'][4]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['BIG'][4]['ns_tes']}}</td>
                <td class="nilai">{{raporSisipan['nilai']['BIG']['STS']?raporSisipan['nilai']['BIG']['STS']['ns_nilai']:null}}</td>
            </tr>
            <tr>
                <td colspan="2">5. Matematika</td>
                <td class="nilaitp">{{raporSisipan['nilai']['MAT'][1]['TP']}}</td>
                <td :class="raporSisipan['nilai']['MAT'][1]['ns_tugas'] > 74 || raporSisipan['nilai']['MAT'][1]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['MAT'][1]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['MAT'][1]['ns_tes'] > 74 || raporSisipan['nilai']['MAT'][1]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['MAT'][1]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['MAT'][2]['TP']}}</td>
                <td :class="raporSisipan['nilai']['MAT'][2]['ns_tugas'] > 74 || raporSisipan['nilai']['MAT'][2]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['MAT'][2]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['MAT'][2]['ns_tes'] > 74 || raporSisipan['nilai']['MAT'][2]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['MAT'][2]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['MAT'][3]['TP']}}</td>
                <td :class="raporSisipan['nilai']['MAT'][3]['ns_tugas'] > 74 || raporSisipan['nilai']['MAT'][3]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['MAT'][3]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['MAT'][3]['ns_tes'] > 74 || raporSisipan['nilai']['MAT'][3]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['MAT'][3]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['MAT'][4]['TP']}}</td>
                <td :class="raporSisipan['nilai']['MAT'][4]['ns_tugas'] > 74 || raporSisipan['nilai']['MAT'][4]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['MAT'][4]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['MAT'][4]['ns_tes'] > 74 || raporSisipan['nilai']['MAT'][4]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['MAT'][4]['ns_tes']}}</td>
                <td class="nilai">{{raporSisipan['nilai']['MAT']['STS']?raporSisipan['nilai']['MAT']['STS']['ns_nilai']:null}}</td>
            </tr>
            <tr>
                <td style="width:100px">6. IPA</td>
                <td>Fisika</td>
                <td class="nilaitp">{{raporSisipan['nilai']['FIS'][1]['TP']}}</td>
                <td :class="raporSisipan['nilai']['FIS'][1]['ns_tugas'] > 74 || raporSisipan['nilai']['FIS'][1]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['FIS'][1]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['FIS'][1]['ns_tes'] > 74 || raporSisipan['nilai']['FIS'][1]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['FIS'][1]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['FIS'][2]['TP']}}</td>
                <td :class="raporSisipan['nilai']['FIS'][2]['ns_tugas'] > 74 || raporSisipan['nilai']['FIS'][2]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['FIS'][2]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['FIS'][2]['ns_tes'] > 74 || raporSisipan['nilai']['FIS'][2]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['FIS'][2]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['FIS'][3]['TP']}}</td>
                <td :class="raporSisipan['nilai']['FIS'][3]['ns_tugas'] > 74 || raporSisipan['nilai']['FIS'][3]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['FIS'][3]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['FIS'][3]['ns_tes'] > 74 || raporSisipan['nilai']['FIS'][3]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['FIS'][3]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['FIS'][4]['TP']}}</td>
                <td :class="raporSisipan['nilai']['FIS'][4]['ns_tugas'] > 74 || raporSisipan['nilai']['FIS'][4]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['FIS'][4]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['FIS'][4]['ns_tes'] > 74 || raporSisipan['nilai']['FIS'][4]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['FIS'][4]['ns_tes']}}</td>
                <td class="nilai">{{raporSisipan['nilai']['FIS']['STS']?raporSisipan['nilai']['FIS']['STS']['ns_nilai']:null}}</td>
            </tr>
            <tr>
                <td rowspan="2">7. IPS</td>
                <td>Geografi</td>
                <td class="nilaitp">{{raporSisipan['nilai']['GEO'][1]['TP']}}</td>
                <td :class="raporSisipan['nilai']['GEO'][1]['ns_tugas'] > 74 || raporSisipan['nilai']['GEO'][1]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['GEO'][1]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['GEO'][1]['ns_tes'] > 74 || raporSisipan['nilai']['GEO'][1]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['GEO'][1]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['GEO'][2]['TP']}}</td>
                <td :class="raporSisipan['nilai']['GEO'][2]['ns_tugas'] > 74 || raporSisipan['nilai']['GEO'][2]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['GEO'][2]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['GEO'][2]['ns_tes'] > 74 || raporSisipan['nilai']['GEO'][2]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['GEO'][2]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['GEO'][3]['TP']}}</td>
                <td :class="raporSisipan['nilai']['GEO'][3]['ns_tugas'] > 74 || raporSisipan['nilai']['GEO'][3]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['GEO'][3]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['GEO'][3]['ns_tes'] > 74 || raporSisipan['nilai']['GEO'][3]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['GEO'][3]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['GEO'][4]['TP']}}</td>
                <td :class="raporSisipan['nilai']['GEO'][4]['ns_tugas'] > 74 || raporSisipan['nilai']['GEO'][4]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['GEO'][4]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['GEO'][4]['ns_tes'] > 74 || raporSisipan['nilai']['GEO'][4]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['GEO'][4]['ns_tes']}}</td>
                <td class="nilai">{{raporSisipan['nilai']['GEO']['STS']?raporSisipan['nilai']['GEO']['STS']['ns_nilai']:null}}</td>
            </tr>
            <tr>
                <td>Ekonomi</td>
                <td class="nilaitp">{{raporSisipan['nilai']['EKO'][1]['TP']}}</td>
                <td :class="raporSisipan['nilai']['EKO'][1]['ns_tugas'] > 74 || raporSisipan['nilai']['EKO'][1]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['EKO'][1]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['EKO'][1]['ns_tes'] > 74 || raporSisipan['nilai']['EKO'][1]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['EKO'][1]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['EKO'][2]['TP']}}</td>
                <td :class="raporSisipan['nilai']['EKO'][2]['ns_tugas'] > 74 || raporSisipan['nilai']['EKO'][2]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['EKO'][2]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['EKO'][2]['ns_tes'] > 74 || raporSisipan['nilai']['EKO'][2]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['EKO'][2]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['EKO'][3]['TP']}}</td>
                <td :class="raporSisipan['nilai']['EKO'][3]['ns_tugas'] > 74 || raporSisipan['nilai']['EKO'][3]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['EKO'][3]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['EKO'][3]['ns_tes'] > 74 || raporSisipan['nilai']['EKO'][3]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['EKO'][3]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['EKO'][4]['TP']}}</td>
                <td :class="raporSisipan['nilai']['EKO'][4]['ns_tugas'] > 74 || raporSisipan['nilai']['EKO'][4]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['EKO'][4]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['EKO'][4]['ns_tes'] > 74 || raporSisipan['nilai']['EKO'][4]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['EKO'][4]['ns_tes']}}</td>
                <td class="nilai">{{raporSisipan['nilai']['EKO']['STS']?raporSisipan['nilai']['EKO']['STS']['ns_nilai']:null}}</td>
            </tr>
            <tr>
                <td>8. Mapel Pilihan</td>
                <td>{{raporSisipan['nilai']['PIL']['KET']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['PIL'][1]['TP']}}</td>
                <td :class="raporSisipan['nilai']['PIL'][1]['ns_tugas'] > 74 || raporSisipan['nilai']['PIL'][1]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PIL'][1]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['PIL'][1]['ns_tes'] > 74 || raporSisipan['nilai']['PIL'][1]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PIL'][1]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['PIL'][2]['TP']}}</td>
                <td :class="raporSisipan['nilai']['PIL'][2]['ns_tugas'] > 74 || raporSisipan['nilai']['PIL'][2]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PIL'][2]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['PIL'][2]['ns_tes'] > 74 || raporSisipan['nilai']['PIL'][2]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PIL'][2]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['PIL'][3]['TP']}}</td>
                <td :class="raporSisipan['nilai']['PIL'][3]['ns_tugas'] > 74 || raporSisipan['nilai']['PIL'][3]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PIL'][3]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['PIL'][3]['ns_tes'] > 74 || raporSisipan['nilai']['PIL'][3]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PIL'][3]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['PIL'][4]['TP']}}</td>
                <td :class="raporSisipan['nilai']['PIL'][4]['ns_tugas'] > 74 || raporSisipan['nilai']['PIL'][4]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PIL'][4]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['PIL'][4]['ns_tes'] > 74 || raporSisipan['nilai']['PIL'][4]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['PIL'][4]['ns_tes']}}</td>
                <td class="nilai">{{raporSisipan['nilai']['PIL']['STS']?raporSisipan['nilai']['PIL']['STS']['ns_nilai']:null}}</td>
            </tr>
            <tr>
                <td colspan="2">9. Pend. Jasmani, Olah Raga & Kesehatan</td>
                <td class="nilaitp">{{raporSisipan['nilai']['ORG'][1]['TP']}}</td>
                <td :class="raporSisipan['nilai']['ORG'][1]['ns_tugas'] > 74 || raporSisipan['nilai']['ORG'][1]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['ORG'][1]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['ORG'][1]['ns_tes'] > 74 || raporSisipan['nilai']['ORG'][1]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['ORG'][1]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['ORG'][2]['TP']}}</td>
                <td :class="raporSisipan['nilai']['ORG'][2]['ns_tugas'] > 74 || raporSisipan['nilai']['ORG'][2]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['ORG'][2]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['ORG'][2]['ns_tes'] > 74 || raporSisipan['nilai']['ORG'][2]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['ORG'][2]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['ORG'][3]['TP']}}</td>
                <td :class="raporSisipan['nilai']['ORG'][3]['ns_tugas'] > 74 || raporSisipan['nilai']['ORG'][3]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['ORG'][3]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['ORG'][3]['ns_tes'] > 74 || raporSisipan['nilai']['ORG'][3]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['ORG'][3]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['ORG'][4]['TP']}}</td>
                <td :class="raporSisipan['nilai']['ORG'][4]['ns_tugas'] > 74 || raporSisipan['nilai']['ORG'][4]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['ORG'][4]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['ORG'][4]['ns_tes'] > 74 || raporSisipan['nilai']['ORG'][4]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['ORG'][4]['ns_tes']}}</td>
                <td class="nilai">{{raporSisipan['nilai']['ORG']['STS']?raporSisipan['nilai']['ORG']['STS']['ns_nilai']:null}}</td>
            </tr>
            <tr>
                <td colspan="2">10. Informatika</td>
                <td class="nilaitp">{{raporSisipan['nilai']['TIK'][1]['TP']}}</td>
                <td :class="raporSisipan['nilai']['TIK'][1]['ns_tugas'] > 74 || raporSisipan['nilai']['TIK'][1]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['TIK'][1]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['TIK'][1]['ns_tes'] > 74 || raporSisipan['nilai']['TIK'][1]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['TIK'][1]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['TIK'][2]['TP']}}</td>
                <td :class="raporSisipan['nilai']['TIK'][2]['ns_tugas'] > 74 || raporSisipan['nilai']['TIK'][2]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['TIK'][2]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['TIK'][2]['ns_tes'] > 74 || raporSisipan['nilai']['TIK'][2]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['TIK'][2]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['TIK'][3]['TP']}}</td>
                <td :class="raporSisipan['nilai']['TIK'][3]['ns_tugas'] > 74 || raporSisipan['nilai']['TIK'][3]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['TIK'][3]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['TIK'][3]['ns_tes'] > 74 || raporSisipan['nilai']['TIK'][3]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['TIK'][3]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['TIK'][4]['TP']}}</td>
                <td :class="raporSisipan['nilai']['TIK'][4]['ns_tugas'] > 74 || raporSisipan['nilai']['TIK'][4]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['TIK'][4]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['TIK'][4]['ns_tes'] > 74 || raporSisipan['nilai']['TIK'][4]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['TIK'][4]['ns_tes']}}</td>
                <td class="nilai">{{raporSisipan['nilai']['TIK']['STS']?raporSisipan['nilai']['TIK']['STS']['ns_nilai']:null}}</td>
            </tr>
            <tr>
                <td colspan="2">11. Bahasa Jawa</td>
                <td class="nilaitp">{{raporSisipan['nilai']['JWA'][1]['TP']}}</td>
                <td :class="raporSisipan['nilai']['JWA'][1]['ns_tugas'] > 74 || raporSisipan['nilai']['JWA'][1]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['JWA'][1]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['JWA'][1]['ns_tes'] > 74 || raporSisipan['nilai']['JWA'][1]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['JWA'][1]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['JWA'][2]['TP']}}</td>
                <td :class="raporSisipan['nilai']['JWA'][2]['ns_tugas'] > 74 || raporSisipan['nilai']['JWA'][2]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['JWA'][2]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['JWA'][2]['ns_tes'] > 74 || raporSisipan['nilai']['JWA'][2]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['JWA'][2]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['JWA'][3]['TP']}}</td>
                <td :class="raporSisipan['nilai']['JWA'][3]['ns_tugas'] > 74 || raporSisipan['nilai']['JWA'][3]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['JWA'][3]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['JWA'][3]['ns_tes'] > 74 || raporSisipan['nilai']['JWA'][3]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['JWA'][3]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['JWA'][4]['TP']}}</td>
                <td :class="raporSisipan['nilai']['JWA'][4]['ns_tugas'] > 74 || raporSisipan['nilai']['JWA'][4]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['JWA'][4]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['JWA'][4]['ns_tes'] > 74 || raporSisipan['nilai']['JWA'][4]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['JWA'][4]['ns_tes']}}</td>
                <td class="nilai">{{raporSisipan['nilai']['JWA']['STS']?raporSisipan['nilai']['JWA']['STS']['ns_nilai']:null}}</td>
            </tr>
            <tr>
                <td colspan="2">12. Mandarin</td>
                <td class="nilaitp">{{raporSisipan['nilai']['MAN'][1]['TP']}}</td>
                <td :class="raporSisipan['nilai']['MAN'][1]['ns_tugas'] > 74 || raporSisipan['nilai']['MAN'][1]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['MAN'][1]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['MAN'][1]['ns_tes'] > 74 || raporSisipan['nilai']['MAN'][1]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['MAN'][1]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['MAN'][2]['TP']}}</td>
                <td :class="raporSisipan['nilai']['MAN'][2]['ns_tugas'] > 74 || raporSisipan['nilai']['MAN'][2]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['MAN'][2]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['MAN'][2]['ns_tes'] > 74 || raporSisipan['nilai']['MAN'][2]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['MAN'][2]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['MAN'][3]['TP']}}</td>
                <td :class="raporSisipan['nilai']['MAN'][3]['ns_tugas'] > 74 || raporSisipan['nilai']['MAN'][3]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['MAN'][3]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['MAN'][3]['ns_tes'] > 74 || raporSisipan['nilai']['MAN'][3]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['MAN'][3]['ns_tes']}}</td>
                <td class="nilaitp">{{raporSisipan['nilai']['MAN'][4]['TP']}}</td>
                <td :class="raporSisipan['nilai']['MAN'][4]['ns_tugas'] > 74 || raporSisipan['nilai']['MAN'][4]['ns_tugas'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['MAN'][4]['ns_tugas']}}</td>
                <td :class="raporSisipan['nilai']['MAN'][4]['ns_tes'] > 74 || raporSisipan['nilai']['MAN'][4]['ns_tes'] == null  ? 'nilai' : 'nilaikkm'">{{raporSisipan['nilai']['MAN'][4]['ns_tes']}}</td>
                <td class="nilai">{{raporSisipan['nilai']['MAN']['STS']?raporSisipan['nilai']['MAN']['STS']['ns_nilai']:null}}</td>
            </tr>
            <tr>
                <td colspan="9" style="text-align:center; font-weight: bold">CATATAN WALIKELAS</td>
                <td colspan="6" style="text-align:center; font-weight: bold">ABSENSI</td>
            </tr>
            <tr>
                <td colspan="9" rowspan="3"><center><i>{{raporSisipan["rs_catatan_isi"]}}</i><br><b>{{raporSisipan["rs_catatan_ayat"]}}</b></center><br>{{raporSisipan["rs_catatan_pesan"]}}</td>
                <td colspan="4" style="text-align:center">Sakit</td>
                <td style="border-right:none; text-align:right">{{raporSisipan["rs_absensi_sakit"]?raporSisipan["rs_absensi_sakit"]:"-"}} </td>
                <td style="border-left:none">hari</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:center">Ijin</td>
                <td style="border-right:none; text-align:right">{{raporSisipan["rs_absensi_ijin"]?raporSisipan["rs_absensi_ijin"]:"-"}} </td>
                <td style="border-left:none">hari</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:center">Tanpa Keterangan</td>
                <td style="border-right:none; text-align:right">{{raporSisipan["rs_absensi_alpha"]?raporSisipan["rs_absensi_alpha"]:"-"}} </td>
                <td style="border-left:none">hari</td>
            </tr>
        </table>
        <table class="TTD">
            <tr>
                <td style="text-align:left; width:30%"></td>
                <td style="text-align:center; padding:1px; width:40%" rowspan="5"><img :src="'/storage/stamps/'+raporSisipan['stamp']+'.png'" style="width:100px"></td>
                <td style="text-align:center; width:30%">Surabaya, 14 Oktober 2022</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align:center; width:20%">a.n. Kepala Sekolah</td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align:center"><img :src="'/storage/signs/'+raporSisipan['ttd']+'.png'" style="width: 100px;"></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align:center">{{raporSisipan['rs_walikelas']}}</td>
            </tr>
        </table>
    </div>
</template>
<style scoped>
    @page {
            margin-top: 0;
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
            width: 90%;
        }
        table.nilai td, th {
            border: 1px solid black;
            padding: 5px;
        }
        table.nilai td.nilai {
            text-align: center;
            font-size:12px;
            font-family: Verdana;
            border: 1px solid black;
            padding: 5px;
        }
        table.nilai td.nilaikkm {
            text-align: center;
            background-color: #ff6666;
            font-size:12px;
            font-family: Verdana;
            border: 1px solid black;
            padding: 5px;
        }
        table.nilai td.nilaitp {
            text-align: center;
            font-size:10px;
            font-family: Comic;
            border: 1px solid black;
            border-left: 2px solid black;
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
            width: 90%;
        }
        table.TTD td, tr, th{
            padding:3px;
            width:auto;
            border: none;

        }

</style>
<script>
import { mapActions, mapState } from 'vuex'

export default {
    name: 'RaporSisipanForm',
    created() {

    },
    data() {
        return {
            fields: [
                { key: 's_nama', label: 'Nama Siswa' },
                { key: 'sisipan', label: 'Rapor Sisipan' },
                { key: 'akhir', label: 'Rapor Akhir' }
            ],
        }
    },
    computed: {
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        ...mapState('raporakhir', {
            raporakhirs: state => state.raporakhirs,
            raporSisipan : state => state.raporsisipan
        }),
        ...mapState(['token']),
    },
    methods: {
        ...mapActions('raporakhir', ['viewRaporSisipan']),
        sentenceCase(input, lowercaseBefore) {
            input = ( input === undefined || input === null ) ? '' : input;
            if (lowercaseBefore) { input = input.toLowerCase(); }
            return input.toString().replace( /(^|\. *)([a-z])/g, function(match, separator, char) {
                return separator + char.toUpperCase();
            });
        }
    },

}
</script>
