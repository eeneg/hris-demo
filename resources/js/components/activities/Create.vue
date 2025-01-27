<template>
    <div class="row">
        <div class="col-md-12 text-center" v-if="!$gate.isAdministrator()">
            <not-authorized></not-authorized>
        </div>

        <div v-else class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h2>New Activity</h2>
                </div>

                <div class="card-body table-responsive p-0">

                    <div class="p-3">
                        <form enctype="multipart/form-data" @submit.prevent="create" action="">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title</label>
                                    <input v-model="form.title" id="exampleInputEmail1" class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('title')}" placeholder="Enter title">
                                    <has-error :form="form" field="title" />
                                </div>
                                <div class="form-group">
                                    <label for="exampleSelect">Type</label>
                                    <select v-model="form.type" id="exampleSelect" class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('type')}">
                                        <option selected disabled hidden :value="null">Activity Type</option>
                                        <option value="announcement">Announcement</option>
                                        <option value="event">Event</option>
                                    </select>
                                    <has-error :form="form" field="type" />
                                </div>
                                <div v-if="form.type == 'event'" class="form-group">
                                    <label for="exampleInputEmail2">Time</label>
                                    <input v-model="form.time" id="exampleInputEmail2" type="datetime-local" class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('time')}" placeholder="Enter time">
                                    <has-error :form="form" field="time" />
                                </div>
                                <div v-if="form.type" class="form-group">
                                    <label>Information</label>
                                    <input v-if="form.type == 'event'" v-model="form.info" type="text" class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('info')}" placeholder="Enter some info">
                                    <VueEditor v-else-if="form.type == 'announcement'" v-model="form.info"> </VueEditor>
                                    <span v-if="form.errors.has('info')" class="text-danger">The Information field is required</span>
                                    <has-error :form="form" field="info" />
                                </div>
                                <div class="form-group mb-0">
                                    <label for="file" class="">Attachments</label>
                                </div>
                                <div class="row pl-3 pr-3">
                                    <div class="col-md-12 pl-2 pr-2 pt-3 pb-3 border">
                                        <input id="file" name="file" @change="getFile($event)" type="file" class=""  accept="application/pdf" multiple>
                                        <has-error :form="form" field="file" />
                                        <div class="mt-2">
                                            <span v-if="Object.keys(form.errors.errors).some(key => key.startsWith('file.'))" class="text-danger">Invalid File</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
import { VueEditor } from "vue2-editor/dist/vue2-editor.core.js";

export default {
    components: {
        VueEditor
    },

    data() {
        return {
            activities: null,
            form: new Form({
                title: null,
                type: 'announcement',
                info: null,
                time: null,
                file: null,
            }),
        };
    },
    methods: {
        create() {
            const formData = new FormData();
            formData.append('title', this.form.title || '');
            formData.append('type', this.form.type);
            formData.append('info', this.form.info || '');
            if (this.form.type === 'event') {
                formData.append('time', this.form.time || '');
            }
            if (this.form.file) {
                Array.from(this.form.file).forEach((file, index) => {
                    formData.append(`file[${index}]`, file);
                });
            }

            axios.post('api/activity', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(() => {
                toast.fire({
                    icon: 'success',
                    title: 'Activity created successfully'
                });
                this.loadActivities();
                this.$Progress.finish();
            })
            .catch((e) => {
                this.form.errors.set(e.response.data.errors);
                toast.fire({
                    icon: 'error',
                    title: 'Failed to create activity'
                });
                this.$Progress.fail();
            });
        },

        getFile($event) {
            this.form.file = $event.target.files;
        },

        loadActivities() {
            axios.get("api/activity").then(r => this.activities = r.data);
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
