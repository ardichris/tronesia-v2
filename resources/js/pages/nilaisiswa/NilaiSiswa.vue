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
                                    label="id"
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
                            <div>
                                <button type="button" class="btn btn-info" @click="submitNilai(jExcelObj.getData())">Submit Nilai</button>    
                            </div>
                        </div>
                        
                    </div>
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
           
            myNilai: JSON.stringify(this.nilaisiswa)
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
                data: JSON.stringify(this.siswaaktif),
                columns: [
                { type: "text", name:'s_nama', title: "Nama Siswa", width: "250px", readOnly:true },
                { type: "text", name:'nilai', title: "Nilai", width: "250px" },
                { type: "hidden", name:'id', title: "Nilai", width: "250px"},
                { type: "hidden", name:'id_nilai', title: "Nilai", width: "250px"},
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
        ...mapMutations('nilaisiswa', ['JM_SELECT','JENIS_SELECT','SET_NILAI']),
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
            this.getNilaiSiswa().then(() => {
                const jExcelObj = jexcel(this.$refs["spreadsheet"], this.jExcelOptions);
                Object.assign(this, { jExcelObj });
            })
        },
        submitNilai(payload){
            //var tabelnilai = document.getElementById('spreadsheet').jexcel;
            this.SET_NILAI(payload)
            this.submitNilaiSiswa().then(window.location.reload())
            
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

