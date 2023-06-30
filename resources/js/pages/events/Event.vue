<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="$bvModal.show('add-modal')">Tambah</b-button>
                        <b-modal id="add-modal" scrollable size="xl">
                            <template v-slot:modal-title>
                                Tambah Event
                            </template>
                            <event-form></event-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"
                                    block @click="simpanEventbaru"
                                >
                                    Simpan
                                </b-button>
                            </template>
                        </b-modal>
                        <b-modal id="edit-modal" scrollable size="xl">
                            <template v-slot:modal-title>
                                Edit Event
                            </template>
                            <event-form></event-form>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"
                                    block @click="updateEvent"
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

              	<!-- TABLE UNTUK MENAEventILKAN LIST PELANGGARAN -->
                <b-table striped hover bordered :items="events.data" :fields="fields" show-empty>
                    <template v-slot:cell(e_start_date)="row">
                        {{ row.item.e_start_date ? row.item.e_start_date:'' }}
                    </template>
                    <template v-slot:cell(actions)="row">
                        <button class="btn btn-warning btn-sm" @click="editP(row.item.id)"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" @click="deleteEvent(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>
              	<!-- TABLE UNTUK MENAEventILKAN LIST PELANGGARAN -->

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="events.data"><i class="fa fa-bars"></i> {{ events.data.length }} item dari {{ events.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="events.meta.total"
                                :per-page="events.meta.per_page"
                                aria-controls="events"
                                v-if="events.data && events.data.length > 0"
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
import FormEvent from './Form.vue'

export default {
    name: 'DataEvent',
    created() {
        this.getEvent()
    },
    data() {
        return {
            fields: [
                { key: 'e_code', label: 'Code' },
                { key: 'e_name', label: 'Name' },
                { key: 'e_desc', label: 'Description' },
                { key: 'e_start_date', label: 'Tanggal', sortable: true },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('event', {
            events: state => state.event_data
        }),
        page: {
            get() {
                return this.$store.state.event.page
            },
            set(val) {
                this.$store.commit('event/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getEvent()
        },
        search() {
            this.getEvent(this.search)
        }
    },
    methods: {
        ...mapActions('event', ['submitEvent','updateEvent','editEvent','getEvent', 'removeEvent']),
        storeEvent(){
            this.submitEvent().then(() => {
                this.$bvModal.hide('add-modal'),
                this.getEvent()
            })
        },
        updateEvent(){
            this.updateEvent().then(() => {
                this.$bvModal.hide('edit-modal'),
                this.getEvent()
            })
        },
        editEvent(kode){
            this.editEvent({
                kode: kode
            }),
            this.$bvModal.show('edit-modal')
        },
        deleteEvent(id) {
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
                    this.removeEvent(id) //JIKA SETUJU MAKA PERMINTAAN HAPUS AKAN DI EKSEKUSI
                }
            })
        }
    },
    components: {
        'event-form': FormEvent
    }
}
</script>
