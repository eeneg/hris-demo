<template>
    <div class="row">
        <div class="col-md-12 text-center" v-if="!$gate.isAdministrator()">
            <not-authorized></not-authorized>
        </div>

        <div v-else class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="#announcements" data-toggle="tab">Announcements</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#events" data-toggle="tab">Events</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="announcements">
                            <div v-for="announcement in announcements?.data" class="post">
                                <div class="user-block" style="margin-bottom:0;">
                                    <img class="img-circle" :src="getAvatar(announcement.user.avatar)" alt="user image">
                                    <span class="username">
                                        <a :href="'/activities-edit?id=' + announcement.id">{{ announcement.title }}</a>
                                    </span>
                                    <span class="description">Posted by {{ announcement.user.name }} {{ moment(announcement.created_at).fromNow() }}</span>
                                </div>
                                <div class="quillWrapper">
                                    <div class="ql-container ql-snow" style="border:none;">
                                        <div class="ql-editor ql-blank" v-html="announcement.info" style="min-height:fit-content;"> </div>
                                    </div>
                                </div>
                                <div class="timeline-footer clearfix">
                                    <button class="btn btn-danger btn-sm float-right ml-2" @click="deleteActivity(announcement.id)">Delete</button>
                                    <a :href="'/activities-edit?id=' + announcement.id" class="btn btn-primary btn-sm float-right">Edit</a>
                                </div>
                            </div>

                            <div class="text-right clearfix" style="display: inherit; align-audits: baseline;">
                                <div style="display:flex;place-content:center;">
                                    <pagination :data="announcements" @pagination-change-page="getAnnouncements">
                                        <span slot="prev-nav">&lt; Previous</span>
                                        <span slot="next-nav">Next &gt;</span>
                                    </pagination>
                                </div>
                                <span style="margin-left:10px;display:flex;place-content:center;">Showing {{ announcements?.from }} to {{ announcements?.to }} of {{ announcements?.total }} announcements | Page {{ announcements?.current_page }} of {{ announcements?.last_page }}</span>
                            </div>
                        </div>
                        <div class="tab-pane" id="events">
                            <div class="timeline">
                                <template v-for="(events, date) in activities">
                                    <div class="time-label">
                                        <span class="bg-purple">{{ moment(date).format('LL') }}</span>
                                    </div>
                                    <div v-for="event in events">
                                        <i class="fas fa-calendar-day bg-blue"></i>
                                        <div class="timeline-item">
                                            <span class="time">
                                                Added <i class="fas fa-clock"></i> {{ moment(event.created_at).format('lll') }}
                                            </span>
                                            <h3 class="timeline-header">
                                                <a>{{ event.title }}</a> by {{ event.user.name }}
                                            </h3>
                                            <div class="timeline-body">
                                                {{ event.info }}
                                            </div>
                                            <div class="timeline-footer clearfix">
                                                <button class="btn btn-danger btn-sm float-right ml-2" @click="deleteActivity(event.id)">Delete</button>
                                                <a :href="'/activities-edit?id=' + event.id" class="btn btn-primary btn-sm float-right">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div>
                                    <i class="far fa-clock bg-gray"></i>
                                </div>
                            </div>

                            <div class="text-right clearfix" style="display: inherit; align-audits: baseline;">
                                <div style="display:flex;place-content:center;">
                                    <pagination :data="events" @pagination-change-page="getEvents">
                                        <span slot="prev-nav">&lt; Previous</span>
                                        <span slot="next-nav">Next &gt;</span>
                                    </pagination>
                                </div>
                                <span style="margin-left:10px;display:flex;place-content:center;">Showing {{ events?.from }} to {{ events?.to }} of {{ events?.total }} events | Page {{ events?.current_page }} of {{ events?.last_page }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="js">
import moment from 'moment';
import { VueEditor } from "vue2-editor/dist/vue2-editor.core.js";
import { groupBy } from 'lodash';

export default {
    components: {
        VueEditor
    },

    data() {
        return {
            activities: null,
            announcements: {},
            events: {},
            form: new Form({
                title: null,
                type: null,
                info: null,
                time: null,
            }),
        };
    },
    methods: {
        deleteActivity(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$Progress.start();
                    this.form.delete('api/activity/' + id)
                        .then(({ data }) => {
                            Fire.$emit('reload');
                            Swal.fire(
                                'Deleted!',
                                data.message,
                                'success'
                            )
                            this.$Progress.finish();
                        })
                        .catch(() => {
                            Swal.fire(
                                'Failed!',
                                'An error occured while trying to delete the record.',
                                'warning'
                            )
                            this.$Progress.fail();
                        });
                }
            });
        },

        getAnnouncements(page = 1) {
            axios.get('api/activity?type=announcement&page=' + page)
                .then(response => response.data)
                .then(response => this.announcements = response);
        },

        getEvents(page = 1) {
            axios.get('api/activity?type=event&page=' + page)
                .then(response => response.data)
                .then(response => {
                    this.events = response;
                    this.activities = groupBy(this.events.data, e => moment(e.time).format('YYYY-MM-DD'));
                });
        },

        getAvatar(avatar) {
            if (avatar != "profile.png") {
                let prefix = (avatar.match(/\//) ? "" : "/storage/user_avatars/");
                return prefix + avatar;
            }
            else {
                let prefix = (avatar.match(/\//) ? "" : "/storage/project_files/");
                return prefix + avatar;
            }
        },

        init() {
            this.getAnnouncements();
            this.getEvents();
        },

        moment: moment
    },
    mounted() {

    },
    created() {
        this.$Progress.start();

        this.init();


        Fire.$on('reload', () => {
            this.init();
        });

        this.$Progress.finish();
    },
}
</script>
