<template>
    <div class="content-wrapper">
        <div class="container">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Penerimaan Siswa Baru</h1>
                        </div>
                        <div class="col-sm-6">
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
        name: 'PenerimaanSiswa',
        components: {
            'breadcrumb': Breadcrumb
        }
    }
</script>
