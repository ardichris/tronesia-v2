import $axios from '../api.js'

const state = () => ({
    pembayaran: [],
    page: 1
})

const mutations = {

    PEMBAYARAN_DATA(state, payload) {
        state.pembayaran = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.pembayaran = {
        }
    },
    CLEAR_FORM(state) {
        state.pembayaran = {}
    }
}

const actions = {
    getPembayaran({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/penerimaansiswa/pembayaran?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('PEMBAYARAN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    uploadPembayaran({ dispatch, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.post(`/penerimaansiswa/pembayaran/import`, payload, {
                headers: { 'content-type': 'multipart/form-data' }
            }).then((response) => {
                resolve(response.data)
            })
            .catch(() => {
                reject()
            })
        })
    },
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
