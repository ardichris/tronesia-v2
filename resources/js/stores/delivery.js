import $axios from '../api.js'

const today = new Date();
const date = today.getFullYear()+'-'+("0" + (today.getMonth() + 1)).slice(-2)+'-'+("0" + (today.getDate())).slice(-2);


const state = () => ({
    siswas: [],
    kelas:[],
    siswa: [],
    deliveries: [],
    delivery: {
        id: '',
        dlv_date: date,
        siswa_id: '',
        dlv_item: '',
    },
    page: 1,
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.deliveries = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.delivery = {
            id: payload.id,
            dlv_date: payload.dlv_date,
            siswa_id: payload.siswa_id,
            dlv_item: payload.dlv_item,
        }
    },
    CLEAR_FORM(state) {
        state.delivery = {
            id: '',
            dlv_date: date,
            siswa_id: '',
            dlv_item: '',
        }
    }
}

const actions = {
    getDelivery({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/deliveries?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitDelivery({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/deliveries`, state.delivery)
            .then((response) => {
                dispatch('getDelivery').then(() => {
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
    editDelivery({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/deliveries/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    sendDelivery({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/deliveries/changestatus/${payload}`)
            .then((response) => {
                resolve(response.data)
            })
        })
    },
    updateDelivery({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/deliveries/${payload}`, state.dlventory)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    },
    removeDelivery({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/deliveries/${payload}`)
            .then((response) => {
                dispatch('getDelivery').then(() => resolve())
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
