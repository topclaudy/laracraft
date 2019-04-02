<template>
    <div class="w-2/3">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span><strong>Block Editor</strong></span>
            </div>

            <el-form ref="form" :model="blockBuffer" label-width="120px" v-loading="processing">
                <el-form-item label="Title">
                    <el-input v-model="blockBuffer.name"></el-input>
                </el-form-item>

                <el-form-item label="Description">
                    <el-input type="textarea" v-model="blockBuffer.description"></el-input>
                </el-form-item>

                <el-form-item label="Type">
                    <el-select v-model="blockBuffer.type" placeholder="select type">
                        <el-option label="Component" value="component"></el-option>
                        <el-option label="WYSIWYG" value="wysiwyg"></el-option>
                        <el-option label="Markdown" value="markdown"></el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="Component" v-if="blockBuffer.type === 'component'">
                    <el-select v-model="blockBuffer.resource" placeholder="select component" no-data-text="No components found">
                        <el-option
                                v-for="component in components"
                                :key="component.class"
                                :label="component.name"
                                :value="component.class">
                        </el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="Custom content" v-if="blockBuffer.type === 'wysiwyg'">
                    <quill-editor v-model="blockBuffer.resource" class="bg-white"
                                  ref="quillEditor"
                                  :options="editorOption">
                    </quill-editor>
                </el-form-item>

                <el-form-item label="Markdown" v-if="blockBuffer.type === 'markdown'">
                    <el-tabs type="border-card" class="shadow-none">
                        <el-tab-pane label="Write">
                            <el-input type="textarea" v-model="blockBuffer.resource" :autosize="{ minRows: 2, maxRows: 6}" @change="updateMardownPreview"></el-input>
                        </el-tab-pane>
                        <el-tab-pane label="Preview">
                            <div v-html="compiledMarkdownContent"></div>
                        </el-tab-pane>
                    </el-tabs>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" @click="updateOrCreate" :disabled="!canSave">
                        <span v-if="!blockBuffer.id">Create</span>
                        <span v-else="">Update</span>
                    </el-button>
                    <el-button @click="cancel">Cancel</el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>

<script>
    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'
    import 'quill/dist/quill.bubble.css'

    import { quillEditor } from 'vue-quill-editor'

    import {mapState, mapActions} from 'vuex';
    import storeActions from '../../vuex/actions'
    import {debounce} from "lodash";
    import * as marked from "marked";

    export default {
        name: "screen-block-editor",

        components: {
            quillEditor
        },

        props: {
            id: null
        },

        data(){
            return {
                blockBuffer: {
                    id: null,
                    name: null,
                    description: null,
                    type: null,
                    resource: null
                },

                markdownContent: null,

                editorOption: {
                    theme: 'snow',
                    placeholder: "Custom content goes here..."
                },

                processing: false
            }
        },

        computed: {
            ...mapState({
                components: ({componentModule}) => componentModule.items
            }),

            canSave(){
                return this.blockBuffer.name && this.blockBuffer.type && this.blockBuffer.resource;
            },

            compiledMarkdownContent: function () {
                if(this.markdownContent) {
                    return marked(this.markdownContent, {sanitize: true})
                }

                return null;
            }
        },

        watch: {
            'blockBuffer.type': {
                handler(newValue, oldValue){
                    if(oldValue) {
                        this.blockBuffer.resource = null;
                    }
                }
            }
        },

        mounted(){
            if(this.id) {
                this.getBlock(this.id).then((response) => {
                    this.resetBuffer(response.data);
                }, (error) => {
                    console.error(error);
                });
            }
        },

        methods: {
            ...mapActions({
                getBlock: storeActions.block.GET,
                createBlock: storeActions.block.POST,
                updateBlock: storeActions.block.PUT
            }),

            updateMardownPreview: debounce(function () {
                this.markdownContent = this.blockBuffer.resource
            }, 300),

            resetBuffer(data){
                if(data){
                    this.blockBuffer = JSON.parse(JSON.stringify(data));
                } else {
                    this.blockBuffer = {
                        name: null,
                        description: null,
                        type: null,
                        resource: null
                    };
                }

                this.markdownContent = this.blockBuffer.resource
            },

            create(){
                this.processing = true;

                this.createBlock(this.blockBuffer).then(response => {
                    this.processing = false;
                    this.resetBuffer();
                    this.$router.go(-1);
                }).catch(error => {
                    this.processing = false;
                    console.log(error);
                });
            },

            update(){
                this.processing = true;

                this.updateBlock(this.blockBuffer).then(response => {
                    this.processing = false;
                    this.resetBuffer(response.data);
                    this.$router.go(-1);
                }).catch(error => {
                    this.processing = false;
                    console.log(error);
                });
            },

            updateOrCreate(){
                if(this.blockBuffer.id){
                    this.update();
                } else {
                    this.create();
                }
            },

            cancel(){
                this.$router.go(-1);
            }
        }
    }
</script>

<style scoped>

</style>