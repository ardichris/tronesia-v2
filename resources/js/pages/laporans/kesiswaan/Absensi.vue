<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-filter mr-1"></i>Filter</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <label>Start</label><span class="badge badge-danger" style="margin-left : 5px" v-if="errors.start">!</span>
                                        <input type="date" class="form-control" v-model="laporanabsensi.start">
                                    </div>
                                    <div class="col-sm-4">
                                        <label>End</label><span class="badge badge-danger" style="margin-left : 5px" v-if="errors.end">!</span>
                                        <input type="date" class="form-control" v-model="laporanabsensi.end">
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Kelas</label>
                                        <v-select :options="kelass.data"
                                            v-model="laporanabsensi.kelas"
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
                                            v-model="laporanabsensi.siswa"
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

                                    </div>
                                    <div class="col-sm-4 d-flex justify-content-center padding:5px">
                                        <a class="btn btn-app bg-success">
                                            <i class="fas fa-file-excel"></i> Excel
                                        </a>
                                        <a class="btn btn-app bg-info" @click="cariAbsensi">
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
                                                    <th>Nama Siswa</th>
                                                    <th>S</th>
                                                    <th>I</th>
                                                    <th>A</th>
                                                    <th>C</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(row, index) in rekap" :key="index">
                                                    <td>
                                                        {{row.Nama}}
                                                        <div class="badge badge-primary" v-if="row.Kelas.substr(0, 2)=='IX'">{{row.Kelas}}</div>
                                                        <div class="badge badge-danger" v-else-if="row.Kelas.substr(0, 4)=='VIII'">{{row.Kelas}}</div>
                                                        <div class="badge badge-warning" v-else>{{row.Kelas}}</div>
                                                    </td>
                                                    <td>
                                                        <span v-if="row.Sakit == 0">-</span>
                                                        <span v-else>{{row.Sakit}}</span>
                                                    </td>
                                                    <td>
                                                        <span v-if="row.Ijin == 0">-</span>
                                                        <span v-else>{{row.Ijin}}</span>
                                                    </td>
                                                    <td>
                                                        <span v-if="row.Alpha == 0">-</span>
                                                        <span v-else>{{row.Alpha}}</span>
                                                    </td>
                                                    <td>
                                                        <span v-if="row.Covid == 0">-</span>
                                                        <span v-else>{{row.Covid}}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <table style="width:100%; text-align:center" v-if="total">
                                        <thead>
                                            <tr>
                                                <th>Jenjang</th>
                                                <th>Total</th>
                                                <th>Sakit</th>
                                                <th>Ijin</th>
                                                <th>Alpha</th>
                                                <th>Covid</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>VII</td>
                                                <td>{{total.kelas7_total}}</td>
                                                <td>{{total.kelas7_sakit}}</td>
                                                <td>{{total.kelas7_ijin}}</td>
                                                <td>{{total.kelas7_alpha}}</td>
                                                <td>{{total.kelas7_covid}}</td>
                                            </tr>
                                            <tr>
                                                <td>VIII</td>
                                                <td>{{total.kelas8_total}}</td>
                                                <td>{{total.kelas8_sakit}}</td>
                                                <td>{{total.kelas8_ijin}}</td>
                                                <td>{{total.kelas8_alpha}}</td>
                                                <td>{{total.kelas8_covid}}</td>
                                            </tr>
                                            <tr>
                                                <td>IX</td>
                                                <td>{{total.kelas9_total}}</td>
                                                <td>{{total.kelas9_sakit}}</td>
                                                <td>{{total.kelas9_ijin}}</td>
                                                <td>{{total.kelas9_alpha}}</td>
                                                <td>{{total.kelas9_covid}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <b-table striped hover bordered :items="absensis.data" :fields="fields" show-empty>
                            <template v-slot:cell(absensi_tanggal)="row">
                                <span>{{row.item.absensi_tanggal|formatDateView}}</span>
                            </template>
                            <template v-slot:cell(siswa_id)="row">
                                {{ row.item.siswa_id ? row.item.siswa.s_nama:'-' }}
                            </template>
                            <template v-slot:cell(kelas)="row">
                                {{ row.item.kelas ? row.item.kelas:'-' }}
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
    name: 'LaporanKesiswaanAbsensi',
    data() {
        return {
            fields: [
                { key: 'absensi_tanggal', label: 'Tanggal' },
                { key: 'siswa_id', label: 'Nama Lengkap' },
                { key: 'kelas', label: 'Kelas'},
                { key: 'absensi_jenis', label: 'Jenis' },
                { key: 'absensi_keterangan', label: 'Keterangan' },
            ],
        }
    },
    created() {
        this.getKelas()
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('laporan', {
            laporanabsensi: state => state.laporanabsensi,
            absensis: state => state.absensis,
            kelass: state => state.kelas,
            siswas: state => state.siswa,
            rekap: state => state.rekap,
            total: state => state.total
        }),
    },
    watch: {
    },
    methods: {
        ...mapActions('laporan',['getKelas','getSiswa','getSiswaKelas','searchAbsensi']),
        ...mapMutations('laporan', ['CLEAR_FORM']),
        cariAbsensi(){
            this.searchAbsensi()
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
                kelas: this.laporanabsensi.kelas
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

