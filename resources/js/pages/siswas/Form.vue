<template>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="form-group" :class="{ 'has-error': errors.siswa_nis }">
                    <label for="">NIS</label>
                    <input type="text" class="form-control" v-model="siswa.siswa_nis" :readonly="$route.name == 'siswas.edit' || $route.name == 'siswas.view'">
                    <p class="text-danger" v-if="errors.siswa_nis">{{ errors.siswa_nis[0] }}</p>    
                </div>
                <div class="col-md-2"></div>
                <div class="form-group" :class="{ 'has-error': errors.siswa_nis }">
                   <label for="">NISN</label>
                    <input type="text" class="form-control" v-model="siswa.siswa_nisn" :readonly="$route.name == 'siswas.edit' || $route.name == 'siswas.view'">
                    <p class="text-danger" v-if="errors.siswa_nisn">{{ errors.siswa_nisn[0] }}</p>   
                </div> 
            </div>
            <div class="row">
                <div class="form-group" :class="{ 'has-error': errors.siswa_nik }">
                    <label for="">NIK</label>
                    <input type="text" class="form-control" v-model="siswa.siswa_nik" :readonly="$route.name == 'siswas.view'">
                    <p class="text-danger" v-if="errors.siswa_nik">{{ errors.siswa_nik[0] }}</p>
                </div>
                <div class="col-md-2"></div>
                <div class="form-group" :class="{ 'has-error': errors.siswa_code }">
                    <label for="">Code</label>
                    <input type="text" class="form-control" v-model="siswa.siswa_code" :readonly="$route.name == 'siswas.view'">
                    <p class="text-danger" v-if="errors.siswa_code">{{ errors.siswa_code[0] }}</p>
                </div>
            </div>
            <br>
            <div class="row" :class="{ 'has-error': errors.siswa_nama }">
                <div class="col-md-4"><label for="">Nama Siswa</label></div>
                <div class="col-md-8"><textarea rows="2" class="form-control" v-model="siswa.siswa_nama" :readonly="$route.name == 'siswas.view'"></textarea></div>
                <p class="text-danger" v-if="errors.siswa_nama">{{ errors.siswa_nama[0] }}</p>
            </div>
            <br>
            <div class="row" :class="{ 'has-error': errors.siswa_kelamin }">
                <div class="col-md-4"><label for="">Jenis Kelamin</label><br></div>
                <div class="col-md-4">
                <input type="radio" id="PL1" value="Laki-laki" v-model="siswa.siswa_kelamin" :readonly="$route.name == 'siswas.view'">
                <label for="PL1">Laki-laki</label>
                </div>
                <div class="col-md-4">
                <input type="radio" id="PL2" value="Perempuan" v-model="siswa.siswa_kelamin" :readonly="$route.name == 'siswas.view'">
                <label for="PL2">Perempuan</label>
                </div>
                <p class="text-danger" v-if="errors.siswa_kelamin">{{ errors.siswa_kelamin[0] }}</p>
            </div>
            <br>
            <div class="row" :class="{ 'has-error': errors.siswa_alamat }">
                <div class="col-md-4"><label for="">Alamat</label></div>
                <div class="col-md-8"><textarea cols="5" rows="5" class="form-control" v-model="siswa.siswa_alamat" :readonly="$route.name == 'siswas.view'"></textarea></div>
                <p class="text-danger" v-if="errors.siswa_alamat">{{ errors.siswa_alamat[0] }}</p>
            </div>
            <br>
            <div class="row" :class="{ 'has-error': errors.siswa_tempatlahir }">
                <div class="col-md-4"><label for="">Tempat Lahir</label></div>
                <div class="col-md-8"><input type="text" class="form-control" v-model="siswa.siswa_tempatlahir" :readonly="$route.name == 'siswas.view'"></div>
                <p class="text-danger" v-if="errors.siswa_tempatlahir">{{ errors.siswa_tempatlahir[0] }}</p>
            </div><br>
            <div class="row" :class="{ 'has-error': errors.siswa_tanggallahir }">
                <div class="col-md-4"><label for="">Tanggal Lahir</label></div>
                <div class="col-md-8"><input type="date" class="form-control" v-model="siswa.siswa_tanggallahir" :readonly="$route.name == 'siswas.view'"></div>
                <p class="text-danger" v-if="errors.siswa_tanggallahir">{{ errors.siswa_tanggallahir[0] }}</p>
            </div><br>
            <div class="row" :class="{ 'has-error': errors.siswa_agama }">
                <div class="col-md-4"><label for="">Agama</label></div>
                <div class="col-md-8">
                    <select class="form-control" v-model="siswa.siswa_agama" :readonly="$route.name == 'siswas.view'">
                    <option>Kristen</option>
                    <option>Katolik</option>
                    <option>Islam</option>
                    <option>Budha</option>
                    <option>Konghucu</option>
                    <option>Hindu</option>
                    </select>
                </div>
                <p class="text-danger" v-if="errors.siswa_agama">{{ errors.siswa_agama[0] }}</p>
            </div><br>
            <div class="row">
                <div class="col-md-4"><label for="">Keluarga</label></div>
                <div class="col-md-4">
                    <div class="form-group" :class="{ 'has-error': errors.siswa_status }">
                        <label for="">Status</label>
                        <select class="form-control" v-model="siswa.siswa_status" :readonly="$route.name == 'siswas.view'">
                        <option selected>Anak Kandung</option>
                        <option>Anak Angkat</option>
                        <option>Anak Tiri</option>
                        <option>Anak Haram</option>
                        </select>
                        <p class="text-danger" v-if="errors.siswa_status">{{ errors.siswa_status[0] }}</p>    
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-3">
                    <div class="form-group" :class="{ 'has-error': errors.siswa_anakke }">
                    <label for="">Anak ke-</label>
                    <input type="text" class="form-control" v-model="siswa.siswa_anakke" :readonly="$route.name == 'siswas.view'">
                    <p class="text-danger" v-if="errors.siswa_anakke">{{ errors.siswa_anakke[0] }}</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="row" :class="{ 'has-error': errors.siswa_sekolahasal }">
                <div class="col-md-4"><label for="">Sekolah Asal</label></div>
                <div class="col-md-8"><input type="text" class="form-control" v-model="siswa.siswa_sekolahasal" :readonly="$route.name == 'siswas.view'"></div>
                <p class="text-danger" v-if="errors.siswa_sekolahasal">{{ errors.siswa_sekolahasal[0] }}</p>
            </div><br>
            <div class="row" :class="{ 'has-error': errors.siswa_notelp }">
                <div class="col-md-4"><label for="">Telp</label></div>
                <div class="col-md-8"><input type="text" class="form-control" v-model="siswa.siswa_notelp" :readonly="$route.name == 'siswas.view'"></div>
                <p class="text-danger" v-if="errors.siswa_notelp">{{ errors.siswa_notelp[0] }}</p>
            </div><br>
            <div class="row" :class="{ 'has-error': errors.siswa_nohandphone }">
                <div class="col-md-4"><label for="">Handphone</label></div>
                <div class="col-md-8"><input type="text" class="form-control" v-model="siswa.siswa_nohandphone" :readonly="$route.name == 'siswas.view'"></div>
                <p class="text-danger" v-if="errors.siswa_nohandphone">{{ errors.siswa_nohandphone[0] }}</p>
            </div><br>
        </div>
        <div class="col-md-6">
            <div class="row" :class="{ 'has-error': errors.siswa_namaibu }">
                <div class="col-md-4"><label for="">Nama Ibu</label></div>
                <div class="col-md-8"><input type="text" class="form-control" v-model="siswa.siswa_namaibu" :readonly="$route.name == 'siswas.view'"></div>
                <p class="text-danger" v-if="errors.siswa_namaibu">{{ errors.siswa_namaibu[0] }}</p>
            </div><br>
            <div class="row" :class="{ 'has-error': errors.siswa_ttlibu }">
                <div class="col-md-4"><label for="">Tanggal Lahir Ibu</label></div>
                <div class="col-md-8"><input type="date" class="form-control" v-model="siswa.siswa_ttlibu" :readonly="$route.name == 'siswas.view'"></div>
                <p class="text-danger" v-if="errors.siswa_ttlibu">{{ errors.siswa_ttlibu[0] }}</p>
            </div><br>
            <div class="row" :class="{ 'has-error': errors.siswa_nikibu }">
                <div class="col-md-4"><label for="">NIK Ibu</label></div>
                <div class="col-md-8"><input type="text" class="form-control" v-model="siswa.siswa_nikibu" :readonly="$route.name == 'siswas.view'"></div>
                <p class="text-danger" v-if="errors.siswa_nikibu">{{ errors.siswa_nikibu[0] }}</p>
            </div><br>
            <div class="row" :class="{ 'has-error': errors.siswa_pekerjaanibu }">
                <div class="col-md-4"><label for="">Pekerjaan Ibu</label></div>
                <div class="col-md-8"><input type="text" class="form-control" v-model="siswa.siswa_pekerjaanibu" :readonly="$route.name == 'siswas.view'"></div>
                <p class="text-danger" v-if="errors.siswa_pekerjaanibu">{{ errors.siswa_pekerjaanibu[0] }}</p>
            </div><br>
            <div class="row" :class="{ 'has-error': errors.siswa_namaayahn }">
                <div class="col-md-4"><label for="">Nama Ayah</label></div>
                <div class="col-md-8"><input type="text" class="form-control" v-model="siswa.siswa_namaayahn" :readonly="$route.name == 'siswas.view'"></div>
                <p class="text-danger" v-if="errors.siswa_namaayah">{{ errors.siswa_namaayahn[0] }}</p>
            </div><br>
            <div class="row" :class="{ 'has-error': errors.siswa_ttlayah }">
                <div class="col-md-4"><label for="">Tanggal Lahir Ayah</label></div>
                <div class="col-md-8"><input type="date" class="form-control" v-model="siswa.siswa_ttlayah" :readonly="$route.name == 'siswas.view'"></div>
                <p class="text-danger" v-if="errors.siswa_ttlayah">{{ errors.siswa_ttlayah[0] }}</p>
            </div><br>
            <div class="row" :class="{ 'has-error': errors.siswa_nikayah }">
                <div class="col-md-4"><label for="">NIK Ayah</label></div>
                <div class="col-md-8"><input type="text" class="form-control" v-model="siswa.siswa_nikayah" :readonly="$route.name == 'siswas.view'"></div>
                <p class="text-danger" v-if="errors.siswa_nikaya">{{ errors.siswa_nikayah[0] }}</p>
            </div><br>
            <div class="row" :class="{ 'has-error': errors.siswa_pekerjaanayah }">
                <div class="col-md-4"><label for="">Pekerjaan Ayah</label></div>
                <div class="col-md-8"><input type="text" class="form-control" v-model="siswa.siswa_pekerjaanayah" :readonly="$route.name == 'siswas.view'"></div>
                <p class="text-danger" v-if="errors.siswa_pekerjaanayah">{{ errors.siswa_pekerjaanayah[0] }}</p>
            </div><br>
            <div class="row" :class="{ 'has-error': errors.siswa_alamatortu }">
                <div class="col-md-4"><label for="">Alamat Orang Tua</label></div>
                <div class="col-md-8"><textarea cols="5" rows="5" class="form-control" v-model="siswa.siswa_alamatortu" :readonly="$route.name == 'siswas.view'"></textarea></div>
                <p class="text-danger" v-if="errors.siswa_alamatortu">{{ errors.siswa_alamatortu[0] }}</p>
            </div><br>
            <div class="row" :class="{ 'has-error': errors.siswa_wali }">
                <div class="col-md-4"><label for="">Nama Wali</label></div>
                <div class="col-md-8"><input type="text" class="form-control" v-model="siswa.siswa_wali" :readonly="$route.name == 'siswas.view'"></div>
                <p class="text-danger" v-if="errors.siswa_wali">{{ errors.siswa_wali[0] }}</p>
            </div><br>
            <div class="row" :class="{ 'has-error': errors.siswa_pekerjaanwali }">
                <div class="col-md-4"><label for="">Pekerjaan Wali</label></div>
                <div class="col-md-8"><input type="text" class="form-control" v-model="siswa.siswa_pekerjaanwali" :readonly="$route.name == 'siswas.view'"></div>
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