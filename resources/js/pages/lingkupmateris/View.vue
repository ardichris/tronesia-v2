<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Lihat Kompetensi Dasar</h3>
            </div>
            <div class="panel-body">
                <kompetensi-form></kompetensi-form>
                <div class="form-group">
                    <button class="btn btn-danger btn-sm btn-flat float-right" @click.prevent="back">
                        <i class="fa fa-angle-double-left"></i> Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapActions, mapState } from 'vuex'
    import FormKompetensi from './Form.vue'
    export default {
        name: 'ViewKompetensi',
        created() {
            //SEBELUM COMPONENT DI-RENDER KITA MELAKUKAN REQUEST KESERVER
            //BERDASARKAN CODE YANG ADA DI URL
            this.viewKompetensi(this.$route.params.id)
        },
        methods: {
            ...mapActions('kompetensi', ['viewKompetensi']),
            back() {
                    this.$router.push({ name: 'kompetensi.data' })
            }
           
        },
        components: {
            'kompetensi-form': FormKompetensi
        },
    }
</script>