<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="$bvModal.show('add-modal')">Tambah</b-button>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="float-right">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search">
                        </span>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <b-modal id="add-modal">
                    <template v-slot:modal-title>
                        Add Delivery
                    </template>
                    <deliveries-form></deliveries-form>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"
                            block @click="submitDlv()"
                        >
                            Simpan
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="edit-modal">
                    <template v-slot:modal-title>
                        Update Delivery
                    </template>
                    <deliveries-form></deliveries-form>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="warning"
                            class="mt-3"
                            block @click="updateDlv(delivery.id)"
                        >
                            Update
                        </b-button>
                    </template>
                </b-modal>
                <b-table striped hover bordered :items="deliveries.data" :fields="fields" show-empty>
                    <template v-slot:cell(siswa)="row">
                        {{ row.item.siswa_id ? row.item.siswa.s_nama:'-' }}<br>
                        <div class="badge badge-primary" v-if="row.item.kelas.substr(0, 2)=='IX'">{{row.item.kelas}}</div>
                        <div class="badge badge-danger" v-else-if="row.item.kelas.substr(0, 4)=='VIII'">{{row.item.kelas}}</div>
                        <div class="badge badge-warning" v-else>{{row.item.kelas}}</div>
                        <div class="badge badge-danger" v-if="row.item.dlv_counter > 2">{{row.item.dlv_counter}}</div>
                        <div class="badge badge-success" v-else>{{row.item.dlv_counter}}</div>
                    </template>
                    <template v-slot:cell(dlv_date)="row">
                        <div class="badge badge-dark">{{row.item.dlv_date|formatDateView}}</div><br>
                        <div class="badge badge-warning">{{row.item.created_at|dtFormat('HH:mm')}}</div>
                        <div class="badge badge-success" v-if="row.item.dlv_status == 'Delivered'">{{row.item.updated_at|dtFormat('HH:mm')}}</div>
                    </template>
                    <template v-slot:cell(actions)="row">
                        <button class="btn btn-success btn-sm"  @click="statusDelivery(row.item.id)" v-if="row.item.dlv_status == 'Received'"><i class="fa fa-check"></i></button>
                        <b-button variant="warning" size="sm" v-b-modal="'edit-modal'" @click="editInv(row.item.id)" v-if="row.item.dlv_status == 'Received' || authenticated.role == 0"><i class="fa fa-edit"></i></b-button>
                        <button class="btn btn-danger btn-sm" @click="deleteDelivery(row.item.id)" v-if="row.item.dlv_status == 'Received' || authenticated.role == 0 "><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="deliveries.data"><i class="fa fa-bars"></i> {{ deliveries.data.length }} item dari {{ deliveries.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="deliveries.meta.total"
                                :per-page="deliveries.meta.per_page"
                                aria-controls="deliveries"
                                v-if="deliveries.data && deliveries.data.length > 0"
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
import FormDelivery from './Form.vue'
import moment from 'moment'

export default {
    name: 'DataDelivery',
    created() {
        this.getDelivery()
    },
    data() {
        return {
            fields: [
                { key: 'siswa', label: 'Siswa', sortable: true },
                { key: 'dlv_item', label: 'Barang', sortable: true },
                { key: 'dlv_sender', label: 'Pengirim' },
                { key: 'dlv_date', label: 'Tanggal' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: '',
        }
    },
    computed: {
        ...mapState('delivery', {
            delivery: state => state.delivery,
            deliveries: state => state.deliveries,
        }),
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        page: {
            get() {
                return this.$store.state.delivery.page
            },
            set(val) {
                this.$store.commit('delivery/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getDelivery()
        },
        search() {
            this.getDelivery(this.search)
        }
    },
    filters: {
        dtFormat (dt, format) {
        return moment.utc(dt).format(format)
        }
    },
    methods: {
        ...mapActions('delivery', ['getDelivery', 'removeDelivery','editDelivery','submitDelivery','updateDelivery', 'sendDelivery']),
        ...mapMutations('delivery', ['CLEAR_FORM']),
        submitDlv() {
            this.submitDelivery().then(() => {
                this.$bvModal.hide('add-modal')
            })
        },
        editDlv($id){
            this.editDelivery($id).then(() =>{
                this.$bvModal.show('edit-modal')
            })
        },
        updateDlv($id) {
            this.updateDelivery($id).then(() => {
                this.getDelivery()
                this.$bvModal.hide('edit-modal')
                this.CLEAR_FORM()
            })
        },
        statusDelivery(delivery) {
            this.sendDelivery(delivery).then(() => {
                this.getDelivery()
            })
        },
        deleteDelivery(id) {
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
                    this.removeDelivery(id)
                }
            })
        }
    },
    components: {
            'deliveries-form': FormDelivery
        }
}
</script>

