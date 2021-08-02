<template>
    <div class="col-md-12">
        <nav>
            <div class="nav nav-tabs" id="nav-tab">
                <a class="nav-item nav-link active" id="nav-profil-tab" data-toggle="tab" href="#nav-KKM" role="tab">KKM</a>
                <a class="nav-item nav-link" id="nav-presensi-tab" data-toggle="tab" href="#nav-pengetahuan" role="tab">Pengetahuan KI-3</a>
                <a class="nav-item nav-link" id="nav-pelanggaran-tab" data-toggle="tab" href="#nav-keterampilan" role="tab">Keterampilan KI-4</a>
                <a class="nav-item nav-link" id="nav-nilai-tab" data-toggle="tab" href="#nav-rapor" role="tab">Rapor</a>
            </div>
            <div class="tab-content" id="nav-tabContent"  style="margin-bottom:10px">
                <div class="tab-pane fade show active" id="nav-KKM" role="tabpanel" style="height:2000px; overflow:disable">
                </div>
                <div class="tab-pane fade" id="nav-pengetahuan" role="tabpanel" style="height:200px">
                </div>
                <div class="tab-pane fade" id="nav-keterampilan" role="tabpanel">
                </div>
                <div class="tab-pane fade" id="nav-rapor" role="tabpanel">
                </div>
            </div>
        </nav>
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