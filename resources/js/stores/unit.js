import $axios from '../api.js'

const state = () => ({
    units: [],
    
    unit: {
        id: '',
        unit_kode: '',
        unit_nama: ''
    },
    page: 1
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.units = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.unit = {
            id: payload.id,
            unit_kode: payload.unit_kode,
            unit_nama: payload.unit_nama
        }
    },
    CLEAR_FORM(state) {
        state.unit = {
            unit_kode: '',
            unit_nama: ''
        }
    }
}

const actions = {
    getUnit({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/unit?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitUnit({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/unit`, state.unit)
            .then((response) => {
                dispatch('getUnit').then(() => {
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
    editUnit({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/unit/${payload.kode}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    viewUnit({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/unit/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    updateUnit({ state, commit }, payload) {
        let kode = state.unit.id
        return new Promise((resolve, reject) => {
            $axios.put(`/unit/${kode}`, state.unit)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    } ,
    removeUnit({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/unit/${payload}`)
            .then((response) => {
                dispatch('getUnit').then(() => resolve())
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