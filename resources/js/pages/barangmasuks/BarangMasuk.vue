<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <!--router-link :to="{ name: 'barangmasuk.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link-->
                        <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="$bvModal.show('add-modal')">Tambah</b-button>
                        <b-modal id="add-modal">
                            <template v-slot:modal-title>
                                Tambah Barang Masuk
                            </template>
                            <barangmasuk-form></barangmasuk-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"
                                    block @click="simpanBMbaru"
                                >
                                    Simpan
                                </b-button>
                            </template>
                        </b-modal>
                        <b-modal id="edit-modal">
                            <template v-slot:modal-title>
                                Edit Barang Masuk
                            </template>
                            <barangmasuk-form></barangmasuk-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"
                                    block @click="editBMsaja"
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
                <b-table striped hover bordered :items="barangmasuks.data" :fields="fields" show-empty>
                    <template v-slot:cell(user_id)="row">
                        <div class="badge badge-primary">{{row.item.user.name }}</div>
                    </template>
                    <template v-slot:cell(bm_jumlah)="row">
                        {{row.item.bm_jumlah}} {{row.item.barang.barang_satuan}}
                    </template>
                    <template v-slot:cell(listbarang)="row">
                        <div v-for="item in row.item.listbarang" :key="item.barang.id">
                                <div class="badge badge-success">{{ item.barang.barang_nama }}</div>
                        </div>
                    </template>
                    <template v-slot:cell(actions)="row">
                        <!--router-link :to="{ name: 'barangmasuk.view', params: {id: row.item.barangmasuk_kode} }" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></router-link>
                        <router-link :to="{ name: 'barangmasuk.edit', params: {id: row.item.bm_kode} }" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></router-link-->
                        <button class="btn btn-warning btn-sm" @click="editBM(row.item.bm_kode)"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" @click="deleteBarangmasuk(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="barangmasuks.data"><i class="fa fa-bars"></i> {{ barangmasuks.data.length }} item dari {{ barangmasuks.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="barangmasuks.meta.total"
                                :per-page="barangmasuks.meta.per_page"
                                aria-controls="barangmasuks"
                                v-if="barangmasuks.data && barangmasuks.data.length > 0"
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
import FormBarangMasuk from './Form.vue'

export default {
    name: 'DataBarangmasuk',
    created() {
        this.getBarangmasuk()
    },
    data() {
        return {
            fields: [
                { key: 'bm_kode', label: 'Kode', sortable: true },
                { key: 'bm_tanggal', label: 'Tanggal', sortable: true },
                { key: 'listbarang', label: 'List Barang'},
                { key: 'user_id', label: 'User' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('barangmasuk', {
            barangmasuk: state => state.barangmasuk,
            barangmasuks: state => state.barangmasuks,
            barangs: state => state.barangs

        }),
        page: {
            get() {
                return this.$store.state.barangmasuk.page
            },
            set(val) {
                this.$store.commit('barangmasuk/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getBarangmasuk()
        },
        search() {
            this.getBarangmasuk(this.search)
        }
    },
    methods: {
        ...mapActions('barangmasuk', ['updateBarangmasuk','editBarangmasuk','submitBarangmasuk','getBarangmasuk', 'removeBarangmasuk','getBarang']),
        simpanBMbaru(){
            this.submitBarangmasuk().then(() => {
                this.$bvModal.hide('add-modal'),
                this.getBarangmasuk()
            })
        },
        editBMsaja(){
            this.updateBarangmasuk(),
            this.$bvModal.hide('edit-modal'),
            this.getBarangmasuk()
        },
        editBM(kode){
            this.editBarangmasuk({
                kode: kode
            }),
            this.$bvModal.show('edit-modal')
        },
        deleteBarangmasuk(kode) {
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
                    this.removeBarangmasuk(kode)
                }
            })
        }
    },
    components: {
        vSelect,
        'barangmasuk-form': FormBarangMasuk
    }
}
</script>

