<template>
    <div class="col-md-6">
        <div class="form-group" :class="{ 'has-error': errors.mapel_kode }">
            <label for="">Kode Mata Pelajaran</label>
            <input type="text" class="form-control" v-model="mapel.mapel_kode" :readonly="$route.name == 'mapel.edit' || $route.name == 'mapel.view'">
            <p class="text-danger" v-if="errors.mapel_kode">{{ errors.mapel_kode[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.mapel_nama }">
            <label for="">Mata Pelajaran</label>
            <input type="text" class="form-control" v-model="mapel.mapel_nama" :readonly="$route.name == 'mapel.view'">
            <p class="text-danger" v-if="errors.mapel_nama">{{ errors.mapel_nama[0] }}</p>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex'
export default {
    name: 'FormMapel',
    computed: {
        ...mapState(['errors']), //MENGAMBIL STATE ERRORS
        ...mapState('mapel', {
            mapel: state => state.mapel //MENGAMBIL STATE SISWA
        })
    },
    methods: {
        ...mapMutations('mapel', ['CLEAR_FORM']), //PANGGIL MUTATIONS CLEAR_FORM
    },
    //KETIKA PAGE INI DITINGGALKAN MAKA 
    destroyed() {
        //FORM DI BERSIHKAN
        this.CLEAR_FORM()
    }
}
</script>