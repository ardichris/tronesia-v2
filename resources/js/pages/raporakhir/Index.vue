<template>
    <div class="content-wrapper">
        <div class="container">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Rapor Akhir Siswa</h1>
                        </div>
                        <div class="col-sm-6">
                            <breadcrumb></breadcrumb>
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
    export default {
        name: 'IndexRaporAkhir',
        components: {
            'breadcrumb': Breadcrumb
        }
    }
</script>