import $axios from '../api.js'

const state = () => ({
    requestLive: {
        studentcode: '',
        dob: '',
    },
    liveStatus: '',
    reqID: ''
    
})

const mutations = {
    CLEAR_FORM(state) {
        state.liveStatus = '',
        state.reqID= ''
    }
}

const actions = {
    requestLiveTracking({ state }, payload) {
        return new Promise((resolve, reject) => {
            $axios.post(`/livetracking`, state.requestLive)
            .then((response) => {
                if (response.data.status == 'success') {
                    state.liveStatus = 'success'
                    state.reqID = response.data.uuid
                } else {
                    state.liveStatus = 'fail'
                }
                resolve(response.data)
            })
            .catch(() => {
                reject()
            })
            
        })
    },
    liveLocation({ dispatch }, payload){
        
        $axios.put(`/livetracking`, payload)
    },
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}