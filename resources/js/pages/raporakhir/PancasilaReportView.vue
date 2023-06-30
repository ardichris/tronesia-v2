<template>
<div>
<div ref='content'>
    <center><h1 style="font-family:'Verdana'; font-size: 14px">RAPOR PROJEK PENGUATAN<br>PROFIL PELAJAR PANCASILA</h1></center>
    <table class="identitas">
        <tr>
            <td style="width:15%">Nama Siswa</td>
            <td style="width:1%">:</td>
            <td colspan="4">{{pancasilaReport['siswa']['s_nama']}}</td>
        </tr>
        <tr>
            <td style="width:15%">Kelas</td>
            <td style="width:1%">:</td>
            <td style="width:40%">{{pancasilaReport['kelas']['kelas']['kelas_nama']}} / {{pancasilaReport['kelas']['absen']}}</td>
            <td style="width:20%">Semester</td>
            <td style="width:1%">:</td>
            <td style="width:20%">2 (Dua)</td>
        </tr>
        <tr>
            <td>Nomor Induk</td>
            <td>:</td>
            <td>{{pancasilaReport['siswa']['s_nis']}}</td>
            <td>Tahun Pelajaran</td>
            <td>:</td>
            <td>2022 - 2023</td>
        </tr>
    </table>
    <table class="identitas" v-for="(row,index) in pancasilaReport.pr_project" v-bind:key="index" style="margin-top:20px">
        <tr>
            <td><b>Projek {{index+1}} | {{row.pp_name}}</b></td>
        </tr>
        <tr>
            <td>{{row.pp_desc}}</td>
        </tr>
    </table>
    <div v-for="(rowproject,indexproject) in pancasilaReport.pr_project" v-bind:key="indexproject">
        <table class="nilai" style="margin-top:10px">
            <tr>
                <td style="width:50%"><b>{{rowproject.pp_name}}</b></td>
                <td style="text-align:center">MB</td>
                <td style="text-align:center">SB</td>
                <td style="text-align:center">BSH</td>
                <td style="text-align:center">SAB</td>

            </tr>
            <tr>
                <td v-if="rowproject.element[0]!=null" colspan="5">Bergotong Royong</td>
            </tr>
            <tr v-for="(rowdetail,indexdetail) in rowproject.element[0]" v-bind:key="indexdetail">
                <td><b>{{rowdetail.pe_subelement==rowdetail.pe_fased?rowdetail.pe_element:rowdetail.pe_subelement}}</b><br>{{rowdetail.pe_fased}}</td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='MB'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='SB'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='BSH'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='SAB'?'✔':''}}</a></td>
            </tr>
            <tr>
                <td v-if="rowproject.element[1]!=null" colspan="5">Beriman, Bertakwa Kepada Tuhan Yang Maha Esa dan Berakhlak Mulia</td>
            </tr>
            <tr v-for="(rowdetail,indexdetail) in rowproject.element[1]" v-bind:key="indexdetail">
                <td><b>{{rowdetail.pe_subelement==rowdetail.pe_fased?rowdetail.pe_element:rowdetail.pe_subelement}}</b><br>{{rowdetail.pe_fased}}</td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='MB'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='SB'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='BSH'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='SAB'?'✔':''}}</a></td>
            </tr>
            <tr>
                <td v-if="rowproject.element[2]!=null" colspan="5">Berkhebinekaan Global</td>
            </tr>
            <tr v-for="(rowdetail,indexdetail) in rowproject.element[2]" v-bind:key="indexdetail">
                <td><b>{{rowdetail.pe_subelement==rowdetail.pe_fased?rowdetail.pe_element:rowdetail.pe_subelement}}</b><br>{{rowdetail.pe_fased}}</td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='MB'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='SB'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='BSH'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='SAB'?'✔':''}}</a></td>
            </tr>
            <tr>
                <td v-if="rowproject.element[3]!=null" colspan="5">Bernalar Kritis</td>
            </tr>
            <tr v-for="(rowdetail,indexdetail) in rowproject.element[3]" v-bind:key="indexdetail">
                <td><b>{{rowdetail.pe_subelement==rowdetail.pe_fased?rowdetail.pe_element:rowdetail.pe_subelement}}</b><br>{{rowdetail.pe_fased}}</td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='MB'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='SB'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='BSH'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='SAB'?'✔':''}}</a></td>
            </tr>
            <tr>
                <td v-if="rowproject.element[4]!=null" colspan="5">Kreatif</td>
            </tr>
            <tr v-for="(rowdetail,indexdetail) in rowproject.element[4]" v-bind:key="indexdetail">
                <td><b>{{rowdetail.pe_subelement==rowdetail.pe_fased?rowdetail.pe_element:rowdetail.pe_subelement}}</b><br>{{rowdetail.pe_fased}}</td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='MB'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='SB'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='BSH'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='SAB'?'✔':''}}</a></td>
            </tr>
            <tr>
                <td v-if="rowproject.element[5]!=null" colspan="5">Mandiri</td>
            </tr>
            <tr v-for="(rowdetail,indexdetail) in rowproject.element[5]" v-bind:key="indexdetail">
                <td><b>{{rowdetail.pe_subelement==rowdetail.pe_fased?rowdetail.pe_element:rowdetail.pe_subelement}}</b><br>{{rowdetail.pe_fased}}</td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='MB'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='SB'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='BSH'?'✔':''}}</a></td>
                <td style="text-align:center"><a v-if="rowdetail.score[0]">{{rowdetail.score[0]['ps_score']=='SAB'?'✔':''}}</a></td>
            </tr>

        </table>
        <table class="nilai" style="margin-top:10px; border-style:none">
            <tr><b>Catatan Proses :</b></tr>
            <tr>{{rowproject.comment}}</tr>
        </table>
    </div>
</div>
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
import jspdf from 'jspdf'

export default {
    name: 'PancasilaReportView',
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
            pancasilaReport : state => state.pancasilareport
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
        },
        exportPDF(){
            const doc = new jspdf()
            doc.text("Hello world!", 10, 10);
            doc.save("a4.pdf");
            const html = this.$refs.content.innerHTML
            doc.fromHTML(html,15,15,{
                width:150
            })
            doc.save("pancasilareport.pdf")
        }
    },
    components: {
    }

}
</script>
