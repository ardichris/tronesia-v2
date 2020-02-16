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
        </div>
        <div class="col-md-6" v-if="$route.name == 'kelas.edit'">
            <b-table striped hover bordered :items="anggota.data" :fields="fields" show-empty>
                <template v-slot:cell(actions)="row">
                    <button class="btn btn-danger btn-sm" @click="deleteSiswa(row.item.id,kelas.kelas_nama)"><i class="fa fa-trash"></i></button>
                </template>
            </b-table>
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
            search: ''
        }
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('kelas', {
            anggota: state=>state.anggotas,
            kelas: state => state.kelas, 
            teachers: state => state.teachers
        })
    },
    methods: {
        ...mapActions('kelas', ['getTeacher','getSiswa','removeAnggota','anggotaKelas']),
        ...mapMutations('kelas', ['CLEAR_FORM']), //PANGGIL MUTATIONS CLEAR_FORM
        onSearch(search, loading) {
            //KITA AKAN ME-REQUEST DATA CUSTOMER BERDASARKAN KEYWORD YG DIMINTA
            this.getTeacher({
                search: search,
                loading: loading
            })
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
        }
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