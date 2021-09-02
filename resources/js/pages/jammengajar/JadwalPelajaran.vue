<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="col-md-4">
                    <span>
                    <v-select :options="kelass.data"
                        v-model="jp.kelas" 
                        @search="SearchKelas"
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
                    </span>
                    <span>
                        <b-button variant="success" size="sm" @click="getJadwal">Submit</b-button>
                    </span>
                </div>
            </div>
            <div class="panel-body">
                <b-modal id="add-modal" size="sm">
                    <template v-slot:modal-title>
                        Tambah Jadwal Pelajaran
                    </template>
                    <div class="form-group">
                        <label>Kelas</label>
                        <b-form-input v-model="jp.kelas.kelas_nama"  :disabled='true'></b-form-input>
                    </div>
                    <div class="form-group">
                        <label>Hari</label>
                        <b-form-input v-model="jp.hari" :disabled='true'></b-form-input>
                    </div>
                    <div class="form-group">
                        <label>Jam Pelajaran</label>
                        <b-form-input v-model="jp.jampel"></b-form-input>
                    </div>
                    <div class="form-group">
                        <label>Mapel</label>
                        <v-select :options="mapels.data"
                            v-model="jp.mapel"
                            @search="SearchMapel" 
                            label="mapel_kode"
                            placeholder="Masukkan Kata Kunci" 
                            :filterable="false">
                            <template slot="no-options">
                                Masukkan Kata Kunci
                            </template>
                            <template slot="option" slot-scope="option">
                                {{ option.mapel_kode }}
                            </template>
                        </v-select>
                    </div>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"                                    
                            block @click="simpanJPbaru"
                        >
                            Simpan
                        </b-button>
                    </template>
                </b-modal>
                <div class="row">
                    <div class="card col-md-4" v-for="(rowday, indexday) in jadwalpelajaran" :key="indexday">
                        <div class="card-header">
                                <h3 class="card-title">{{indexday}}</h3>
                                <span class="float-right">
                                    <!-- <button class="btn btn-warning btn-sm" v-b-modal="'add-modal'" @click="addJP(indexday)"><i class="fa fa-plus"></i></button> -->
                                </span>
                        </div>
                        <div class="card-body">
                                <table class="table" width="auto">
                                    <thead>
                                        <tr>
                                            <th>Jam</th>
                                            <th>Pengajar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row, index) in rowday" :key="index">
                                            <td>
                                                {{index}}
                                            </td>
                                            <td>
                                                <div v-for="(rowjam, indexjam) in row" :key="indexjam">
                                                    <span class="badge badge-info">{{rowjam.mapel.mapel_kode}}</span>
                                                    <span class="badge badge-success">{{rowjam.guru.name}}</span>
                                                    <button type ="button" class ="btn btn-danger btn-circle btn-xs" @click="deleteJP(rowjam.id)"><i class="fa fa-minus"></i></button>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" v-b-modal="'add-modal'" @click="addJP(indexday,index)"><i class="fa fa-plus"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapMutations, mapActions, mapState } from 'vuex'
import vSelect from 'vue-select'
import _ from 'lodash'

export default {
    name: 'DataJM',
    created() {
    },
    data() {
        return {
            search: ''
        }
    },
    computed: {
        ...mapState('jammengajar', {
            jammengajar: state => state.jammengajar,
            kelass: state => state.kelas,
            mapels: state => state.mapel,
            jadwalkelass: state => state.jadwalkelas,
            jadwalpelajaran: state => state.jadwalpelajaran,
            jp: state => state.jadwal
        })
    },
    watch: {
        page() {
            this.getJM()
        },
        search() {
            this.getJM(this.search)
        }
    },
    methods: {
        ...mapActions('jammengajar', ['getMapel','getKelas','getJP','submitJP','removeJP']),
        addJP(hari,jam){
            this.jp.hari = hari,
            this.jp.jampel = jam,
            this.$bvModal.show('add-modal')
        },
        simpanJPbaru(){
            this.submitJP().then(() => {
                this.$bvModal.hide('add-modal'),
                this.jp.mapel = ''
            })
        },
        deleteJP(id){
            this.$swal({
                title: 'Kamu Yakin?',
                text: "Tindakan ini akan menghapus secara permanent!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, Lanjutkan!'
            }).then((result) => {
                if (result.value) {
                    this.removeJP(id)
                }
            })
        },
        SearchKelas(search, loading) {
            this.getKelas({
                search: search,
                loading: loading
            })
        },
        SearchMapel(search, loading) {
            this.getMapel({
                search: search,
                loading: loading
            })
        },
        getJadwal(){
            this.getJP()
        }
        
    },
    components: {
        vSelect
    }
}
</script>

