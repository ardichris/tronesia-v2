<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Kelas</h3>
            </div>
            <div class="panel-body">
                <kelas-form></kelas-form>
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
            ...mapActions('kelas', ['editKelas', 'updateKelas', 'anggotaKelas'])
        },
        components: {
            'kelas-form': FormKelas
        },
    }
</script>
