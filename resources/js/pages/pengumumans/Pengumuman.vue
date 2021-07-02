<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="$bvModal.show('add-modal')">Tambah</b-button>
                        <b-modal id="add-modal" scrollable size="xl">
                            <template v-slot:modal-title>
                                Tambah Pengumuman
                            </template>
                            <pengumuman-form></pengumuman-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block @click="simpanPengumumanbaru"
                                >
                                    Simpan
                                </b-button>
                            </template>
                        </b-modal>
                        <b-modal id="edit-modal" scrollable size="xl">
                            <template v-slot:modal-title>
                                Edit Pengumuman
                            </template>
                            <pengumuman-form></pengumuman-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block @click="updateP"
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
              
              	<!-- TABLE UNTUK MENAPengumumanILKAN LIST PELANGGARAN -->
                <b-table striped hover bordered :items="pengumumans.data" :fields="fields" show-empty>                	
                    <template v-slot:cell(p_tanggal)="row">
                        {{ row.item.p_tanggal ? row.item.p_tanggal:'' }}
                    </template>
                    <template v-slot:cell(p_kategori)="row">
                        <span class="badge badge-danger" v-if="row.item.p_kategori == 'Penting'">Penting</span>
                        <span class="badge badge-success" v-if="row.item.p_kategori == 'Siswa'">Siswa</span>
                        <span class="badge badge-warning" v-if="row.item.p_kategori == 'Guru'">Guru</span>
                    </template>
                    <template v-slot:cell(p_title)="row">
                        {{ row.item.p_title ? row.item.p_title:'-'  }}
                    </template>
                    <template v-slot:cell(actions)="row">
                        <button class="btn btn-warning btn-sm" @click="editP(row.item.id)"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" @click="deletePengumuman(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>
              	<!-- TABLE UNTUK MENAPengumumanILKAN LIST PELANGGARAN -->

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="pengumumans.data"><i class="fa fa-bars"></i> {{ pengumumans.data.length }} item dari {{ pengumumans.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="pengumumans.meta.total"
                                :per-page="pengumumans.meta.per_page"
                                aria-controls="pengumumans"
                                v-if="pengumumans.data && pengumumans.data.length > 0"
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
import FormPengumuman from './Form.vue'

export default {
    name: 'DataPengumuman',
    created() {
        this.getPengumuman()
    },
    data() {
        return {
            fields: [
                { key: 'p_tanggal', label: 'Tanggal', sortable: true },
                { key: 'p_kategori', label: 'Kategori', sortable: true },
                { key: 'p_title', label: 'Pengumuman' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('pengumuman', {
            pengumumans: state => state.p_data
        }),
        page: {
            get() {
                return this.$store.state.pengumuman.page
            },
            set(val) {
                this.$store.commit('pengumuman/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getPengumuman()
        },
        search() {
            this.getPengumuman(this.search)
        }
    },
    methods: {
        ...mapActions('pengumuman', ['submitPengumuman','updatePengumuman','editPengumuman','getPengumuman', 'removePengumuman']),
        simpanPengumumanbaru(){
            this.submitPengumuman().then(() => {
                this.$bvModal.hide('add-modal'),
                this.getPengumuman()
            })
        },
        updateP(){
            this.updatePengumuman().then(() => {
                this.$bvModal.hide('edit-modal'),
                this.getPengumuman()
            })
        },
        editP(kode){
            this.editPengumuman({
                kode: kode
            }),
            this.$bvModal.show('edit-modal')
        },
        deletePengumuman(id) {
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
                    this.removePengumuman(id) //JIKA SETUJU MAKA PERMINTAAN HAPUS AKAN DI EKSEKUSI
                }
            })
        }
    },
    components: {
        'pengumuman-form': FormPengumuman
    }
}
</script>