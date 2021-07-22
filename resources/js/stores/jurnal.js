import $axios from '../api.js'

const state = () => ({
    siswa: [],
    kelas: [],
    kompetensi: [],
    mapel: [],
    jurnals: [],
    
    jurnal: {
        jm_kode: '',
        mapel_id: '',
        jm_tanggal: '',
        jm_jampel: '',
        kelas_id: '',
        kompetensi_id: '',
        jm_materi: '',
        user_id: '',
        jm_status: '',
        jm_catatan: null,
        jm_keterangan: '',
        jm_status: '',
        detail: [],
        pelanggaran: [],
    },
    page: 1 
})

const mutations = {
    SISWA_DATA(state, payload) {
        state.siswa = payload
    },
    KOMPETENSI_DATA(state, payload) {
        state.kompetensi = payload
    },
    KELAS_DATA(state, payload) {
        state.kelas = payload
    },
    MAPEL_DATA(state, payload) {
        state.mapel = payload
    },
    ASSIGN_DATA(state, payload) {
        state.jurnals = payload
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
            pelanggaran: payload.pelanggaran,
            jm_status: payload.jm_status,
            jm_keterangan: payload.jm_keterangan,
            jm_catatan: payload.jm_catatan
        }
    },
    CLEAR_FORM(state) {
        state.jurnal = {
            jm_kode: '',
            mapel_id: '',
            jm_tanggal: '',
            jm_jampel: '',
            kelas_id: '',
            kompetensi_id: '',
            jm_materi: '',
            user_id: '',
            jm_status: '',
            jm_keterangan: '',
            jm_catatan: null,
            detail: [],
            pelanggaran: [],
        },
        state.siswa= [],
        state.kelas= [],
        state.kompetensi= [],
        state.mapel= []
    }
}

const actions = {
    /*getSiswa({ commit, state }, payload) {
        let search = payload.search
        let kelass = state.jurnal.kelas_id.id
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/kelas/anggotakelas/${kelass}`)
            .then((response) => {
                console.log(response.data)
                commit('SISWA_DATA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },*/
    getSiswa({ commit, state }, payload) {
        let search = payload.search
        let kelass = state.jurnal.kelas_id.id
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/siswas?kelas=${kelass}&q=${search}`)
            .then((response) => {
                commit('SISWA_DATA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
    getMapel({ commit, state }, payload) {
        let search = payload.search
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/mapel?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('MAPEL_DATA', response.data)
                payload.loading(false)
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
    getKompetensi({ commit, state }, payload) {
        let mapels = state.jurnal.mapel_id.mapel_kode
        let jenjangs = state.jurnal.kelas_id.kelas_jenjang
        return new Promise((resolve, reject) => {
            $axios.get(`/kompetensi?m=${mapels}&j=${jenjangs}`)
            .then((response) => {
                commit('KOMPETENSI_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    getJurnal({ commit, state }, payload) {
        let search = typeof payload.search != 'undefined' ? payload.search:''
        let status = typeof payload.status != 'undefined' ? payload.status:''
        return new Promise((resolve, reject) => {
            $axios.get(`/jurnal?page=${state.page}&q=${search}&s=${status}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitJurnal({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/jurnal`, state.jurnal)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
        })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
            })
        })
    },
    editJurnal({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/jurnal/${payload.kode}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                console.log(response.data.data)
                resolve(response.data)
            })
        })
    },
    viewJurnal({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/jurnal/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    updateJurnal({ state, commit }, payload) {
        let kode = state.jurnal.jm_kode
        return new Promise((resolve, reject) => {
            $axios.put(`/jurnal/${kode}`, state.jurnal)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    } ,
    checkJurnal({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/jurnal/${payload}`)
            .then((response) => {
                dispatch('getJurnal').then(() => resolve())
            })
        })
    },
    tolakJurnal({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/jurnal/${payload}`, state.jurnal)
            .then((response) => {
                dispatch('getJurnal').then(() => resolve())
            })
        })
    },

    updateStatus({ dispatch }, payload) {
        let kode = payload.jurnal.jm_kode
        let status = payload.status
        return new Promise((resolve, reject) => {
            $axios.put(`/jurnal/changestatus/${kode}`, payload)
            .then((response) => {
                resolve(response.data)
            })
        })
    },
    removeJurnal({ dispatch },payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/jurnal/${payload}`)
        })
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}