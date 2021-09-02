import $axios from '../api.js'

const state = () => ({
    jammengajars: [],
    kelas:[],
    mapel:[],
    guru:[],
    jadwalkelas: [],
    jadwalpelajaran: [],
    
    jadwal: {
        kelas: '',
        mapel: '',
        guru: '',
        jampel: '',
        hari: ''
    },

    jammengajar: {
        id: '',
        kelas: [],
        mapel: [],
        guru: [],
        pengajar: [],
        mengajar: [],
    },
    page: 1
})

const mutations = {
    JP_DATA(state,payload) {
        state.jadwalpelajaran = payload
    },
    KELAS_DATA(state, payload) {
        state.kelas = payload
    },
    MAPEL_DATA(state, payload) {
        state.mapel = payload
    },
    GURU_DATA(state, payload) {
        state.guru = payload
    },
    ASSIGN_DATA(state, payload) {
        state.jammengajars = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.jammengajar = {
            id: payload.id,
            kelas: payload.kelas,
            mapel: payload.mapel,
            guru: payload.guru
        }
    },
    CLEAR_FORM(state) {
        state.jammengajar = {
            kelas: [],
            mapel: [],
            guru: [],
            pengajar: [],
            mengajar: []
        }
    }
}

const actions = {
    getJP({ commit, state}) {
        let search = state.jadwal.kelas.id
        return new Promise((resolve,reject) => {
            $axios.get(`/jadwalpelajaran?kelas=${search}`)
            .then((response) => {
                commit('JP_DATA', response.data.data)
                resolve(response.data)
            })
        })
    },
    submitJP({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/jadwalpelajaran`, state.jadwal)
            .then((response) => {
                dispatch('getJP').then(() => {
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
    removeJP({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/jadwalpelajaran/${payload}`)
            .then((response) => {
                dispatch('getJP').then(() => resolve())
            })
        })
    },
    getGuru({ commit, state }, payload) {
        let search = payload.search
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/teachers?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('GURU_DATA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
    getMapel({ commit, state }, payload) {
        let search = payload.search
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/mapel?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('MAPEL_DATA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
    getKelas({ commit, state }, payload) {
        let search = payload.search
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/kelas?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('KELAS_DATA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
    getJM({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/jammengajar?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitJM({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/jammengajar`, state.jammengajar)
            .then((response) => {
                dispatch('getJM').then(() => {
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
    editJM({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/jammengajar/${payload.kode}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    viewJM({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/jammengajar/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    updateJM({ state, commit }) {
        let kode = state.jammengajar.id
        return new Promise((resolve, reject) => {
            $axios.put(`/jammengajar/${kode}`, state.jammengajar)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    } ,
    removeJM({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/jammengajar/${payload}`)
            .then((response) => {
                dispatch('getJM').then(() => resolve())
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