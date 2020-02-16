<template>
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Pelanggaran</h3>
            </div>
            <div class="panel-body">
                <pelanggaran-form></pelanggaran-form>
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
    import { mapActions, mapState, mapMutations } from 'vuex'
    import FormPelanggarans from './Form.vue'
    export default {
        name: 'EditPelanggaran',
        created() {
            //SEBELUM COMPONENT DI-RENDER KITA MELAKUKAN REQUEST KESERVER
            //BERDASARKAN CODE YANG ADA DI URL
            this.editPelanggaran(this.$route.params.id)
        },
        methods: {
            ...mapActions('pelanggaran', ['editPelanggaran', 'updatePelanggaran']),
            ...mapMutations('pelanggaran', ['CLEAR_FORM']),
            submit() {
                this.updatePelanggaran(this.$route.params.id).then(() => {
                    this.$router.push({ name: 'pelanggarans.data' })
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
        },
    }
</script>