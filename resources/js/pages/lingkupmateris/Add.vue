<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Tambah Kompetensi Dasar</h3>
            </div>
            <div class="panel-body">
                <kompetensi-form></kompetensi-form>
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
    import FormKompetensi from './Form.vue'
    export default {
        name: 'AddKompetensi',
        data() {
            return {
                
            }
        },
        methods: {
            ...mapActions('kompetensi', ['submitKompetensi']), //PANGGIL ACTIONS submitkompetensi
            submit() {
                //KETIKA TOMBOL DITEKAN MAKA FUNGSI INI AKAN DIJALANKAN
                //DIMANA FUNGSI INI TELAH DIBUAT PADA SESI SEBELUMNYA
                this.submitKompetensi().then(() => {
                    //APABILA BERHASIL MAKA AKAN DI-DIRECT KE HALAMAN /kompetensis
                    this.$router.push({ name: 'kompetensi.data' })
                })
            },
            back(){
                this.$router.push({ name: 'kompetensi.data'})
            },
        },
        components: {
            'kompetensi-form': FormKompetensi
        }
    }
</script>