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
import { mapActions, mapGetters } from 'vuex'
Vue.use(require('vue-moment'))
import moment from 'moment'

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
        ...mapGetters(['isAuth'])
    },
    methods: {
        ...mapActions('user', ['getUserLogin'])
    },
    created() {
        if (this.isAuth) {
            this.getUserLogin() //REQUEST DATA YANG SEDANG LOGIN
        }
    }
})
