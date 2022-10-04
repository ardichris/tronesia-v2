<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <!--<li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>-->
    </ul>


    <!--<form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>-->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown show">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
            <i class="far fa-bell"></i>
            <span class="badge badge-success navbar-badge">{{ notifications.length }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <span class="dropdown-item dropdown-header">You have {{ notifications.length }} messages</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" v-if="notifications.length > 0">
                    <li v-for="(row, index) in notifications" :key="index">
                        <a href="javascript:void(0)" @click="readNotif(row)">
                            <div class="pull-left">
                                <img src="https://via.placeholder.com/160" class="img-circle" alt="User Image">
                            </div>
                            <h4>
                                <!-- TAMPILKAN NAMA PENGIRIM NOTIFIKASI -->
                                {{ row.data.sender_name }}
                                <!-- TAMPILKAN WAKTU NOTIFIKASI -->
                                <small><i class="fa fa-clock-o"></i> {{ row.created_at | formatDate }}</small>
                            </h4>
                            <!-- TAMPILKAN JENIS PERMINTAAN NOTIFIKASI -->
                            <p></p>
                        </a>
                    </li>
                </a>
                <a href="#" class="dropdown-item" v-for="(row, index) in notifications" :key="index">

                    <div class="media">
                        <img src="" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                            {{ row.data.kitirs.siswa }}
                            <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">{{row.data.kitirs.ks_jenis}}</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{ row.created_at | formatDate }}</p>
                        </div>
                    </div>

                </a>
            </div>
        </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <button class="btn btn-danger btn-sm btn-flat" @click.prevent="logout">
            <i class="fas fa-power-off"></i> Sign out
          </button>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import moment from 'moment'

export default {
    computed: {
    ...mapState('user', {
        authenticated: state => state.authenticated
    }),

    ...mapState('notification', {
        notifications: state => state.notifications
    })
    },
    filters: {
        formatDate(val) {
            return moment(new Date(val)).fromNow()
        }
    },
    methods: {
        ...mapActions('notification', ['readNotification']),
        readNotif(row) {
            //MENGIRIMKAN REQUEST KE SERVER UNTUK MENANDAI BAHWA NOTIFIKASI TELAH DI BACA
            //KEMUDIAN SELANJUTNYA KITA REDIRECT KE HALAMAN VIEW EXPENSES
            this.readNotification({ id: row.id}).then(() => this.$router.push({ name: 'kitirsiswas.view', params: {id: row.data.kitirsiswas.id} }))
        },
        logout() {
            return new Promise((resolve, reject) => {
                localStorage.removeItem('token') //MENGHAPUS TOKEN DARI LOCALSTORAGE
                resolve()
            }).then(() => {
                //MEMPERBAHARUI STATE TOKEN
                this.$store.state.token = localStorage.getItem('token')
                this.$router.push('/login') //REDIRECT KE PAGE LOGIN
            })
        },
    }
}
</script>
