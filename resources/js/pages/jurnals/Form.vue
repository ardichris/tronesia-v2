<template>
    <div class="row">
        <div class="alert alert-danger alert-dismissible col-md-12" v-if="jurnal.jm_catatan!=null && jurnal.jm_catatan!=''">
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            {{jurnal.jm_catatan}}
        </div>
    <div class="col-md-6">
        <div class="form-group" :class="{ 'has-error': errors.jm_tanggal }">
            <label for="">Tanggal</label>
            <input type="date" class="form-control" v-model="jurnal.jm_tanggal" :readonly="jurnal.jm_status == 1 && authenticated.role != 0">
            <p class="text-danger" v-if="errors.jm_tanggal">Tanggal jurnal wajib diisi</p>
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
                :disabled="jurnal.jm_status == 1 && authenticated.role != 0"
                :filterable="false">
                <template slot="no-options">
                    Masukkan Kata Kunci
                </template>
                <template slot="option" slot-scope="option">
                    {{ option.mapel_kode }} - {{ option.mapel_nama }}
                </template>
            </v-select>
            <p class="text-danger" v-if="errors.mapel_id">Mata pelajaran wajib diisi</p>
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
                :disabled="jurnal.jm_status == 1 && authenticated.role != 0"
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
            <!--input type="text" class="form-control" v-model="jurnal.jm_jampel" :readonly="jurnal.jm_status == 1 && authenticated.role != 0" v-if="$route.name == 'jurnal.edit'"-->       
            <v-select :options="[0,1,2,3,4,5,6,7,8,9]"
                v-model="jurnal.jm_jampel"
                :disabled="jurnal.jm_status == 1 && authenticated.role != 0"
                :multiple="$route.name == 'jurnal.add'"
                :value="jurnal.jm_jampel">
            </v-select>
            <p class="text-danger" v-if="errors.jm_jampel">Jam pelajaran wajib diisi</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.kompetensi_id }">
            <label for="">Kompetensi Dasar</label>
            <v-select :options="kompetensis.data"
                v-model="jurnal.kompetensi_id"
                @search="setSelected"
                label="kd_kode"
                placeholder="Masukkan Kata Kunci" 
                :disabled="jurnal.jm_status == 1 && authenticated.role != 0"
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
            <textarea cols="6" rows="5" class="form-control" v-model="jurnal.jm_materi" :readonly="jurnal.jm_status == 1 && authenticated.role != 0"></textarea>
            <p class="text-danger" v-if="errors.jm_materi">Materi mengajar wajib diisi</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.jm_keterangan }">
            <label for="">Catatan</label>
            <textarea cols="6" rows="5" class="form-control" v-model="jurnal.jm_keterangan" :readonly="jurnal.jm_status == 1 && authenticated.role != 0"></textarea>
            <p class="text-danger" v-if="errors.jm_keterangan">Catatan mengajar wajib diisi</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.jm_media }">
            <label for="">Media</label>
            <div class="input-group">
                <input type="text" class="form-control" v-model="jurnal.jm_media" :readonly="jurnal.jm_status == 1 && authenticated.role != 0">
                <div class="input-group-append" v-if="jurnal.jm_media">
                    <button class="btn btn-success btn-flat" @click="mediaClick"><i class="fa fa-eye"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <label for="">PRESENSI KEHADIRAN</label><br>
        <button class="btn btn-warning btn-sm float-right" style="margin-bottom: 10px" @click="addSiswa" :disabled="jurnal.jm_status == 1 && authenticated.role != 0">Tambah</button>
        <div class="table-responsive" style="height: 300px">
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
                                label="s_nama"
                                placeholder="Masukkan Kata Kunci" 
                                :filterable="false">
                                <template slot="no-options">
                                    Masukkan Kata Kunci
                                </template>
                                <template slot="option" slot-scope="option">
                                    {{ option.s_nama }}
                                </template>
                            </v-select>
                        </td>
                        <td>
                            <v-select :options="['Sakit', 'Alpha', 'Kegiatan Sekolah', 'Urusan Pribadi', 'Kendala Teknis']"
                                v-model="row.alasan"
                                :value="row.alasan"
                                >
                            </v-select>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-flat" @click="removeSiswa(index)" :disabled="jurnal.jm_status == 1 && authenticated.role != 0"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <label for="">PELANGGARAN SISWA</label><br>
        <button class="btn btn-warning btn-sm float-right" style="margin-bottom: 10px" @click="addPelanggaran" :disabled="jurnal.jm_status == 1 && authenticated.role != 0">Tambah</button>
        <div class="table-responsive" style="height: 300px">
            <table class="table" >
                <thead>
                    <tr>
                        <th width="35%">Nama Siswa</th>
                        <th width="35%">Pelanggaran</th>
                        <th width="25%">Keterangan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in jurnal.pelanggaran" :key="index">
                        <td>
                            <v-select :options="siswas.data"
                                v-model="row.siswa"
                                @search="onSearchSiswa" 
                                label="s_nama"
                                placeholder="Masukkan Kata Kunci" 
                                :filterable="false">
                                <template slot="no-options">
                                    Masukkan Kata Kunci
                                </template>
                                <template slot="option" slot-scope="option">
                                    {{ option.s_nama }}
                                </template>
                            </v-select>
                        </td>
                        <td>
                            <v-select :options="['Terlambat', 'Escape', 'Atribut', 'Seragam', 'Sepatu', 'Kaos Kaki', 'Rambut', 'Berkelahi', 'Bermain Game', 'Mendengarkan Musik', 'Berkata Kotor']"
                                v-model="row.pelanggaran_jenis"
                                :value="row.pelanggaran_jenis"
                                >
                            </v-select>
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="row.pelanggaran_keterangan" >
                        </td>
                        <td>
                            <button class="btn btn-danger btn-flat" @click="removePelanggaran(index)" :disabled="jurnal.jm_status == 1 && authenticated.role != 0"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--div>
            <b-tabs card>
                <b-tab title="Kompetensi" active>
                    
                </b-tab>
                <b-tab title="Presensi">
                    
                </b-tab>
                <b-tab title="Pelanggaran">
                    
                </b-tab>
            </b-tabs>
        </div-->
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
            mapels: state => state.mapel,
            siswas: state => state.siswa,
            kelass: state => state.kelas,
            kompetensis: state => state.kompetensi,
            jurnal: state => state.jurnal 
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
        ...mapActions('jurnal',['getMapel','getKelas','getKompetensi', 'getSiswa']),
        ...mapMutations('jurnal', ['CLEAR_FORM']), //PANGGIL MUTATIONS CLEAR_FORM
        mediaClick(){
            window.open(this.jurnal.jm_media, "_blank");
        },
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
        addPelanggaran() {
            if (this.filterPelanggaran.length == 0) {
                this.jurnal.pelanggaran.push({ siswa_id: null, pelanggaran_jenis: null, siswa: null})
            }
        },
        //KETIKA TOMBOL HAPUS PADA MASING-MASING ITEM DITEKAN, MAKA AKAN MENGHAPUS BERDASARKAN INDEX DATANYA
        removePelanggaran(index) {
            if (this.jurnal.pelanggaran.length > 0) {
                this.jurnal.pelanggaran.splice(index, 1)
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