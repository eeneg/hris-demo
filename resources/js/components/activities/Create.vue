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
                        <form @submit.prevent="create" role="form">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title</label>
                                    <input v-model="form.title" id="exampleInputEmail1" class="form-control" placeholder="Enter title">
                                    <has-error :form="form" field="title" />
                                </div>
                                <div class="form-group">
                                    <label for="exampleSelect">Type</label>
                                    <select v-model="form.type" id="exampleSelect" class="custom-select">
                                        <option selected disabled hidden :value="null">Activity Type</option>
                                        <option value="announcement">Announcement</option>
                                        <option value="event">Event</option>
                                    </select>
                                    <has-error :form="form" field="type" />
                                </div>
                                <div v-if="form.type == 'event'" class="form-group">
                                    <label for="exampleInputEmail2">Time</label>
                                    <input v-model="form.time" id="exampleInputEmail2" type="datetime-local" class="form-control" placeholder="Enter time">
                                    <has-error :form="form" field="time" />
                                </div>
                                <div v-if="form.type" class="form-group">
                                    <label>Info</label>
                                    <input v-if="form.type == 'event'" v-model="form.info" type="text" class="form-control" placeholder="Enter some info">
                                    <VueEditor v-else-if="form.type == 'announcement'" v-model="form.info"> </VueEditor>
                                    <has-error :form="form" field="info" />
                                </div>
                            </div>
                            <div class="box-footer">
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
                type: null,
                info: null,
                time: null,
            }),
        };
    },
    methods: {
        create() {
            this.form.post('api/activity')
                .then(response => {
                    toast.fire({
                        icon: 'success',
                        title: 'Settings updated successfully'
                    });
                    this.$parent.getSettings();
                    this.$Progress.finish();
                })
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
