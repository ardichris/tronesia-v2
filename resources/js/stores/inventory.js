import $axios from '../api.js'

const state = () => ({
    inventories: [],
    inventory: {
        id: '',
        inv_code: '',
        inv_name: '',
        inv_serialnumber: '',
        inv_location: '',
        inv_condition: '',
        inv_photo: '',
        inv_status: ''
    },
    page: 1,
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.inventories = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.inventory = {
            id: payload.id,
            inv_code: payload.inv_code,
            inv_name: payload.inv_name,
            inv_serialnumber: payload.inv_serialnumber,
            inv_location: payload.inv_location,
            inv_condition: payload.inv_condition,
            inv_photo: payload.inv_photo,
            inv_status: payload.inv_status,
        }
    },
    CLEAR_FORM(state) {
        state.inventory = {
            id: '',
            inv_code: '',
            inv_name: '',
            inv_serialnumber: '',
            inv_location: '',
            inv_condition: '',
            inv_photo: '',
            inv_status: '',
        }
    }
}

const actions = {
    getInventory({ commit, state }, payload) {
        let search = typeof payload.search != 'undefined' ? payload.search:''
        let status = typeof payload.status != 'undefined' ? payload.status:''
        return new Promise((resolve, reject) => {
            $axios.get(`/inventories?page=${state.page}&q=${search}&s=${status}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitInventory({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/inventories`, state.inventory)
            .then((response) => {
                resolve(response.data)
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
            })
        })
    },
    editInventory({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/inventories/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    viewInventory({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/inventories/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    updateInventory({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/inventories/${payload}`, state.inventory)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    },
    removeInventory({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/inventories/${payload}`)
            .then((response) => {
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
