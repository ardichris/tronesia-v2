<template>
    <div class="col-md-6">
        <div class="form-group" :class="{ 'has-error': errors.barang_nama }">
            <label for="">Nama Barang</label>
            <input type="text" class="form-control" v-model="barang.barang_nama" :readonly="$route.name == 'barang.edit' || $route.name == 'barang.view'">
            <p class="text-danger" v-if="errors.barang_nama">{{ errors.barang_nama[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.barang_stok }">
            <label for="">Stok Barang</label>
            <div class="input-group col-md-6 mb-6">
                <input type="number" class="form-control" v-model="barang.barang_stok" :readonly="$route.name == 'barang.view' || $route.name == 'barang.edit'">
                <span class="input-group-append">
                    <v-select :options="['pcs', 'dus', 'galon', 'roll', 'meter', 'kg']"
                                v-model="barang.barang_satuan"                      
                                :value="barang.barang_satuan"
                                >
                    </v-select>
                </span>
            </div>
            <p class="text-danger" v-if="errors.barang_stok">{{ errors.barang_stok[0] }}</p>
            <p class="text-danger" v-if="errors.barang_satuan">{{ errors.barang_satuan[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.barang_lokasi }">
            <label for="">Lokasi Barang</label>
            <v-select :options="['Gudang ATK', 'Ruang TU', 'Gudang OR', 'Gudang Pojok']"
                        v-model="barang.barang_lokasi"                      
                        :value="barang.barang_lokasi"
                        >
            </v-select>
            <p class="text-danger" v-if="errors.barang_lokasi">{{ errors.barang_lokasi[0] }}</p>
        </div>    
    </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
export default {
    name: 'FormBarang',
    computed: {
        ...mapState(['errors']),
        ...mapState('barang', {
            barang: state => state.barang
        })
    },
    methods: {
        ...mapMutations('barang', ['CLEAR_FORM']),
    },
    destroyed() {
        this.CLEAR_FORM()
    },
    components: {
        vSelect
    }
}
</script>