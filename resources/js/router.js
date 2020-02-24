import Vue from 'vue'
import Router from 'vue-router'
import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import store from './store.js'
import IndexBarang from './pages/barangs/Index.vue'
import DataBarang from './pages/barangs/Barang.vue'
import AddBarang from './pages/barangs/Add.vue'
import EditBarang from './pages/barangs/Edit.vue'
import IndexPemakaianBarang from './pages/pemakaianbarangs/Index.vue'
import DataPemakaianBarang from './pages/pemakaianbarangs/PemakaianBarang.vue'
import AddPemakaianBarang from './pages/pemakaianbarangs/Add.vue'
import EditPemakaianBarang from './pages/pemakaianbarangs/Edit.vue'
import IndexBarangMasuk from './pages/barangmasuks/Index.vue'
import DataBarangMasuk from './pages/barangmasuks/BarangMasuk.vue'
import AddBarangMasuk from './pages/barangmasuks/Add.vue'
import EditBarangMasuk from './pages/barangmasuks/Edit.vue'
import IndexSiswa from './pages/siswas/Index.vue'
import DataSiswa from './pages/siswas/Siswa.vue'
import AddSiswa from './pages/siswas/Add.vue'
import EditSiswa from './pages/siswas/Edit.vue'
import ViewSiswa from './pages/siswas/View.vue'
import AddTeachers from './pages/teachers/Add.vue'
import EditTeachers from './pages/teachers/Edit.vue'
import ViewTeachers from './pages/teachers/View.vue'
import IndexTeacher from './pages/teachers/Index.vue'
import DataTeachers from './pages/teachers/Teacher.vue'
import IndexPelanggaran from './pages/pelanggarans/Index.vue'
import DataPelanggaran from './pages/pelanggarans/Pelanggaran.vue'
import AddPelanggaran from './pages/pelanggarans/Add.vue'
import EditPelanggaran from './pages/pelanggarans/Edit.vue'
import ViewPelanggaran from './pages/pelanggarans/View.vue'
import IndexAbsensi from './pages/absensis/Index.vue'
import DataAbsensi from './pages/absensis/Absensi.vue'
import AddAbsensi from './pages/absensis/Add.vue'
import EditAbsensi from './pages/absensis/Edit.vue'
import ViewAbsensi from './pages/absensis/View.vue'
import IndexMapel from './pages/mapels/Index.vue'
import DataMapel from './pages/mapels/Mapel.vue'
import AddMapel from './pages/mapels/Add.vue'
import EditMapel from './pages/mapels/Edit.vue'
import ViewMapel from './pages/mapels/View.vue'
import IndexKompetensi from './pages/kompetensis/Index.vue'
import DataKompetensi from './pages/kompetensis/Kompetensi.vue'
import AddKompetensi from './pages/kompetensis/Add.vue'
import EditKompetensi from './pages/kompetensis/Edit.vue'
import ViewKompetensi from './pages/kompetensis/View.vue'
import IndexKelas from './pages/kelas/Index.vue'
import DataKelas from './pages/kelas/Kelas.vue'
import AddKelas from './pages/kelas/Add.vue'
import EditKelas from './pages/kelas/Edit.vue'
import ViewKelas from './pages/kelas/View.vue'
import IndexJurnal from './pages/jurnals/Index.vue'
import DataJurnal from './pages/jurnals/Jurnal.vue'
import AddJurnal from './pages/jurnals/Add.vue'
import EditJurnal from './pages/jurnals/Edit.vue'
import ViewJurnal from './pages/jurnals/View.vue'
import Setting from './pages/setting/Index.vue'
import SetPermission from './pages/setting/roles/SetPermission.vue'


Vue.use(Router)

//DEFINE ROUTE
const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: { requiresAuth: true }
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/setting',
            component: Setting,
            meta: { requiresAuth: true },
            children: [
                {
                    path: 'role-permission',
                    name: 'role.permissions',
                    component: SetPermission,
                    meta: { title: 'Set Permissions' }
                },
            ]
        },
        {
            path: '/barangmasuk',
            component: IndexBarangMasuk,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'barangmasuk.data',
                    component: DataBarangMasuk,
                    meta: { title: 'Daftar Barang Masuk' }
                },
                {
                    path: 'add',
                    name: 'barangmasuk.add',
                    component: AddBarangMasuk,
                    meta: { title: 'Tambah Barang Masuk' }
                },
                {
                    path: 'edit/:id',
                    name: 'barangmasuk.edit',
                    component: EditBarangMasuk,
                    meta: { title: 'Edit Barang Masuk' }
                }                
            ]
        },
        {
            path: '/pemakaianbarang',
            component: IndexPemakaianBarang,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'pemakaianbarang.data',
                    component: DataPemakaianBarang,
                    meta: { title: 'Daftar Pemakaian' }
                },
                {
                    path: 'add',
                    name: 'pemakaianbarang.add',
                    component: AddPemakaianBarang,
                    meta: { title: 'Tambah Barang' }
                },
                {
                    path: 'view/:id',
                    name: 'pemakaianbarang.view',
                    component: EditPemakaianBarang,
                    meta: { title: 'View Barang' }
                },
                {
                    path: 'edit/:id',
                    name: 'pemakaianbarang.edit',
                    component: EditPemakaianBarang,
                    meta: { title: 'Edit Barang' }
                }
            ]
        },
        {
            path: '/barang',
            component: IndexBarang,
            meta: { requiresAuth: false },
            children: [
                {
                    path: '',
                    name: 'barang.data',
                    component: DataBarang,
                    meta: { title: 'Daftar Barang' }
                },
                {
                    path: 'add',
                    name: 'barang.add',
                    component: AddBarang,
                    meta: { title: 'Tambah Barang' }
                },
                {
                    path: 'view/:id',
                    name: 'barang.view',
                    component: EditBarang,
                    meta: { title: 'View Barang' }
                },
                {
                    path: 'edit/:id',
                    name: 'barang.edit',
                    component: EditBarang,
                    meta: { title: 'Edit Barang' }
                }
            ]
        },
        {
            path: '/siswas',
            component: IndexSiswa,
            meta: { requiresAuth: false },
            children: [
                {
                    path: '',
                    name: 'siswas.data',
                    component: DataSiswa,
                    meta: { title: 'Daftar Siswa' }
                },
                {
                    path: 'add',
                    name: 'siswas.add',
                    component: AddSiswa,
                    meta: { title: 'Tambah Siswa' }
                },
                {
                    path: 'view/:id',
                    name: 'siswas.view',
                    component: ViewSiswa,
                    meta: { title: 'View Siswa' }
                },
                {
                    path: 'edit/:id',
                    name: 'siswas.edit',
                    component: EditSiswa,
                    meta: { title: 'Edit Siswa' }
                }
            ]
        },
        {
            path: '/teachers',
            component: IndexTeacher,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'teachers.data',
                    component: DataTeachers,
                    meta: { title: 'Daftar Teachers' }
                },
                {
                    path: 'add',
                    name: 'teachers.add',
                    component: AddTeachers,
                    meta: { title: 'Tambah Teacher' }
                },
                {
                    path: 'edit/:id',
                    name: 'teachers.edit',
                    component: EditTeachers,
                    meta: { title: 'Edit Teacher' }
                },
                {
                    path: 'view/:id',
                    name: 'teachers.view',
                    component: ViewTeachers,
                    meta: { title: 'View Teacher' }
                },
            ]
        },
        {
            path: '/pelanggarans',
            component: IndexPelanggaran,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'pelanggarans.data',
                    component: DataPelanggaran,
                    meta: { title: 'Daftar Pelanggaran' }
                },
                {
                    path: 'add',
                    name: 'pelanggarans.add',
                    component: AddPelanggaran,
                    meta: { title: 'Tambah Pelanggaran' }
                },
                {
                    path: 'edit/:id',
                    name: 'pelanggarans.edit',
                    component: EditPelanggaran,
                    meta: { title: 'Ganti Pelanggaran' }
                },
                {
                    path: 'view/:id',
                    name: 'pelanggarans.view',
                    component: ViewPelanggaran,
                    meta: { title: 'Lihat Pelanggaran' }
                },
            ]
        },
        {
            path: '/absensi',
            component: IndexAbsensi,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'absensi.data',
                    component: DataAbsensi,
                    meta: { title: 'Daftar Absensi' }
                },
                {
                    path: 'add',
                    name: 'absensi.add',
                    component: AddAbsensi,
                    meta: { title: 'Tambah Absensi' }
                },
                {
                    path: 'edit/:id',
                    name: 'absensi.edit',
                    component: EditAbsensi,
                    meta: { title: 'Ganti Absensi' }
                },
                {
                    path: 'view/:id',
                    name: 'absensi.view',
                    component: ViewAbsensi,
                    meta: { title: 'Lihat Absensi' }
                },
            ]
        },
        {
            path: '/mapel',
            component: IndexMapel,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'mapel.data',
                    component: DataMapel,
                    meta: { title: 'Daftar Mapel' }
                },
                {
                    path: 'add',
                    name: 'mapel.add',
                    component: AddMapel,
                    meta: { title: 'Tambah Mapel' }
                },
                {
                    path: 'edit/:id',
                    name: 'mapel.edit',
                    component: EditMapel,
                    meta: { title: 'Ganti Mapel' }
                },
                {
                    path: 'view/:id',
                    name: 'mapel.view',
                    component: ViewMapel,
                    meta: { title: 'Lihat Mapel' }
                }
            ]
        },
        {
            path: '/kompetensi',
            component: IndexKompetensi,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'kompetensi.data',
                    component: DataKompetensi,
                    meta: { title: 'Daftar Kompetensi' }
                },
                {
                    path: 'add',
                    name: 'kompetensi.add',
                    component: AddKompetensi,
                    meta: { title: 'Tambah Kompetensi' }
                },
                {
                    path: 'edit/:id',
                    name: 'kompetensi.edit',
                    component: EditKompetensi,
                    meta: { title: 'Ganti Kompetensi' }
                },
                {
                    path: 'view/:id',
                    name: 'kompetensi.view',
                    component: ViewKompetensi,
                    meta: { title: 'Lihat Kompetensi' }
                }
            ]
        },
        {
            path: '/kelas',
            component: IndexKelas,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'kelas.data',
                    component: DataKelas,
                    meta: { title: 'Daftar Kelas' }
                },
                {
                    path: 'add',
                    name: 'kelas.add',
                    component: AddKelas,
                    meta: { title: 'Tambah Kelas' }
                },
                {
                    path: 'edit/:id',
                    name: 'kelas.edit',
                    component: EditKelas,
                    meta: { title: 'Ganti Kelas' }
                },
                {
                    path: 'view/:id',
                    name: 'kelas.view',
                    component: ViewKelas,
                    meta: { title: 'Lihat Kelas' }
                }
            ]
        }, 
        {
            path: '/jurnal',
            component: IndexJurnal,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'jurnal.data',
                    component: DataJurnal,
                    meta: { title: 'Daftar Jurnal' }
                },
                {
                    path: 'add',
                    name: 'jurnal.add',
                    component: AddJurnal,
                    meta: { title: 'Tambah Jurnal' }
                },
                {
                    path: 'edit/:id',
                    name: 'jurnal.edit',
                    component: EditJurnal,
                    meta: { title: 'Ganti Jurnal' }
                },
                {
                    path: 'view/:id',
                    name: 'jurnal.view',
                    component: ViewJurnal,
                    meta: { title: 'Lihat Jurnal' }
                }
            ]
        },     
    ]
});

//Navigation Guards
router.beforeEach((to, from, next) => {
    store.commit('CLEAR_ERRORS')
    if (to.matched.some(record => record.meta.requiresAuth)) {
        let auth = store.getters.isAuth
        if (!auth) {
            next({ name: 'login' })
        } else {
            next()
        }
    } else {
        next()
    }
})

export default router