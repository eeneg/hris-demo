<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Leave Applications</h2>
                    <small style="margin-left: 2px;">Subtitle Subtitle Subtitle Subtitle Subtitle Subtitle</small>

                    <div class="row mt-1">
                        <div class="form-group col-md-4 mb-0">
                            <v-select @input="filter_data()" class="form-control form-control-border border-width-2" v-model="personal_information_id" placeholder="Select Employee" :options="personalinformations" label="name" 
                            :reduce="personalinformations => personalinformations.id"></v-select>
                        </div>
                        <div class="form-group col-md-3 mb-0">
                            <v-select v-model="selectedleavetype" @input="filter_data()" placeholder="Select specific leave type" class="form-control form-control-border border-width-2" :options="leavetypes" label="title" :reduce="leavetypes => leavetypes.id"></v-select>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <div class="custom-control custom-radio d-inline">
                                    <input v-model="status" @change="filter_data()" class="custom-control-input" type="radio" value="final" id="customRadio1" name="status">
                                    <label for="customRadio1" class="custom-control-label">Final</label>
                                </div>
                                <div class="custom-control custom-radio d-inline ml-3">
                                    <input v-model="status" @change="filter_data()" class="custom-control-input" type="radio" value="draft" id="customRadio2" name="status">
                                    <label for="customRadio2" class="custom-control-label">Drafts</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="card-body table-responsive p-0" style="height: 600px;">
                    <table class="table table-striped text-nowrap custom-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type of leave</th>
                                <th>Inclusive dates</th>
                                <th>Date of filing</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="leaveapplication in leaveapplications" :key="leaveapplication.id">
                                <td>{{ leaveapplication.personalinformation.surname + ', ' + leaveapplication.personalinformation.firstname + ' ' + leaveapplication.personalinformation.nameextension + ' ' + leaveapplication.personalinformation.middlename }}</td>
                                <td>{{ leaveapplication.leavetype.title }}</td>
                                <td>{{ leaveapplication.from + ' to ' + leaveapplication.to }}</td>
                                <td>{{ leaveapplication.date_of_filing }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <router-link class="btn btn-primary float-right" to="/leave-form">New Application</router-link>
                    <!-- <pagination size="default" :data="employees" @pagination-change-page="getResults" :limit="5">
                        <span slot="prev-nav">&lt; Previous</span>
	                    <span slot="next-nav">Next &gt;</span>
                    </pagination>
                    <span style="margin-left: 10px;">Showing {{ employees.meta && employees.meta.from | validateCount }} to {{ employees.meta && employees.meta.to | validateCount }} of {{ employees.meta && employees.meta.total }} records</span> -->
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                search: '',
                status: 'final',
                selectedleavetype: '',
                leavetypes: [],
                leaveapplications: [],
                leaveapplicationsdata: [],
                personalinformations: [],
                personal_information_id: '',
                form: new Form({

                })
            }
        },
        methods: {
            searchit: _.debounce(function(){

            }, 400),
            filter_data() {
                let filtered = _.filter(this.leaveapplicationsdata, {'status': this.status});
                if (this.personal_information_id != null && this.personal_information_id != '') {
                    filtered = _.filter(filtered, {'personal_information_id': this.personal_information_id});
                }
                if (this.selectedleavetype != null && this.selectedleavetype != '') {
                    filtered = _.filter(filtered, {'leave_type_id': this.selectedleavetype});
                }
                this.leaveapplications = filtered;
            },
            loadContent() {
                axios.get('api/leaveapplication')
                    .then( ({ data }) => {
                        this.leaveapplicationsdata = data.data;
                        let filtered = _.filter(data.data, {'status': this.status});
                        this.leaveapplications = filtered;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
                axios.get('api/getleavetypes')
                    .then(({data}) => {
                        this.leavetypes = data;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
                axios.post('api/forleave')
                    .then(({data}) => {
                        this.personalinformations = data;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            }
        },
        created() {
            this.$Progress.start();
            this.loadContent();
            this.$Progress.finish();
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
