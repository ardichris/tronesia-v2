<template>
    <div class="container">
        <center><h1 style="font-family:'Verdana'; font-size: 14px">LAPORAN HASIL PEMANTAUAN PETRA</h1></center>
        <table class="identitas">
            <tr>
                <td style="width:15%">Nama Siswa</td>
                <td style="width:1%">:</td>
                <td colspan="4">{{raporPetra['siswa']['s_nama']}}</td>
            </tr>
            <tr>
                <td style="width:15%">Kelas</td>
                <td style="width:1%">:</td>
                <td style="width:40%">{{raporPetra['kelas']['kelas']['kelas_nama']}} / {{raporPetra['kelas']['absen']}}</td>
                <td style="width:20%">Semester</td>
                <td style="width:1%">:</td>
                <td style="width:20%">2 (Dua)</td>
            </tr>
            <tr>
                <td>Nomor Induk</td>
                <td>:</td>
                <td>{{raporPetra['siswa']['s_nis']}}</td>
                <td>Tahun Pelajaran</td>
                <td>:</td>
                <td>2021 - 2022</td>
            </tr>
        </table>
        <table class="nilai">
            <tr>
                <td style="text-align:center; font-weight: bold">No</td>
                <td style="width:20%; text-align:center; font-weight: bold">ASPEK</td>
                <td style="text-align:center; font-weight: bold">CAPAIAN</td>
            </tr>
            <tr>
                <td style="text-align:center">1</td>
                <td>Physical Growth</td>
                <td>{{raporPetra['rp_physical_desc']}}</td>
            </tr>
            <tr>
                <td style="text-align:center">2</td>
                <td>Emotional Intellegence</td>
                <td>{{raporPetra['rp_emotional_desc']}}</td>
            </tr>
            <tr>
                <td style="text-align:center">3</td>
                <td>Talent Development</td>
                <td>{{raporPetra['rp_talent_desc']}}</td>
            </tr>
            <tr>
                <td style="text-align:center">4</td>
                <td>Religious Education</td>
                <td>{{raporPetra['rp_religious_desc']}}</td>
            </tr>
            <tr>
                <td style="text-align:center">5</td>
                <td>Academic Excellence</td>
                <td>{{raporPetra['rp_academic_desc']}}</td>
            </tr>

        </table>
        <table class="TTD">
            <tr>
                <td colspan="2"></td>
                <td style="text-align:left; width:30%">Surabaya, 18 Juni 2022</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:left">Mengetahui,</td>
            </tr>
            <tr>
                <td>Orang Tua Siswa/Wali</td>
                <td style="width:45%"></td>
                <td style="width:20%">Kepala Sekolah</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td><!-- <img :src="'/storage/signs/'+raporPetra['ttd']+'.png'" style="width: 100px;"> -->
            </tr>
            <tr>
                <td>..................................</td>
                <td></td>
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
            margin-top: 15px;
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
    name: 'RaporPetraView',
    created() {

    },
    data() {
        return {
            fields: [
                { key: 's_nama', label: 'Nama Siswa' },
                { key: 'sisipan', label: 'Rapor Sisipan' },
                { key: 'akhir', label: 'Rapor Akhir' },
            ],
        }
    },
    computed: {
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        ...mapState('raporakhir', {
            raporPetra : state => state.raporpetra
        }),
        ...mapState(['token']),
    },
    methods: {
        ...mapActions('raporakhir', ['viewRaporPetra']),
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
