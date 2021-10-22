<template>
    <div class="row">
        <div class="table-responsive">
            <label>KI1-1 : Berpartisipasi aktif saat ibadah</label><br>
            <label>KI1-2 : Mengekspresikan sukacita</label><br>
            <label>KI1-3 : Mengucap syukur</label><br>
            <label>KI1-4 : Memuliakan Tuhan</label><br>
            <table class="table" width="700px">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th style="text-align:center">KI1-1</th>
                        <th style="text-align:center">KI1-2</th>
                        <th style="text-align:center">KI1-3</th>
                        <th style="text-align:center">KI1-4</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in rapor.nilai" :key="index">
                        <td>
                            {{row.s_nama}}
                        </td>
                        <td style="width:100px">
                            <input type="text" class="form-control" v-model="row.KI11" >
                        </td>
                        <td style="width:100px">
                            <input type="text" class="form-control" v-model="row.KI12" >
                        </td>
                        <td style="width:100px">
                            <input type="text" class="form-control" v-model="row.KI13" >
                        </td>
                        <td style="width:100px">
                            <input type="text" class="form-control" v-model="row.KI14" >
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <span class="float-right">
                <button type="button" class="btn btn-primary" @click="submitKi1">Submit Nilai</button>
            </span>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
export default {
    name: 'FormKi1',
    created(){
        this.getNilaiSpiritual();
    },
    computed: {
        ...mapState(['errors']), //MENGAMBIL STATE ERRORS
        ...mapState('rapor', {
            rapor: state => state.raporki1 //MENGAMBIL STATE SISWA
        })
    },
    methods: {
        ...mapActions('rapor', ['getNilaiSpiritual','putNilaiSpiritual']),
        ...mapMutations('rapor', ['CLEAR_FORM']), //PANGGIL MUTATIONS CLEAR_FORM
        submitKi1(){
            //console.log('tes'),
            this.putNilaiSpiritual()
        }
    },
    //KETIKA PAGE INI DITINGGALKAN MAKA 
    destroyed() {
        //FORM DI BERSIHKAN
        this.CLEAR_FORM()
    },

}
</script>