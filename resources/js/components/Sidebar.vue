<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo class="brand-image img-circle elevation-3">
        <a href="/" class="brand-link">
        <img src="/storage/LOGO P1.png" alt="AdminLTE Logo" 
            style="opacity: .8">
        </a-->
        <a href="/" class="brand-link">
        <img src="/storage/TRONESIA.png" alt="TRONESIA Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">TRONESIA</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            <img :src="'/storage/teachers/' + authenticated.photo" class="img-circle elevation-5" alt="User Image">
            </div>
            <div class="info">
            <!--a href="/" class="d-block">{{ authenticated.name }}</a-->
            <router-link :to="{ name: 'teachers.edit', params: {id: authenticated.id} }">{{ authenticated.name }}</router-link>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview" v-if="authenticated.role==0">
                    <a class="nav-link active">
                    <i class="nav-icon fas fa-database"></i>
                    <p>
                        Master
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a class="nav-link">
                        <i class="fas fa-users nav-icon"></i>
                        <p><router-link :to="{ name: 'siswas.data' }">Master Siswa</router-link></p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
                        <i class="fas fa-chalkboard-teacher nav-icon"></i>
                        <p><router-link :to="{ name: 'teachers.data' }">Master Guru</router-link></p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
                        <i class="fas fa-book nav-icon"></i>
                        <p><router-link :to="{ name: 'mapel.data' }">Master Mapel</router-link></p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
                        <i class="fas fa-address-card nav-icon"></i>
                        <p><router-link :to="{ name: 'kelas.data' }">Master Kelas</router-link></p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
                        <i class="fas fa-running nav-icon"></i>
                        <p><router-link :to="{ name: 'kompetensi.data' }">Master Kompetensi</router-link></p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
                        <i class="fas fa-dolly nav-icon"></i>
                        <p><router-link :to="{ name: 'barang.data' }">Master Barang</router-link></p>
                        </a>
                    </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview" v-if="authenticated.role==0 || authenticated.role==3 || authenticated.role==2">
                    <a class="nav-link active">
                        <i class="nav-icon fas fa-users"></i>
                            <p>
                                Kesiswaan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                    </a>
                    <ul class="nav nav-treeview" >
                        <li class="nav-item">
                            <a class="nav-link" v-if="authenticated.role!=2">
                                <i class="fas fa-user-injured nav-icon"></i>
                                <p><router-link :to="{ name: 'absensi.data' }">Absensi</router-link></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="fas fa-exclamation-triangle nav-icon"></i>
                                <p><router-link :to="{ name: 'pelanggarans.data' }">Pelanggaran</router-link></p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview" v-if="authenticated.role==0 || authenticated.role==4">
                    <a class="nav-link active">
                        <i class="nav-icon fas fa-building"></i>
                            <p>
                                Sarpras
                                <i class="right fas fa-angle-left"></i>
                            </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="fas fa-bullhorn nav-icon"></i>
                                <p><router-link :to="{ name: 'pelanggarans.data' }">Laporan</router-link></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="fas fa-house-damage nav-icon"></i>
                                <p><router-link :to="{ name: 'pelanggarans.data' }">Kerusakan</router-link></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="fas fa-sign-in-alt nav-icon"></i>
                                <p><router-link :to="{ name: 'barangmasuk.data' }">Barang Masuk</router-link></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="fas fa-toilet-paper nav-icon"></i>
                                <p><router-link :to="{ name: 'pemakaianbarang.data' }">Pemakaian Barang</router-link></p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview" v-if="authenticated.role==0 || authenticated.role==2 || authenticated.role==1">
                    <a class="nav-link active">
                        <i class="nav-icon fas fa-book-reader"></i>
                            <p>
                                Kurikulum
                                <i class="right fas fa-angle-left"></i>
                            </p>
                    </a>
                    <ul class="nav nav-treeview" >
                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p><router-link :to="{ name: 'jurnal.data' }">Jurnal Mengajar</router-link></p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview" v-if="authenticated.role==0">
                    <a class="nav-link active">
                        <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Setting
                                <i class="right fas fa-angle-left"></i>
                            </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="fas fa-users-cog"></i>
                                <p><router-link :to="{ name: 'role.permissions' }">Role Permissions</router-link></p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->          
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
import { mapState } from 'vuex'
export default {
    computed: {
        ...mapState('user', {
            authenticated: state => state.authenticated //ME-LOAD STATE AUTHENTICATED
        })
    },
    methods: {
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