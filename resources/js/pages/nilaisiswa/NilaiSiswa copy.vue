<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="card col-md-2">
                        <div class="card-header">
                            <h3 class="card-title">Filter Nilai</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Kelas</label>
                                <v-select :options="jammengajars"
                                    v-model="nilaiselect.kelas"
                                    label="kelas"
                                    @input="searchkd">
                                    <template slot="option" slot-scope="option">
                                        {{option.mapel.mapel_kode}} - {{ option.kelas.kelas_nama }}
                                    </template>
                                </v-select>
                            </div>
                            <div class="form-group">
                                <label>Jenis Nilai</label>
                                <v-select :options="field"
                                    v-model="nilaiselect.jenis"
                                    label="text"
                                    @input="searchkd">                                    
                                </v-select>
                            </div>
                            <div class="form-group">
                                <label>Kompetensi</label>
                                <v-select
                                    :options="kompetensis.data"
                                    v-model="nilaiselect.kd"
                                    label="kd_kode"
                                    placeholder="Masukkan Kata Kunci"                                     
                                    :filterable="false">                                
                                    <template slot="no-options">
                                        Masukkan Kata Kunci
                                    </template>
                                    <template slot="option" slot-scope="option">
                                        {{ option.kd_kode }}
                                    </template>
                                </v-select>
                            </div>
                            <button type="button" class="btn btn-success" @click="getNilai">Submit Filter</button>    

                        </div>
                    </div>
                    <div class="card col-md-10">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Nilai</h3>
                        </div>
                        <div class="card-body">
                            <div id="spreadsheet" ref="spreadsheet"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card col-md-6">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Kelas Yang Diampu</h3>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-app" v-for="(row, index) in jammengajars" :key="index"  @click="JMSelected(row)">
                                <i class="fas fa-chalkboard-teacher"></i>{{row.mapel.mapel_kode}} - {{row.kelas.kelas_nama}}
                            </button>
                            <!-- <a class="btn btn-app" v-for="(row, index) in jammengajars" :key="index"  @click="JMSelected(row)">
                            <i class="fas fa-spell-check"></i>{{row.mapel.mapel_kode}} - {{row.kelas.kelas_nama}}
                            </a> -->
                        </div>                                               
                        <!-- /.card-body -->
                    </div>
                    <div class="card col-md-6">
                        <div class="card-header">
                            <h3 class="card-title">Jenis Nilai</h3>
                        </div>
                        <div class="card-body">
                            <div>
                                <button type="button" class="btn btn-app" v-for="(row, index) in field" :key="index" @click="JenisSelected(row.value)" >
                                    <i class="fas fa-spell-check"></i>{{row.text}}
                                </button>
                                <button type="button" class="btn btn-primary btn-lg btn-block" @click="getNilai">SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body" id="form-nilai">
                <div class="row">
                    <div class="card col-md-12" >
                        <div class="card-header">
                            <h3 class="card-title">Nilai Siswa</h3>
                                <span class="float-right">
                                <span class="badge badge-primary">{{nilaisiswas.kelasnama}}</span>
                                <span class="badge badge-success">{{nilaisiswas.mapelkode}}</span>
                                <span class="badge badge-warning" v-if="nilaisiswas.jenis == 'PHS'">PH</span>
                                <span class="badge badge-warning" v-else-if="nilaisiswas.jenis == 'TGS'">Tugas</span>
                                <span class="badge badge-warning" v-else-if="nilaisiswas.jenis == 'PTSPAS'">PTS-PAS</span>
                                <span class="badge badge-warning" v-else-if="nilaisiswas.jenis == 'PRK'">Praktik</span>
                                <span class="badge badge-warning" v-else-if="nilaisiswas.jenis == 'PRD'">Produk</span>
                                <span class="badge badge-warning" v-else-if="nilaisiswas.jenis == 'PRY'">Proyek</span>
                                <span class="badge badge-warning" v-else-if="nilaisiswas.jenis == 'PRT'">Portofolio</span>
                                </span>
                            
                        </div>
                        <div class="card-body">
                            <div style="overflow-x:scroll;">
                                <table class="table" width="auto">
                                    <thead>
                                        <tr>
                                            <th>Nama Siswa</th>
                                            <th width="100px"  style="text-align:center" v-for="(row, index) in nilaisiswas.kompetensi" :key="index">KD:{{row.kd_kode?row.kd_kode:row}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row, index) in nilaisiswas.siswa" :key="index">
                                            <td>
                                                {{row.s_nama}}
                                            </td>
                                            <td v-for="(row, index) in row.nilai" :key="index">
                                                <!-- <input type="text" class="form-control" v-model="row.ns_nilai"> -->
                                                <b-form-input size="sm" v-model="row.ns_nilai"></b-form-input>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <span class="float-right" style="margin-top:20px">
                                <button type="button" class="btn btn-success" @click="submitNilai">SUBMIT NILAI</button>    
                            </span>
                        </div>
                        <!-- /.card-body -->
                    </div>    
                    <!-- <nilaisiswa-form></nilaisiswa-form> -->
                </div>
            </div>
        </div>
    </div> 
</template>

<script>
import { mapActions, mapState, mapMutations } from 'vuex'
import FormNilaiSiswa from './Form.vue'
import vSelect from 'vue-select'

export default {
    name: 'DataNilaiSiswa',
    created() {
        //SEBELUM COMPONENT DI-LOAD, REQUEST DATA DARI SERVER
        this.getJamMengajar()
    },
    data() {
        return {
            //FIELD UNTUK B-TABLE, PASTIKAN KEY NYA SESUAI DENGAN FIELD DATABASE
            //AGAR OTOMATIS DI-RENDER
            search: '',
            field: [
                { value: 'PHS', text: 'PH' },
                { value: 'TGS', text: 'Tugas' },
                { value: 'PTS', text: 'PTS' },
                { value: 'PAS', text: 'PAS' },
                { value: 'PRK', text: 'Praktik' },
                { value: 'PRD', text: 'Produk' },
                { value: 'PRY', text: 'Proyek' },
                { value: 'PRT', text: 'Portofolio' },
                ],
           
            myNilai: JSON.stringify(this.nilaisiswas)
            // myCars: [                
            //     ["Civic", "Honda"],
            //      ["Z4", "BMW"],
            //  ]
        }
    },
    computed: {
        //MENGAMBIL DATA OUTLETS DARI STATE OUTLETS
        ...mapState('nilaisiswa', {
            nilaiselect: state => state.nilaiselect,
            nilaisiswas: state => state.nilaisiswas,
            nilaisiswa: state => state.nilaisiswas,
            jammengajars: state => state.jammengajars,
            kompetensis: state => state.kompetensi
            
        }),
        page: {
            get() {
                //MENGAMBIL VALUE PAGE DARI VUEX MODULE nilaisiswa
                return this.$store.state.nilaisiswa.page
            },
            set(val) {
                //APABILA TERJADI PERUBAHAN VALUE DARI PAGE, MAKA STATE PAGE
                //DI VUEX JUGA AKAN DIUBAH
                this.$store.commit('nilaisiswa/SET_PAGE', val)
            }
        },
        jExcelOptions() {
            return {
                data: this.myNilai,
                columns: [
                { type: "text", name:'s_nama', title: "Nama Siswa", width: "250px", readOnly:true },
                { type: "text", name:'nilai', title: "Nilai", width: "250px" },
                // {
                //     type: "dropdown",
                //     title: "Make",
                //     width: "250px",
                //     source: ["Alfa Romeo", "Audi", "BMW", "Honda", "Porshe"]
                // },
                // { type: "calendar", title: "Available", width: "250px" },
                // { type: "image", title: "Photo", width: "120px" },
                // { type: "checkbox", title: "Stock", width: "80px" },
                // {
                //     type: "numeric",
                //     title: "Price",
                //     width: "120px",
                //     mask: "$ #.##,00",
                //     decimal: ","
                // },
                // { type: "color", width: "100px", render: "square" }
                ]
            };
        }
    },
    watch: {
        page() {
            //APABILA VALUE DARI PAGE BERUBAH, MAKA AKAN MEMINTA DATA DARI SERVER
            this.getNilaiSiswa()
        },
        search() {
            //APABILA VALUE DARI SEARCH BERUBAH MAKA AKAN MEMINTA DATA
            //SESUAI DENGAN DATA YANG SEDANG DICARI
            this.getNilaiSiswa(this.search)
        }
    },
    methods: {
        ...mapActions('nilaisiswa', ['getJamMengajar','submitNilaiSiswa','updateNilaiSiswa','editNilaiSiswa','getNilaiSiswa', 'removeNilaiSiswa','setJM','getKD']),
        ...mapMutations('nilaisiswa', ['JM_SELECT','JENIS_SELECT']),
        searchkd(){
            this.getKD()
        },
        JMSelected(JMset){
            this.JM_SELECT(JMset)
        },
        JenisSelected(JMset){
            this.JENIS_SELECT(JMset)
        },
        getNilai(){
            this.getNilaiSiswa()
            const jExcelObj = jexcel(this.$refs["spreadsheet"], this.jExcelOptions);
            Object.assign(this, { jExcelObj });
            console.log(this.nilaisiswa);
        },
        submitNilai(){
            this.submitNilaiSiswa()
        },
        simpanNilaiSiswabaru(){
            this.submitNilaiSiswa().then(() => {
                this.$bvModal.hide('add-modal'),
                this.getNilaiSiswa()
            })
        },
        editNilaiSiswalama(){
            this.updateNilaiSiswa().then(() => {
                this.$bvModal.hide('edit-modal'),
                this.getNilaiSiswa()
            })
        },
        ubahNilaiSiswa(kode){
            this.editNilaiSiswa({
                kode: kode
            }),
            this.$bvModal.show('edit-modal')
        },
        deleteNilaiSiswa(id) {
            this.$swal({
                title: 'Kamu Yakin?',
                text: "Tindakan ini akan menghapus secara permanent!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, Lanjutkan!'
            }).then((result) => {
                if (result.value) {
                    this.removeNilaiSiswa(id) //JIKA SETUJU MAKA PERMINTAAN HAPUS AKAN DI EKSEKUSI
                }
            })
        }
    },
    // mounted: function() {
    //     //console.log(this.jExcelOptions);
    //     //console.log(this.$refs["spreadsheet"]);
    //     const jExcelObj = jexcel(this.$refs["spreadsheet"], this.jExcelOptions);
    //     // Object.assign(this, jExcelObj); // pollutes component instance
    //     Object.assign(this, { jExcelObj }); // tucks all methods under jExcelObj object in component instance
    //     // console.log(this.jExcelObj);
    // },
    components: {
        'nilaisiswa-form': FormNilaiSiswa,
        vSelect
    }
}
</script>

