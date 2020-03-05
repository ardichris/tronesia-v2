<template>
    <div class="d-block">
        <div class="form-group" :class="{ 'has-error': errors.siswa_id }">
            <label for="">Nama Siswa</label>
            <v-select :options="siswas.data"
                v-model="seragam.siswa_id"
                @search="onSearchSiswa" 
                label="siswa_nama"
                placeholder="Masukkan Kata Kunci" 
                :disabled="$route.name == 'seragams.view'"
                :filterable="false">
                <template slot="no-options">
                    Masukkan Kata Kunci
                </template>
                <template slot="option" slot-scope="option">
                    {{ option.siswa_nama }} - {{ option.siswa_kelas }}
                </template>
            </v-select>
            <p class="text-danger" v-if="errors.siswa_id">Siswa belum dipilih</p>
        </div>
        <!--b-table :items="seragam.pemesanan" :fields="fields" show-empty responsive>
            <template v-slot:cell(barang)="row">
                <v-select :options="barangs.data"
                    v-model="row.item.barang"
                    @search="onSearchBarang" 
                    label="barang_nama"
                    placeholder="Masukkan Kata Kunci" 
                    :filterable="false">
                    <template slot="no-options">
                        Masukkan Kata Kunci
                    </template>
                    <template slot="option" slot-scope="option">
                        {{ option.barang_nama }} {{ option.b_varian }}
                    </template>
                </v-select>
            </template>
            <template v-slot:cell(jumlah)="row">
                <b-form-input type="number" v-model="row.item.jumlah"></b-form-input>
            </template>
            <template v-slot:cell(status)="row">
                <b-form-checkbox
                    v-model="row.item.status"
                    :checked="row.item.status && row.item.status.includes('Diterima')"
                    value="Diterima"
                    unchecked-value="Pesan">
                </b-form-checkbox>
            </template>
            <template v-slot:cell(tanggal)="row">
                <span class="label label-success">{{row.item.tanggal}}</span>
            </template>
            <template v-slot:cell(actions)="row">
                <button class="btn btn-danger btn-flat" @click="removeBarang(index)"><i class="fa fa-trash"></i></button>
            </template>
        </b-table-->

        
        <div class="table-responsive" style="height: 400px">
            <table class="table" >
                <thead>
                    <tr>
                        <th width="50%">Nama Barang</th>
                        <th width="10%">Ukuran</th>
                        <th width="10%">Qty</th>
                        <th width="10%">#</th>
                        <th width="30%">Diterima</th>
                        <th> <button class="btn btn-warning btn-sm float-right" @click="addBarang">Tambah</button></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in seragam.pemesanan" :key="index">
                        <td>
                            <v-select :options="barangs.data"
                                v-model="row.barang"
                                @search="onSearchBarang" 
                                label="barang_nama"
                                placeholder="Masukkan Kata Kunci" 
                                :filterable="false">
                                <template slot="no-options">
                                    Masukkan Kata Kunci
                                </template>
                                <template slot="option" slot-scope="option">
                                    {{ option.barang_nama }} {{ option.b_varian }}
                                </template>
                            </v-select>
                        </td>
                        <td>
                            <h3><span class="badge badge-warning" v-if="row.barang!=null"><b>{{row.barang.b_varian}}</b></span></h3>
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="row.jumlah">
                        </td>
                        <td>
                            <b-form-checkbox
                                v-model="row.status"
                                :checked="row.status && row.status.includes('Diterima')"
                                value="Diterima"
                                unchecked-value="Pesan">
                            </b-form-checkbox>
                            <!--span class="badge badge-danger" v-else>Perempuan</span-->
                        </td>
                        <td>
                            <h5><span class="badge badge-success">{{row.diterima}}</span></h5>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-flat" @click="removeBarang(index)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>        
        <!--div class="form-group" :class="{ 'has-error': errors.s_tanggal }">
            <label for="">Tanggal Pengambilan</label>
            <input type="date" class="form-control" v-model="seragam.s_tanggal" :readonly="$route.name == 'seragam.edit' || $route.name == 'seragam.view'">
            <p class="text-danger" v-if="errors.s_tanggal">Tanggal belum dipilih</p>
        </div-->    
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
import _ from 'lodash'
export default {
    name: 'FormSeragam',
    data() {
        return {
            fields: [
                { key: 'barang', label: 'Barang'},
                { key: 'ukuran', label: 'Ukuran' },
                { key: 'jumlah', label: 'Jumlah' },
                { key: 'status', label: '#' },
                { key: 'tanggal', label: 'Tgl Terima' },
                { key: 'actions', label: 'Aksi' }
            ],
            isForm: false,
            isSuccess: false,
            seragams: {
                pemesanan: [
                    { barang: null, jumlah: null, tanggal: null, status: null }
                ]
            }
        }
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('seragam', {
            seragam: state => state.seragam,
            barangs: state => state.barang,
            siswas: state => state.siswa
        }),
        filterBarang() {
            return _.filter(this.seragam.pemesanan, function(item) {
                return item.barang == null
            })
        },
    },
    methods: {
        ...mapMutations('seragam', ['CLEAR_FORM']),
        ...mapActions('seragam', ['getBarang','getSiswa']),
        addBarang(){
            if (this.filterBarang.length == 0) {
                this.seragam.pemesanan.push({ barang_id: null, jumlah: null, barang: null, tanggal: null, status: null})
            }
        },
        removeBarang(index) {
            if (this.seragam.pemesanan.length > 0) {
                this.seragam.pemesanan.splice(index, 1)
            }
        },
        onSearchSiswa(search, loading) {
            this.getSiswa({
                search: search,
                loading: loading
            })            
        },
        onSearchBarang(search, loading) {
            this.getBarang({
                search: search,
                loading: loading
            })            
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