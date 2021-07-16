<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">View Siswa</h3>
            </div>
            <div class="panel-body">
                <siswa-form></siswa-form>
                <div class="form-group">
                    <button class="btn btn-danger btn-sm btn-flat" @click.prevent="back">
                        <i class="fa fa-angle-double-left"></i> Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapActions, mapState } from 'vuex'
    import FormSiswas from './Form.vue'
    export default {
        name: 'ViewSiswa',
        created() {
            //SEBELUM COMPONENT DI-RENDER KITA MELAKUKAN REQUEST KESERVER
            //BERDASARKAN CODE YANG ADA DI URL
            this.viewSiswa(this.$route.params.id)
        },
        methods: {
            ...mapActions('siswa', ['viewSiswa']),
            back() {
                    this.$router.push({ name: 'siswas.data' })
            }
           
        },
        components: {
            'siswa-form': FormSiswas
        },
    }
</script>