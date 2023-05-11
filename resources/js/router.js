import Vue from 'vue'
import Router from 'vue-router'
import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import store from './store.js'
import IndexBarang from './pages/barangs/Index.vue'
import DataBarang from './pages/barangs/Barang.vue'
import AddBarang from './pages/barangs/Add.vue'
import EditBarang from './pages/barangs/Edit.vue'
import IndexInventory from './pages/inventories/Index.vue'
import DataInventory from './pages/inventories/Inventory.vue'
import AddInventory from './pages/inventories/Add.vue'
import EditInventory from './pages/inventories/Edit.vue'
import IndexDelivery from './pages/deliveries/Index.vue'
import DataDelivery from './pages/deliveries/Delivery.vue'
import AddDelivery from './pages/deliveries/Add.vue'
import EditDelivery from './pages/deliveries/Edit.vue'
import IndexPemakaianBarang from './pages/pemakaianbarangs/Index.vue'
import DataPemakaianBarang from './pages/pemakaianbarangs/PemakaianBarang.vue'
import AddPemakaianBarang from './pages/pemakaianbarangs/Add.vue'
import EditPemakaianBarang from './pages/pemakaianbarangs/Edit.vue'
import IndexBarangMasuk from './pages/barangmasuks/Index.vue'
import DataBarangMasuk from './pages/barangmasuks/BarangMasuk.vue'
import AddBarangMasuk from './pages/barangmasuks/Add.vue'
import EditBarangMasuk from './pages/barangmasuks/Edit.vue'
import IndexSeragam from './pages/seragams/Index.vue'
import DataSeragam from './pages/seragams/Seragam.vue'
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
import IndexMasterPelanggaran from './pages/masterpelanggarans/Index.vue'
import DataMasterPelanggaran from './pages/masterpelanggarans/MasterPelanggaran.vue'
import AddMasterPelanggaran from './pages/masterpelanggarans/Add.vue'
import EditMasterPelanggaran from './pages/masterpelanggarans/Edit.vue'
import ViewMasterPelanggaran from './pages/masterpelanggarans/View.vue'
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
import IndexLingkupMateri from './pages/lingkupmateris/Index.vue'
import DataLingkupMateri from './pages/lingkupmateris/LingkupMateri.vue'
import IndexKelas from './pages/kelas/Index.vue'
import DataKelas from './pages/kelas/Kelas.vue'
import AddKelas from './pages/kelas/Add.vue'
import EditKelas from './pages/kelas/Edit.vue'
import ViewKelas from './pages/kelas/View.vue'
import IndexJurnal from './pages/jurnals/Index.vue'
import DataJurnal from './pages/jurnals/Jurnal.vue'
import AddJurnal from './pages/jurnals/Add.vue'
import EditJurnal from './pages/jurnals/Edit.vue'
import ViewJurnal from './pages/jurnals/Edit.vue'
import Setting from './pages/setting/Index.vue'
import SetPermission from './pages/setting/roles/SetPermission.vue'
import IndexLaporSarpras from './pages/laporsarpras/Index.vue'
import DataLaporSarpras from './pages/laporsarpras/LaporSarpras.vue'
import IndexKitirSiswa from './pages/kitirsiswas/Index.vue'
import DataKitirSiswa from './pages/kitirsiswas/KitirSiswa.vue'
import IndexRekapJurnal from './pages/rekapjurnals/Index.vue'
import DataRekapJurnal from './pages/rekapjurnals/RekapJurnal.vue'
import IndexPresensi from './pages/presensis/Index.vue'
import DataPresensi from './pages/presensis/Presensi.vue'
import IndexPengumuman from './pages/pengumumans/Index.vue'
import DataPengumuman from './pages/pengumumans/Pengumuman.vue'
import IndexUnit from './pages/units/Index.vue'
import DataUnit from './pages/units/Unit.vue'
import AddUnit from './pages/units/Add.vue'
import EditUnit from './pages/units/Edit.vue'
import ViewUnit from './pages/units/View.vue'
import DataNilaiSiswa from './pages/nilaisiswa/NilaiSiswa.vue'
import DataNilaiSiswaKurMer from './pages/nilaisiswa/NilaiSiswaKurmer.vue'
import IndexNilaiSiswa from './pages/nilaisiswa/Index.vue'
import AddNilaiSiswa from './pages/nilaisiswa/Add.vue'
import EditNilaiSiswa from './pages/nilaisiswa/Edit.vue'
import ViewNilaiSiswa from './pages/nilaisiswa/View.vue'
import IndexJamMengajar from './pages/jammengajar/Index.vue'
import DataJamMengajar from './pages/jammengajar/JamMengajar.vue'
import AddJamMengajar from './pages/jammengajar/Add.vue'
import EditJamMengajar from './pages/jammengajar/Edit.vue'
import ViewJamMengajar from './pages/jammengajar/View.vue'
import DataJadwalPelajaran from './pages/jammengajar/JadwalPelajaran.vue'
import DataRapor from './pages/rapor/Rapor.vue'
import IndexRapor from './pages/rapor/Index.vue'
import AddRapor from './pages/rapor/Add.vue'
import EditRapor from './pages/rapor/Edit.vue'
import ViewRapor from './pages/rapor/View.vue'
import DataRaporAkhir from './pages/raporakhir/RaporAkhir.vue'
import IndexRaporAkhir from './pages/raporakhir/Index.vue'
import DataSiswaPTM from './pages/siswaptm/SiswaPTM.vue'
import IndexSiswaPTM from './pages/siswaptm/Index.vue'
import LaporanKesiswaan from './pages/laporans/kesiswaan/Kesiswaan.vue'
import LaporanKesiswaanAbsensi from './pages/laporans/kesiswaan/Absensi.vue'
import LaporanKesiswaanPelanggaran from './pages/laporans/kesiswaan/Pelanggaran.vue'
import LaporanKesiswaanKitir from './pages/laporans/kesiswaan/Kitir.vue'
import LaporanKurikulum from './pages/laporans/kurikulum/Kurikulum.vue'
import LaporanKurikulumNilaisiswa from './pages/laporans/kurikulum/Nilai.vue'
import LaporanPembayaranPSB from './pages/laporans/psb/Pembayaran.vue'
import LaporanDaftarUlangPSB from './pages/laporans/psb/DaftarUlang.vue'
import PenerimaanSiswa from './pages/penerimaansiswas/PenerimaanSiswa.vue'
import PenerimaanSiswaDaftarUlang from './pages/penerimaansiswas/DaftarUlang.vue'
import PenerimaanSiswaPembayaran from './pages/penerimaansiswas/Pembayaran.vue'
import DataPancasilaProject from './pages/pancasilaprojects/PancasilaProject.vue'
import IndexPancasilaProject from './pages/pancasilaprojects/Index.vue'


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
            path: '/rekapjurnal',
            component: IndexRekapJurnal,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'rekapjurnal.data',
                    component: DataRekapJurnal,
                    meta: { title: 'Rekap Jurnal' }
                }
            ]
        },
        {
            path: '/presensi',
            component: IndexPresensi,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'presensi.data',
                    component: DataPresensi,
                    meta: { title: 'Presensi' }
                }
            ]
        },
        {
            path: '/pengumuman',
            component: IndexPengumuman,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'pengumuman.data',
                    component: DataPengumuman,
                    meta: { title: 'Pengumuman' }
                }
            ]
        },
        {
            path: '/seragam',
            component: IndexSeragam,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'seragam.data',
                    component: DataSeragam,
                    meta: { title: 'Daftar Seragam' }
                }
            ]
        },
        {
            path: '/laporsarpras',
            component: IndexLaporSarpras,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'laporsarpras.data',
                    component: DataLaporSarpras,
                    meta: { title: 'Daftar Lapor' }
                }
            ]
        },
        {
            path: '/kitirsiswa',
            component: IndexKitirSiswa,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'kitirsiswa.data',
                    component: DataKitirSiswa,
                    meta: { title: 'Daftar Kitir Siswa' }
                }
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
                    meta: { title: 'Daftar Permintaan' }
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
            path: '/inventories',
            component: IndexInventory,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'inventories.data',
                    component: DataInventory,
                    meta: { title: 'Daftar Inventaris' }
                },
                {
                    path: 'add',
                    name: 'inventories.add',
                    component: AddInventory,
                    meta: { title: 'Tambah Inventaris' }
                },
                {
                    path: 'view/:id',
                    name: 'inventories.view',
                    component: EditInventory,
                    meta: { title: 'View Inventaris' }
                },
                {
                    path: 'edit/:id',
                    name: 'inventories.edit',
                    component: EditInventory,
                    meta: { title: 'Edit Inventaris' }
                }
            ]
        },
        {
            path: '/deliveries',
            component: IndexDelivery,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'deliveries.data',
                    component: DataDelivery,
                    meta: { title: 'Daftar Delivery' }
                },
                {
                    path: 'add',
                    name: 'deliveries.add',
                    component: AddDelivery,
                    meta: { title: 'Tambah Delivery' }
                },
                {
                    path: 'view/:id',
                    name: 'deliveries.view',
                    component: EditDelivery,
                    meta: { title: 'View Delivery' }
                },
                {
                    path: 'edit/:id',
                    name: 'deliveries.edit',
                    component: EditDelivery,
                    meta: { title: 'Edit Delivery' }
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
            path: '/masterpelanggarans',
            component: IndexMasterPelanggaran,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'masterpelanggarans.data',
                    component: DataMasterPelanggaran,
                    meta: { title: 'Daftar Pelanggaran' }
                },
                {
                    path: 'add',
                    name: 'masterpelanggarans.add',
                    component: AddMasterPelanggaran,
                    meta: { title: 'Tambah Pelanggaran' }
                },
                {
                    path: 'edit/:id',
                    name: 'masterpelanggarans.edit',
                    component: EditMasterPelanggaran,
                    meta: { title: 'Ganti Pelanggaran' }
                },
                {
                    path: 'view/:id',
                    name: 'masterpelanggarans.view',
                    component: ViewMasterPelanggaran,
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
            path: '/unit',
            component: IndexUnit,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'unit.data',
                    component: DataUnit,
                    meta: { title: 'Daftar Unit' }
                },
                {
                    path: 'add',
                    name: 'unit.add',
                    component: AddUnit,
                    meta: { title: 'Tambah Unit' }
                },
                {
                    path: 'edit/:id',
                    name: 'unit.edit',
                    component: EditUnit,
                    meta: { title: 'Ganti Unit' }
                },
                {
                    path: 'view/:id',
                    name: 'unit.view',
                    component: ViewUnit,
                    meta: { title: 'Lihat Unit' }
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
            path: '/lingkupmateri',
            component: IndexLingkupMateri,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'lingkupmateri.data',
                    component: DataLingkupMateri,
                    meta: { title: 'Daftar Lingkup Materi' }
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
        {
            path: '/nilaisiswa',
            component: IndexNilaiSiswa,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'nilaisiswa.data',
                    component: DataNilaiSiswa,
                    meta: { title: 'Daftar Nilai Siswa' }
                },
                {
                    path: 'kurmer',
                    name: 'nilaisiswa.kurmer',
                    component: DataNilaiSiswaKurMer,
                    meta: { title: 'Daftar Nilai Siswa KurMer' }
                },
                {
                    path: 'add',
                    name: 'nilaisiswa.add',
                    component: AddNilaiSiswa,
                    meta: { title: 'Tambah Nilai Siswa' }
                },
                {
                    path: 'edit/:id',
                    name: 'nilaisiswa.edit',
                    component: EditNilaiSiswa,
                    meta: { title: 'Ganti Nilai Siswa' }
                },
                {
                    path: 'view/:id',
                    name: 'nilaisiswa.view',
                    component: ViewNilaiSiswa,
                    meta: { title: 'Lihat Nilai Siswa' }
                }
            ]
        },
        {
            path: '/jammengajar',
            component: IndexJamMengajar,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'jammengajar.data',
                    component: DataJamMengajar,
                    meta: { title: 'Daftar Jam Mengajar' }
                },
                {
                    path: 'jadwalpelajaran',
                    name: 'jammengajar.jadwalpelajaran',
                    component: DataJadwalPelajaran,
                    meta: { title: 'Jadwal Pelajaran' }
                },
                {
                    path: 'add',
                    name: 'jammengajar.add',
                    component: AddJamMengajar,
                    meta: { title: 'Tambah Jam Mengajar' }
                },
                {
                    path: 'edit/:id',
                    name: 'jammengajar.edit',
                    component: EditJamMengajar,
                    meta: { title: 'Ganti Jam Mengajar' }
                },
                {
                    path: 'view/:id',
                    name: 'jammengajar.view',
                    component: ViewJamMengajar,
                    meta: { title: 'Lihat Jam Mengajar' }
                }
            ]
        },
        {
            path: '/rapor',
            component: IndexRapor,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'rapor.data',
                    component: DataRapor,
                    meta: { title: 'Daftar Rapor' }
                },
                {
                    path: 'add',
                    name: 'rapor.add',
                    component: AddRapor,
                    meta: { title: 'Tambah Rapor' }
                },
                {
                    path: 'edit/:id',
                    name: 'rapor.edit',
                    component: EditRapor,
                    meta: { title: 'Ganti Rapor' }
                },
                {
                    path: 'view/:id',
                    name: 'rapor.view',
                    component: ViewRapor,
                    meta: { title: 'Lihat Rapor' }
                }
            ]
        },
        {
            path: '/raporakhir',
            component: IndexRaporAkhir,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'raporakhir.data',
                    component: DataRaporAkhir,
                    meta: { title: 'Rapor Akhir' }
                }
            ]

        },
        {
            path: '/siswaptm',
            component: IndexSiswaPTM,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'siswaptm.data',
                    component: DataSiswaPTM,
                    meta: { title: 'Siswa PTM' }
                }
            ]

        },
        {
            path: '/laporan/kesiswaan',
            component: LaporanKesiswaan,
            meta: { requiresAuth: true },
            children: [
                {
                    path: 'absensi',
                    name: 'laporan.kesiswaan.absensi',
                    component: LaporanKesiswaanAbsensi,
                    meta: { title: 'Laporan Absensi' }
                },
                {
                    path: 'pelanggaran',
                    name: 'laporan.kesiswaan.pelanggaran',
                    component: LaporanKesiswaanPelanggaran,
                    meta: { title: 'Laporan Pelanggaran' }
                },
                {
                    path: 'kitir',
                    name: 'laporan.kesiswaan.kitir',
                    component: LaporanKesiswaanKitir,
                    meta: { title: 'Laporan Kitir' }
                },

            ]
        },
        {
            path: '/laporan/kurikulum',
            component: LaporanKurikulum,
            meta: { requiresAuth: true },
            children: [
                {
                    path: 'nilaisiswa',
                    name: 'laporan.kurikulum.nilaisiswa',
                    component: LaporanKurikulumNilaisiswa,
                    meta: { title: 'Laporan Nilai Siswa' }
                }
            ]
        },
        {
            path: '/penerimaansiswa/',
            component: PenerimaanSiswa,
            meta: { requiresAuth: true },
            children: [
                {
                    path: 'pembayaran',
                    name: 'penerimaansiswa.pembayaran',
                    component: PenerimaanSiswaPembayaran,
                    meta: { title: 'Pembayaran PSB' }
                },
                {
                    path: 'daftarulang',
                    name: 'penerimaansiswa.daftarulang',
                    component: PenerimaanSiswaDaftarUlang,
                    meta: { title: 'Daftar Ulang PSB' }
                },
                {
                    path: 'laporanpembayaran',
                    name: 'laporan.psb.pembayaran',
                    component: LaporanPembayaranPSB,
                    meta: { title: 'Laporan Pembayaran PSB' }
                },
                {
                    path: 'laporandaftarulang',
                    name: 'laporan.psb.daftarulang',
                    component: LaporanDaftarUlangPSB,
                    meta: { title: 'Laporan Daftar Ulang PSB' }
                }
            ]
        },
        {
            path: '/pancasilaproject',
            component: IndexPancasilaProject,
            meta: { requiresAuth: true },
            children: [
                {
                    path: '',
                    name: 'pancasilaproject.data',
                    component: DataPancasilaProject,
                    meta: { title: 'Daftar Proyek Pancasila' }
                },
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
