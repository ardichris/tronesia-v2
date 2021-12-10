<template>
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form form="">
                    <p style="background-color: #5A8DEE; color:white; font-size:20px; text-align:center">DATA SISWA</p>
                    <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Nama</label><span class="badge badge-danger" style="margin-left : 5px">!</span>
                            <input type="text" class="form-control" v-model="siswa.s_nama" :readonly="$route.name == 'siswas.view'">
                        </div>
                        <div class="form-group">
                            <label>NIS/NISN/Student Code</label><span class="badge badge-danger" style="margin-left : 5px">!</span>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" v-model="siswa.s_nis" :readonly="$route.name == 'siswas.view' || authenticated.role!=0">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" v-model="siswa.s_nisn" :readonly="$route.name == 'siswas.view' || authenticated.role!=0">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" v-model="siswa.s_code" :readonly="$route.name == 'siswas.view' || authenticated.role!=0">
                                </div>
                            </div>
                        </div>
                            <div class="form-group">
                                <label>Tempat Tanggal Lahir</label><span class="badge badge-danger" style="margin-left : 5px">!</span>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Tempat lahir" v-model="siswa.s_tempat_lahir" :readonly="$route.name == 'siswas.view'">
                                    </div>
                                    <div class="col">
                                        <input type="date" class="form-control" placeholder="dd-mm-yyyy" v-model="siswa.s_tanggal_lahir" :readonly="$route.name == 'siswas.view'">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group validate">
                                <label>J. Kelamin/Anak ke/Status Anak</label><span class="badge badge-danger" style="margin-left : 5px">!</span>
                                <div class="row">
                                    <div class="col">
                                        <select type="text" class="form-control" aria-invalid="false" v-model="siswa.s_kelamin" :readonly="$route.name == 'siswas.view'">
                                            <option>Laki-laki</option>
                                            <option>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" aria-invalid="false" v-model="siswa.s_anak_ke" :readonly="$route.name == 'siswas.view'">
                                    </div>
                                    <div class="col">
                                        <select type="text" class="form-control" aria-invalid="false" v-model="siswa.s_status" :readonly="$route.name == 'siswas.view'">
                                            <option>KANDUNG</option>
                                            <option>ANGKAT</option>
                                            <option>TIRI</option>
                                            <option>TITIPAN</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>NIK</label><span class="badge badge-danger" style="margin-left : 5px">!</span>
                                <input type="text" class="form-control" v-model="siswa.s_nik" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label>Keterangan (Jika tanpa NIK/Akta)</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Jarak Rumah Ke Sekolah</label>
                                <select type="text" class="form-control" v-model="siswa.s_jarak_rumah" :readonly="$route.name == 'siswas.view'"> 
                                    <option selected=""></option>
                                    <option value="Dekat">Dekat</option>
                                    <option value="Jauh">Jauh</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputJarak">Jarak ke Sekolah (km)</label>
                                <input type="text" class="form-control" v-model="siswa.s_jarak_rumah_km" :readonly="$route.name == 'siswas.view'">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="inputJenisTinggal">Jenis Tinggal</label>
                                <select class="form-control form-control" v-model="siswa.s_jenis_tinggal" :readonly="$route.name == 'siswas.view'">>Pilih
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
                                        <select type="password" class="form-control" aria-invalid="false" v-model="siswa.s_agama" :readonly="$route.name == 'siswas.view'">
                                            <option>Kristen</option>
                                            <option>Katolik</option>
                                            <option>Hindu</option>
                                            <option>Budha</option>
                                            <option>Konghucu</option>
                                            <option>Islam</option>
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
                                <input type="text" class="form-control" v-model="siswa.s_tinggi" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputBerat">Berat Badan (kg)</label>
                                <input type="text" class="form-control" v-model="siswa.s_berat" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputTransportasi">Alat Transportasi</label>
                                <select type="text" class="form-control" v-model="siswa.s_transportasi" :readonly="$route.name == 'siswas.view'">
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
                                <label for="inputTelpon">No. Telpon</label><span class="badge badge-danger" style="margin-left : 5px">!</span>
                                <input type="text" class="form-control" v-model="siswa.s_notelp" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputSekolahAsal">Sekolah Asal</label><span class="badge badge-danger" style="margin-left : 5px">!</span>
                                <input type="text" class="form-control" v-model="siswa.s_sekolahasal" :readonly="$route.name == 'siswas.view'">
                            </div>

                            <div class="form-group">
                                <label for="inputEmail">Email</label>
                                <input type="email" class="form-control" aria-describedby="emailHelp" v-model="siswa.s_email" :readonly="$route.name == 'siswas.view'">
                            </div>
                        </div>
                    </div>
                    <br>
                    <p style="background-color: #5A8DEE; color:white; font-size:20px; text-align:center">DATA AKTA KELAHIRAN</p>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="inputNamaAkta">Nama Sesuai Akta</label>
                                <input type="text" class="form-control" v-model="siswa.s_akta_nama" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputTempatAkta">Tempat Lahir Sesuai Akta</label>
                                <input type="text" class="form-control" v-model="siswa.s_akta_tempat_lahir" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputAyahAkta">Nama Ayah Sesuai Akta</label>
                                <input type="text" class="form-control" v-model="siswa.s_akta_nama_ayah" :readonly="$route.name == 'siswas.view'">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="inputNomorAkta">Nomor Akta</label>
                                <input type="text" class="form-control" v-model="siswa.s_akta_nomor" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputTanggalAkta">Tanggal Lahir Sesuai Akta</label>
                                <input type="text" class="form-control" v-model="siswa.s_akta_tanggal_lahir" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="namaIbuAkta">Nama Ibu Sesuai Akta</label>
                                <input type="text" class="form-control" v-model="siswa.s_akta_nama_ibu" :readonly="$route.name == 'siswas.view'">
                            </div>
                        </div>
                    </div>
                    <br>
                    <p style="background-color: #5A8DEE; color:white; font-size:20px; text-align:center">DATA ORANG TUA</p>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="inputAyah">Nama Ayah</label><span class="badge badge-danger" style="margin-left : 5px">!</span>
                                <input type="text" class="form-control" v-model="siswa.s_ayah_nama" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputLahirAyah">Tanggal Lahir Ayah</label><span class="badge badge-danger" style="margin-left : 5px">!</span>
                                <input type="date" class="form-control" v-model="siswa.s_ayah_tanggal_lahir" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputNIKAyah">NIK Ayah</label><span class="badge badge-danger" style="margin-left : 5px">!</span>
                                <input type="text" class="form-control" v-model="siswa.s_ayah_nik" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label>Pendidikan Ayah</label>
                                <select class="select2 form-control select2-hidden-accessible" v-model="siswa.s_ayah_pendidikan" :readonly="$route.name == 'siswas.view'" aria-hidden="true">
                                    <option>SD/SEDERAJAT</option>
                                    <option>SMP/SEDERAJAT</option>
                                    <option>TIDAK/BELUM SEKOLAH</option>
                                    <option>BELUM TAMAT SD/SEDERAJAT</option>
                                    <option>SMA/SEDERAJAT</option>
                                    <option>DIPLOMA I (D1)</option>
                                    <option>DIPLOMA III (D3)</option>
                                    <option>DIPLOMA IV (D4)/STRATA I (S1)</option>
                                    <option>STRATA II (S2)</option>
                                    <option>STRATA III (S3)</option>
                                    <option>DIPLOMA II (D2)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan Ayah</label>
                                <input type="text" class="form-control" v-model="siswa.s_ayah_pekerjaan" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label>Perusahaan Ayah</label>
                                <input type="text" class="form-control" v-model="siswa.s_ayah_perusahaan" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label>Jabatan Ayah</label>
                                <input type="text" class="form-control" v-model="siswa.s_ayah_jabatan" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group validate">
                                <label>Penghasilan Ayah</label>
                                <select class="form-control form-control" aria-invalid="false" v-model="siswa.s_ayah_penghasilan" :readonly="$route.name == 'siswas.view'">
                                    <option>Tidak Ada Penghasilan</option>
                                    <option>Rp.0 - Rp.500 Ribu</option>
                                    <option>Rp.500 Ribu - Rp.1 Juta</option>
                                    <option>Rp.1,5 Juta - Rp.2,5 Juta</option>
                                    <option>Rp.3 Juta - Rp.5 Juta</option>
                                    <option>Diatas Rp.5 Juta</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>No. KK(Kartu Keluarga)</label><span class="badge badge-danger" style="margin-left : 5px">!</span>
                                <input type="text" class="form-control" v-model="siswa.s_kk_nomor" :readonly="$route.name == 'siswas.view'">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="inputIbu">Nama Ibu</label><span class="badge badge-danger" style="margin-left : 5px">!</span>
                                <input type="text" class="form-control" v-model="siswa.s_ibu_nama" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputLahirIbu">Tanggal Lahir Ibu</label><span class="badge badge-danger" style="margin-left : 5px">!</span>
                                <input type="date" class="form-control" v-model="siswa.s_ibu_tanggal_lahir" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputNIKIbu">NIK Ibu</label><span class="badge badge-danger" style="margin-left : 5px">!</span>
                                <input type="text" class="form-control" v-model="siswa.s_ibu_nik" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputPendidikanIbu">Pendidikan Ibu</label>
                                <select class="select2 form-control form-control select2-hidden-accessible" aria-hidden="true" v-model="siswa.s_ibu_pendidikan" :readonly="$route.name == 'siswas.view'">
                                    <option>SD/SEDERAJAT</option>
                                    <option>SMP/SEDERAJAT</option>
                                    <option>TIDAK/BELUM SEKOLAH</option>
                                    <option>BELUM TAMAT SD/SEDERAJAT</option>
                                    <option>SMA/SEDERAJAT</option>
                                    <option>DIPLOMA I (D1)</option>
                                    <option>DIPLOMA III (D3)</option>
                                    <option>DIPLOMA IV (D4)/STRATA I (S1)</option>
                                    <option>STRATA II (S2)</option>
                                    <option>STRATA III (S3)</option>
                                    <option>DIPLOMA II (D2)</option>                                           
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan Ibu</label>
                                <input type="text" class="form-control" v-model="siswa.s_ibu_pekerjaan" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label>Perusahaan Ibu</label>
                                <input type="text" class="form-control" v-model="siswa.s_ibu_perusahaan" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label>Jabatan Ibu</label>
                                <input type="text" class="form-control" v-model="siswa.s_ibu_jabatan" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label>Penghasilan Ibu</label>
                                <select class="form-control form-control" v-model="siswa.s_ibu_penghasilan" :readonly="$route.name == 'siswas.view'">
                                    <option>Tidak Ada Penghasilan</option>
                                    <option>Rp.0 - Rp.500 Ribu</option>
                                    <option>Rp.500 Ribu - Rp.1 Juta</option>
                                    <option>Rp.1,5 Juta - Rp.2,5 Juta</option>
                                    <option>Rp.3 Juta - Rp.5 Juta</option>
                                    <option>Diatas Rp.5 Juta</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputHandphone">No. Kontak Orang Tua</label><span class="badge badge-danger" style="margin-left : 5px">!</span>
                                <input type="text" class="form-control" v-model="siswa.s_nohandphone" :readonly="$route.name == 'siswas.view'">
                            </div>
                        </div>
                    </div>
                    <br>
                    <p style="background-color: #5A8DEE; color:white; font-size:20px; text-align:center">DATA WALI</p>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Nama Wali</label>
                                <input type="text" class="form-control" v-model="siswa.s_wali_nama" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label>NIK Wali</label>
                                <input type="text" class="form-control" v-model="siswa.s_wali_nik" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan Wali</label>
                                <input type="text" class="form-control" v-model="siswa.s_wali_pekerjaan" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label>Alamat Rumah Wali </label>
                                <input type="text" class="form-control" v-model="siswa.s_wali_alamat" :readonly="$route.name == 'siswas.view'">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Tanggal Lahir Wali</label>
                                <input type="date" class="form-control" v-model="siswa.s_wali_tanggal_lahir" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label>Pendidikan Wali</label>
                                <select class="form-control form-control" aria-hidden="true" v-model="siswa.s_wali_pendidikan" :readonly="$route.name == 'siswas.view'">
                                    <option>SD/SEDERAJAT</option>
                                    <option>SMP/SEDERAJAT</option>
                                    <option>TIDAK/BELUM SEKOLAH</option>
                                    <option>BELUM TAMAT SD/SEDERAJAT</option>
                                    <option>SMA/SEDERAJAT</option>
                                    <option>DIPLOMA I (D1)</option>
                                    <option>DIPLOMA III (D3)</option>
                                    <option>DIPLOMA IV (D4)/STRATA I (S1)</option>
                                    <option>STRATA II (S2)</option>
                                    <option>STRATA III (S3)</option>
                                    <option>DIPLOMA II (D2)</option>                                           
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputPenghasilanWali">Penghasilan Wali</label>
                                <select class="form-control form-control" v-model="siswa.s_wali_penghasilan" :readonly="$route.name == 'siswas.view'">
                                    <option>Tidak Ada Penghasilan</option>
                                    <option>Rp.0 - Rp.500 Ribu</option>
                                    <option>Rp.500 Ribu - Rp.1 Juta</option>
                                    <option>Rp.1,5 Juta - Rp.2,5 Juta</option>
                                    <option>Rp.3 Juta - Rp.5 Juta</option>
                                    <option>Diatas Rp.5 Juta</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputTelpon">No. Telpon Wali</label>
                                <input type="text" class="form-control" v-model="siswa.s_wali_notelp" :readonly="$route.name == 'siswas.view'">
                            </div>
                        </div>
                    </div>
                    <br>
                    <p style="background-color: #5A8DEE; color:white; font-size:20px; text-align:center">DATA ALAMAT SESUAI KARTU KELUARGA</p>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Alamat Rumah </label>
                                <input type="text" class="form-control" v-model="siswa.s_kk_alamat" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>RT</label>
                                            <input type="text" class="form-control" v-model="siswa.s_kk_rt" :readonly="$route.name == 'siswas.view'">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>RW</label>
                                            <input type="text" class="form-control" v-model="siswa.s_kk_rw" :readonly="$route.name == 'siswas.view'">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Kodepos</label>
                                            <input type="text" class="form-control" v-model="siswa.s_kk_kodepos" :readonly="$route.name == 'siswas.view'">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Kelurahan</label>
                                    <input type="text" class="form-control" v-model="siswa.s_kk_kelurahan" :readonly="$route.name == 'siswas.view'">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <input type="text" class="form-control" v-model="siswa.s_kk_kecamatan" :readonly="$route.name == 'siswas.view'">                                        
                            </div>
                            <div class="form-group">
                                <label>Kabupaten/Kota</label>
                                <input type="text" class="form-control" v-model="siswa.s_kk_kota" :readonly="$route.name == 'siswas.view'">
                            </div>
                        </div>
                    </div>
                    <br>
                    <p style="background-color: #5A8DEE; color:white; font-size:20px; text-align:center">DATA ALAMAT DOMISILI SISWA</p>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="inputAlamatSiswa">Alamat Rumah </label>
                                <input type="text" class="form-control" v-model="siswa.s_domisili_alamat" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputRTRW">RT/RW </label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" v-model="siswa.s_domisili_rt" :readonly="$route.name == 'siswas.view'">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" v-model="siswa.s_domisili_rw" :readonly="$route.name == 'siswas.view'">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <input type="text" class="form-control" v-model="siswa.s_domisili_kecamatan" :readonly="$route.name == 'siswas.view'">
                             </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Kodepos</label>
                                <input type="text" class="form-control" v-model="siswa.s_domisili_kodepos" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputKotaSiswa">Kabupaten/Kota</label>
                                <input type="text" class="form-control" v-model="siswa.s_domisili_kota" :readonly="$route.name == 'siswas.view'">
                            </div>
                            <div class="form-group">
                                <label for="inputKelurahanSiswa">Kelurahan</label>
                                <input type="text" class="form-control" v-model="siswa.s_domisili_kelurahan" :readonly="$route.name == 'siswas.view'">
                            </div>
                        </div>
                    </div>
                    <br>
                    <p style="background-color: #5A8DEE; color:white; font-size:20px; text-align:center">STATUS SISWA</p>
                    <div class="row">
                        <div class="col-12 col-sm-6">

                            <div class="form-group">
                                <label >Status Siswa    </label>
                                <h4>
                                <span class="badge badge-danger" v-if="siswa.s_keterangan == 'ALUMNI'">Alumni</span>
                                <span class="badge badge-primary" v-if="siswa.s_keterangan == 'SISWA BARU'">Siswa Baru</span>
                                <span class="badge badge-success" v-if="siswa.s_keterangan == 'AKTIF'">Aktif</span>
                                </h4>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Kelas     </label>
                                <h4>
                                <span class="badge badge-warning">{{siswa.kelas}}</span>
                                <!-- <span class="badge badge-danger" v-if="siswa.kelas.kelas_jenjang == '8'">{{siswa.kelas.kelas_nama}}</span>
                                <span class="badge badge-primary" v-if="siswa.kelas.kelas_jenjang == '9'">{{siswa.kelas.kelas_nama}}</span>
                                <span class="badge badge-warning" v-if="siswa.kelas.kelas_jenjang == '7'">{{siswa.kelas.kelas_nama}}</span> -->
                                </h4>
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
        }),
        ...mapState('user', {
            authenticated: state => state.authenticated //ME-LOAD STATE AUTHENTICATED
        })
    },
    methods: {
        ...mapMutations('siswa', ['CLEAR_FORM']), //PANGGIL MUTATIONS CLEAR_FORM
    },
    //KETIKA PAGE INI DITINGGALKAN MAKA 
    destroyed() {
        //FORM DI BERSIHKAN
        this.CLEAR_FORM()
    },
    
}
</script>