import $axios from '../api.js'

const state = () => ({
    pemakaianbarangs: [], 
    barangs: [],

    pemakaianbarang: {
        pb_kode: '',
        pb_tanggal: '',
        barang_id: '',
        pb_jumlah: '',
        barang: ''
    },
    page: 1 
})

const mutations = {
    BARANG_DATA(state, payload) {
        state.barangs = payload
    },
    ASSIGN_DATA(state, payload) {
        state.pemakaianbarangs = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.pemakaianbarang = {
            pb_kode: payload.pb_kode,
            pb_tanggal: payload.pb_tanggal,
            barang: payload.barang,
            pb_jumlah: payload.pb_jumlah
        }
    },
    CLEAR_FORM(state) {
        state.pemakaianbarang = {
            pb_kode: '',
            pb_tanggal: '',
            barang_id: '',
            pb_jumlah: '',
            barang: ''
        }
    }
}

const actions = {
    getBarang({ commit, state }, payload) {
        let search = payload.search
        return new Promise((resolve, reject) => {
            $axios.get(`/barang?q=${search}`)
            .then((response) => {
                commit('BARANG_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    getPemakaianbarang({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/pemakaianbarang?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitPemakaianbarang({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/pemakaianbarang`, state.pemakaianbarang)
            .then((response) => {
                dispatch('getPemakaianbarang').then(() => {
                    commit('CLEAR_FORM')
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
    editPemakaianbarang({ commit }, payload) {
        let kode = payload.kode
        return new Promise((resolve, reject) => {
            $axios.get(`/pemakaianbarang/${kode}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    viewPemakaianbarang({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/pemakaianbarang/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    updatePemakaianbarang({ state, commit }, payload) {
        let kode = state.pemakaianbarang.pb_kode
        return new Promise((resolve, reject) => {
            $axios.put(`/pemakaianbarang/${kode}`, state.pemakaianbarang)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    },
    removePemakaianbarang({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/pemakaianbarang/${payload}`)
            .then((response) => {
                dispatch('getPemakaianbarang').then(() => resolve())
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