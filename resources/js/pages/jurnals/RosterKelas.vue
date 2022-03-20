<template>
    <div class="container">
    <div class="row" style="margin-bottom:10px">
        <div class="col-sm-4">
            <label>Kelas</label>
            <v-select :options="kelass.data"
                v-model="rekapjurnal.kelas"
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
            <input type="date" class="form-control" v-model="rekapjurnal.start">
        </div>
        <div class="col-sm-4">
            <label>Tanggal Akhir</label>
            <input type="date" class="form-control" v-model="rekapjurnal.end">
        </div>
    </div>
    <div class="row" style="margin-bottom:10px">                            
        <div class="col-sm-12">
            <span class="float-right">
            <b-button variant="success" size="sm" @click="getRoster" style="float-center">Submit</b-button>
            </span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table" width="auto">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>0</th>
                    <th>1</th>
                    <th>2</th>                                        
                    <th>3</th>                                        
                    <th>4</th>                                        
                    <th>5</th>                                        
                    <th>6</th>                                        
                    <th>7</th>                                        
                    <th>8</th>                                        
                    <th>9</th>                                        
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in rekapjurnal.jurnal" :key="index">
                    <td>
                        {{index}}
                    </td>
                    <td>
                        <span v-if="row.jam0">
                            <span class="badge badge-success" v-if="row.jam0.jm_status == 1">Approved</span>
                            <span  class="badge badge-warning" v-if="row.jam0.jm_status == 0">Submitted</span>
                        </span>
                    </td>
                    <td>
                        <span v-if="row.jam1">
                            <span class="badge badge-success" v-if="row.jam1.jm_status == 1">Approved</span>
                            <span  class="badge badge-warning" v-if="row.jam1.jm_status == 0">Submitted</span>
                            <span class="badge badge-dark" v-if="row.jam1.guru">{{row.jam1.guru?row.jam1.guru:"-"}}</span>
                        </span>
                    </td>
                    <td>
                        <span v-if="row.jam2">
                            <span class="badge badge-success" v-if="row.jam2.jm_status == 1">Approved</span>
                            <span  class="badge badge-warning" v-if="row.jam2.jm_status == 0">Submitted</span>
                            <span class="badge badge-dark" v-if="row.jam2.guru">{{row.jam2.guru?row.jam2.guru:"-"}}</span>
                        </span>
                    </td>
                    <td>
                        <span v-if="row.jam3">
                            <span class="badge badge-success" v-if="row.jam3.jm_status == 1">Approved</span>
                            <span  class="badge badge-warning" v-if="row.jam3.jm_status == 0">Submitted</span>
                            <span class="badge badge-dark" v-if="row.jam3.guru">{{row.jam3.guru?row.jam3.guru:"-"}}</span>
                        </span>
                    </td>
                    <td>
                        <span v-if="row.jam4">
                            <span class="badge badge-success" v-if="row.jam4.jm_status == 1">Approved</span>
                            <span  class="badge badge-warning" v-if="row.jam4.jm_status == 0">Submitted</span>
                            <span class="badge badge-dark" v-if="row.jam4.guru">{{row.jam4.guru?row.jam4.guru:"-"}}</span>
                        </span>
                    </td>
                    <td>
                        <span v-if="row.jam5">
                            <span class="badge badge-success" v-if="row.jam5.jm_status == 1">Approved</span>
                            <span  class="badge badge-warning" v-if="row.jam5.jm_status == 0">Submitted</span>
                            <span class="badge badge-dark" v-if="row.jam5.guru">{{row.jam5.guru?row.jam5.guru:"-"}}</span>
                        </span>
                    </td>
                    <td>
                        <span v-if="row.jam6">
                            <span class="badge badge-success" v-if="row.jam6.jm_status == 1">Approved</span>
                            <span  class="badge badge-warning" v-if="row.jam6.jm_status == 0">Submitted</span>
                            <span class="badge badge-dark" v-if="row.jam6.guru">{{row.jam6.guru?row.jam6.guru:"-"}}</span>
                        </span>
                    </td>
                    <td>
                        <span v-if="row.jam7">
                            <span class="badge badge-success" v-if="row.jam7.jm_status == 1">Approved</span>
                            <span  class="badge badge-warning" v-if="row.jam7.jm_status == 0">Submitted</span>
                            <span class="badge badge-dark" v-if="row.jam7.guru">{{row.jam7.guru?row.jam7.guru:"-"}}</span>
                        </span>
                    </td>
                    <td>
                        <span v-if="row.jam8">
                            <span class="badge badge-success" v-if="row.jam8.jm_status == 1">Approved</span>
                            <span  class="badge badge-warning" v-if="row.jam8.jm_status == 0">Submitted</span>
                            <span class="badge badge-dark" v-if="row.jam8.guru">{{row.jam8.guru?row.jam8.guru:"-"}}</span>
                        </span>
                    </td>
                    <td>
                        <span v-if="row.jam9">
                            <span class="badge badge-success" v-if="row.jam9.jm_status == 1">Approved</span>
                            <span  class="badge badge-warning" v-if="row.jam9.jm_status == 0">Submitted</span>
                            <span class="badge badge-dark" v-if="row.jam9.guru">{{row.jam9.guru?row.jam9.guru:"-"}}</span>
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