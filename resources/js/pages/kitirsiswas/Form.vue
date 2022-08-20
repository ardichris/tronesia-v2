<template>
    <div>
        <div class="form-group">
            <label for="">Kelas</label>
            <b-form-select
                v-model="kelas"
                size="sm"
                :options="kelasdata.data"
                @change="cariSiswa(kelas)"
                >
            </b-form-select>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.siswa_id }">
            <label for="">Nama Siswa</label>
            <v-select :options="siswas.data"
                v-model="kitir.siswa_id"
                @search="onSearch"
                label="s_nama"
                placeholder="Masukkan Kata Kunci"
                :disabled="$route.name == 'kitir.view'"
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
        <div class="form-group" :class="{ 'has-error': errors.ks_tanggal }">
            <label for="">Tanggal</label>
            <input type="date" class="form-control" v-model="kitir.ks_tanggal" :readonly="$route.name == 'kitir.view'">
            <p class="text-danger" v-if="errors.ks_tanggal">Tanggal belum diisi</p>
        </div>
        <div class="row">
            <div class="col-md-6">
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
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Mulai</label>
                    <v-select :options="['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']"
                                v-model="kitir.ks_start"
                                :disabled="$route.name == 'kitir.view'"
                                :value="kitir.ks_start"
                                >
                    </v-select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Selesai</label>
                    <v-select :options="['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']"
                                v-model="kitir.ks_end"
                                :disabled="$route.name == 'kitir.view'"
                                :value="kitir.ks_end"
                                >
                    </v-select>
                </div>
            </div>
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
    data() {
        return {
            kelas: '',
        }
    },
    created() {
        this.getKelas()
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('kitirsiswa', {
            siswas: state => state.siswas,
            kitir: state => state.kitir,
            kelasdata: state => state.kelas,
        })
    },
    methods: {
        ...mapActions('kitirsiswa', ['getSiswas', 'editKitir', 'getSiswaKelas', 'getKelas']),
        ...mapMutations('kitirsiswa', ['CLEAR_FORM']),
        onSearch(search, loading) {
            this.getSiswas({
                search: search,
                loading: loading
            })
        },
        cariSiswa(kelas){
            this.getSiswaKelas({
                kelas: kelas
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
