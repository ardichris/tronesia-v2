<template>
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Absensi</h3>
            </div>
            <div class="panel-body">
                <absensi-form></absensi-form>
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
    import FormAbsensi from './Form.vue'
    export default {
        name: 'EditAbsensi',
        created() {
            //SEBELUM COMPONENT DI-RENDER KITA MELAKUKAN REQUEST KESERVER
            //BERDASARKAN CODE YANG ADA DI URL
            this.editAbsensi(this.$route.params.id)
        },
        methods: {
            ...mapActions('absensi', ['editAbsensi', 'updateAbsensi']),
            ...mapMutations('absensi', ['CLEAR_FORM']),
            submit() {
                this.updateAbsensi(this.$route.params.id).then(() => {
                    this.$router.push({ name: 'absensi.data' })
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
        },
    }
</script>