import $axios from '../api.js'

const state = () => ({
    event_data: [],

    event_input: {
        id:'',
        e_code: '',
        e_name: '',
        e_desc: '',
        e_end_date: '',
        e_start_date: '',
    },
    page: 1
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.event_data = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.event_input = {
            id: payload.id,
            e_code: payload.e_code,
            e_name: payload.e_name,
            e_desc: payload.e_desc,
            e_start_date: payload.e_start_date,
            e_end_date: payload.e_end_date,
        }
    },
    CLEAR_FORM(state) {
        state.event_input = {
            id:'',
            e_code: '',
            e_name: '',
            e_desc: '',
            e_end_date: '',
            e_start_date: '',
        }
    }
}

const actions = {
    getEvent({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/event?page=${state.page}&q=${search}`)
            .then((response) => {
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
