<template>
    <div class="card card-primary card-outline card-tabs col-sm-12">
        
    </div>
    
    
</template>

<script>
import { mapState, mapMutations } from 'vuex'
export default {
    name: 'FormRapor',
    computed: {
        ...mapState(['errors']), //MENGAMBIL STATE ERRORS
        ...mapState('rapor', {
            rapor: state => state.rapor //MENGAMBIL STATE SISWA
        })
    },
    methods: {
        ...mapMutations('rapor', ['CLEAR_FORM']), //PANGGIL MUTATIONS CLEAR_FORM
    },
    //KETIKA PAGE INI DITINGGALKAN MAKA 
    destroyed() {
        //FORM DI BERSIHKAN
        this.CLEAR_FORM()
    },

}
</script>