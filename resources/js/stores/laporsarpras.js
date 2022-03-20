import $axios from '../api.js'

const state = () => ({
    laporsarprass: [],
    
    laporsarpras: {
        ls_kategori: '',
        ls_sarpras: '',
        ls_tanggal: '',
        ls_keterangan: '',
        ls_penanganan: ''
    },
    page: 1
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.laporsarprass = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.laporsarpras = {
            ls_kode: payload.ls_kode,
            ls_kategori: payload.ls_kategori,
            ls_sarpras: payload.ls_sarpras,
            ls_tanggal: payload.ls_tanggal,
            ls_keterangan: payload.ls_keterangan,
            ls_penanganan: payload.ls_penanganan
        }
    },
    CLEAR_FORM(state) {
        state.laporsarpras = {
            ls_kode: '',
            ls_kategori: '',
            ls_sarpras: '',
            ls_tanggal: '',
            ls_keterangan: '',
            ls_penanganan: ''
        }
    }
}

const actions = {
    updateStatus({ dispatch }, payload) {
        let kode = payload.ls.ls_kode
        return new Promise((resolve, reject) => {
            $axios.put(`/laporsarpras/changestatus/${kode}`, payload)
            .then((response) => {
                resolve(response.data)
            })
            
        })
    },
    getLaporSarpras({ commit, state }, payload) {
        let search = typeof payload.search != 'undefined' ? payload.search:''
        let kategori = typeof payload.kategori != 'undefined' ? payload.kategori:''
        return new Promise((resolve, reject) => {            
            $axios.get(`/laporsarpras?page=${state.page}&q=${search}&k=${kategori}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    editLaporSarpras({ commit }, payload) {
        let kode = payload.kode
        return new Promise((resolve, reject) => {
            $axios.get(`/laporsarpras/${kode}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    submitLaporSarpras({ dispatch, commit, state }) {
        console.log(state.laporsarpras)
        return new Promise((resolve, reject) => {
            $axios.post(`/laporsarpras`, state.laporsarpras)
            .then((response) => {
                    commit('CLEAR_FORM')
                    resolve(response.data)
            })
            /*.catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
            })*/
        })
    },
    updateLaporSarpras({ state, commit }, payload) {
        let kode = state.laporsarpras.ls_kode
        return new Promise((resolve, reject) => {
            $axios.put(`/laporsarpras/${kode}`, state.laporsarpras)
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
    removeLaporSarpras({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/laporsarpras/${payload}`)
        })
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}