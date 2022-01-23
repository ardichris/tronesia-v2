import $axios from '../api.js'

const state = () => ({
    siswa: [],
    siswaptms: [],
    
    siswaptm: {
        ptm:[]
    },
    page: 1
})

const mutations = {
    SISWA_DATA(state, payload) {
        state.siswa = payload
    },
    ASSIGN_DATA(state, payload) {
        state.siswaptms = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.siswaptm = {
            siswaptm_kode: payload.siswaptm_kode,
            siswaptm_nama: payload.siswaptm_nama
        }
    },
    CLEAR_FORM(state) {
        state.siswaptm = {
            ptm:[]
        }
    }
}

const actions = {
    submitPTM({ dispatch, commit, state }) {
        console.log(state.siswaptm)
        return new Promise((resolve, reject) => {
            $axios.post(`/siswaptm`, state.siswaptm)
            .then((response) => {
                resolve(response.data)
                commit('CLEAR_FORM')
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
            })
        })
    },
    getSiswa({ commit, state }, payload) {
        let search = payload.search
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/siswas?q=${search}`)
            .then((response) => {
                commit('SISWA_DATA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
    absenDatang({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.post(`/siswaptm/absenmasuk`, payload)
            .then((response) => {
                resolve(response.data)
            })
        })
    },
    dijemput({ dispatch }, payload) {
        let kode = payload
        return new Promise((resolve, reject) => {
            $axios.put(`/siswaptm/dijemput/${kode}`)
            .then((response) => {
                resolve(response.data)
            })
        })
    },
    submitsuhupulang({ dispatch }, payload) {
        let kode = payload.siswaid
        return new Promise((resolve, reject) => {
            $axios.put(`/siswaptm/suhupulang/${kode}`, payload)
            .then((response) => {
                resolve(response.data)
            })
        })
    },
    getSiswaPtm({ commit, state }, payload) {
        let search = payload.search
        let kelas = payload.kelas
        return new Promise((resolve, reject) => {
            $axios.get(`/siswaptm?page=${state.page}&q=${search}&kelas=${kelas}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
            })
        })
    },
    submitSiswaPtm({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/siswaptm`, state.siswaptm)
            .then((response) => {
                dispatch('getSiswaPtm').then(() => {
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
    editSiswaPtm({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/siswaptm/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    viewSiswaPtm({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/siswaptm/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    updateSiswaPtm({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/siswaptm/${payload}`, state.siswaptm)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    } ,
    removeSiswaPtm({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/siswaptm/${payload}`)
            .then((response) => {
                dispatch('getSiswaPtm').then(() => resolve())
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