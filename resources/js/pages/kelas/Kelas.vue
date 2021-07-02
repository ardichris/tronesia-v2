<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <router-link :to="{ name: 'kelas.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="float-right">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search">
                        </span>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <b-table striped hover bordered :items="kelass.data" :fields="fields" show-empty>
                    <template v-slot:cell(kelas_wali)="row">
                        {{ row.item.kelas_wali ? row.item.user.name:'-' }}
                    </template>
                    <template v-slot:cell(actions)="row">
                        <div class="btn-group">
                            <router-link :to="{ name: 'kelas.view', params: {id: row.item.kelas_nama} }" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></router-link>
                            <router-link :to="{ name: 'kelas.edit', params: {id: row.item.id} }" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></router-link>
                            <button class="btn btn-danger btn-sm" @click="deleteKelas(row.item.id)"><i class="fa fa-trash"></i></button>
                      </div>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="kelass.data"><i class="fa fa-bars"></i> {{ kelass.data.length }} item dari {{ kelass.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="kelass.meta.total"
                                :per-page="kelass.meta.per_page"
                                aria-controls="kelass"
                                v-if="kelass.data && kelass.data.length > 0"
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
    name: 'DataKelas',
    created() {
        //SEBELUM COMPONENT DI-LOAD, REQUEST DATA DARI SERVER
        this.getKelas()
    },
    data() {
        return {
            //FIELD UNTUK B-TABLE, PASTIKAN KEY NYA SESUAI DENGAN FIELD DATABASE
            //AGAR OTOMATIS DI-RENDER
            fields: [
                { key: 'kelas_nama', label: 'Nama Kelas' },
                { key: 'kelas_jenjang', label: 'Jenjang Kelas' },
                { key: 'kelas_wali', label: 'Wali Kelas' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        //MENGAMBIL DATA OUTLETS DARI STATE OUTLETS
        ...mapState('kelas', {
            kelass: state => state.kelass
        }),
        page: {
            get() {
                //MENGAMBIL VALUE PAGE DARI VUEX MODULE kelas
                return this.$store.state.kelas.page
            },
            set(val) {
                //APABILA TERJADI PERUBAHAN VALUE DARI PAGE, MAKA STATE PAGE
                //DI VUEX JUGA AKAN DIUBAH
                this.$store.commit('kelas/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            //APABILA VALUE DARI PAGE BERUBAH, MAKA AKAN MEMINTA DATA DARI SERVER
            this.getKelas()
        },
        search() {
            //APABILA VALUE DARI SEARCH BERUBAH MAKA AKAN MEMINTA DATA
            //SESUAI DENGAN DATA YANG SEDANG DICARI
            this.getKelas(this.search)
        }
    },
    methods: {
        //MENGAMBIL FUNGSI DARI VUEX MODULE kelas
        ...mapActions('kelas', ['getKelas', 'removeKelas']),
        //KETIKA TOMBOL HAPUS DICLICK, MAKA AKAN MENJALANKAN METHOD INI
        deleteKelas(id) {
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
                    //MAKA FUNGSI removeKelas AKAN DIJALANKAN
                    this.removeKelas(id)
                }
            })
        }
    }
}
</script>

