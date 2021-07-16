import $axios from '../api.js'

const state = () => ({
    presensis: [],
    page: 1
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.presensis = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    }
}

const actions = {
    getPresensi({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {            
            $axios.get(`/presensi?page=${state.page}&q=${search}`)
            .then((response) => {
                console.log(response.data)
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
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