import $axios from '../api.js'

const state = () => ({
    siswas: [],
    siswaaktif: [],

    siswa: {
        s_nis: '',
        s_nisn: '',
        s_nik: '',
        s_code: '',
        s_nama: '',
        s_kelamin: '',
        s_kelas: '',
        s_tempat_lahir: '',
        s_tanggal_lahir: '',
        s_tinggi: '',
        s_berat: '',
        s_status: '',
        s_sekolahasal: '',
        s_notelp: '',
        s_nohandphone: '',
        s_poin: '',
        s_anak_ke: '',
        s_ibu_nama: '',
        s_ibu_tanggal_lahir: '',
        s_ibu_nik: '',
        s_ibu_pekerjaan: '',
        s_ayah_nama: '',
        s_ayah_tanggal_lahir: '',
        s_ayah_nik: '',
        s_ayah_pekerjaan: '',
        s_kk_alamat:'',
        s_wali_nama:'',
        s_wali_pekerjaan:'',
        s_agama: '',
        s_jarak_rumah: '',
        s_jarak_rumah_km: '',
        s_jenis_tinggal: '',
        s_transportasi: '',
        s_email: '',
        s_akta_nama: '',
        s_akta_nomor: '',
        s_akta_tempat_lahir: '',
        s_akta_tanggal_lahir: '',
        s_akta_nama_ayah : '',
        s_akta_nama_ibu: '',
        s_ayah_pendidikan: '',
        s_ayah_penghasilan: '',
        s_ibu_pendidikan: '',
        s_ibu_penghasilan: '',
        s_kk_nomor: '',
        s_wali_nik: '',
        s_wali_pendidikan: '',
        s_wali_penghasilan: '',
        s_wali_tanggal_lahir: '',
        s_kk_rt: '',
        s_kk_rw: '',
        s_kk_kodepos: '',
        s_kk_kelurahan: '',
        s_kk_kecamatan: '',
        s_kk_kota: '',
        s_domisili_rt: '',
        s_domisili_rw: '',
        s_domisili_kodepos: '',
        s_domisili_kelurahan: '',
        s_domisili_kecamatan: '',
        s_domisili_kota: '',
        s_ayah_perusahaan: '',
        s_ayah_jabatan: '',
        s_ibu_perusahaan: '',
        s_ibu_jabatan: '',
        s_keterangan: '',
        kelas: []
    },
    page: 1
})

const mutations = {
    SISWA_AKTIF(state, payload){
        state.siswaaktif = payload
    },
    ASSIGN_DATA(state, payload) {
        state.siswas = payload
    },
    SET_PAGE(state, payload) {
        state.page = payload
    },
    ASSIGN_FORM(state, payload) {
        state.siswa = {
            s_nis: payload.s_nis,
            s_nisn: payload.s_nisn,
            s_nik: payload.s_nik,
            s_code: payload.s_code,
            s_nama: payload.s_nama,
            s_kelamin: payload.s_kelamin,
            s_kelas: payload.s_kelas,
            s_tempat_lahir: payload.s_tempat_lahir,
            s_tanggal_lahir: payload.s_tanggal_lahir,
            s_tinggi: payload.s_tinggi,
            s_berat: payload.s_berat,
            s_status: payload.s_status,
            s_sekolahasal: payload.s_sekolahasal,
            s_notelp: payload.s_notelp,
            s_nohandphone: payload.s_nohandphone,
            s_poin: payload.s_poin,
            s_anak_ke: payload.s_anak_ke,
            s_ibu_nama: payload.s_ibu_nama,
            s_ibu_tanggal_lahir: payload.s_ibu_tanggal_lahir,
            s_ibu_nik: payload.s_ibu_nik,
            s_ibu_pekerjaan: payload.s_ibu_pekerjaan,
            s_ayah_nama: payload.s_ayah_nama,
            s_ayah_tanggal_lahir: payload.s_ayah_tanggal_lahir,
            s_ayah_nik: payload.s_ayah_nik,
            s_ayah_pekerjaan: payload.s_ayah_pekerjaan,
            s_kk_alamat: payload.s_kk_alamat,
            s_wali_nama: payload.s_wali_nama,
            s_wali_pekerjaan: payload.s_wali_pekerjaan,
            s_agama: payload.s_agama,
            s_jarak_rumah: payload.s_jarak_rumah,
            s_jarak_rumah_km: payload.s_jarak_rumah_km,
            s_jenis_tinggal: payload.s_jenis_tinggal,
            s_transportasi: payload.s_transportasi,
            s_email: payload.s_email,
            s_akta_nama: payload.s_akta_nama,
            s_akta_nomor: payload.s_akta_nomor,
            s_akta_tempat_lahir: payload.s_akta_tempat_lahir,
            s_akta_tanggal_lahir: payload.s_akta_tanggal_lahir,
            s_akta_nama_ayah : payload.s_akta_nama_ayah,
            s_akta_nama_ibu: payload.s_akta_nama_ibu,
            s_ayah_pendidikan: payload.s_ayah_pendidikan,
            s_ayah_penghasilan: payload.s_ayah_penghasilan,
            s_ibu_pendidikan: payload.s_ibu_pendidikan,
            s_ibu_penghasilan: payload.s_ibu_penghasilan,
            s_kk_nomor: payload.s_kk_nomor,
            s_wali_nik: payload.s_wali_nik,
            s_wali_pendidikan: payload.s_wali_pendidikan,
            s_wali_penghasilan: payload.s_wali_penghasilan,
            s_wali_tanggal_lahir: payload.s_wali_tanggal_lahir,
            s_kk_rt: payload.s_kk_rt,
            s_kk_rw: payload.s_kk_rw,
            s_kk_kodepos: payload.s_kk_kodepos,
            s_kk_kelurahan: payload.s_kk_kelurahan,
            s_kk_kecamatan: payload.s_kk_kecamatan,
            s_kk_kota: payload.s_kk_kota,
            s_domisili_rt: payload.s_domisili_rt,
            s_domisili_rw: payload.s_domisili_rw,
            s_domisili_kodepos: payload.s_domisili_kodepos,
            s_domisili_kelurahan: payload.s_domisili_kelurahan,
            s_domisili_kecamatan: payload.s_domisili_kecamatan,
            s_domisili_kota: payload.s_domisili_kota,
            s_ayah_perusahaan: payload.s_ayah_perusahaan,
            s_ayah_jabatan: payload.s_ayah_jabatan,
            s_ibu_perusahaan: payload.s_ibu_perusahaan,
            s_ibu_jabatan: payload.s_ibu_jabatan,
            s_keterangan: payload.s_keterangan,
            kelas: payload.kelas
        }
    },
    CLEAR_FORM(state) {
        state.siswa = {
            s_nis: '',
            s_nisn: '',
            s_nik: '',
            s_code: '',
            s_nama: '',
            s_kelamin: '',
            s_kelas: '',
            s_tempat_lahir: '',
            s_tanggal_lahir: '',
            s_tinggi: '',
            s_berat: '',
            s_status: '',
            s_sekolahasal: '',
            s_notelp: '',
            s_nohandphone: '',
            s_poin: '',
            s_anak_ke: '',
            s_ibu_nama: '',
            s_ibu_tanggal_lahir: '',
            s_ibu_nik: '',
            s_ibu_pekerjaan: '',
            s_ayah_nama: '',
            s_ayah_tanggal_lahir: '',
            s_ayah_nik: '',
            s_ayah_pekerjaan: '',
            s_kk_alamat:'',
            s_wali_nama:'',
            s_wali_pekerjaan:'',
            s_agama: '',
            s_jarak_rumah: '',
            s_jarak_rumah_km: '',
            s_jenis_tinggal: '',
            s_transportasi: '',
            s_email: '',
            s_akta_nama: '',
            s_akta_nomor: '',
            s_akta_tempat_lahir: '',
            s_akta_tanggal_lahir: '',
            s_akta_nama_ayah : '',
            s_akta_nama_ibu: '',
            s_ayah_pendidikan: '',
            s_ayah_penghasilan: '',
            s_ibu_pendidikan: '',
            s_ibu_penghasilan: '',
            s_kk_nomor: '',
            s_wali_nik: '',
            s_wali_pendidikan: '',
            s_wali_penghasilan: '',
            s_wali_tanggal_lahir: '',
            s_kk_rt: '',
            s_kk_rw: '',
            s_kk_kodepos: '',
            s_kk_kelurahan: '',
            s_kk_kecamatan: '',
            s_kk_kota: '',
            s_domisili_rt: '',
            s_domisili_rw: '',
            s_domisili_kodepos: '',
            s_domisili_kelurahan: '',
            s_domisili_kecamatan: '',
            s_domisili_kota: '',
            s_ayah_perusahaan: '',
            s_ayah_jabatan: '',
            s_ibu_perusahaan: '',
            s_ibu_jabatan: '',
            s_keterangan: '',
            kelas: []
        }
    }
}

const actions = {
    siswaAktif({commit, state}){
        return new Promise((resolve, reject) => {
            $axios.get(`/siswas/rekap`)
            .then((response) => {
                commit('SISWA_AKTIF', response.data)
                console.log(response.data)
                resolve(response.data)
                
            })
        })
    },
    
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