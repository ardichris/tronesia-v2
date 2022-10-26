<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary" size="sm">Sisipan</button>
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                            <div class="dropdown-menu" role="menu" style="">
                                <a class="dropdown-item" @click="$bvModal.show('modal-sisipan')" v-if="authenticated.role==0">Upload Ledger</a>
                                <a class="dropdown-item" @click="settingsisipan" v-if="authenticated.role==0">Setting Sisipan</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" @click="$bvModal.show('modal-export')"  v-if="authenticated.role==0">Export Ledger</a>
                            </div>
                            </button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success" size="sm">Final</button>
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                            <div class="dropdown-menu" role="menu" style="">
                                <a class="dropdown-item" @click="$bvModal.show('modal-import')"  v-if="authenticated.role==0">Upload Ledger</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" @click="$bvModal.show('modal-export')"  v-if="authenticated.role==0">Export Ledger</a>
                            </div>
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="float-right">
                            <b-form-input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search"></b-form-input>
                        </span>
                    </div>
                </div>
                <b-modal id="modal-export" scrollable size="sm">
                    <template v-slot:modal-title>
                        Export Rapor
                    </template>
                    <div class="row">
                        <div class="col">
                            <label>Extensi File</label>
                            <select type="text" class="form-control" aria-invalid="false" v-model="exportParameter.file">
                                <option>Excel</option>
                                <option>PDF</option>
                            </select>
                            <label>Rapor</label>
                            <select type="text" class="form-control" aria-invalid="false" v-model="exportParameter.rapor">
                                <option>Sisipan</option>
                                <option>Akhir</option>
                                <option>Petra</option>
                            </select>
                            <label>Grup</label>
                            <select type="text" class="form-control" aria-invalid="false" v-model="exportParameter.grup">
                                <option>Jenjang</option>
                                <option>Kelas</option>
                            </select>
                            <div class="form-group" v-if="exportParameter.grup!=''&&exportParameter.grup!='All'">
                                <label>Detail</label>
                                <b-form-select
                                    v-if="exportParameter.grup=='Kelas'"
                                    v-model="exportParameter.detail"
                                    size="sm"
                                    @change="cari"
                                    :options="kelasdata.data"
                                    >
                                </b-form-select>
                                <select type="text" class="form-control" aria-invalid="false" v-model="exportParameter.detail" v-if="exportParameter.grup=='Jenjang'">
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"
                            block  @click="submitExport"
                        >
                            Submit
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="modal-input-raporpetra" scrollable size="md">
                    <template v-slot:modal-title>
                        Input Penilaian PETRA
                    </template>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Physical Growth
                                </button>
                            </h5>
                            </div>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                               <div class="form-group">
                                    <label>Berat Badan</label>
                                    <select type="text" class="form-control" aria-invalid="false" v-model="raporPetra.rp_pone_score">
                                        <option value="P1">Ideal</option>
                                        <option value="P1+">Menuju Ideal</option>
                                        <option value="P1-">Menjauhi Ideal</option>
                                        <option value="P1++">Obesitas/Overweight</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Kondisi Mata</label>
                                    <select type="text" class="form-control" aria-invalid="false" v-model="raporPetra.rp_ptwo_score">
                                        <option value="P2+">Baik</option>
                                        <option value="P2-">Cukup Baik</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Kondisi Gigi</label>
                                    <select type="text" class="form-control" aria-invalid="false" v-model="raporPetra.rp_pthree_score">
                                        <option value="P3+">Baik</option>
                                        <option value="P3-">Cukup Baik</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Emotional Intellegence
                                </button>
                            </h5>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Peduli Diri Sendiri</label>
                                        <select type="text" class="form-control" aria-invalid="false" v-model="raporPetra.rp_eone_score">
                                            <option value="E1+">Peduli</option>
                                            <option value="E1-">Tidak Peduli</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Peduli Sesama</label>
                                        <select type="text" class="form-control" aria-invalid="false" v-model="raporPetra.rp_etwo_score">
                                            <option value="E2+">Peduli</option>
                                            <option value="E2-">Tidak Peduli</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Peduli Lingkungan</label>
                                        <select type="text" class="form-control" aria-invalid="false" v-model="raporPetra.rp_ethree_score">
                                            <option value="E3+">Peduli</option>
                                            <option value="E3-">Tidak Peduli</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Ekspresi Emosi</label>
                                        <select type="text" class="form-control" aria-invalid="false" v-model="raporPetra.rp_efour_score">
                                            <option value="E4+">Mampu</option>
                                            <option value="E4-">Belum Mampu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Talent Development
                                </button>
                            </h5>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Bakat/Minat 1</label>
                                        <select type="text" class="form-control" aria-invalid="false" v-model="raporPetra.rp_tone_desc">
                                            <option>Art And Craft</option>
                                            <option>Bahasa Inggris</option>
                                            <option>Bahasa Israel</option>
                                            <option>Bahasa Mandarin</option>
                                            <option>Bahasa Perancis</option>
                                            <option>Balet</option>
                                            <option>Basket</option>
                                            <option>Beatbox</option>
                                            <option>Berenang</option>
                                            <option>Bernyanyi</option>
                                            <option>Bersepeda</option>
                                            <option>Biola</option>
                                            <option>Bisnis</option>
                                            <option>Blogging</option>
                                            <option>Bulutangkis</option>
                                            <option>Catur</option>
                                            <option>Comedy</option>
                                            <option>Cover Dance</option>
                                            <option>Dance</option>
                                            <option>Debat</option>
                                            <option>Dekorasi</option>
                                            <option>Desain Baju</option>
                                            <option>Desain Grafis</option>
                                            <option>DJ</option>
                                            <option>Drama</option>
                                            <option>Drum</option>
                                            <option>Enterpreneurship</option>
                                            <option>Fashion</option>
                                            <option>Fotografi</option>
                                            <option>Futsal</option>
                                            <option>Gitar</option>
                                            <option>Handycraft</option>
                                            <option>Hip-Hop</option>
                                            <option>IPA</option>
                                            <option>Jurnalistik</option>
                                            <option>Kaligrafi</option>
                                            <option>Karate</option>
                                            <option>Kerajinan Tangan</option>
                                            <option>Keyboard</option>
                                            <option>Kulintang</option>
                                            <option>Lari</option>
                                            <option>Lettering</option>
                                            <option>Make Up</option>
                                            <option>Marketing</option>
                                            <option>Matematika</option>
                                            <option>MC</option>
                                            <option>Melukis</option>
                                            <option>Memasak</option>
                                            <option>Membaca</option>
                                            <option>Menari</option>
                                            <option>Mengarang</option>
                                            <option>Menggambar</option>
                                            <option>Menjahit</option>
                                            <option>Menulis</option>
                                            <option>Mewarnai</option>
                                            <option>Modeling</option>
                                            <option>Motor Cross</option>
                                            <option>Muay Thai</option>
                                            <option>Multimedia</option>
                                            <option>Musik</option>
                                            <option>Origami</option>
                                            <option>Otomotif</option>
                                            <option>Paduan Suara</option>
                                            <option>Pemrograman</option>
                                            <option>Pianika</option>
                                            <option>Piano</option>
                                            <option>Polo Air</option>
                                            <option>Prakarya</option>
                                            <option>Presenter</option>
                                            <option>Public Relation</option>
                                            <option>Public Speaking</option>
                                            <option>Rap</option>
                                            <option>Recorder</option>
                                            <option>Renang</option>
                                            <option>Robotik</option>
                                            <option>Scrapbook</option>
                                            <option>Seni Rupa</option>
                                            <option>Sepak Bola</option>
                                            <option>Sulap</option>
                                            <option>Taekwondo</option>
                                            <option>Tenis</option>
                                            <option>Tenis Meja</option>
                                            <option>Ukulele</option>
                                            <option>Vlog</option>
                                            <option>Vokal</option>
                                            <option>Voli</option>
                                            <option>Wing Chun</option>
                                            <option>Wushu</option>
                                            <option>Yoga</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Bakat/Minat 2</label>
                                        <select type="text" class="form-control" aria-invalid="false" v-model="raporPetra.rp_ttwo_desc">
                                            <option>Art And Craft</option>
                                            <option>Bahasa Inggris</option>
                                            <option>Bahasa Israel</option>
                                            <option>Bahasa Mandarin</option>
                                            <option>Bahasa Perancis</option>
                                            <option>Balet</option>
                                            <option>Basket</option>
                                            <option>Beatbox</option>
                                            <option>Berenang</option>
                                            <option>Bernyanyi</option>
                                            <option>Bersepeda</option>
                                            <option>Biola</option>
                                            <option>Bisnis</option>
                                            <option>Blogging</option>
                                            <option>Bulutangkis</option>
                                            <option>Catur</option>
                                            <option>Comedy</option>
                                            <option>Cover Dance</option>
                                            <option>Dance</option>
                                            <option>Debat</option>
                                            <option>Dekorasi</option>
                                            <option>Desain Baju</option>
                                            <option>Desain Grafis</option>
                                            <option>DJ</option>
                                            <option>Drama</option>
                                            <option>Drum</option>
                                            <option>Enterpreneurship</option>
                                            <option>Fashion</option>
                                            <option>Fotografi</option>
                                            <option>Futsal</option>
                                            <option>Gitar</option>
                                            <option>Handycraft</option>
                                            <option>Hip-Hop</option>
                                            <option>IPA</option>
                                            <option>Jurnalistik</option>
                                            <option>Kaligrafi</option>
                                            <option>Karate</option>
                                            <option>Kerajinan Tangan</option>
                                            <option>Keyboard</option>
                                            <option>Kulintang</option>
                                            <option>Lari</option>
                                            <option>Lettering</option>
                                            <option>Make Up</option>
                                            <option>Marketing</option>
                                            <option>Matematika</option>
                                            <option>MC</option>
                                            <option>Melukis</option>
                                            <option>Memasak</option>
                                            <option>Membaca</option>
                                            <option>Menari</option>
                                            <option>Mengarang</option>
                                            <option>Menggambar</option>
                                            <option>Menjahit</option>
                                            <option>Menulis</option>
                                            <option>Mewarnai</option>
                                            <option>Modeling</option>
                                            <option>Motor Cross</option>
                                            <option>Muay Thai</option>
                                            <option>Multimedia</option>
                                            <option>Musik</option>
                                            <option>Origami</option>
                                            <option>Otomotif</option>
                                            <option>Paduan Suara</option>
                                            <option>Pemrograman</option>
                                            <option>Pianika</option>
                                            <option>Piano</option>
                                            <option>Polo Air</option>
                                            <option>Prakarya</option>
                                            <option>Presenter</option>
                                            <option>Public Relation</option>
                                            <option>Public Speaking</option>
                                            <option>Rap</option>
                                            <option>Recorder</option>
                                            <option>Renang</option>
                                            <option>Robotik</option>
                                            <option>Scrapbook</option>
                                            <option>Seni Rupa</option>
                                            <option>Sepak Bola</option>
                                            <option>Sulap</option>
                                            <option>Taekwondo</option>
                                            <option>Tenis</option>
                                            <option>Tenis Meja</option>
                                            <option>Ukulele</option>
                                            <option>Vlog</option>
                                            <option>Vokal</option>
                                            <option>Voli</option>
                                            <option>Wing Chun</option>
                                            <option>Wushu</option>
                                            <option>Yoga</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Kemampuan</label>
                                        <select type="text" class="form-control" aria-invalid="false" v-model="raporPetra.rp_talent_score">
                                            <option value="T1">Sangat Terampil</option>
                                            <option value="T2">Terampil</option>
                                            <option value="T3">Cukup Terampil</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingFour">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Religious Education
                                </button>
                            </h5>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Doa Pagi, PD dan Kebaktian</label>
                                        <select type="text" class="form-control" aria-invalid="false" v-model="raporPetra.rp_rone_score">
                                            <option value="R1+">Aktif</option>
                                            <option value="R1-">Kurang Aktif</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Mengekspresikan Keceriaan, Berkata Ramah, Mengungkapkan Perasaan Dan Pengalaman</label>
                                        <select type="text" class="form-control" aria-invalid="false" v-model="raporPetra.rp_rtwo_score">
                                            <option value="R2+">Mampu</option>
                                            <option value="R2-">Kurang Mampu</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Berterimakasih Kepada Tuhan, Berbagi Dengan Sesama Dan Menghargai Segala Sesuatu Pada Dirinya Dan Sekitarnya</label>
                                        <select type="text" class="form-control" aria-invalid="false" v-model="raporPetra.rp_rthree_score">
                                            <option value="R3+">Mampu</option>
                                            <option value="R3-">Kurang Mampu</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Menghormati Tuhan Saat Ibadah, Menyatakan Kebaikan Tuhan Dalam Perbuatan Dan Perkataan Dan Menunjukkan Sikap Rendah Hati</label>
                                        <select type="text" class="form-control" aria-invalid="false" v-model="raporPetra.rp_rfour_score">
                                            <option value="R4+">Mampu</option>
                                            <option value="R4-">Kurang Mampu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingFive">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Academic Excellence
                                </button>
                            </h5>
                            </div>
                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                <div class="card-body">
                                    <label>Nilai Rapor</label>
                                    <select type="text" class="form-control" aria-invalid="false" v-model="raporPetra.rp_academic_score">
                                        <option value="A+">Baik</option>
                                        <option value="A-">Kurang Baik</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"
                            block  @click="submitNilai()"
                        >
                            Submit
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="modal-import" scrollable size="md">
                    <template v-slot:modal-title>
                        Pilih File Ledger Rapor Akhir
                    </template>
                    <input type="file" class="form-control" :class="{ ' is-invalid' : error.message }" id="input-file-import" name="file_import" ref="import_file"  @change="onFileChange">
                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"
                            block  @click="submitfile('akhir')"
                        >
                            Upload
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="modal-sisipan" scrollable size="md">
                    <template v-slot:modal-title>
                        Pilih File Ledger Rapor Sisipan
                    </template>
                    <input type="file" class="form-control" :class="{ ' is-invalid' : error.message }" id="input-file-import" name="file_import" ref="import_file"  @change="onFileChange">
                    <template v-slot:modal-footer>
                        <b-button
                            variant="primary"
                            class="mt-3"
                            block  @click="submitfile('sisipan')"
                        >
                            Upload
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="setting-sisipan" scrollable size="md">
                    <template v-slot:modal-title>
                        Setting Rapor Sisipan
                    </template>
                    <div class="form-group" v-for="item in mapel_sisipan">
                        <label>{{item}}</label>
                        <div class="row">
                            <div class="col md-3" v-for="(items, index) in field_sisipan">
                                <v-select
                                    :options="filterTP(item)"
                                    :filterable="false"
                                    label="kd_kode"
                                    v-model="settingTP.field[item][items]">

                                    <template slot="no-options">
                                        Masukkan Kata Kunci
                                    </template>
                                    <template slot="option" slot-scope="option">
                                        {{ option.kd_kode }}
                                    </template>
                                    <template slot="selected-option" slot-scope="option">
                                        <span class="badge badge-primary">{{ option.kd_kode }}</span>
                                    </template>
                                </v-select>
                            </div>
                        </div>
                    </div>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="primary"
                            class="mt-3"
                            block  @click="submitSetting()"
                        >
                            Submit
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="modal-input-sisipan" scrollable size="sm">
                    <template v-slot:modal-title>
                        Rapor Sisipan
                    </template>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label>Sakit</label>
                            <input type="number" class="form-control" v-model="raporSisipan.rs_absensi_sakit">
                        </div>
                        <div class="form-group col-sm-4">
                            <label>Ijin</label>
                            <input type="number" class="form-control" v-model="raporSisipan.rs_absensi_ijin">
                        </div>
                        <div class="form-group col-sm-4">
                            <label>Alpha</label>
                            <input type="number" class="form-control" v-model="raporSisipan.rs_absensi_alpha">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ayat Alkitab</label>
                        <input type="text" class="form-control" v-model="raporSisipan.rs_catatan_ayat">
                    </div>
                    <div class="form-group">
                        <label>Isi Ayat</label>
                        <textarea cols="6" rows="5" class="form-control" v-model="raporSisipan.rs_catatan_isi" ></textarea>
                    </div>
                    <div class="form-group">
                        <label>Catatan Wali Kelas</label>
                        <textarea cols="6" rows="5" class="form-control" v-model="raporSisipan.rs_catatan_pesan" ></textarea>
                    </div>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"
                            block  @click="addSisipan()"
                        >
                            Simpan
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="modal-sisipan-biblical" scrollable size="sm">
                    <template v-slot:modal-title>
                        Edit Rapor Sisipan
                    </template>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label>Sakit</label>
                            <input type="number" class="form-control" v-model="raporSisipan.rs_absensi_sakit">
                        </div>
                        <div class="form-group col-sm-4">
                            <label>Ijin</label>
                            <input type="number" class="form-control" v-model="raporSisipan.rs_absensi_ijin">
                        </div>
                        <div class="form-group col-sm-4">
                            <label>Alpha</label>
                            <input type="number" class="form-control" v-model="raporSisipan.rs_absensi_alpha">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ayat Alkitab</label>
                        <input type="text" class="form-control" v-model="raporSisipan.rs_catatan_ayat">
                    </div>
                    <div class="form-group">
                        <label>Isi Ayat</label>
                        <textarea cols="6" rows="5" class="form-control" v-model="raporSisipan.rs_catatan_isi" ></textarea>
                    </div>
                    <div class="form-group">
                        <label>Catatan Walikelas</label>
                        <textarea cols="6" rows="5" class="form-control" v-model="raporSisipan.rs_catatan_pesan" ></textarea>
                    </div>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"
                            block  @click="submitCatatan('sisipan')"
                        >
                            Simpan
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="modal-rapor-biblical" scrollable size="sm">
                    <template v-slot:modal-title>
                        Catatan Walikelas
                    </template>
                    <div class="form-group">
                        <label>Ayat Alkitab</label>
                        <input type="text" class="form-control" v-model="raporAkhir.ra_catatan_ayat">
                    </div>
                    <div class="form-group">
                        <label>Isi Ayat</label>
                        <textarea cols="6" rows="5" class="form-control" v-model="raporAkhir.ra_catatan_isi" ></textarea>
                    </div>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"
                            block  @click="submitCatatan('rapor')"
                        >
                            Simpan
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="modal-sisipan-preview" scrollable size="lg" hide-footer>
                    <template v-slot:modal-title>
                        Preview Rapor Sisipan
                    </template>
                    <rapor-sisipan-form></rapor-sisipan-form>
                </b-modal>
                <b-modal id="modal-sisipan-kurmer-preview" scrollable size="lg" hide-footer>
                    <template v-slot:modal-title>
                        Preview Rapor Sisipan
                    </template>
                    <rapor-sisipan-kurmer-form></rapor-sisipan-kurmer-form>
                </b-modal>
                <b-modal id="modal-rapor-preview" scrollable size="lg" hide-footer>
                    <template v-slot:modal-title>
                        Preview Rapor Akhir
                    </template>
                    <rapor-akhir-form></rapor-akhir-form>
                </b-modal>
                <b-modal id="modal-raporpetra-view" scrollable size="lg" hide-footer>
                    <template v-slot:modal-title>
                        Preview Rapor Petra
                    </template>
                    <rapor-petra-view v-if="authenticated.unit_id == 1"></rapor-petra-view>
                </b-modal>
            </div>
            <div class="panel-body">
                <b-table striped hover bordered :items="rapors.data" :fields="fields" show-empty>
                    <template v-slot:cell(s_nama)="row">
                        {{row.item.siswa.s_nama}}
                    </template>
                    <template v-slot:cell(sisipan)="row">
                        <b-button variant="success" size="sm" v-if="row.item.RaporSisipan == '-'" @click="inputRaporSisipan(row.item.siswa.id)"><i class="fa fa-plus"></i></b-button>
                        <!-- <b-button variant="warning" size="sm" v-if="row.item.RaporSisipan != '-' && row.item.kelas.kelas_jenjang!='7'" @click="commentSisipan(row.item.RaporSisipan.id)"><i class="fa fa-church"></i></b-button> -->
                        <b-button variant="warning" size="sm" v-if="row.item.RaporSisipan != '-'" @click="commentSisipan(row.item.RaporSisipan.id)"><i class="fa fa-edit"></i></b-button>
                        <b-button variant="primary" size="sm" v-b-modal="'modal-jurnal-roster'" v-if="row.item.RaporSisipan != '-'&&row.item.kelas.kelas_jenjang!='7'" @click="previewSisipan(row.item.RaporSisipan.id)"><i class="fa fa-eye"></i></b-button>
                        <b-button variant="primary" size="sm" v-b-modal="'modal-jurnal-roster'" v-if="row.item.RaporSisipan != '-'&&row.item.kelas.kelas_jenjang=='7'" @click="previewSisipanKurmer(row.item.RaporSisipan.id)"><i class="fa fa-eye"></i></b-button>
                        <b-button variant="success" size="sm" :href="'/laporan/raporsisipan?rapor='+row.item.RaporSisipan.id+'&unit='+authenticated.unit_id+'&kurikulum=merdeka'" v-if="row.item.RaporSisipan != '-'&&row.item.kelas.kelas_jenjang=='7'"><i class="fa fa-file-pdf"></i></b-button>
                        <b-button variant="success" size="sm" :href="'/laporan/raporsisipan?rapor='+row.item.RaporSisipan.id+'&unit='+authenticated.unit_id" v-if="row.item.RaporSisipan != '-'&&row.item.kelas.kelas_jenjang!='7'"><i class="fa fa-file-pdf"></i></b-button>
                    </template>
                    <template v-slot:cell(akhir)="row">
                        <b-button variant="warning" size="sm" v-if="row.item.RaporAkhir != '-' && authenticated.unit_id == 1" @click="commentRapor(row.item.RaporAkhir.id)"><i class="fa fa-church"></i></b-button>
                        <b-button variant="primary" size="sm" v-if="row.item.RaporAkhir != '-'" @click="previewRapor(row.item.RaporAkhir.id)"><i class="fa fa-eye"></i></b-button>
                        <!-- <b-button variant="primary" size="sm" v-b-modal="'modal-jurnal-roster'" @click="$bvModal.show('modal-sisipan-preview')"></b-button> -->
                        <!-- <b-button variant="success" size="sm" :href="'/laporan/raporakhir?user='+authenticated.id+'&rapor='+row.item.RaporAkhir.id" v-if="row.item.RaporAkhir != '-'"><i class="fa fa-file-pdf"></i> PDF</b-button> -->
                    </template>
                    <template v-slot:cell(petra)="row">
                        <b-button variant="success" size="sm" v-if="row.item.RaporPetra == '-'" @click="inputRaporPetra(row.item.siswa.id)"><i class="fa fa-plus"></i></b-button>
                        <b-button variant="warning" size="sm" v-if="row.item.RaporPetra != '-'" @click="editRaporPetra(row.item.RaporPetra.id)"><i class="fa fa-pen"></i></b-button>
                        <b-button variant="primary" size="sm" v-if="row.item.RaporPetra != '-'" @click="viewRaporPetra(row.item.RaporPetra.id)"><i class="fa fa-eye"></i></b-button>

                    </template>
                    <!-- <template v-slot:cell(walikelas)="row">
                        {{row.item.ra_walikelas}}
                    </template> -->
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="rapors.data"><i class="fa fa-bars"></i> {{ rapors.data.length }} item dari {{ rapors.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="rapors.meta.total"
                                :per-page="rapors.meta.per_page"
                                aria-controls="rapors"
                                v-if="rapors.data && rapors.data.length > 0"
                                ></b-pagination>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState, mapMutations } from 'vuex'
import FormRaporSisipan from './RaporSisipanForm.vue'
import FormRaporSisipanKurmer from './RaporSisipanKurmerForm.vue'
import FormRaporSisipanP2 from './RaporSisipanFormP2.vue'
import FormRaporAkhir from './RaporAkhirForm.vue'
import ViewRaporPetra from './RaporPetraView.vue'
import vSelect from 'vue-select'


export default {
    name: 'DataRaporAkhir',
    created() {
        this.getRapor({
                search: ''
            }),
        this.getKelas()

    },
    data() {
        return {
            mapel_sisipan : ['PAK','PKN','BIN','BIG','MAT','BIO','FIS',
                             'EKO','GEO','SEJ','SNR','SNM','MEK','TIK',
                             'ORG','JWA','MAN'],
            field_sisipan : ['1','2','3','4'],
            fields: [
                { key: 's_nama', label: 'Nama Siswa' },
                { key: 'sisipan', label: 'Rapor Sisipan' },
                { key: 'akhir', label: 'Rapor Akhir' },
                { key: 'petra', label: 'Rapor Petra'}
            ],
            search: '',
            import_file: '',
            error: {},
            kelas:'',
        }
    },
    computed: {

        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        ...mapState('raporakhir', {
            rapors: state => state.rapor,
            raporSisipan: state => state.raporsisipan,
            raporAkhir: state => state.raporakhir,
            raporPetra: state => state.raporpetra,
            exportParameter: state => state.exportParameter,
            kompetensi: state => state.kompetensi,
            settingTP: state => state.settingTP,
            kelasdata: state=> state.kelas
        }),
        ...mapState(['token']),
        page: {
            get() {
                return this.$store.state.raporakhir.page
            },
            set(val) {
                this.$store.commit('raporakhir/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getRapor({
                search: this.search
                })
        },
        search() {
            this.page = 1;
            this.getRapor({
                search: this.search
            })
        }
    },
    methods: {
        ...mapActions('raporakhir', ['exportRapor',
                                    'viewRaporSisipan',
                                    'viewRaporSisipanKurmer',
                                    'getRapor',
                                    'getKelas',
                                    'uploadLedger',
                                    'submitRaporSisipan',
                                    'viewRaporAkhir',
                                    'submitRaporAkhir',
                                    'addRaporPetra',
                                    'submitNilaiPetra',
                                    'editNilaiPetra',
                                    'getKompetensi',
                                    'setTP',
                                    'getSettingSisipan',
                                    'tambahSisipan']),
        ...mapMutations('raporakhir', ['CLEAR_FORM']), //PANGGIL MUTATIONS CLEAR_FORM

        filterTP(mapel){
          return this.kompetensi.filter(item => item.kompetensi_mapel === mapel)
        },
        submitExport(){
            window.open(`/api/exportrapor?api_token=${this.token}&file=${this.exportParameter.file}&rapor=${this.exportParameter.rapor}&grup=${this.exportParameter.grup}&detail=${this.exportParameter.detail}`,)
        },
        submitNilai(){
            this.submitNilaiPetra().then(() => {
                this.$bvModal.hide('modal-input-raporpetra')
                this.getRapor({
                    search: ''
                })
            })
        },
        addSisipan(){
            this.submitRaporSisipan().then(() => {
                this.$bvModal.hide('modal-input-sisipan')
                this.getRapor({
                    search: ''
                })
            })
        },
        submitCatatan(rapor){
            if(rapor=='sisipan'){
                this.submitRaporSisipan()
                .then(() => {
                    this.$bvModal.hide('modal-sisipan-biblical')
                    .then(() => {
                        this.getRapor({
                            search: ''
                        })
                    })

                })
            }
            if(rapor=='rapor'){
                this.submitRaporAkhir()
                .then(() => {
                    this.$bvModal.hide('modal-rapor-biblical')
                })
            }
        },
        previewSisipan(rapor){
            this.viewRaporSisipan({
                uuid: rapor
            }).then(() => {
                this.$bvModal.show('modal-sisipan-preview')
            })
        },
        previewSisipanKurmer(rapor){
            this.viewRaporSisipanKurmer({
                uuid: rapor
            }).then(() => {
                this.$bvModal.show('modal-sisipan-kurmer-preview')
            })
        },
        previewRapor(rapor){
            this.viewRaporAkhir({
                uuid: rapor
            }).then(() => {
                this.$bvModal.show('modal-rapor-preview')
            })
        },
        viewRaporPetra(rapor){
            this.editNilaiPetra(rapor).then(() => {
                this.$bvModal.show('modal-raporpetra-view')
            })
        },
        inputRaporPetra(siswa){
           this.$store.commit('raporakhir/SET_SISWA', siswa)
            this.$bvModal.show('modal-input-raporpetra')
        },
        inputRaporSisipan(siswa){
           this.CLEAR_FORM()
           this.raporSisipan.id = siswa
            this.$bvModal.show('modal-input-sisipan')

        },
        editRaporPetra(rapor){
            this.editNilaiPetra(rapor)
            this.$bvModal.show('modal-input-raporpetra')
        },
        commentSisipan(rapor){
            this.viewRaporSisipan({
                uuid: rapor
            }).then(() => {
                this.$bvModal.show('modal-sisipan-biblical')
            })
        },
        commentRapor(rapor){
            this.viewRaporAkhir({
                uuid: rapor
            }).then(() => {
                this.$bvModal.show('modal-rapor-biblical')
            })
        },
        onFileChange(e) {
            this.import_file = e.target.files[0];
        },
        submitfile(rapor){
            let formData = new FormData();
            formData.append('import_file', this.import_file);
            formData.append('rapor', rapor);
            this.uploadLedger(formData).then(() => {
                this.import_file = '',
                // this.$bvModal.hide('modal-import'),
                this.getRapor({
                    search: ''
                }),
                this.$swal({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    type: 'success',
                    title: 'Import Ledger Berhasil'
                })

            }).catch(() => {
                this.$swal({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    type: 'error',
                    title: 'Import Rapor Gagal'
                })
            })
        },
        settingsisipan(){
            this.getSettingSisipan()
            this.getKompetensi().then(()=>{
                this.$bvModal.show('setting-sisipan')
            })
        },
        submitSetting(){
            this.setTP().then(() => {
                this.$swal({
                    toast: true,
                    position: 'top-end',
                    title: 'Setting tersimpan',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 1500
                }),
                this.$bvModal.hide('setting_sisipan')
            })
            this.$bvModal.hide('setting_sisipan')
        },

    },
    components: {
        'rapor-sisipan-form': FormRaporSisipan,
        'rapor-sisipan-kurmer-form': FormRaporSisipanKurmer,
        'rapor-sisipanP2-form': FormRaporSisipanP2,
        'rapor-akhir-form': FormRaporAkhir,
        'rapor-petra-view': ViewRaporPetra,
        vSelect

    }
}
</script>

