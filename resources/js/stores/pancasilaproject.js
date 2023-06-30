import $axios from "../api";

const state = () => ({
    kelas: [],
    pancasilaelement: [],
    pancasilaprojects: [],
    pancasilaproject: {
        pp_name: '',
        pp_desc: '',
        pp_theme: '',
        pp_element: [],
        pp_class: [],
    },
    page: 1,
    mode: ''
})

const mutations = {
    ASSIGN_KELAS(state, payload) {
        state.kelas = payload
    },
    ASSIGN_PE(state, payload) {
        state.pancasilaelement = payload
    },
    ASSIGN_DATA(state, payload) {
        state.pancasilaprojects = payload
    },
    ASSIGN_FORM(state, payload) {
        state.pancasilaproject = {
            id: payload.id,
            pp_name: payload.pp_name,
            pp_desc: payload.pp_desc,
            pp_theme: payload.pp_theme,
            pp_element: payload.pp_element
        }
    },
    CLEAR_FORM(state) {
        state.pancasilaproject = {
            pp_name: '',
            pp_desc: '',
            pp_theme: '',
            pp_element: [],
            pp_class: [],
        }
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    SET_MODE(state, payload) {
        state.mode = payload
    },
}

const actions = {
    getPancasilaProject({commit, state}, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject ) => {
            $axios.get(`/pancasilaproject?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    editPancasilaProject({commit, state}, payload){
        return new Promise((resolve, reject) => {
            $axios.get(`/pancasilaproject/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    getKelas({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/kelas?jenis=REGULER&key=PANCASILA`)
            .then((response) => {
                commit('ASSIGN_KELAS', response.data.data)
                resolve(response.data)
            })
        })
    },
    getPancasilaElement({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/pancasilaelement?&search=${search}`)
            .then((response) => {
                commit('ASSIGN_PE', response.data)
                resolve(response.data)
            })
        })
    },
    storePancasilaProject({dispatch,commit,state},payload) {
        return new Promise((resolve,reject) => {
            $axios.post(`/pancasilaproject`, state.pancasilaproject)
            .then((response) => {
                dispatch('getPancasilaProject').then(() => {
                    resolve(response.data)
                })
            })
            .catch((error) => {
                if(error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, {root: true})
                }
            })
        })
    },
    updatePancasilaProject({dispatch,commit,state},payload) {
        console.log(state.pancasilaproject)
        return new Promise((resolve,reject) => {
            $axios.put(`/pancasilaproject/${state.pancasilaproject.id}`, state.pancasilaproject)
            .then((response) => {
                dispatch('getPancasilaProject').then(() => {
                    resolve(response.data)
                })
            })
            .catch((error) => {
                if(error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, {root: true})
                }
            })
        })
    },
    removePancasilaProject({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/pancasilaproject/${payload}`)
            .then((response) => {
                dispatch('getPancasilaProject').then(() => resolve())
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
