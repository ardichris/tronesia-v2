import Vue from 'vue'
import router from './router.js'
import store from './store.js'
import App from './App.vue'
import BootstrapVue from 'bootstrap-vue'
import VueSweetalert2 from 'vue-sweetalert2'
    Vue.use(VueSweetalert2)
    Vue.use(BootstrapVue)
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'sweetalert2/dist/sweetalert2.min.css'
import Permissions from './mixins/Permission.js'
Vue.mixin(Permissions)
import { mapActions, mapGetters, mapState } from 'vuex'
Vue.use(require('vue-moment'))
import moment from 'moment'
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

Vue.filter('formatDate', function(value) {
    if (value) {
      return moment(String(value)).format('D MMMM YYYY')
    }
  });

  Vue.filter('formatDateView', function(value) {
    if (value) {
      return moment(String(value)).format('DD-MM-YYYY')
    }
  });

import wysiwyg from "vue-wysiwyg";
Vue.use(wysiwyg, {});
import 'vue-wysiwyg/dist/vueWysiwyg.css'
import VueGeolocation from 'vue-browser-geolocation';
Vue.use(VueGeolocation);

new Vue({
    el: '#dw',
    router,
    store,
    components: {
        App
    },
    computed: {
        ...mapGetters(['isAuth']),
        ...mapState(['token']), //GET TOKEN
        ...mapState('user', {
            user_authenticated: state => state.authenticated //MENGAMBIL STATE USER YANG SEDANG LOGIN
        })
    },
    methods: {
        ...mapActions('user', ['getUserLogin']),
        ...mapActions('notification', ['getNotifications']), //DEFINISIKAN FUNGSI UNTUK MENGAMBIL NOTIFIKASI DARI TABLE NOTIFICATIONS
        ...mapActions('kitirsiswa', ['getKitir']),
          //METHOD INI UNTUK MENGISIASI LISTER MENGGUNAKAN LARAVEL ECHO
          initialLister() {
            //JIKA USER SUDAH LOGIN
            if (this.isAuth) {
                //MAKA INISIASI FUNGSI BROADCASTER DENGAN KONFIGURASI BERIKUT
                window.Echo = new Echo({
                    broadcaster: 'pusher',
                    key: process.env.MIX_PUSHER_APP_KEY, //VALUENYA DI AMBIL DARI FILE .ENV
                    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
                    encrypted: false,
                    auth: {
                        headers: {
                            Authorization: 'Bearer ' + this.token
                        },
                    },
                });

                if (typeof this.user_authenticated.id != 'undefined') {
                    //KEMUDIAN KITA MENGAKSES CHANNEL BROADCAST SECARA PRIVATE
                    window.Echo.private(`App.User.${this.user_authenticated.id}`)
                    .notification(() => {
                        //APABILA DITEMUKAN, MAKA KITA MENJALANKAN KEDUA FUNGSI INI
                        //UNTUK MENGAMBIL DATA TERBARU
                        this.getNotifications()
                        this.getKitir()
                    })
                }
            }
        }
    },
    watch: {
        token() {
            this.initialLister()
        },
        user_authenticated() {
            this.initialLister()
        }
    },
    created() {
        if (this.isAuth) {
            this.getUserLogin() //REQUEST DATA YANG SEDANG LOGIN
            this.initialLister()
            this.getNotifications()
        }
    }
})
