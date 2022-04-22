import $axios from '../api.js'

const state = () => ({
    raporakhirs: {},
    raporsisipan: {},

    raporakhir: {
        raporakhir_kode: '',
        raporakhir_nama: ''
    },
    page: 1
})

const mutations = {

    ASSIGN_DATA(state, payload) {
        state.raporakhirs = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.raporakhir = {
            raporakhir_kode: payload.raporakhir_kode,
            raporakhir_nama: payload.raporakhir_nama
        }
    },
    SISIPAN_FORM(state, payload){
        state.raporsisipan = payload
    },
    RAPOR_FORM(state, payload){
        state.raporakhirs = payload
    },
    CLEAR_FORM(state) {
        state.raporakhir = {
            raporakhir_kode: '',
            raporakhir_nama: ''
        }
    }
}

const actions = {

    uploadLedger({ dispatch, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.post(`/raporakhir/import`, payload, {
                headers: { 'content-type': 'multipart/form-data' }
            }).then((response) => {
                resolve(response.data)
            })
            .catch(() => {
                reject()
            })
            // .then((response) => {
            //     dispatch('getRaporAkhir').then(() => {
            //         resolve(response.data)
            //     })
            // })
            // .catch((error) => {
            //     if (error.response.status == 422) {
            //         commit('SET_ERRORS', error.response.data.errors, { root: true })
            //     }
            // })
        })
    },
    getRaporAkhir({ commit, state }, payload) {
        let search = payload.search
        return new Promise((resolve, reject) => {
            $axios.get(`/raporakhir?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitRaporAkhir({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/raporakhir`, state.raporakhir)
            .then((response) => {
                dispatch('getRaporAkhir').then(() => {
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
    viewRaporSisipan({ commit, state }, payload) {
        let uuid = payload.uuid
        return new Promise((resolve, reject) => {
            $axios.get(`/raporsisipan/view?uuid=${uuid}`)
            .then((response) => {
                commit('SISIPAN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    viewRaporAkhir({ commit, state }, payload) {
        let uuid = payload.uuid
        return new Promise((resolve, reject) => {
            $axios.get(`/raporakhir/view?uuid=${uuid}`)
            .then((response) => {
                commit('RAPOR_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    submitRaporSisipan({commit, state}, payload){
        let kode = state.raporsisipan.id
        return new Promise((resolve, reject) => {
            $axios.put(`/raporsisipan/${kode}`, state.raporsisipan)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    },
    editRaporAkhir({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/raporakhir/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    updateRaporAkhir({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/raporakhir/${payload}`, state.raporakhir)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    } ,
    removeRaporAkhir({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/raporakhir/${payload}`)
            .then((response) => {
                dispatch('getRaporAkhir').then(() => resolve())
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
