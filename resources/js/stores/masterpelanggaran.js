import $axios from '../api.js'

const state = () => ({
    MP_data: [],

    MP_input: {
        id: '',
        mp_pelanggaran: '',
        mp_kategori: '',
        mp_poin: ''
    },
    page: 1
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.MP_data = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.MP_input = {
            id : payload.id,
            mp_pelanggaran : payload.mp_pelanggaran,
            mp_kategori : payload.mp_kategori,
            mp_poin : payload.mp_poin,
        }
    },
    CLEAR_FORM(state) {
        state.MP_input = {
            id: '',
            mp_pelanggaran: '',
            mp_kategori: '',
            mp_poin: ''
        }
        //state.MP_data = ''
    }
}

const actions = {
    getMP({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/masterpelanggaran?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    editMP({ commit }, payload) {
        let kode = payload.kode
        return new Promise((resolve, reject) => {
            $axios.get(`/masterpelanggaran/${kode}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    submitMP({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/masterpelanggaran`, state.MP_input)
            .then((response) => {
                dispatch('getMP').then(() => {
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
    updateMP({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/masterpelanggaran/${payload}`, state.MP_input)
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
    viewMP({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/masterpelanggaran/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    removeMP({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/masterpelanggaran/${payload}`)
            .then((response) => {
                dispatch('getMP').then(() => resolve())
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
