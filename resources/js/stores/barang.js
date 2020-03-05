import $axios from '../api.js'

const state = () => ({
    barangs: [], 

    barang: {
        barang_kode: '',
        barang_nama: '',
        b_varian: '',
        b_kategori: '',
        barang_stok: '',
        barang_satuan: '',
        barang_lokasi: ''
    },
    page: 1 
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.barangs = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.barang = {
            barang_kode: payload.barang_kode,
            barang_nama: payload.barang_nama,
            b_kategori: payload.b_kategori,
            b_varian: payload.b_varian,
            barang_stok: payload.barang_stok,
            barang_satuan: payload.barang_satuan,
            barang_lokasi: payload.barang_lokasi
        }
    },
    CLEAR_FORM(state) {
        state.barang = {
            barang_kode: '',
            barang_nama: '',
            b_kategori: '',
            b_varian: '',
            barang_stok: 0,
            barang_satuan: '',
            barang_lokasi: ''
        }
    }
}

const actions = {
    getBarang({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/barang?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitBarang({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/barang`, state.barang)
            .then((response) => {
                dispatch('getBarang').then(() => {
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
    editBarang({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/barang/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    viewBarang({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/barang/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    updateBarang({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/barang/${payload}`, state.barang)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    },
    removeBarang({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/barang/${payload}`)
            .then((response) => {
                dispatch('getBarang').then(() => resolve())
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