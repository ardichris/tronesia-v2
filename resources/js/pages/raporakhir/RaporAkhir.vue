<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <b-button variant="success" size="sm" v-b-modal="'modal-jurnal-roster'" @click="$bvModal.show('modal-import')">Upload Ledger</b-button>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="float-right">
                            <b-form-input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search"></b-form-input>
                        </span>
                    </div>
                </div>
                <b-modal id="modal-import" scrollable size="md">
                    <template v-slot:modal-title>
                        Pilih File Ledger
                    </template>
                    <input type="file" class="form-control" :class="{ ' is-invalid' : error.message }" id="input-file-import" name="file_import" ref="import_file"  @change="onFileChange">
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
            <div class="panel-body">
                <b-table striped hover bordered :items="raporakhirs.data" :fields="fields" show-empty>
                    <template v-slot:cell(s_nama)="row">
                        {{row.item.siswa.s_nama}}
                    </template>
                    <template v-slot:cell(kelas)="row">
                        {{row.item.kelas}}/{{row.item.absen}}
                    </template>
                    <template v-slot:cell(walikelas)="row">
                        {{row.item.ra_walikelas}}
                    </template>
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
                { key: 'kelas', label: 'Kelas' },
                { key: 's_nama', label: 'Nama Siswa' },
                { key: 'walikelas', label: 'Walikelas' },
                { key: 's_keterangan', label: 'Status' },
                { key: 'actions', label: 'Aksi' }
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
            this.getRaporAkhir()
        },
        search() {
            this.getRaporAkhir(this.search)
        }
    },
    methods: {
        ...mapActions('raporakhir', ['getRaporAkhir','uploadLedger']),
        onFileChange(e) {
            this.import_file = e.target.files[0];
        },
        submitfile(){
            let formData = new FormData();
            formData.append('import_file', this.import_file);
            this.uploadLedger(formData).then(() => {
                    this.import_file = '',
                    this.$bvModal.hide('modal-import')
                    
            })
        }
        
    }
}
</script>

