<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <router-link :to="{ name: 'jurnal.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="float-right">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search">
                        </span>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <b-table striped hover bordered :items="jurnals.data" :fields="fields" show-empty>
                    <template v-slot:cell(jm_status)="row">
                        <span class="badge badge-success" v-if="row.item.jm_status == 1">Approved</span>
                        <span class="badge badge-danger" v-else-if="row.item.jm_status == 2">Reject</span>
                        <span class="badge badge-warning" v-else-if="row.item.jm_status == 0">Waiting</span>
                    </template>
                    <template v-slot:cell(user_id)="row">
                        {{ row.item.user_id ? row.item.user.name:'-' }}
                    </template>
                    <template v-slot:cell(kelas_id)="row">
                        {{ row.item.kelas_id ? row.item.kelas.kelas_nama:'-' }}
                    </template>
                    <template v-slot:cell(kompetensi_id)="row">
                        {{ row.item.kompetensi_id ? row.item.kompetensi.kd_kode:'-' }}
                    </template>
                    <template v-slot:cell(actions)="row">
                        <div class="btn-group">
                            <button class="btn btn-success btn-sm" v-if="authenticated.role!=2" @click="updateJMstatus(row.item,1)"><i class="far fa-check-circle"></i></button>
                            <button class="btn btn-danger btn-sm" v-if="authenticated.role!=2" @click="updateJMstatus(row.item,2)"><i class="fa fa-times"></i></button>
                            <router-link :to="{ name: 'jurnal.edit', params: {id: row.item.jm_kode} }" class="btn btn-warning btn-sm" v-if="authenticated.role==2 || authenticated.role==0"><i class="fa fa-edit"></i></router-link>
                            <button class="btn btn-danger btn-sm" @click="deleteJurnal(row.item.id)" v-if="authenticated.role==2 || authenticated.role==0"><i class="fa fa-trash"></i></button>
                        </div>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="jurnals.data"><i class="fa fa-bars"></i> {{ jurnals.data.length }} item dari {{ jurnals.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="jurnals.meta.total"
                                :per-page="jurnals.meta.per_page"
                                aria-controls="jurnals"
                                v-if="jurnals.data && jurnals.data.length > 0"
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
    name: 'DataJurnal',
    created() {
        //SEBELUM COMPONENT DI-LOAD, REQUEST DATA DARI SERVER
        this.getJurnal()
    },
    data() {
        return {
            //FIELD UNTUK B-TABLE, PASTIKAN KEY NYA SESUAI DENGAN FIELD DATABASE
            //AGAR OTOMATIS DI-RENDER
            
            fields: [
                //{ key: 'jm_kode', label: 'Kode' },
                { key: 'user_id', label: 'Guru', sortable: true },
                { key: 'jm_tanggal', label: 'Tanggal', sortable: true },
                { key: 'kelas_id', label: 'Kelas', sortable: true },
                { key: 'jm_jampel', label: 'Jam' },
                { key: 'kompetensi_id', label: 'KD' },
                { key: 'jm_materi', label: 'Materi' },
                { key: 'jm_status', label: 'Status', sortable: true },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        //MENGAMBIL DATA OUTLETS DARI STATE OUTLETS
        ...mapState('jurnal', {
            jurnals: state => state.jurnals
        }),
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        page: {
            get() {
                //MENGAMBIL VALUE PAGE DARI VUEX MODULE jurnal
                return this.$store.state.jurnal.page
            },
            set(val) {
                //APABILA TERJADI PERUBAHAN VALUE DARI PAGE, MAKA STATE PAGE
                //DI VUEX JUGA AKAN DIUBAH
                this.$store.commit('jurnal/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            //APABILA VALUE DARI PAGE BERUBAH, MAKA AKAN MEMINTA DATA DARI SERVER
            this.getJurnal()
        },
        search() {
            //APABILA VALUE DARI SEARCH BERUBAH MAKA AKAN MEMINTA DATA
            //SESUAI DENGAN DATA YANG SEDANG DICARI
            this.getJurnal(this.search)
        }
    },
    methods: {
        ...mapActions('jurnal', ['getJurnal', 'removeJurnal','checkJurnal','updateStatus']),
        approveJurnal(id){
            this.checkJurnal(id)
        },
        updateJMstatus(jurnal,status){
            this.updateStatus({
                jurnal: jurnal,
                status: status
            })//.then(()=>{jurnal.jm_status = status })
        },
        deleteJurnal(id) {
            //AKAN MENAMPILKAN JENDELA KONFIRMASI
            this.$swal({
                title: 'Kamu Yakin?',
                text: "Tindakan ini akan menghapus secara permanent!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, Lanjutkan!'
            }).then((result) => {
                //JIKA DISETUJUI
                if (result.value) {
                    //MAKA FUNGSI removeJurnal AKAN DIJALANKAN
                    this.removeJurnal(id)
                }
            })
        }
    }
}
</script>

