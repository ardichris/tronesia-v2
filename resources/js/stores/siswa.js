import $axios from '../api.js'

const state = () => ({
    siswas: [],

    siswa: {
        siswa_nis: '',
        siswa_nisn: '',
        siswa_nik: '',
        siswa_nama: '',
        siswa_kelamin: '',
        siswa_kelas: '',
        siswa_alamat: '',
        siswa_tempatlahir: '',
        siswa_tanggallahir: '',
        siswa_tinggi: '',
        siswa_berat: '',
        siswa_status: '',
        siswa_sekolahasal: '',
        siswa_notelp: '',
        siswa_nohandphone: '',
        siswa_poin: '',
        siswa_anakke: '',
        siswa_namaibu: '',
        siswa_ttlibu: '',
        siswa_nikibu: '',
        siswa_pekerjaanibu: '',
        siswa_namaayah: '',
        siswa_ttlayah: '',
        siswa_alamatortu:'',
        siswa_wali:'',
        siswa_pekerjaanwali:''
    },
    page: 1
})

const mutations = {
    ASSIGN_DATA(state, payload) {
        state.siswas = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.siswa = {
            siswa_nis: payload.siswa_nis,
            siswa_nisn: payload.siswa_nisn,
            siswa_nik: payload.siswa_nik,
            siswa_nama: payload.siswa_nama,
            siswa_kelamin: payload.siswa_kelamin,
            siswa_kelas: payload.siswa_kelas,
            siswa_alamat: payload.siswa_alamat,
            siswa_tempatlahir: payload.siswa_tempatlahir,
            siswa_tanggallahir: payload.siswa_tanggallahir,
            siswa_tinggi: payload.siswa_tinggi,
            siswa_berat: payload.siswa_berat,
            siswa_status: payload.siswa_status,
            siswa_sekolahasal: payload.siswa_sekolahasal,
            siswa_notelp: payload.siswa_notelp,
            siswa_nohandphone: payload.siswa_nohandphone,
            siswa_poin: payload.siswa_poin,
            siswa_anakke: payload.siswa_anakke,
            siswa_namaibu: payload.siswa_namaibu,
            siswa_ttlibu: payload.siswa_ttlibu,
            siswa_nikibu: payload.siswa_nikibu,
            siswa_pekerjaanibu: payload.siswa_pekerjaanibu,
            siswa_namaayah: payload.siswa_namaayah,
            siswa_ttlayah: payload.siswa_ttlayah,
            siswa_alamatortu: payload.siswa_alamatortu,
            siswa_wali: payload.siswa_wali,
            siswa_pekerjaanwali: payload.siswa_pekerjaanwali
        }
    },
    CLEAR_FORM(state) {
        state.siswa = {
            siswa_nis: '',
            siswa_nisn: '',
            siswa_nik: '',
            siswa_nama: '',
            siswa_kelamin: '',
            siswa_kelas: '',
            siswa_alamat: '',
            siswa_tempatlahir: '',
            siswa_tanggallahir: '',
            siswa_tinggi: '',
            siswa_berat: '',
            siswa_status: '',
            siswa_sekolahasal: '',
            siswa_notelp: '',
            siswa_nohandphone: '',
            siswa_poin: '',
            siswa_anakke: '',
            siswa_namaibu: '',
            siswa_ttlibu: '',
            siswa_nikibu: '',
            siswa_pekerjaanibu: '',
            siswa_namaayah: '',
            siswa_ttlayah: '',
            siswa_alamatortu:'',
            siswa_wali:'',
            siswa_pekerjaanwali:''
        }
    }
}

const actions = {
    getSiswas({ commit, state }, payload) {
        let search = typeof payload.search != 'undefined' ? payload.search:''
        let status = typeof payload.status != 'undefined' ? payload.status:''
        return new Promise((resolve, reject) => {
            $axios.get(`/siswas?page=${state.page}&q=${search}&s=${status}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    submitSiswa({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/siswas`, state.siswa)
            .then((response) => {
                dispatch('getSiswas').then(() => {
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
    editSiswa({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/siswas/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    viewSiswa({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/siswas/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    updateSiswa({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/siswas/${payload}`, state.siswa)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    },
    removeSiswa({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/siswas/${payload}`)
            .then((response) => {
                dispatch('getSiswas').then(() => resolve())
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