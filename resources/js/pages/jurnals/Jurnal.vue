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
                        <span class="float-right">
                            <b-form-select 
                                v-model="status"
                                size="sm"   
                                placeholder="Status"                            
                                :options="status_options"
                                required
                                ></b-form-select>
                        </span>
                    </div>
                    <b-modal id="reject-modal">
                        <template v-slot:modal-title>
                            Keterangan Reject
                        </template>
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <textarea cols="6" rows="5" class="form-control" v-model="jurnal.jm_catatan"></textarea>
                        </div>
                        <template v-slot:modal-footer>
                            <b-button
                                variant="success"
                                class="mt-3"                                    
                                block  @click="updateJMstatus(jurnal,2)"
                            >
                                Simpan
                            </b-button>
                        </template>
                    </b-modal>
                    <b-modal id="edit-modal" scrollable size="xl">
                        <template v-slot:modal-title>
                            Edit Jurnal Mengajar
                        </template>
                        <jurnal-form></jurnal-form>
                        <template v-slot:modal-footer >
                            <b-button
                                variant="success"
                                class="mt-3"                                    
                                block @click="editJMsaja"
                            >
                                Update
                            </b-button>
                        </template>
                    </b-modal>
                    <b-modal id="view-modal" scrollable size="xl" hide-footer>
                        <template v-slot:modal-title>
                            View Jurnal Mengajar
                        </template>
                        <jurnal-form></jurnal-form>
                    </b-modal>
                </div>
            </div>
            <div class="panel-body">
                <b-table striped hover bordered :items="jurnals.data" :fields="fields" show-empty>
                    <template v-slot:cell(jm_detail)="row">
                        <div v-if="row.item.detail.length >= 1">
                            <div v-for="item in row.item.detail" :key="item.siswa.s_nama">
                                <div class="badge badge-warning">{{ item.siswa.s_nama }}</div>
                            </div>
                        </div>
                        <div v-if="row.item.pelanggaran.length >= 1">
                            <div v-for="item in row.item.pelanggaran" :key="item.siswa.s_nama">
                                <div class="badge badge-danger">{{ item.siswa.s_nama }}</div>
                            </div>
                        </div>
                    </template>
                    <template v-slot:cell(user_id)="row">
                        <h5><span class="badge badge-secondary">{{ row.item.user_id ? row.item.user.name:'-' }}</span></h5>
                        <span class="badge badge-success">{{ row.item.mapel_id ? row.item.mapel.mapel_kode:'WKM' }}</span>
                        <span class="badge badge-info">{{ row.item.jm_tanggal}}</span><br>
                        <span class="badge badge-success" v-if="row.item.jm_status == 1">Approved</span>
                        <span class="badge badge-danger" v-else-if="row.item.jm_status == 2">Rejected</span>
                        <span class="badge badge-warning" v-else-if="row.item.jm_status == 0">Submited</span>
                        <span class="badge badge-dark" v-else-if="row.item.jm_status == 3">Archived</span>
                        
                    </template>
                    <template v-slot:cell(kelas_id)="row">
                        <h5><span class="badge badge-warning">{{ row.item.kelas_id ? row.item.kelas.kelas_nama:'-' }} <span class="badge badge-danger">{{ row.item.jm_jampel}}</span></span></h5>
                        
                    </template>
                    <template v-slot:cell(kompetensi_id)="row">
                        {{ row.item.kompetensi_id ? row.item.kompetensi.kd_kode:'-' }}
                    </template>
                    <template v-slot:cell(actions)="row">
                        <div class="btn-group" v-if="row.item.jm_status != 2 && (authenticated.role==1 || authenticated.role==0)" >
                            <button class="btn btn-warning btn-sm"  v-if="(row.item.jm_status == 1)" @click="updateJMstatus(row.item,0)"><i class="fa fa-clock"></i></button>
                            <button class="btn btn-success btn-sm" v-if="(row.item.jm_status == 0)" @click="updateJMstatus(row.item,1)"><i class="fa fa-check-circle"></i></button>
                            <button class="btn btn-danger btn-sm" v-if="(row.item.jm_status != 3 && row.item.jm_status != 2)" @click="rejectJM(row.item.jm_kode)"><i class="fa fa-times"></i></button>
                        </div>
                        <div class="btn-group"> 
                            <button class="btn btn-success btn-sm" @click="viewJM(row.item.jm_kode)" v-if="(row.item.jm_status == 1 && row.item.jm_status != 3) ||authenticated.role==0"><i class="fa fa-eye"></i></button>
                            <button class="btn btn-warning btn-sm" @click="editJM(row.item.jm_kode)" v-if="(row.item.jm_status != 1 && row.item.jm_status != 3) || authenticated.role==0"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" @click="deleteJurnal(row.item.id)" v-if="(row.item.jm_status != 1 && row.item.jm_status != 3) || authenticated.role==0"><i class="fa fa-trash"></i></button>
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
import FormJurnal from './Form.vue'

export default {
    name: 'DataJurnal',
    created() {
        this.getJurnal({
                search : this.search,
                status : this.status
            })
    },
    data() {
        return {
            
            fields: [
                { key: 'user_id', label: 'Guru', sortable: true },
                { key: 'kelas_id', label: 'Kelas', sortable: true },
                { key: 'kompetensi_id', label: 'KD' },
                { key: 'jm_materi', label: 'Materi' },
                { key: 'jm_keterangan', label: 'Catatan'},
                { key: 'jm_detail', label: 'Presensi / Pelanggaran' },
                { key: 'actions', label: 'Aksi' }
            ],
            status_options: [
                { value: '', text: '' },
                { value: '0', text: 'Waiting' },
                { value: '1', text: 'Approved' },
                { value: '2', text: 'Reject' },
            ],
            search: '',
            status: ''
        }
    },
    computed: {
        ...mapState('jurnal', {
            jurnals: state => state.jurnals,
            jurnal: state => state.jurnal
        }),
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        page: {
            get() {
                return this.$store.state.jurnal.page
            },
            set(val) {
                this.$store.commit('jurnal/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getJurnal({
                search : this.search,
                status : this.status
            })
        },
        search() {
            this.getJurnal({
                search : this.search,
                status : this.status
            })
        },
        status() {
            this.getJurnal({
                search : this.search,
                status : this.status
            })
        }
    },
    methods: {
        ...mapActions('jurnal', ['editJurnal','updateJurnal','getJurnal', 'removeJurnal','checkJurnal','updateStatus']),
        rejectJM(kode){
            this.editJurnal({
                kode: kode
            }),
            this.$bvModal.show('reject-modal')
        },
        approveJurnal(id){
            this.checkJurnal(id)
        },
        updateJMstatus(jurnal,status){
            this.updateStatus({
                jurnal: jurnal,
                status: status
            }),
            this.$bvModal.hide('reject-modal'),
            this.getJurnal({
                search: this.search,
                status: this.status
            })
        },
        editJMsaja(){
            this.updateJurnal().then(() => {
                this.$bvModal.hide('edit-modal'),
                this.getJurnal({
                    search: this.search,
                    status: this.status
                })
            })
        },
        viewJM(kode){
            this.editJurnal({
                kode: kode
            }),
            this.$bvModal.show('view-modal')
        },
        editJM(kode){
            this.editJurnal({
                kode: kode
            }),
            this.$bvModal.show('edit-modal')
        },
        deleteJurnal(id) {
            this.$swal({
                title: 'Kamu Yakin?',
                text: "Tindakan ini akan menghapus secara permanent!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, Lanjutkan!'
            }).then((result) => {
                if (result.value) {
                    this.removeJurnal(id),
                    this.getJurnal({
                        search: this.search,
                        status: this.status
                    })
                }
            })
        }
    },
    components: {
        'jurnal-form': FormJurnal
    }
}
</script>

