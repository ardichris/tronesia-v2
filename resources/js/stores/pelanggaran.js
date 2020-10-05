import $axios from '../api.js'

const state = () => ({
    pelanggarans: [],
    siswas: [],
    MPs: [],

    pelanggaran: {
        pelanggaran_kode: '',
        siswa_id: '',
        mp_id: '',
        pelanggaran_tanggal: '',
        pelanggaran_jenis: '',
        pelanggaran_keterangan: ''
    },
    page: 1
})

const mutations = {
    DATA_SISWA(state, payload) {
        state.siswas = payload
    },
    DATA_MP(state, payload) {
        state.MPs = payload
    },
    ASSIGN_DATA(state, payload) {
        state.pelanggarans = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.pelanggaran = {
            pelanggaran_kode: payload.pelanggaran_kode,
            siswa_id: payload.siswa,
            mp_id: payload.masterpelanggaran,
            pelanggaran_tanggal: payload.pelanggaran_tanggal,
            pelanggaran_jenis: payload.pelanggaran_jenis,
            pelanggaran_keterangan: payload.pelanggaran_keterangan
        }
    },
    CLEAR_FORM(state) {
        state.pelanggaran = {
            pelanggaran_kode: '',
            siswa_id: '',
            mp_id: '',
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
            $axios.get(`/siswas?page=${state.page}&q=${search}&s=AKTIF`)
            .then((response) => {
                commit('DATA_SISWA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
    getMPs({ commit, state }, payload) {
        let search = payload.search
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/masterpelanggaran?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('DATA_MP', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
    getPelanggarans({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/pelanggaran?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                console.log(response.data)
                resolve(response.data)
            })
        })
    },
    editPelanggaran({ commit }, payload) {
        let kode = payload.kode
        return new Promise((resolve, reject) => {
            $axios.get(`/pelanggaran/${kode}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    submitPelanggaran({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/pelanggaran`, state.pelanggaran)
            .then((response) => {
                dispatch('getPelanggarans').then(() => {
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
    updatePelanggaran({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/pelanggaran/${payload}`, state.pelanggaran)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
            })
        })
    },
    viewPelanggaran({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/pelanggaran/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    removePelanggaran({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/pelanggaran/${payload}`)
            .then((response) => {
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