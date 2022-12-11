<template>
    <div class="content-wrapper">
        <div class="container">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Laporan Kurikulum</h1>
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
    export default {
        name: 'LaporanKurikulum',
        components: {
        }
    }
</script>
