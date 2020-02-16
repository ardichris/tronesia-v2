<template>
    <div class>
        <div class="form-group" :hidden="$route.name == 'pelanggarans.add'" :class="{ 'has-error': errors.pelanggaran_kode }">
            <label for="">Kode Register</label>
            <input type="text" class="form-control" v-model="pelanggaran.pelanggaran_kode" :readonly="$route.name == 'pelanggarans.edit' || $route.name == 'pelanggarans.view'">
            <p class="text-danger" v-if="errors.pelanggaran_kode">{{ errors.pelanggaran_kode[0] }}</p>
        </div>
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
            <p class="text-danger" v-if="errors.siswa_id">{{ errors.siswa_id[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.pelanggaran_tanggal }">
            <label for="">Tanggal</label>
            <input type="date" class="form-control" v-model="pelanggaran.pelanggaran_tanggal" :readonly="$route.name == 'pelanggarans.view'">
            <p class="text-danger" v-if="errors.pelanggaran_tanggal">{{ errors.pelanggaran_tanggal[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.pelanggaran_jenis }">
            <label for="">Jenis Pelanggaran</label>
            <v-select :options="['Terlambat', 'Escape', 'Atribut', 'Seragam', 'Sepatu', 'Kaos Kaki', 'Rambut', 'Berkelahi']"
                        v-model="pelanggaran.pelanggaran_jenis"
                        :disabled="$route.name == 'pelanggaran.view'"
                        :value="pelanggaran.pelanggaran_jenis"
                        >
            </v-select>
            <p class="text-danger" v-if="errors.pelanggaran_jenis">{{ errors.pelanggaran_jenis[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.pelanggaran_keterangan }">
            <label for="">Keterangan</label>
            <input type="text" class="form-control" v-model="pelanggaran.pelanggaran_keterangan" :readonly="$route.name == 'pelanggarans.view'">
            <p class="text-danger" v-if="errors.pelanggaran_keterangan">{{ errors.pelanggaran_keterangan[0] }}</p>
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
        ...mapState(['errors']), //MENGAMBIL STATE ERRORS
        ...mapState('pelanggaran', {
            siswas: state => state.siswas,
            pelanggaran: state => state.pelanggaran //MENGAMBIL STATE PELANGGARAN
        })
    },
    methods: {
        ...mapActions('pelanggaran', ['getSiswas', 'editPelanggaran']),
        ...mapMutations('pelanggaran', ['CLEAR_FORM']),//PANGGIL MUTATIONS CLEAR_FORM
        onSearch(search, loading) {
            //KITA AKAN ME-REQUEST DATA CUSTOMER BERDASARKAN KEYWORD YG DIMINTA
            this.getSiswas({
                search: search,
                loading: loading
            })
        }
    },
    destroyed() {
            //FORM DI BERSIHKAN
            this.CLEAR_FORM()
    },
    components: {
        vSelect
    }
}
</script>