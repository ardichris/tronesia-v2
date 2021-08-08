<template>
    <div class="card card-primary card-outline card-tabs col-sm-12">
        <nav>
            <div class="card-header">
            <div class="nav nav-pills" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-profil-tab" data-toggle="tab" href="#nav-KKM" role="tab">KKM</a>
                <a class="nav-item nav-link" id="nav-presensi-tab" data-toggle="tab" href="#nav-pengetahuan" role="tab">Pengetahuan KI-3</a>
                <a class="nav-item nav-link" id="nav-pelanggaran-tab" data-toggle="tab" href="#nav-keterampilan" role="tab">Keterampilan KI-4</a>
                <a class="nav-item nav-link" id="nav-nilai-tab" data-toggle="tab" href="#nav-rapor" role="tab">Rapor</a>
            </div>
            </div>
            <div class="card-body">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-KKM" role="tabpanel" style="overflow-y: auto">
                </div>
                <div class="tab-pane fade" id="nav-pengetahuan" role="tabpanel"   style="margin-bottom:10px;height:auto;overflow:hidden">
                    <pengetahuan-form></pengetahuan-form>
                </div>
                <div class="tab-pane fade" id="nav-keterampilan" role="tabpanel"  style="margin-bottom:10px;height:auto;overflow:hidden">
                    <keterampilan-form></keterampilan-form>
                </div>
                <div class="tab-pane fade" id="nav-rapor" role="tabpanel"  style="margin-bottom:10px;height:auto;overflow:hidden">
                </div>
            </div>
            </div>
        </nav>
    </div>
    
    
</template>

<script>
import { mapState, mapMutations } from 'vuex'
import FormPengetahuan from './FormKI3.vue'
import FormKeterampilan from './FormKI4.vue'
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
    components: {
        'pengetahuan-form': FormPengetahuan,
        'keterampilan-form': FormKeterampilan
    }
}
</script>