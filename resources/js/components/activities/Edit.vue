<template>
    <div class="row">
        <div class="col-md-12 text-center" v-if="!$gate.isAdministrator()">
            <not-authorized></not-authorized>
        </div>

        <div v-else class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h2>Edit {{ type }}</h2>
                </div>

                <div class="card-body table-responsive p-0">

                    <div class="p-3">
                        <form @submit.prevent="update()" action="">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title</label>
                                    <input v-model="form.title" id="exampleInputEmail1" class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('title')}" placeholder="Enter title">
                                    <has-error :form="form" field="title"/>
                                </div>
                                <div v-if="type == 'event'" class="form-group">
                                    <label for="exampleInputEmail2">Time</label>
                                    <input v-model="form.time" id="exampleInputEmail2" type="datetime-local" class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('time')}" placeholder="Enter time">
                                    <has-error :form="form" field="time" />
                                </div>
                                <div v-if="type" class="form-group">
                                    <label>Info</label>
                                    <input v-if="type == 'event'" v-model="form.info" type="text" class="form-control form-control-border border-width-2" placeholder="Enter some info">
                                    <VueEditor v-else-if="type == 'announcement'" v-model="form.info" />
                                    <has-error :form="form" field="info" />
                                </div>
                                <div v-if="type" class="form-group">
                                    <label for="attachments">Add Attachments</label>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 pl-5 pr-2 pt-3 pb-3 border">
                                        <div class="">
                                            <input id="newFiles" name="newFiles" @change="getFile($event)" type="file" class="" accept="application/pdf" multiple>
                                            <br>
                                            <span class="text-danger">{{ errors.newFiles?.join(' ') }}</span>
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-success" @click="uploadNewFiles">Upload</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Attachments</label>
                                    </div>
                                    <div class="col-md-12">
                                        <ul>
                                            <li v-for="(e, i) in attachments">
                                                <a :href="e.file.path + e.file.id + '.pdf'" target="_blank" :class="{'text-danger ' : e.deleted}"> {{ e.file.file_name }} </a>
                                                <a role="button" class="text-danger button" v-if="e.deleted == false" @click="deleteFile(e.file.id, i)">(Delete)</a>
                                                <a role="button" class="button" v-if="e.deleted" @click="undoDelete(e.file.id, i)">(Undo)</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import _ from 'lodash';
import { VueEditor } from "vue2-editor/dist/vue2-editor.core.js";

export default {
    components: {
        VueEditor
    },

    data() {
        return {
            id: null,
            activities: null,
            type: null,
            attachments: [],
            errors: {},
            form: new Form({
                title: null,
                type: null,
                info: null,
                time: null,
                newFiles: [],
                deleteFiles: []
            }),
        };
    },

    beforeRouteEnter(to, from, next) {
        next(vm => vm.fetchdata(to.query.id))
    },

    methods: {
        update() {
                this.form.submit('patch', 'api/activity/' + this.id)
                    .then(() => {
                        toast.fire({
                            icon: 'success',
                            title: `${this.type} updated successfully`
                        });
                        this.fetchdata(this.id);
                        this.$Progress.finish();
                    })
                    .catch(e => {
                        console.log(e)
                        this.$Progress.fail();
                    })
        },

        uploadNewFiles(){
            const formData = new FormData();
            formData.append('id', this.id);
            formData.append('newFiles', []);
            if (this.form.newFiles) {
                Array.from(this.form.newFiles).forEach((file, index) => {
                    formData.append(`newFiles[${index}]`, file);  // Ensure matching keys
                });
            }

            axios.post('api/uploadNewFilesOnEdit', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(() => {
                toast.fire({
                    icon: 'success',
                    title: 'Files uploaded successfully'
                });
                this.fetchdata(this.id);
                this.errors = {};
                this.$Progress.finish();
            })
            .catch(e => {
                toast.fire({
                    icon: 'error',
                    title: 'Failed to upload files'
                });
                this.errors = e.response.data.errors;
                this.$Progress.finish();
            })
        },


        getFile($event) {
            this.form.newFiles = $event.target.files;
        },

        deleteFile(id, index){
            this.form.deleteFiles.push(id)
            this.attachments[index].deleted = true
        },

        undoDelete(id, index){
            this.form.deleteFiles = this.form.deleteFiles.filter(e => e != id)
            this.attachments[index].deleted = false
        },

        loadActivities() {
            axios.get("api/activity").then(r => this.activities = r.data);
        },

        fetchdata(id) {
            this.id = id

            axios.get('api/activity/' + id)
                .then(data => data.data)
                .then(data => {
                    this.type = data.activity.type
                    this.form.type = data.activity.type
                    this.form.title = data.activity.title
                    this.form.info = data.activity.info
                    this.form.time = this.type == 'event' ? data.activity.time : null
                    this.attachments = []
                    data.attachments.forEach(attachment => {
                        this.attachments.push({file: attachment, deleted: false})
                    })
                })
        },

        moment: moment
    },
    mounted() {

    },
    created() {
        this.$Progress.start();

        this.loadActivities();

        this.$Progress.finish();
    },
}
</script>
