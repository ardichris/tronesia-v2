<template>
    <div class="container">
        <div class="col-lg-3">
                                <input type="date" class="form-control" v-model="rekapjurnal.tanggal" @change="getRoster">
                            </div>
                            <div class="table-responsive">
                                <table class="table" width="auto">
                                    <thead>
                                        <tr>
                                            <th>Kelas</th>
                                            <th style="text-align:center; width:100px">0</th>
                                            <th style="text-align:center">1</th>
                                            <th style="text-align:center">2</th>
                                            <th style="text-align:center">3</th>
                                            <th style="text-align:center">4</th>
                                            <th style="text-align:center">5</th>
                                            <th style="text-align:center">6</th>
                                            <th style="text-align:center">7</th>
                                            <th style="text-align:center">8</th>
                                            <th style="text-align:center">9</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row, index) in rekapjurnal.jurnal" :key="index">
                                            <td>
                                                {{row.kelas_nama}}
                                            </td>
                                            <td>
                                                <span v-if="row.jam0.jm_status < 2">
                                                    <span class="badge badge-success" v-if="row.jam0.jm_status == 1">Approved</span>
                                                    <span  class="badge badge-warning" v-if="row.jam0.jm_status == 0">Submitted</span>
                                                </span>
                                            </td>
                                            <td>
                                                <span v-if="row.jam1.jm_status < 2" >
                                                    <span class="badge badge-success" v-if="row.jam1.jm_status == 1">Approved</span>
                                                    <span  class="badge badge-warning" v-if="row.jam1.jm_status == 0">Submitted</span>
                                                </span>
                                                <div v-else v-for="(rowjam, indexjam) in row.jam1" :key="indexjam">
                                                    <span class="badge badge-dark">{{rowjam}}</span>                                                  
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="row.jam2.jm_status < 2">
                                                    <span class="badge badge-success" v-if="row.jam2.jm_status == 1">Approved</span>
                                                    <span  class="badge badge-warning" v-if="row.jam2.jm_status == 0">Submitted</span>
                                                </span>
                                                <div v-else v-for="(rowjam, indexjam) in row.jam2" :key="indexjam">
                                                    <span class="badge badge-dark">{{rowjam}}</span>                                                  
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="row.jam3.jm_status < 2">
                                                    <span class="badge badge-success" v-if="row.jam3.jm_status == 1">Approved</span>
                                                    <span  class="badge badge-warning" v-if="row.jam3.jm_status == 0">Submitted</span>
                                                </span>
                                                <div v-else v-for="(rowjam, indexjam) in row.jam3" :key="indexjam">
                                                    <span class="badge badge-dark">{{rowjam}}</span>                                                  
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="row.jam4.jm_status < 2">
                                                    <span class="badge badge-success" v-if="row.jam4.jm_status == 1">Approved</span>
                                                    <span  class="badge badge-warning" v-if="row.jam4.jm_status == 0">Submitted</span>
                                                </span>
                                                <div v-else v-for="(rowjam, indexjam) in row.jam4" :key="indexjam">
                                                    <span class="badge badge-dark">{{rowjam}}</span>                                                  
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="row.jam5.jm_status < 2">
                                                    <span class="badge badge-success" v-if="row.jam5.jm_status == 1">Approved</span>
                                                    <span  class="badge badge-warning" v-if="row.jam5.jm_status == 0">Submitted</span>
                                                </span>
                                                <div v-else v-for="(rowjam, indexjam) in row.jam5" :key="indexjam">
                                                    <span class="badge badge-dark">{{rowjam}}</span>                                                  
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="row.jam6.jm_status < 2">
                                                    <span class="badge badge-success" v-if="row.jam6.jm_status == 1">Approved</span>
                                                    <span  class="badge badge-warning" v-if="row.jam6.jm_status == 0">Submitted</span>
                                                </span>
                                                <div v-else v-for="(rowjam, indexjam) in row.jam6" :key="indexjam">
                                                    <span class="badge badge-dark">{{rowjam}}</span>                                                  
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="row.jam7.jm_status < 2">
                                                    <span class="badge badge-success" v-if="row.jam7.jm_status == 1">Approved</span>
                                                    <span  class="badge badge-warning" v-if="row.jam7.jm_status == 0">Submitted</span>
                                                </span>
                                                <div v-else v-for="(rowjam, indexjam) in row.jam7" :key="indexjam">
                                                    <span class="badge badge-dark">{{rowjam}}</span>                                                  
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="row.jam8.jm_status < 2">
                                                    <span class="badge badge-success" v-if="row.jam8.jm_status == 1">Approved</span>
                                                    <span  class="badge badge-warning" v-if="row.jam8.jm_status == 0">Submitted</span>
                                                </span>
                                                <div v-else v-for="(rowjam, indexjam) in row.jam8" :key="indexjam">
                                                    <span class="badge badge-dark">{{rowjam}}</span>                                                  
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="row.jam9.jm_status < 2">
                                                    <span class="badge badge-success" v-if="row.jam9.jm_status == 1">Approved</span>
                                                    <span  class="badge badge-warning" v-if="row.jam9.jm_status == 0">Submitted</span>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
import _ from 'lodash'
export default {
    name: 'FormJurnal',
    data() {
        return {
            isForm: false,
            isSuccess: false,
            jurnals: {
                detail: [
                    { siswa: null, alasan: null }
                ],
                pelanggaran: [
                    { siswa: null, pelanggaran_jenis: null, pelanggaran_keterangan: null }
                ]
            }
        }
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('jurnal', {
            rekapjurnal: state => state.rekapjurnal,
            kelass: state => state.kelas
        }),
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        filterSiswa() {
            return _.filter(this.jurnal.detail, function(item) {
                return item.siswa == null
            })
        },
        filterPelanggaran() {
            return _.filter(this.jurnal.pelanggaran, function(item) {
                return item.siswa == null
            })
        },
    },
    methods: {
        ...mapActions('jurnal',['getRosterJurnal','getKelas']),
        ...mapMutations('jurnal', ['CLEAR_FORM']), //PANGGIL MUTATIONS CLEAR_FORM
        searchKelas(search, loading) {
            this.getKelas({
                search: search,
                loading: loading
            })            
        },
        getRoster(){
            this.getRosterJurnal();
        },
    },
    //KETIKA PAGE INI DITINGGALKAN MAKA 
    destroyed() {
        //FORM DI BERSIHKAN
        this.CLEAR_FORM()
    },
    components: {
        vSelect
    }
}
</script>