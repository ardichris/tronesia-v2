<template>
    <div>
        <div class="form-group" :class="{ 'has-error': errors.siswa_id }">
            <label for="">Nama Siswa</label>
            <v-select :options="siswas.data"
                v-model="kitir.siswa_id"
                @search="onSearch" 
                label="siswa_nama"
                placeholder="Masukkan Kata Kunci" 
                :disabled="$route.name == 'kitir.view'"
                :filterable="false">
                <template slot="no-options">
                    Masukkan Kata Kunci
                </template>
                <template slot="option" slot-scope="option">
                    {{ option.siswa_nama }} - {{ option.siswa_kelas }}
                </template>
            </v-select>
            <p class="text-danger" v-if="errors.siswa_id">Siswa belum dipilih</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.ks_tanggal }">
            <label for="">Tanggal</label>
            <input type="date" class="form-control" v-model="kitir.ks_tanggal" :readonly="$route.name == 'kitir.view'">
            <p class="text-danger" v-if="errors.ks_tanggal">Tanggal belum diisi</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.ks_jenis }">
            <label for="">Jenis Kitir</label>
            <v-select :options="['Masuk Kelas', 'Keluar Kelas', 'Pulang Sekolah']"
                        v-model="kitir.ks_jenis"
                        :disabled="$route.name == 'kitir.view'"
                        :value="kitir.ks_jenis"
                        >
            </v-select>
            <p class="text-danger" v-if="errors.ks_jenis">Kitir belum dipilih</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.ks_keterangan }">
            <label for="">Keterangan</label>
            <input type="text" class="form-control" v-model="kitir.ks_keterangan" :readonly="$route.name == 'kitir.view'">
            <p class="text-danger" v-if="errors.ks_keterangan">Keterangan wajib diisi</p>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
export default {
    name: 'FormKitir',
    computed: {
        ...mapState(['errors']),
        ...mapState('kitirsiswa', {
            siswas: state => state.siswas,
            kitir: state => state.kitir
        })
    },
    methods: {
        ...mapActions('kitirsiswa', ['getSiswas', 'editKitir']),
        ...mapMutations('kitirsiswa', ['CLEAR_FORM']),
        onSearch(search, loading) {
            this.getSiswas({
                search: search,
                loading: loading
            })
        }
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