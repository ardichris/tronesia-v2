<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="showFormAdd">Add</b-button>
                        <b-modal id="add-modal" scrollable size="lg">
                            <template v-slot:modal-title>
                                Tambah Proyek
                            </template>
                            <pancasilaproject-form></pancasilaproject-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"
                                    block @click="storePP"
                                >
                                    Simpan
                                </b-button>
                            </template>
                        </b-modal>
                        <b-modal id="edit-modal" scrollable size="lg">
                            <template v-slot:modal-title>
                                Edit Proyek
                            </template>
                            <pancasilaproject-form></pancasilaproject-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"
                                    block @click="updatePP"
                                >
                                    Simpan
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
                <b-table striped hover bordered :items="pancasilaprojects.data" :fields="fields" show-empty>
                    <template v-slot:cell(kelas_id)="row">
                        <div class="badge badge-primary" v-if="row.item.kelas.kelas_nama.substr(0, 2)=='IX'">{{row.item.kelas.kelas_nama}}</div>
                        <div class="badge badge-danger" v-else-if="row.item.kelas.kelas_nama.substr(0, 4)=='VIII'">{{row.item.kelas.kelas_nama}}</div>
                        <div class="badge badge-warning" v-else>{{row.item.kelas.kelas_nama}}</div>
                    </template>
                    <template v-slot:cell(pp_name)="row">
                        {{ row.item.pp_name }}
                    </template>
                    <template v-slot:cell(pp_theme)="row">
                        {{ row.item.pp_theme }}
                    </template>
                    <template v-slot:cell(pp_desc)="row">
                        {{ row.item.pp_desc }}
                    </template>
                    <template v-slot:cell(actions)="row">
                        <button class="btn btn-warning btn-sm" v-if="authenticated.id==row.item.user_id || authenticated.role == 0" @click="editPP(row.item.id)"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" v-if="authenticated.id==row.item.user_id || authenticated.role == 0" @click="deletePP(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>
                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="pancasilaprojects.data"><i class="fa fa-bars"></i> {{ pancasilaprojects.data.length }} item dari {{ pancasilaprojects.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="pancasilaprojects.meta.total"
                                :per-page="pancasilaprojects.meta.per_page"
                                aria-controls="pancasilaprojects"
                                v-if="pancasilaprojects.data && pancasilaprojects.data.length > 0"
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
import FormPancasilaProject from './Form.vue'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'

export default {
    name: 'DataPancasilaProject',
    created() {
        this.getPancasilaProject()
    },
    data() {
        return {
            fields: [
                { key: 'kelas_id', label: 'Kelas', sortable: true },
                { key: 'pp_name', label: 'Nama Proyek' },
                { key: 'pp_desc', label: 'Deskripsi Proyek' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: '',
        }
    },
    computed: {
        ...mapState('pancasilaproject', {
            pancasilaprojects: state => state.pancasilaprojects,
            pancasilaproject: state => state.pancasilaproject,
            mode: state => state.mode
        }),
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        page: {
            get() {
                return this.$store.state.pancasilaproject.page
            },
            set(val) {
                this.$store.commit('pancasilaproject/SET_PAGE', val)
            }
        },
        mode: {
            get() {
                return this.$store.state.pancasilaproject.mode
            },
            set(val) {
                this.$store.commit('pancasilaproject/SET_MODE', val)
            }
        },
    },
    watch: {
        page() {
            this.getPancasilaProject(this.search)
        },
        search() {
            this.getPancasilaProject(this.search)
        }
    },
    methods: {
        ...mapActions('pancasilaproject',
                        ['getPancasilaProject',
                         'storePancasilaProject',
                         'editPancasilaProject',
                         'removePancasilaProject',
                         'updatePancasilaProject']),
        storePP(){
            this.storePancasilaProject().then(() => {
                this.$bvModal.hide('add-modal')
                this.getPancasilaProject()
            })
        },
        editPP(id){
            this.mode = 'edit',
            this.editPancasilaProject(id).then(() => {
                this.$bvModal.show('edit-modal')
            })
        },
        updatePP(){
            this.updatePancasilaProject().then(() => {
                this.$bvModal.hide('edit-modal')
                this.getPancasilaProject()
            })
        },
        deletePP(id){
            this.removePancasilaProject(id)
        },
        showFormAdd(){
            this.mode = 'add',
            this.$bvModal.show('add-modal')
        }

    },
    components: {
        'pancasilaproject-form': FormPancasilaProject,
        vSelect
    }
}
</script>
