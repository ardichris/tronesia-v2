import $axios from '../api.js'

const state = () => ({
    jurnals: [],
    jurnal: {
        kelas: '',
        tanggal: ''
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
            jm_kode: payload.jm_kode,
            mapel_id: payload.mapel,
            jm_tanggal: payload.jm_tanggal,
            jm_jampel: payload.jm_jampel,
            kelas_id: payload.kelas,
            kompetensi_id: payload.kompetensi,
            jm_materi: payload.jm_materi,
            user_id: payload.user,
            detail: payload.detail,
            jm_catatan: payload.jm_catatan,
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
    getJurnal({ commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.get(`/jurnal/rekap?kls=${state.jurnal.kelas.id}&tgl=${state.jurnal.tanggal}`, state.jurnal)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    getKelas({ commit, state }, payload) {
        let search = payload.search
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/kelas?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('KELAS_DATA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}