<template>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': errors.siswa_nis }">
                <label for="">NIS</label>
                <input type="text" class="form-control" v-model="siswa.siswa_nis" :readonly="$route.name == 'siswas.edit' || $route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_nis">{{ errors.siswa_nis[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_nisn }">
                <label for="">NISN</label>
                <input type="text" class="form-control" v-model="siswa.siswa_nisn" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_nisn">{{ errors.siswa_nisn[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_nik }">
                <label for="">NIK</label>
                <input type="text" class="form-control" v-model="siswa.siswa_nik" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_nik">{{ errors.siswa_nik[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_nama }">
                <label for="">Nama Siswa</label>
                <input type="text" class="form-control" v-model="siswa.siswa_nama" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_nama">{{ errors.siswa_nama[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_kelamin }">
                <label for="">Jenis Kelamin</label>
                <input type="text" class="form-control" v-model="siswa.siswa_kelamin" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_kelamin">{{ errors.siswa_kelamin[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_kelas }">
                <label for="">Kelas</label>
                <input type="text" class="form-control" v-model="siswa.siswa_kelas" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_kelas">{{ errors.siswa_kelas[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_alamat }">
                <label for="">Alamat</label>
                <textarea cols="5" rows="5" class="form-control" v-model="siswa.siswa_alamat" :readonly="$route.name == 'siswas.view'"></textarea>
                <p class="text-danger" v-if="errors.siswa_alamat">{{ errors.siswa_alamat[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_tempatlahir }">
                <label for="">Tempat Lahir</label>
                <input type="text" class="form-control" v-model="siswa.siswa_tempatlahir" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_tempatlahir">{{ errors.siswa_tempatlahir[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_tanggallahir }">
                <label for="">Tanggal Lahir</label>
                <input type="date" class="form-control" v-model="siswa.siswa_tanggallahir" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_tanggallahir">{{ errors.siswa_tanggallahir[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_tinggi }">
                <label for="">Tinggi</label>
                <input type="text" class="form-control" v-model="siswa.siswa_tinggi" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_tinggi">{{ errors.siswa_tinggi[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_berat }">
                <label for="">Berat</label>
                <input type="text" class="form-control" v-model="siswa.siswa_berat" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_berat">{{ errors.siswa_berat[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_agama }">
                <label for="">Agama</label>
                <input type="text" class="form-control" v-model="siswa.siswa_agama" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_agama">{{ errors.siswa_agama[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_status }">
                <label for="">Status</label>
                <input type="text" class="form-control" v-model="siswa.siswa_status" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_status">{{ errors.siswa_status[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_sekolahasal }">
                <label for="">Sekolah Asal</label>
                <input type="text" class="form-control" v-model="siswa.siswa_sekolahasal" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_sekolahasal">{{ errors.siswa_sekolahasal[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_notelp }">
                <label for="">Telp</label>
                <input type="text" class="form-control" v-model="siswa.siswa_notelp" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_notelp">{{ errors.siswa_notelp[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_nohandphone }">
                <label for="">Handphone</label>
                <input type="text" class="form-control" v-model="siswa.siswa_nohandphone" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_nohandphone">{{ errors.siswa_nohandphone[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_poin }">
                <label for="">Poin</label>
                <input type="text" class="form-control" v-model="siswa.siswa_poin" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_poin">{{ errors.siswa_poin[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_anakke }">
                <label for="">Anak ke</label>
                <input type="text" class="form-control" v-model="siswa.siswa_anakke" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_anakke">{{ errors.siswa_anakke[0] }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': errors.siswa_namaibu }">
                <label for="">Nama Ibu</label>
                <input type="text" class="form-control" v-model="siswa.siswa_namaibu" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_namaibu">{{ errors.siswa_namaibu[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_ttlibu }">
                <label for="">Tanggal Lahir Ibu</label>
                <input type="date" class="form-control" v-model="siswa.siswa_ttlibu" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_ttlibu">{{ errors.siswa_ttlibu[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_nikibu }">
                <label for="">NIK Ibu</label>
                <input type="text" class="form-control" v-model="siswa.siswa_nikibu" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_nikibu">{{ errors.siswa_nikibu[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_pekerjaanibu }">
                <label for="">Pekerjaan Ibu</label>
                <input type="text" class="form-control" v-model="siswa.siswa_pekerjaanibu" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_pekerjaanibu">{{ errors.siswa_pekerjaanibu[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_namaayahn }">
                <label for="">Nama Ayah</label>
                <input type="text" class="form-control" v-model="siswa.siswa_namaayahn" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_namaayah">{{ errors.siswa_namaayahn[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_ttlayah }">
                <label for="">Tanggal Lahir Ayah</label>
                <input type="date" class="form-control" v-model="siswa.siswa_ttlayah" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_ttlayah">{{ errors.siswa_ttlayah[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_nikayah }">
                <label for="">NIK Ayah</label>
                <input type="text" class="form-control" v-model="siswa.siswa_nikayah" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_nikaya">{{ errors.siswa_nikayah[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_pekerjaanayah }">
                <label for="">Pekerjaan Ayah</label>
                <input type="text" class="form-control" v-model="siswa.siswa_pekerjaanayah" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_pekerjaanayah">{{ errors.siswa_pekerjaanayah[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_alamatortu }">
                <label for="">Alamat Orang Tua</label>
                <textarea cols="5" rows="5" class="form-control" v-model="siswa.siswa_alamatortu" :readonly="$route.name == 'siswas.view'"></textarea>
                <p class="text-danger" v-if="errors.siswa_alamatortu">{{ errors.siswa_alamatortu[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_wali }">
                <label for="">Nama Wali</label>
                <input type="text" class="form-control" v-model="siswa.siswa_wali" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_wali">{{ errors.siswa_wali[0] }}</p>
            </div>
            <div class="form-group" :class="{ 'has-error': errors.siswa_pekerjaanwali }">
                <label for="">Pekerjaan Wali</label>
                <input type="text" class="form-control" v-model="siswa.siswa_pekerjaanwali" :readonly="$route.name == 'siswas.view'">
                <p class="text-danger" v-if="errors.siswa_pekerjaanwali">{{ errors.siswa_pekerjaanwali[0] }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex'
export default {
    name: 'FormSiswas',
    computed: {
        ...mapState(['errors']), //MENGAMBIL STATE ERRORS
        ...mapState('siswa', {
            siswa: state => state.siswa //MENGAMBIL STATE SISWA
        })
    },
    methods: {
        ...mapMutations('siswa', ['CLEAR_FORM']), //PANGGIL MUTATIONS CLEAR_FORM
    },
    //KETIKA PAGE INI DITINGGALKAN MAKA 
    destroyed() {
        //FORM DI BERSIHKAN
        this.CLEAR_FORM()
    }
}
</script>