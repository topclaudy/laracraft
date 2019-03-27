<template>
    <div class="w-2/3">
        <el-form ref="form" :model="blockBuffer" label-width="120px">
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
                </el-select>
            </el-form-item>

            <el-form-item label="Component" v-if="blockBuffer.type === 'component'">
                <el-select v-model="blockBuffer.resource" placeholder="select component">
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

            <el-form-item>
                <el-button type="primary" @click="updateOrCreate">
                    <span v-if="!blockBuffer.id">Create</span>
                    <span v-else="">Update</span>
                </el-button>
                <el-button @click="cancel">Cancel</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'
    import 'quill/dist/quill.bubble.css'

    import { quillEditor } from 'vue-quill-editor'

    import {mapState, mapActions} from 'vuex';
    import storeActions from '../../vuex/actions'

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

                editorOption: {
                    theme: 'snow',
                    placeholder: "Custom content goes here..."
                }
            }
        },

        computed: {
            ...mapState({
                components: ({componentModule}) => componentModule.items
            })
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
            },

            create(){
                this.processing = true;

                this.createBlock(this.blockBuffer).then(response => {
                    //this.processing = false;
                    //this.show = false;
                    this.resetBuffer();
                    this.$router.go(-1);
                    //this.$emit('holding-created', response.data)
                }).catch(error => {
                    //this.processing = false;
                    console.log(error);
                });
            },

            update(){
                this.processing = true;

                this.updateBlock(this.blockBuffer).then(response => {
                    //this.processing = false;
                    //this.show = false;
                    this.resetBuffer(response.data);
                    this.$router.go(-1);
                    //this.$emit('holding-updated', response.data)
                }).catch(error => {
                    //this.processing = false;
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