<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo class="brand-image img-circle elevation-3">
        <a href="/" class="brand-link">
        <img src="/storage/LOGO P1.png" alt="AdminLTE Logo"
            style="opacity: .8">
        </a-->
        <a href="/" class="brand-link">
        <img src="/storage/SIAP.png" alt="SIAP Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">S.I.A.P</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            <img v-if="authenticated.photo" :src="'/storage/teachers/' + authenticated.photo" class="img-circle elevation-5" alt="User Image">
            <img v-else :src="'https://ui-avatars.com/api/?name=s+i+a+p&length=4&background=random'" class="img-circle elevation-5">
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
                <li class="nav-item has-treeview" v-if="authenticated.role==0 || authenticated.role==4 || authenticated.role==2">
                    <a class="nav-link">
                    <i class="nav-icon fas fa-database"></i>
                    <p>
                        Master
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a class="nav-link ml-3">
                        <i class="fas fa-users nav-icon"></i>
                        <p><router-link :to="{ name: 'siswas.data' }">Master Siswa</router-link></p>
                        </a>
                    </li>
                    <li class="nav-item" v-if="authenticated.role!=2">
                        <a class="nav-link ml-3">
                        <i class="fas fa-chalkboard-teacher nav-icon"></i>
                        <p><router-link :to="{ name: 'teachers.data' }">Master Guru</router-link></p>
                        </a>
                    </li>
                    <li class="nav-item" v-if="authenticated.role!=2">
                        <a class="nav-link ml-3">
                        <i class="fas fa-book nav-icon"></i>
                        <p><router-link :to="{ name: 'mapel.data' }">Master Mapel</router-link></p>
                        </a>
                    </li>
                    <li class="nav-item" v-if="authenticated.role!=2">
                        <a class="nav-link ml-3">
                        <i class="fas fa-address-card nav-icon"></i>
                        <p><router-link :to="{ name: 'kelas.data' }">Master Kelas</router-link></p>
                        </a>
                    </li>
                    <li class="nav-item" v-if="authenticated.role!=2">
                        <a class="nav-link ml-3">
                        <i class="fas fa-running nav-icon"></i>
                        <p><router-link :to="{ name: 'kompetensi.data' }">Master Kompetensi</router-link></p>
                        </a>
                    </li>
                    <li class="nav-item" v-if="authenticated.role!=2">
                        <a class="nav-link ml-3">
                        <i class="fas fa-ban nav-icon"></i>
                        <p><router-link :to="{ name: 'masterpelanggarans.data' }">Master Pelanggaran</router-link></p>
                        </a>
                    </li>
                    <li class="nav-item" v-if="authenticated.role!=2">
                        <a class="nav-link ml-3">
                        <i class="fas fa-dolly nav-icon"></i>
                        <p><router-link :to="{ name: 'barang.data' }">Master Barang</router-link></p>
                        </a>
                    </li>
                    <li class="nav-item" v-if="authenticated.role!=2">
                        <a class="nav-link ml-3">
                        <i class="fas fa-university nav-icon"></i>
                        <p><router-link :to="{ name: 'unit.data' }">Master Unit</router-link></p>
                        </a>
                    </li>
                    <li class="nav-item" v-if="authenticated.role!=2">
                        <a class="nav-link ml-3">
                        <i class="fas fa-barcode nav-icon"></i>
                        <p>Master Inventaris</p>
                        </a>
                    </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview"  v-if="authenticated.role != null">
                    <a class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                            <p>
                                Kesiswaan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                    </a>
                    <ul class="nav nav-treeview" >
                        <li class="nav-item">
                            <a class="nav-link ml-3">
                                <i class="fas fa-user-injured nav-icon"></i>
                                <p><router-link :to="{ name: 'absensi.data' }">Absensi</router-link></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ml-3">
                                <i class="fas fa-search-minus nav-icon"></i>
                                <p><router-link :to="{ name: 'presensi.data' }">Presensi</router-link></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ml-3">
                                <i class="fas fa-exclamation-triangle nav-icon"></i>
                                <p><router-link :to="{ name: 'pelanggarans.data' }">Pelanggaran</router-link></p>
                            </a>
                        </li>
                        <li class="nav-item ml-3">
                            <a class="nav-link">
                                <i class="fas fa-ticket-alt nav-icon"></i>
                                <p><router-link :to="{ name: 'kitirsiswa.data' }">Kitir Siswa</router-link></p>
                            </a>
                        </li>
                        <li class="nav-item ml-3">
                            <a class="nav-link">
                                <i class="fas fa-child nav-icon"></i>
                                <p><router-link :to="{ name: 'siswaptm.data' }">Siswa PTM</router-link></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview" v-if="authenticated.role==0 || authenticated.role==2 || authenticated.role==1">
                    <a class="nav-link">
                        <i class="nav-icon fas fa-book-reader"></i>
                            <p>
                                Kurikulum
                                <i class="right fas fa-angle-left"></i>
                            </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ml-3">
                            <a class="nav-link">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p><router-link :to="{ name: 'jurnal.data' }">Jurnal Mengajar</router-link></p>
                            </a>
                        </li>
                        <li class="nav-item" v-if="authenticated.role==0">
                            <a class="nav-link ml-3">
                                <i class="fas fa-chalkboard-teacher nav-icon"></i>
                                <p><router-link :to="{ name: 'jammengajar.data' }">Mengajar</router-link></p>
                            </a>
                        </li>
                        <li class="nav-item" v-if="authenticated.role==0||authenticated.role==2">
                            <a class="nav-link ml-3">
                                <i class="fas fa-spell-check nav-icon"></i>
                                <p><router-link :to="{ name: 'nilaisiswa.data' }">Penilaian</router-link></p>
                            </a>
                        </li>
                        <!-- <li class="nav-item" v-if="authenticated.role!=null">
                            <a class="nav-link ml-3">
                                <i class="fas fa-award nav-icon"></i>
                                <p><router-link :to="{ name: 'rapor.data' }">Rapor</router-link></p>
                            </a>
                        </li> -->
                        <li class="nav-item" v-if="authenticated.role!=null">
                            <a class="nav-link ml-3">
                                <i class="fas fa-award nav-icon"></i>
                                <p><router-link :to="{ name: 'raporakhir.data' }">Rapor</router-link></p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview" v-if="authenticated.role != null">
                    <a class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                            <p>
                                Sarpras
                                <i class="right fas fa-angle-left"></i>
                            </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ml-3">
                            <a class="nav-link">
                                <i class="fas fa-bullhorn nav-icon"></i>
                                <p><router-link :to="{ name: 'laporsarpras.data' }">Lapor</router-link></p>
                            </a>
                        </li>
                        <li class="nav-item" v-if="authenticated.role==0 || authenticated.role==4">
                            <a class="nav-link ml-3">
                                <i class="fas fa-house-damage nav-icon"></i>
                                <p><router-link :to="{ name: 'pelanggarans.data' }">Kerusakan</router-link></p>
                            </a>
                        </li>
                        <li class="nav-item" v-if="authenticated.role==0 || authenticated.role==4">
                            <a class="nav-link ml-3">
                                <i class="fas fa-sign-in-alt nav-icon"></i>
                                <p><router-link :to="{ name: 'barangmasuk.data' }">Barang Masuk</router-link></p>
                            </a>
                        </li>
                        <li class="nav-item" v-if="authenticated.role==0 || authenticated.role==4">
                            <a class="nav-link ml-3">
                                <i class="fas fa-toilet-paper nav-icon"></i>
                                <p><router-link :to="{ name: 'pemakaianbarang.data' }">Permintaan Barang</router-link></p>
                            </a>
                        </li>
                        <li class="nav-item" v-if="authenticated.role!=2">
                            <a class="nav-link ml-3">
                            <i class="fas fa-barcode nav-icon"></i>
                            <p>Inventaris</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview" v-if="authenticated.role==0 || authenticated.role==2 || authenticated.role==1">
                    <a class="nav-link">
                        <i class="nav-icon fas fa-handshake"></i>
                            <p>
                                Humas
                                <i class="right fas fa-angle-left"></i>
                            </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ml-3">
                            <a class="nav-link">
                                <i class="fas fa-bullhorn nav-icon"></i>
                                <p><router-link :to="{ name: 'pengumuman.data' }">Pengumuman</router-link></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview" v-if="authenticated.role==0 || authenticated.role==4">
                    <a class="nav-link">
                        <i class="nav-icon fas fa-mail-bulk"></i>
                            <p>
                                Tata Usaha
                                <i class="right fas fa-angle-left"></i>
                            </p>
                    </a>
                    <ul class="nav nav-treeview" >
                        <li class="nav-item ml-3">
                            <a class="nav-link">
                                <i class="fas fa-tshirt nav-icon"></i>
                                <p><router-link :to="{ name: 'seragam.data' }">Seragam</router-link></p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Laporan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ml-3 has-treeview">
                            <a class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Kesiswaan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item ml-3">
                                    <a class="nav-link">
                                        <i class="nav-icon fas fa-user-injured"></i>
                                        <p><router-link :to="{ name: 'laporan.kesiswaan.absensi' }">Absensi</router-link></p>
                                    </a>
                                </li>
                                <li class="nav-item ml-3">
                                    <a class="nav-link">
                                        <i class="fas fa-exclamation-triangle nav-icon"></i>
                                        <p><router-link :to="{ name: 'laporan.kesiswaan.pelanggaran' }">Pelanggaran</router-link></p>
                                    </a>
                                </li>
                                <li class="nav-item ml-3">
                                    <a class="nav-link">
                                        <i class="nav-icon fas fa-ticket-alt"></i>
                                        <p><router-link :to="{ name: 'laporan.kesiswaan.kitir' }">Kitir</router-link></p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item ml-3 has-treeview">
                            <a class="nav-link">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>
                                    Kurikulum
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item ml-3">
                                    <a class="nav-link">
                                        <i class="fas fa-tasks nav-icon"></i>
                                        <p><router-link :to="{ name: 'rekapjurnal.data' }">Jurnal</router-link></p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview" v-if="authenticated.role==0">
                    <a class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Setting
                                <i class="right fas fa-angle-left"></i>
                            </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ml-3">
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
