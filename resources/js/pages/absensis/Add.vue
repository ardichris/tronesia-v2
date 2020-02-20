<template>
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Tambah Absensi</h3>
            </div>
            <div class="panel-body">
                <absensi-form></absensi-form>
                <div class="form-group">
                    <button class="btn btn-danger btn-sm btn-flat" @click.prevent="back">
                        <i class="fa fa-angle-double-left"></i> Kembali
                    </button>
                    <span class="float-right">
                        <button class="btn btn-primary btn-sm btn-flat" @click.prevent="submit">
                            <i class="fa fa-save"></i> Tambah
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapActions, mapState, mapMutations } from 'vuex'
    import FormAbsensi from './Form.vue'
    export default {
        name: 'AddAbsensi',
        data() {
            return {
                
            }
        },
        methods: {
            ...mapActions('absensi', ['submitAbsensi']), //PANGGIL ACTIONS submitAbsensi
            ...mapMutations('absensi', ['CLEAR_FORM']),
            submit() {
                //KETIKA TOMBOL DITEKAN MAKA FUNGSI INI AKAN DIJALANKAN
                //DIMANA FUNGSI INI TELAH DIBUAT PADA SESI SEBELUMNYA
                this.submitAbsensi().then(() => {
                    //APABILA BERHASIL MAKA AKAN DI-DIRECT KE HALAMAN /absensis
                    this.$router.push({ name: 'absensi.data' }),
                    this.CLEAR_FORM()
                })
            },
            back() {
                    this.CLEAR_FORM(),
                    this.$router.push({ name: 'absensi.data' })
            }
        },
        components: {
            'absensi-form': FormAbsensi
        }
    }
</script>