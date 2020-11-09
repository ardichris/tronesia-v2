<template>
    <div class="col-md-12">
        <div class="form-group" :class="{ 'has-error': errors.p_kategori }">
            <span> <label for="">Kategori</label>
            <v-select :options="['Siswa', 'Guru', 'Penting']"
                        v-model="pengumuman.p_kategori"
                        >
            </v-select> </span>
            <p class="text-danger" v-if="errors.p_kategori">{{ errors.p_kategori[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.p_title }">
            <label for="">Title</label>
            <input type="text" class="form-control" v-model="pengumuman.p_title">
            <p class="text-danger" v-if="errors.p_title">{{ errors.p_title[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.p_isi }">
            <label for="">Pengumuman</label>
            <textarea cols="6" rows="5" class="form-control" v-model="pengumuman.p_isi" :readonly="$route.name == 'pengumuman.edit' || $route.name == 'pengumuman.view'"></textarea>
            <p class="text-danger" v-if="errors.p_isi">{{ errors.p_isi[0] }}</p>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
export default {
    name: 'FormPengumuman',
    computed: {
        ...mapState(['errors']),
        ...mapState('pengumuman', {
            pengumuman: state => state.p_input
        }),
    },
    methods: {
        ...mapMutations('pengumuman', ['CLEAR_FORM']),
    },
    destroyed() {
        this.CLEAR_FORM()
    },
    components: {
        vSelect
    }
}
</script>