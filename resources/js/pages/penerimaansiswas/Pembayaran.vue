<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Pembayaran</h3>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <!--router-link :to="{ name: 'pemakaianbarang.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link-->
                        <b-button variant="primary" size="sm" @click="$bvModal.show('upload-pembayaran')">Upload</b-button>
                        <b-modal id="upload-pembayaran">
                            <template v-slot:modal-title>
                                Upload Laporan Pembayaran
                            </template>
                            <input type="file" class="form-control" :class="{ ' is-invalid' : error.message }" id="input-file-import" name="file_import" ref="import_file" @change="onFileChange">
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"
                                    block  @click="submitfile()"
                                >
                                    Upload
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
                <b-table striped hover bordered :items="pembayarans.data" :fields="fields" show-empty>
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="pembayarans.data"><i class="fa fa-bars"></i> {{ pembayarans.data.length }} item dari {{ pembayarans.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="pembayarans.meta.total"
                                :per-page="pembayarans.meta.per_page"
                                aria-controls="pembayarans"
                                v-if="pembayarans.data && pembayarans.data.length > 0"
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
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'

export default {
    name: 'penerimaansiswa.pembayaran',
    created() {
        this.getPembayaranPSB()
    },
    data() {
        return {
            fields: [
                { key: 'pp_no_formulir', label: 'No Form', sortable: true },
                { key: 'pp_student_code', label: 'Kode', sortable: true },
                { key: 'pp_student_name', label: 'Nama Siswa', sortable: true },
                { key: 'pp_angsuran', label: 'Ans', sortable: true },
                { key: 'pp_biaya', label: 'Tagihan' },
                { key: 'pp_pembayaran', label: 'Pembayaran' },
                { key: 'pp_sisa', label: 'Sisa' },
                { key: 'pp_tanggal', label: 'Tanggal', sortable: true },
                // { key: 'actions', label: 'Aksi' }
            ],
            error: {},
            import_file: '',
            search: ''
        }
    },
    computed: {
        ...mapState('penerimaansiswa', {
            pembayarans: state => state.pembayaran,
        }),
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        page: {
            get() {
                return this.$store.state.penerimaansiswa.page
            },
            set(val) {
                this.$store.commit('penerimaansiswa/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getPembayaranPSB()
        },
        search() {
            this.getPembayaranPSB()
        }
    },
    methods: {
        ...mapActions('penerimaansiswa', ['uploadPembayaran', 'getPembayaran']),
        getPembayaranPSB(){
            this.getPembayaran()
        },
        onFileChange(e) {
            this.import_file = e.target.files[0];
        },
        submitfile(){
            let formData = new FormData();
            formData.append('import_file', this.import_file);
            this.uploadPembayaran(formData).then(() => {
                this.import_file = '',
                this.$bvModal.hide('upload-pembayaran'),
                this.getPembayaran({
                    search: ''
                }),
                this.$swal({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    type: 'success',
                    title: 'Import Berhasil'
                })

            }).catch(() => {
                this.$swal({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    type: 'error',
                    title: 'Import Gagal'
                })
            })
        },

    },
    components: {
        vSelect,
    }
}
</script>
