<template>
    <div class="col-md-6">
        <div class="form-group" :class="{ 'has-error': errors.kompetensi_mapel }">
            <label for="">Mata Pelajaran</label>
            <v-select :options="mapels.data"
                v-model="kompetensi.kompetensi_mapel"
                @search="onSearch" 
                label="mapel_kode"
                placeholder="Masukkan Kata Kunci" 
                :disabled="$route.name == 'kompetensi.view'"
                :filterable="false">
                <template slot="no-options">
                    Masukkan Kata Kunci
                </template>
                <template slot="option" slot-scope="option">
                    {{ option.mapel_kode }} - {{ option.mapel_nama }}
                </template>
            </v-select>
            <p class="text-danger" v-if="errors.kompetensi_mapel">{{ errors.kompetensi_mapel[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.kompetensi_jenjang }">
            <label for="">Jenjang</label>
            <v-select :options="['7', '8', '9', '10', '11', '12']"
                        v-model="kompetensi.kompetensi_jenjang"                      
                        :value="kompetensi.kompetensi_jenjang"
                        >
            </v-select>
            <p class="text-danger" v-if="errors.kompetensi_jenjang">{{ errors.kompetensi_jenjang[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.kd_kode }">
            <label for="">Kode Kompetensi Dasar</label>
             <input type="text" class="form-control" v-model="kompetensi.kd_kode" :readonly="$route.name == 'kompetensi.view'"></textarea>
            <p class="text-danger" v-if="errors.kd_kode">{{ errors.kd_kode[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.kompetensi_deskripsi }">
            <label for="">Deskripsi Kompetensi Dasar</label>
             <textarea cols="5" rows="5" class="form-control" v-model="kompetensi.kompetensi_deskripsi" :readonly="$route.name == 'kompetensi.view'"></textarea>
            <p class="text-danger" v-if="errors.kompetensi_deskripsi">{{ errors.kompetensi_deskripsi[0] }}</p>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
export default {
    name: 'FormKompetensi',
    computed: {
        ...mapState(['errors']),
        ...mapState('kompetensi', {
            mapels: state => state.mapels,
            kompetensi: state => state.kompetensi
        })
    },
    methods: {
        ...mapActions('kompetensi', ['getMapel']),
        ...mapMutations('kompetensi', ['CLEAR_FORM']),
        onSearch(search, loading) {
            this.getMapel({
                search: search,
                loading: loading
            })
        }
    },
    destroyed() {
        this.CLEAR_FORM()
    },
    components: {
        vSelect
    }
}
</script>