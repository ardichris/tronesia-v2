<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <router-link :to="{ name: 'pelanggarans.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link>
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
                <b-table striped hover bordered :items="pelanggarans.data" :fields="fields" show-empty>                	
                    <template v-slot:cell(siswa_id)="row">
                        {{ row.item.siswa_id ? row.item.siswa.siswa_nama:'-' }}
                    </template>
                    <template v-slot:cell(actions)="row">
                        <router-link :to="{ name: 'pelanggarans.view', params: {id: row.item.pelanggaran_kode} }" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></router-link>
                        <router-link :to="{ name: 'pelanggarans.edit', params: {id: row.item.pelanggaran_kode} }" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></router-link>
                        <button class="btn btn-danger btn-sm" @click="deletePelanggaran(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>
              	<!-- TABLE UNTUK MENAMPILKAN LIST PELANGGARAN -->

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="pelanggarans.data"><i class="fa fa-bars"></i> {{ pelanggarans.data.length }} item dari {{ pelanggarans.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="pelanggarans.meta.total"
                                :per-page="pelanggarans.meta.per_page"
                                aria-controls="pelanggarans"
                                v-if="pelanggarans.data && pelanggarans.data.length > 0"
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
    name: 'DataPelanggaran',
    created() {
        this.getPelanggarans() //LOAD DATA PELANGGAN KETIKA COMPONENT DI-LOAD
    },
    data() {
        return {
            //FIELD YANG AKAN DITAMPILKAN PADA TABLE DIATAS
            fields: [
                { key: 'pelanggaran_kode', label: 'Kode' },
                { key: 'siswa_id', label: 'Nama Lengkap' },
                { key: 'pelanggaran_tanggal', label: 'Tanggal' },
                { key: 'pelanggaran_jenis', label: 'Jenis' },
                { key: 'pelanggaran_keterangan', label: 'Keterangan' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('pelanggaran', {
            pelanggarans: state => state.pelanggarans //MENGAMBIL DATA PELANGGARAN DARI STATE PELANGGARAN
        }),
        //MENGAMBIL DATA PAGE DARI STATE PELANGGARAN
        page: {
            get() {
                return this.$store.state.pelanggaran.page
            },
            set(val) {
                this.$store.commit('pelanggaran/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getPelanggarans() //KETIKA VALUE PAGE TERJADI PERUBAHAN, MAKA REQUEST DATA BARU
        },
        search() {
            this.getPelanggarans(this.search) //KETIKA VALUE SEARCH TERJADI PERUBAHAN, MAKA REQUEST DATA BARU
        }
    },
    methods: {
        ...mapActions('pelanggaran', ['getPelanggarans', 'removePelanggaran']), 
        //KETIKA TOMBOL HAPUS DITEKAN MAKA FUNGSI INI AKAN DIJALANKAN
        deletePelanggaran(id) {
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
                    this.removePelanggaran(id) //JIKA SETUJU MAKA PERMINTAAN HAPUS AKAN DI EKSEKUSI
                }
            })
        }
    }
}
</script>