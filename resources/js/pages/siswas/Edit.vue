<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Siswa</h3>
            </div>
            <div class="panel-body">
                <siswa-form></siswa-form>
                <div class="form-group">
                    <button class="btn btn-danger btn-sm btn-flat" @click.prevent="back">
                        <i class="fa fa-angle-double-left"></i> Kembali
                    </button>
                    <span class="float-right">
                        <button class="btn btn-primary btn-sm btn-flat float-right" @click.prevent="submit">
                            <i class="fa fa-save"></i> Update
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapActions, mapState } from 'vuex'
    import FormSiswas from './Form.vue'
    export default {
        name: 'EditSiswa',
        created() {
            //SEBELUM COMPONENT DI-RENDER KITA MELAKUKAN REQUEST KESERVER
            //BERDASARKAN CODE YANG ADA DI URL
            this.editSiswa(this.$route.params.id)
        },
        methods: {
            ...mapActions('siswa', ['editSiswa', 'updateSiswa']),
            submit() {
                //KETIKA TOMBOL UPDATE DI MAKA AKAN MENGIRIMKAN PERMINTAAN
                //UNTUK MENGUBAH DATA BERDASARKAN CODE YANG DIKIRIMKAN
                this.updateSiswa(this.$route.params.id).then(() => {
                    //APABILA BERHASIL MAKA AKAN DI-DIRECT KEMBALI
                    //KE HALAMAN /outlets
                    this.$router.push({ name: 'siswas.data' })
                })
            },
            back() {
                    this.$router.push({ name: 'siswas.data' })
            }
        },
        components: {
            'siswa-form': FormSiswas
        },
    }
</script>