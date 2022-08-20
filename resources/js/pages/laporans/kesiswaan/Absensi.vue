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
                                    <div class="col-sm-4">
                                        <label>Tanggal Awal</label>
                                        <input type="date" class="form-control" v-model="laporanabsensi.start">
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Tanggal Akhir</label>
                                        <input type="date" class="form-control" v-model="laporanabsensi.end">
                                    </div>
                                </div>
                                <div class="row mb-2">
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
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-check mr-1"></i>Rekap</h3>
                            </div>
                            <div class="card-body">
                                <div class="row col-sm-12">
                                    <table style="width:100%; text-align:center" v-if="rekap.kelas7_total">
                                        <thead>
                                            <tr>
                                                <th>Jenjang</th>
                                                <th>Total</th>
                                                <th>Sakit</th>
                                                <th>Ijin</th>
                                                <th>Alpha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>VII</td>
                                                <td>{{rekap.kelas7_total}}</td>
                                                <td>{{rekap.kelas7_sakit}}</td>
                                                <td>{{rekap.kelas7_ijin}}</td>
                                                <td>{{rekap.kelas7_alpha}}</td>
                                            </tr>
                                            <tr>
                                                <td>VIII</td>
                                                <td>{{rekap.kelas8_total}}</td>
                                                <td>{{rekap.kelas8_sakit}}</td>
                                                <td>{{rekap.kelas8_ijin}}</td>
                                                <td>{{rekap.kelas8_alpha}}</td>
                                            </tr>
                                            <tr>
                                                <td>IX</td>
                                                <td>{{rekap.kelas9_total}}</td>
                                                <td>{{rekap.kelas9_sakit}}</td>
                                                <td>{{rekap.kelas9_ijin}}</td>
                                                <td>{{rekap.kelas9_alpha}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
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
        ...mapState('laporan', {
            laporanabsensi: state => state.laporanabsensi,
            absensis: state => state.absensis,
            kelass: state => state.kelas,
            siswas: state => state.siswa,
            rekap: state => state.rekap
        }),
    },
    watch: {
    },
    methods: {
        ...mapActions('laporan',['getKelas','getSiswa','getSiswaKelas','searchAbsensi']),
        ...mapMutations('laporan', ['CLEAR_FORM']),
        cariAbsensi(){
            this.searchAbsensi()
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

