import $axios from '../api.js'

const state = () => ({
    statistiks: [],
    page: 1
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.statistiks = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
}

const actions = {

    getData({ commit, state }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/?page=${state.page}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                console.log(response.data)
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