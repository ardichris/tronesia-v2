import $axios from '../api.js'

const state = () => ({
    siswas: [], //UNTUK MENAMPUNG DATA SISWAS YANG DIDAPATKAN DARI DATABASE
    
    //UNTUK MENAMPUNG VALUE DARI FORM INPUTAN NANTINYA
    //STATE INI AKAN DIGUNAKAN PADA FORM ADD SISWA YANG AKAN DIBAHAS KEMUDIAN
    siswa: {
        siswa_nis: '',
        siswa_nisn: '',
        siswa_nik: '',
        siswa_nama: '',
        siswa_kelamin: '',
        siswa_kelas: '',
        siswa_alamat: '',
        siswa_tempatlahir: '',
        siswa_tanggallahir: '',
        siswa_tinggi: '',
        siswa_berat: '',
        siswa_status: '',
        siswa_sekolahasal: '',
        siswa_notelp: '',
        siswa_nohandphone: '',
        siswa_poin: '',
        siswa_anakke: '',
        siswa_namaibu: '',
        siswa_ttlibu: '',
        siswa_nikibu: '',
        siswa_pekerjaanibu: '',
        siswa_namaayah: '',
        siswa_ttlayah: '',
        siswa_alamatortu:'',
        siswa_wali:'',
        siswa_pekerjaanwali:''
    },
    page: 1 //UNTUK MENCATAT PAGE PAGINATE YANG SEDANG DIAKSES
})

const mutations = {
    //MEMASUKKAN DATA KE STATE SISWAS
    ASSIGN_DATA(state, payload) {
        state.siswas = payload
    },
    //MENGUBAH DATA STATE PAGE
    SET_PAGE(state, payload) {
        state.page = payload
    },
    //MENGUBAH DATA STATE SISWA
    ASSIGN_FORM(state, payload) {
        state.siswa = {
            siswa_nis: payload.siswa_nis,
            siswa_nisn: payload.siswa_nisn,
            siswa_nik: payload.siswa_nik,
            siswa_nama: payload.siswa_nama,
            siswa_kelamin: payload.siswa_kelamin,
            siswa_kelas: payload.siswa_kelas,
            siswa_alamat: payload.siswa_alamat,
            siswa_tempatlahir: payload.siswa_tempatlahir,
            siswa_tanggallahir: payload.siswa_tanggallahir,
            siswa_tinggi: payload.siswa_tinggi,
            siswa_berat: payload.siswa_berat,
            siswa_status: payload.siswa_status,
            siswa_sekolahasal: payload.siswa_sekolahasal,
            siswa_notelp: payload.siswa_notelp,
            siswa_nohandphone: payload.siswa_nohandphone,
            siswa_poin: payload.siswa_poin,
            siswa_anakke: payload.siswa_anakke,
            siswa_namaibu: payload.siswa_namaibu,
            siswa_ttlibu: payload.siswa_ttlibu,
            siswa_nikibu: payload.siswa_nikibu,
            siswa_pekerjaanibu: payload.siswa_pekerjaanibu,
            siswa_namaayah: payload.siswa_namaayah,
            siswa_ttlayah: payload.siswa_ttlayah,
            siswa_alamatortu: payload.siswa_alamatortu,
            siswa_wali: payload.siswa_wali,
            siswa_pekerjaanwali: payload.siswa_pekerjaanwali
        }
    },
    //ME-RESET STATE SISWA MENJADI KOSONG
    CLEAR_FORM(state) {
        state.siswa = {
            siswa_nis: '',
            siswa_nisn: '',
            siswa_nik: '',
            siswa_nama: '',
            siswa_kelamin: '',
            siswa_kelas: '',
            siswa_alamat: '',
            siswa_tempatlahir: '',
            siswa_tanggallahir: '',
            siswa_tinggi: '',
            siswa_berat: '',
            siswa_status: '',
            siswa_sekolahasal: '',
            siswa_notelp: '',
            siswa_nohandphone: '',
            siswa_poin: '',
            siswa_anakke: '',
            siswa_namaibu: '',
            siswa_ttlibu: '',
            siswa_nikibu: '',
            siswa_pekerjaanibu: '',
            siswa_namaayah: '',
            siswa_ttlayah: '',
            siswa_alamatortu:'',
            siswa_wali:'',
            siswa_pekerjaanwali:''
        }
    }
}

const actions = {
    //FUNGSI INI UNTUK MELAKUKAN REQUEST DATA SISWA DARI SERVER
    getSiswas({ commit, state }, payload) {
        //MENGECEK PAYLOAD ADA ATAU TIDAK
        let search = typeof payload != 'undefined' ? payload:''
        //let search = payload.search
        //payload.loading(true)
        return new Promise((resolve, reject) => {
            //REQUEST DATA DENGAN ENDPOINT /SISWAS
            $axios.get(`/siswas?page=${state.page}&q=${search}`)
            .then((response) => {
                //SIMPAN DATA KE STATE MELALUI MUTATIONS
                commit('ASSIGN_DATA', response.data)
                //payload.loading(false)
                resolve(response.data)
            })
        })
    },
    //FUNGSI UNTUK MENAMBAHKAN DATA BARU
    submitSiswa({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            //MENGIRIMKAN PERMINTAAN KE SERVER DAN MELAMPIRKAN DATA YANG AKAN DISIMPAN
            //DARI STATE SISWA
            $axios.post(`/siswas`, state.siswa)
            .then((response) => {
                //APABILA BERHASIL KITA MELAKUKAN REQUEST LAGI
                //UNTUK MENGAMBIL DATA TERBARU
                dispatch('getSiswas').then(() => {
                    resolve(response.data)
                })
            })
            .catch((error) => {
                //APABILA TERJADI ERROR VALIDASI
                //DIMANA LARAVEL MENGGUNAKAN CODE 422
                if (error.response.status == 422) {
                    //MAKA LIST ERROR AKAN DIASSIGN KE STATE ERRORS
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
            })
        })
    },
    //UNTUK MENGAMBIL SINGLE DATA DARI SERVER BERDASARKAN CODE SISWA
    editSiswa({ commit }, payload) {
        return new Promise((resolve, reject) => {
            //MELAKUKAN REQUEST DENGAN MENGIRIMKAN CODE SISWA DI URL
            $axios.get(`/siswas/${payload}/edit`)
            .then((response) => {
                //APABIL BERHASIL, DI ASSIGN KE FORM
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    viewSiswa({ commit }, payload) {
        return new Promise((resolve, reject) => {
            //MELAKUKAN REQUEST DENGAN MENGIRIMKAN CODE SISWA DI URL
            $axios.get(`/siswas/${payload}/edit`)
            .then((response) => {
                //APABIL BERHASIL, DI ASSIGN KE FORM
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    //UNTUK MENGUPDATE DATA BERDASARKAN CODE YANG SEDANG DIEDIT
    updateSiswa({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            //MELAKUKAN REQUEST DENGAN MENGIRIMKAN CODE DIURL
            //DAN MENGIRIMKAN DATA TERBARU YANG TELAH DIEDIT
            //MELALUI STATE SISWA
            $axios.put(`/siswas/${payload}`, state.siswa)
            .then((response) => {
                //FORM DIBERSIHKAN
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    } ,
    //MENGHAPUS DATA 
    removeSiswa({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            //MENGIRIM PERMINTAAN KE SERVER UNTUK MENGHAPUS DATA
            //DENGAN METHOD DELETE DAN ID SISWA DI URL
            $axios.delete(`/siswas/${payload}`)
            .then((response) => {
                //APABILA BERHASIL, FETCH DATA TERBARU DARI SERVER
                dispatch('getSiswas').then(() => resolve())
            })
        })
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}