<template>
    <div>
        <div class="form-group" :class="{ 'has-error': errors.name }">
            <label for="">Nama Lengkap</label>
            <input type="text" class="form-control" v-model="teacher.name" :readonly="$route.name == 'teachers.view'">
            <p class="text-danger" v-if="errors.name">{{ errors.name[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.email }">
            <label for="">Email</label>
            <input type="text" class="form-control" v-model="teacher.email" :readonly="$route.name == 'teachers.view'">
            <p class="text-danger" v-if="errors.email">{{ errors.email[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.password }">
            <label for="">Password</label>
            <input type="password" class="form-control" v-model="teacher.password" :readonly="$route.name == 'teachers.view'">
            <p class="text-warning" v-if="$route.name == 'teachers.edit'">Leave blank if you don't want to change password</p>
            <p class="text-danger" v-if="errors.password">{{ errors.password[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.role }" v-if="authenticated.role==0">
            <label for="">Role</label>
            <input type="text" class="form-control" v-model="teacher.role" :readonly="$route.name == 'teachers.view'">
            <p class="text-danger" v-if="errors.role">{{ errors.role[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.photo }">
            <label for="">Foto</label>
            <img :src="'/storage/teachers/' + teacher.foto" :width="120" :height="160" :hidden="$route.name == 'teachers.add'">
            <input type="file" class="form-control" accept="image/*" @change="uploadImage($event)" id="file-input" :hidden="$route.name == 'teachers.view'">
            <p class="text-warning" v-if="$route.name == 'teachers.edit'">Leave blank if you don't want to change photo</p>
            <p class="text-danger" v-if="errors.photo">{{ errors.photo[0] }}</p>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
export default {
    name: 'FormTeacher',
    created() { 
        if (this.$route.name == 'teachers.edit' || this.$route.name == 'teachers.view') {
            this.editTeacher(this.$route.params.id).then((res) => {
                this.teacher = {
                    name: res.data.name,
                    email: res.data.email,
                    password: '',
                    photo: '',
                    foto: res.data.photo
                }
            })
        }
    },
    data() {
        return {
            teacher: {
                name: '',
                email: '',
                password: '',
                photo: '',
                role: ''
            }
        }
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('user', {
            authenticated: state => state.authenticated //ME-LOAD STATE AUTHENTICATED
        })
    },
    methods: {
        ...mapActions('teacher', ['submitTeacher', 'editTeacher', 'updateTeacher']), //MENDEFINISIKAN FUNGSI submitTeacher, editTeacher, dan updateTeacher
        ...mapMutations('teacher', ['SET_ID_UPDATE']), //MEMANGGIL MUTATIONS
        //KETIKA TERJADI PENGINPUTAN GAMBAR, MAKA FILE TERSEBUT AKAN DI ASSIGN KE DALAM teacher.photo
        uploadImage(event) {
            this.teacher.photo = event.target.files[0]
        },
        //KETIKA TOMBOL ADD NEW DITEKAN MAKA AKAN MENJALAN FUNGSI DIBAWAH
        submit() {
            //DIMANA UNTUK MENGUPLOAD GAMBAR HARUS MENGGUNAKAN FORMDATA
            let form = new FormData()
            form.append('name', this.teacher.name)
            form.append('email', this.teacher.email)
            form.append('password', this.teacher.password)
            form.append('role', this.teacher.role)
            form.append('photo', this.teacher.photo)

            //KETIKA HALAMAN ADD KURIR YANG DI AKSES
            if (this.$route.name == 'teachers.add') {
                //MAKA AKAN MENJALANKAN FUNGSI submitTeacher
                this.submitTeacher(form).then(() => {
                    //KEMUDIAN FORM DI KOSONGKAN
                    this.teacher = {
                        name: '',
                        email: '',
                        password: '',
                        photo: '',
                        role:''
                    }
                    //DI DIRECT KE HALAMAN LIST DATA KURIR
                    this.$router.push({ name: 'teachers.data' })
                })
            //JIKA YANG DIAKSES HALAMAN EDIT KURIR
            } else if (this.$route.name == 'teachers.edit') {
                //MAKA ID NYA DI ASSING KE STATE ID
                this.SET_ID_UPDATE(this.$route.params.id)
                //DAN FUNGSI updateTeacher DIJALANKAN
                this.updateTeacher(form).then(() => {
                    //KEMUDIAN FORM DI KOSONGKAN
                    this.teacher = {
                        name: '',
                        email: '',
                        password: '',
                        photo: '',
                        role:''
                    }
                    //DI DIRECT KE HALAMAN LIST DATA KURIR
                    this.$router.push({ name: 'teachers.data' })
                })
            }
        }
    }
}
</script>