<template>
    <div class="col-md-12">
        <div class="form-group" :class="{ 'has-error': errors.guru }">
            <label for="">Pengajar</label>
            <v-select :options="gurus.data"
                v-model="jammengajar.guru"
                @search="SearchGuru" 
                label="name"
                placeholder="Masukkan Kata Kunci" 
                :filterable="false">
                <template slot="no-options">
                    Masukkan Kata Kunci
                </template>
                <template slot="option" slot-scope="option">
                    {{ option.name }} - {{option.unit.unit_kode}}
                </template>
            </v-select>
            <p class="text-danger" v-if="errors.guru">{{ errors.guru[0] }}</p>
        </div>
        <label for="">Daftar Mengajar</label><br>
        <button class="btn btn-warning btn-sm float-right" style="margin-bottom: 10px" @click="addKelas">Tambah</button>
        <div class="table-responsive" style="height: 300px">
            <table class="table" >
                <thead>
                    <tr>
                        <th width="25%">Mapel</th>
                        <th width="75%">Nama Kelas</th>
                        <th></th>
                    </tr>
                </thead>
                <!-- TABLE INI BERGUNA UNTUK MENAMBAHKAN ITEM TRANSAKSI -->
                <tbody>
                    <tr v-for="(row, index) in jammengajar.mengajar" :key="index">
                        <td>
                            <v-select :options="mapels.data"
                                v-model="row.mapel"
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
                        </td>
                        <td>
                            <v-select :options="kelass.data"
                                v-model="row.kelas"
                                @search="SearchKelas"
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
                        </td>
                        <td>
                            <button class="btn btn-danger btn-flat" @click="removeGuru(index)"><i class="fa fa-trash"></i></button>
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
    name: 'FormJamMengajar',
    data() {
        return {
            isForm: false,
            isSuccess: false,
            jammengajars: {
                mengajar: [
                    { mapel: null, kelas: null }
                ],               
            }
        }
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('jammengajar', {
            jammengajar: state => state.jammengajar,
            kelass: state => state.kelas,
            mapels: state => state.mapel,
            gurus: state => state.guru
        }),
        filterKelas() {
            return _.filter(this.jammengajar.mengajar, function(item) {
                return item.kelas == null
            })
        },
    },
    methods: {
        ...mapMutations('jammengajar', ['CLEAR_FORM']), 
        ...mapActions('jammengajar', ['getKelas','getMapel','getGuru']),
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
        SearchGuru(search, loading) {
            this.getGuru({
                search: search,
                loading: loading
            })
        },
        addKelas() {
            if (this.filterKelas.length == 0) {
                this.jammengajar.mengajar.push({ mapel_id: null, kelas_id: null, mapel: null, kelas: null})
            }
        },
        removeKelas(index) {
            if (this.jammengajar.mengajar.length > 0) {
                this.jammengajar.mengajar.splice(index, 1)
            }
        },
    },
    destroyed() {
        this.CLEAR_FORM()
    },
    components: {
        vSelect
    }
}
</script>