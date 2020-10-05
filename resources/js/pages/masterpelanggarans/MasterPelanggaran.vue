<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="$bvModal.show('add-modal')">Tambah</b-button>
                        <b-modal id="add-modal">
                            <template v-slot:modal-title>
                                Tambah Pelanggaran
                            </template>
                            <pelanggaran-form></pelanggaran-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block @click="simpanMPbaru"
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
                                    block @click="editMPlama"
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
                    <template v-slot:cell(mp_pelanggaran)="row">
                        {{ row.item.mp_pelanggaran }}
                    </template>
                    <template v-slot:cell(mp_kategori)="row">
                        <span class="badge badge-danger" v-if="row.item.mp_kategori == 'Berat'">Berat</span>
                        <span class="badge badge-success" v-if="row.item.mp_kategori == 'Ringan'">Ringan</span>
                        <span class="badge badge-warning" v-if="row.item.mp_kategori == 'Sedang'">Sedang</span>
                    </template>
                    <!--template v-slot:cell(mp_kategori)="row">
                        {{ row.item.mp_kategori ? row.item.mp_kategori:'-' }}
                    </template-->
                    <template v-slot:cell(mp_poin)="row">
                        {{ row.item.mp_poin ? row.item.mp_poin:'-'  }}
                    </template>
                    <template v-slot:cell(actions)="row">
                        <button class="btn btn-warning btn-sm" @click="editMPelanggaran(row.item.id)"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" @click="deleteMP(row.item.id)"><i class="fa fa-trash"></i></button>
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

export default {
    name: 'DataMasterPelanggaran',
    created() {
        this.getMP()
    },
    data() {
        return {
            fields: [
                { key: 'mp_pelanggaran', label: 'Pelanggaran', sortable: true },
                { key: 'mp_kategori', label: 'Kategori', sortable: true },
                { key: 'mp_poin', label: 'Poin' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('masterpelanggaran', {
            pelanggarans: state => state.MP_data
        }),
        page: {
            get() {
                return this.$store.state.masterpelanggaran.page
            },
            set(val) {
                this.$store.commit('masterpelanggaran/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getMP()
        },
        search() {
            this.getMP(this.search)
        }
    },
    methods: {
        ...mapActions('masterpelanggaran', ['submitMP','updateMP','editMP','getMP', 'removeMP']),
        simpanMPbaru(){
            this.submitMP().then(() => {
                this.$bvModal.hide('add-modal'),
                this.getMP()
            })
        },
        editMPlama(){
            this.updateMP().then(() => {
                this.$bvModal.hide('edit-modal'),
                this.getMP()
            })
        },
        editMPelanggaran(kode){
            this.editMP({
                kode: kode
            }),
            this.$bvModal.show('edit-modal')
        },
        deleteMP(id) {
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
                    this.removeMP(id) //JIKA SETUJU MAKA PERMINTAAN HAPUS AKAN DI EKSEKUSI
                }
            })
        }
    },
    components: {
        'pelanggaran-form': FormPelanggaran
    }
}
</script>