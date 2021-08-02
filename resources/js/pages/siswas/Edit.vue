<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Siswa</h3>
            </div>
            <div class="panel-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab">
                        <a class="nav-item nav-link active" id="nav-profil-tab" data-toggle="tab" href="#nav-profil" role="tab">Profil</a>
                        <a class="nav-item nav-link" id="nav-presensi-tab" data-toggle="tab" href="#nav-presensi" role="tab">Presensi</a>
                        <a class="nav-item nav-link" id="nav-pelanggaran-tab" data-toggle="tab" href="#nav-pelanggaran" role="tab">Pelanggaran</a>
                        <a class="nav-item nav-link" id="nav-nilai-tab" data-toggle="tab" href="#nav-nilai" role="tab">Nilai</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent"  style="margin-bottom:10px">
                    <div class="tab-pane fade show active" id="nav-profil" role="tabpanel" style="height:2000px; overflow:disable">
                        <siswa-form></siswa-form>
                    </div>
                    <div class="tab-pane fade" id="nav-presensi" role="tabpanel" style="height:200px">
                    </div>
                    <div class="tab-pane fade" id="nav-pelanggaran" role="tabpanel">
                    </div>
                    <div class="tab-pane fade" id="nav-nilai" role="tabpanel">
                    </div>
                </div>
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