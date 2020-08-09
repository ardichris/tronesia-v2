<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >
                        <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="$bvModal.show('my-modal')">Tambah</b-button>
                        <b-modal id="penanganan-modal">
                            <template v-slot:modal-title>
                                Penanganan Lapor Sarpras
                            </template>
                            <div class="form-group">
                                <label for="">Tindakan</label>
                                <textarea cols="6" rows="5" class="form-control" v-model="laporsarpras.ls_penanganan"></textarea>
                            </div>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block  @click="updateLSStatus(laporsarpras,2)"
                                >
                                    Simpan
                                </b-button>
                            </template>
                        </b-modal>
                        <b-modal id="add-modal">
                            <template v-slot:modal-title>
                                Tambah Lapor Sarpras
                            </template>
                            <laporsarpras-form></laporsarpras-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block @click="simpanLSbaru"
                                >
                                    Simpan
                                </b-button>
                            </template>
                        </b-modal>
                        <b-modal id="edit-modal">
                            <template v-slot:modal-title>
                                Edit Lapor Sarpras
                            </template>
                            <laporsarpras-form></laporsarpras-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block @click="editLSsaja"
                                >
                                    Update
                                </b-button>
                            </template>
                        </b-modal>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="float-right">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search">
                        </span>
                        <span class="float-right">
                            <b-form-select 
                                v-model="kategori"
                                size="sm"                               
                                :options="['','Kerusakan','Peminjaman']"
                                required
                                ></b-form-select>
                        </span>
                    </div>
                </div>
            </div>
            <div class="panel-body">
              
                <b-table striped hover bordered :items="laporsarprass.data" :fields="fields" show-empty>                	
                    <template v-slot:cell(ls_kategori)="row">
                        <h5><div class="badge badge-secondary">{{row.item.creator.name}}</div></h5>
                        <div class="badge badge-info">{{row.item.ls_tanggal}}</div>
                        <span class="badge badge-danger" v-if="row.item.ls_kategori == 'Kerusakan'">Kerusakan</span>
                        <span class="badge badge-primary" v-if="row.item.ls_kategori == 'Peminjaman'">Peminjaman</span>
                        <span class="badge badge-info" v-if="row.item.ls_status == 1 && row.item.ls_kategori == 'Kerusakan'">Proses</span>
                        <span class="badge badge-info" v-if="row.item.ls_status == 1 && row.item.ls_kategori == 'Peminjaman'">Dipinjam</span>
                        <span class="badge badge-success" v-else-if="row.item.ls_status == 2">Selesai</span>
                        <span class="badge badge-warning" v-else-if="row.item.ls_status == 0">Tunggu</span>
                    </template>
                    <template v-slot:cell(ls_penanganan)="row">
                        <div>{{row.item.ls_penanganan}}</div>
                        <div class="badge badge-secondary" v-if="row.item.updater!=null">{{row.item.updater.name}}</div><br>
                        <div class="badge badge-secondary" v-if="row.item.updater!=null">{{row.item.updated_at}}</div>
                    </template>
                    <template v-slot:cell(user_id)="row">
                        {{row.item.user.name}}
                    </template>
                    <template v-slot:cell(actions)="row">
                        <div class="btn-group">
                            <button class="btn btn-info btn-sm" v-if="(authenticated.role==0 || authenticated.role==4) && row.item.ls_status == 0 && row.item.ls_kategori == 'Kerusakan'"  @click="updateLSStatus(row.item,1)"><i class="fas fa-hammer"></i></button>
                            <button class="btn btn-info btn-sm" v-if="(authenticated.role==0 || authenticated.role==4) && row.item.ls_status == 0 && row.item.ls_kategori == 'Peminjaman'" @click="updateLSStatus(row.item,1)"><i class="fas fa-hand-holding-heart"></i></button>
                            <button class="btn btn-success btn-sm" v-if="(authenticated.role==0 || authenticated.role==4) && row.item.ls_status != 2" @click="penangananLS(row.item.ls_kode)"><i class="far fa-check-circle"></i></button>
                        </div>
                        <div class="btn-group">
                        <button class="btn btn-warning btn-sm" @click="editLS(row.item.ls_kode)" v-if="row.item.ls_status != 2 || authenticated.role==0"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" @click="deleteLaporSarpras(row.item.id)" v-if="row.item.ls_status != 2 || authenticated.role==0"><i class="fa fa-trash"></i></button>
                        </div>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="laporsarprass.data"><i class="fa fa-bars"></i> {{ laporsarprass.data.length }} item dari {{ laporsarprass.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="laporsarprass.meta.total"
                                :per-page="laporsarprass.meta.per_page"
                                aria-controls="laporsarprass"
                                v-if="laporsarprass.data && laporsarprass.data.length > 0"
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
import FormLaporSarpras from './Form.vue'

export default {
    name: 'DataLaporSarpras',
    created() {
        this.getLaporSarpras({
                search: this.search,
                kategori: this.kategori
            })
    },
    data() {
        return {
            fields: [                
                { key: 'ls_kategori', label: 'Kategori' },
                { key: 'ls_sarpras', label: 'Sarpras' },
                { key: 'ls_keterangan', label: 'Keterangan' },
                { key: 'ls_penanganan', label: 'Tindakan' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: '',
            kategori: ''
        }
    },
    computed: {
        ...mapState('laporsarpras', {
            laporsarprass: state => state.laporsarprass,
            laporsarpras: state => state.laporsarpras
        }),
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        //MENGAMBIL DATA PAGE DARI STATE PELANGGARAN
        page: {
            get() {
                return this.$store.state.laporsarpras.page
            },
            set(val) {
                this.$store.commit('laporsarpras/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getLaporSarpras({
                search: this.search,
                kategori: this.kategori
            })
        },
        search() {
            this.getLaporSarpras({
                search: this.search,
                kategori: this.kategori
            })
        },
        kategori() {
            this.getLaporSarpras({
                search: this.search,
                kategori: this.kategori
            })
        }
    },
    methods: {
        ...mapActions('laporsarpras', ['updateStatus','editLaporSarpras','getLaporSarpras', 'removeLaporSarpras','submitLaporSarpras','updateLaporSarpras']),
        ...mapMutations('laporsarpras', ['CLEAR_FORM']),
        penangananLS(kode){
            this.editLaporSarpras({
                kode: kode
            }),
            this.$bvModal.show('penanganan-modal')
        },
        updateLSStatus(ls,status){
            this.updateStatus({
                ls: ls,
                status: status
            }),
            this.$bvModal.hide('penanganan-modal'),
            this.getLaporSarpras({
                search: this.search,
                kategori: this.kategori
            })
        },
        editLSsaja(){
            this.updateLaporSarpras().then(() => {
                this.$bvModal.hide('edit-modal'),
                this.getLaporSarpras({
                    search: this.search,
                    kategori: this.kategori
                })
            })
        },
        editLS(kode){
            this.editLaporSarpras({
                kode: kode
            }),
            this.$bvModal.show('edit-modal')
        },
        simpanLSbaru(){
            this.submitLaporSarpras().then(() => {
                this.$bvModal.hide('add-modal'),
                this.getLaporSarpras({
                    search: this.search,
                    kategori: this.kategori
                })
            })
        },
        deleteLaporSarpras(id) {
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
                    this.removeLaporSarpras(id)
                    this.getLaporSarpras({
                        search: this.search,
                        kategori: this.kategori
                    })
                }
            })
        }
    },
    components: {
        'laporsarpras-form': FormLaporSarpras
    }
}
</script>