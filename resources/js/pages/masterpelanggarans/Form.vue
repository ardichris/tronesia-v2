<template>
    <div class>
        <div class="form-group" :class="{ 'has-error': errors.mp_pelanggaran }">
            <label for="">Nama Pelanggaran</label>
            <input type="text" class="form-control" v-model="pelanggaran.mp_pelanggaran" :readonly="$route.name == 'masterpelanggarans.view'">
            <p class="text-danger" v-if="errors.mp_pelanggaran">Nama pelanggaran belum diisi</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.mp_kategori }">
            <label for="">Kategori Pelanggaran</label>
            <v-select :options="['Ringan', 'Sedang' , 'Berat']"
                        v-model="pelanggaran.mp_kategori"
                        :disabled="$route.name == 'masterpelanggarans.view'"
                        :value="pelanggaran.mp_kategori"
                        >
            </v-select>
            <p class="text-danger" v-if="errors.mp_kategori">Kategori pelanggaran belum dipilih</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.mp_poin }">
            <label for="">Poin Pelanggaran</label>
            <input type="number" class="form-control" v-model="pelanggaran.mp_poin" :readonly="$route.name == 'masterpelanggarans.view'">
            <p class="text-danger" v-if="errors.mp_poin">Poin pelanggaran belum diisi</p>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
export default {
    name: 'FormMasterPelanggarans',
    computed: {
        ...mapState(['errors']),
        ...mapState('masterpelanggaran', {
            pelanggaran: state => state.MP_input
        })
    },
    methods: {
        ...mapActions('masterpelanggaran', ['editMP']),
        ...mapMutations('masterpelanggaran', ['CLEAR_FORM']),
    },
    destroyed() {
            this.CLEAR_FORM(),
            this.$store.commit('CLEAR_ERRORS')
    },
    components: {
        vSelect
    }
}
</script>