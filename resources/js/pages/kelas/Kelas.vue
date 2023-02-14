<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <router-link :to="{ name: 'kelas.add' }" class="btn btn-primary btn-sm btn-flat">Tambah</router-link>
                        <button type="button" class="btn btn-success" size="sm" @click="$bvModal.show('modal-duplicate')" v-if="authenticated.role==0">Duplikat</button>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <span class="float-right">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari..." v-model="search">
                        </span>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <b-modal id="modal-duplicate" scrollable size="sm">
                    <template v-slot:modal-title>
                        Duplikat Kelas
                    </template>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" v-model="duplicateKelas">
                        <label class="form-check-label" for="flexCheckDefault">
                            Duplikat kelas semester lalu
                        </label>
                    </div>
                    <div class="form-check" v-if="duplicateKelas">
                        <input class="form-check-input" type="checkbox" v-model="duplicateMember">
                        <label class="form-check-label" for="flexCheckDefault">
                            Duplikat anggota kelas semester lalu
                        </label>
                    </div>
                    <div class="form-check" v-if="duplicateKelas">
                        <input class="form-check-input" type="checkbox" v-model="duplicateMengajar">
                        <label class="form-check-label" for="flexCheckDefault">
                            Duplikat mengajar semester lalu
                        </label>
                    </div>
                    <div class="form-check" v-if="duplicateMengajar">
                        <input class="form-check-input" type="checkbox" v-model="duplicateJadwal">
                        <label class="form-check-label" for="flexCheckDefault">
                            Duplikat jadwal mengajar semester lalu
                        </label>
                    </div>
                    <template v-slot:modal-footer>
                        <b-button
                            variant="success"
                            class="mt-3"
                            block  @click="submitDuplicate"
                        >
                            Apply
                        </b-button>
                    </template>
                </b-modal>
                <b-table striped hover bordered :items="kelass.data" :fields="fields" show-empty>
                    <template v-slot:cell(kelas_wali)="row">
                        {{ row.item.kelas_wali ? row.item.user.name:'-' }}
                    </template>
                    <template v-slot:cell(k_mentor)="row">
                        {{ row.item.k_mentor ? row.item.mentor.name:'-' }}
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
        this.getKelas()
    },
    data() {
        return {
            fields: [
                { key: 'kelas_nama', label: 'Nama Kelas' },
                { key: 'kelas_jenjang', label: 'Jenjang Kelas' },
                { key: 'kelas_wali', label: 'Wali Kelas' },
                { key: 'k_mentor', label: 'Mentor' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: '',
            duplicateKelas: false,
            duplicateMember: false,
            duplicateMengajar: false,
            duplicateJadwal: false
        }
    },
    computed: {
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        ...mapState('kelas', {
            kelass: state => state.kelass
        }),
        page: {
            get() {
                return this.$store.state.kelas.page
            },
            set(val) {
                this.$store.commit('kelas/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getKelas()
        },
        search() {
            this.getKelas(this.search)
        }
    },
    methods: {
        ...mapActions('kelas', ['getKelas', 'removeKelas', 'duplikatKelas']),
        submitDuplicate(){
            this.duplikatKelas({
                dKelas: this.duplicateKelas,
                dMember: this.duplicateMember,
                dMengajar: this.duplicateMengajar,
                dJadwal: this.duplicateJadwal
            }).then(() => {
                this.$bvModal.hide('modal-duplicate')
            });
        },
        deleteKelas(id) {
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
                    this.removeKelas(id)
                }
            })
        }
    }
}
</script>

