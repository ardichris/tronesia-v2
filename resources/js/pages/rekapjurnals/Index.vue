<template>
    <div class="content-wrapper">
        <div class="container">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <center><h1>Rekap Jurnal Mengajar</h1></center>                           
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