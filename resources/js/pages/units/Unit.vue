<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="$bvModal.show('add-modal')">Tambah</b-button>
                        <b-modal id="add-modal">
                            <template v-slot:modal-title>
                                Tambah Unit
                            </template>
                            <unit-form></unit-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block @click="simpanUnitbaru"
                                >
                                    Simpan
                                </b-button>
                            </template>
                        </b-modal>
                        <b-modal id="edit-modal">
                            <template v-slot:modal-title>
                                Edit Unit
                            </template>
                            <unit-form></unit-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block @click="editUnitlama"
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
                <b-table striped hover bordered :items="units.data" :fields="fields" show-empty>
                    <template v-slot:cell(actions)="row">
                        <router-link :to="{ name: 'unit.view', params: {id: row.item.unit_kode} }" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></router-link>
                        <button class="btn btn-warning btn-sm" @click="ubahUnit(row.item.id)"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" @click="deleteUnit(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="units.data"><i class="fa fa-bars"></i> {{ units.data.length }} item dari {{ units.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="units.meta.total"
                                :per-page="units.meta.per_page"
                                aria-controls="units"
                                v-if="units.data && units.data.length > 0"
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
import FormUnit from './Form.vue'

export default {
    name: 'DataUnit',
    created() {
        //SEBELUM COMPONENT DI-LOAD, REQUEST DATA DARI SERVER
        this.getUnit()
    },
    data() {
        return {
            //FIELD UNTUK B-TABLE, PASTIKAN KEY NYA SESUAI DENGAN FIELD DATABASE
            //AGAR OTOMATIS DI-RENDER
            fields: [
                { key: 'unit_kode', label: 'Kode Unit' },
                { key: 'unit_nama', label: 'Nama Unit' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        //MENGAMBIL DATA OUTLETS DARI STATE OUTLETS
        ...mapState('unit', {
            units: state => state.units
        }),
        page: {
            get() {
                //MENGAMBIL VALUE PAGE DARI VUEX MODULE unit
                return this.$store.state.unit.page
            },
            set(val) {
                //APABILA TERJADI PERUBAHAN VALUE DARI PAGE, MAKA STATE PAGE
                //DI VUEX JUGA AKAN DIUBAH
                this.$store.commit('unit/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            //APABILA VALUE DARI PAGE BERUBAH, MAKA AKAN MEMINTA DATA DARI SERVER
            this.getUnit()
        },
        search() {
            //APABILA VALUE DARI SEARCH BERUBAH MAKA AKAN MEMINTA DATA
            //SESUAI DENGAN DATA YANG SEDANG DICARI
            this.getUnit(this.search)
        }
    },
    methods: {
        ...mapActions('unit', ['submitUnit','updateUnit','editUnit','getUnit', 'removeUnit']),
        simpanUnitbaru(){
            this.submitUnit().then(() => {
                this.$bvModal.hide('add-modal'),
                this.getUnit()
            })
        },
        editUnitlama(){
            this.updateUnit().then(() => {
                this.$bvModal.hide('edit-modal'),
                this.getUnit()
            })
        },
        ubahUnit(kode){
            this.editUnit({
                kode: kode
            }),
            this.$bvModal.show('edit-modal')
        },
        deleteUnit(id) {
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
                    this.removeUnit(id) //JIKA SETUJU MAKA PERMINTAAN HAPUS AKAN DI EKSEKUSI
                }
            })
        }
    },
    components: {
        'unit-form': FormUnit
    }
}
</script>

