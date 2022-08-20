import $axios from '../api.js'

const state = () => ({
    absensis: [],
    kelas: [],
    siswa: [],
    rekap:[],

    laporanabsensi: {
        siswa: [],
        kelas: [],
        start: '',
        end: ''
    },


    page: 1
})

const mutations = {
    DATA_SISWA(state, payload) {
        state.siswa = payload
    },
    KELAS_DATA(state, payload) {
        state.kelas = payload
    },

    ABSENSI_DATA(state, payload) {
        state.absensis = payload
        state.rekap = payload.total
    },
    REKAP_DATA(state, payload) {
        state.rekap = payload
    },

    ASSIGN_FORM(state, payload) {

    },

    CLEAR_FORM(state) {
        state.absensis= [],
        state.kelas= [],
        state.siswa= [],

        state.laporanabsensi= {
            siswa: [],
            kelas: [],
            start: '',
            end: ''
        }
    }
}

const actions = {
    searchAbsensi({commit,state}, payload){
        let start = state.laporanabsensi.start
        let end = state.laporanabsensi.end
        let siswa = state.laporanabsensi.siswa != 'undefined'?'':state.laporanabsensi.siswa.uuid
        let kelas = state.laporanabsensi.kelas != 'undefined'?'':state.laporanabsensi.kelas.id
        return new Promise((resolve) => {
            $axios.get(`/laporan/kesiswaan/absensi?start=${start}&end=${end}&siswa=${siswa}&kelas=${kelas}`)
            .then((response) => {
                commit('ABSENSI_DATA', response.data)
                //commit('REKAP_DATA', response.data.total)
                console.log(state.rekap)
                resolve(response.data)
            })
        })
    },
    getSiswaKelas({ commit}, payload) {
        let kelas = payload.kelas
        return new Promise((resolve, reject) => {
            $axios.get(`/siswas?s=AKTIF&kelasnama=${kelas}`)
            .then((response) => {
                commit('DATA_SISWA', response.data)
                resolve(response.data)
            })
        })
    },
    getSiswa({ commit, state }, payload) {
        let search = payload.search
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/siswas?page=${state.page}&q=${search}&s=AKTIF`)
            .then((response) => {
                commit('DATA_SISWA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
    getKelas({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/kelas?q=${search}&key=nama`)
            .then((response) => {
                commit('KELAS_DATA', response.data)
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
