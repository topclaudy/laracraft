<template>
    <div>
        <div v-if="error">
            {{ error }}
        </div>

        <el-table :data="components" v-loading="componentsLoading" stripe empty-text="0 components found">
            <el-table-column prop="name" label="Name"></el-table-column>

            <el-table-column prop="description" label="Description"></el-table-column>

            <el-table-column prop="class" label="Class"></el-table-column>
        </el-table>
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';

    export default {
        name: "screen-components",

        data () {
            return {
                error: null
            }
        },

        created () {
        },

        computed: {
            ...mapState({
                components: ({componentModule}) => componentModule.items,
                componentsLoading: ({componentModule}) => componentModule.loading
            })
        },

        watch: {
            // call again the method if the route changes
            //'$route': 'fetchData'
        },

        methods: {

        }
    }
</script>

<style scoped>

</style>