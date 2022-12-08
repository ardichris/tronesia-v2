<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <router-link :to="{ name: 'lingkupmateri.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="float-right">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search">
                        </span>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <b-table striped hover bordered :items="lingkupmateris.data" :fields="fields" show-empty>
                    <template v-slot:cell(actions)="row">
                        <div class="btn-group">
                            <router-link :to="{ name: 'lingkupmateri.view', params: {id: row.item.id} }" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></router-link>
                            <router-link :to="{ name: 'lingkupmateri.edit', params: {id: row.item.id} }" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></router-link>
                            <button class="btn btn-danger btn-sm" @click="deleteLingkupMateri(row.item.id)"><i class="fa fa-trash"></i></button>
                        </div>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="lingkupmateris.data"><i class="fa fa-bars"></i> {{ lingkupmateris.data.length }} item dari {{ lingkupmateris.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="lingkupmateris.meta.total"
                                :per-page="lingkupmateris.meta.per_page"
                                aria-controls="lingkupmateris"
                                v-if="lingkupmateris.data && lingkupmateris.data.length > 0"
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
    name: 'DataLingkupMateri',
    created() {
        //SEBELUM COMPONENT DI-LOAD, REQUEST DATA DARI SERVER
        this.getLingkupMateri()
    },
    data() {
        return {
            //FIELD UNTUK B-TABLE, PASTIKAN KEY NYA SESUAI DENGAN FIELD DATABASE
            //AGAR OTOMATIS DI-RENDER
            fields: [
                { key: 'lingkupmateri_mapel', label: 'Mata Pelajaran' },
                { key: 'lingkupmateri_jenjang', label: 'Jenjang Kelas' },
                { key: 'kd_kode', label: 'KD' },
                { key: 'lingkupmateri_deskripsi', label: 'Deskripsi' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        //MENGAMBIL DATA OUTLETS DARI STATE OUTLETS
        ...mapState('lingkupmateri', {
            lingkupmateris: state => state.lingkupmateris
        }),
        page: {
            get() {
                //MENGAMBIL VALUE PAGE DARI VUEX MODULE lingkupmateri
                return this.$store.state.lingkupmateri.page
            },
            set(val) {
                //APABILA TERJADI PERUBAHAN VALUE DARI PAGE, MAKA STATE PAGE
                //DI VUEX JUGA AKAN DIUBAH
                this.$store.commit('lingkupmateri/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            //APABILA VALUE DARI PAGE BERUBAH, MAKA AKAN MEMINTA DATA DARI SERVER
            this.getLingkupMateri()
        },
        search() {
            //APABILA VALUE DARI SEARCH BERUBAH MAKA AKAN MEMINTA DATA
            //SESUAI DENGAN DATA YANG SEDANG DICARI
            this.getLingkupMateri(this.search)
        }
    },
    methods: {
        //MENGAMBIL FUNGSI DARI VUEX MODULE lingkupmateri
        ...mapActions('lingkupmateri', ['getLingkupMateri', 'removeLingkupMateri']),
        //KETIKA TOMBOL HAPUS DICLICK, MAKA AKAN MENJALANKAN METHOD INI
        deleteLingkupMateri(id) {
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
                    //MAKA FUNGSI removeLingkupMateri AKAN DIJALANKAN
                    this.removeLingkupMateri(id)
                }
            })
        }
    }
}
</script>

