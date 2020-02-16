<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">View Mapel</h3>
            </div>
            <div class="panel-body">
                <mapel-form></mapel-form>
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
    import FormMapel from './Form.vue'
    export default {
        name: 'ViewMapel',
        created() {
            //SEBELUM COMPONENT DI-RENDER KITA MELAKUKAN REQUEST KESERVER
            //BERDASARKAN CODE YANG ADA DI URL
            this.viewMapel(this.$route.params.id)
        },
        methods: {
            ...mapActions('mapel', ['viewMapel']),
            back() {
                    this.$router.push({ name: 'mapel.data' })
            }
           
        },
        components: {
            'mapel-form': FormMapel
        },
    }
</script>