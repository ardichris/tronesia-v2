import $axios from '../api.js'

const state = () => ({
    pelanggarans: [], //STATE UNTUK MENAMPUNG DATA PELANGGARANS
    siswas: [],
    
    //STATE INI UNTUK FORM ADD DAN EDIT NANTINYA
    pelanggaran: {
        pelanggaran_kode: '',
        siswa_id: '',
        pelanggaran_tanggal: '',
        pelanggaran_jenis: '',
        pelanggaran_keterangan: ''
    },
    page: 1
})

const mutations = {
    //MUTATIONS UNTUK ASSIGN DATA PELANGGARAN KE DALAM STATE PELANGGARAN
    DATA_SISWA(state, payload) {
        state.siswas = payload
    },
    ASSIGN_DATA(state, payload) {
        state.pelanggarans = payload
    },
    //MENGUBAH STATE PAGE
    SET_PAGE(state, payload) {
        state.page = payload
    },
    //MENGUBAH STATE PELANGGARAN
    ASSIGN_FORM(state, payload) {
        state.pelanggaran = {
            pelanggaran_kode: payload.pelanggaran_kode,
            siswa_id: payload.siswa,
            pelanggaran_tanggal: payload.pelanggaran_tanggal,
            pelanggaran_jenis: payload.pelanggaran_jenis,
            pelanggaran_keterangan: payload.pelanggaran_keterangan
        }
    },
    //RESET STATE PELANGGARAN
    CLEAR_FORM(state) {
        state.pelanggaran = {
            pelanggaran_kode: '',
            siswa_id: '',
            pelanggaran_tanggal: '',
            pelanggaran_jenis: '',
            pelanggaran_keterangan: ''
        }
    }
}

const actions = {
    getSiswas({ commit, state }, payload) {
        let search = payload.search
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/siswas?page=${state.page}&q=${search}`)
            .then((response) => {
                //JIKA BERHASIL, SIMPAN DATANYA KE STATE
                commit('DATA_SISWA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
    getPelanggarans({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            //REQUEST DATA PELANGGARAN  DENGAN MENGIRIMKAN PARAMETER PAGE YG SEDANG AKTIF DAN VALUE PENCARIAN
            $axios.get(`/pelanggaran?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data) //JIKA DATA DITERIMA, SIMPAN DATA KEDALMA MUTATIONS
                resolve(response.data)
            })
        })
    },
    editPelanggaran({ commit }, payload) {
        return new Promise((resolve, reject) => {
            //MELAKUKAN REQUEST DENGAN MENGIRIMKAN CODE SISWA DI URL
            $axios.get(`/pelanggaran/${payload}/edit`)
            .then((response) => {
                //APABIL BERHASIL, DI ASSIGN KE FORM
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    submitPelanggaran({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            console.log(state.pelanggaran);
            //MENGIRIMKAN REQUEST KE BACKEND DENGAN DATA YANG DIDAPATKAN DARI STATE PELANGGARAN
            $axios.post(`/pelanggaran`, state.pelanggaran)
            .then((response) => {
                //APABILA BERHASIL MAKA LOAD DATA PELANGGARAN UNTUK MENGAMBIL DATA TERBARU
                dispatch('getPelanggarans').then(() => {
                    resolve(response.data)
                })
            })
            .catch((error) => {
                //JIKA TERJADI ERROR VALIDASI, ASSIGN ERROR TERSEBUT KE DALAM STATE ERRORS
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
            })
        })
    },
    updatePelanggaran({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/pelanggaran/${payload}`, state.pelanggaran)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    },
    viewPelanggaran({ commit }, payload) {
        return new Promise((resolve, reject) => {
            //MELAKUKAN REQUEST DENGAN MENGIRIMKAN CODE SISWA DI URL
            $axios.get(`/pelanggaran/${payload}/edit`)
            .then((response) => {
                //APABIL BERHASIL, DI ASSIGN KE FORM
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    removePelanggaran({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            //MENGIRIM PERMINTAAN KE SERVER UNTUK MENGHAPUS DATA
            //DENGAN METHOD DELETE DAN ID SISWA DI URL
            $axios.delete(`/pelanggaran/${payload}`)
            .then((response) => {
                //APABILA BERHASIL, FETCH DATA TERBARU DARI SERVER
                dispatch('getPelanggarans').then(() => resolve())
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