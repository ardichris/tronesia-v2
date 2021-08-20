<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="card col-md-12">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Kelas Yang Diampu</h3>
                        </div>
                        <div class="card-body">
                            <a class="btn btn-app" v-for="(row, index) in jammengajars" :key="index"  @click="JMSelected(row)">
                            <i class="fas fa-spell-check"></i>{{row.mapel.mapel_kode}} - {{row.kelas.kelas_nama}}
                            </a>
                            <div>
                                <b-form-select v-model="nilaiselect.jenis" class="mb-3" @change="getNilai">
                                    <b-form-select-option :value="null"></b-form-select-option>
                                    <b-form-select-option value="PHS">PH</b-form-select-option>
                                    <b-form-select-option value="TGS">Tugas</b-form-select-option>
                                    <b-form-select-option value="PTSPAS">PTS / PAS</b-form-select-option>
                                    <b-form-select-option value="PRK">Praktik</b-form-select-option>
                                    <b-form-select-option value="PRY">Proyek</b-form-select-option>
                                    <b-form-select-option value="PRD">Produk</b-form-select-option>
                                    <b-form-select-option value="PRT">Portofolio</b-form-select-option>
                                </b-form-select>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <div class="panel-body" id="form-nilai">
                <div class="row">
                    <div class="card col-md-12">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Nilai Siswa</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" >
                                    <thead>
                                        <tr>
                                            <th width="400px">Nama Siswa</th>
                                            <th width="100px" v-for="(row, index) in nilaisiswas.kompetensi" :key="index">{{row.kd_kode?row.kd_kode:row}}</th>
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
                        </div>
                        <!-- /.card-body -->
                    </div>    
                    <nilaisiswa-form></nilaisiswa-form>
                </div>
            </div>
        </div>
    </div> 
</template>

<script>
import { mapActions, mapState, mapMutations } from 'vuex'
import FormNilaiSiswa from './Form.vue'

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
            search: ''
        }
    },
    computed: {
        //MENGAMBIL DATA OUTLETS DARI STATE OUTLETS
        ...mapState('nilaisiswa', {
            nilaiselect: state => state.nilaiselect,
            nilaisiswas: state => state.nilaisiswas,
            jammengajars: state => state.jammengajars
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
        ...mapActions('nilaisiswa', ['getJamMengajar','submitNilaiSiswa','updateNilaiSiswa','editNilaiSiswa','getNilaiSiswa', 'removeNilaiSiswa','setJM']),
        ...mapMutations('nilaisiswa', ['JM_SELECT']),
        JMSelected(JMset){
            this.JM_SELECT(JMset)
        },
        getNilai(){
            this.getNilaiSiswa()
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
    components: {
        'nilaisiswa-form': FormNilaiSiswa
    }
}
</script>

