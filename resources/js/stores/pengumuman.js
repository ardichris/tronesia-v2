import $axios from '../api.js'

const state = () => ({
    p_data: [], 

    p_input: {
        p_title: '',
        p_tanggal: '',
        p_isi: '',
        p_kategori: ''
    },
    page: 1
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.p_data = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.p_input = {
            p_title: payload.p_title,
            p_tanggal: payload.p_tanggal,
            p_isi: payload.p_isi,
            p_kategori: payload.p_kategori
        }
    },
    CLEAR_FORM(state) {
        state.p_input = {
            p_title: '',
            p_tanggal: '',
            p_isi: '',
            p_kategori: ''
        }
    }
}

const actions = {
    getPengumuman({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/pengumuman?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                console.log(response.data)
                resolve(response.data)
            })
        })
    },
    editPengumuman({ commit }, payload) {
        let kode = payload.kode
        return new Promise((resolve, reject) => {
            $axios.get(`/pengumuman/${kode}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    submitPengumuman({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/pengumuman`, state.p_input)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
                console.log(response.data)
                
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
            })
        })
    },
    updatePengumuman({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/pengumuman/${payload}`, state.p_input)
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
    viewPengumuman({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/pengumuman/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    removePengumuman({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/pengumuman/${payload}`)
            .then((response) => {
                dispatch('getPengumuman').then(() => resolve())
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