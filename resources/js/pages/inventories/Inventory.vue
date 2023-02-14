<template>
    <div class="col-12">
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
                        <span class="float-right">
                            <b-form-select
                                v-model="status"
                                size="sm"
                                :options="['','Active','Failed','Service','Lost','Deleted']"
                                required
                                ></b-form-select>
                        </span>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <b-modal id="add-modal">
                    <template v-slot:modal-title>
                        Tambah Inventory
                    </template>
                    <inventories-form></inventories-form>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"
                            block @click="submitInv()"
                        >
                            Simpan
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="edit-modal">
                    <template v-slot:modal-title>
                        Update Inventory
                    </template>
                    <inventories-form></inventories-form>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="warning"
                            class="mt-3"
                            block @click="updateInv(inventory.id)"
                        >
                            Update
                        </b-button>
                    </template>
                </b-modal>
                <b-table striped hover bordered :items="inventories.data" :fields="fields" show-empty>
                    <template v-slot:cell(inv_code)="row">
                        {{row.item.inv_code}}<br>
                        <span class="badge badge-success" v-if="row.item.inv_status == 'Active'">Active</span>
                        <span class="badge badge-warning" v-else-if="row.item.inv_status == 'Failed'">Failed</span>
                        <span class="badge badge-danger" v-else-if="row.item.inv_status == 'Lost'">Lost</span>
                        <span class="badge badge-info" v-else-if="row.item.inv_status == 'Service'">Service</span>
                        <span class="badge badge-secondary" v-else-if="row.item.inv_status == 'Deleted'">Deleted</span>
                    </template>
                    <template v-slot:cell(actions)="row">
                        <button class="btn btn-success btn-sm"  @click="viewInventory(row.item)"><i class="fa fa-eye"></i></button>
                        <b-button variant="warning" size="sm" v-b-modal="'edit-modal'" @click="editInv(row.item.id)"><i class="fa fa-edit"></i></b-button>
                        <button class="btn btn-danger btn-sm" @click="deleteInventory(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="inventories.data"><i class="fa fa-bars"></i> {{ inventories.data.length }} item dari {{ inventories.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="inventories.meta.total"
                                :per-page="inventories.meta.per_page"
                                aria-controls="inventories"
                                v-if="inventories.data && inventories.data.length > 0"
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
import FormInventory from './Form.vue'

export default {
    name: 'DataInventory',
    created() {
        this.getInventory({
            search: this.search,
            status: this.status
        })
    },
    data() {
        return {
            fields: [
                { key: 'inv_code', label: 'Kode', sortable: true },
                { key: 'inv_name', label: 'Nama Barang', sortable: true },
                { key: 'inv_serialnumber', label: 'Serial' },
                { key: 'inv_condition', label: 'Kondisi' },
                { key: 'inv_location', label: 'Lokasi' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: '',
            status: '',
        }
    },
    computed: {
        ...mapState('inventory', {
            inventory: state => state.inventory,
            inventories: state => state.inventories,
        }),
        page: {
            get() {
                return this.$store.state.inventory.page
            },
            set(val) {
                this.$store.commit('inventory/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getInventory({
                search: this.search,
                status: this.status
            })
        },
        search() {
            this.getInventory({
                search: this.search,
                status: this.status
            })
            this.$store.commit('inventory/SET_PAGE', 1)
        },
        status() {
            this.getInventory({
                search: this.search,
                status: this.status
            })
            this.$store.commit('inventory/SET_PAGE', 1)
        }
    },
    methods: {
        ...mapActions('inventory', ['getInventory', 'removeInventory','editInventory','submitInventory','updateInventory']),
        ...mapMutations('inventory', ['CLEAR_FORM']),
        submitInv() {
            this.submitInventory().then(() => {
                this.$bvModal.hide('add-modal')
            }).then(() => {
                this.getInventory({
                    search: this.search,
                    status: this.status
                })
            })
        },
        editInv($id){
            this.editInventory($id).then(() =>{
                this.$bvModal.show('edit-modal')
            })
        },
        updateInv($id) {
            this.updateInventory($id).then(() => {
                this.getInventory({
                    search: this.search,
                    status: this.status
                })
                this.$bvModal.hide('edit-modal')
                this.CLEAR_FORM()
            })
        },
        viewInventory(inventory) {
            this.editInventory(inventories.barang_kode)
            this.$bvModal.show('view-stok')
        },
        deleteInventory(id) {
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
                    this.removeInventory(id)
                }
                this.getInventory({
                    search: this.search,
                    status: this.status
                })
            })
        }
    },
    components: {
            'inventories-form': FormInventory
        }
}
</script>

