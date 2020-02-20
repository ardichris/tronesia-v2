<template>
    <div class="d-block">
        <div class="form-group" :class="{ 'has-error': errors.barang }">
            <label for="">Nama Barang</label>
            <v-select :options="barangs.data"
                v-model="pemakaianbarang.barang"
                @search="onSearch" 
                label="barang_nama"
                placeholder="Masukkan Kata Kunci" 
                :filterable="false">
                <template slot="no-options">
                    Masukkan Kata Kunci
                </template>
                <template slot="option" slot-scope="option">
                    {{ option.barang_nama }} - {{ option.barang_stok }} {{ option.barang_satuan }}
                </template>
            </v-select>
            <p class="text-danger" v-if="errors.barang">Barang harus dipilih</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.pb_tanggal }">
            <label for="">Tanggal</label>
            <div class="input-group col-md-6">
                <input type="date" class="form-control" v-model="pemakaianbarang.pb_tanggal">
            </div>
            <p class="text-danger" v-if="errors.pb_tanggal">Tanggal harus diisi</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.pb_jumlah }">
            <label for="">Jumlah Barang</label>
            <div class="input-group col-md-6">
                <input type="number" class="form-control" v-model="pemakaianbarang.pb_jumlah">
            </div>
            <p class="text-danger" v-if="errors.pb_jumlah">Jumlah harus diisi</p>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
//import store from 'store.js'
export default {
    name: 'FormPemakaianBarang',
    computed: {
        ...mapState(['errors']),
        ...mapState('pemakaianbarang', {
            pemakaianbarang: state => state.pemakaianbarang,
            barangs: state => state.barangs
        })
    },
    methods: {
        ...mapMutations('pemakaianbarang', ['CLEAR_FORM']),
        ...mapActions('pemakaianbarang', ['getBarang']),
        onSearch(search, loading) {
            this.getBarang({
                search: search,
                loading: loading
            })
        }
    },
    destroyed() {
        this.CLEAR_FORM()
        //store.commit('CLEAR_ERRORS')
    },
    components: {
        vSelect
    }
}
</script>