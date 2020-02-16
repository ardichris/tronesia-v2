<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">View Absensi</h3>
            </div>
            <div class="panel-body">
                <absensi-form></absensi-form>
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
    import FormAbsensi from './Form.vue'
    export default {
        name: 'ViewAbsensi',
        created() {
            //SEBELUM COMPONENT DI-RENDER KITA MELAKUKAN REQUEST KESERVER
            //BERDASARKAN CODE YANG ADA DI URL
            this.editAbsensi(this.$route.params.id)
        },
        methods: {
            ...mapActions('absensi', ['editAbsensi']),
            ...mapMutations('absensi', ['CLEAR_FORM']),
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