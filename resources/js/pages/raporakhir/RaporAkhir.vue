<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <b-button variant="primary" size="sm" v-b-modal="'modal-jurnal-roster'" @click="$bvModal.show('modal-sisipan')" v-if="authenticated.role==0">Upload Sisipan</b-button>
                        <b-button variant="success" size="sm" v-b-modal="'modal-jurnal-roster'" @click="$bvModal.show('modal-import')"  v-if="authenticated.role==0">Upload Ledger</b-button>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="float-right">
                            <b-form-input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search"></b-form-input>
                        </span>
                    </div>
                </div>
                <b-modal id="modal-import" scrollable size="md">
                    <template v-slot:modal-title>
                        Pilih File Ledger Rapor Akhir
                    </template>
                    <input type="file" class="form-control" :class="{ ' is-invalid' : error.message }" id="input-file-import" name="file_import" ref="import_file"  @change="onFileChange">
                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"
                            block  @click="submitfile('akhir')"
                        >
                            Upload
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="modal-sisipan" scrollable size="md">
                    <template v-slot:modal-title>
                        Pilih File Ledger Rapor Sisipan
                    </template>
                    <input type="file" class="form-control" :class="{ ' is-invalid' : error.message }" id="input-file-import" name="file_import" ref="import_file"  @change="onFileChange">
                    <template v-slot:modal-footer>
                        <b-button
                            variant="primary"
                            class="mt-3"
                            block  @click="submitfile('sisipan')"
                        >
                            Upload
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="modal-sisipan-biblical" scrollable size="sm">
                    <template v-slot:modal-title>
                        Catatan Walikelas
                    </template>
                    <div class="form-group">
                        <label>Ayat Alkitab</label>
                        <input type="text" class="form-control" v-model="raporSisipan.rs_catatan_ayat">
                    </div>
                    <div class="form-group">
                        <label>Isi Ayat</label>
                        <textarea cols="6" rows="5" class="form-control" v-model="raporSisipan.rs_catatan_isi" ></textarea>
                    </div>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"
                            block  @click="submitCatatan()"
                        >
                            Simpan
                        </b-button>
                    </template>
                </b-modal>
                <b-modal id="modal-sisipan-preview" scrollable size="lg" hide-footer>
                    <template v-slot:modal-title>
                        Preview Rapor Sisipan
                    </template>
                    <rapor-sisipan-form v-if="authenticated.unit_id == 1"></rapor-sisipan-form>
                    <rapor-sisipanP2-form v-if="authenticated.unit_id == 3"></rapor-sisipanP2-form>
                </b-modal>
                <b-modal id="modal-rapor-preview" scrollable size="lg" hide-footer>
                    <template v-slot:modal-title>
                        Preview Rapor Akhir
                    </template>
                    <rapor-akhir-form v-if="authenticated.unit_id == 1"></rapor-akhir-form>
                </b-modal>
            </div>
            <div class="panel-body">
                <b-table striped hover bordered :items="raporakhirs.data" :fields="fields" show-empty>
                    <template v-slot:cell(s_nama)="row">
                        {{row.item.siswa.s_nama}}
                    </template>
                    <template v-slot:cell(sisipan)="row">
                        <b-button variant="warning" size="sm" v-if="row.item.RaporSisipan != '-' && authenticated.unit_id == 1" @click="commentSisipan(row.item.RaporSisipan.id)"><i class="fa fa-church"></i> Biblical</b-button>
                        <b-button variant="primary" size="sm" v-b-modal="'modal-jurnal-roster'" v-if="row.item.RaporSisipan != '-'" @click="previewSisipan(row.item.RaporSisipan.id)"><i class="fa fa-eye"></i> Preview</b-button>
                        <b-button variant="success" size="sm" :href="'/laporan/raporsisipan?rapor='+row.item.RaporSisipan.id+'&unit='+authenticated.unit_id" v-if="row.item.RaporSisipan != '-'"><i class="fa fa-file-pdf"></i> PDF</b-button>
                    </template>
                    <template v-slot:cell(akhir)="row">
                        <b-button variant="warning" size="sm" v-if="row.item.RaporAkhir != '-' && authenticated.unit_id == 1" @click="commentAkhir(row.item.RaporAkhir.id)"><i class="fa fa-church"></i> Biblical</b-button>
                        <b-button variant="primary" size="sm" v-if="row.item.RaporAkhir != '-'" @click="previewRapor(row.item.RaporAkhir.id)"><i class="fa fa-eye"></i> Preview</b-button>
                        <!-- <b-button variant="primary" size="sm" v-b-modal="'modal-jurnal-roster'" @click="$bvModal.show('modal-sisipan-preview')"></b-button> -->
                        <!-- <b-button variant="success" size="sm" :href="'/laporan/raporakhir?user='+authenticated.id+'&rapor='+row.item.RaporAkhir.id" v-if="row.item.RaporAkhir != '-'"><i class="fa fa-file-pdf"></i> PDF</b-button> -->
                    </template>
                    <!-- <template v-slot:cell(walikelas)="row">
                        {{row.item.ra_walikelas}}
                    </template> -->
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="raporakhirs.data"><i class="fa fa-bars"></i> {{ raporakhirs.data.length }} item dari {{ raporakhirs.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="raporakhirs.meta.total"
                                :per-page="raporakhirs.meta.per_page"
                                aria-controls="raporakhirs"
                                v-if="raporakhirs.data && raporakhirs.data.length > 0"
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
import FormRaporSisipan from './RaporSisipanForm.vue'
import FormRaporSisipanP2 from './RaporSisipanFormP2.vue'
import FormRaporAkhir from './RaporAkhirForm.vue'

export default {
    name: 'DataRaporAkhir',
    created() {
        this.getRaporAkhir({
                search: ''
            })
    },
    data() {
        return {
            fields: [
                { key: 's_nama', label: 'Nama Siswa' },
                { key: 'sisipan', label: 'Rapor Sisipan' },
                { key: 'akhir', label: 'Rapor Akhir' }
            ],
            search: '',
            import_file: '',
            error: {},
        }
    },
    computed: {
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        ...mapState('raporakhir', {
            raporakhirs: state => state.raporakhirs,
            raporSisipan: state => state.raporsisipan
        }),
        ...mapState(['token']),
        page: {
            get() {
                return this.$store.state.raporakhir.page
            },
            set(val) {
                this.$store.commit('raporakhir/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getRaporAkhir({
                search: this.search
                })
        },
        search() {
            this.page = 1;
            this.getRaporAkhir({
                search: this.search
            })
        }
    },
    methods: {
        ...mapActions('raporakhir', ['viewRaporSisipan','getRaporAkhir','uploadLedger','submitRaporSisipan','viewRaporAkhir']),
        submitCatatan(){
            this.submitRaporSisipan()
            .then(() => {
                this.$bvModal.hide('modal-sisipan-biblical')
            })
        },
        previewSisipan(rapor){
            this.viewRaporSisipan({
                uuid: rapor
            }).then(() => {
                this.$bvModal.show('modal-sisipan-preview')
            })
        },
        previewRapor(rapor){
            this.viewRaporAkhir({
                uuid: rapor
            }).then(() => {
                this.$bvModal.show('modal-rapor-preview')
            })
        },
        commentSisipan(rapor){
            this.viewRaporSisipan({
                uuid: rapor
            }).then(() => {
                this.$bvModal.show('modal-sisipan-biblical')
            })
        },
        onFileChange(e) {
            this.import_file = e.target.files[0];
        },
        submitfile(rapor){
            let formData = new FormData();
            formData.append('import_file', this.import_file);
            formData.append('rapor', rapor);
            this.uploadLedger(formData).then(() => {
                this.import_file = '',
                // this.$bvModal.hide('modal-import'),
                this.getRaporAkhir({
                    search: ''
                }),
                this.$swal({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    type: 'success',
                    title: 'Import Ledger Berhasil'
                })

            }).catch(() => {
                this.$swal({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    type: 'error',
                    title: 'Import Rapor Gagal'
                })
            })
        }

    },
    components: {
        'rapor-sisipan-form': FormRaporSisipan,
        'rapor-sisipanP2-form': FormRaporSisipanP2,
        'rapor-akhir-form': FormRaporAkhir,
    }
}
</script>

