<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        <b-button variant="success" size="sm" v-b-modal="'modal-jurnal-roster'" @click="$bvModal.show('modal-add')" v-if="authenticated.role==0">Tambah Siswa</b-button>
                        <b-button variant="warning" size="sm" v-b-modal="'modal-jurnal-roster'" @click="$bvModal.show('modal-absen')" v-if="authenticated.role==0">Absen Masuk</b-button>
                        <b-button variant="primary" size="sm" v-b-modal="'modal-jurnal-roster'" @click="$bvModal.show('modal-jemput')" v-if="authenticated.role==0">Penjemputan</b-button>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">                            
                            <b-button variant="primary" size="sm" @click="cari()"><i class="fas fa-search"></i></b-button>
                        </span>
                        <span class="float-right">
                            <b-form-input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search" ref="search"></b-form-input>
                        </span>
                        <span class="float-right">
                            <b-form-select 
                                v-model="kelas"
                                size="sm"                               
                                :options="['','VII-1','VII-2','VII-3','VII-4','VII-5','VII-6','VII-7','VII-8','VII-9',
                                           'VIII-1','VIII-2','VIII-3','VIII-4','VIII-5','VIII-6','VIII-7','VIII-8','VIII-9','VIII-10',
                                           'IX-1','IX-2','IX-3','IX-4','IX-5','IX-6','IX-7','IX-8','IX-9','IX-10']"
                                required
                                >
                            </b-form-select>
                        </span>
                    </div>
                </div>
                <b-modal id="modal-add" scrollable size="md">
                    <template v-slot:modal-title>
                        Tambah Siswa PTM
                    </template>
                    <button class="btn btn-warning btn-sm float-right" style="margin-bottom: 10px" @click="addSiswa">Tambah</button>
                    <div class="table-responsive" style="height: 300px">
                        <table class="table" >
                            <thead>
                                <tr>
                                    <th width="100%">Nama Siswa</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in siswaptm.ptm" :key="index">
                                    <td>
                                        <v-select :options="siswas.data"
                                            v-model="row.siswa"
                                            @search="SearchSiswa"
                                            :value="$store.myValue"
                                            label="s_nama"
                                            placeholder="Masukkan Kata Kunci" 
                                            :filterable="false">
                                            <template slot="no-options">
                                                Masukkan Kata Kunci
                                            </template>
                                            <template slot="option" slot-scope="option">
                                                {{ option.s_nama }}
                                            </template>
                                        </v-select>    
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-flat" @click="removeSiswa(index)"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"                                    
                            block  @click="submitSiswaPtm()"
                        >
                            Submit
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="modal-jemput" scrollable size="sm">
                    <template v-slot:modal-title>
                        Jemput - Scan QR
                    </template>
                    <p class="error">{{ error }}</p>
                    <p class="decode-result">Nama: <b>{{ siswas.s_nama }} / {{ siswas.kelas }}</b></p>
                    <qrcode-stream @decode="onDecode" @init="onInit"></qrcode-stream>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"                                    
                            block  @click="sudahdijemput(siswas.id)"
                        >
                            Submit
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="modal-absen" scrollable size="sm">
                    <template v-slot:modal-title>
                        Scan QRCode
                    </template>
                    <p class="error">{{ error }}</p>
                    <p class="decode-result">Last result: <b>{{ result }}</b></p>
                    <qrcode-stream @decode="onDecode" @init="onInit"></qrcode-stream>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"                                    
                            block  @click="submitabsenmasuk()"
                        >
                            Submit
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="modal-absen-datang" scrollable size="sm">
                    <template v-slot:modal-title>
                        Suhu Datang
                    </template>
                    <b-form-input type="text" class="form-control form-control-sm" v-model="suhu" ref="sm"></b-form-input>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"                                    
                            block  @click="submitabsenmasuk()"
                        >
                            Submit
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="modal-absen-pulang" scrollable size="sm">
                    <template v-slot:modal-title>
                        Suhu Pulang
                    </template>
                    <b-form-input type="text" class="form-control form-control-sm" v-model="suhu"></b-form-input>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"                                    
                            block  @click="suhupulang()"
                        >
                            Submit
                        </b-button>
                    </template>
                </b-modal>
            </div>
            <div class="panel-body">
                <b-table striped hover bordered :items="siswaptms.data" :fields="fields" show-empty>
                    <template v-slot:cell(kelas)="row">
                        {{ row.item.kelas ? row.item.kelas:'-' }} / {{row.item.absen ? row.item.absen:'-'}}
                    </template>
                    <template v-slot:cell(s_nama)="row">
                        {{ row.item.siswa.s_nama ? row.item.siswa.s_nama:'-' }}
                    </template>
                    <template v-slot:cell(status)="row">
                        <span class="badge badge-primary" v-if="row.item.absensi.aptm_status == 'Dijemput'">Dijemput</span>
                        <span class="badge badge-success" v-if="row.item.absensi.aptm_status == 'Masuk'">Masuk</span>
                        <span class="badge badge-dark" v-else-if="row.item.absensi == '-'">Daring</span>
                        <span class="badge badge-dark" v-if="row.item.distance">{{row.item.distance}}km aways</span>
                    </template>
                    <template v-slot:cell(actions)="row">
                        
                            <button class="btn btn-success btn-sm" v-if="(row.item.absensi.aptm_status == null)" @click="submitabsenmasuk(row.item.siswa_id)"><i class="fa fa-check"></i></button>
                            <button class="btn btn-primary btn-sm" v-if="(row.item.absensi.aptm_status == 'Masuk')"  @click="sudahdijemput(row.item.siswa_id)" ><i class="fas fa-car"></i></button>
                            <button class="btn btn-danger btn-sm" v-if="(row.item.absensi != '-' && row.item.absensi.aptm_suhu_pulang == null)" @click="deleteAbsence(row.item.siswa_id)"><i class="fas fa-trash"></i></button>
                        
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="siswaptms.data"><i class="fa fa-bars"></i> {{ siswaptms.data.length }} item dari {{ siswaptms.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="siswaptms.meta.total"
                                :per-page="siswaptms.meta.per_page"
                                aria-controls="siswaptms"
                                v-if="siswaptms.data && siswaptms.data.length > 0"
                                ></b-pagination>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapMutations, mapState } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
import { QrcodeStream } from 'vue-qrcode-reader'

export default {
    name: 'DataSiswaPtm',
    mounted(){
        this.$refs.search.$el.focus();
    },
    created() {
        this.interval = setInterval(() =>
            this.refreshdata(), 30000);
        this.refreshdata()
    },
    data() {
        return {
            fields: [
                { key: 'kelas', label: 'Kelas' },
                { key: 's_nama', label: 'Nama Siswa' },
                { key: 'status', label: 'Status' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: '',
            suhu: '',
            kelas: '',
            siswaid: '',
            import_file: '',
            error: {},
            isForm: false,
            isSuccess: false,
            siswasptm: [{ siswa: null }],
            result: '',
            error: ''
        }
    },
    computed: {
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        ...mapState('siswaptm', {
            siswaptms: state => state.siswaptms,
            siswas: state => state.siswa,
            siswaptm: state => state.siswaptm
        }),
        ...mapState(['token']),
        page: {
            get() {
                return this.$store.state.siswaptm.page
            },
            set(val) {
                this.$store.commit('siswaptm/SET_PAGE', val)
            }
        },
        filterSiswa() {
            return _.filter(this.siswaptm.ptm, function(item) {
                return item.siswa == null
            })
        },
    },
    watch: {
        page() {
            this.refreshdata()
        },
        kelas() {
            this.refreshdata()
        },
        // search() {
        //     this.getSiswaPtm({
        //         search: this.search,
        //         kelas: this.kelas
        //     })
        // }
    },
    methods: {
        ...mapActions('siswaptm', ['getSiswaPtm','uploadLedger','absenDatang','dijemput','submitsuhupulang','getSiswa','submitPTM','hapusAbsen','confirmSiswa']),
        ...mapMutations('siswaptm' ['CLEAR_SISWA']),
        onDecode (result) {
            this.confirmSiswa(result)
        },

        async onInit (promise) {
        try {
            await promise
        } catch (error) {
            if (error.name === 'NotAllowedError') {
            this.error = "ERROR: you need to grant camera access permission"
            } else if (error.name === 'NotFoundError') {
            this.error = "ERROR: no camera on this device"
            } else if (error.name === 'NotSupportedError') {
            this.error = "ERROR: secure context required (HTTPS, localhost)"
            } else if (error.name === 'NotReadableError') {
            this.error = "ERROR: is the camera already in use?"
            } else if (error.name === 'OverconstrainedError') {
            this.error = "ERROR: installed cameras are not suitable"
            } else if (error.name === 'StreamApiNotSupportedError') {
            this.error = "ERROR: Stream API is not supported in this browser"
            } else if (error.name === 'InsecureContextError') {
            this.error = 'ERROR: Camera access is only permitted in secure context. Use HTTPS or localhost rather than HTTP.';
            } else {
            this.error = `ERROR: Camera error (${error.name})`;
            }
        }
        },
        refreshdata(){
            this.getSiswaPtm({
                    search: this.search,
                    kelas: this.kelas
                })
        },
        submitSiswaPtm(){
            this.submitPTM().then(() => {
                this.$bvModal.hide('modal-add')
                this.refreshdata()                
            })
        },
        removeSiswa(index) {
            if (this.siswaptm.ptm.length > 0) {
                this.siswaptm.ptm.splice(index, 1)
            }
        },
        SearchSiswa(search, loading) {
            this.getSiswa({
                search: search,
                loading: loading
            })
        },
        addSiswa() {
            if (this.filterSiswa.length == 0) {
                this.siswaptm.ptm.push({ siswa_id: null, siswa: null})
            }
        },
        cari(){
            this.page = 1
            this.refreshdata()
        },
        absenmasuk(id){
            this.$bvModal.show('modal-absen-datang');
            this.$refs.sm.$el.focus();
            this.siswaid = id;
        },
        submitabsenmasuk(id){
            this.absenDatang({siswaid: id})
            .then(() => {              
                this.refreshdata()
            });
        },
        sudahdijemput(id){
            this.dijemput(id)
            .then(() => {
                this.$swal({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    type: 'success',
                    title: 'Success'
                })
                this.refreshdata()
            });
        },
        absenpulang(id){
            this.$bvModal.show('modal-absen-pulang');
            this.siswaid = id;
        },
        suhupulang(){
            this.submitsuhupulang({suhu: this.suhu, siswaid: this.siswaid})
            .then(() => {
                this.$bvModal.hide('modal-absen-pulang'),
                this.refreshdata()
                this.suhu= ''
                this.siswaid = ''
            });
        },
        deleteAbsence(id){
            this.hapusAbsen(id)
            .then(() => {
                this.refreshdata()
            });
        },
        
    },
    components: {
        vSelect,
        QrcodeStream
    }
    
}
</script>

