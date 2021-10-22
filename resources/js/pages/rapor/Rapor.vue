<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab">
                        <a class="nav-item nav-link active" id="nav-spiritual-tab" data-toggle="tab" href="#nav-spiritual" role="tab">Nilai KI-1</a>
                        <a class="nav-item nav-link" id="nav-sosial-tab" data-toggle="tab" href="#nav-sosial" role="tab">Nilai KI-2</a>
                        <a class="nav-item nav-link" id="nav-absensi-tab" data-toggle="tab" href="#nav-absensi" role="tab">Absensi</a>
                        <a class="nav-item nav-link" id="nav-catatan-tab" data-toggle="tab" href="#nav-catatan" role="tab">Catatan Walikelas</a>
                        <a class="nav-item nav-link" id="nav-rapor-tab" data-toggle="tab" href="#nav-rapor" role="tab">Rapor</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent"  style="margin-bottom:10px">
                    <div class="tab-pane fade show active" id="nav-spiritual" role="tabpanel" style="height:auto; overflow:disabled">
                        <spiritual-form></spiritual-form>
                    </div>
                    <div class="tab-pane fade" id="nav-sosial" role="tabpanel" style="height:auto; overflow:disabled">
                        <sosial-form></sosial-form>
                    </div>
                    <div class="tab-pane fade" id="nav-absensi" role="tabpanel">
                        <absensi-form></absensi-form>
                    </div>
                    <div class="tab-pane fade" id="nav-catatan" role="tabpanel">
                        <catatan-form></catatan-form>
                    </div>
                    <div class="tab-pane fade" id="nav-rapor" role="tabpanel">
                        <rapor-form></rapor-form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</template>

<script>
import { mapActions, mapState, mapMutations } from 'vuex'
import FormRapor from './FormRapor.vue'
import FormCatatan from './FormCatatan.vue'
import FormAbsensi from './FormAbsensi.vue'
import FormSosial from './FormSosial.vue'
import FormSpiritual from './FormSpiritual.vue'
import vSelect from 'vue-select'

export default {
    name: 'DataRapor',
    components: {
            'spiritual-form': FormSpiritual,
            'sosial-form': FormSosial,
            'absensi-form': FormAbsensi,
            'catatan-form': FormCatatan,
            'rapor-form': FormRapor
        },
}
</script>

