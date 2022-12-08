import $axios from '../api.js'

const state = () => ({
    lingkupmateris: [],
    mapels: [],

    lingkupmateri: {
        lingkupmateri_mapel: '',
        lingkupmateri_jenjang: '',
        kd_kode: '',
        lingkupmateri_deskripsi: ''
    },
    page: 1
})

const mutations = {
    DATA_MAPEL(state, payload) {
        state.mapels = payload
    },

    ASSIGN_DATA(state, payload) {
        state.lingkupmateris = payload
    },

    SET_PAGE(state, payload) {
        state.page = payload
    },

    ASSIGN_FORM(state, payload) {
        state.lingkupmateri = {
            lingkupmateri_mapel: payload.lingkupmateri_mapel,
            lingkupmateri_jenjang: payload.lingkupmateri_jenjang,
            kd_kode: payload.kd_kode,
            lingkupmateri_deskripsi: payload.lingkupmateri_deskripsi
        }
    },

    CLEAR_FORM(state) {
        state.lingkupmateri = {
            lingkupmateri_mapel: '',
            lingkupmateri_jenjang: '',
            kd_kode: '',
            lingkupmateri_deskripsi: ''
        }
    }
}

const actions = {
    getMapel({ commit, state }, payload) {
        let search = payload.search
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/mapel?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('DATA_MAPEL', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },

    getLingkupMateri({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/lingkupmateri?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },

    submitLingkupMateri({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/lingkupmateri`, state.lingkupmateri)
            .then((response) => {
                dispatch('getLingkupMateri').then(() => {
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
    editLingkupMateri({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/lingkupmateri/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    viewLingkupMateri({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/lingkupmateri/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },

    updateLingkupMateri({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/lingkupmateri/${payload}`, state.lingkupmateri)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    } ,
    removeLingkupMateri({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/lingkupmateri/${payload}`)
            .then((response) => {
                dispatch('getLingkupMateri').then(() => resolve())
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
