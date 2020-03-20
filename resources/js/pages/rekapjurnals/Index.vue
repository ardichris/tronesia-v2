<template>
    <div class="content-wrapper">
        <div class="container">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <center><h1>Tugas Siswa</h1></center>
                            <div class="col-sm-4">
                                <label for="">Kelas</label>
                                <v-select :options="kelass.data"
                                    v-model="rekapjurnal.kelas"
                                    @search="onSearchh"
                                    :value="$store.myValue"
                                    label="kelas_nama"
                                    placeholder="Masukkan Kata Kunci" 
                                    :disabled="$route.name == 'jurnal.view'"
                                    :filterable="false">
                                    <template slot="no-options">
                                        Masukkan Kata Kunci
                                    </template>
                                    <template slot="option" slot-scope="option">
                                        {{ option.kelas_nama }}
                                    </template>
                                </v-select>
                            </div>
                            <div class="col-sm-4">
                                <label for="">Tanggal</label>
                                <input type="date" class="form-control" v-model="rekapjurnal.tanggal" :readonly="$route.name == 'jurnal.view'">
                            </div>
                            
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="row">
                    
                        <router-view></router-view>
                    
                </div>
            </section>
        </div>
    </div>
    
</template>
<script>
    import Breadcrumb from '../../components/Breadcrumb.vue'
    import { mapActions, mapState } from 'vuex'
    import vSelect from 'vue-select'
    export default {
        name: 'IndexRekapJurnal',
        components: {
            'breadcrumb': Breadcrumb
        },
        
        computed: {
            ...mapState('rekapjurnal', {
                rekapjurnal: state => state.jurnal,
                kelass: state => state.kelas
            }),
            ...mapState('user', {
                authenticated: state => state.authenticated
            }),
        },
        methods: {
            ...mapActions('rekapjurnal',['getJurnal','getKelas']),
            onSearchh(search, loading) {
                this.getKelas({
                    search: search,
                    loading: loading
                })            
            },

        },
        components: {
        vSelect
        }
    }
</script>