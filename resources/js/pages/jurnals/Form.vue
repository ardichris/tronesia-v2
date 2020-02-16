<template>
    <div class="row">
    <div class="col-md-6">
        <div class="form-group" :class="{ 'has-error': errors.jm_tanggal }">
            <label for="">Tanggal</label>
            <input type="date" class="form-control" v-model="jurnal.jm_tanggal" :readonly="$route.name == 'jurnal.view'">
            <p class="text-danger" v-if="errors.jm_tanggal">{{ errors.jm_tanggal[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.mapel_id }">
            <label for="">Mata Pelajaran</label>
            <v-select :options="mapels.data"
                v-model="jurnal.mapel_id"
                @search="onSearch"
                @change="setSelected"
                :value="$store.myValue"
                label="mapel_kode"
                placeholder="Masukkan Kata Kunci" 
                :disabled="$route.name == 'jurnal.view'"
                :filterable="false">
                <template slot="no-options">
                    Masukkan Kata Kunci
                </template>
                <template slot="option" slot-scope="option">
                    {{ option.mapel_kode }} - {{ option.mapel_nama }}
                </template>
            </v-select>
            <p class="text-danger" v-if="errors.mapel_id">{{ errors.mapel_id[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.kelas_id }">
            <label for="">Kelas</label>
            <v-select :options="kelass.data"
                v-model="jurnal.kelas_id"
                @search="onSearchh"
                :value="$store.myValue"
                @change="setSelected"
                label="kelas_nama"
                placeholder="Masukkan Kata Kunci" 
                :disabled="$route.name == 'jurnal.view'"
                :filterable="false">
                <template slot="no-options">
                    Masukkan Kata Kunci
                </template>
                <template slot="option" slot-scope="option">
                    {{ option.kelas_nama }}
                </template>
            </v-select>
            <p class="text-danger" v-if="errors.kelas_id">{{ errors.kelas_id[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.jm_jampel }">
            <label for="">Jam Pelajaran</label>
            <!--input type="text" class="form-control" v-model="jurnal.jm_jampel" :readonly="$route.name == 'jurnal.view'" v-if="$route.name == 'jurnal.edit'"-->
            <p class="text-danger" v-if="errors.jm_jampel">{{ errors.jm_jampel[0] }}</p>          
            <v-select :options="[1,2,3,4,5,6,7,8,9]"
                v-model="jurnal.jm_jampel"
                :multiple="$route.name == 'jurnal.add'"
                :value="jurnal.jm_jampel">
            </v-select>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.kompetensi_id }">
            <label for="">Kompetensi Dasar</label>
            <v-select :options="kompetensis.data"
                v-model="jurnal.kompetensi_id"
                @search="setSelected"
                label="kd_kode"
                placeholder="Masukkan Kata Kunci" 
                :disabled="$route.name == 'jurnal.view'"
                :filterable="false">
                <template slot="no-options">
                    Masukkan Kata Kunci
                </template>
                <template slot="option" slot-scope="option">
                    {{ option.kd_kode }}
                </template>
            </v-select>
        </div>
        <div class="form-group" v-if="jurnal.kompetensi_id!=null">
            <label for="">Deskripsi</label>
             <textarea cols="6" rows="5" class="form-control" v-model="jurnal.kompetensi_id.kompetensi_deskripsi" :readonly="true"></textarea-->
        </div>
        <div class="form-group" :class="{ 'has-error': errors.jm_materi }">
            <label for="">Materi Mengajar</label>
            <textarea cols="6" rows="5" class="form-control" v-model="jurnal.jm_materi" :readonly="$route.name == 'jurnal.view'"></textarea>
            <p class="text-danger" v-if="errors.jm_materi">{{ errors.jm_materi[0] }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="alert alert-danger alert-dismissible" v-if="jurnal.jm_catatan!=null && jurnal.jm_catatan!=''">
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            {{jurnal.jm_catatan}}
        </div>
        <label for="">Siswa Tidak Hadir</label><br>
        <button class="btn btn-warning btn-sm float-right" style="margin-bottom: 10px" @click="addSiswa">Tambah</button>
        <div class="table-responsive" style="height: 600px">
            <table class="table" >
                <thead>
                    <tr>
                        <th width="45%">Nama Siswa</th>
                        <th width="50%">Alasan</th>
                        <th></th>
                    </tr>
                </thead>
                <!-- TABLE INI BERGUNA UNTUK MENAMBAHKAN ITEM TRANSAKSI -->
                <tbody>
                    <tr v-for="(row, index) in jurnal.detail" :key="index">
                        <td>
                            <v-select :options="siswas.data"
                                v-model="row.siswa"
                                @search="onSearchSiswa" 
                                label="siswa_nama"
                                placeholder="Masukkan Kata Kunci" 
                                :filterable="false">
                                <template slot="no-options">
                                    Masukkan Kata Kunci
                                </template>
                                <template slot="option" slot-scope="option">
                                    {{ option.siswa_nama }}
                                </template>
                            </v-select>
                        </td>
                        <td>
                            <v-select :options="['Sakit', 'Alpha', 'Kegiatan Sekolah', 'Urusan Pribadi']"
                                v-model="row.alasan"
                                :value="row.alasan"
                                >
                            </v-select>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-flat" @click="removeSiswa(index)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
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
                ]
            }
        }
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('jurnal', {
            mapels: state => state.mapel,
            siswas: state => state.siswa,
            kelass: state => state.kelas,
            kompetensis: state => state.kompetensi,
            jurnal: state => state.jurnal 
        }),
        filterSiswa() {
            return _.filter(this.jurnal.detail, function(item) {
                return item.siswa == null
            })
        },
    },
    methods: {
        ...mapActions('jurnal',['getMapel','getKelas','getKompetensi', 'getSiswa']),
        ...mapMutations('jurnal', ['CLEAR_FORM']), //PANGGIL MUTATIONS CLEAR_FORM
        setSelected(value){
            this.getKompetensi()
        },
        onSearch(search, loading) {
            this.getMapel({
                search: search,
                loading: loading
            })
        },
        onSearchh(search, loading) {
            this.getKelas({
                search: search,
                loading: loading
            })            
        },
        onSearchSiswa(search, loading) {
            this.getSiswa({
                search: search,
                loading: loading
            })            
        },
        addSiswa() {
            if (this.filterSiswa.length == 0) {
                this.jurnal.detail.push({ siswa_id: null, alasan: null, siswa: null})
            }
        },
        //KETIKA TOMBOL HAPUS PADA MASING-MASING ITEM DITEKAN, MAKA AKAN MENGHAPUS BERDASARKAN INDEX DATANYA
        removeSiswa(index) {
            if (this.jurnal.detail.length > 0) {
                this.jurnal.detail.splice(index, 1)
            }
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