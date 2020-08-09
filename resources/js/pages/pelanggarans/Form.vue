<template>
    <div class>
        <div class="form-group" :class="{ 'has-error': errors.siswa_id }">
            <label for="">Nama Siswa</label>
            <v-select :options="siswas.data"
                v-model="pelanggaran.siswa_id"
                @search="onSearch" 
                label="siswa_nama"
                placeholder="Masukkan Kata Kunci" 
                :disabled="$route.name == 'pelanggarans.view'"
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
        <div class="form-group" :class="{ 'has-error': errors.pelanggaran_tanggal }">
            <label for="">Tanggal</label>
            <input type="date" class="form-control" v-model="pelanggaran.pelanggaran_tanggal" :readonly="$route.name == 'pelanggarans.view'">
            <!--b-form-datepicker id="pelanggaran-datepicker" v-model="pelanggaran.pelanggaran_tanggal" class="mb-2"></b-form-datepicker-->
            <p class="text-danger" v-if="errors.pelanggaran_tanggal">Tanggal belum diisi</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.pelanggaran_jenis }">
            <label for="">Jenis Pelanggaran</label>
            <v-select :options="['Terlambat', 'Escape', 'Atribut', 'Seragam', 'Sepatu', 'Kaos Kaki', 'Rambut', 'Berkelahi', 'Bermain Game', 'Mendengarkan Musik', 'Berkata Kotor']"
                        v-model="pelanggaran.pelanggaran_jenis"
                        :disabled="$route.name == 'pelanggaran.view'"
                        :value="pelanggaran.pelanggaran_jenis"
                        >
            </v-select>
            <p class="text-danger" v-if="errors.pelanggaran_jenis">Pelanggaran belum dipilih</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.pelanggaran_keterangan }">
            <label for="">Keterangan</label>
            <input type="text" class="form-control" v-model="pelanggaran.pelanggaran_keterangan" :readonly="$route.name == 'pelanggarans.view'">
            <p class="text-danger" v-if="errors.pelanggaran_keterangan">Keterangan belum diisi</p>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
export default {
    name: 'FormPelanggarans',
    computed: {
        ...mapState(['errors']),
        ...mapState('pelanggaran', {
            siswas: state => state.siswas,
            pelanggaran: state => state.pelanggaran
        })
    },
    methods: {
        ...mapActions('pelanggaran', ['getSiswas', 'editPelanggaran']),
        ...mapMutations('pelanggaran', ['CLEAR_FORM']),
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