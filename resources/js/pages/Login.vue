<!-- HTML SECTION -->
<template>
<body class="hold-transition login-page">
        <b-modal id="live-tracking" scrollable size="md">
            <template v-slot:modal-title>
                Insert Student Details
            </template>
            <label>Student Code</label>
            <input type="text" class="form-control" v-model="requestLive.studentcode">

            <label>Date of Birth</label>
            <input type="date" class="form-control" v-model="requestLive.dob">
            <template v-slot:modal-footer>
                <b-button
                    variant="primary"
                    class="mt-3"                                    
                    block  @click="liveTrackingHandler  "
                >
                    Submit
                </b-button>
            </template>
        </b-modal>
        <div class="login-box">
            <div class="login-logo">
                <router-link :to="{ name: 'home' }"><b>S.I.A.P</b></router-link>
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
                                <option value="4" selected>Semester 2 Tahun Ajaran 2021/2022</option>                                         
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
            <div>
                    <button v-if="liveStatus === ''" type="submit" class="btn btn-success btn-block btn-flat" @click.prevent="showLiveTrackingModal">Live Location</button>
                    <button v-if="liveStatus === 'success'" type="submit" class="btn btn-danger btn-block btn-flat" @click.prevent="stopLiveTracking">Stop Tracking</button>
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
                periode: 4,
                remember_me: false
            },
            options: {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            },
            target: {
                latitude : 0,
                longitude: 0
            },
            koordinat: {},
            id: '',
            centerPosition: {
            lat: 10.762622,
            lng: 106.660172,
            },
            zoom: 16,
            positions: [],

            
        }
    },
    mounted() {
        if(this.liveStatus == 'success'){
            console.log('cek')
            this.interval = setInterval(() =>
                this.updateLocation(), 5000);
        }

    },
    //SEBELUM COMPONENT DI-RENDER
    created() {
        //KITA MELAKUKAN PENGECEKAN JIKA SUDAH LOGIN DIMANA VALUE isAuth BERNILAI TRUE
        if (this.isAuth) {
            //MAKA DI-DIRECT KE ROUTE DENGAN NAME home
            this.$router.push({ name: 'home' })
        }
        if(this.liveStatus == 'success'){
            this.interval = setInterval(() =>
                this.updateLocation(), 5000);
        }


    },
    computed: {
        ...mapGetters(['isAuth']), //MENGAMBIL GETTERS isAuth DARI VUEX
      	...mapState(['errors']),
        ...mapState('livetracking', {
            requestLive: state => state.requestLive,
            liveStatus: state => state.liveStatus,
            reqID: state => state.reqID
        })
    },
    watch: {

    },
    
    methods: {
        ...mapActions('auth', ['submit']), //MENGISIASI FUNGSI submit() DARI VUEX AGAR DAPAT DIGUNAKAN PADA COMPONENT TERKAIT. submit() BERASAL DARI ACTION PADA FOLDER STORES/auth.js
        ...mapActions('user', ['getUserLogin']),
        ...mapActions('livetracking', ['liveLocation', 'requestLiveTracking', 'stopLiveTracking']),
        ...mapMutations(['CLEAR_ERRORS']),
        ...mapMutations('livetracking', ['CLEAR_FORM']),
        updateLocation(){
            this.liveLocation({
                code: this.requestLive.studentcode,
                lat: this.centerPosition.lat,
                lng: this.centerPosition.lng
            })
        },
        stopLiveTracking(){
            navigator.geolocation.clearWatch(this.id),
            this.CLEAR_FORM()
        },
        trackPosition() {
            if (navigator.geolocation) {
                this.id = navigator.geolocation.watchPosition(this.successPosition, this.failurePosition, {
                enableHighAccuracy: false,
                timeout: 15000,
                maximumAge: 0,
                })
            } else {
                alert(`Browser doesn't support Geolocation`)
            }
        },
        successPosition: function(position) {
            this.positions.push({
                lat: position.coords.latitude,
                lng: position.coords.longitude,
            })
            this.centerPosition = {lat: position.coords.latitude, lng: position.coords.longitude}
            this.liveLocation({
                code: this.reqID,
                lat: this.centerPosition.lat,
                lng: this.centerPosition.lng
            })
        },
        failurePosition: function(err) {
            alert('Error Code: ' + err.code + ' Error Message: ' + err.message)
        },  
        
        showLiveTrackingModal(){
            this.$bvModal.show('live-tracking')           
        },
        liveTrackingHandler(){
            this.requestLiveTracking()
                .then(() => {
                    if(this.liveStatus == 'success'){
                        this.$swal({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            type: 'success',
                            title: 'Live Request accepted'
                        })
                        this.trackPosition();
                        this.$bvModal.hide('live-tracking')    
                    } else {
                        this.$swal({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            type: 'error',
                            title: 'Live Request fail'
                        })
                    }
                })
                .catch(() => {
                    this.$swal({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        type: 'error',
                        title: 'Live Request fail'
                    })
                })
            // //id = navigator.geolocation.watchPosition(this.options)
            // this.id = this.$watchLocation(this.options)
            // .then(coordinates => {
            //     console.log(coordinates);
            //     this.koordinat = coordinates;
            // });
        },
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