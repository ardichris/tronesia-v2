<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading" style="margin-bottom:10px">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >
                        <b-button variant="success" size="sm" v-b-modal="'modal-rekap-presensi'" @click="$bvModal.show('modal-rekap-presensi')">Rekap Presensi</b-button>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="float-right">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search">
                        </span>
                    </div>
                    <b-modal id="modal-rekap-presensi" size="lg">
                        <template v-slot:modal-title>
                            Rekap Presensi
                        </template>
                        <div class="row" style="margin-bottom:10px">
                            <div class="col-sm-4">
                                <label>Kelas</label>
                                <v-select :options="kelas.data"
                                    v-model="rekappresensi.kelas"
                                    @search="searchKelas"
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
                                <input type="date" class="form-control" v-model="rekappresensi.tanggalawal">
                            </div>
                            <div class="col-sm-4">
                                <label>Tanggal Akhir</label>
                                <input type="date" class="form-control" v-model="rekappresensi.tanggalakhir">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px">                            
                            <div class="col-sm-12">
                                <span class="float-right">
                                <b-button variant="success" size="sm" @click="getRekap" style="float-center">Submit</b-button>
                                </span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" width="auto">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th>S</th>
                                        <th>I</th>
                                        <th>A</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row, index) in rekappresensi.presensi" :key="index">
                                        <td>
                                            {{row.s_nama}}
                                        </td>
                                        <td>
                                            <span v-if="row.sakit == 0">-</span>
                                            <span v-else>{{row.sakit}}</span>
                                        </td>
                                        <td>
                                            <span v-if="row.ijin == 0">-</span>
                                            <span v-else>{{row.ijin}}</span>
                                        </td>
                                        <td>
                                            <span v-if="row.alpha == 0">-</span>
                                            <span v-else>{{row.alpha}}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </b-modal>
                </div>
            </div>
            <div class="panel-body">
              
              	<!-- TABLE UNTUK MENAMPILKAN LIST PELANGGARAN -->
                <b-table striped hover bordered :items="presensis.data" :fields="fields" show-empty>                	
                    <template v-slot:cell(siswa)="row">
                        {{ row.item.siswa_id ? row.item.siswa.s_nama:'-' }}
                    </template>
                    <template v-slot:cell(presensi_tanggal)="row">
                        <h5><span class="badge badge-info">{{ row.item.jurnal.jm_tanggal ? row.item.jurnal.jm_tanggal:'-' }}</span></h5>
                    </template>
                    <template v-slot:cell(jampel)="row">
                        <h5><span class="badge badge-warning">{{ row.item.siswa.kelas_id ? row.item.siswa.kelas.kelas_nama:'-' }} <span class="badge badge-danger">{{ row.item.jurnal.jm_jampel}}</span></span></h5>
                    </template>
                </b-table>
              	<!-- TABLE UNTUK MENAMPILKAN LIST PELANGGARAN -->

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="presensis.data"><i class="fa fa-bars"></i> {{ presensis.data.length }} item dari {{ presensis.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="presensis.meta.total"
                                :per-page="presensis.meta.per_page"
                                aria-controls="presensis"
                                v-if="presensis.data && presensis.data.length > 0"
                                ></b-pagination>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState, mapMutations } from 'vuex'
import vSelect from 'vue-select'

export default {
    name: 'DataPresensi',
    created() {
        this.getPresensi()
    },
    data() {
        return {
            fields: [
                { key: 'presensi_tanggal', label: 'Tanggal' },
                { key: 'jampel', label: 'Kelas/JP' },
                { key: 'siswa', label: 'Nama Lengkap' },
                { key: 'alasan', label: 'Alasan' }
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('presensi', {
            presensis: state => state.presensis,
            presensi: state => state.presensi,
            siswas: state => state.siswas,
            rekappresensi: state => state.rekappresensi,
            kelas: state => state.kelas,
        }),
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        //MENGAMBIL DATA PAGE DARI STATE PELANGGARAN
        page: {
            get() {
                return this.$store.state.presensi.page
            },
            set(val) {
                this.$store.commit('presensi/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getPresensi(this.search)
        },
        search() {
            this.getPresensi(this.search)
        }
    },
    methods: {
        ...mapActions('presensi', ['getPresensi','getKelas','getRekapPresensi']),
        ...mapMutations('presensi', ['CLEAR_FORM']),
        getRekap(){
            this.getRekapPresensi();
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
    },
    destroyed() {
        this.CLEAR_FORM()
    },
}
</script>