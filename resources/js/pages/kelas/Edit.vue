<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Kelas</h3>
            </div>
            <div class="panel-body">
                <kelas-form></kelas-form>
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
    import FormKelas from './Form.vue'
    export default {
        name: 'EditKelas',
        created() {
            this.editKelas(this.$route.params.id)
            //this.anggotaKelas(this.$route.params.id)
        },
        methods: {
            ...mapActions('kelas', ['editKelas', 'updateKelas', 'anggotaKelas']),
            submit() {
                //KETIKA TOMBOL UPDATE DI MAKA AKAN MENGIRIMKAN PERMINTAAN
                //UNTUK MENGUBAH DATA BERDASARKAN CODE YANG DIKIRIMKAN
                this.updateKelas(this.$route.params.id).then(() => {
                    //APABILA BERHASIL MAKA AKAN DI-DIRECT KEMBALI
                    //KE HALAMAN /outlets
                    this.$router.push({ name: 'kelas.data' })
                })
            },
            back() {
                    this.$router.push({ name: 'kelas.data' })
            }
        },
        components: {
            'kelas-form': FormKelas
        },
    }
</script>