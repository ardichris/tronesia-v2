<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">View Teacher</h3>
            </div>
            <div class="panel-body">
                <teacher-form ref="formTeacher"></teacher-form>
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
    import FormTeacher from './Form.vue'
    export default {
        name: 'ViewTeacher',
        methods: {
            back() {
                this.$router.push({ name: 'teachers.data' })
            }
        },
        components: {
            'teacher-form': FormTeacher
        }
    }
</script>