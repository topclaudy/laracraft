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

            <el-table-column prop="themes_count" label="Theme Usages" align="right"></el-table-column>

            <el-table-column prop="regions_count" label="Regions Usages" align="right"></el-table-column>

            <el-table-column align="right">
                <template slot-scope="scope">
                    <el-button type="danger" plain icon="el-icon-delete" size="mini" @click="deleteBlockById(scope.row)"></el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';
    import storeActions from "../../vuex/actions";

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
            ...mapActions({
                deleteBlock: storeActions.block.DELETE
            }),

            showBlockEditor(blockId){
                this.$router.push({ name: 'block-edit', params: { id: blockId } });
            },

            deleteBlockById(block){
                this.deleteBlock(block).then((response) => {

                }, (error) => {
                    console.error(error);
                });
            }
        }
    }
</script>

<style scoped>

</style>