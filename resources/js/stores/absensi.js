import $axios from '../api.js'

const state = () => ({
    absensis: [], //STATE UNTUK MENAMPUNG DATA PELANGGARANS
    siswas: [],
    
    //STATE INI UNTUK FORM ADD DAN EDIT NANTINYA
    absensi: {
        absensi_kode: '',
        siswa_id: '',
        absensi_tanggal: '',
        absensi_jenis: '',
        absensi_keterangan: ''
    },
    page: 1
})

const mutations = {
    //MUTATIONS UNTUK ASSIGN DATA PELANGGARAN KE DALAM STATE PELANGGARAN
    DATA_SISWA(state, payload) {
        state.siswas = payload
    },
    ASSIGN_DATA(state, payload) {
        state.absensis = payload
    },
    //MENGUBAH STATE PAGE
    SET_PAGE(state, payload) {
        state.page = payload
    },
    //MENGUBAH STATE PELANGGARAN
    ASSIGN_FORM(state, payload) {
        state.absensi = {
            absensi_kode: payload.absensi_kode,
            siswa_id: payload.siswa,
            absensi_tanggal: payload.absensi_tanggal,
            absensi_jenis: payload.absensi_jenis,
            absensi_keterangan: payload.absensi_keterangan
        }
    },
    //RESET STATE PELANGGARAN
    CLEAR_FORM(state) {
        state.absensi = {
            absensi_kode: '',
            siswa_id: '',
            absensi_tanggal: '',
            absensi_jenis: '',
            absensi_keterangan: ''
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
                commit('DATA_SISWA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
    getAbsensi({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            //REQUEST DATA PELANGGARAN  DENGAN MENGIRIMKAN PARAMETER PAGE YG SEDANG AKTIF DAN VALUE PENCARIAN
            $axios.get(`/absensi?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data) //JIKA DATA DITERIMA, SIMPAN DATA KEDALMA MUTATIONS
                resolve(response.data)
            })
        })
    },
    editAbsensi({ commit }, payload) {
        return new Promise((resolve, reject) => {
            //MELAKUKAN REQUEST DENGAN MENGIRIMKAN CODE SISWA DI URL
            $axios.get(`/absensi/${payload}/edit`)
            .then((response) => {
                //APABIL BERHASIL, DI ASSIGN KE FORM
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    submitAbsensi({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            console.log(state.absensi);
            $axios.post(`/absensi`, state.absensi)
            .then((response) => {
                dispatch('getAbsensi').then(() => {
                    resolve(response.data)
                })
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
            })
        })
    },
    updateAbsensi({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/absensi/${payload}`, state.absensi)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    },
    viewAbsensi({ commit }, payload) {
        return new Promise((resolve, reject) => {
            //MELAKUKAN REQUEST DENGAN MENGIRIMKAN CODE SISWA DI URL
            $axios.get(`/absensi/${payload}/edit`)
            .then((response) => {
                //APABIL BERHASIL, DI ASSIGN KE FORM
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    removeAbsensi({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            //MENGIRIM PERMINTAAN KE SERVER UNTUK MENGHAPUS DATA
            //DENGAN METHOD DELETE DAN ID SISWA DI URL
            $axios.delete(`/absensi/${payload}`)
            .then((response) => {
                //APABILA BERHASIL, FETCH DATA TERBARU DARI SERVER
                dispatch('getAbsensi').then(() => resolve())
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