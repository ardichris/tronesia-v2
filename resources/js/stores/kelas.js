import $axios from '../api.js'

const state = () => ({
    siswa: [],
    teachers: [],
    kelass: [],
    anggotas: [], 
    
    kelas: {
        id: '',
        kelas_nama: '',
        kelas_jenjang: '',
        kelas_wali: '',
        tambah: '',
    },
    page: 1 
})

const mutations = {
    SISWA_DATA(state, payload) {
        state.siswa = payload
    },
    TEACHER_DATA(state, payload) {
        state.teachers = payload
    },

    ANGGOTA_DATA(state, payload) {
        state.anggotas = payload
    },
    
    ASSIGN_DATA(state, payload) {
        state.kelass = payload
    },

    SET_PAGE(state, payload) {
        state.page = payload
    },

    ASSIGN_FORM(state, payload) {
        state.kelas = {
            kelas_nama: payload.kelas_nama,
            kelas_jenjang: payload.kelas_jenjang,
            kelas_wali: payload.user
        }
    },

    CLEAR_FORM(state) {
        state.kelas = {
            kelas_nama: '',
            kelas_jenjang: '',
            kelas_wali: '',
            kelas_anggota: []
        }
    }
}

const actions = {
    getSiswa({ commit, state }, payload) {
        let search = payload.search
        let kelas = payload.kelas
        let key = payload.key
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/siswas?q=${search}&kelas=${kelas}&key=${key}`)
            .then((response) => {
                commit('SISWA_DATA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
    anggotaKelas({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/siswas?kelas=${payload}`)
            .then((response) => {
                commit('ANGGOTA_DATA', response.data)
                console.log(response.data)
                resolve(response.data)
            })
        })
    },
    removeAnggota({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/siswas/${payload}`)
            .then((response) => {
                resolve(response.data)
            })
        })
    },
    tambahAnggota({ dispatch }, payload) {
        let kelas = payload.kelas
        let key = payload.key
        let siswa = payload.siswa
        return new Promise((resolve, reject) => {
            $axios.put(`/kelas/addanggota?kelas=${kelas}&key=${key}&siswa=${siswa}`)
            .then((response) => {
                dispatch('anggotaKelas').then(() => resolve())
            })
        })
    },
    getTeacher({ commit, state }, payload) {
        let search = payload.search
        payload.loading(true)
        return new Promise((resolve, reject) => {
            $axios.get(`/teachers?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('TEACHER_DATA', response.data)
                payload.loading(false)
                resolve(response.data)
            })
        })
    },
    getKelas({ commit, state }, payload) {
        let search = typeof payload != 'undefined' ? payload:''
        return new Promise((resolve, reject) => {
            $axios.get(`/kelas?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },

    submitKelas({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            $axios.post(`/kelas`, state.kelas)
            .then((response) => {
                dispatch('getKelas').then(() => {
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

    editKelas({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/kelas/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })

    },

    viewKelas({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get(`/kelas/${payload}/edit`)
            .then((response) => {
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
   
    updateKelas({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/kelas/${payload}`, state.kelas)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    } ,

    removeKelas({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/kelas/${payload}`)
            .then((response) => {
                dispatch('getKelas').then(() => resolve())
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