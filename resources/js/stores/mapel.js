import $axios from '../api.js'

const state = () => ({
    mapels: [], //UNTUK MENAMPUNG DATA SISWAS YANG DIDAPATKAN DARI DATABASE
    
    //UNTUK MENAMPUNG VALUE DARI FORM INPUTAN NANTINYA
    //STATE INI AKAN DIGUNAKAN PADA FORM ADD SISWA YANG AKAN DIBAHAS KEMUDIAN
    mapel: {
        mapel_kode: '',
        mapel_nama: ''
    },
    page: 1 //UNTUK MENCATAT PAGE PAGINATE YANG SEDANG DIAKSES
})

const mutations = {
    //MEMASUKKAN DATA KE STATE SISWAS
    ASSIGN_DATA(state, payload) {
        state.mapels = payload
    },
    //MENGUBAH DATA STATE PAGE
    SET_PAGE(state, payload) {
        state.page = payload
    },
    //MENGUBAH DATA STATE SISWA
    ASSIGN_FORM(state, payload) {
        state.mapel = {
            mapel_kode: payload.mapel_kode,
            mapel_nama: payload.mapel_nama
        }
    },
    //ME-RESET STATE SISWA MENJADI KOSONG
    CLEAR_FORM(state) {
        state.mapel = {
            mapel_kode: '',
            mapel_nama: ''
        }
    }
}

const actions = {
    //FUNGSI INI UNTUK MELAKUKAN REQUEST DATA SISWA DARI SERVER
    getMapel({ commit, state }, payload) {
        //MENGECEK PAYLOAD ADA ATAU TIDAK
        let search = typeof payload != 'undefined' ? payload:''
        //let search = payload.search
        //payload.loading(true)
        return new Promise((resolve, reject) => {
            //REQUEST DATA DENGAN ENDPOINT /SISWAS
            $axios.get(`/mapel?page=${state.page}&q=${search}`)
            .then((response) => {
                //SIMPAN DATA KE STATE MELALUI MUTATIONS
                commit('ASSIGN_DATA', response.data)
                //payload.loading(false)
                resolve(response.data)
            })
        })
    },
    //FUNGSI UNTUK MENAMBAHKAN DATA BARU
    submitMapel({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            //MENGIRIMKAN PERMINTAAN KE SERVER DAN MELAMPIRKAN DATA YANG AKAN DISIMPAN
            //DARI STATE SISWA
            console.log(state.mapel);
            $axios.post(`/mapel`, state.mapel)
            .then((response) => {
                //APABILA BERHASIL KITA MELAKUKAN REQUEST LAGI
                //UNTUK MENGAMBIL DATA TERBARU
                dispatch('getMapel').then(() => {
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
    editMapel({ commit }, payload) {
        return new Promise((resolve, reject) => {
            //MELAKUKAN REQUEST DENGAN MENGIRIMKAN CODE SISWA DI URL
            $axios.get(`/mapel/${payload}/edit`)
            .then((response) => {
                //APABIL BERHASIL, DI ASSIGN KE FORM
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    viewMapel({ commit }, payload) {
        return new Promise((resolve, reject) => {
            //MELAKUKAN REQUEST DENGAN MENGIRIMKAN CODE SISWA DI URL
            $axios.get(`/mapel/${payload}/edit`)
            .then((response) => {
                //APABIL BERHASIL, DI ASSIGN KE FORM
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    //UNTUK MENGUPDATE DATA BERDASARKAN CODE YANG SEDANG DIEDIT
    updateMapel({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            //MELAKUKAN REQUEST DENGAN MENGIRIMKAN CODE DIURL
            //DAN MENGIRIMKAN DATA TERBARU YANG TELAH DIEDIT
            //MELALUI STATE SISWA
            $axios.put(`/mapel/${payload}`, state.mapel)
            .then((response) => {
                //FORM DIBERSIHKAN
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    } ,
    //MENGHAPUS DATA 
    removeMapel({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            //MENGIRIM PERMINTAAN KE SERVER UNTUK MENGHAPUS DATA
            //DENGAN METHOD DELETE DAN ID SISWA DI URL
            $axios.delete(`/mapel/${payload}`)
            .then((response) => {
                //APABILA BERHASIL, FETCH DATA TERBARU DARI SERVER
                dispatch('getMapel').then(() => resolve())
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