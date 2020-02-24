<template>
    <div class="col-md-6">
        <div class="form-group" :class="{ 'has-error': errors.bm_tanggal }">
            <label for="">Tanggal</label>
            <input type="date" class="form-control" v-model="barangmasuk.bm_tanggal" :readonly="$route.name == 'barangmasuk.edit' || $route.name == 'barangmasuk.view'">
            <p class="text-danger" v-if="errors.bm_tanggal">Tanggal belum dipilih</p>
        </div> 
        <label for="">List Barang</label><br>
        <button class="btn btn-warning btn-sm float-right" style="margin-bottom: 10px" @click="addBarang">Tambah</button>
        <div class="table-responsive" style="height: 400px">
            <table class="table" >
                <thead>
                    <tr>
                        <th width="80%">Nama Barang</th>
                        <th width="20%">Jumlah</th>
                        <th></th>
                    </tr>
                </thead>
                <!-- TABLE INI BERGUNA UNTUK MENAMBAHKAN ITEM TRANSAKSI -->
                <tbody>
                    <tr v-for="(row, index) in barangmasuk.listbarang" :key="index">
                        <td>
                            <v-select :options="barangs.data"
                                v-model="row.barang"
                                @search="onSearchBarang" 
                                label="barang_nama"
                                placeholder="Masukkan Kata Kunci" 
                                :filterable="false">
                                <template slot="no-options">
                                    Masukkan Kata Kunci
                                </template>
                                <template slot="option" slot-scope="option">
                                    {{ option.barang_nama }}
                                </template>
                            </v-select>
                        </td>
                        <td>
                            <input type="number" class="form-control" v-model="row.jumlah" :readonly="$route.name == 'barangmasuk.edit' || $route.name == 'barangmasuk.view'">
                        </td>
                        <td>
                            <button class="btn btn-danger btn-flat" @click="removeBarang(index)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>   
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
import _ from 'lodash'
export default {
    name: 'FormBarangMasuk',
    data() {
        return {
            isForm: false,
            isSuccess: false,
            barangmasuks: {
                listbarang: [
                    { barang: null, jumlah: null }
                ]
            }
        }
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('barangmasuk', {
            barangmasuk: state => state.barangmasuk,
            barangs: state => state.barang,
        }),
        filterBarang() {
            return _.filter(this.barangmasuk.listbarang, function(item) {
                return item.barang == null
            })
        },
    },
    methods: {
        ...mapMutations('barangmasuk', ['CLEAR_FORM']),
        ...mapActions('barangmasuk', ['getBarang']),
        addBarang(){
            if (this.filterBarang.length == 0) {
                this.barangmasuk.listbarang.push({ barang_id: null, jumlah: null, barang: null})
            }
        },
        removeBarang(index) {
            if (this.barangmasuk.listbarang.length > 0) {
                this.barangmasuk.listbarang.splice(index, 1)
            }
        },
        onSearchBarang(search, loading) {
            this.getBarang({
                search: search,
                loading: loading
            })            
        },
    },
    destroyed() {
        this.CLEAR_FORM()
    },
    components: {
        vSelect
    }
}
</script>