<template>
    <div class>
        <div class="alert alert-danger alert-dismissible col-md-12" v-if="pelanggaran.p_jumlah!=''">
            Total Pelanggaran : {{pelanggaran.p_jumlah}}
        </div>
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
                v-model="pelanggaran.siswa_id"
                @search="onSearch"
                v-on:input="setMP"
                label="s_nama"
                placeholder="Masukkan Kata Kunci"
                :disabled="$route.name == 'pelanggarans.view'"
                :filterable="false">
                <template slot="no-options">
                    Masukkan Kata Kunci
                </template>
                <template slot="option" slot-scope="option">
                    <!-- <span class="badge badge-dark">({{ option.kelas }}/{{option.absen}})</span> {{ option.s_nama }} -->
                    <span><div class="badge badge-primary" v-if="option.kelas.substr(0, 2)=='IX'">{{option.kelas}}/{{option.absen}}</div>
                    <div class="badge badge-danger" v-else-if="option.kelas.substr(0, 4)=='VIII'">{{option.kelas}}/{{option.absen}}</div>
                    <div class="badge badge-warning" v-else-if="option.kelas.substr(0, 4)=='VII-'">{{option.kelas}}/{{option.absen}}</div>
                    <div class="badge badge-dark" v-else>{{option.kelas}}</div> {{ option.s_nama }}</span>
                    <!-- {{ option.s_nama }} - ({{ option.kelas }}/{{option.absen}}) -->
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
        <div class="form-group" :class="{ 'has-error': errors.mp_id }">
            <label for="">Pelanggaran yang dilakukan</label>
            <v-select :options="MPs.data"
                v-model="pelanggaran.mp_id"
                @search="onSearchMP"
                v-on:input="onSearchPelanggaran"
                label="mp_pelanggaran"
                placeholder="Masukkan Kata Kunci"
                :disabled="$route.name == 'pelanggarans.view'"
                :filterable="false">
                <template slot="no-options">
                    Masukkan Kata Kunci
                </template>
                <template slot="option" slot-scope="option">
                    {{ option.mp_pelanggaran }}
                    <span class="badge badge-danger float-right" v-if="option.total>0">{{option.total}}</span>
                </template>
            </v-select>
            <p class="text-danger" v-if="errors.mp_id">Pelanggaran belum diisi</p>
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
    data() {
        return {
            kelas: '',
        }
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('pelanggaran', {
            siswas: state => state.siswas,
            MPs: state => state.MPs,
            pelanggaran: state => state.pelanggaran,
            kelasdata: state=> state.kelas
        })

    },
    methods: {
        ...mapActions('pelanggaran', ['getSiswas', 'getMPs', 'getMP', 'editPelanggaran','getSiswaKelas','getTotalPelanggaran']),
        ...mapMutations('pelanggaran', ['CLEAR_FORM']),
        setMP(){
            this.getMP({
                cat: 'Ringan',
            })
            this.getTotalPelanggaran()

        },
        onSearch(search, loading) {
            this.getSiswas({
                search: search,
                loading: loading
            })
        },
        onSearchPelanggaran(search, loading) {
            this.getTotalPelanggaran({
                search: search,
                loading: loading
            })
        },
        onSearchMP(search, loading) {
            this.getMPs({
                search: search,
                loading: loading
            })
        },
        cari(){
            this.getSiswaKelas({
                kelas: this.kelas
            })
        },
    },
    destroyed() {
            this.CLEAR_FORM()
    },
    components: {
        vSelect
    }
}
</script>
