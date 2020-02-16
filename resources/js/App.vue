<template>

    <div class="wrapper">
        <app-header v-if="isAuth" />
        <app-sidebar v-if="isAuth" />

           <router-view></router-view>

        <app-footer v-if="isAuth" />
    </div>
</template>
<script>
    import { mapState, mapGetters } from 'vuex'
    import Header from './components/Header.vue'
    import Footer from './components/Footer.vue'
    import Sidebar from './components/Sidebar.vue'
    export default {
        computed: {
            ...mapState(['token']),
            ...mapGetters(['isAuth'])
        },
        components: {
            'app-header': Header,
            'app-sidebar': Sidebar,
            'app-footer': Footer,
            
        }
    }
</script>