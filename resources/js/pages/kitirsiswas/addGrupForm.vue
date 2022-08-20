<template>
    <div class>
        <div class="form-group col-sm-6">
            <label for="">Tanggal</label>
            <input type="date" class="form-control" v-model="kitir.ks_tanggal">
        </div>
        <div class="row">
            <div class="form-group col-sm-6" :class="{ 'has-error': errors.ks_jenis }">
                    <label for="">Jenis Kitir</label>
                    <v-select :options="['Masuk Kelas', 'Keluar Kelas', 'Pulang Sekolah']"
                                v-model="kitir.ks_jenis"
                                :disabled="$route.name == 'kitir.view'"
                                :value="kitir.ks_jenis"
                                >
                    </v-select>
                    <p class="text-danger" v-if="errors.ks_jenis">Kitir belum dipilih</p>
                </div>
            <div class="form-group col-sm-3">
                <label for="">Mulai</label>
                <v-select :options="['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']"
                            v-model="kitir.ks_start"
                            :disabled="$route.name == 'kitir.view'"
                            :value="kitir.ks_start"
                            >
                </v-select>
            </div>
            <div class="form-group col-sm-3">
                <label for="">Selesai</label>
                <v-select :options="['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']"
                            v-model="kitir.ks_end"
                            :disabled="$route.name == 'kitir.view'"
                            :value="kitir.ks_end"
                            >
                </v-select>
            </div>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.ks_keterangan }">
            <label for="">Keterangan</label>
            <input type="text" class="form-control" v-model="kitir.ks_keterangan" :readonly="$route.name == 'kitir.view'">
            <p class="text-danger" v-if="errors.ks_keterangan">Keterangan wajib diisi</p>
        </div>
        <button class="btn btn-warning btn-sm float-right" style="margin-bottom: 10px" @click="addSiswa">Tambah</button>
        <div class="table-responsive" style="height: 400px">
            <table class="table" >
                <thead>
                    <tr>
                        <th width="25%">Kelas</th>
                        <th width="65%">Nama Siswa</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in kitir.siswa" :key="index">
                        <td>
                            <b-form-select
                                v-model="row.kelas"
                                size="sm"
                                :options="kelasdata.data"
                                @change="cariSiswa(row.kelas)"
                                >
                            </b-form-select>
                        </td>
                        <td>
                                <v-select :options="siswas.data"
                                v-model="row.siswa"
                                @search="onSearch"
                                label="s_nama"
                                placeholder="Masukkan Kata Kunci"
                                :filterable="false">
                                <template slot="no-options">
                                    Masukkan Kata Kunci
                                </template>
                                <template slot="option" slot-scope="option">
                                    ({{ option.kelas }}/{{option.absen}}) {{ option.s_nama }}
                                </template>
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
</template>

<script>
import { mapActions, mapState, mapMutations } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'

export default {
    name: 'DataKitir',
    created() {
        this.getKelas()
    },
    data() {
        return {
            search: '',
            kelas: '',

        }
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('kitirsiswa', {
            siswas: state => state.siswas,
            kitir: state => state.kitir,
            kelasdata: state => state.kelas,

        }),
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        filterSiswa() {
            return _.filter(this.kitir.siswa, function(item) {
                return item.siswa == null
            })
        },
    },
    methods: {
        ...mapActions('kitirsiswa', ['getSiswaKelas','getSiswas','getKelas','getTotalGrup']),
        ...mapMutations('kitirsiswa', ['CLEAR_FORM']),
        setSiswa(index){
            this.kitir.siswa_id = this.kitir.siswa[index]['siswa']
            this.getTotalGrup({
                index: index,
            }).then(() => {
                this.kitir.siswa[index]['total'] = this.kitir.p_jumlah
            })
        },
        cariSiswa(kelas){
            this.getSiswaKelas({
                kelas: kelas
            })
        },
        removeSiswa(index) {
            if (this.kitir.siswa.length > 0) {
                this.kitir.siswa.splice(index, 1)
            }
        },
        addSiswa() {
            if (this.filterSiswa.length == 0) {
                this.kitir.siswa.push({siswa:null})
            }
        },
        onSearch(search, loading) {
            this.getSiswas({
                search: search,
                loading: loading
            })
        }

    },
    destroyed() {
            this.CLEAR_FORM(),
            this.$store.commit('CLEAR_ERRORS')
    },
    components: {
        vSelect
    }
}
</script>
