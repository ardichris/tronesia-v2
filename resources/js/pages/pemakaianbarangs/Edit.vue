<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Barang</h3>
            </div>
            <div class="panel-body">
                <barang-form></barang-form>
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
    import FormBarang from './Form.vue'
    export default {
        name: 'EditBarang',
        created() {
            this.editBarang(this.$route.params.id)
        },
        methods: {
            ...mapActions('barang', ['editBarang', 'updateBarang']),
            submit() {
                this.updateBarang(this.$route.params.id).then(() => {
                    this.$router.push({ name: 'barang.data' })
                })
            },
            back() {
                    this.$router.push({ name: 'barang.data' })
            }
        },
        components: {
            'barang-form': FormBarang
        },
    }
</script>