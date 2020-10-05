<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">View Pelanggaran</h3>
            </div>
            <div class="panel-body">
                <pelanggaran-form></pelanggaran-form>
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
    import { mapActions, mapState, mapMutations } from 'vuex'
    import FormPelanggarans from './Form.vue'
    export default {
        name: 'ViewPelanggaran',
        created() {
            //SEBELUM COMPONENT DI-RENDER KITA MELAKUKAN REQUEST KESERVER
            //BERDASARKAN CODE YANG ADA DI URL
            this.editPelanggaran(this.$route.params.id)
        },
        methods: {
            ...mapActions('pelanggaran', ['editPelanggaran']),
            ...mapMutations('pelanggaran', ['CLEAR_FORM']),
            back() {
                    this.CLEAR_FORM(),
                    this.$router.push({ name: 'pelanggarans.data' })
            }
           
        },
        components: {
            'pelanggaran-form': FormPelanggarans
        },
    }
</script>