<template >
  <component :is="layout"></component>

</template>

<script>
import AuthLayout from './components/layouts/Auth'
import MainLayout from './components/layouts/Main'
import {mapState} from 'vuex'
export default {
    components: {AuthLayout, MainLayout},
    computed: mapState(['layout']),
    data() {
        return {

        };
    },
    methods: {



    }
};
</script>
