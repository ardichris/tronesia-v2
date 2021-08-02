<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="$bvModal.show('add-modal')">Tambah</b-button>
                        <b-modal id="add-modal" size="lg">
                            <template v-slot:modal-title>
                                Tambah Jam Mengajar
                            </template>
                            <jammengajar-form></jammengajar-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block @click="simpanJMbaru"
                                >
                                    Simpan
                                </b-button>
                            </template>
                        </b-modal>
                        <b-modal id="edit-modal">
                            <template v-slot:modal-title>
                                Edit Jam Mengajar
                            </template>
                            <editJM-form></editJM-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block @click="editJMlama"
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
                <b-table striped hover bordered :items="jammengajars.data" :fields="fields" show-empty>
                    <template v-slot:cell(guru)="row">
                        {{ row.item.guru_id ? row.item.guru.name:'-' }}
                    </template>
                    <template v-slot:cell(actions)="row">
                        <router-link :to="{ name: 'jammengajar.view', params: {id: row.item.id} }" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></router-link>
                        <button class="btn btn-warning btn-sm" @click="ubahJM(row.item.id)"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" @click="deleteJM(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="jammengajars.data"><i class="fa fa-bars"></i> {{ jammengajars.data.length }} item dari {{ jammengajars.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="jammengajars.meta.total"
                                :per-page="jammengajars.meta.per_page"
                                aria-controls="jammengajars"
                                v-if="jammengajars.data && jammengajars.data.length > 0"
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
import FormJM from './Form.vue'
import FormJMedit from './FormEdit.vue'

export default {
    name: 'DataJM',
    created() {
        this.getJM()
    },
    data() {
        return {
            fields: [
                { key: 'kelas.kelas_nama', label: 'Kelas', sortable: true },
                { key: 'mapel.mapel_nama', label: 'Mata Pelajaran', sortable: true },
                { key: 'guru', label: 'Guru Pengajar', sortable: true },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        //MENGAMBIL DATA OUTLETS DARI STATE OUTLETS
        ...mapState('jammengajar', {
            jammengajars: state => state.jammengajars
        }),
        page: {
            get() {
                return this.$store.state.jammengajar.page
            },
            set(val) {
                this.$store.commit('jammengajar/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getJM()
        },
        search() {
            this.getJM(this.search)
        }
    },
    methods: {
        ...mapActions('jammengajar', ['submitJM','updateJM','editJM','getJM', 'removeJM']),
        simpanJMbaru(){
            this.submitJM().then(() => {
                this.$bvModal.hide('add-modal'),
                this.getJM()
            })
        },
        editJMlama(){
            this.updateJM().then(() => {
                this.$bvModal.hide('edit-modal'),
                this.getJM()
            })
        },
        ubahJM(kode){
            this.editJM({
                kode: kode
            }),
            this.$bvModal.show('edit-modal')
        },
        deleteJM(id) {
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
                    this.removeJM(id) //JIKA SETUJU MAKA PERMINTAAN HAPUS AKAN DI EKSEKUSI
                }
            })
        }
    },
    components: {
        'jammengajar-form': FormJM,
        'editJM-form': FormJMedit
    }
}
</script>

