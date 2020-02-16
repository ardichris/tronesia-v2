<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Tambah Kelas</h3>
            </div>
            <div class="panel-body">
                <kelas-form></kelas-form>
                <div class="form-group">
                    <button class="btn btn-primary btn-sm btn-flat" @click.prevent="submit">
                        <i class="fa fa-save"></i> Submit
                    </button>
                    <span class="float-right">
                        <button class="btn btn-danger btn-sm btn-flat" @click.prevent="back">
                            <i class="fa fa-angle-double-left"></i> Kembali
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapActions, mapState } from 'vuex'
    import FormKelas from './Form.vue'
    export default {
        name: 'AddKelas',
        data() {
            return {
                
            }
        },
        methods: {
            ...mapActions('kelas', ['submitKelas']), //PANGGIL ACTIONS submitkelas
            submit() {
                //KETIKA TOMBOL DITEKAN MAKA FUNGSI INI AKAN DIJALANKAN
                //DIMANA FUNGSI INI TELAH DIBUAT PADA SESI SEBELUMNYA
                this.submitKelas().then(() => {
                    //APABILA BERHASIL MAKA AKAN DI-DIRECT KE HALAMAN /kelass
                    this.$router.push({ name: 'kelas.data' })
                })
            },
            back(){
                this.$router.push({ name: 'kelas.data'})
            },
        },
        components: {
            'kelas-form': FormKelas
        }
    }
</script>