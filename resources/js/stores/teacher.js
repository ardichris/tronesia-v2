import $axios from '../api.js'

const state = () => ({
    teachers: [],
    unit: [],
    page: 1,
    id: ''
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.teachers = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    SET_ID_UPDATE(state, payload) {
        state.id = payload
    },
    UNIT_DATA(state, payload) {
        state.unit = payload
    }
}

const actions = {
    getUnit({ commit, state }, payload) {
        let search = payload.search
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/unit?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('UNIT_DATA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
    getTeachers({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/teachers?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitTeacher({ dispatch, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.post(`/teachers`, payload, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then((response) => {
                dispatch('getTeachers').then(() => {
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
    editTeacher({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/teachers/${payload}/edit`)
            .then((response) => {
                resolve(response.data)
            })
        })
    },
    viewTeacher({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/teachers/${payload}/view`)
            .then((response) => {
                resolve(response.data)
            })
        })
    },
    updateTeacher({ state }, payload) {
        return new Promise((resolve, reject) => {
            $axios.post(`/teachers/${state.id}`, payload, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then((response) => {
                resolve(response.data)
            })
        })
    },
    removeTeacher({ dispatch }, payload) {
        return new Promise((resolve, reject) => {            
            $axios.delete(`/teachers/${payload}`)
            .then((response) => {
                dispatch('getTeachers').then(() => resolve(response.data))
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