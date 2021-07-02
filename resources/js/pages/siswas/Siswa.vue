<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <router-link :to="{ name: 'siswas.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="float-right">
                            <b-form-input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search"></b-form-input>
                        </span>
                        <span class="float-right">
                            <b-form-select 
                                v-model="status"
                                size="sm"                               
                                :options="['','AKTIF','ALUMNI','SISWA BARU']"
                                required
                                ></b-form-select>
                        </span>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <b-table striped hover bordered :items="siswas.data" :fields="fields" show-empty>
                    <template v-slot:cell(siswa_kelamin)="row">
                        <span class="badge badge-info" v-if="row.item.siswa_kelamin == 'Laki-laki'">L</span>
                        <span class="badge badge-danger" v-if="row.item.siswa_kelamin == 'Perempuan'">P</span>
                    </template>
                    <template v-slot:cell(s_keterangan)="row">
                        <span class="badge badge-danger" v-if="row.item.s_keterangan == 'ALUMNI'">Alumni</span>
                        <span class="badge badge-primary" v-if="row.item.s_keterangan == 'SISWA BARU'">Siswa Baru</span>
                        <span class="badge badge-success" v-if="row.item.s_keterangan == 'AKTIF'">Aktif</span>
                    </template>
                    <template v-slot:cell(actions)="row">
                        <router-link :to="{ name: 'siswas.view', params: {id: row.item.id} }" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></router-link>
                        <router-link :to="{ name: 'siswas.edit', params: {id: row.item.id} }" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></router-link>
                        <button class="btn btn-danger btn-sm" @click="deleteSiswa(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>

                <div class="row">
                    <div class="col-sm-6">
                        <p v-if="siswas.data"><i class="fa fa-bars"></i> {{ siswas.data.length }} item dari {{ siswas.meta.total }} total data</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="siswas.meta.total"
                                :per-page="siswas.meta.per_page"
                                aria-controls="siswas"
                                v-if="siswas.data && siswas.data.length > 0"
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
    name: 'DataSiswa',
    created() {
        //SEBELUM COMPONENT DI-LOAD, REQUEST DATA DARI SERVER
        this.getSiswas({
                search: this.search,
                status: this.status
            })
    },
    data() {
        return {
            //FIELD UNTUK B-TABLE, PASTIKAN KEY NYA SESUAI DENGAN FIELD DATABASE
            //AGAR OTOMATIS DI-RENDER
            fields: [
                { key: 'siswa_kelas', label: 'Kelas' },
                { key: 'siswa_nis', label: 'NIS' },
                { key: 'siswa_nama', label: 'Nama Siswa' },
                { key: 'siswa_kelamin', label: 'L/P' },
                { key: 's_keterangan', label: 'Status' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: '',
            status: 'AKTIF'
        }
    },
    computed: {
        //MENGAMBIL DATA OUTLETS DARI STATE OUTLETS
        ...mapState('siswa', {
            siswas: state => state.siswas
        }),
        page: {
            get() {
                //MENGAMBIL VALUE PAGE DARI VUEX MODULE siswa
                return this.$store.state.siswa.page
            },
            set(val) {
                //APABILA TERJADI PERUBAHAN VALUE DARI PAGE, MAKA STATE PAGE
                //DI VUEX JUGA AKAN DIUBAH
                this.$store.commit('siswa/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {            
            this.getSiswas({
                search: this.search,
                status: this.status
            })
        },
        search() {
            this.getSiswas({
                search: this.search,
                status: this.status
            })
        },
        status() {
            this.getSiswas({
                search: this.search,
                status: this.status
            })
        }
    },
    methods: {
        //MENGAMBIL FUNGSI DARI VUEX MODULE siswa
        ...mapActions('siswa', ['getSiswas', 'removeSiswa']),
        //KETIKA TOMBOL HAPUS DICLICK, MAKA AKAN MENJALANKAN METHOD INI
        deleteSiswa(id) {
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
                    //MAKA FUNGSI removeSiswa AKAN DIJALANKAN
                    this.removeSiswa(id)
                    this.getSiswas({
                        search: this.search,
                        status: this.status
                    })
                }
            })
        }
    }
}
</script>

