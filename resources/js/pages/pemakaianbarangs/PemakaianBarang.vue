<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <!--router-link :to="{ name: 'pemakaianbarang.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link-->
                        <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="$bvModal.show('my-modal')">Tambah</b-button>
                        <b-modal id="add-modal">
                            <template v-slot:modal-title>
                                Tambah Pemakaian Barang
                            </template>
                            <pemakaianbarang-form></pemakaianbarang-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block @click="simpanPBbaru"
                                >
                                    Simpan
                                </b-button>
                            </template>
                        </b-modal>
                        <b-modal id="edit-modal">
                            <template v-slot:modal-title>
                                Edit Pemakaian Barang
                            </template>
                            <pemakaianbarang-form></pemakaianbarang-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block @click="editPBsaja"
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
                <b-table striped hover bordered :items="pemakaianbarangs.data" :fields="fields" show-empty>
                    <template v-slot:cell(barang_id)="row">
                        {{row.item.barang.barang_nama}}
                    </template>
                    <template v-slot:cell(user_id)="row">
                        {{row.item.user.name}}
                    </template>
                    <template v-slot:cell(pb_jumlah)="row">
                        {{row.item.pb_jumlah}} {{row.item.barang.barang_satuan}}
                    </template>
                    <template v-slot:cell(actions)="row">
                        <!--router-link :to="{ name: 'pemakaianbarang.view', params: {id: row.item.pemakaianbarang_kode} }" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></router-link>
                        <router-link :to="{ name: 'pemakaianbarang.edit', params: {id: row.item.pemakaianbarang_kode} }" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></router-link-->
                        <button class="btn btn-warning btn-sm" @click="editPB(row.item.pb_kode)"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" @click="deletePemakaianbarang(row.item.pb_kode)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="pemakaianbarangs.data"><i class="fa fa-bars"></i> {{ pemakaianbarangs.data.length }} item dari {{ pemakaianbarangs.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="pemakaianbarangs.meta.total"
                                :per-page="pemakaianbarangs.meta.per_page"
                                aria-controls="pemakaianbarangs"
                                v-if="pemakaianbarangs.data && pemakaianbarangs.data.length > 0"
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
import FormPemakaianBarang from './Form.vue'

export default {
    name: 'DataPemakaianbarang',
    created() {
        this.getPemakaianbarang()
    },
    data() {
        return {
            fields: [
                { key: 'pb_kode', label: 'Kode', sortable: true },
                { key: 'pb_tanggal', label: 'Tanggal', sortable: true },
                { key: 'barang_id', label: 'Barang' },
                { key: 'pb_jumlah', label: 'Jumlah' },
                { key: 'user_id', label: 'User' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('pemakaianbarang', {
            pemakaianbarang: state => state.pemakaianbarang,
            pemakaianbarangs: state => state.pemakaianbarangs,
            barangs: state => state.barangs

        }),
        page: {
            get() {
                return this.$store.state.pemakaianbarang.page
            },
            set(val) {
                this.$store.commit('pemakaianbarang/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getPemakaianbarang()
        },
        search() {
            this.getPemakaianbarang({search: this.search})
        }
    },
    methods: {
        ...mapActions('pemakaianbarang', ['updatePemakaianbarang','editPemakaianbarang','submitPemakaianbarang','getPemakaianbarang', 'removePemakaianbarang','getBarang']),
        simpanPBbaru(){
            this.submitPemakaianbarang().then(() => {
                this.$bvModal.hide('add-modal'),
                this.getPemakaianbarang()
            })
        },
        editPBsaja(){
            this.updatePemakaianbarang(),
            this.$bvModal.hide('edit-modal'),
            this.getPemakaianbarang()
        },
        editPB(kode){
            this.editPemakaianbarang({
                kode: kode
            }),
            this.$bvModal.show('edit-modal')
        },
        deletePemakaianbarang(kode) {
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
                    this.removePemakaianbarang(kode)
                }
            })
        }
    },
    components: {
        vSelect,
        'pemakaianbarang-form': FormPemakaianBarang
    }
}
</script>

