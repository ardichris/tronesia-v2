<template>
    <div class="col-md-12">
        <div class="form-group" :class="{ 'has-error': errors.inv_code }">
            <label for="">Kode Inventaris</label>
            <input type="text" class="form-control" v-model="inventory.inv_code" :readonly="$route.name == 'inventory.edit' || $route.name == 'inventory.view'">
            <p class="text-danger" v-if="errors.inv_code">{{ errors.inv_code[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.inv_name }">
            <label for="">Nama Inventaris</label>
            <input type="text" class="form-control" v-model="inventory.inv_name" :readonly="$route.name == 'inventory.edit' || $route.name == 'inventory.view'">
            <p class="text-danger" v-if="errors.inv_name">{{ errors.inv_name[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.inv_serialnumber }">
            <label for="">Serial Number</label>
            <input type="text" class="form-control" v-model="inventory.inv_serialnumber" :readonly="$route.name == 'inventory.edit' || $route.name == 'inventory.view'">
            <p class="text-danger" v-if="errors.inv_serialnumber">{{ errors.inv_serialnumber[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.inv_condition }">
            <label for="">Kondisi</label>
            <input type="text" class="form-control" v-model="inventory.inv_condition" :readonly="$route.name == 'inventory.edit' || $route.name == 'inventory.view'">
            <p class="text-danger" v-if="errors.inv_condition">{{ errors.inv_condition[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.inv_location }">
            <label for="">Lokasi</label>
            <input type="text" class="form-control" v-model="inventory.inv_location" :readonly="$route.name == 'inventory.edit' || $route.name == 'inventory.view'">
            <p class="text-danger" v-if="errors.inv_location">{{ errors.inv_location[0] }}</p>
        </div>
        <div class="form-group" :class="{ 'has-error': errors.inv_location }">
            <label for="">Status</label>
            <v-select :options="['Active', 'Service', 'Failed', 'Lost', 'Deleted']"
                        v-model="inventory.inv_status"
                        :value="inventory.inv_status"
                        >
            </v-select>
            <p class="text-danger" v-if="errors.inv_location">{{ errors.inv_location[0] }}</p>
        </div>
    </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
export default {
    name: 'FormBarang',
    computed: {
        ...mapState(['errors']),
        ...mapState('inventory', {
            inventory: state => state.inventory
        })
    },
    methods: {
        ...mapMutations('inventory', ['CLEAR_FORM']),
    },
    destroyed() {
        this.CLEAR_FORM()
    },
    components: {
        vSelect
    }
}
</script>
