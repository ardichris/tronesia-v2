<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="$bvModal.show('add-modal')">Add</b-button>
                        <b-button variant="success" size="sm" v-b-modal="'add-grup'" @click="$bvModal.show('add-grup')">Add-Grup</b-button>
                        <b-modal id="add-grup" size="lg">
                            <template v-slot:modal-title>
                                Tambah Pelanggaran
                            </template>
                            <add-grup-form></add-grup-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"
                                    block @click="simpanPLbaru"
                                >
                                    Simpan
                                </b-button>
                            </template>
                        </b-modal>
                        <b-modal id="add-modal">
                            <template v-slot:modal-title>
                                Tambah Pelanggaran
                            </template>
                            <pelanggaran-form></pelanggaran-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"
                                    block @click="simpanPLbaru"
                                >
                                    Simpan
                                </b-button>
                            </template>
                        </b-modal>
                        <b-modal id="edit-modal">
                            <template v-slot:modal-title>
                                Edit Pelanggaran
                            </template>
                            <pelanggaran-form></pelanggaran-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"
                                    block @click="editPLlama"
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
                <b-table striped hover bordered :items="pelanggarans.data" :fields="fields" show-empty>
                    <template v-slot:cell(siswa_id)="row">
                        {{ row.item.siswa_id ? row.item.siswa.s_nama:'-' }}
                        <div class="badge badge-primary" v-if="row.item.kelas.substr(0, 2)=='IX'">{{row.item.kelas}}</div>
                        <div class="badge badge-danger" v-else-if="row.item.kelas.substr(0, 4)=='VIII'">{{row.item.kelas}}</div>
                        <div class="badge badge-warning" v-else>{{row.item.kelas}}</div>
                    </template>
                    <template v-slot:cell(pelanggaran)="row">
                        {{ row.item.mp_id ? row.item.masterpelanggaran.mp_pelanggaran:'' }} {{ row.item.pelanggaran_jenis ? row.item.pelanggaran_jenis:'' }}
                    </template>
                    <template v-slot:cell(guru)="row">
                        <span class="badge badge-info">{{ row.item.pelanggaran_tanggal ? row.item.pelanggaran_tanggal:'-' | formatDateView }}</span><br>
                        <span class="badge badge-dark">{{row.item.user.name}}</span>
                        <span class="badge badge-warning" v-if="row.item.jurnal_id">{{ row.item.siswa.kelas ? row.item.siswa.kelas.kelas_nama:'' }} <span class="badge badge-danger">{{ row.item.jurnal ? row.item.jurnal.jm_jampel:'' }}</span></span>
                    </template>
                    <template v-slot:cell(actions)="row">
                        <button class="btn btn-warning btn-sm" v-if="authenticated.id==row.item.user_id || authenticated.role == 0" @click="editPL(row.item.pelanggaran_kode)"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" v-if="authenticated.id==row.item.user_id || authenticated.role == 0" @click="deletePelanggaran(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>
              	<!-- TABLE UNTUK MENAMPILKAN LIST PELANGGARAN -->

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="pelanggarans.data"><i class="fa fa-bars"></i> {{ pelanggarans.data.length }} item dari {{ pelanggarans.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="pelanggarans.meta.total"
                                :per-page="pelanggarans.meta.per_page"
                                aria-controls="pelanggarans"
                                v-if="pelanggarans.data && pelanggarans.data.length > 0"
                                ></b-pagination>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'
import FormPelanggaran from './Form.vue'
import AddGrup from './addGrupForm.vue'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'

export default {
    name: 'DataPelanggaran',
    created() {
        this.getPelanggarans()
        this.getKelas()
    },
    data() {
        return {
            fields: [
                { key: 'siswa_id', label: 'Nama Siswa', sortable: true },
                { key: 'pelanggaran', label: 'Pelanggaran' },
                { key: 'pelanggaran_keterangan', label: 'Keterangan' },
                { key: 'guru', label: 'Info', sortable: true },
                { key: 'actions', label: 'Aksi' }
            ],
            search: '',
            kelas: '',
            // pelanggaran: {
            //     pelanggar: [
            //         { siswa: null, pelanggaran_jenis: null, pelanggaran_keterangan: null }
            //     ]
            // }
        }
    },
    computed: {
        ...mapState('pelanggaran', {
            pelanggarans: state => state.pelanggarans,
            pelanggaran: state=> state.pelanggaranGrup,
            siswas: state => state.siswas,
            kelasdata: state => state.kelas,

        }),
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        page: {
            get() {
                return this.$store.state.pelanggaran.page
            },
            set(val) {
                this.$store.commit('pelanggaran/SET_PAGE', val)
            }
        },
        filterPelanggar() {
            return _.filter(this.pelanggaran.pelanggar, function(item) {
                return item.siswa == null
            })
        },
    },
    watch: {
        page() {
            this.getPelanggarans()
        },
        search() {
            this.getPelanggarans(this.search)
        }
    },
    methods: {
        ...mapActions('pelanggaran', ['getSiswaKelas','getSiswas','submitPelanggaran','updatePelanggaran','editPelanggaran','getPelanggarans', 'removePelanggaran','getKelas']),
        cariSiswa(kelas){
            this.getSiswaKelas({
                kelas: kelas
            })
        },
        removePelanggar(index) {
            if (this.pelanggaran.pelanggar.length > 0) {
                this.pelanggaran.pelanggar.splice(index, 1)
            }
        },
        addPelanggar() {
            if (this.filterPelanggar.length == 0) {
                this.pelanggaran.pelanggar.push({ siswa_id: null, pelanggaran_jenis: null, siswa: null})
            }
        },
        onSearch(search, loading) {
            this.getSiswas({
                search: search,
                loading: loading
            })
        },
        simpanPLbaru(){
            this.submitPelanggaran().then(() => {
                this.$bvModal.hide('add-modal'),
                this.$bvModal.hide('add-grup'),
                this.getPelanggarans()
            })
        },
        editPLlama(){
            this.updatePelanggaran().then(() => {
                this.$bvModal.hide('edit-modal'),
                this.getPelanggarans()
            })
        },
        editPL(kode){
            this.editPelanggaran({
                kode: kode
            }),
            this.$bvModal.show('edit-modal')
        },
        deletePelanggaran(id) {
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
                    this.removePelanggaran(id) //JIKA SETUJU MAKA PERMINTAAN HAPUS AKAN DI EKSEKUSI
                }
            })
        }
    },
    components: {
        'pelanggaran-form': FormPelanggaran,
        'add-grup-form': AddGrup,
        vSelect
    }
}
</script>
