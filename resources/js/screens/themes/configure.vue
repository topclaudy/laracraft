<template>
    <div>
        <div class="flex">
            <div class="w-1/3 mx-6">
                <el-card class="box-card">
                    <div slot="header" class="clearfix">
                        <span><strong>Available Blocks</strong></span>
                    </div>

                    <span v-if="!blocks || blocks.length === 0" class="text-grey-darker p-2 block italic">0 blocks found</span>

                    <draggable :list="blocks" :group="{ name: 'blocks', pull: 'clone', put: false }" :sort="false" drag-class="bg-grey-lighter" class="" @change="log">
                        <div class="flex justify-between items-center block p-3 text-grey-dark cursor-move" v-for="(block, index) in blocks" :key="block.id" :class="{'bg-grey-lightest': (index % 2) === 0}">
                            <div>{{ block.name }}</div>
                            <div>
                                <div v-if="block.type === 'component'" class="text-sm text-grey-light">COMPONENT</div>
                                <div v-if="block.type === 'wysiwyg'" class="text-grey-light">
                                    <el-tooltip placement="right" effect="light">
                                        <div slot="content">
                                            <div v-html="block.resource"></div>
                                        </div>
                                        <span class="cursor-pointer"><i class="el-icon-view"></i></span>
                                    </el-tooltip>
                                </div>
                            </div>
                        </div>
                    </draggable>
                </el-card>
            </div>

            <div v-if="theme" class="w-2/3 mx-6">
                <el-card>
                    <div slot="header" class="clearfix">
                        <span>Regions in <strong>{{ theme.view }}</strong></span>
                    </div>

                    <span v-if="!theme.regions || theme.regions.length === 0" class="text-grey-darker p-2 block italic">No regions in this theme</span>

                    <div class="" v-for="(region, regionIndex) in theme.regions" :key="region.id">
                        <div class="block p-3 bg-orange-dark text-white text-lg">
                            {{ region.name }}
                        </div>

                        <span v-if="!region.blocks || region.blocks.length === 0" class="text-grey-darker p-2 block italic">No blocks in this region</span>

                        <draggable :list="region.blocks" :group="{name: `blocks-in-region-${regionIndex}`, put: 'blocks', pull: false}" class="p-4 border border-dashed" @change="log" @add="blockAdded" @update="blockUpdated">
                            <div class="flex justify-between items-center block p-3 text-grey-dark cursor-move" v-for="(block, blockIndex) in region.blocks" :class="{'bg-grey-lightest': (blockIndex % 2) === 0}">
                                <div class="float-left">{{ block.name }}</div>
                                <div class="float-right">
                                    <el-button type="danger" plain icon="el-icon-delete" size="mini" @click="removeBlock(region.id, block.id)"></el-button>
                                </div>
                            </div>
                        </draggable>
                    </div>
                </el-card>
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from "vuedraggable";
    import {mapActions, mapState} from "vuex";
    import storeActions from '../../vuex/actions'
    import {findIndex} from 'lodash';

    export default {
        name: "screen-theme-configure",

        components: {
            draggable
        },

        props: {
            id: null
        },

        data() {
            return {
                theme: null,
            };
        },

        computed: {
            ...mapState({
                blocks: ({blockModule}) => blockModule.items
            })
        },

        mounted(){
            this.getTheme(this.id).then((response) => {
                this.theme = JSON.parse(JSON.stringify(response.data));
            }, (error) => {
                console.error(error);
            });
        },

        methods: {
            ...mapActions({
                getTheme: storeActions.theme.GET,
                configureTheme: storeActions.theme.CONFIGURE
            }),

            blockAdded(event){
                this.updateThemeLayout();
            },

            blockUpdated(event){
                this.updateThemeLayout();
            },

            removeBlock(regionId, blockId){
                let region = this.theme.regions.find(region => region.id === regionId);

                if(region){
                    const blockIndex = findIndex(region.blocks, { id: blockId });

                    if(blockIndex !== -1){
                        region.blocks.splice(blockIndex, 1);
                        this.updateThemeLayout();
                    }
                }
            },

            updateThemeLayout(){
                let payload = {
                    id: this.theme.id,
                    regions: []
                };

                this.theme.regions.forEach(function(region){
                    let regionPayload = {
                        id: region.id,
                        blocks: []
                    };

                    region.blocks.forEach(function(block, index){
                        regionPayload.blocks.push({id: block.id, order: index, settings: {}});
                    });

                    payload.regions.push(regionPayload);
                });

                this.configureTheme(payload).then((response) => {

                }, (error) => {
                    console.error(error);
                });
            },

            log(event) {

            }
        }
    };
</script>

<style scoped></style>