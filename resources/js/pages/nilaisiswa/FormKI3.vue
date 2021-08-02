<template>
    <div class="row">
        <b-tabs pills card vertical>
        <b-tab title="PTS/PAS" active style="margin-bottom:10px;height:auto;overflow:hidden"><b-card-text>KKM</b-card-text></b-tab>
        <b-tab title="Ulangan" style="margin-bottom:10px;height:auto;overflow:hidden">
            <b-card-text>
                <div id="spreadsheet"></div>
            </b-card-text>
        </b-tab>
        <b-tab title="Tugas" style="margin-bottom:10px;height:auto;overflow:hidden"><b-card-text>{{nilaisiswa}}</b-card-text></b-tab>
        </b-tabs>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'


// var data = [
//   ['Jazz', 'Honda', '2019-02-12', '', true, '$ 2.000,00', '#777700'],
//   ['Civic', 'Honda', '2018-07-11', '', true, '$ 4.000,01', '#007777']
// ]
// var options = {
//   data: data,
//   allowToolbar:true,
//   columns: [
//     { type: 'text', title: 'Car', width: '120px' },
//     { type: 'dropdown', title: 'Make', width: '250px', source: [ 'Alfa Romeo', 'Audi', 'Bmw' ] },
//     { type: 'calendar', title: 'Available', width: '250px' },
//     { type: 'image', title: 'Photo', width: '120px' },
//     { type: 'checkbox', title: 'Stock', width: '80px' },
//     { type: 'numeric', title: 'Price', width: '100px', mask: '$ #.##,00', decimal: ',' },
//     { type: 'color', width: '100px', render: 'square' }
//   ]
// }



export default {
    name: 'FormKI3',
    created() {
            this.getNilai()
        },
    data() {
        return {
            table:[],
            options:{
                data: this.nilaisiswa
                    // ['Jazz', 'Honda', '2019-02-12', '', true, '$ 2.000,00', '#777700'],
                    // ['Civic', 'Honda', '2018-07-11', '', true, '$ 4.000,01', '#007777']
                ,
                columns: [
                    { type: 'text', title: 'Car', width: '120px', name: 'unit_id' },
                    { type: 'dropdown', title: 'Make', width: '250px', source: [ 'Alfa Romeo', 'Audi', 'Bmw' ] },
                    { type: 'calendar', title: 'Available', width: '250px' },
                    { type: 'image', title: 'Photo', width: '120px' },
                    { type: 'checkbox', title: 'Stock', width: '80px' },
                    { type: 'numeric', title: 'Price', width: '100px', mask: '$ #.##,00', decimal: ',' },
                    { type: 'color', width: '100px', render: 'square' }
                ]
            }
        }
    },
    mounted: function () {
        let spreadsheet = jexcel(this.$el, this.options)
        this.table = Object.assign(this, spreadsheet)
    },
    computed: {
        ...mapState(['errors']), //MENGAMBIL STATE ERRORS
        ...mapState('nilaisiswa', {
            nilaisiswa: state => state.nilaisiswas, //MENGAMBIL STATE SISWA
        }),
    },
    methods: {
        ...mapActions('nilaisiswa', ['getNilai']),
        ...mapMutations('nilaisiswa', ['CLEAR_FORM']), //PANGGIL MUTATIONS CLEAR_FORM
    },
    //KETIKA PAGE INI DITINGGALKAN MAKA 
    destroyed() {
        //FORM DI BERSIHKAN
        this.CLEAR_FORM()
    }
}
</script>