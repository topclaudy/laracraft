<template>
    <div>
        <div v-if="error">
            {{ error }}
        </div>

        <el-button @click="showBlockEditor(null)">Add block</el-button>

        <el-table :data="blocks" v-loading="blocksLoading" stripe empty-text="0 blocks found" class="mt-4">
            <el-table-column prop="name" label="Title">
                <template slot-scope="scope">
                    <router-link :to="{name: 'block-edit', params: {id: scope.row.id}}">{{ scope.row.name }}</router-link>
                </template>
            </el-table-column>

            <el-table-column prop="type" label="Type">
                <template slot-scope="scope">
                    <span class="uppercase text-grey">{{ scope.row.type }}</span>
                </template>
            </el-table-column>

            <el-table-column prop="resource" label="Resource">
                <template slot-scope="scope">
                    <div v-if="scope.row.type === 'component'">{{ scope.row.resource }}</div>
                    <div v-if="scope.row.type === 'wysiwyg'">
                        HTML
                        <el-tooltip placement="left" effect="light">
                            <div slot="content">
                                <div v-html="scope.row.resource"></div>
                            </div>
                            <span class="cursor-pointer"><i class="el-icon-view"></i></span>
                        </el-tooltip>
                    </div>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';

    export default {
        name: "screen-blocks",

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
                blocks: ({blockModule}) => blockModule.items,
                blocksLoading: ({blockModule}) => blockModule.loading
            })
        },

        watch: {
            // call again the method if the route changes
            //'$route': 'fetchData'
        },

        methods: {
            showBlockEditor(blockId){
                this.$router.push({ name: 'block-edit', params: { id: blockId } });
            }
        }
    }
</script>

<style scoped>

</style>