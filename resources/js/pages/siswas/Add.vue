<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Add New Siswa</h3>
            </div>
            <div class="panel-body">
                <siswa-form></siswa-form>
                <div class="form-group">
                    <button class="btn btn-primary btn-sm btn-flat" @click.prevent="submit">
                        <i class="fa fa-save"></i> Add New
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
        name: 'AddSiswa',
        data() {
            return {
                
            }
        },
        methods: {
            ...mapActions('siswa', ['submitSiswa']), //PANGGIL ACTIONS submitSiswa
            submit() {
                //KETIKA TOMBOL DITEKAN MAKA FUNGSI INI AKAN DIJALANKAN
                //DIMANA FUNGSI INI TELAH DIBUAT PADA SESI SEBELUMNYA
                this.submitSiswa().then(() => {
                    //APABILA BERHASIL MAKA AKAN DI-DIRECT KE HALAMAN /siswas
                    this.$router.push({ name: 'siswas.data' })
                })
            }
        },
        components: {
            'siswa-form': FormSiswas
        }
    }
</script>