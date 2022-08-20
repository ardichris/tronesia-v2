import $axios from '../api.js'

const today = new Date();
const date = today.getFullYear()+'-'+("0" + (today.getMonth() + 1)).slice(-2)+'-'+("0" + (today.getDate())).slice(-2);

const state = () => ({
    kitirs: [],
    siswas: [],
    kelas: [],

    kitir: {
        siswa: [],
        ks_kode: '',
        siswa_id: '',
        ks_tanggal: date,
        ks_jenis: '',
        ks_start: '',
        ks_end: '',
        ks_keterangan: ''
    },
    page: 1
})

const mutations = {
    KELAS_DATA(state, payload) {
        state.kelas = payload
    },
    DATA_SISWA(state, payload) {
        state.siswas = payload
    },
    ASSIGN_DATA(state, payload) {
        state.kitirs = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.kitir = {
            ks_kode: payload.ks_kode,
            siswa_id: payload.siswa,
            ks_tanggal: payload.ks_tanggal,
            ks_waktu: payload.ks_waktu,
            ks_jenis: payload.ks_jenis,
            ks_keterangan: payload.ks_keterangan
        }
    },
    CLEAR_FORM(state) {
        state.kitir = {
            siswa: [],
            ks_kode: '',
            siswa_id: '',
            ks_tanggal: date,
            ks_jenis: '',
            ks_start: '',
            ks_end: '',
            ks_keterangan: ''
        }
    }
}

const actions = {
    getSiswaKelas({ commit}, payload) {
        let kelas = payload.kelas
        return new Promise((resolve, reject) => {
            $axios.get(`/siswas?s=AKTIF&kelasnama=${kelas}`)
            .then((response) => {
                commit('DATA_SISWA', response.data)
                resolve(response.data)
            })
        })
    },
    getKelas({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/kelas?q=${search}&key=nama`)
            .then((response) => {
                commit('KELAS_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    updateStatus({ dispatch }, payload) {
        let kode = payload.ks.ks_kode
        return new Promise((resolve, reject) => {
            $axios.put(`/kitirsiswa/changestatus/${kode}`, payload)
            .then((response) => {
                resolve(response.data)
            })

        })
    },
    getSiswas({ commit, state }, payload) {
        let search = payload.search
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/siswas?q=${search}&s=AKTIF`)
            .then((response) => {
                commit('DATA_SISWA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
    getKitir({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/kitirsiswa?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    editKitir({ commit }, payload) {
        let kode = payload.kode
        return new Promise((resolve, reject) => {
            $axios.get(`/kitirsiswa/${kode}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    submitKitir({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/kitirsiswa`, state.kitir)
            .then((response) => {
                dispatch('getKitir').then(() => {
                    commit('CLEAR_FORM')
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
    updateKitir({ state, commit }, payload) {
        let kode = state.kitir.kitir_kode
        return new Promise((resolve, reject) => {
            $axios.put(`/kitirsiswa/${kode}`, state.kitir)
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
    viewKitir({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/kitirsiswa/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    removeKitir({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/kitirsiswa/${payload}`)
            .then((response) => {
                dispatch('getKitir').then(() => resolve())
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
