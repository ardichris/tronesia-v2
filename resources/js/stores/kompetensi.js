import $axios from '../api.js'

const state = () => ({
    kompetensis: [], 
    mapels: [],
    
    kompetensi: {
        kompetensi_mapel: '',
        kompetensi_jenjang: '',
        kd_kode: '',
        kompetensi_deskripsi: ''
    },
    page: 1 
})

const mutations = {
    DATA_MAPEL(state, payload) {
        state.mapels = payload
    },

    ASSIGN_DATA(state, payload) {
        state.kompetensis = payload
    },

    SET_PAGE(state, payload) {
        state.page = payload
    },

    ASSIGN_FORM(state, payload) {
        state.kompetensi = {
            kompetensi_mapel: payload.kompetensi_mapel,
            kompetensi_jenjang: payload.kompetensi_jenjang,
            kd_kode: payload.kd_kode,
            kompetensi_deskripsi: payload.kompetensi_deskripsi
        }
    },

    CLEAR_FORM(state) {
        state.kompetensi = {
            kompetensi_mapel: '',
            kompetensi_jenjang: '',
            kd_kode: '',
            kompetensi_deskripsi: ''
        }
    }
}

const actions = {
    getMapel({ commit, state }, payload) {
        let search = payload.search
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/mapel?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('DATA_MAPEL', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },

    getKompetensi({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/kompetensi?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },

    submitKompetensi({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            console.log(state.kompetensi);
            $axios.post(`/kompetensi`, state.kompetensi)
            .then((response) => {
                console.log(response.data);
                dispatch('getKompetensi').then(() => {
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
    //UNTUK MENGAMBIL SINGLE DATA DARI SERVER BERDASARKAN CODE SISWA
    editKompetensi({ commit }, payload) {
        return new Promise((resolve, reject) => {
            //MELAKUKAN REQUEST DENGAN MENGIRIMKAN CODE SISWA DI URL
            $axios.get(`/kompetensi/${payload}/edit`)
            .then((response) => {
                //APABIL BERHASIL, DI ASSIGN KE FORM
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    viewKompetensi({ commit }, payload) {
        return new Promise((resolve, reject) => {
            //MELAKUKAN REQUEST DENGAN MENGIRIMKAN CODE SISWA DI URL
            $axios.get(`/kompetensi/${payload}/edit`)
            .then((response) => {
                //APABIL BERHASIL, DI ASSIGN KE FORM
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },

    updateKompetensi({ state, commit }, payload) {
        console.log(state.kompetensi);
        return new Promise((resolve, reject) => {
            $axios.put(`/kompetensi/${payload}`, state.kompetensi)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    } ,
    //MENGHAPUS DATA 
    removeKompetensi({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            //MENGIRIM PERMINTAAN KE SERVER UNTUK MENGHAPUS DATA
            //DENGAN METHOD DELETE DAN ID SISWA DI URL
            $axios.delete(`/kompetensi/${payload}`)
            .then((response) => {
                //APABILA BERHASIL, FETCH DATA TERBARU DARI SERVER
                dispatch('getKompetensi').then(() => resolve())
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