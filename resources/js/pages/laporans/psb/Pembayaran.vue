<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-filter mr-1"></i>Filter Pembayaran</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-2">
                                        <label>Start</label>
                                        <input type="date" class="form-control" v-model="laporanpembayaran.start">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>End</label>
                                        <input type="date" class="form-control" v-model="laporanpembayaran.end">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>No Form</label>
                                        <input type="text" class="form-control" v-model="laporanpembayaran.noform">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Nama Siswa</label>
                                        <input type="text" class="form-control" v-model="laporanpembayaran.siswa">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 d-flex justify-content-center padding:5px">
                                        <a class="btn btn-app bg-info" @click="cariPembayaran">
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
                                <div class="row">
                                    <div class="col-sm-6" v-if="rekap">
                                        <h4 style="text-align:center">Dalam Petra</h4>
                                        <table style="width:100%; text-align:center" >
                                            <thead>
                                                <tr>
                                                    <th>Keterangan</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Total Siswa</td>
                                                    <td>{{rekap.dalam.jumlah}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tunai / Angsuran</td>
                                                    <td>{{rekap.dalam.tunaiangsuran}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Lunas UP</td>
                                                    <td>{{rekap.dalam.lunasUP}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Angsuran 1</td>
                                                    <td>{{rekap.dalam.Angsuran1}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Angsuran 2</td>
                                                    <td>{{rekap.dalam.Angsuran2}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Angsuran 3</td>
                                                    <td>{{rekap.dalam.Angsuran3}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Angsuran 4</td>
                                                    <td>{{rekap.dalam.Angsuran4}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-sm-6" v-if="rekap">
                                        <h4 style="text-align:center">Luar Petra</h4>
                                        <table style="width:100%; text-align:center">
                                            <thead>
                                                <tr>
                                                    <th>Keterangan</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Total Siswa</td>
                                                    <td>{{rekap.luar.jumlah}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tunai / Angsuran</td>
                                                    <td>{{rekap.luar.tunaiangsuran}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Lunas UP</td>
                                                    <td>{{rekap.luar.lunasUP}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Angsuran 1</td>
                                                    <td>{{rekap.luar.Angsuran1}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Angsuran 2</td>
                                                    <td>{{rekap.luar.Angsuran2}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Angsuran 3</td>
                                                    <td>{{rekap.luar.Angsuran3}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Angsuran 4</td>
                                                    <td>{{rekap.luar.Angsuran4}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <b-table striped hover bordered :items="pembayarans" :fields="fields" show-empty>
                            <template v-slot:cell(Angsuran1)="row">
                                <div style="text-align:center">{{row.item.Angsuran1==0?'Lunas':row.item.Angsuran1}}</div>
                            </template>
                            <template v-slot:cell(Angsuran2)="row">
                                <div style="text-align:center">{{row.item.Angsuran2==0?'Lunas':row.item.Angsuran2}}</div>
                            </template>
                            <template v-slot:cell(Angsuran3)="row">
                                <div style="text-align:center">{{row.item.Angsuran3==0?'Lunas':row.item.Angsuran3}}</div>
                            </template>
                            <template v-slot:cell(Angsuran4)="row">
                                <div style="text-align:center">{{row.item.Angsuran4==0?'Lunas':row.item.Angsuran4}}</div>
                            </template>
                            <template v-slot:cell(Sisa)="row">
                                <div style="text-align:center">{{row.item.Sisa==0?'Lunas':row.item.Sisa}}</div>
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
    name: 'LaporanKesiswaanpembayaran',
    data() {
        return {
            fields: [
                { key: 'Noform', label: 'No Form', sortable: true },
                { key: 'Kode', label: 'Kode', sortable: true },
                { key: 'Nama', label: 'Nama Siswa' },
                { key: 'Angsuran1', label: '1'},
                { key: 'Angsuran2', label: '2'},
                { key: 'Angsuran3', label: '3'},
                { key: 'Angsuran4', label: '4'},
                { key: 'Sisa', label: 'Sisa Pembayaran'}
            ],
        }
    },
    created() {
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('laporan', {
            laporanpembayaran: state => state.laporanpembayaran,
            pembayarans: state => state.pembayarans,
            rekap: state => state.rekap
        }),
    },
    watch: {
    },
    methods: {
        ...mapActions('laporan',['getKelas','getSiswa','getSiswaKelas','searchPembayaran']),
        ...mapMutations('laporan', ['CLEAR_FORM']),
        cariPembayaran(){
            this.searchPembayaran()
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
    },
    components: {
        vSelect
    }
}
</script>

