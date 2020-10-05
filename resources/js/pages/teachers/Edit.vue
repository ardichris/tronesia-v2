<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Account</h3>
            </div>
            <div class="panel-body">
                <teacher-form ref="formTeacher"></teacher-form>
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
    import { mapActions, mapState } from 'vuex'
    import FormTeacher from './Form.vue'
    export default {
        name: 'EditTeacher',
        methods: {
            submit() {
                this.$refs.formTeacher.submit()
            },
            back() {
                this.$router.push({ name: 'home' })
            }
        },
        components: {
            'teacher-form': FormTeacher
        },
    }
</script>
