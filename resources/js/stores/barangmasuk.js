import $axios from '../api.js'

const state = () => ({
    barangmasuks: [], 
    barang:[],

    barangmasuk: {
        bm_kode: '',
        bm_tanggal: '',
        listbarang: []
    },
    page: 1 
})

const mutations = {
    BARANG_DATA(state, payload) {
        state.barang = payload
    },
    ASSIGN_DATA(state, payload) {
        state.barangmasuks = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.barangmasuk = {
            bm_kode: payload.bm_kode,
            bm_tanggal: payload.bm_tanggal,
            listbarang: payload.listbarang
        }
    },
    CLEAR_FORM(state) {
        state.barangmasuk = {
            bm_kode: '',
            bm_tanggal: '',
            listbarang: []
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
    getBarangmasuk({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/barangmasuk?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitBarangmasuk({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            console.log(state.barangmasuk)
            $axios.post(`/barangmasuk`, state.barangmasuk)
            .then((response) => {
                dispatch('getBarangmasuk').then(() => {
                    commit('CLEAR_FORM')
                    resolve(response.data)

                })
            })
            .catch((error) => {   
                console.log(error.response.data)
            })
        })
    },
    editBarangmasuk({ commit }, payload) {
        let kode = payload.kode
        return new Promise((resolve, reject) => {
            $axios.get(`/barangmasuk/${kode}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                console.log(response.data)
                resolve(response.data)
            })
            .catch((error) => {   
                console.log(error.response.data)
            })
        })
    },
    viewBarangmasuk({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/barangmasuk/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    updateBarangmasuk({ state, commit }, payload) {
        let kode = state.barangmasuk.bm_kode
        return new Promise((resolve, reject) => {
            console.log(state.barangmasuk)
            $axios.put(`/barangmasuk/${kode}`, state.barangmasuk)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    },
    removeBarangmasuk({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/barangmasuk/${payload}`)
            .then((response) => {
                dispatch('getBarangmasuk').then(() => resolve())
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