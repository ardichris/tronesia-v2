import $axios from '../api.js'

const state = () => ({
    presensis: [],
    kelas: [],
    rekappresensi: {
        kelas: '',
        tanggalawal: '',
        tanggalakhir: '',
        presensi: []
    },
    page: 1
})

const mutations = {
    REKAP_DATA(state, payload){
        state.rekappresensi.presensi = payload
    },
    ASSIGN_DATA(state, payload) {
        state.presensis = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    KELAS_DATA(state, payload) {
        state.kelas = payload
    },
    CLEAR_FORM(state) {
        state.rekappresensi = {
            kelas: '',
            tanggalawal: '',
            tanggalakhir: '',
            presensi: []
        }
    }
}

const actions = {
    getRekapPresensi({commit, state}, payload){
        let tanggalawal = state.rekappresensi.tanggalawal
        let tanggalakhir = state.rekappresensi.tanggalakhir
        let kelas = state.rekappresensi.kelas.id
        return new Promise((resolve, reject) => {
            $axios.get(`/presensi/rekap?kelas=${kelas}&tanggalawal=${tanggalawal}&tanggalakhir=${tanggalakhir}`)
            .then((response) => {
                commit('REKAP_DATA', response.data.data)
                resolve(response.data)
            })
        })
    },
    getPresensi({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/presensi?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    getKelas({ commit, state }, payload) {
        let search = payload.search
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/kelas?q=${search}`)
            .then((response) => {
                commit('KELAS_DATA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
