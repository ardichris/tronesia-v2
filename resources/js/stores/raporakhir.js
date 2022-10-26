import $axios from '../api.js'

const state = () => ({
    rapor: {},
    kelas: [],
    raporsisipan: {},
    raporakhir: {},
    raporpetra: {
        siswa_id: '',
        rp_pone_score: '',
        rp_ptwo_score: '',
        rp_pthree_score: '',
        rp_eone_score: '',
        rp_etwo_score: '',
        rp_ethree_score: '',
        rp_efour_score: '',
        rp_tone_desc: '',
        rp_ttwo_desc: '',
        rp_talent_score: '',
        rp_rone_score: '',
        rp_rtwo_score: '',
        rp_rthree_score: '',
        rp_rfour_score: '',
        rp_academic_score: '',
    },
    siswa: {},
    exportParameter: {
        file:'',
        rapor:'',
        grup:'',
        detail:''
    },
    exportRapor: {},
    kompetensi: [],
    settingTP: {
        field:{
            PAK:{1:[],2:[],3:[],4:[]},
            PKN:{1:[],2:[],3:[],4:[]},
            BIN:{1:[],2:[],3:[],4:[]},
            BIG:{1:[],2:[],3:[],4:[]},
            MAT:{1:[],2:[],3:[],4:[]},
            BIO:{1:[],2:[],3:[],4:[]},
            FIS:{1:[],2:[],3:[],4:[]},
            EKO:{1:[],2:[],3:[],4:[]},
            GEO:{1:[],2:[],3:[],4:[]},
            SEJ:{1:[],2:[],3:[],4:[]},
            SNR:{1:[],2:[],3:[],4:[]},
            SNM:{1:[],2:[],3:[],4:[]},
            MEK:{1:[],2:[],3:[],4:[]},
            TIK:{1:[],2:[],3:[],4:[]},
            JWA:{1:[],2:[],3:[],4:[]},
            MAN:{1:[],2:[],3:[],4:[]},
            ORG:{1:[],2:[],3:[],4:[]},
        }
    },

    page: 1
})

const mutations = {
    KELAS_DATA(state, payload) {
        state.kelas = payload
    },
    SETTING_SISIPAN(state, payload){
        state.settingTP.field = Object.assign( {}, state.settingTP.field, payload )
    },
    KOMPETENSI_DATA(state, payload){
        state.kompetensi = payload
    },
    EXPORT_RAPOR(state, payload) {
        state.exportRapor = payload
    },
    ASSIGN_DATA(state, payload) {
        state.rapor = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    SET_SISWA(state, payload) {
        state.raporpetra.siswa_id = payload
    },
    ASSIGN_FORM(state, payload) {
        state.raporakhir = {
            raporakhir_kode: payload.raporakhir_kode,
            raporakhir_nama: payload.raporakhir_nama
        }
    },
    SISIPAN_FORM(state, payload){
        state.raporsisipan = payload
    },
    RAPOR_FORM(state, payload){
        state.raporakhir = payload
    },
    PETRA_FORM(state, payload){
        state.raporpetra = payload
    },
    CLEAR_FORM(state) {
        state.raporakhir = {}
        state.raporsisipan = {}
        state.raporpetra = {}
    }
}

const actions = {

    exportRapor({commit, state}, payload){

        // return new Promise((resolve, reject)=> {
        //     $axios.get(`/exportrapor`)
        //     .then((response) => {
        //         window.open(response)
        //         resolve(response)
        //     })
        //     // .catch(() => {
        //     //     reject()
        //     // })
        // })
    },
    uploadLedger({ dispatch, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.post(`/raporakhir/import`, payload, {
                headers: { 'content-type': 'multipart/form-data' }
            }).then((response) => {
                resolve(response.data)
            })
            .catch(() => {
                reject()
            })
            // .then((response) => {
            //     dispatch('getRaporAkhir').then(() => {
            //         resolve(response.data)
            //     })
            // })
            // .catch((error) => {
            //     if (error.response.status == 422) {
            //         commit('SET_ERRORS', error.response.data.errors, { root: true })
            //     }
            // })
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
    getRapor({ commit, state }, payload) {
        let search = payload.search
        return new Promise((resolve, reject) => {
            $axios.get(`/raporakhir?page=${state.page}&q=${search}`)
            .then((response) => {
                commit('ASSIGN_DATA', response.data)
                resolve(response.data)
            })
        })
    },
    // submitRaporAkhir({ dispatch, commit, state }) {
    //     return new Promise((resolve, reject) => {
    //         $axios.post(`/raporakhir`, state.raporakhir)
    //         .then((response) => {
    //             dispatch('getRaporAkhir').then(() => {
    //                 resolve(response.data)
    //             })
    //         })
    //         .catch((error) => {
    //             if (error.response.status == 422) {
    //                 commit('SET_ERRORS', error.response.data.errors, { root: true })
    //             }
    //         })
    //     })
    // },
    viewRaporSisipan({ commit, state }, payload) {
        let uuid = payload.uuid
        return new Promise((resolve, reject) => {
            $axios.get(`/raporsisipan/view?uuid=${uuid}`)
            .then((response) => {
                commit('SISIPAN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    viewRaporSisipanKurmer({ commit, state }, payload) {
        let uuid = payload.uuid
        return new Promise((resolve, reject) => {
            $axios.get(`/raporsisipan/view?uuid=${uuid}&kurikulum=merdeka`)
            .then((response) => {
                commit('SISIPAN_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    viewRaporAkhir({ commit, state }, payload) {
        let uuid = payload.uuid
        return new Promise((resolve, reject) => {
            $axios.get(`/raporakhir/view?uuid=${uuid}`)
            .then((response) => {
                commit('RAPOR_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    submitRaporSisipan({commit, state}, payload){
        let kode = state.raporsisipan.id
        return new Promise((resolve, reject) => {
            $axios.put(`/raporsisipan/${kode}`, state.raporsisipan)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
                this.getRapor()
            })
        })
    },
    submitRaporAkhir({commit, state}, payload){
        let kode = state.raporakhir.id
        return new Promise((resolve, reject) => {
            $axios.put(`/raporakhir/${kode}`, state.raporakhir)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    },
    // editRaporAkhir({ commit }, payload) {
    //     return new Promise((resolve, reject) => {
    //         $axios.get(`/raporakhir/${payload}/edit`)
    //         .then((response) => {
    //             commit('ASSIGN_FORM', response.data.data)
    //             resolve(response.data)
    //         })
    //     })
    // },
    updateRaporAkhir({ state, commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.put(`/raporakhir/${payload}`, state.raporakhir)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    } ,
    removeRaporAkhir({ dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete(`/raporakhir/${payload}`)
            .then((response) => {
                dispatch('getRaporAkhir').then(() => resolve())
            })
        })
    },
    viewRaporPetra({ commit, state }, payload) {
        let uuid = payload.uuid
        return new Promise((resolve, reject) => {
            $axios.get(`/raporpetra/view?uuid=${uuid}`)
            .then((response) => {
                commit('PETRA_FORM', response.data)
                resolve(response.data)
            })
        })
    },
    submitNilaiPetra({commit, state}, payload){
        let kode = state.raporpetra.id?state.raporpetra.id:'add'
        return new Promise((resolve, reject) => {
            $axios.put(`/raporpetra/${kode}`, state.raporpetra)
            .then((response) => {
                commit('CLEAR_FORM')
                resolve(response.data)
            })
        })
    },
    editNilaiPetra({commit,state}, payload){
        let uuid = payload
        return new Promise((resolve, reject) => {
            $axios.get(`/raporpetra/${uuid}/edit`)
            .then((response) => {
                commit('PETRA_FORM', response.data.data)
                resolve(response.data)
            })
        })
    },
    getKompetensi({ commit, state }, payload){
        let jenjangs = 7
        return new Promise((resolve, reject) => {
            $axios.get(`/kompetensi?j=${jenjangs}&r=sisipan&s=active`)
            .then((response) => {
                commit('KOMPETENSI_DATA', response.data.data)
                resolve(response.data)
            })
        })
    },
    setTP({commit, state}){
        return new Promise((resolve, reject) => {
            $axios.post(`/settingsisipan`, state.settingTP)
            .then((response) => {
                resolve(response.data)
            })
        })
    },
    getSettingSisipan({commit, state}){
        return new Promise((resolve) => {
            $axios.get(`/settingsisipan`)
            .then((response) => {
                commit('SETTING_SISIPAN', response.data.data)
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
