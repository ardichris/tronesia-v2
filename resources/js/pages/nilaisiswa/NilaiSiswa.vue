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
                                    label="id">
                                    <template slot="option" slot-scope="option">
                                        {{option.mapel.mapel_kode}} - {{ option.kelas.kelas_nama }}
                                    </template>
                                    <template slot="selected-option" slot-scope="option">
                                        <span class="badge badge-primary">{{ option.kelas.kelas_nama }}</span>
                                    </template>
                                </v-select>
                            </div>
                            <div class="form-group" v-if="nilaiselect.kelas">
                                <label>Jenis Nilai</label>
                                <v-select :options="field"
                                    v-model="nilaiselect.jenis"
                                    label="text"
                                    @input="searchkd">
                                    <template slot="selected-option" slot-scope="option">
                                        <span class="badge badge-primary">{{ option.text }}</span>
                                    </template>
                                </v-select>
                            </div>
                            <div class="form-group" v-if="nilaiselect.jenis.text=='KI3'||nilaiselect.jenis.text=='KI4'">
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
                                    <template slot="selected-option" slot-scope="option">
                                        <span class="badge badge-primary">{{ option.kd_kode }}</span>
                                    </template>
                                </v-select>
                            </div>
                            <div style="margin-bottom:5px">
                            <button type="button" class="btn btn-success" v-if="nilaiselect.jenis" @click="getNilai">Submit Filter</button>
                            </div>
                            <button type="button" class="btn btn-danger" v-if="nilaiselect.jenis.text=='KI3'||nilaiselect.jenis.text=='KI4'" @click="$bvModal.show('modal-upload-nilai')">Upload Nilai</button>
                            <button type="button" class="btn btn-warning" v-if="nilaiselect.jenis.text=='KI3'||nilaiselect.jenis.text=='KI4'" @click="downloadNilai">Download Nilai</button>

                        </div>
                        <b-modal id="modal-upload-nilai" scrollable size="md">
                            <template v-slot:modal-title>
                                Pilih File Nilai {{nilaiselect.jenis.text}}
                            </template>
                            <input type="file" class="form-control" id="input-file-import" name="file_import" ref="import_file"  @change="onFileChange">
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"
                                    block  @click="submitfile()"
                                >
                                    Upload
                                </b-button>
                            </template>
                        </b-modal>
                    </div>
                    <div class="card col-md-10">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Nilai</h3>
                        </div>
                        <div class="card-body">
                            <div id="spreadsheet" ref="spreadsheet"></div>
                            <!-- <div v-if="nilaisiswa!=null">
                                <button type="button" class="btn btn-info" @click="submitNilai(jExcelObj.getData())">Submit Nilai</button>
                            </div> -->
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
//import jexcel from 'jexcel'

export default {
    name: 'DataNilaiSiswa',
    created() {
        //SEBELUM COMPONENT DI-LOAD, REQUEST DATA DARI SERVER
        this.getJamMengajar({
                kurikulum: 'kurtilas'
            })
        .then(() => {
                const jExcelObj = jexcel(this.$refs["spreadsheet"]);
                Object.assign(this, { jExcelObj });
            })
    },
    data() {
        return {
            search: '',
            field: [
                { value: 'KI3', text: 'KI3' },
                { value: 'KI4', text: 'KI4' },
                { value: 'PTS', text: 'PTS' },
                { value: 'PAS', text: 'PAS' },
                { value: 'Rapor', text: 'Rapor' },
                ],

            myNilai: JSON.stringify(this.nilaisiswa),
            import_file: '',
            error: {},
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
        ...mapState(['token']),
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
        jExcelOptionsKI3() {
            return {
                data: this.nilaisiswa,
                columns: [
                { type: "hidden", name:'id_nilai', title: "Nilai", width: "250px"},
                { type: "hidden", name:'id', title: "Nilai", width: "250px"},
                { type: "text", name:'s_nama', title: "Nama Siswa", width: "250px", readOnly:true },
                { type: "number", name:'ns_tes', title: "UH", width: "100px", readOnly:true },
                { type: "number", name:'ns_remidi', title: "REMIDI", width: "100px", readOnly:true },
                { type: "number", name:'ns_tugas', title: "TUGAS", width: "100px" , readOnly:true},
                { type: "number", name:'ns_perbaikan', title: "REMIDI", width: "100px", readOnly:true },
                { type: "text", name:'ns_nilai', title: "NA", width: "100px", readOnly:true },
                { type: "hidden", name:'ns_avg_tugas', title: "Rata2", width: "100px" },
                { type: "hidden", name:'ns_avg_tes', title: "Rata2", width: "100px" },
                { type: "hidden", name:'absen', title: "Absen", width: "250px"},
                ]
            };
        },
        jExcelOptionsKI4() {
            return {
                data: this.nilaisiswa,
                columns: [
                { type: "hidden", name:'id_nilai', title: "Nilai", width: "250px"},
                { type: "hidden", name:'id', title: "Nilai", width: "250px"},
                { type: "text", name:'s_nama', title: "Nama Siswa", width: "250px", readOnly:true },
                { type: "number", name:'ns_tugas', title: "PRAKTEK", width: "100px", readOnly:true },
                { type: "number", name:'ns_perbaikan', title: "PROYEK", width: "100px", readOnly:true },
                { type: "number", name:'ns_tes', title: "PRODUK", width: "100px", readOnly:true },
                { type: "number", name:'ns_remidi', title: "PORTOFOLIO", width: "100px", readOnly:true },
                { type: "text", name:'ns_nilai', title: "NA", width: "100px", readOnly:true },
                { type: "hidden", name:'absen', title: "Absen", width: "250px"},
                ]
            };
        },
        jExcelOptionsTest() {
            return {
                data: this.nilaisiswa,
                columns: [
                { type: "hidden", name:'id_nilai', title: "Nilai", width: "250px"},
                { type: "hidden", name:'id', title: "Nilai", width: "250px"},
                { type: "text", name:'s_nama', title: "Nama Siswa", width: "250px", readOnly:true },
                { type: "text", name:'ns_tes', title: "NILAI", width: "100px", readOnly:true },
                { type: "text", name:'ns_remidi', title: "REMIDI", width: "100px", readOnly:true },
                { type: "text", name:'ns_nilai', title: "NA", width: "100px", readOnly:true  },
                { type: "hidden", name:'absen', title: "Absen", width: "250px"},
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
        ...mapActions('nilaisiswa', ['getJamMengajar','submitNilaiSiswa','updateNilaiSiswa','editNilaiSiswa','getNilaiSiswa', 'removeNilaiSiswa','setJM','getKD','uploadNilai']),
        ...mapMutations('nilaisiswa', ['JM_SELECT','JENIS_SELECT','SET_NILAI','CLEAR_FORM']),
        onFileChange(e) {
            this.import_file = e.target.files[0];
        },
        searchkd(){
            this.nilaiselect.kd=null
            this.getKD({
                kompetensi: this.nilaiselect.jenis.text
            })
        },
        JMSelected(JMset){
            this.JM_SELECT(JMset)
        },
        JenisSelected(JMset){
            this.JENIS_SELECT(JMset)
        },
        submitfile(){
            let formData = new FormData();
            formData.append('import_file', this.import_file);
            formData.append('mapel', this.nilaiselect.kelas.mapel_id);
            formData.append('jenjang', this.nilaiselect.kelas.kelas.kelas_jenjang);
            formData.append('guru', this.nilaiselect.kelas.guru_id);
            formData.append('jenis', this.nilaiselect.jenis.text);
            this.uploadNilai(formData).then(() => {
                this.import_file = '',
                this.$bvModal.hide('modal-upload-nilai'),
                this.$swal({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    type: 'success',
                    title: 'Import Nilai Berhasil'
                })
            }).catch(() => {
                this.$swal({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    type: 'error',
                    title: 'Import Nilai Gagal'
                })
            })
        },
        downloadNilai(){
            if(this.nilaiselect.jenis.value=="KI4"){
                window.open(`/api/downloadnilaiketerampilan?api_token=${this.token}&filter=${this.nilaiselect.kelas.id}`)
            } else {
                window.open(`/api/downloadnilaipengetahuan?api_token=${this.token}&filter=${this.nilaiselect.kelas.id}`)
            }
        },
        getNilai(){
            this.getNilaiSiswa().then(() => {
                this.jExcelObj.destroy(this.$refs["spreadsheet"], true);
                jexcel.destroy(document.getElementById('spreadsheet'), true);
                if(this.nilaiselect.jenis.value=="KI3"){
                    const jExcelObj = jexcel(this.$refs["spreadsheet"], this.jExcelOptionsKI3);
                    Object.assign(this, { jExcelObj });
                }
                if(this.nilaiselect.jenis.value=="PAS"||this.nilaiselect.jenis.value=="PTS"){
                    const jExcelObj = jexcel(this.$refs["spreadsheet"], this.jExcelOptionsTest);
                    Object.assign(this, { jExcelObj });
                }
                if(this.nilaiselect.jenis.value=="KI4"){
                    const jExcelObj = jexcel(this.$refs["spreadsheet"], this.jExcelOptionsKI4);
                    Object.assign(this, { jExcelObj });
                }
                this.jExcelObj.setData(this.nilaisiswa)
                })
            // .then(() => {
            //     const jExcelObj = jexcel(this.$refs["spreadsheet"], this.jExcelOptions);
            //     Object.assign(this, { jExcelObj });
            // })
        },
        submitNilai(payload){
            //var tabelnilai = document.getElementById('spreadsheet').jexcel;
            this.SET_NILAI(payload)
            this.submitNilaiSiswa()
            .then(() => {
                this.$swal({
                    toast: true,
                    position: 'top-end',
                    title: 'Nilai tersimpan',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 1500
                }),
                this.getNilai()
            })
            .catch(() => {
                this.$swal({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    type: 'error',
                    title: 'Gagal'
                })
            })

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
    },
    destroyed() {
        this.CLEAR_FORM()
    }
}
</script>

