<template>
    <div class="col-md-12">
        <div class="form-group" :class="{ 'has-error': errors.kelas }">
            <label for="">Kelas</label>
            <v-select :options="kelass.data"
                v-model="jammengajar.kelas"
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
            <p class="text-danger" v-if="errors.kelas">{{ errors.kelas[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.mapel }">
            <label for="">Mapel</label>
            <v-select :options="mapels.data"
                v-model="jammengajar.mapel"
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
            <p class="text-danger" v-if="errors.mapel">{{ errors.mapel[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.guru }">
            <label for="">Guru</label>
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
                pengajar: [
                    { mapel: null, guru: null }
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
        filterGuru() {
            return _.filter(this.jammengajar.pengajar, function(item) {
                return item.guru == null
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
        addGuru() {
            if (this.filterGuru.length == 0) {
                this.jammengajar.pengajar.push({ mapel_id: null, guru_id: null, mapel: null, guru: null})
            }
        },
        removeGuru(index) {
            if (this.jammengajar.pengajar.length > 0) {
                this.jammengajar.pengajar.splice(index, 1)
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