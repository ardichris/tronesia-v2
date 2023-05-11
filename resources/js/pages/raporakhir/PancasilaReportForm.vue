<template>
<div>
    <div v-for="(row,index) in pancasilareport.pr_project" v-bind:key="index">
        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
            <b-button block v-b-toggle="'accordion-element'+index" variant="info" class="collapsed">{{row.pp_name}}</b-button>
            </b-card-header>

            <b-collapse
            :id="'accordion-element'+index"
            :accordion="'element-accordion'+index"
            role="tabpanel"
            >

            <div class="form-group" v-for="(rowelement, indexelement) in row.element" :key="indexelement">
                <label>[{{rowelement.pe_dimension}}] [{{rowelement.pe_element}}]<br>{{rowelement.pe_subelement}}</label>
                <select type="text" class="form-control" aria-invalid="false" v-model="rowelement.score">
                    <option value=""></option>
                    <option value="MB">MB</option>
                    <option value="SB">SB</option>
                    <option value="BSH">BSH</option>
                    <option value="SAB">SAB</option>
                </select>
            </div>
            <div class="row" style="margin-top:10px">
                <div class="col-lg-12">
                    <label for="">Catatan Proses</label>
                </div>
                <div class="col-lg-12">
                    <textarea class="form-control" v-model="row.comment"></textarea>
                </div>
            </div>
            </b-collapse>
        </b-card>
    </div>
</div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'

export default {
    name: 'FormPancasilaProject',
    created(){

    },
    computed: {
        ...mapState('raporakhir',{
            pancasilareport: state => state.pancasilareport
        }),
        ...mapMutations('raporakhir',['CLEAR_FORM'])
    },
    destroyed(){
        this.CLEAR_FORM
    },
    components: {
        vSelect
    }
}
</script>
