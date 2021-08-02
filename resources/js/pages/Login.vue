<!-- HTML SECTION -->
<template>
<body class="hold-transition login-page">

        <div class="login-box">
            <div class="login-logo">
                <router-link :to="{ name: 'home' }"><b>TRONE</b>SIA</router-link>
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <div class="login-box-body">
                        <p class="login-box-msg">Sign in to start your session</p>

                        <div class="form-group has-feedback" :class="{'has-error': errors.email}">
                            <input type="email" class="form-control" placeholder="Email" v-model="data.email">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            <p class="text-danger" v-if="errors.email">{{ errors.email[0] }}</p>
                        </div>
                        <div class="form-group has-feedback" :class="{'has-error': errors.password}" v-on:keyup.enter="postLogin">
                            <input type="password" class="form-control" placeholder="Password" v-model="data.password">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            <p class="text-danger" v-if="errors.password">{{ errors.password[0] }}</p>
                        </div>
                        <div class="form-group has-feedback">
                            <select class="form-control" v-model="data.periode">
                                <option value="1">Semester 1 Tahun Ajaran 2020/2021</option>
                                <option value="2">Semester 2 Tahun Ajaran 2020/2021</option>
                                <option value="3">Semester 1 Tahun Ajaran 2021/2022</option>                                         
                            </select>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            <p class="text-danger" v-if="errors.periode">{{ errors.periode[0] }}</p>
                        </div>                        
                        <div class="alert alert-danger" v-if="errors.invalid">{{ errors.invalid }}</div>
                        <div class="row">
                            <div class="col-8">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" v-model="data.remember_me"> Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat" @click.prevent="postLogin">Login</button>
                            </div>
                        </div>

                        <a href="#">I forgot my password</a><br>
                    </div>
                </div>
            </div>
        </div>

</body>
</template>

<!-- JAVASCRIPT SECTION -->
<script>
import { mapActions, mapMutations, mapGetters, mapState } from 'vuex';
export default {
    data() {
        return {
            data: {
                email: '',
                password: '',
                periode: '',
                remember_me: false
            }
        }
    },
    //SEBELUM COMPONENT DI-RENDER
    created() {
        //KITA MELAKUKAN PENGECEKAN JIKA SUDAH LOGIN DIMANA VALUE isAuth BERNILAI TRUE
        if (this.isAuth) {
            //MAKA DI-DIRECT KE ROUTE DENGAN NAME home
            this.$router.push({ name: 'home' })
        }
    },
    computed: {
        ...mapGetters(['isAuth']), //MENGAMBIL GETTERS isAuth DARI VUEX
      	...mapState(['errors'])
    },
    methods: {
        ...mapActions('auth', ['submit']), //MENGISIASI FUNGSI submit() DARI VUEX AGAR DAPAT DIGUNAKAN PADA COMPONENT TERKAIT. submit() BERASAL DARI ACTION PADA FOLDER STORES/auth.js
        ...mapActions('user', ['getUserLogin']),
        ...mapMutations(['CLEAR_ERRORS']),
      
      	//KETIKA TOMBOL LOGIN DITEKAN, MAKA AKAN MEMINCU METHODS postLogin()
        postLogin() {
            //DIMANA TOMBOL INI AKAN MENJALANKAN FUNGSI submit() DENGAN MENGIRIMKAN DATA YANG DIBUTUHKAN
            this.submit(this.data).then(() => {
                //KEMUDIAN DI CEK VALUE DARI isAuth
                //APABILA BERNILAI TRUE
                if (this.isAuth) {
                    this.CLEAR_ERRORS()
                    //MAKA AKAN DI-DIRECT KE ROUTE DENGAN NAME home
                    this.$router.push({ name: 'home' })
                }
            })
        }
    },
    destroyed() {
        this.getUserLogin()
    }
}
</script>