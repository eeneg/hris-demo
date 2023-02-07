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
                        <form @submit.prevent="update" role="form">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title</label>
                                    <input v-model="form.title" id="exampleInputEmail1" class="form-control" placeholder="Enter title">
                                    <has-error :form="form" field="title" />
                                </div>
                                <div v-if="type == 'event'" class="form-group">
                                    <label for="exampleInputEmail2">Time</label>
                                    <input v-model="form.time" id="exampleInputEmail2" type="datetime-local" class="form-control" placeholder="Enter time">
                                    <has-error :form="form" field="time" />
                                </div>
                                <div v-if="type" class="form-group">
                                    <label>Info</label>
                                    <input v-if="type == 'event'" v-model="form.info" type="text" class="form-control" placeholder="Enter some info">
                                    <VueEditor v-else-if="type == 'announcement'" v-model="form.info" />
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
import axios from 'axios';
import moment from 'moment';
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
            form: new Form({
                title: null,
                type: null,
                info: null,
                time: null,
            }),
        };
    },

    beforeRouteEnter(to, from, next) {
        next(vm => vm.fetchdata(to.query.id))
    },

    methods: {
        update() {
            console.log(this.id)
            axios.put('api/activity/' + this.id, this.form)
                .then(response => {
                    toast.fire({
                        icon: 'success',
                        title: `${this.type} updated successfully`
                    });
                    this.$Progress.finish();
                })
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
                    this.form.title = data.activity.title
                    this.form.info = this.type == 'announcement' ? data.activity.info : null
                    this.form.time = this.type == 'event' ? data.activity.time : null
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
