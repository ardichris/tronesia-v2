<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-filter mr-1"></i>Filter Pelanggaran</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <label>Start</label><span class="badge badge-danger" style="margin-left : 5px" v-if="errors.start">!</span>
                                        <input type="date" class="form-control" v-model="laporanpelanggaran.start">
                                    </div>
                                    <div class="col-sm-4">
                                        <label>End</label><span class="badge badge-danger" style="margin-left : 5px" v-if="errors.end">!</span>
                                        <input type="date" class="form-control" v-model="laporanpelanggaran.end">
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Kelas</label>
                                        <v-select :options="kelass.data"
                                            v-model="laporanpelanggaran.kelas"
                                            @change="cari"
                                            :value="$store.myValue"
                                            label="kelas_nama"
                                            placeholder="Masukkan Kata Kunci"
                                            :filterable="false">
                                            <template slot="no-options">
                                                Masukkan Kata Kunci
                                            </template>
                                            <template slot="option" slot-scope="option">
                                                {{ option.kelas_nama }}
                                            </template>
                                        </v-select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <label for="">Nama Siswa</label>
                                        <v-select :options="siswas.data"
                                            v-model="laporanpelanggaran.siswa"
                                            @search="onSearch"
                                            label="s_nama"
                                            placeholder="Masukkan Kata Kunci"
                                            :disabled="$route.name == 'pelanggaran.view'"
                                            :filterable="false">
                                            <template slot="no-options">
                                                Masukkan Kata Kunci
                                            </template>
                                            <template slot="option" slot-scope="option">
                                                {{ option.s_nama }} ({{ option.kelas }})
                                            </template>
                                        </v-select>

                                    </div>
                                    <div class="col-sm-4 d-flex justify-content-center padding:5px">
                                        <a class="btn btn-app bg-success">
                                            <i class="fas fa-file-excel"></i> Excel
                                        </a>
                                        <a class="btn btn-app bg-info" @click="cariPelanggaran">
                                            <i class="fas fa-search"></i> Search
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-check mr-1"></i>Rekap</h3>
                            </div>
                            <div class="card-body">
                                <div class="row col-sm-12">
                                    <div class="table-responsive" v-if="rekap">
                                        <table class="table" width="auto">
                                            <thead>
                                                <tr>
                                                    <th>Pelanggaran</th>
                                                    <th>Kategori</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(row, index) in rekap" :key="index">
                                                    <td>
                                                        {{row.mp_pelanggaran}}
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-primary" v-if="row.mp_kategori=='Ringan'">{{row.mp_kategori}}</div>
                                                        <div class="badge badge-danger" v-else-if="row.mp_kategori=='Berat'">{{row.mp_kategori}}</div>
                                                        <div class="badge badge-warning" v-else>{{row.mp_kategori}}</div>
                                                    </td>
                                                    <td>
                                                        {{row.jumlah}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive" v-if="total">
                                        <table class="table" width="auto">
                                            <thead>
                                                <tr>
                                                    <th>Nama Siswa</th>
                                                    <th>Kelas</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(row, index) in total" :key="index">
                                                    <td>
                                                        {{row.Nama}}
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-primary" v-if="row.Kelas.substr(0, 2)=='IX'">{{row.Kelas}}</div>
                                                        <div class="badge badge-danger" v-else-if="row.Kelas.substr(0, 4)=='VIII'">{{row.Kelas}}</div>
                                                        <div class="badge badge-warning" v-else>{{row.Kelas}}</div>
                                                    </td>
                                                    <td style="text-align:center">
                                                        {{row.Pelanggaran}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <b-table striped hover bordered :items="pelanggarans.data" :fields="fields" show-empty>
                            <template v-slot:cell(pelanggaran_tanggal)="row">
                                <span>{{row.item.pelanggaran_tanggal|formatDateView}}</span>
                            </template>
                            <template v-slot:cell(siswa_id)="row">
                                {{ row.item.siswa_id ? row.item.siswa.s_nama:'-' }}
                            </template>
                            <template v-slot:cell(kelas)="row">
                                {{ row.item.kelas ? row.item.kelas:'-' }}
                            </template>
                            <template v-slot:cell(pelanggaran_jenis)="row">
                                {{ row.item.masterpelanggaran.mp_pelanggaran ? row.item.masterpelanggaran.mp_pelanggaran:'-' }}
                            </template>
                        </b-table>
                    </div>
                </div>
            </div>
            <div class="panel-body">

            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState, mapMutations } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'

export default {
    name: 'LaporanKesiswaanpelanggaran',
    data() {
        return {
            fields: [
                { key: 'pelanggaran_tanggal', label: 'Tanggal' },
                { key: 'siswa_id', label: 'Nama Lengkap' },
                { key: 'kelas', label: 'Kelas'},
                { key: 'pelanggaran_jenis', label: 'Pelanggaran' },
                { key: 'pelanggaran_keterangan', label: 'Keterangan' },
            ],
        }
    },
    created() {
        this.getKelas()
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('laporan', {
            laporanpelanggaran: state => state.laporanpelanggaran,
            pelanggarans: state => state.pelanggarans,
            kelass: state => state.kelas,
            siswas: state => state.siswa,
            rekap: state => state.rekap,
            total: state => state.total
        }),
    },
    watch: {
    },
    methods: {
        ...mapActions('laporan',['getKelas','getSiswa','getSiswaKelas','searchPelanggaran']),
        ...mapMutations('laporan', ['CLEAR_FORM']),
        cariPelanggaran(){
            this.searchPelanggaran()
            .then(() => {
                this.$swal({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    type: 'success',
                    title: 'Success'
                })
            })
            .catch(() => {
                this.$swal({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    type: 'error',
                    title: 'Search Failed'
                })
            })
        },
        cari(){
            this.getSiswaKelas({
                kelas: this.laporanpelanggaran.kelas
            })
        },
        onSearch(search, loading) {
            this.getSiswa({
                search: search,
                loading: loading,
            })
        },
        searchKelas(search, loading) {
            this.getKelas({
                search: search,
                loading: loading
            })
        },
    },
    components: {
        vSelect
    }
}
</script>

