<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >
                        <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="$bvModal.show('my-modal')">Tambah</b-button>
                        <b-modal id="add-modal">
                            <template v-slot:modal-title>
                                Tambah Kitir
                            </template>
                            <kitir-form></kitir-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block @click="simpanKSbaru"
                                >
                                    Simpan
                                </b-button>
                            </template>
                        </b-modal>
                        <b-modal id="edit-modal">
                            <template v-slot:modal-title>
                                Edit Kitir
                            </template>
                            <kitir-form></kitir-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block @click="editKSsaja"
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
                    </div>
                </div>
            </div>
            <div class="panel-body">
              
              	<!-- TKSLE UNTUK MENAMPILKAN LIST KITIR -->
                <b-table striped hover bordered :items="kitirs.data" :fields="fields" show-empty>                	
                    <template v-slot:cell(siswa_id)="row">
                        {{ row.item.siswa_id ? row.item.siswa.siswa_nama:'-' }}
                    </template>
                    <template v-slot:cell(status)="row">
                        <div class="badge badge-warning">{{ row.item.creator_id ? row.item.creator.name:'-' }}<br>{{ row.item.last_at }}</div><br>
                        <div class="badge badge-success" v-if="row.item.approve_by != null">{{ row.item.approve_by ? row.item.approve.name:null }} <br> {{ row.item.approve_at }}</div>
                    </template>
                    <template v-slot:cell(actions)="row">
                        <div class="btn-group">
                        <button class="btn btn-success btn-sm" v-if="(authenticated.role==0 || authenticated.role==4) && row.item.ks_status != 1" @click="updateKSStatus(row.item,1)"><i class="far fa-check-circle"></i></button>
                        <button class="btn btn-warning btn-sm" @click="editKS(row.item.ks_kode)" v-if="row.item.ks_status != 1 || authenticated.role==0"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" @click="deleteKitir(row.item.id)" v-if="row.item.ks_status != 1 || authenticated.role==0"><i class="fa fa-trash"></i></button>
                        </div>
                    </template>
                </b-table>
              	<!-- TKSLE UNTUK MENAMPILKAN LIST KITIR -->

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="kitirs.data"><i class="fa fa-bars"></i> {{ kitirs.data.length }} item dari {{ kitirs.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="kitirs.meta.total"
                                :per-page="kitirs.meta.per_page"
                                aria-controls="kitirs"
                                v-if="kitirs.data && kitirs.data.length > 0"
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
import FormKitir from './Form.vue'

export default {
    name: 'DataKitir',
    created() {
        this.getKitir()
    },
    data() {
        return {
            fields: [
                { key: 'siswa_id', label: 'Nama Lengkap' },
                { key: 'ks_tanggal', label: 'Tanggal' },
                { key: 'ks_jenis', label: 'Jenis' },
                { key: 'ks_keterangan', label: 'Keterangan' },
                { key: 'status', label: 'Status' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('kitirsiswa', {
            kitirs: state => state.kitirs,
            kitir: state => state.kitir,
            siswas: state => state.siswas
        }),
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        //MENGAMBIL DATA PAGE DARI STATE KITIR
        page: {
            get() {
                return this.$store.state.kitirsiswa.page
            },
            set(val) {
                this.$store.commit('kitirsiswa/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getKitir()
        },
        search() {
            this.getKitir(this.search)
        }
    },
    methods: {
        ...mapActions('kitirsiswa', ['editKitir','getKitir', 'removeKitir','submitKitir','updateKitir','updateStatus']),
        ...mapMutations('kitirsiswa', ['CLEAR_FORM']),
        updateKSStatus(ks,status){
            this.updateStatus({
                ks: ks,
                status: status
            }),
            this.getKitir(this.search)
        },
        editKSsaja(){
            this.updateKitir().then(() => {
                this.$bvModal.hide('edit-modal'),
                this.getKitir()
            })
        },
        editKS(kode){
            this.editKitir({
                kode: kode
            }),
            this.$bvModal.show('edit-modal')
        },
        simpanKSbaru(){
            this.submitKitir().then(() => {
                this.$bvModal.hide('add-modal'),
                this.getKitir()
            })
        },
        deleteKitir(id) {
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
                    this.removeKitir(id)
                }
            })
        }
    },
    components: {
        'kitir-form': FormKitir
    }
}
</script>