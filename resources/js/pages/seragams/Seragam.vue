<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <!--router-link :to="{ name: 'seragam.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link-->
                        <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="$bvModal.show('add-modal')">Tambah</b-button>
                        <b-modal id="add-modal" scrollable size="lg">
                            <template v-slot:modal-title>
                                Tambah Seragam
                            </template>
                            <seragam-form></seragam-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block @click="simpanSbaru"
                                >
                                    Simpan
                                </b-button>
                            </template>
                        </b-modal>
                        <b-modal id="edit-modal" scrollable size="lg">
                            <template v-slot:modal-title>
                                Edit Seragam
                            </template>
                            <seragam-form></seragam-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block @click="editSsaja"
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
                <b-table striped hover bordered :items="seragams.data" :fields="fields" show-empty>
                    <template v-slot:cell(siswa_id)="row">
                        {{row.item.siswa.siswa_nama}}
                    </template>
                    <template v-slot:cell(user_id)="row">
                        {{row.item.user.name}}
                    </template>
                    <template v-slot:cell(s_jumlah)="row">
                        {{row.item.s_jumlah}} {{row.item.barang.barang_satuan}}
                    </template>
                    <template v-slot:cell(s_status)="row">
                        <span class="badge badge-success" v-if="row.item.s_status == 'Complete'">{{row.item.s_status}}</span>
                        <span class="badge badge-dark" v-else>{{row.item.s_status}}</span>
                    </template>
                    <template v-slot:cell(actions)="row">
                        <!--router-link :to="{ name: 'seragam.view', params: {id: row.item.seragam_kode} }" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></router-link>
                        <router-link :to="{ name: 'seragam.edit', params: {id: row.item.s_kode} }" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></router-link-->
                        <button class="btn btn-warning btn-sm" @click="editS(row.item.s_kode)"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" @click="deleteSeragam(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="seragams.data"><i class="fa fa-bars"></i> {{ seragams.data.length }} item dari {{ seragams.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="seragams.meta.total"
                                :per-page="seragams.meta.per_page"
                                aria-controls="seragams"
                                v-if="seragams.data && seragams.data.length > 0"
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
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
import FormSeragam from './Form.vue'

export default {
    name: 'DataSeragam',
    created() {
        this.getSeragam()
    },
    data() {
        return {
            fields: [
                { key: 's_kode', label: 'Kode', sortable: true },
                { key: 'siswa_id', label: 'Siswa' },
                { key: 's_status', label: 'Status', sortable: true },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('seragam', {
            seragam: state => state.seragam,
            seragams: state => state.seragams,
            barangs: state => state.barangs

        }),
        page: {
            get() {
                return this.$store.state.seragam.page
            },
            set(val) {
                this.$store.commit('seragam/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getSeragam()
        },
        search() {
            this.getSeragam(this.search)
        }
    },
    methods: {
        ...mapActions('seragam', ['updateSeragam','editSeragam','submitSeragam','getSeragam', 'removeSeragam','getBarang']),
        simpanSbaru(){
            this.submitSeragam().then(() => {
                this.$bvModal.hide('add-modal'),
                this.getSeragam()
            })
        },
        editSsaja(){
            this.updateSeragam(),
            this.$bvModal.hide('edit-modal'),
            this.getSeragam()
        },
        editS(kode){
            this.editSeragam({
                kode: kode
            }),
            this.$bvModal.show('edit-modal')
        },
        deleteSeragam(kode) {
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
                    this.removeSeragam(kode)
                }
            })
        }
    },
    components: {
        vSelect,
        'seragam-form': FormSeragam
    }
}
</script>

