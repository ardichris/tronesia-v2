<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <router-link :to="{ name: 'kompetensi.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="float-right">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search">
                        </span>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <b-table striped hover bordered :items="kompetensis.data" :fields="fields" show-empty>
                    <template v-slot:cell(actions)="row">
                        <div class="btn-group">
                            <router-link :to="{ name: 'kompetensi.view', params: {id: row.item.id} }" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></router-link>
                            <router-link :to="{ name: 'kompetensi.edit', params: {id: row.item.id} }" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></router-link>
                            <button class="btn btn-danger btn-sm" @click="deleteKompetensi(row.item.id)"><i class="fa fa-trash"></i></button>
                        </div>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="kompetensis.data"><i class="fa fa-bars"></i> {{ kompetensis.data.length }} item dari {{ kompetensis.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="kompetensis.meta.total"
                                :per-page="kompetensis.meta.per_page"
                                aria-controls="kompetensis"
                                v-if="kompetensis.data && kompetensis.data.length > 0"
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
    name: 'DataKompetensi',
    created() {
        //SEBELUM COMPONENT DI-LOAD, REQUEST DATA DARI SERVER
        this.getKompetensi()
    },
    data() {
        return {
            //FIELD UNTUK B-TABLE, PASTIKAN KEY NYA SESUAI DENGAN FIELD DATABASE
            //AGAR OTOMATIS DI-RENDER
            fields: [
                { key: 'kompetensi_mapel', label: 'Mata Pelajaran' },
                { key: 'kompetensi_jenjang', label: 'Jenjang Kelas' },
                { key: 'kd_kode', label: 'KD' },
                { key: 'kompetensi_deskripsi', label: 'Deskripsi' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        //MENGAMBIL DATA OUTLETS DARI STATE OUTLETS
        ...mapState('kompetensi', {
            kompetensis: state => state.kompetensis
        }),
        page: {
            get() {
                //MENGAMBIL VALUE PAGE DARI VUEX MODULE kompetensi
                return this.$store.state.kompetensi.page
            },
            set(val) {
                //APABILA TERJADI PERUBAHAN VALUE DARI PAGE, MAKA STATE PAGE
                //DI VUEX JUGA AKAN DIUBAH
                this.$store.commit('kompetensi/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            //APABILA VALUE DARI PAGE BERUBAH, MAKA AKAN MEMINTA DATA DARI SERVER
            this.getKompetensi()
        },
        search() {
            //APABILA VALUE DARI SEARCH BERUBAH MAKA AKAN MEMINTA DATA
            //SESUAI DENGAN DATA YANG SEDANG DICARI
            this.getKompetensi(this.search)
        }
    },
    methods: {
        //MENGAMBIL FUNGSI DARI VUEX MODULE kompetensi
        ...mapActions('kompetensi', ['getKompetensi', 'removeKompetensi']),
        //KETIKA TOMBOL HAPUS DICLICK, MAKA AKAN MENJALANKAN METHOD INI
        deleteKompetensi(id) {
            //AKAN MENAMPILKAN JENDELA KONFIRMASI
            this.$swal({
                title: 'Kamu Yakin?',
                text: "Tindakan ini akan menghapus secara permanent!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, Lanjutkan!'
            }).then((result) => {
                //JIKA DISETUJUI
                if (result.value) {
                    //MAKA FUNGSI removeKompetensi AKAN DIJALANKAN
                    this.removeKompetensi(id)
                }
            })
        }
    }
}
</script>

