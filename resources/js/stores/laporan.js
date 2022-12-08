import $axios from '../api.js'

const state = () => ({
    absensis: [],
    pelanggarans: {},
    pembayarans: [],
    kelas: [],
    siswa: [],
    rekap:null,
    total:null,

    laporanabsensi: {
        siswa: null,
        kelas: null,
        start: '',
        end: ''
    },
    laporanpelanggaran: {
        siswa: null,
        kelas: null,
        start: '',
        end: ''
    },
    laporanpembayaran: {
        siswa: '',
        start: '',
        end: '',
        noform: ''
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
    PEMBAYARAN_DATA(state, payload) {
        state.pembayarans = payload.data
        state.rekap = payload.rekap
    },
    ABSENSI_DATA(state, payload) {
        state.absensis = payload
        state.total = payload.total
        state.rekap = payload.rekap
    },
    PELANGGARAN_DATA(state, payload) {
        state.pelanggarans = payload
        state.total = payload.total
        state.rekap = payload.rekap
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
            siswa: null,
            kelas: null,
            start: '',
            end: ''
        }

        state.laporanabsensi= {
            siswa: null,
            kelas: null,
            start: '',
            end: ''
        }
    }
}

const actions = {
    searchPembayaran({commit,state}){
        let start = typeof state.laporanpelanggaran.start != 'undefined' ? state.laporanpelanggaran.start:''
        let end = typeof state.laporanpelanggaran.end != 'undefined' ? state.laporanpelanggaran.end:''
        let siswa = typeof state.laporanpelanggaran.siswa != 'undefined' ? state.laporanpelanggaran.siswa:''
        let noform = typeof state.laporanpelanggaran.noform != 'undefined' ? state.laporanpelanggaran.noform:''
        return new Promise((resolve, reject) => {
            $axios.get(`/laporan/psb/pembayaran?start=${start}&end=${end}&siswa=${siswa}$noform=${noform}`)
            .then((response) => {
                commit('PEMBAYARAN_DATA', response.data)
                resolve(response.data)
            })
            .catch(() => {
                if(error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, {root: true})
                }
                reject()
            })
        })

    },
    searchPelanggaran({commit,state}, payload){
        let start = state.laporanpelanggaran.start
        let end = state.laporanpelanggaran.end
        let siswa = state.laporanpelanggaran.siswa == null? '':state.laporanpelanggaran.siswa.uuid
        let kelas = state.laporanpelanggaran.kelas == null? '':state.laporanpelanggaran.kelas
        return new Promise((resolve,reject) => {
            $axios.get(`/laporan/kesiswaan/pelanggaran?start=${start}&end=${end}&siswa=${siswa}&kelas=${kelas}`)
            .then((response) => {
                commit('PELANGGARAN_DATA', response.data)
                resolve(response.data)
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
                reject()
            })
        })
    },
    searchAbsensi({commit,state}, payload){
        let start = state.laporanabsensi.start
        let end = state.laporanabsensi.end
        let siswa = state.laporanabsensi.siswa == null? '':state.laporanabsensi.siswa.uuid
        let kelas = state.laporanabsensi.kelas == null? '':state.laporanabsensi.kelas
        return new Promise((resolve,reject) => {
            $axios.get(`/laporan/kesiswaan/absensi?start=${start}&end=${end}&siswa=${siswa}&kelas=${kelas}`)
            .then((response) => {
                commit('ABSENSI_DATA', response.data)
                resolve(response.data)
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
                reject()
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
