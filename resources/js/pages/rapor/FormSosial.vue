<template>
    <div class="row">
        <div class="table-responsive">
            <label>KI2-1 : Jujur</label><br>
            <label>KI2-2 : Disiplin & tanggung jawab</label><br>
            <label>KI2-3 : Toleransi</label><br>
            <label>KI2-4 : Gotong royong</label><br>
            <label>KI2-5 : Salam, senyum, sapa, sopan dan santun</label><br>
            <label>KI2-6 : Percaya diri</label><br>
            <label>KI2-7 : Menjaga keindahan dan kebersihan</label><br>
            <table class="table" width="700px">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th style="text-align:center">KI2-1</th>
                        <th style="text-align:center">KI2-2</th>
                        <th style="text-align:center">KI2-3</th>
                        <th style="text-align:center">KI2-4</th>
                        <th style="text-align:center">KI2-5</th>
                        <th style="text-align:center">KI2-6</th>
                        <th style="text-align:center">KI2-7</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in rapor" :key="index">
                        <td>
                            {{row.s_nama}}
                        </td>
                        <td style="width:100px">
                            <input type="text" class="form-control" v-model="row.KI21" >
                        </td>
                        <td style="width:100px">
                            <input type="text" class="form-control" v-model="row.KI22" >
                        </td>
                        <td style="width:100px">
                            <input type="text" class="form-control" v-model="row.KI23" >
                        </td>
                        <td style="width:100px">
                            <input type="text" class="form-control" v-model="row.KI24" >
                        </td>
                        <td style="width:100px">
                            <input type="text" class="form-control" v-model="row.KI25" >
                        </td>
                        <td style="width:100px">
                            <input type="text" class="form-control" v-model="row.KI26" >
                        </td>
                        <td style="width:100px">
                            <input type="text" class="form-control" v-model="row.KI27" >
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
export default {
    name: 'FormKi1',
    created(){
        this.getNilaiSosial();
    },
    computed: {
        ...mapState(['errors']),
        ...mapState('rapor', {
            rapor: state => state.raporki2
        })
    },
    methods: {
        ...mapActions('rapor', ['getNilaiSosial']),
        ...mapMutations('rapor', ['CLEAR_FORM']),
    },
    destroyed() {
        this.CLEAR_FORM()
    },

}
</script>