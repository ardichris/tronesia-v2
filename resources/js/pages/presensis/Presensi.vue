<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="float-right">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search">
                        </span>
                    </div>
                </div>
            </div>
            <div class="panel-body">
              
              	<!-- TABLE UNTUK MENAMPILKAN LIST PELANGGARAN -->
                <b-table striped hover bordered :items="presensis.data" :fields="fields" show-empty>                	
                    <template v-slot:cell(siswa_id)="row">
                        {{ row.item.siswa_id ? row.item.siswa.siswa_nama:'-' }}
                    </template>
                    <template v-slot:cell(presensi_tanggal)="row">
                        <h5><span class="badge badge-info">{{ row.item.jurnal.jm_tanggal ? row.item.jurnal.jm_tanggal:'-' }}</span></h5>
                    </template>
                    <template v-slot:cell(jampel)="row">
                        <h5><span class="badge badge-warning">{{ row.item.siswa.siswa_kelas }} <span class="badge badge-danger">{{ row.item.jurnal.jm_jampel}}</span></span></h5>
                    </template>
                </b-table>
              	<!-- TABLE UNTUK MENAMPILKAN LIST PELANGGARAN -->

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="presensis.data"><i class="fa fa-bars"></i> {{ presensis.data.length }} item dari {{ presensis.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="presensis.meta.total"
                                :per-page="presensis.meta.per_page"
                                aria-controls="presensis"
                                v-if="presensis.data && presensis.data.length > 0"
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

export default {
    name: 'DataPresensi',
    created() {
        this.getPresensi()
    },
    data() {
        return {
            fields: [
                { key: 'presensi_tanggal', label: 'Tanggal' },
                { key: 'jampel', label: 'Kelas/JP' },
                { key: 'siswa_id', label: 'Nama Lengkap' },
                { key: 'alasan', label: 'Alasan' }
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('presensi', {
            presensis: state => state.presensis,
            presensi: state => state.presensi,
            siswas: state => state.siswas
        }),
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        //MENGAMBIL DATA PAGE DARI STATE PELANGGARAN
        page: {
            get() {
                return this.$store.state.presensi.page
            },
            set(val) {
                this.$store.commit('presensi/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getPresensi()
        },
        search() {
            this.getPresensi(this.search)
        }
    },
    methods: {
        ...mapActions('presensi', ['getPresensi']),
        ...mapMutations('presensi', ['CLEAR_FORM']),
    }
}
</script>