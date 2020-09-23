import $axios from '../api.js'

const state = () => ({
    jurnals: [],
    jurnal: {
        tanggalmulai: '',
        tanggalakhir: ''
    },
    kelas: []
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.jurnals = payload
    },
    KELAS_DATA(state, payload) {
        state.kelas = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.jurnal = {
            tanggalmulai: payload.tanggalmulai,
            tanggalakhir: payload.tanggalakhir
        }
    },
    CLEAR_FORM(state) {
        state.jurnal = {
            kelas: '',
            tanggal: ''
        }
    }
}

const actions = {
    getJurnal({commit, state }) {
        return new Promise((resolve, reject) => {
            //$axios.get(`/jurnal/rekap`, state.jurnal)
            $axios.get(`/jurnal/rekap?start=${state.jurnal.tanggalmulai}&finish=${state.jurnal.tanggalakhir}`, state.jurnal)
            //$axios.get(`/laporan/cetak_pdf?start=${state.jurnal.tanggalmulai}&finish=${state.jurnal.tanggalakhir}`, state.jurnal)
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