<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-filter mr-1"></i>Filter Nilai</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Kelas</label>
                                        <v-select :options="kelass.data"
                                            v-model="laporannilai.kelas"
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
                                        <!-- <label for="">Nama Siswa</label>
                                        <v-select :options="siswas.data"
                                            v-model="laporannilai.siswa"
                                            @search="onSearch"
                                            label="s_nama"
                                            placeholder="Masukkan Kata Kunci"
                                            :disabled="$route.name == 'nilai.view'"
                                            :filterable="false">
                                            <template slot="no-options">
                                                Masukkan Kata Kunci
                                            </template>
                                            <template slot="option" slot-scope="option">
                                                {{ option.s_nama }} ({{ option.kelas }})
                                            </template>
                                        </v-select> -->

                                    </div>
                                    <div class="col-sm-4 d-flex justify-content-center padding:5px">
                                        <a class="btn btn-app bg-success">
                                            <i class="fas fa-file-excel"></i> Excel
                                        </a>
                                        <a class="btn btn-app bg-info" @click="cariNilai">
                                            <i class="fas fa-search"></i> Search
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-check mr-1"></i>Rekap</h3>
                    </div>
                    <div class="card-body">
                        <div class="row col-sm-12">
                            <div class="table-responsive" v-if="nilais">
                                <table class="table" width="auto" v-for="(row, index) in nilais" :key="index">
                                    <thead>
                                        <tr>
                                            <th>Nama Kelas</th>
                                            <th>Mapel</th>
                                            <th>KI3</th>
                                            <th>KI4</th>
                                            <th>PTS</th>
                                            <th>PAS</th>
                                            <th>SUM</th>
                                            <th>SAS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(rowmapel, indexmapel) in row" :key="indexmapel">
                                            <td>{{index}}</td>
                                            <td>{{indexmapel}}</td>
                                            <td>{{rowmapel.KI3}}</td>
                                            <td>{{rowmapel.KI4}}</td>
                                            <td>{{rowmapel.PTS}}</td>
                                            <td>{{rowmapel.PAS}}</td>
                                            <td>{{rowmapel.SUM}}</td>
                                            <td>{{rowmapel.SAS}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState, mapMutations } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'

export default {
    name: 'LaporanKesiswaanNilai',
    data() {
        return {
            fields: [
                { key: 'nilai_tanggal', label: 'Tanggal' },
                { key: 'siswa_id', label: 'Nama Lengkap' },
                { key: 'kelas', label: 'Kelas'},
                { key: 'nilai_jenis', label: 'Jenis' },
                { key: 'nilai_keterangan', label: 'Keterangan' },
            ],
        }
    },
    created() {
        this.getKelas()
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('laporan', {
            laporannilai: state => state.laporannilai,
            nilais: state => state.nilais,
            kelass: state => state.kelas,
            siswas: state => state.siswa,
            rekap: state => state.rekap,
            total: state => state.total
        }),
    },
    watch: {
    },
    methods: {
        ...mapActions('laporan',['getKelas','getSiswa','getSiswaKelas','searchNilai']),
        ...mapMutations('laporan', ['CLEAR_FORM']),
        cariNilai(){
            this.searchNilai()
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
                kelas: this.laporannilai.kelas
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

