<template>
    <div class="row">
        <div class="col-md-12 text-center" v-if="!$gate.isAdministrator()">
            <not-authorized></not-authorized>
        </div>

        <div v-else class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h2>User Activity Logs</h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input v-model="search" @keyup.prevent="searchit" type="text" class="form-control" placeholder="Search">
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table text-nowrap table-striped custom-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>Model</th>
                                <th>Data</th>
                                <th>IP Address</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="audit in audits?.data" :key="audit.id" style="cursor: pointer;" @click="showActivityLog(audit)">
                                <td>
                                    <img style="width: 35px; height: 35px;" class="img-circle mr-2" :src="getAvatar(audit.user.avatar)" alt="User Avatar">
                                    <span style="vertical-align: middle;">{{ audit.user.name }}</span>
                                </td>
                                <td>
                                    {{ audit.event.charAt(0).toUpperCase() + audit.event.substring(1) }}
                                </td>
                                <td>
                                    {{ audit.audited }}
                                </td>
                                <td>
                                    {{ audit.modified.substring(0,40) }}...
                                </td>
                                <td>
                                    {{ audit.ip_address }}
                                </td>
                                <td>
                                    {{ moment(audit.time).format('ddd, ll LTS') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right" style="display: inherit; align-audits: baseline;">
                    <pagination :data="audits" @pagination-change-page="getResults">
                        <span slot="prev-nav">&lt; Previous</span>
	                    <span slot="next-nav">Next &gt;</span>
                    </pagination>
                    <span style="margin-left:10px;display:flex;place-content:center;">Showing {{ audits?.meta?.from }} to {{ audits?.meta?.to }} of {{ audits?.meta?.total }} activity logs | Page {{ audits?.meta?.current_page }} of {{ audits?.meta?.last_page }}</span>
                </div>
            </div>
        </div>

        <div class="modal fade" id="showActivity" ref="showActivity" tabindex="-1" role="dialog" aria-labelledby="showAcitivityLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showAcitivityLabel">
                            {{ `${activity?.audited} ${activity?.event} by ${activity?.user?.name}` }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="clearfix mb-3">
                            {{ `${activity?.ip_address} ${moment(activity?.time)?.format('ddd, ll @LTS')}` }}
                        </div>
                        <div class="table-responsive">
                            <table class="table text-nowrap table-striped custom-table table-fixed">
                                <thead>
                                    <tr>
                                        <th>Field</th>
                                        <th>New</th>
                                        <th>Old</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(values, field) of activity ? JSON.parse(activity.modified) : []">
                                        <th class="pl-4 border-right">
                                            {{ field }}
                                        </th>
                                        <td>
                                            {{ values.new ?? 'null' }}
                                        </td>
                                        <td class="text-truncate">
                                            {{ values.old ?? 'null' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        data() {
            return {
                audits: {},
                activity: null,
                search: '',
            }
        },
        methods: {
            searchit: _.debounce(function(){
                this.getResults();
            }, 400),

            getResults(page = 1) {
                axios.get('api/audits?page=' + page + '&query=' + this.search)
                    .then(response => {
                        this.audits = response.data;
                    })
                    .catch(error => {
                        console.error(error.response.data.message);
                    });
            },

            getAvatar(avatar) {
                if (avatar != "profile.png") {
                    let prefix = (avatar.match(/\//) ? '' : '/storage/user_avatars/');
                    return prefix + avatar;
                } else {
                    let prefix = (avatar.match(/\//) ? '' : '/storage/project_files/');
                    return prefix + avatar;
                }
            },

            loadAudits() {
                axios.get('api/audits')
                    .then( ({ data }) => (this.audits = data) )
                    .catch(error => {
                        console.error(error.response.data.message);
                    });
            },

            showActivityLog(activity) {
                this.activity = activity

                $('#showActivity').modal('show')
            },

            moment: moment
        },
        created() {
            this.$Progress.start();

            this.loadAudits();

            this.$Progress.finish();
        },
    }
</script>
