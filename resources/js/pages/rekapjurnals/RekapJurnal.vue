<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >
                        <b-modal id="tanggal-modal" >
                            <template v-slot:modal-title>
                                Filter Tanggal
                            </template>
                            <div class="form-group">
                                <label for="">Tanggal Mulai</label>
                                <input type="date" class="form-control" v-model="rekapjurnal.tanggalmulai">
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Akhir</label>
                                <input type="date" class="form-control" v-model="rekapjurnal.tanggalakhir">
                            </div>
                            <template v-slot:modal-footer>
                                <b-button
                                    variant="success"
                                    class="mt-3"                                    
                                    block  @click="submitRekap"
                                >
                                    Submit
                                </b-button>
                            </template>
                        </b-modal>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <!--b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="$bvModal.show('tanggal-modal')">View</b-button-->
                Nama Guru :  <label for="">{{authenticated.name}}</label><br>
                Tanggal :  <label for="">{{rekapjurnal.tanggalmulai | formatDate}}</label>
                 s/d   <label for="">{{rekapjurnal.tanggalakhir | formatDate}}</label><br>
                <b-table striped hover bordered :items="jurnals.data" :fields="fields" show-empty>
                    <template v-slot:cell(jm_tanggal)="row">
                        {{ row.item.jm_tanggal | formatDate }}
                    </template>
                    <template v-slot:cell(jm_kelas)="row">
                        {{ row.item.kelas.kelas_nama }}
                    </template>
                    <template v-slot:cell(KD)="row">
                        {{ row.item.kompetensi_id ? row.item.kompetensi.kd_kode:''  }}
                    </template>
                </b-table>
                <b-row align-h="end">
                    <b-col cols="3">Surabaya, {{new Date() | formatDate}}  <!--new Date().toLocaleString()-->
                        <br>
                        <br>
                        <br>
                        <br>
                        Yurui, S.Pd., M.M.
                    </b-col>
                </b-row>
                <b-button variant="success"  :href="'/laporan/cetak_pdf?user='+authenticated.id+'&start='+rekapjurnal.tanggalmulai+'&finish='+rekapjurnal.tanggalakhir">Cetak PDF</b-button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState, mapMutations } from 'vuex'
import 'moment/locale/id'

export default {
    name: 'DataJurnal',
    created() {
        //this.getJurnal()
        //this.$bvModal.show('tanggal-modal')
    },
    mounted() {
      this.$bvModal.show('tanggal-modal')
    },
    data() {
        return {            
            fields: [
                { key: 'jm_tanggal', label: 'Tanggal' },
                { key: 'jm_jampel', label: 'Jam' },
                { key: 'jm_kelas', label: 'Kelas' },
                { key: 'KD', label: 'KD' },
                { key: 'jm_materi', label: 'Materi' },
                { key: 'jm_keterangan', label: 'Catatan' }

            ],
            search: ''
        }
    },

    computed: {
        ...mapState('rekapjurnal', {
            rekapjurnal: state => state.jurnal,
            jurnals: state => state.jurnals
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
        jurnal() {
            this.getJurnal()
        },
    },
    methods: {
        ...mapActions('rekapjurnal', ['getJurnal']),
        ...mapMutations('rekapjurnal', ['CLEAR_FORM']),
        submitRekap(){
            this.$bvModal.hide('tanggal-modal')//.then(() => {
                this.getJurnal()
            //})
        }
    },
    destroyed() {
        this.CLEAR_FORM()
    },
    
}
</script>

