import $axios from '../api.js'

const state = () => ({
    siswa: [],
    teachers: [],
    kelass: [],
    anggota: [],

    kelas: {
        id: '',
        kelas_nama: '',
        kelas_jenjang: '',
        kelas_wali: '',
        k_mentor:'',
        k_jenis: '',
        tambah: '',
        anggota: [],
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
        state.anggota = payload
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
            kelas_wali: payload.user,
            k_mentor: payload.mentor,
            k_jenis: payload.k_jenis,
            anggota: payload.anggota
        }
    },

    CLEAR_FORM(state) {
        state.kelas = {
            kelas_nama: '',
            kelas_jenjang: '',
            kelas_wali: '',
            k_jenis: '',
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
            $axios.get(`/teachers?q=${search}`)
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
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
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
    },

    duplikatKelas({commit}, payload){
        let dKelas = payload.dKelas
        let dMember = payload.dMember
        let dMengajar = payload.dMengajar
        let dJadwal = payload.dJadwal
        return new Promise((resolve, reject) => {
            $axios.put(`/kelas/duplikat?kelas=${dKelas}&member=${dMember}&mengajar=${dMengajar}&jadwal=${dJadwal}`)
            .then((response) => {
                commit('CLEAR_FORM')
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
