<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        <!-- <b-button variant="success" size="sm" v-b-modal="'modal-jurnal-roster'" @click="$bvModal.show('modal-import')">Tambah Siswa</b-button> -->
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">                            
                            <b-button variant="primary" size="sm" @click="cari()"><i class="fas fa-search"></i></b-button>
                        </span>
                        <span class="float-right">
                            <b-form-input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search"></b-form-input>
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
                <b-modal id="modal-absen-datang" scrollable size="sm">
                    <template v-slot:modal-title>
                        Suhu Datang
                    </template>
                    <b-form-input type="text" class="form-control form-control-sm" v-model="suhu"></b-form-input>
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
                    </template>
                    <template v-slot:cell(actions)="row">
                        
                            <button class="btn btn-success btn-sm" v-if="(row.item.absensi.aptm_status == null)" @click="absenmasuk(row.item.siswa_id)"><i class="fa fa-thermometer-full"></i></button>
                            <button class="btn btn-primary btn-sm" v-if="(row.item.absensi.aptm_status == 'Masuk')"  @click="sudahdijemput(row.item.siswa_id)" ><i class="fas fa-car"></i></button>
                            <button class="btn btn-danger btn-sm" v-if="(row.item.absensi != '-' && row.item.absensi.aptm_suhu_pulang == null)" @click="absenpulang(row.item.siswa_id)"><i class="fas fa-thermometer-full"></i></button>
                        
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
import { mapActions, mapState } from 'vuex'

export default {
    name: 'DataSiswaPtm',
    created() {
        this.interval = setInterval(() =>
            this.getSiswaPtm({
                    search: this.search,
                    kelas: this.kelas
                }),
        30000);
        this.getSiswaPtm({
                    search: this.search,
                    kelas: this.kelas
                })
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
        }
    },
    computed: {
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        ...mapState('siswaptm', {
            siswaptms: state => state.siswaptms,
        }),
        ...mapState(['token']),
        page: {
            get() {
                return this.$store.state.siswaptm.page
            },
            set(val) {
                this.$store.commit('siswaptm/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getSiswaPtm({
                search: this.search,
                kelas: this.kelas
            })
        },
        // search() {
        //     this.getSiswaPtm({
        //         search: this.search,
        //         kelas: this.kelas
        //     })
        // }
    },
    methods: {
        ...mapActions('siswaptm', ['getSiswaPtm','uploadLedger','absenDatang','dijemput','submitsuhupulang']),
        onFileChange(e) {
            this.import_file = e.target.files[0];
        },
        cari(){
            this.getSiswaPtm({
                    search: this.search,
                    kelas: this.kelas
                })
        },
        absenmasuk(id){
            this.$bvModal.show('modal-absen-datang');
            this.siswaid = id;
        },
        submitabsenmasuk(){
            this.absenDatang({suhu: this.suhu, siswaid: this.siswaid})
            .then(() => {
                this.$bvModal.hide('modal-absen-datang'),
                this.getSiswaPtm({
                    search: this.search,
                    kelas: this.kelas
                })
                this.suhu= ''
                this.siswaid = ''
            });
        },
        sudahdijemput(id){
            this.dijemput(id)
            .then(() => {
                this.getSiswaPtm({
                    search: this.search,
                    kelas: this.kelas
                })
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
                this.getSiswaPtm({
                    search: this.search,
                    kelas: this.kelas
                })
                this.suhu= ''
                this.siswaid = ''
            });
        }
        
    },
    
}
</script>

