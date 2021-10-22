import $axios from '../api.js'

const state = () => ({
    raporki1: {
        kelas: '',
        nilai: []
    },
    raporki2: [],

    page: 1
})

const mutations = {
    ASSIGN_KI1(state, payload) {
        state.raporki1.nilai = payload
    },
    ASSIGN_KI2(state, payload) {
        state.raporki2 = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.rapor = payload
    },
    CLEAR_FORM(state) {
        state.rapor = []
    }
}

const actions = {
    getNilaiSpiritual({ commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.get(`/nilaisiswa?&jenis=KI1`)
            .then((response) => {
                commit('ASSIGN_KI1', response.data.data)
                console.log(response.data.data)
                resolve(response)
            })
        })
    },
    getNilaiSosial({ commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.get(`/nilaisiswa?&jenis=KI2`)
            .then((response) => {
                commit('ASSIGN_KI2', response.data.data)
                console.log(response.data.data)
                resolve(response)
            })
        })
    },
    putNilaiSpiritual({ dispatch, commit, state}, payload) {
        return new Promise((resolve, reject) => {
            console.log(state.raporki1)
            $axios.post(`/nilaisiswa/nilaiki12`, state.raporki1)
            .then((response) => {
                console.log(response.data.data)
            }).catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
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