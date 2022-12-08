<template>
    <div class="row">
        <div class="col-lg-6">
            <p style="background-color: #5A8DEE; color:white; font-size:15px; text-align:center">ABSENSI</p>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label>Sakit</label>
                    <input type="number" class="form-control" v-model="walikelas.ra_catatan_sakit">
                </div>
                <div class="form-group col-sm-4">
                    <label>Ijin</label>
                    <input type="number" class="form-control" v-model="walikelas.ra_catatan_ijin">
                </div>
                <div class="form-group col-sm-4">
                    <label>Alpha</label>
                    <input type="number" class="form-control" v-model="walikelas.ra_catatan_alpha">
                </div>
            </div>
            <p style="background-color: #5A8DEE; color:white; font-size:15px; text-align:center">EKSTRA1</p>
            <div class="row">
                <div class="form-group col-sm-3">
                    <select type="text" class="form-control"  v-model="walikelas.ra_ekstra1_nilai" >
                        <option value=''></option>
                        <option>A</option>
                        <option>B</option>
                        <option>C</option>
                    </select>
                </div>
                <div class="form-group col-sm-9">
                    <textarea cols="6" rows="2" class="form-control" v-model="walikelas.ra_ekstra1_kegiatan"></textarea>
                </div>
            </div>
            <p style="background-color: #5A8DEE; color:white; font-size:15px; text-align:center">EKSTRA2</p>
            <div class="row">
                <div class="form-group col-sm-3">
                    <select type="text" class="form-control"  v-model="walikelas.ra_ekstra2_nilai" >
                        <option value=''></option>
                        <option>A</option>
                        <option>B</option>
                        <option>C</option>
                    </select>
                </div>
                <div class="form-group col-sm-9">
                    <textarea cols="6" rows="2" class="form-control" v-model="walikelas.ra_ekstra2_kegiatan"></textarea>
                </div>
            </div>
            <p style="background-color: #5A8DEE; color:white; font-size:15px; text-align:center">EKSTRA3</p>
            <div class="row">
                <div class="form-group col-sm-3">
                    <select type="text" class="form-control"  v-model="walikelas.ra_ekstra3_nilai" >
                        <option value=''></option>
                        <option>A</option>
                        <option>B</option>
                        <option>C</option>
                    </select>
                </div>
                <div class="form-group col-sm-9">
                    <textarea cols="6" rows="2" class="form-control" v-model="walikelas.ra_ekstra3_kegiatan"></textarea>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <p style="background-color: #5A8DEE; color:white; font-size:15px; text-align:center">BIBLICAL</p>
            <div class="form-group">
                <label>Ayat Alkitab</label>
                <input type="text" class="form-control" v-model="walikelas.ra_catatan_ayat">
            </div>
            <div class="form-group">
                <label>Isi Ayat</label>
                <textarea cols="6" rows="5" class="form-control" v-model="walikelas.ra_catatan_isi" ></textarea>
            </div>
            <div class="form-group">
                <label>Catatan Wali Kelas</label>
                <textarea cols="6" rows="5" class="form-control" v-model="walikelas.ra_catatan_pesan" ></textarea>
            </div>
        </div>
    </div>
</template>
<script>

import { mapState, mapMutations } from 'vuex'

export default {
    name: 'WalikelasForm',
    created() {
    },
    computed: {
        ...mapState('raporakhir',{
            walikelas: state => state.walikelas
        })
    },
    methods: {
        ...mapMutations('raporakhir', ['CLEAR_FORM']),
    },
    destroyed() {
        this.CLEAR_FORM()
    },
}
</script>
