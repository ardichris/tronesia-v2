<template>
    <div>
        <div class="form-group" :class="{ 'has-error': errors.ls_kategori }">
            <label for="">Kategori</label>
            <v-select :options="['Kerusakan', 'Peminjaman']"
                        v-model="laporsarpras.ls_kategori"                        
                        :value="laporsarpras.ls_kategori"
                        >
            </v-select>
            <p class="text-danger" v-if="errors.ls_kategori">Kategori belum dipilih</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.ls_sarpras }">
            <label for="">Sarana</label>
            <input type="text" class="form-control" v-model="laporsarpras.ls_sarpras">
            <p class="text-danger" v-if="errors.ls_sarpras">Keterangan belum diisi</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.ls_keterangan }">
            <label for="">Keterangan</label>
            <textarea cols="6" rows="5" class="form-control" v-model="laporsarpras.ls_keterangan"></textarea>
            <p class="text-danger" v-if="errors.ls_keterangan">Keterangan belum diisi</p>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
export default {
    name: 'FormLaporSarpras',
    computed: {
        ...mapState(['errors']),
        ...mapState('laporsarpras', {
           laporsarpras: state => state.laporsarpras
        })
    },
    methods: {
        ...mapActions('laporsarpras', ['getSiswas', 'editAbsensi']),
        ...mapMutations('laporsarpras', ['CLEAR_FORM']),
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