<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <b-button variant="primary" size="sm" v-b-modal="'add-modal'" @click="getJurnal">View</b-button>
                <b-table striped hover bordered :items="jurnals.data" :fields="fields" show-empty>
                    <template v-slot:cell(mapel_id)="row">
                        {{ row.item.mapel.mapel_kode }}
                    </template>
                </b-table>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState, mapMutations } from 'vuex'

export default {
    name: 'DataJurnal',
    created() {
        this.getJurnal()
    },
    data() {
        return {            
            fields: [
                { key: 'jm_jampel', label: 'Jam' },
                { key: 'mapel_id', label: 'Mapel' },
                { key: 'jm_materi', label: 'Materi' },
                { key: 'jm_keterangan', label: 'Keterangan' }

            ],
            search: ''
        }
    },

    computed: {
        ...mapState('rekapjurnal', {
            jurnals: state => state.jurnals
        }),
        ...mapState('user', {
            authenticated: state => state.authenticated
        }),
        page: {
            get() {
                return this.$store.state.jurnal.page
            },
            set(val) {
                this.$store.commit('jurnal/SET_PAGE', val)
            }
        }
    },
    watch: {
        jurnal() {
            this.getJurnal()
        },
    },
    methods: {
        ...mapActions('rekapjurnal', ['getJurnal']),
        ...mapMutations('rekapjurnal', ['CLEAR_FORM']),
    },
    destroyed() {
        this.CLEAR_FORM()
    }
}
</script>

