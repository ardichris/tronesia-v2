<template>
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form form="">
                    <p style="background-color: #5A8DEE; color:white; font-size:20px; text-align:center">DATA SISWA</p>
                    <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" v-model="siswa.siswa_nama" :readonly="$route.name == 'siswas.view'">
                        </div>
                        <div class="form-group">
                            <label>NIS/NISN/Student Code</label>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" v-model="siswa.siswa_nis" :readonly="$route.name == 'siswas.edit' || $route.name == 'siswas.view'">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" v-model="siswa.siswa_nisn" :readonly="$route.name == 'siswas.edit' || $route.name == 'siswas.view'">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" v-model="siswa.siswa_code" :readonly="$route.name == 'siswas.view'">
                                </div>
                            </div>
                        </div>
                            <div class="form-group">
                                <label>Tempat Tanggal Lahir</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Tempat lahir" v-model="siswa.siswa_tempatlahir" :readonly="$route.name == 'siswas.view'">
                                    </div>
                                    <div class="col">
                                        <input type="date" class="form-control" placeholder="ini datepicker" v-model="siswa.siswa_tanggallahir" :readonly="$route.name == 'siswas.view'">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group validate">
                                <label>J. Kelamin/Anak ke/Status Anak</label>
                                <div class="row">
                                    <div class="col">
                                        <select type="text" class="form-control" aria-invalid="false" v-model="siswa.siswa_kelamin" :readonly="$route.name == 'siswas.view'">
                                            <option selected=""></option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" aria-invalid="false" v-model="siswa.siswa_anakke" :readonly="$route.name == 'siswas.view'">
                                    </div>
                                    <div class="col">
                                        <select type="text" class="form-control" aria-invalid="false" v-model="siswa.siswa_status" :readonly="$route.name == 'siswas.view'">
                                            <option>KANDUNG</option>
                                            <option>ANGKAT</option>
                                            <option>TIRI</option>
                                            <option>TITIPAN</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" class="form-control" v-model="siswa.siswa_nik" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label>Keterangan (Jika tanpa NIK/Akta)</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Jarak Rumah Ke Sekolah</label>
                                <select type="text" class="form-control">
                                    <option selected=""></option>
                                    <option value="Dekat">Dekat</option>
                                    <option value="Jauh">Jauh</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputJarak">Jarak ke Sekolah (km)</label>
                                <input type="text" class="form-control" name="jarak_rmh_sekolah_km" id="inputJarak" value="">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="inputJenisTinggal">Jenis Tinggal</label>
                                <select class="form-control form-control">Pilih
                                    <option></option>
                                    <option>Orang Tua</option>
                                    <option>Wali</option>
                                    <option>Kost</option>
                                    <option>Asrama</option>
                                    <option>Panti Asuhan</option>
                                    <option>Pesantren</option>
                                    <option>Lainnya</option>
                                </select>
                            </div>
                            <div class="form-group validate">
                                <label for="exampleInputPassword1">Agama/Inklusi/KLK</label>
                                <div class="row">
                                    <div class="col">
                                        <select type="password" class="form-control" aria-invalid="false" v-model="siswa.siswa_agama" :readonly="$route.name == 'siswas.view'">
                                            <option>Islam</option>
                                            <option>Katholik</option>
                                            <option>Hindu</option>
                                            <option>Budha</option>
                                            <option>Lainnya</option>
                                            <option>Khonghucu</option>
                                            <option>Kristen</option>
                                            <option>Kepercayaan Terhadap Tuhan YME</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select type="password" class="form-control" aria-invalid="false">
                                            <option selected=""></option>
                                            <option value="YA">YA</option>
                                            <option value="TIDAK">TIDAK</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select type="password" class="form-control" aria-invalid="false">
                                            <option selected=""></option>
                                            <option>KLK</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputTinggi">Tinggi Badan (cm)</label>
                                <input type="text" class="form-control" v-model="siswa.siswa_tinggi" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputBerat">Berat Badan (kg)</label>
                                <input type="text" class="form-control" v-model="siswa.siswa_berat" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputTransportasi">Alat Transportasi</label>
                                <select type="text" class="form-control">
                                    <option>ANGKUTAN KOTA</option>
                                    <option>BUS KOTA</option>
                                    <option>OJEK</option>
                                    <option>SEPEDA MOTOR</option>
                                    <option>MOBIL</option>
                                    <option>BECAK</option>
                                    <option>JALAN KAKI</option>
                                    <option>SEPEDA</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputTelpon">No. Telpon</label>
                                <input type="text" class="form-control" v-model="siswa.siswa_notelp" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputHandphone">No. Handphone</label>
                                <input type="text" class="form-control" v-model="siswa.siswa_nohandphone" :readonly="$route.name == 'siswas.view'">
                            </div>

                            <div class="form-group">
                                <label for="inputEmail">Email</label>
                                <input type="email" class="form-control" aria-describedby="emailHelp">
                            </div>
                        </div>
                    </div>
                    <br>
                    <p style="background-color: #5A8DEE; color:white; font-size:20px; text-align:center">DATA AKTA KELAHIRAN</p>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="inputNamaAkta">Nama Sesuai Akta</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputTempatAkta">Tempat Lahir Sesuai Akta</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputAyahAkta">Nama Ayah Sesuai Akta</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="inputNomorAkta">Nomor Akta</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputTanggalAkta">Tanggal Lahir Sesuai Akta</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="namaIbuAkta">Nama Ibu Sesuai Akta</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <br>
                    <p style="background-color: #5A8DEE; color:white; font-size:20px; text-align:center">DATA ORANG TUA</p>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="inputAyah">Nama Ayah</label>
                                <input type="text" class="form-control" v-model="siswa.siswa_namaayahn" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputLahirAyah">Tanggal Lahir Ayah</label>
                                <input type="date" class="form-control" v-model="siswa.siswa_ttlayah" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputNIKAyah">NIK Ayah</label>
                                <input type="text" class="form-control" v-model="siswa.siswa_nikayah" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label>Pendidikan Ayah</label>
                                <select class="select2 form-control select2-hidden-accessible" name="pendidikan_ayah" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                    <option selected=""></option>
                                    <option value="03"> SD/SEDERAJAT </option>
                                    <option value="04"> SMP/SEDERAJAT </option>
                                    <option value="01"> TIDAK/BELUM SEKOLAH </option>
                                    <option value="02"> BELUM TAMAT SD/SEDERAJAT </option>
                                    <option value="05"> SMA/SEDERAJAT </option>
                                    <option value="06"> DIPLOMA I (D1) </option>
                                    <option value="08"> DIPLOMA III (D3) </option>
                                    <option value="09"> DIPLOMA IV (D4)/STRATA I (S1) </option>
                                    <option value="10"> STRATA II (S2) </option>
                                    <option value="11"> STRATA III (S3) </option>
                                    <option value="07"> DIPLOMA II (D2) </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan Ayah</label>
                                <input type="text" class="form-control" v-model="siswa.siswa_pekerjaanayah" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group validate">
                                <label>Penghasilan Ayah</label>
                                <select class="form-control form-control" aria-invalid="false">
                                    <option value="1"> Tidak Ada Penghasilan </option>
                                    <option value="2"> Rp.0 - Rp.500 Ribu </option>
                                    <option value="3"> Rp.500 Ribu - Rp.1 Juta </option>
                                    <option value="4"> Rp.1,5 Juta - Rp.2,5 Juta </option>
                                    <option value="5"> Rp.3 Juta - Rp.5 Juta </option>
                                    <option value="6"> Diatas Rp.5 Juta </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>No. KK(Kartu Keluarga)</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="inputIbu">Nama Ibu</label>
                                <input type="text" class="form-control" v-model="siswa.siswa_namaibu" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputLahirIbu">Tanggal Lahir Ibu</label>
                                <input type="date" class="form-control" v-model="siswa.siswa_ttlibu" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputNIKIbu">NIK Ibu</label>
                                <input type="text" class="form-control" v-model="siswa.siswa_nikibu" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputPendidikanIbu">Pendidikan Ibu</label>
                                <select class="select2 form-control form-control select2-hidden-accessible" aria-hidden="true">
                                    <option selected=""></option>
                                    <option value="03"> SD/SEDERAJAT </option>
                                    <option value="04"> SMP/SEDERAJAT </option>
                                    <option value="01"> TIDAK/BELUM SEKOLAH </option>
                                    <option value="02"> BELUM TAMAT SD/SEDERAJAT </option>
                                    <option value="05"> SMA/SEDERAJAT </option>
                                    <option value="06"> DIPLOMA I (D1) </option>
                                    <option value="08"> DIPLOMA III (D3) </option>
                                    <option value="09"> DIPLOMA IV (D4)/STRATA I (S1) </option>
                                    <option value="10"> STRATA II (S2) </option>
                                    <option value="11"> STRATA III (S3) </option>
                                    <option value="07"> DIPLOMA II (D2) </option>                                           
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan Ibu</label>
                                <input type="text" class="form-control" v-model="siswa.siswa_pekerjaanibu" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label>Penghasilan Ibu</label>
                                <select class="form-control form-control">
                                    <option value="1"> Tidak Ada Penghasilan </option>
                                    <option value="2"> Rp.0 - Rp.500 Ribu </option>
                                    <option value="3"> Rp.500 Ribu - Rp.1 Juta </option>
                                    <option value="4"> Rp.1,5 Juta - Rp.2,5 Juta </option>
                                    <option value="5"> Rp.3 Juta - Rp.5 Juta </option>
                                    <option value="6"> Diatas Rp.5 Juta </option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <br>
                    <p style="background-color: #5A8DEE; color:white; font-size:20px; text-align:center">DATA WALI</p>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="inputWali">Nama Wali</label>
                                <input type="text" class="form-control" v-model="siswa.siswa_wali" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputNIKWali">NIK Wali</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputPekerjaanWali">Pekerjaan Wali</label>
                                <input type="text" class="form-control" v-model="siswa.siswa_pekerjaanwali" :readonly="$route.name == 'siswas.view'">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="inputLahirWali">Tanggal Lahir Wali</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputPendidikanWali">Pendidikan Wali</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputPenghasilanWali">Penghasilan Wali</label>
                                <select class="form-control form-control" name="penghasilan_wali" id="inputPenghasilanWali">
                                    <option selected="">Pilih Rentang Penghasilan</option>
                                    <option>Tidak ada penghasilan</option>
                                    <option>Rp. 0.00 - Rp.500.000</option>
                                    <option>Rp.500.000 - Rp.1.000.000</option>
                                    <option>Rp. 1.500.000 - Rp.2.500.000</option>
                                    <option>Rp. 3.000.000 - Rp.5.000.000</option>
                                    <option>Di atas Rp.5.000.000</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <p style="background-color: #5A8DEE; color:white; font-size:20px; text-align:center">DATA ALAMAT SESUAI KARTU KELUARGA</p>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Alamat Rumah </label>
                                <input type="text" class="form-control" v-model="siswa.siswa_alamatortu" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>RT</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>RW</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Kodepos</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Kelurahan</label>
                                <input type="text" class="form-control">
                                </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <input type="text" class="form-control">                                        
                            </div>
                            <div class="form-group">
                                <label>Kabupaten/Kota</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <br>
                    <p style="background-color: #5A8DEE; color:white; font-size:20px; text-align:center">DATA ALAMAT DOMISILI SISWA</p>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="inputAlamatSiswa">Alamat Rumah </label>
                                <input type="text" class="form-control" v-model="siswa.siswa_alamat" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputRTRW">RT/RW </label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <input type="text" class="form-control">
                             </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Kodepos</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputKotaSiswa">Kabupaten/Kota</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputKelurahanSiswa">Kelurahan</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <br>
                    <p style="background-color: #5A8DEE; color:white; font-size:20px; text-align:center">STATUS SISWA</p>
                    <div class="row">
                        <div class="col-12 col-sm-6">

                            <div class="form-group">
                                <label >Status Siswa</label>
                                <input type="text" class="form-control" disabled="">
                            </div>
                            <div class="form-group">
                                <label>Jenjang</label>
                                <input type="text" class="form-control" disabled="">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Jurusan</label>
                                <input type="text" class="form-control" disabled="">
                            </div>
                            <div class="form-group">
                                <label>Kelas</label>
                                <input type="text" class="form-control" disabled="">
                            </div>
                        </div>
                    </div>
                    <!--  <button class="btn btn-primary mx-auto d-block" type="submit" style="width:200px">Simpan</button> -->
                </form>
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