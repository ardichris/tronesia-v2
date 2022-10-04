import $axios from '../api.js'

const state = () => ({
    absensis: [],
    siswas: [],
    kelas:[],
    siswa: [],

    absensi: {
        absensi_kode: '',
        siswa_id: '',
        absensi_tanggal: '',
        absensi_jenis: '',
        absensi_keterangan: '',
        absensi_enddate: ''
    },
    page: 1
})

const mutations = {
    DATA_SISWA(state, payload) {
        state.siswas = payload
    },
    ASSIGN_DATA(state, payload) {
        state.absensis = payload
    },
    KELAS_DATA(state, payload) {
        state.kelas = payload
    },
    SISWA_DATA(state, payload) {
        state.siswa = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.absensi = {
            absensi_kode: payload.absensi_kode,
            siswa_id: payload.siswa,
            absensi_tanggal: payload.absensi_tanggal,
            absensi_jenis: payload.absensi_jenis,
            absensi_keterangan: payload.absensi_keterangan
        }
    },
    CLEAR_FORM(state) {
        state.absensi = {
            absensi_kode: '',
            siswa_id: '',
            absensi_tanggal: '',
            absensi_jenis: '',
            absensi_keterangan: '',
            absensi_enddate: ''
        }
    }
}

const actions = {
    updateStatus({ dispatch }, payload) {
        let kode = payload.ab
        return new Promise((resolve, reject) => {
            $axios.put(`/absensi/changestatus/${kode}`, payload)
            .then((response) => {
                resolve(response.data)
            })

        })
    },
    viewSiswa({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/siswas/${payload.uuid}/edit`)
            .then((response) => {
                commit('SISWA_DATA', response.data.data)
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
    getSiswas({ commit, state }, payload) {
        let search = payload.search
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/siswas?page=${state.page}&q=${search}&s=AKTIF`)
            .then((response) => {
                commit('DATA_SISWA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
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
    getAbsensi({ commit, state }, payload) {
        let search = payload.search
        let kelas = payload.kelas
        return new Promise((resolve, reject) => {
            $axios.get(`/absensi?page=${state.page}&q=${search}&kelas=${kelas}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    editAbsensi({ commit }, payload) {
        let kode = payload.kode
        return new Promise((resolve, reject) => {
            $axios.get(`/absensi/${kode}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    submitAbsensi({ dispatch, commit, state }) {
        return new Promise((resolve) => {
            $axios.post(`/absensi`, state.absensi)
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
    updateAbsensi({ state, commit }, payload) {
        let kode = state.absensi.absensi_kode
        return new Promise((resolve, reject) => {
            $axios.put(`/absensi/${kode}`, state.absensi)
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
    viewAbsensi({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/absensi/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    removeAbsensi({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/absensi/${payload}`)

        })
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
