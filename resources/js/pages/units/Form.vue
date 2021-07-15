<template>
    <div class="col-md-6">
        <div class="form-group" :class="{ 'has-error': errors.unit_kode }">
            <label for="">Kode Unit</label>
            <input type="text" class="form-control" v-model="unit.unit_kode" :readonly="$route.name == 'unit.edit' || $route.name == 'unit.view'">
            <p class="text-danger" v-if="errors.unit_kode">{{ errors.unit_kode[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.unit_nama }">
            <label for="">Nama Unit</label>
            <input type="text" class="form-control" v-model="unit.unit_nama" :readonly="$route.name == 'unit.view'">
            <p class="text-danger" v-if="errors.unit_nama">{{ errors.unit_nama[0] }}</p>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex'
export default {
    name: 'FormUnit',
    computed: {
        ...mapState(['errors']), //MENGAMBIL STATE ERRORS
        ...mapState('unit', {
            unit: state => state.unit //MENGAMBIL STATE SISWA
        })
    },
    methods: {
        ...mapMutations('unit', ['CLEAR_FORM']), //PANGGIL MUTATIONS CLEAR_FORM
    },
    //KETIKA PAGE INI DITINGGALKAN MAKA 
    destroyed() {
        //FORM DI BERSIHKAN
        this.CLEAR_FORM()
    }
}
</script>