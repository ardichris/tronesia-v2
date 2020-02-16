import $axios from '../api.js'

const state = () => ({
    statistiks: []
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.statistiks = payload
    }
}

const actions = {

    getData({ commit, state }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/`)
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