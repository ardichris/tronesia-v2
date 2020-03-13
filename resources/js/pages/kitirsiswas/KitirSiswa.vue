<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >
                        <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="$bvModal.show('my-modal')">Tambah</b-button>
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
                            <input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search">
                        </span>
                    </div>
                </div>
            </div>
            <div class="panel-body">
              
              	<!-- TABLE UNTUK MENAMPILKAN LIST PELANGGARAN -->
                <b-table striped hover bordered :items="absensis.data" :fields="fields" show-empty>                	
                    <template v-slot:cell(siswa_id)="row">
                        {{ row.item.siswa_id ? row.item.siswa.siswa_nama:'-' }}
                    </template>
                    <template v-slot:cell(actions)="row">
                        <button class="btn btn-warning btn-sm" @click="editAB(row.item.absensi_kode)"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" @click="deleteAbsensi(row.item.id)"><i class="fa fa-trash"></i></button>
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
        this.getAbsensi()
    },
    data() {
        return {
            fields: [
                { key: 'absensi_kode', label: 'Kode' },
                { key: 'siswa_id', label: 'Nama Lengkap' },
                { key: 'absensi_tanggal', label: 'Tanggal' },
                { key: 'absensi_jenis', label: 'Jenis' },
                { key: 'absensi_keterangan', label: 'Keterangan' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('absensi', {
            absensis: state => state.absensis,
            absensi: state => state.absensi,
            siswas: state => state.siswas
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
            this.getAbsensi()
        },
        search() {
            this.getAbsensi(this.search)
        }
    },
    methods: {
        ...mapActions('absensi', ['editAbsensi','getAbsensi', 'removeAbsensi','submitAbsensi','updateAbsensi']),
        ...mapMutations('absensi', ['CLEAR_FORM']),
        editABsaja(){
            this.updateAbsensi().then(() => {
                this.$bvModal.hide('edit-modal'),
                this.getAbsensi()
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
                this.getAbsensi()
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
            })
        }
    },
    components: {
        'absensi-form': FormAbsensi
    }
}
</script>