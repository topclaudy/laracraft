<template>
    <div>
        <div v-if="error">
            {{ error }}
        </div>

        <el-table :data="themes" v-loading="themesLoading" stripe empty-text="0 themes found">
            <el-table-column prop="view" label="View">
                <template slot-scope="scope">
                    <router-link :to="{name: 'theme', params:{id: scope.row.id}}">{{ scope.row.view }}</router-link>
                </template>
            </el-table-column>

            <el-table-column prop="regions.length" label="Regions"></el-table-column>
        </el-table>
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';

    export default {
        name: "screen-themes",

        data () {
            return {
                error: null,
                search: null
            }
        },

        created () {

        },

        computed: {
            ...mapState({
                themes: ({themeModule}) => themeModule.items,
                themesLoading: ({themeModule}) => themeModule.loading
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