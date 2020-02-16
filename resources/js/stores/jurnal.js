import $axios from '../api.js'

const state = () => ({
    siswa: [],
    kelas: [],
    kompetensi: [],
    mapel: [],
    jurnals: [],
    
    //UNTUK MENAMPUNG VALUE DARI FORM INPUTAN NANTINYA
    //STATE INI AKAN DIGUNAKAN PADA FORM ADD SISWA YANG AKAN DIBAHAS KEMUDIAN
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
        detail: [
            //{ id: null, jurnal_id: null, siswa_id: 1, alasan: null, siswa: null }
        ]
    },
    page: 1 //UNTUK MENCATAT PAGE PAGINATE YANG SEDANG DIAKSES
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
    //MEMASUKKAN DATA KE STATE SISWAS
    ASSIGN_DATA(state, payload) {
        state.jurnals = payload
    },
    //MENGUBAH DATA STATE PAGE
    SET_PAGE(state, payload) {
        state.page = payload
    },
    //MENGUBAH DATA STATE SISWA
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
    //ME-RESET STATE SISWA MENJADI KOSONG
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
            detail: []
        }
    }
}

const actions = {
    getSiswa({ commit, state }, payload) {
        let search = payload.search
        let kelass = state.jurnal.kelas_id.kelas_nama
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
                console.log(response.data);
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
    //FUNGSI INI UNTUK MELAKUKAN REQUEST DATA SISWA DARI SERVER
    getJurnal({ commit, state }, payload) {
        //MENGECEK PAYLOAD ADA ATAU TIDAK
        let search = typeof payload != 'undefined' ? payload:''
        //let search = payload.search
        //payload.loading(true)
        return new Promise((resolve, reject) => {
            //REQUEST DATA DENGAN ENDPOINT /SISWAS
            $axios.get(`/jurnal?page=${state.page}&q=${search}`)
            .then((response) => {
                //SIMPAN DATA KE STATE MELALUI MUTATIONS
                commit('ASSIGN_DATA', response.data)
                //payload.loading(false)
                resolve(response.data)
            })
        })
    },
    //FUNGSI UNTUK MENAMBAHKAN DATA BARU
    submitJurnal({ dispatch, commit, state }) {
        return new Promise((resolve, reject) => {
            console.log(state.jurnal);
            $axios.post(`/jurnal`, state.jurnal)
            .then((response) => {
                dispatch('getJurnal').then(() => {
                    resolve(response.data)
                    console.log(response.data);
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
    editJurnal({ commit }, payload) {
        return new Promise((resolve, reject) => {
            //MELAKUKAN REQUEST DENGAN MENGIRIMKAN CODE SISWA DI URL
            $axios.get(`/jurnal/${payload}/edit`)
            .then((response) => {
                //APABIL BERHASIL, DI ASSIGN KE FORM
                commit('ASSIGN_FORM', response.data.data)
                console.log(response.data.data);
                resolve(response.data)
            })
        })
    },
    viewJurnal({ commit }, payload) {
        return new Promise((resolve, reject) => {
            //MELAKUKAN REQUEST DENGAN MENGIRIMKAN CODE SISWA DI URL
            $axios.get(`/jurnal/${payload}/edit`)
            .then((response) => {
                //APABIL BERHASIL, DI ASSIGN KE FORM
                commit('ASSIGN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    //UNTUK MENGUPDATE DATA BERDASARKAN CODE YANG SEDANG DIEDIT
    updateJurnal({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            console.log(state.jurnal);
            $axios.put(`/jurnal/${payload}`, state.jurnal)
            .then((response) => {
                //FORM DIBERSIHKAN
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
                console.log(response.data)
                dispatch('getJurnal').then(() => resolve())
            })
        })
    },

    //MENGHAPUS DATA 
    removeJurnal({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            //MENGIRIM PERMINTAAN KE SERVER UNTUK MENGHAPUS DATA
            //DENGAN METHOD DELETE DAN ID SISWA DI URL
            $axios.delete(`/jurnal/${payload}`)
            .then((response) => {
                //APABILA BERHASIL, FETCH DATA TERBARU DARI SERVER
                dispatch('getJurnal').then(() => resolve())
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