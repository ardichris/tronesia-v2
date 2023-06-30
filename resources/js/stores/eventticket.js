import $axios from '../api.js'

const state = () => ({
    eventticket_data: [],
    ticket_data: {
        status: '',
        ticket: ''
    },

    eventticket_input: {
        id:'',
        event_id: '',
        et_code: '',
        et_name: '',
        et_organization: '',
        et_group: '',
    },
    page: 1
})

const mutations = {
    TICKET_DATA(state, payload) {
        state.ticket_data = payload
    },
    ASSIGN_DATA(state, payload) {
        state.eventticket_data = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.eventticket_input = {
            id: payload.id,
            event_id: payload.event_id,
            et_code: payload.et_code,
            et_name: payload.et_name,
            et_organization: payload.et_organization,
            et_group: payload.et_group,
        }
    },
    CLEAR_FORM(state) {
        state.eventticket_input = {
            id:'',
            event_id: '',
            et_code: '',
            et_name: '',
            et_organization: '',
            et_group: '',
        }
    },
    CLEAR_TICKET(state) {
        state.ticket_data = {
            status: '',
            ticket: ''
        }
    }
}

const actions = {
    confirmTicket({commit, state}, payload){
        return new Promise((resolve, reject) => {
            $axios.put(`/eventticket/attend/${payload}`)
            .then((response) => {
                commit('TICKET_DATA', response.data.data)
                resolve(response.data)
            })
        })
    },
    getEventTicket({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/eventticket?page=${state.page}&q=${search}`)
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
