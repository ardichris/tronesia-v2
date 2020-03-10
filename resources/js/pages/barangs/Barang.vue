<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <router-link :to="{ name: 'barang.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link>
                        <b-modal id="view-stok" scrollable size="lg" hide-footer>
                            <template v-slot:modal-title>
                                Kartu Stok :  <b>{{barang.barang_nama}}</b>
                            </template>
                            <div class="row">
                            <div class="col-md-6">
                                <label>Barang Masuk</label>
                                <b-table striped hover bordered :items="barangmasuk.data" :fields="masuk" show-empty>
                                    <template v-slot:cell(bm_kode)="row">
                                        {{row.item.barangmasuk.bm_kode}}
                                    </template>
                                    <template v-slot:cell(bm_tanggal)="row">
                                        {{row.item.barangmasuk.bm_tanggal}}
                                    </template>
                                </b-table>
                            </div>
                            <div class="col-md-6">
                                <label>Pemakaian</label>
                                <b-table striped hover bordered :items="pemakaian.data" :fields="pakai" show-empty>
                                </b-table>
                            </div>
                            </div>
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
                <b-table striped hover bordered :items="barangs.data" :fields="fields" show-empty>
                    <template v-slot:cell(barang_stok)="row">
                        {{row.item.barang_stok}} {{row.item.barang_satuan}}
                    </template>
                    <template v-slot:cell(actions)="row">
                        <!--router-link :to="{ name: 'barang.view', params: {id: row.item.barang_kode} }" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></router-link-->
                        <button class="btn btn-success btn-sm"  @click="viewBarang(row.item)"><i class="fa fa-eye"></i></button>
                        <router-link :to="{ name: 'barang.edit', params: {id: row.item.barang_kode} }" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></router-link>
                        <button class="btn btn-danger btn-sm" @click="deleteBarang(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="barangs.data"><i class="fa fa-bars"></i> {{ barangs.data.length }} item dari {{ barangs.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="barangs.meta.total"
                                :per-page="barangs.meta.per_page"
                                aria-controls="barangs"
                                v-if="barangs.data && barangs.data.length > 0"
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

export default {
    name: 'DataBarang',
    created() {
        this.getBarang()
    },
    data() {
        return {
            fields: [
                { key: 'barang_kode', label: 'Kode', sortable: true },
                { key: 'barang_nama', label: 'Nama Barang', sortable: true },
                { key: 'b_varian', label: 'Varian' },
                { key: 'b_kategori', label: 'Kategori' },
                { key: 'barang_stok', label: 'Stok' },
                { key: 'barang_lokasi', label: 'Lokasi' },
                { key: 'actions', label: 'Aksi' }
            ],
            masuk: [
                { key: 'bm_kode', label: 'Kode', sortable: true },
                { key: 'bm_tanggal', label: 'Tanggal', sortable: true },
                { key: 'jumlah', label: 'Jumlah', sortable: true }                
            ],
            pakai: [
                { key: 'pb_kode', label: 'Kode', sortable: true },
                { key: 'pb_tanggal', label: 'Tanggal', sortable: true },
                { key: 'pb_jumlah', label: 'Jumlah', sortable: true }                
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('barang', {
            barang: state => state.barang,
            barangs: state => state.barangs,
            barangmasuk: state => state.barangmasuk,
            pemakaian: state => state.pemakaian
        }),
        page: {
            get() {
                return this.$store.state.barang.page
            },
            set(val) {
                this.$store.commit('barang/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getBarang()
        },
        search() {
            this.getBarang(this.search)
        }
    },
    methods: {
        ...mapActions('barang', ['getPemakaian','getBarangmasuk','getBarang', 'removeBarang','editBarang']),
        viewBarang(barang) {
            this.getBarangmasuk({barang: barang})
            this.getPemakaian({barang: barang})
            this.editBarang(barang.barang_kode)
            this.$bvModal.show('view-stok')
        },
        deleteBarang(id) {
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
                    this.removeBarang(id)
                }
            })
        }
    }
}
</script>

