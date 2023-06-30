<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="$bvModal.show('add-modal')">Tambah</b-button>
                        <b-button variant="success" size="sm" v-b-modal="'scan-attend-modal'" @click="scanAttend()">Attend</b-button>
                        <b-modal id="add-modal" scrollable size="xl">
                            <template v-slot:modal-title>
                                Tambah EventTicket
                            </template>
                            <eventticket-form></eventticket-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"
                                    block @click="simpanEventTicketbaru"
                                >
                                    Simpan
                                </b-button>
                            </template>
                        </b-modal>
                        <b-modal id="edit-modal" scrollable size="xl">
                            <template v-slot:modal-title>
                                Edit EventTicket
                            </template>
                            <eventticket-form></eventticket-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"
                                    block @click="updateEventTicket"
                                >
                                    Update
                                </b-button>
                            </template>
                        </b-modal>
                        <b-modal id="scan-attend-modal" scrollable size="sm" hide-footer>
                            <template v-slot:modal-title>
                                Scan Attend
                            </template>
                            <p class="error">{{ error }}</p>
                            <div class="decode-result">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <b>Status</b>
                                    </div>
                                    <div class="col-lg-9">
                                        <span class="badge badge-primary" v-if="dataticket.status == 'Attended'">Attended</span>
                                        <span class="badge badge-success" v-if="dataticket.status == 'Success'">Success</span>
                                        <span class="badge badge-dark" v-if="dataticket.status == 'Not Found'">Not Found</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <b>Group</b>
                                    </div>
                                    <div class="col-lg-9">
                                        <span class="badge badge-dark" v-if="dataticket.ticket == null">-</span>
                                        <span class="badge badge-primary" v-if="dataticket.ticket != null && dataticket.ticket.et_group == 'Student'">Student</span>
                                        <span class="badge badge-warning" v-if="dataticket.ticket != null && dataticket.ticket.et_group == 'Parent'">Parent</span>
                                        <span class="badge badge-danger" v-if="dataticket.ticket != null && dataticket.ticket.et_group == 'Guest'">Guest</span>
                                        <span class="badge badge-success" v-if="dataticket.ticket != null && dataticket.ticket.et_group == 'Special'">Special</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <b>Name</b>
                                    </div>
                                    <div class="col-lg-9">
                                        {{ dataticket.ticket?dataticket.ticket.et_name:'' }}
                                    </div>
                                </div>
                            </div>
                            <qrcode-stream @decode="onDecode" @init="onInit"></qrcode-stream>
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

              	<!-- TABLE UNTUK MENAEventTicketILKAN LIST PELANGGARAN -->
                <b-table striped hover bordered :items="eventtickets.data" :fields="fields" show-empty>
                    <template v-slot:cell(e_start_date)="row">
                        {{ row.item.e_start_date ? row.item.e_start_date:'' }}
                    </template>
                    <template v-slot:cell(actions)="row">
                        <button class="btn btn-warning btn-sm" @click="editP(row.item.id)"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" @click="deleteEventTicket(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>
              	<!-- TABLE UNTUK MENAEventTicketILKAN LIST PELANGGARAN -->

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="eventtickets.data"><i class="fa fa-bars"></i> {{ eventtickets.data.length }} item dari {{ eventtickets.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="eventtickets.meta.total"
                                :per-page="eventtickets.meta.per_page"
                                aria-controls="eventtickets"
                                v-if="eventtickets.data && eventtickets.data.length > 0"
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
import FormEventTicket from './Form.vue'
import { QrcodeStream } from 'vue-qrcode-reader'

export default {
    name: 'DataEventTicket',
    created() {
        this.getEventTicket()
    },
    data() {
        return {
            fields: [
                { key: 'et_name', label: 'Name' },
                { key: 'et_organization', label: 'Organization' },
                { key: 'et_group', label: 'Group' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: '',
            result: '',
            error: ''
        }
    },
    computed: {
        ...mapState('eventticket', {
            eventtickets: state => state.eventticket_data,
            dataticket: state => state.ticket_data
        }),
        page: {
            get() {
                return this.$store.state.eventticket.page
            },
            set(val) {
                this.$store.commit('eventticket/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getEventTicket()
        },
        search() {
            this.getEventTicket(this.search)
        }
    },
    methods: {
        ...mapActions('eventticket', ['submitEventTicket','updateEventTicket','editEventTicket','getEventTicket', 'removeEventTicket', 'confirmTicket']),
        ...mapMutations('eventticket', ['CLEAR_TICKET']),
        scanAttend(){
            this.CLEAR_TICKET()
            this.$bvModal.show('scan-attend-modal')
        },
        onDecode (result) {
            this.confirmTicket(result)
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
        storeEventTicket(){
            this.submitEventTicket().then(() => {
                this.$bvModal.hide('add-modal'),
                this.getEventTicket()
            })
        },
        updateEventTicket(){
            this.updateEventTicket().then(() => {
                this.$bvModal.hide('edit-modal'),
                this.getEventTicket()
            })
        },
        editEventTicket(kode){
            this.editEventTicket({
                kode: kode
            }),
            this.$bvModal.show('edit-modal')
        },
        deleteEventTicket(id) {
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
                    this.removeEventTicket(id) //JIKA SETUJU MAKA PERMINTAAN HAPUS AKAN DI EKSEKUSI
                }
            })
        }
    },
    components: {
        'eventticket-form': FormEventTicket,
        QrcodeStream
    }
}
</script>
