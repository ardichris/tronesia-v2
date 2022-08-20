import $axios from '../api.js'

const today = new Date();
const date = today.getFullYear()+'-'+("0" + (today.getMonth() + 1)).slice(-2)+'-'+("0" + (today.getDate())).slice(-2);


const state = () => ({
    pelanggarans: [],
    siswas: [],
    MPs: [],
    kelas: [],
    pelanggaranGrup: {
        pelanggar: [],
        pelanggaran_tanggal: date,
    },
    pelanggaran: {
        pelanggar: [],
        p_jumlah: '',
        pelanggaran_kode: '',
        siswa_id: '',
        mp_id: '',
        pelanggaran_tanggal: date,
        pelanggaran_jenis: '',
        pelanggaran_keterangan: ''
    },
    page: 1
})

const mutations = {
    TOTAL_PELANGGARAN(state, payload) {
        state.pelanggaran.p_jumlah = payload
    },
    DATA_SISWA(state, payload) {
        state.siswas = payload
    },
    DATA_MP(state, payload) {
        state.MPs = payload
    },
    ASSIGN_DATA(state, payload) {
        state.pelanggarans = payload
    },
    KELAS_DATA(state, payload) {
        state.kelas = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.pelanggaran = {
            pelanggaran_kode: payload.pelanggaran_kode,
            siswa_id: payload.siswa,
            mp_id: payload.masterpelanggaran,
            pelanggaran_tanggal: payload.pelanggaran_tanggal,
            pelanggaran_jenis: payload.pelanggaran_jenis,
            pelanggaran_keterangan: payload.pelanggaran_keterangan
        }
    },
    CLEAR_FORM(state) {
        state.pelanggaran = {
            pelanggar: [],
            p_jumlah: '',
            pelanggaran_kode: '',
            siswa_id: '',
            mp_id: '',
            pelanggaran_tanggal: date,
            pelanggaran_jenis: '',
            pelanggaran_keterangan: ''
        }
        state.siswas= [],
        state.MPs= []
    }
}

const actions = {
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
    getMP({ commit, state }, payload) {
        let cat = payload.cat
        return new Promise((resolve, reject) => {
            $axios.get(`/masterpelanggaran?category=${cat}&siswa=${state.pelanggaran.siswa_id.id}`)
            .then((response) => {
                commit('DATA_MP', response.data)
                resolve(response.data)
            })
        })
    },
    getMPs({ commit, state }, payload) {
        let siswa = state.pelanggaran.siswa_id.id
        let search = payload.search
        //payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/masterpelanggaran?q=${search}&siswa=${siswa}`)
            .then((response) => {
                commit('DATA_MP', response.data)
                //payload.loading(false)
                resolve(response.data)
            })
        })
    },
    getTotalGrup({ commit, state }, payload) {
        console.log(state.pelanggaran)
        return new Promise((resolve, reject) => {
            $axios.get(`/pelanggaran/total?siswa=${state.pelanggaran.siswa_id.id}&mp=${payload.mp}`)
            .then((response) => {
                commit('TOTAL_PELANGGARAN', response.data.data)
                resolve(response.data)
            })
        })
    },
    getTotalPelanggaran({ commit, state }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/pelanggaran/total?siswa=${state.pelanggaran.siswa_id.id}`)
            .then((response) => {
                commit('TOTAL_PELANGGARAN', response.data.data)
                resolve(response.data)
            })
        })
    },
    getPelanggarans({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/pelanggaran?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    editPelanggaran({ commit }, payload) {
        let kode = payload.kode
        return new Promise((resolve, reject) => {
            $axios.get(`/pelanggaran/${kode}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    submitPelanggaran({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/pelanggaran`, state.pelanggaran)
            .then((response) => {
                dispatch('getPelanggarans').then(() => {
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
    updatePelanggaran({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/pelanggaran/${payload}`, state.pelanggaran)
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
    viewPelanggaran({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/pelanggaran/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    removePelanggaran({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/pelanggaran/${payload}`)
            .then((response) => {
                dispatch('getPelanggarans').then(() => resolve())
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
