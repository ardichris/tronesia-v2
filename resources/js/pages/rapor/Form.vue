<template>
    <div class="card card-primary card-outline card-tabs col-sm-12">
        
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
    },

}
</script>