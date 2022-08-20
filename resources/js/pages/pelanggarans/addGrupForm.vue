<template>
    <div class>
        <div class="form-group col-sm-4">
            <label for="">Tanggal</label>
            <input type="date" class="form-control" v-model="pelanggaran.pelanggaran_tanggal">
        </div>
        <button class="btn btn-warning btn-sm float-right" style="margin-bottom: 10px" @click="addPelanggar">Tambah</button>
        <div class="table-responsive" style="height: 400px">
            <table class="table" >
                <thead>
                    <tr>
                        <th width="15%">Kelas</th>
                        <th width="50%">Nama Siswa</th>
                        <th width="30%">Pelanggaran</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in pelanggaran.pelanggar" :key="index">
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
                                v-on:input="setSiswa(index)"
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
                            <div class="badge badge-danger float-right" v-if="row.total!=''">Total pelanggaran : {{row.total}}</div>
                        </td>
                        <td>
                            <v-select :options="MPs.data"
                                v-model="row.mp_id"
                                @search="onSearchMP"
                                label="mp_pelanggaran"
                                placeholder="Masukkan Kata Kunci"
                                :disabled="$route.name == 'pelanggarans.view'"
                                :filterable="false">
                                <template slot="no-options">
                                    Masukkan Kata Kunci
                                </template>
                                <template slot="option" slot-scope="option">
                                    {{ option.mp_pelanggaran }}
                                    <span class="badge badge-danger float-right" v-if="option.total>0">{{option.total}}</span>
                                </template>
                            </v-select>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-flat" @click="removePelanggar(index)"><i class="fa fa-trash"></i></button>
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
    name: 'DataPelanggaran',
    created() {
        this.getPelanggarans()
        this.getKelas()
        this.getMP({
            cat: 'Ringan',

        })
    },
    data() {
        return {
            fields: [
                { key: 'guru', label: 'Guru', sortable: true },
                { key: 'siswa_id', label: 'Nama Siswa', sortable: true },
                { key: 'pelanggaran', label: 'Pelanggaran' },
                { key: 'pelanggaran_keterangan', label: 'Keterangan' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: '',
            kelas: '',

        }
    },
    computed: {
        ...mapState('pelanggaran', {
            pelanggarans: state => state.pelanggarans,
            pelanggaran: state=> state.pelanggaran,
            siswas: state => state.siswas,
            MPs: state => state.MPs,
            kelasdata: state => state.kelas,

        }),
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        page: {
            get() {
                return this.$store.state.pelanggaran.page
            },
            set(val) {
                this.$store.commit('pelanggaran/SET_PAGE', val)
            }
        },
        filterPelanggar() {
            return _.filter(this.pelanggaran.pelanggar, function(item) {
                return item.siswa == null
            })
        },
    },
    watch: {
        page() {
            this.getPelanggarans()
        },
        search() {
            this.getPelanggarans(this.search)
        }
    },
    methods: {
        ...mapActions('pelanggaran', ['getMP','getMPs','getSiswaKelas','getSiswas','getPelanggarans','getKelas','getTotalGrup']),
        ...mapMutations('pelanggaran', ['CLEAR_FORM']),
        setSiswa(index){
            this.pelanggaran.siswa_id = this.pelanggaran.pelanggar[index]['siswa']
            this.getTotalGrup({
                index: index,
            }).then(() => {
                this.pelanggaran.pelanggar[index]['total'] = this.pelanggaran.p_jumlah
            })
        },
        onSearchPelanggaran(index, siswa, mp) {
            this.getTotalGrup({
                index: index,
                siswa: siswa,
                mp: mp
            }).then(() => {
                this.pelanggaran.pelanggar[index]['total'] = this.pelanggaran.p_jumlah
            })
        },
        cariSiswa(kelas){
            this.getSiswaKelas({
                kelas: kelas
            })
        },
        removePelanggar(index) {
            if (this.pelanggaran.pelanggar.length > 0) {
                this.pelanggaran.pelanggar.splice(index, 1)
            }
        },
        addPelanggar() {
            if (this.filterPelanggar.length == 0) {
                this.pelanggaran.pelanggar.push({ mp_id: null, siswa: null, total: ''})
            }
        },
        onSearch(search, loading) {
            this.getSiswas({
                search: search,
                loading: loading
            })
        },
        onSearchMP(search, loading ) {
            this.getMPs({
                search: search,
                loading: loading
            })
        },

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
