import $axios from '../api.js'

const state = () => ({
    units: [],
    
    unit: {
        unit_code: '',
        unit_name: '',
        unit_alamat: '',
        unit_telp: ''
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
            unit_code: payload.unit_code,
            unit_name: payload.unit_name,
            unit_alamat: payload.unit_alamat,
            unit_telp: payload.unit_telp
        }
    },
    CLEAR_FORM(state) {
        state.unit = {
            unit_code: '',
            unit_name: '',
            unit_alamat: '',
            unit_telp: ''
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
            $axios.get(`/unit/${payload}/edit`)
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
        return new Promise((resolve, reject) => {
            $axios.put(`/unit/${payload}`, state.unit)
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