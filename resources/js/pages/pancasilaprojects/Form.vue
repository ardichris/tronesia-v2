<template>
    <div class>
        <div class="row" style="margin-top:10px" v-if="mode=='add'">
            <div class="col-lg-2">
                <label for="">Kelas</label><i style="color: red">*</i>
            </div>
            <div class="col-lg-10">
                <div class="row">
                    <template v-for="(row, index) in kelas">
                        <div class="col-lg-2" :key="index">
                            <input type="checkbox"
                                class="minimal-red"
                                :value="row"
                                v-model="pancasilaproject.pp_class"
                                :checked="pancasilaproject.pp_class"
                                > {{ row.kelas_nama }}
                        </div>

                    </template>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:10px">
            <div class="col-lg-2">
                <label for="">Tema</label><i style="color: red">*</i>
            </div>
            <div class="col-lg-10">
                <select type="text" class="form-control" aria-invalid="false" v-model="pancasilaproject.pp_theme">
                    <option>Gaya Hidup Berkelanjutan</option>
                    <option>Kearifan Lokal</option>
                    <option>Bhinneka Tunggal Ika</option>
                    <option>Bangunlah Jiwa dan Raganya</option>
                    <option>Suara Demokrasi</option>
                    <option>Rekayasa dan Teknologi</option>
                    <option>Kewirausahaan</option>
                    <option>Kebekerjaan</option>
                </select>
            </div>
        </div>
        <div class="row" style="margin-top:10px">
            <div class="col-lg-2">
                <label for="">Nama</label><i style="color: red">*</i>
            </div>
            <div class="col-lg-10">
                <input type="text" class="form-control" aria-invalid="false" v-model="pancasilaproject.pp_name">
            </div>
        </div>

        <div class="row" style="margin-top:10px">
            <div class="col-lg-2">
                <label for="">Deskripsi</label><i style="color: red">*</i>
            </div>
            <div class="col-lg-10">
                <textarea class="form-control" v-model="pancasilaproject.pp_desc"></textarea>
            </div>
        </div>
        <div class="row" style="margin-top:10px">
            <div class="col-lg-2">
                <label for="">Elemen</label><i style="color: red">*</i>
                <button class="btn btn-warning btn-sm" style="margin-bottom: 10px" @click="addPE">Tambah</button>
            </div>
            <div class="col-lg-10">
                <div class="table-responsive" style="height: 900px">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th width="95%">Dimensi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <!-- TABLE INI BERGUNA UNTUK MENAMBAHKAN ITEM TRANSAKSI -->
                        <tbody>
                            <tr v-for="(row, index) in pancasilaproject.pp_element" :key="index">
                                <td>
                                    <v-select :options="pancasilaelement"
                                        v-model="row.element"
                                        label="pe_element"
                                        placeholder="Masukkan Kata Kunci"
                                        :filterable="false">
                                        <template slot="no-options">
                                            Masukkan Kata Kunci
                                        </template>
                                        <template slot="option" slot-scope="option">
                                            [{{ option.pe_dimension }}] [{{ option.pe_element }}] <br> {{option.pe_subelement}}
                                        </template>
                                        <template slot="selected-option" slot-scope="option">
                                            [{{ option.pe_element }}] [{{ option.pe_dimension }}] <br> {{option.pe_subelement}}
                                        </template>
                                    </v-select>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-flat" @click="removePE(index)"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'

export default {
    name: 'FormPancasilaProject',
    data() {
        return {
            pancasilaelements: [
                {}
            ]
        }
    },
    created(){
        this.getKelas();
        this.getPancasilaElement();
    },
    computed: {
        ...mapState('pancasilaproject', {
            pancasilaproject: state => state.pancasilaproject,
            kelas: state => state.kelas,
            pancasilaelement: state => state.pancasilaelement,
            mode: state => state.mode
        }),
        filterPE() {
            return _.filter(this.pancasilaproject.pp_element, function(item) {
                return item == null
            })
        },
    },
    methods: {
        ...mapActions('pancasilaproject', ['getKelas', 'getPancasilaElement']),
        ...mapMutations('pancasilaproject', ['CLEAR_FORM']),
        addKelas(name) {
                //DICEK KE NEW_PERMISSION BERDASARKAN NAME
                let index = this.pancasilaproject.class.findIndex(x => x == kelas_nama)
                //APABIL TIDAK TERSEDIA, INDEXNYA -1
                if (index == -1) {
                    //MAKA TAMBAHKAN KE LIST
                    this.pancasilaproject.class.push(name)
                } else {
                    //JIKA SUDAH ADA, MAKA HAPUS DARI LIST
                    this.pancasilaproject.class.splice(index, 1)
                }
            },
        addPE() {
            if (this.filterPE.length == 0) {
                this.pancasilaproject.pp_element.push({})
            }
        },
        //KETIKA TOMBOL HAPUS PADA MASING-MASING ITEM DITEKAN, MAKA AKAN MENGHAPUS BERDASARKAN INDEX DATANYA
        removePE(index) {
            if (this.pancasilaproject.pp_element.length > 0) {
                this.pancasilaproject.pp_element.splice(index, 1)
            }
        },
    },
    destroyed(){
        this.CLEAR_FORM()
    },
    components: {
        vSelect
    }
}
</script>
