<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab">
                        <a class="nav-item nav-link active" id="nav-profil-tab" data-toggle="tab" href="#nav-profil" role="tab">Nilai KI-1</a>
                        <a class="nav-item nav-link" id="nav-presensi-tab" data-toggle="tab" href="#nav-presensi" role="tab">Nilai KI-2</a>
                        <a class="nav-item nav-link" id="nav-pelanggaran-tab" data-toggle="tab" href="#nav-pelanggaran" role="tab">Absensi</a>
                        <a class="nav-item nav-link" id="nav-nilai-tab" data-toggle="tab" href="#nav-nilai" role="tab">Catatan Walikelas</a>
                        <a class="nav-item nav-link" id="nav-nilai-tab" data-toggle="tab" href="#nav-nilai" role="tab">Rapor</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent"  style="margin-bottom:10px">
                    <div class="tab-pane fade show active" id="nav-profil" role="tabpanel" style="height:2000px; overflow:disable">
                        <siswa-form></siswa-form>
                    </div>
                    <div class="tab-pane fade" id="nav-presensi" role="tabpanel" style="height:200px">
                    </div>
                    <div class="tab-pane fade" id="nav-pelanggaran" role="tabpanel">
                    </div>
                    <div class="tab-pane fade" id="nav-nilai" role="tabpanel">
                    </div>
                </div>
            </div>
        </div>
    </div>    
</template>

<script>
import { mapActions, mapState, mapMutations } from 'vuex'
import FormRapor from './Form.vue'
import vSelect from 'vue-select'

export default {
    name: 'DataRapor',
}
</script>

