import $axios from '../api.js'

const state = () => ({
    nilaisiswas: [],
    jammengajars: [],
    nilaiselect: {
        kelas: '',
        kelasnama: '',
        mapel: [],
        mapelkode: '',
        jenis: '',
        kd: ''
    },
    
    mapel: {
        mapel_kode: '',
        mapel_nama: ''
    },
    page: 1
})

const mutations = {
    JM_SELECT(state, payload){
        state.nilaiselect.kelas = payload.kelas_id,
        state.nilaiselect.mapel = payload.mapel_id
    },
    JENIS_SELECT(state, payload){
        state.nilaiselect.jenis = payload
    },
    JAMMENGAJAR_DATA(state, payload) {
        state.jammengajars = payload
    },
    ASSIGN_DATA(state, payload) {
        state.nilaisiswas = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.mapel = {
            mapel_kode: payload.mapel_kode,
            mapel_nama: payload.mapel_nama
        }
    },
    CLEAR_FORM(state) {
        state.mapel = {
            mapel_kode: '',
            mapel_nama: ''
        }
    }
}

const actions = {
    getJamMengajar({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/jammengajar?jm=nilai`)
            .then((response) => {
                commit('JAMMENGAJAR_DATA', response.data.data)
                resolve(response.data)
            })
        })
    },
    getNilaiSiswa({ commit, state }) {
        let kelas = state.nilaiselect.kelas
        let mapel = state.nilaiselect.mapel
        let jenis = state.nilaiselect.jenis
        return new Promise((resolve, reject) => {
            $axios.get(`/nilaisiswa?kelas=${kelas}&mapel=${mapel}&jenis=${jenis}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data.data)
                console.log(response.data.data)
                resolve(response)
            })
        })
    },
    submitNilaiSiswa({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/nilaisiswa`, state.nilaisiswas)
            .then((response) => {
                console.log(response.data.status)
            //     dispatch('getNilaiSiswa').then(() => {
            //         commit('ASSIGN_DATA', response.data.data)
            //         resolve(response)
            //     })
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
            })
        })
    },
    editMapel({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/mapel/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    viewMapel({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/mapel/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    updateMapel({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/mapel/${payload}`, state.mapel)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    } ,
    removeMapel({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/mapel/${payload}`)
            .then((response) => {
                dispatch('getMapel').then(() => resolve())
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