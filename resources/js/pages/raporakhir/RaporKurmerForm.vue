<template>
    <div class="container">
        <center><h2 style="font-family:'Verdana'; font-size: 14px"><b>RAPOR KURIKULUM MERDEKA</b></h2></center>
        <table class="identitas">
            <tr>
                <td style="width:15%">Nama Siswa</td>
                <td style="width:1%">:</td>
                <td colspan="4" style="padding-left:5px">{{raporKurmer['nama_siswa']}}</td>
            </tr>
            <tr>
                <td style="width:15%">Kelas</td>
                <td style="width:1%">:</td>
                <td style="width:40%; padding-left:5px">{{raporKurmer['kelas']}} / {{raporKurmer['absen']}}</td>
                <td style="width:20%">Semester</td>
                <td style="width:1%">:</td>
                <td style="width:20%; padding-left:5px">1 (Satu)</td>
            </tr>
            <tr>
                <td>Nomor Induk</td>
                <td>:</td>
                <td style="padding-left:5px">{{raporKurmer['code']}}</td>
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
                <td style="text-align:center; font-weight: bold">No</td>
                <td colspan="2" style="width:200px; text-align:center; font-weight: bold">MATA PELAJARAN</td>
                <td style="text-align:center; font-weight: bold">Nilai</td>
                <!-- <td style="text-align:center; font-weight: bold">Predikat</td> -->
                <!-- <td style="text-align:center; font-weight: bold">Deskripsi</td> -->
            </tr>
            <tr>
                <td style="text-align:center">1</td>
                <td colspan="2">Pendidikan Agama dan Budi Pekerti</td>
                <td :class="raporKurmer['PAK']['kmr_score'] > 74 || raporKurmer['PAK']['kmr_score'] == null ? 'nilai' : 'nilaikkm'">{{raporKurmer['PAK']['kmr_score']}}</td>
                <!-- <td style="text-align:center">{{raporKurmer['PAK']['kmr_predicate']}}</td> -->
                <!-- <td>{{raporKurmer['PAK']['kmr_description1']}}<br>{{raporKurmer['PAK']['kmr_description2']}}</td> -->
            </tr>
            <tr>
                <td style="text-align:center">2</td>
                <td colspan="2">Pendidikan Pancasila dan Kewarganegaraan</td>
                <td :class="raporKurmer['PKN']['kmr_score'] > 74 || raporKurmer['PKN']['kmr_score'] == null ? 'nilai' : 'nilaikkm'">{{raporKurmer['PKN']['kmr_score']}}</td>
                <!-- <td style="text-align:center">{{raporKurmer['PKN']['kmr_predicate']}}</td> -->
                <!-- <td>{{raporKurmer['PKN']['kmr_description1']}}<br>{{raporKurmer['PKN']['kmr_description2']}}</td> -->
            </tr>
            <tr>
                <td style="text-align:center">3</td>
                <td colspan="2">Bahasa Indonesia</td>
                <td :class="raporKurmer['BIN']['kmr_score'] > 74 || raporKurmer['BIN']['kmr_score'] == null ? 'nilai' : 'nilaikkm'">{{raporKurmer['BIN']['kmr_score']}}</td>
                <!-- <td style="text-align:center">{{raporKurmer['BIN']['kmr_predicate']}}</td> -->
                <!-- <td>{{raporKurmer['BIN']['kmr_description1']}}<br>{{raporKurmer['BIN']['kmr_description2']}}</td> -->
            </tr>
            <tr>
                <td style="text-align:center">4</td>
                <td colspan="2">Bahasa Inggris</td>
                <td :class="raporKurmer['BIG']['kmr_score'] > 74 || raporKurmer['BIG']['kmr_score'] == null ? 'nilai' : 'nilaikkm'">{{raporKurmer['BIG']['kmr_score']}}</td>
                <!-- <td style="text-align:center">{{raporKurmer['BIG']['kmr_predicate']}}</td> -->
                <!-- <td>{{raporKurmer['BIG']['kmr_description1']}}<br>{{raporKurmer['BIG']['kmr_description2']}}</td> -->
            </tr>
            <tr>
                <td style="text-align:center">5</td>
                <td colspan="2">Matematika</td>
                <td :class="raporKurmer['MAT']['kmr_score'] > 74 || raporKurmer['MAT']['kmr_score'] == null ? 'nilai' : 'nilaikkm'">{{raporKurmer['MAT']['kmr_score']}}</td>
                <!-- <td style="text-align:center">{{raporKurmer['MAT']['kmr_predicate']}}</td> -->
                <!-- <td>{{raporKurmer['MAT']['kmr_description1']}}<br>{{raporKurmer['MAT']['kmr_description2']}}</td> -->
            </tr>
            <tr>
                <td style="text-align:center">6</td>
                <td colspan="2">Ilmu Pengetahuan Alam</td>
                <td :class="raporKurmer['IPA']['kmr_score'] > 74 || raporKurmer['IPA']['kmr_score'] == null ? 'nilai' : 'nilaikkm'">{{raporKurmer['IPA']['kmr_score']}}</td>
                <!-- <td style="text-align:center">{{raporKurmer['IPA']['kmr_predicate']}}</td> -->
                <!-- <td>{{raporKurmer['IPA']['kmr_description1']}}<br>{{raporKurmer['IPA']['kmr_description2']}}</td> -->
            </tr>
            <tr>
                <td style="text-align:center">7</td>
                <td colspan="2">Ilmu Pengetahuan Sosial</td>
                <td :class="raporKurmer['IPS']['kmr_score'] > 74 || raporKurmer['IPS']['kmr_score'] == null ? 'nilai' : 'nilaikkm'">{{raporKurmer['IPS']['kmr_score']}}</td>
                <!-- <td style="text-align:center">{{raporKurmer['IPS']['kmr_predicate']}}</td> -->
                <!-- <td>{{raporKurmer['IPS']['kmr_description1']}}<br>{{raporKurmer['IPS']['kmr_description2']}}</td> -->
            </tr>
            <tr>
                <td style="text-align:center">8</td>
                <td colspan="2">Mapel Pilihan :<br>{{raporKurmer['pilihan']}}</td>
                <td :class="raporKurmer['PIL']['kmr_score'] > 74 || raporKurmer['PIL']['kmr_score'] == null ? 'nilai' : 'nilaikkm'">{{raporKurmer['PIL']['kmr_score']}}</td>
                <!-- <td style="text-align:center">{{raporKurmer['PIL']['kmr_predicate']}}</td> -->
                <!-- <td>{{raporKurmer['PIL']['kmr_description1']}}<br>{{raporKurmer['PIL']['kmr_description2']}}</td> -->
            </tr>
            <tr>
                <td style="text-align:center">9</td>
                <td colspan="2">Pend. Jasmani, Olah Raga & Kesehatan</td>
                <td :class="raporKurmer['ORG']['kmr_score'] > 74 || raporKurmer['ORG']['kmr_score'] == null ? 'nilai' : 'nilaikkm'">{{raporKurmer['ORG']['kmr_score']}}</td>
                <!-- <td style="text-align:center">{{raporKurmer['ORG']['kmr_predicate']}}</td> -->
                <!-- <td>{{raporKurmer['ORG']['kmr_description1']}}<br>{{raporKurmer['ORG']['kmr_description2']}}</td> -->
            </tr>
            <tr>
                <td style="text-align:center">10</td>
                <td colspan="2">Informatika</td>
                <td :class="raporKurmer['TIK']['kmr_score'] > 74 || raporKurmer['TIK']['kmr_score'] == null ? 'nilai' : 'nilaikkm'">{{raporKurmer['TIK']['kmr_score']}}</td>
                <!-- <td style="text-align:center">{{raporKurmer['TIK']['kmr_predicate']}}</td> -->
                <!-- <td>{{raporKurmer['TIK']['kmr_description1']}}<br>{{raporKurmer['TIK']['kmr_description2']}}</td> -->
            </tr>
            <tr>
                <td style="text-align:center">11</td>
                <td colspan="2">Bahasa Jawa</td>
                <td :class="raporKurmer['JWA']['kmr_score'] > 74 || raporKurmer['JWA']['kmr_score'] == null ? 'nilai' : 'nilaikkm'">{{raporKurmer['JWA']['kmr_score']}}</td>
                <!-- <td style="text-align:center">{{raporKurmer['JWA']['kmr_predicate']}}</td> -->
                <!-- <td>{{raporKurmer['JWA']['kmr_description1']}}<br>{{raporKurmer['JWA']['kmr_description2']}}</td> -->
            </tr>
            <tr>
                <td style="text-align:center">12</td>
                <td colspan="2">Mandarin</td>
                <td :class="raporKurmer['MAN']['kmr_score'] > 74 || raporKurmer['MAN']['kmr_score'] == null ? 'nilai' : 'nilaikkm'">{{raporKurmer['MAN']['kmr_score']}}</td>
                <!-- <td style="text-align:center">{{raporKurmer['MAN']['kmr_predicate']}}</td> -->
                <!-- <td>{{raporKurmer['MAN']['kmr_description1']}}<br>{{raporKurmer['MAN']['kmr_description2']}}</td> -->
            </tr>
        </table>
        <div class="row" style="margin-right: 10px">
            <div class="col-lg-8">
                <table class="subrapor" style="margin-left: 35px">
                    <tr>
                        <td style="text-align:left; font-weight: bold">B. PENGEMBANGAN DIRI</td>
                    </tr>
                </table>
                <table class="absensi" style="margin-left:35px">
                    <tr>
                        <td style="width:10%"><b>No</b></td>
                        <td style="width:50%"><b>Jenis Kegiatan</b></td>
                        <td style="width:10%"><b>Predikat</b></td>
                        <td style="width:30%"><b>Keterangan</b></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>{{raporKurmer['kmr_extracurricular1']}}</td>
                        <td>{{raporKurmer['kmr_extracurricular1_score']}}</td>
                        <td>{{raporKurmer['kmr_extracurricular1_predicate']}}</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>{{raporKurmer['kmr_extracurricular2']}}</td>
                        <td>{{raporKurmer['kmr_extracurricular2_score']}}</td>
                        <td>{{raporKurmer['kmr_extracurricular2_predicate']}}</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>{{raporKurmer['kmr_extracurricular3']}}</td>
                        <td>{{raporKurmer['kmr_extracurricular3_score']}}</td>
                        <td>{{raporKurmer['kmr_extracurricular3_predicate']}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-4">
                <table style="margin-top: 10px; font-size: 12px;">
                    <tr>
                        <td style="font-weight: bold">C. KETIDAKHADIRAN</td>
                    </tr>
                </table>
                <table class="absensi" style="margin-left:0">
                    <tr>
                        <td style="width:50%"><b>Sakit</b></td>
                        <td>{{raporKurmer['kmr_attedance_sick']?raporKurmer['kmr_attedance_sick']+' hari':'-'}}</td>
                    </tr>
                    <tr>
                        <td style="width:33%"><b>Ijin</b></td>
                        <td>{{raporKurmer['kmr_attedance_excuse']?raporKurmer['kmr_attedance_excuse']+' hari':'-'}}</td>
                    </tr>
                    <tr>
                        <td style="width:33%"><b>Tanpa Keterangan</b></td>
                        <td>{{raporKurmer['kmr_attedance_alpha']?raporKurmer['kmr_attedance_alpha']+' hari':'-'}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <table class="subrapor">
            <tr>
                <td style="width:660px; font-weight: bold">D. CATATAN WALIKELAS</td>
            </tr>
        </table>
        <table class="nilai">
            <tr>
                <td colspan="3"><center><i>{{raporKurmer["kmr_note_godword"]}}</i><br><b>{{raporKurmer["kmr_note_verse"]}}</b></center><br>{{raporKurmer["kmr_note"]}}</td>
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
                <td></td>
                <td></td>
                <td><br><br><br></td>
            </tr>
            <tr>
                <td>..................................</td>
                <td style="text-align:center;">{{raporKurmer['walikelas']}}</td>
                <td>Yurui, S.Pd., M.M.</td>
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
            margin-top: 10px;
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
            width: 90%;
        }
        table.ki1ki2 td, th {
            border: 1px solid black;
            padding: 5px;
        }
        table.identitas {
            margin-left: auto;
            margin-right: auto;
            font-size:13px;
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
            font-size:11px;
            border: 1px solid black;
            border-collapse: collapse;
            width: 90%;
        }
        table.absensi td, th {
            border: 1px solid black;
            padding: 5px;
            text-align:center;
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
            width: 95%;
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
    name: 'raporKurmerForm',
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
            //raporakhirs: state => state.raporakhirs,
            raporKurmer : state => state.raporkurmer
        }),
        ...mapState(['token']),
    },
    methods: {
    },

}
</script>
