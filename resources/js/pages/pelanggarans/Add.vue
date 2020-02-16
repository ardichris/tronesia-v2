<template>
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Tambah Pelanggaran</h3>
            </div>
            <div class="panel-body">
                <pelanggaran-form></pelanggaran-form>
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
    import FormPelanggarans from './Form.vue'
    export default {
        name: 'AddPelanggaran',
        data() {
            return {
                
            }
        },
        methods: {
            ...mapActions('pelanggaran', ['submitPelanggaran']), //PANGGIL ACTIONS submitPelanggaran
            ...mapMutations('pelanggaran', ['CLEAR_FORM']),
            submit() {
                //KETIKA TOMBOL DITEKAN MAKA FUNGSI INI AKAN DIJALANKAN
                //DIMANA FUNGSI INI TELAH DIBUAT PADA SESI SEBELUMNYA
                this.submitPelanggaran().then(() => {
                    //APABILA BERHASIL MAKA AKAN DI-DIRECT KE HALAMAN /pelanggarans
                    this.$router.push({ name: 'pelanggarans.data' }),
                this.CLEAR_FORM()
                })
            },
            back() {
                    this.CLEAR_FORM(),
                    this.$router.push({ name: 'pelanggarans.data' })
            }
        },
        components: {
            'pelanggaran-form': FormPelanggarans
        }
    }
</script>