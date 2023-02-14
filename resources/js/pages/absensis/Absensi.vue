<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >
                        <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="$bvModal.show('my-modal')">Tambah</b-button>
                        <b-modal id="siswa-modal" hide-footer>
                            <template v-slot:modal-title>
                                Data Siswa
                            </template>
                            <div class="form-group">
                                <div class="timeline">
                                    <div>
                                        <i class="fas fa-user bg-green"></i>
                                        <div class="timeline-item">
                                            <h5 class="text-dark text-sm font-weight-bold mb-0">Nama</h5>
                                            <p class="text-secondary font-weight-bold text-sm mt-1 mb-0">{{siswadata.s_nama}}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="fas fa-home bg-blue"></i>
                                        <div class="timeline-item">
                                            <h5 class="text-dark text-sm font-weight-bold mb-0">Alamat Domisili</h5>
                                            <p class="text-secondary font-weight-bold text-sm mt-1 mb-0">{{siswadata.s_domisili_alamat?siswadata.s_domisili_alamat:"-"}}</p>
                                        </div>
                                        <div class="timeline-item">
                                            <h5 class="text-dark text-sm font-weight-bold mb-0">Alamat KK</h5>
                                            <p class="text-secondary font-weight-bold text-sm mt-1 mb-0">{{siswadata.s_kk_alamat?siswadata.s_kk_alamat:"-"}}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="fas fa-phone bg-yellow"></i>
                                        <div class="timeline-item">
                                            <h5 class="text-dark text-sm font-weight-bold mb-0">Kontak Telp</h5>
                                            <p class="text-secondary font-weight-bold text-sm mt-1 mb-0">{{siswadata.s_notelp?siswadata.s_notelp:"-"}}</p>
                                        </div>
                                        <div class="timeline-item">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">Kontak HP</h6>
                                            <p class="text-secondary font-weight-bold text-sm mt-1 mb-0">{{siswadata.s_nohandphone?siswadata.s_nohandphone:"-"}}</p>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </b-modal>
                        <b-modal id="add-modal">
                            <template v-slot:modal-title>
                                Tambah Absensi
                            </template>
                            <absensi-form></absensi-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"
                                    block @click="simpanABbaru"
                                >
                                    Simpan
                                </b-button>
                            </template>
                        </b-modal>
                        <b-modal id="edit-modal">
                            <template v-slot:modal-title>
                                Edit Absensi
                            </template>
                            <absensi-form></absensi-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"
                                    block @click="editABsaja"
                                >
                                    Update
                                </b-button>
                            </template>
                        </b-modal>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="float-right">
                            <b-button variant="primary" size="sm" @click="cari()"><i class="fas fa-search"></i></b-button>
                        </span>
                        <span class="float-right">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search">
                        </span>
                        <span class="float-right">
                            <b-form-select
                                v-model="kelas"
                                size="sm"
                                @change="cari()"
                                :options="kelasdata.data"
                                required
                                >
                            </b-form-select>
                        </span>
                    </div>
                </div>
            </div>
            <div class="panel-body">

              	<!-- TABLE UNTUK MENAMPILKAN LIST PELANGGARAN -->
                <b-table striped hover bordered :items="absensis.data" :fields="fields" show-empty>
                    <template v-slot:cell(siswa_id)="row">
                        {{ row.item.siswa_id ? row.item.siswa.s_nama:'-' }}<br>
                        <div class="badge badge-primary" v-if="row.item.kelas.substr(0, 2)=='IX'">{{row.item.kelas}}</div>
                        <div class="badge badge-danger" v-else-if="row.item.kelas.substr(0, 4)=='VIII'">{{row.item.kelas}}</div>
                        <div class="badge badge-warning" v-else>{{row.item.kelas}}</div>
                        <button class="badge badge-success" @click="ceksiswa(row.item.siswa.uuid)"><i class="fa fa-search"></i></button>
                    </template>
                    <template v-slot:cell(ab_status)="row">
                        <span class="badge badge-success" v-if="row.item.ab_status == 'Approved'">Approved</span>
                        <span class="badge badge-danger" v-else-if="row.item.ab_status == 2">Rejected</span>
                        <span class="badge badge-info" v-else-if="row.item.ab_status == 'Issued'">Issued</span>
                        <span class="badge badge-dark" v-else-if="row.item.ab_status == 3">Archived</span>
                    </template>
                    <template v-slot:cell(actions)="row">
                        <button class="btn btn-success btn-sm" v-if="(authenticated.role==0 || authenticated.role==5) && row.item.ab_status != 'Approved'" @click="updateABStatus(row.item.absensi_kode,'Approved')"><i class="far fa-check-circle"></i></button>
                        <button class="btn btn-info btn-sm" v-if="(authenticated.role==0 || authenticated.role==5) && row.item.ab_status == 'Approved'" @click="updateABStatus(row.item.absensi_kode,'Issued')"><i class="fa fa-clock"></i></button>
                        <button class="btn btn-warning btn-sm" v-if="authenticated.id==(row.item.created_by && row.item.ab_status!='Approved') || authenticated.role == 0" @click="editAB(row.item.absensi_kode)"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" v-if="authenticated.id==(row.item.created_by && row.item.ab_status!='Approved') || authenticated.role == 0" @click="deleteAbsensi(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                    <template v-slot:cell(absensi_tanggal)="row">
                        <span class="badge badge-dark">{{row.item.absensi_tanggal|formatDateView}}</span><br>
                        <span class="badge badge-info">{{row.item.creator.name}}</span>
                        <span class="badge badge-warning" v-if="row.item.updated_by!=null">{{row.item.editor.name}}</span>
                        <span class="badge badge-success" v-if="row.item.approve_by!=null">{{row.item.approve.name}}</span>
                    </template>
                </b-table>
              	<!-- TABLE UNTUK MENAMPILKAN LIST PELANGGARAN -->

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="absensis.data"><i class="fa fa-bars"></i> {{ absensis.data.length }} item dari {{ absensis.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="absensis.meta.total"
                                :per-page="absensis.meta.per_page"
                                aria-controls="absensis"
                                v-if="absensis.data && absensis.data.length > 0"
                                ></b-pagination>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState, mapMutations } from 'vuex'
import FormAbsensi from './Form.vue'

export default {
    name: 'DataAbsensi',
    created() {
        this.refreshdata(),
        this.getKelas()
    },
    data() {
        return {
            fields: [
                { key: 'siswa_id', label: 'Nama Lengkap' },
                { key: 'absensi_jenis', label: 'Jenis' },
                { key: 'absensi_keterangan', label: 'Keterangan' },
                { key: 'ab_status', label: 'Status'},
                { key: 'absensi_tanggal', label: 'Info' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: '',
            kelas: '',
        }
    },
    computed: {
        ...mapState('absensi', {
            absensis: state => state.absensis,
            absensi: state => state.absensi,
            siswas: state => state.siswas,
            kelasdata: state => state.kelas,
            siswadata: state => state.siswa,
        }),
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        //MENGAMBIL DATA PAGE DARI STATE PELANGGARAN
        page: {
            get() {
                return this.$store.state.absensi.page
            },
            set(val) {
                this.$store.commit('absensi/SET_PAGE', val)
            }
        }
    },

    watch: {
        page() {
            this.refreshdata()
        },
        // search() {
        //     this.getAbsensi(this.search)
        // }
    },
    methods: {
        ...mapActions('absensi', ['editAbsensi','getAbsensi', 'removeAbsensi','submitAbsensi','updateAbsensi','getKelas','viewSiswa','updateStatus']),
        ...mapMutations('absensi', ['CLEAR_FORM']),
        updateABStatus(ab,status){
            this.updateStatus({
                ab: ab,
                status: status
            }).then(() => {
                this.refreshdata()
            })
        },
        ceksiswa(uuid){
            this.viewSiswa({
                uuid: uuid
            }).then(() => {
                this.$bvModal.show('siswa-modal')
            })
        },
        cari(){
            this.page = 1
            this.refreshdata()
        },
        refreshdata(){
            this.getAbsensi({
                    search: this.search,
                    kelas: this.kelas
                })
        },
        editABsaja(){
            this.updateAbsensi().then(() => {
                this.$bvModal.hide('edit-modal'),
                this.refreshdata()
            })
        },
        editAB(kode){
            this.editAbsensi({
                kode: kode
            }),
            this.$bvModal.show('edit-modal')
        },
        simpanABbaru(){
            this.submitAbsensi().then(() => {
                this.$bvModal.hide('add-modal'),
                this.refreshdata()
            })
        },
        deleteAbsensi(id) {
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
                    this.removeAbsensi(id) //JIKA SETUJU MAKA PERMINTAAN HAPUS AKAN DI EKSEKUSI
                }
            }).then(() => {
            this.refreshdata()})
        }
    },
    components: {
        'absensi-form': FormAbsensi
    }
}
</script>
