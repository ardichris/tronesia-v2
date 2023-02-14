<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Tambah Inventaris</h3>
            </div>
            <div class="panel-body">
                <inventories-form></inventories-form>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapActions, mapState } from 'vuex'
    import FormInventory from './Form.vue'
    export default {
        name: 'AddBarang',
        data() {
            return {

            }
        },
        methods: {
            ...mapActions('barang', ['submitBarang']),
            submit() {
                this.submitBarang().then(() => {
                    this.$router.push({ name: 'barang.data' })
                })
            },
            back(){
                this.$router.push({ name: 'barang.data'})
            },
        },
        components: {
            'inventories-form': FormInventory
        }
    }
</script>
