<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Jurnal Mengajar</h3>
            </div>
            <div class="panel-body">
                <jurnal-form></jurnal-form>
                <div class="form-group">
                    <button class="btn btn-primary btn-sm btn-flat" @click.prevent="submit">
                        <i class="fa fa-save"></i> Update
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
    import FormJurnal from './Form.vue'
    export default {
        name: 'EditJurnal',
        created() {
            //SEBELUM COMPONENT DI-RENDER KITA MELAKUKAN REQUEST KESERVER
            //BERDASARKAN CODE YANG ADA DI URL
            this.editJurnal(this.$route.params.id)
        },
        methods: {
            ...mapActions('jurnal', ['editJurnal', 'updateJurnal']),
            submit() {
                //KETIKA TOMBOL UPDATE DI MAKA AKAN MENGIRIMKAN PERMINTAAN
                //UNTUK MENGUBAH DATA BERDASARKAN CODE YANG DIKIRIMKAN
                this.updateJurnal(this.$route.params.id).then(() => {
                    //APABILA BERHASIL MAKA AKAN DI-DIRECT KEMBALI
                    //KE HALAMAN /outlets
                    this.$router.push({ name: 'jurnal.data' })
                })
            },
            back() {
                    this.$router.push({ name: 'jurnal.data' })
            }
        },
        components: {
            'jurnal-form': FormJurnal
        },
    }
</script>