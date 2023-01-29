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
                            <tr v-for="audit in audits?.data" :key="audit.id">
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
                    <span style="margin-left: 10px;">Showing {{ audits.from }} to {{ audits.to }} of {{ audits.total }} results | Page {{ audits.current_page }} of {{ audits.last_page }}</span>
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
                audits: null,
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

            moment: moment
        },
        created() {
            this.$Progress.start();

            this.loadAudits();

            this.$Progress.finish();
        },
    }
</script>
