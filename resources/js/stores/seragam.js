import $axios from '../api.js'

const state = () => ({
    seragams: [], 
    barang:[],
    siswa:[],

    seragam: {
        s_kode: '',
        siswa_id: '',
        s_status: '',
        pemesanan: []
    },
    page: 1 
})

const mutations = {
    BARANG_DATA(state, payload) {
        state.barang = payload
    },
    SISWA_DATA(state, payload) {
        state.siswa = payload
    },
    ASSIGN_DATA(state, payload) {
        state.seragams = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.seragam = {
            s_kode: payload.s_kode,
            siswa_id: payload.siswa,
            s_status: payload.s_status,
            pemesanan: payload.pemesanan
        }
    },
    CLEAR_FORM(state) {
        state.seragam = {
            s_kode: '',
            siswa_id:'',
            s_status: '',
            pemesanan: []
        }
    }
}

const actions = {
    getSiswa({ commit, state }, payload) {
        let search = payload.search
        return new Promise((resolve, reject) => {
            $axios.get(`/siswas?q=${search}&seragam=pesan`)
            .then((response) => {
                commit('SISWA_DATA', response.data)
                resolve(response.data)
            })
        })
    },
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
    getSeragam({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/seragam?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitSeragam({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            //console.log(state.seragam)
            $axios.post(`/seragam`, state.seragam)
            .then((response) => {
                dispatch('getSeragam').then(() => {
                    commit('CLEAR_FORM')
                    resolve(response.data)

                })
            })
            .catch((error) => {   
                console.log(error.response.data)
            })
        })
    },
    editSeragam({ commit }, payload) {
        let kode = payload.kode
        return new Promise((resolve, reject) => {
            $axios.get(`/seragam/${kode}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
            .catch((error) => {   
                console.log(error.response.data)
            })
        })
    },
    viewSeragam({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/seragam/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    updateSeragam({ state, commit }, payload) {
        let kode = state.seragam.s_kode
        return new Promise((resolve, reject) => {
            $axios.put(`/seragam/${kode}`, state.seragam)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    },
    removeSeragam({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/seragam/${payload}`)
            .then((response) => {
                dispatch('getSeragam').then(() => resolve())
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