<template>
    <div class="col-md-12">
        <div class="form-group" :class="{ 'has-error': errors.absensi_tanggal }">
            <label for="">Tanggal</label>
            <div class="row">
                <div class="col-sm-12">
                    <input type="date" class="form-control" v-model="delivery.dlv_date">
                    <p class="text-danger" v-if="errors.dlv_date">Tanggal belum diisi</p>
                </div>
            </div>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.dlv_item }">
            <label for="">Barang</label>
            <input type="text" class="form-control" v-model="delivery.dlv_item" :readonly="$route.name == 'delivery.edit' || $route.name == 'delivery.view'">
            <p class="text-danger" v-if="errors.dlv_item">Barang belum diisi</p>
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
                v-model="delivery.siswa"
                @search="onSearch"
                label="s_nama"
                placeholder="Masukkan Kata Kunci"
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
        <div class="form-group" :class="{ 'has-error': errors.dlv_sender }">
            <label for="">Pengirim</label>
            <input type="text" class="form-control" v-model="delivery.dlv_sender">
            <p class="text-danger" v-if="errors.dlv_sender">Pengirim belum diisi</p>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
export default {
    name: 'FormDelivery',
    created() {
        this.getKelas()
    },
    data() {
        return {
            kelas: '',
        }
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('delivery', {
            delivery: state => state.delivery,
        }),
        ...mapState('absensi', {
            siswas: state => state.siswas,
            kelasdata: state => state.kelas,
        })
    },
    methods: {
        ...mapActions('absensi', ['getSiswas','getSiswaKelas', 'getKelas']),
        ...mapMutations('delivery', ['CLEAR_FORM']),
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
        this.CLEAR_FORM()
        this.$store.commit('CLEAR_ERRORS')
    },
    components: {
        vSelect
    }
}
</script>
