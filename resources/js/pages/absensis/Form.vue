<template>
    <div>
        <div class="form-group">
            <label for="">Kelas</label>
            <b-form-select
                v-model="kelas"
                size="sm"
                @change="cari"
                :options="kelasdata.data"
                >
            </b-form-select>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.siswa_id }">
            <label for="">Nama Siswa</label>
            <v-select :options="siswas.data"
                v-model="absensi.siswa_id"
                @search="onSearch"
                label="s_nama"
                placeholder="Masukkan Kata Kunci"
                :disabled="$route.name == 'absensi.view'"
                :filterable="false">
                <template slot="no-options">
                    Masukkan Kata Kunci
                </template>
                <template slot="option" slot-scope="option">
                    {{ option.s_nama }} ({{ option.kelas }})
                </template>
            </v-select>
            <p class="text-danger" v-if="errors.siswa_id">Siswa belum dipilih</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.absensi_tanggal }">
            <label for="">Tanggal</label>
            <input type="date" class="form-control" v-model="absensi.absensi_tanggal" :readonly="$route.name == 'absensi.view'">
            <p class="text-danger" v-if="errors.absensi_tanggal">Tanggal belum diisi</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.absensi_jenis }">
            <label for="">Jenis Absensi</label>
            <v-select :options="['Sakit', 'Ijin', 'Alpha']"
                        v-model="absensi.absensi_jenis"
                        :disabled="$route.name == 'absensi.view'"
                        :value="absensi.absensi_jenis"
                        >
            </v-select>
            <p class="text-danger" v-if="errors.absensi_jenis">Absensi belum dipilih</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.absensi_keterangan }">
            <label for="">Keterangan</label>
            <input type="text" class="form-control" v-model="absensi.absensi_keterangan" :readonly="$route.name == 'absensi.view'">
            <p class="text-danger" v-if="errors.absensi_keterangan">Keterangan wajib diisi</p>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
export default {
    name: 'FormAbsensi',
    data() {
        return {
            kelas: '',
        }
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('absensi', {
            siswas: state => state.siswas,
            absensi: state => state.absensi,
            kelasdata: state => state.kelas,
        })
    },
    methods: {
        ...mapActions('absensi', ['getSiswas', 'editAbsensi','getSiswaKelas']),
        ...mapMutations('absensi', ['CLEAR_FORM']),
        onSearch(search, loading) {
            this.getSiswas({
                search: search,
                loading: loading,
            })
        },
        cari(loading){
            this.getSiswaKelas({
                kelas: this.kelas,
                loading: loading
            })
        },
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
