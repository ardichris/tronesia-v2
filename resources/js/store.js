import Vue from 'vue'
import Vuex from 'vuex'

//IMPORT MODULE SECTION
import auth from './stores/auth.js'
import home from './stores/home.js'
import siswa from './stores/siswa.js'
import teacher from './stores/teacher.js'
import pelanggaran from './stores/pelanggaran.js'
import masterpelanggaran from './stores/masterpelanggaran.js'
import absensi from './stores/absensi.js'
import mapel from './stores/mapel.js'
import kelas from './stores/kelas.js'
import barang from './stores/barang.js'
import kompetensi from './stores/kompetensi.js'
import jurnal from './stores/jurnal.js'
import user from './stores/user.js'
import pemakaianbarang from './stores/pemakaianbarang.js'
import barangmasuk from './stores/barangmasuk.js'
import seragam from './stores/seragam.js'
import kitirsiswa from './stores/kitirsiswa.js'
import laporsarpras from './stores/laporsarpras.js'
import rekapjurnal from './stores/rekapjurnal.js'
import presensi from './stores/presensi.js'
import pengumuman from './stores/pengumuman.js'

Vue.use(Vuex)

//DEFINE ROOT STORE VUEX
const store = new Vuex.Store({
    //SEMUA MODULE YANG DIBUAT AKAN DITEPATKAN DIDALAM BAGIAN INI DAN DIPISAHKAN DENGAN KOMA UNTUK SETIAP MODULE-NYA
    modules: {
        auth,
        home,
        siswa,
        teacher,
        pelanggaran,
        masterpelanggaran,
        absensi,
        mapel,
        kelas,
        barang,
        kompetensi,
        jurnal,
        user,
        pemakaianbarang,
        barangmasuk,
        seragam,
        kitirsiswa,
        laporsarpras,
        rekapjurnal,
        presensi,
        pengumuman
    },
  	//STATE HAMPIR SERUPA DENGAN PROPERTY DATA DARI COMPONENT HANYA SAJA DAPAT DIGUNAKAN SECARA GLOBAL
    state: {
        //VARIABLE TOKEN MENGAMBIL VALUE DARI LOCAL STORAGE token
        token: localStorage.getItem('token'),
        errors: []
    },
    getters: {
        //KITA MEMBUAT SEBUAH GETTERS DENGAN NAMA isAuth
        //DIMANA GETTERS INI AKAN BERNILAI TRUE/FALSE DENGAN KONDISI BERDASARKAN
        //STATE token.
        isAuth: state => {
            return state.token != "null" && state.token != null
        }
    },
    mutations: {
        //SEBUAH MUTATIONS YANG BERFUNGSI UNTUK MEMANIPULASI VALUE DARI STATE token
        SET_TOKEN(state, payload) {
            state.token = payload
        },
        SET_ERRORS(state, payload) {
            state.errors = payload
        },
        CLEAR_ERRORS(state) {
            state.errors = []
        }
    }
})

export default store