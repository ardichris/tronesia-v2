<template>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': errors.kelas_nama }">
                <label for="">Nama Kelas</label>
                <input type="text" class="form-control" v-model="kelas.kelas_nama" :readonly="$route.name == 'kelas.edit' || $route.name == 'kelas.view'">
                <p class="text-danger" v-if="errors.kelas_nama">{{ errors.kelas_nama[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.kelas_jenjang }">
                <label for="">Jenjang</label>
                <v-select :options="['7', '8', '9', '10', '11', '12']"
                            v-model="kelas.kelas_jenjang"                      
                            :value="kelas.kelas_jenjang"
                            >
                </v-select>
                <p class="text-danger" v-if="errors.kelas_jenjang">{{ errors.kelas_jenjang[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.kelas_wali }">
                <label for="">Wali Kelas</label>
                <v-select :options="teachers.data"
                    v-model="kelas.kelas_wali"
                    @search="onSearch" 
                    label="name"
                    placeholder="Masukkan Kata Kunci" 
                    :disabled="$route.name == 'kelas.view'"
                    :filterable="false">
                    <template slot="no-options">
                        Masukkan Kata Kunci
                    </template>
                    <template slot="option" slot-scope="option">
                        {{ option.name }}
                    </template>
                </v-select>
                <p class="text-danger" v-if="errors.kelas_wali">{{ errors.kelas_wali[0] }}</p>
            </div>
            <div class="form-group">
                <label for="">Tambah Anggota</label>
                <v-select :options="siswas.data"
                    v-model="kelas.tambah"
                    @search="onSearchSiswa" 
                    label="siswa_nama"
                    placeholder="Masukkan Kata Kunci" 
                    :filterable="false">
                    <template slot="no-options">
                        Masukkan Kata Kunci
                    </template>
                    <template slot="option" slot-scope="option">
                        {{ option.siswa_nis }} - {{ option.siswa_nama }}
                    </template>
                </v-select>
                <span><button class="btn btn-warning btn-sm float-right" style="margin-bottom: 10px" @click="addAnggota" :disabled="authenticated.role != 0">Tambah</button></span>
            </div>
            
        </div>
        <div class="col-md-6" v-if="$route.name == 'kelas.edit'">
            <label for="">Daftar Siswa</label>
            <button class="btn btn-warning btn-sm float-right" style="margin-bottom: 10px" @click="addSiswa" :disabled="authenticated.role != 0">Tambah</button>
            <div class="table-responsive" style="height: 600px">
                <table class="table" >
                    <thead>
                    </thead>
                    <!-- TABLE INI BERGUNA UNTUK MENAMBAHKAN ITEM TRANSAKSI -->
                    <tbody>
                        <tr v-for="(row, index) in anggota.data" :key="index">
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
                                        {{ option.siswa_nis }} - {{ option.siswa_nama }}
                                    </template>
                                </v-select>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-flat" @click="removeSiswa(index)" :disabled="authenticated.role != 0"><i class="fa fa-trash"></i></button>
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
export default {
    name: 'FormKelas',
    created(){
        this.anggotaKelas(this.$route.params.id)
    },

    data() {
        return {
            fields: [
                { key: 'siswa_nis', label: 'NIS' },
                { key: 'siswa_nama', label: 'Nama Siswa' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: '',
            anggotas: [
                    { siswa: null }
            ]
        }
    },
    computed: {
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        ...mapState(['errors']),
        ...mapState('kelas', {
            siswas: state => state.siswa,
            anggota: state=>state.anggotas,
            kelas: state => state.kelas, 
            teachers: state => state.teachers,
            tambah: state=> state.tambah
        }),
        filterSiswa() {
            return _.filter(this.kelas.anggota, function(item) {
                return item.siswa == null
            })
        },
    },
    methods: {
        ...mapActions('kelas', ['getTeacher','getSiswa','removeAnggota','anggotaKelas','tambahAnggota']),
        ...mapMutations('kelas', ['CLEAR_FORM']), //PANGGIL MUTATIONS CLEAR_FORM
        onSearch(search, loading) {
            //KITA AKAN ME-REQUEST DATA CUSTOMER BERDASARKAN KEYWORD YG DIMINTA
            this.getTeacher({
                search: search,
                loading: loading
            })
        },
        onSearchSiswa(search, loading) {
            this.getSiswa({
                search: search,
                kelas: this.$route.params.id,
                key: 'addAnggotaKelas',
                loading: loading
            })            
        },
        addSiswa() {
            if (this.filterSiswa.length == 0) {
                this.anggotakelas.push({ siswa_id: null, siswa_nama: null})
            }
        },
        //KETIKA TOMBOL HAPUS PADA MASING-MASING ITEM DITEKAN, MAKA AKAN MENGHAPUS BERDASARKAN INDEX DATANYA
        removeSiswa(index) {
            if (this.anggotakelas.length > 0) {
                this.anggotakelas.splice(index, 1)
            }
        },
        deleteSiswa(id,kelas) {
            //AKAN MENAMPILKAN JENDELA KONFIRMASI
            this.$swal({
                title: 'Kamu Yakin?',
                text: "Tindakan ini akan menghapus secara permanent!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, Lanjutkan!'
            }).then((result) => {
                //JIKA DISETUJUI
                if (result.value) {
                    //MAKA FUNGSI removeSiswa AKAN DIJALANKAN
                    this.removeAnggota(id).then(()=>{ this.anggotaKelas(this.$route.params.id) });
                }
            })
        },
        addAnggota(){
            this.tambahAnggota({
                siswa: this.kelas.tambah.id,
                kelas: this.$route.params.id,
                key: 'tambahAnggotaKelas',
            }).then(()=>{ this.anggotaKelas(this.$route.params.id) });
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