<template>
    <div class="row justify-content-center">
        <div class="col-md-12 text-center" v-if="$gate.isEmployee()">
            <not-authorized></not-authorized>
        </div>
        <div v-else class="col-md-12">
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <div class="row mt-1">
                        <div class="col-md-6">
                            <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Leave Applications</h2>
                            <small style="margin-left: 2px;">Create a leave application / View list of applications</small>
                        </div>
                        <div class="form-group col-md-6 mt-2">
                            <router-link class="btn btn-primary float-right" to="/leave-form">Create <span><i class="fas fa-plus"></i></span></router-link>
                        </div>
                    </div>

                    <div class="row mt-1 col-md-12">
                        <div class="form-group col-md-6 mb-0">
                            <v-select class="form-control form-control-border border-width-2" v-model="search.personal_information_id" placeholder="Select Employee" :options="personalinformations" label="name"
                            :reduce="personalinformations => personalinformations.id"></v-select>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <v-select v-model="search.leave_type_id" placeholder="Select specific leave type" class="form-control form-control-border border-width-2" :options="leavetypes" label="title" :reduce="leavetypes => leavetypes.id"></v-select>
                        </div>
                    </div>

                    <div class="row mt-1 col-md-12">
                        <div class="form-group col-md-6 mb-0">
                            <v-select class="form-control form-control-border border-width-2" aria-label="Default select example" v-model="search.stage_status" :options="stage_status" placeholder="Filter Status">
                            </v-select>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <div class="form-group">
                                <date-picker id="reckoning_date" :config="options" v-model="search.date_of_filing" class="form-control form-control-border border-width-2" placeholder="Date: (yyyy-mm-dd)"></date-picker>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1 col-md-12">
                        <div class="form-group col-md-6 mb-0">
                            <button type="button" class="btn btn-danger btn-block" @click="clear()"><i class="fas fa-trash"></i> Clear</button>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <button type="button" class="btn btn-success btn-block" @click="filter_data()"><i class="fas fa-search"></i> Search</button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <div class="custom-control custom-radio d-inline">
                                    <input v-model="search.status" @change="filter_data()" class="custom-control-input" type="radio" value="final" id="customRadio1" name="status">
                                    <label for="customRadio1" class="custom-control-label">Final</label>
                                </div>
                                <div class="custom-control custom-radio d-inline ml-3">
                                    <input v-model="search.status" @change="filter_data()" class="custom-control-input" type="radio" value="draft" id="customRadio2" name="status">
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
                                <th>Date of filing</th>
                                <th>Status</th>
                                <th>Remark</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(leaveapplication, index) in leaveapplications.data" :key="leaveapplication.id">
                                <td>{{ leaveapplication.personalinformation.surname + ', ' + leaveapplication.personalinformation.firstname + ' ' + leaveapplication.personalinformation.nameextension + ' ' + leaveapplication.personalinformation.middlename }}</td>
                                <td>{{ leaveapplication.leavetype.title }}</td>
                                <td>{{ leaveapplication.date_of_filing }}</td>
                                <td>{{ leaveapplication.stage_status }}</td>
                                <td>
                                    {{
                                        leaveapplication.stage_status == 'Pending Noted By' ? leaveapplication.recommendation_remark_approved :
                                        leaveapplication.stage_status == 'Recommendation Disapproved' ? leaveapplication.recommendation_remark_disapproved :
                                        leaveapplication.stage_status == 'Disapproved by the Governor' ? leaveapplication.disapproved_due_to : ''
                                    }}
                                </td>
                                <td style="width: calc(100%-150px);">
                                    <button type="button" class="btn btn-sm btn-primary btn-info dropdown-toggle right" style="float: right; !important" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a type="button" @click.prevent="viewApplication(leaveapplication)" class="dropdown-item">
                                            View Application
                                        </a>
                                        <a v-if="user.role == 'Administrator' || user.role != 'Office Head'" type="button" @click.prevent="editLeaveApplication(leaveapplication)" class="dropdown-item">
                                            Edit
                                        </a>
                                        <a type="button" v-if="leaveapplication.status != 'draft' && (user.role == 'Administrator' || user.role == 'Office Head')" class="dropdown-item" @click.prevent="recommendation(leaveapplication)" aria-haspopup="true" aria-expanded="false" data-toggle="modal">
                                            Recommendation
                                        </a>
                                        <a type="button" v-if="leaveapplication.status != 'draft' && user.role == 'Administrator' || user.role == 'Office Head' && user.dept['title'] == 'PHRMO' && leaveapplication.status != 'draft'" class="dropdown-item"  @click.prevent="noted_by(leaveapplication)" aria-haspopup="true" aria-expanded="false" data-toggle="modal">
                                            Noted by
                                        </a>
                                         <a type="button" v-if=" leaveapplication.status != 'draft' && user.role == 'Administrator' || user.role == 'Office Head' && user.dept['title'] == 'PGO-Executive' && leaveapplication.status != 'draft'" class="dropdown-item" @click.prevent="governor(leaveapplication)" aria-haspopup="true" aria-expanded="false" data-toggle="modal">
                                            For Governor's Approval
                                        </a>
                                        <a class="dropdown-item" @click.prevent="deleteLeaveApplication(leaveapplication.id, index)" type="button" aria-haspopup="true" aria-expanded="false" data-toggle="modal">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <pagination size="default" :data="leaveapplications" @pagination-change-page="paginate" :limit="5">
                        <span slot="prev-nav">&lt; Previous</span>
	                    <span slot="next-nav">Next &gt;</span>
                    </pagination>
                    <span style="margin-left: 10px;">Showing {{ leaveapplications.meta && leaveapplications.meta.from | validateCount }} to {{ leaveapplications.meta && leaveapplications.meta.to | validateCount }} of {{ leaveapplications.meta && leaveapplications.meta.total }} records</span>
                </div>
            </div>
        </div>

        <!-- modal -->
        <div class="modal fade" id="leave_application_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content" style="overflow-y: auto;">
                <div class="modal-header kuz-header">
                    <h5 class="modal-title" id="modal-grade">Leave Application</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <form @submit.prevent="submit_mode == 'recommendation' ? review_recommendation(1) : submit_mode == 'noted_by' ? submit_noted_by(1) : submit_mode == 'gov' ? submit_governor(1) : ''" action="">
                        <div class="modal-body">
                            <div class="row" v-if="submit_mode == 'recommendation'">
                                <div class="form-group col-md-6" style="position: relative;margin-bottom: 0.3rem;">
                                    <label style="margin: 0;">Recommendation Officer</label>

                                    <v-select @input="filter_data()" class="form-control form-control-border border-width-2" v-model="form.recommendation_officer_id" placeholder="Select Employee" :options="personalinformations" item-text="label" label="name"
                                    :reduce="personalinformations => personalinformations.id"></v-select>

                                    <has-error :form="form" field="personal_information_id"></has-error>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="custom-control custom-radio">
                                        <input v-model="form.recommendation_status" value="APPROVED" class="custom-control-input" type="radio" id="recommendation_status_approved" name="recommendation_status">
                                        <label for="recommendation_status_approved" class="custom-control-label">Approved</label>
                                        <input v-model="form.recommendation_remark_approved" ref="recommendation_status_approved" class="form-control form-control-border border-width-2" type="text" name="recommendation_remark" placeholder="Remark" :disabled="form.recommendation_status != 'APPROVED'">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="custom-control custom-radio">
                                        <input v-model="form.recommendation_status" class="custom-control-input" value="DISAPPROVED" type="radio" id="recommendation_status_disapproved" name="recommendation_status">
                                        <label for="recommendation_status_disapproved" class="custom-control-label">Dissaproved due to</label>
                                        <input v-model="form.recommendation_remark_disapproved" ref="recommendation_status_disapproved" class="form-control form-control-border border-width-2" type="text" name="recommendation_remark" placeholder="Remark" :disabled="form.recommendation_status != 'DISAPPROVED'">
                                    </div>
                                </div>
                            </div>

                            <div class="row col-md-12" v-if="submit_mode == 'noted_by'">
                                <div class="col-md-4 form-group">
                                    <label for="days_with_pay">Days with pay:</label>
                                    <input v-model="form.days_with_pay" ref="days_with_pay" class="form-control form-control-border border-width-2" type="number" name="days_with_pay">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="days_without_pay">Days without pay:</label>
                                    <input v-model="form.days_without_pay" ref="days_without_pay" class="form-control form-control-border border-width-2" type="number" name="days_without_pay">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="others">others (specify):</label>
                                    <input v-model="form.others" ref="others" class="form-control form-control-border border-width-2" type="number" name="others">
                                </div>
                            </div>

                            <div class="row" v-if="submit_mode == 'gov'">
                                <div class="col-md-2 form-group custom-control custom-radio d-inline ml-3">
                                    <input v-model="gov_approval" class="custom-control-input" type="radio" value="1" id="gov_approval" name="gov_approval">
                                    <label for="gov_approval" class="custom-control-label">Approve</label>
                                </div>
                                <div class="col-md-2 form-group custom-control custom-radio d-inline ml-3">
                                    <input v-model="gov_approval" class="custom-control-input" type="radio" value="0" id="gov_dissaproval" name="gov_approval">
                                    <label for="gov_dissaproval" class="custom-control-label">Disapprove</label>
                                </div>
                            </div>

                            <div class="row" v-if="submit_mode == 'gov' && gov_approval == 0">
                                <div class="col-md-12 form-group">
                                    <label for="disapproved_due_to">Disapproved due to:</label>
                                    <input v-model="form.disapproved_due_to" ref="disapproved_due_to" class="form-control form-control-border border-width-2" type="text" name="disapproved_due_to">
                                </div>
                            </div>

                            <hr>

                            <div class="row col-md-12" v-if="modal == true">
                                <div class="col-md-6">
                                    <p>Name:
                                        <strong>
                                            {{ leave_details.personalinformation.surname }},
                                            {{ leave_details.personalinformation.firstname }}
                                            {{ leave_details.personalinformation.middlename }}
                                            {{ leave_details.personalinformation.nameextension }}
                                        </strong>
                                    </p>
                                    <p>Date of filing: <strong> {{ leave_details.date_of_filing }} </strong></p>
                                    <p>Type of leave: <strong> {{ leave_details.leavetype.title }} </strong></p>
                                    <p>Number of working days applied: <strong> {{ leave_details.working_days }} </strong></p>
                                    <p>
                                        Where leave will be spent: <strong> {{ leave_details.spent }} </strong><br>
                                        Remark: <strong> {{ leave_details.spent_spec }} </strong>
                                    </p>
                                    <p>Inclusive dates:
                                       <strong> {{ leave_details.from }} - {{ leave_details.to }} </strong>
                                    </p>
                                    <p>Commutation: <strong> {{ leave_details.commutation }} </strong></p>

                                     <p>Certification of Leave Credits as of: <strong> {{ leave_details.credit_as_of }} </strong></p>
                                </div>

                                <div class="col-md-6">

                                    <p>Details of action on Application</p>
                                    <table style="width:100%">
                                        <tr>
                                            <th></th>
                                            <th>Vacation</th>
                                            <th>Sick</th>
                                            <th>Total</th>
                                        </tr>
                                        <tr>
                                            <td>Previous Balance</td>
                                            <td>{{ leave_details.vacation_balance }}</td>
                                            <td>{{ leave_details.sick_balance }}</td>
                                            <td>{{ prev_balance_total }}</td>
                                        </tr>
                                        <tr>
                                            <td>Less this Leave</td>
                                            <td>{{ leave_details.vacation_less }}</td>
                                            <td>{{ leave_details.sick_less }}</td>
                                            <td>{{ less_total }}</td>
                                        </tr>
                                        <tr>
                                            <td>Leave Balance</td>
                                            <td>{{ curr_vacation_balance }}</td>
                                            <td>{{ curr_sick_balance }}</td>
                                            <td>{{ balance_total }}</td>
                                        </tr>
                                    </table>

                                    <br>

                                    <p>
                                        Reccomendation: <strong> {{ leave_details.recommendation_status }} </strong> <br>
                                        Remark: <strong> {{
                                                    leave_details.recommendation_status != 'APPROVED' ? leave_details.recommendation_remark_approved :
                                                    leave_details.recommendation_status != 'DISAPPROVED' ? leave_details.recommendation_remark_disapproved : ''
                                                }} </strong>

                                    </p>

                                    <p>
                                        Noted By: <strong> {{ leave_details.noted_by_id != null && leave_details.noted_by_id != '' ? 'APPROVED' : 'PENDING' }} </strong><br>
                                        Days with pay: <strong> {{ leave_details.days_with_pay }} </strong> <br>
                                        Days without pay: <strong> {{ leave_details.days_without_pay }} </strong> <br>
                                        Others: <strong> {{ leave_details.others }} </strong> <br>
                                    </p>

                                    <p>Governor Approval:
                                       <strong> {{
                                            leave_details.governor_id != null && leave_details.governor_id != '' &&
                                            leave_details.disapproved_due_to != null && leave_details.disapproved_due_to != '' ? 'DISAPPROVED' :
                                            leave_details.governor_id != null && leave_details.governor_id != '' &&
                                            leave_details.disapproved_due_to == null || leave_details.disapproved_due_to == '' ? 'APPROVED' : ''
                                        }} </strong>
                                        <br>
                                        Disapproved due to:
                                       <strong> {{ leave_details.disapproved_due_to != null && leave_details.disapproved_due_to != '' ? leave_details.disapproved_due_to : '' }} </strong>
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-if="submit_mode == 'recommendation' && form.stage_status != 'Pending Recommendation'" type="button" @click.prevent="review_recommendation(2)" class="btn btn-danger float-left">Undo Recommendation</button>
                            <button v-if="submit_mode == 'noted_by' && form.stage_status != 'Pending Noted By'" type="button" @click.prevent="submit_noted_by(2)" class="btn btn-danger float-left">Undo Noted By</button>
                            <button v-if="submit_mode == 'gov' && form.stage_status != 'Pending Governor Approval'" type="button" @click.prevent="submit_governor(2)" class="btn btn-danger float-left">Undo</button>
                            <button v-if="submit_mode == 'noted_by'" type="button" @click.prevent="submit_noted_by(3)" class="btn btn-success float-left">Approve</button>
                            <button v-if="submit_mode == 'gov'" type="submit" class="btn btn-primary">Save</button>
                            <button v-if="submit_mode != 'view' && submit_mode != 'gov'" type="submit" class="btn btn-primary">{{ submit_mode == 'noted_by' ? 'Governors Approval' : 'Save Changes' }}</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal -->

    </div>
</template>

<script>
import axios from 'axios';
    export default {
        data() {
            return {
                modal: false,
                submit_mode: '',
                search: '',
                selectedleavetype: '',
                leavetypes: [],
                leaveapplications: {},
                leaveapplicationsdata: {},
                personalinformations: [],
                personal_information_id: '',
                leave_application_id: '',
                leave_details: {},
                user: {id: '', role: '', dept:[]},
                selected_stage_status: '',
                gov_approval: null,
                stage_status: [
                    'Pending Recommendation',
                    'Recommendation Disapproved',
                    'Pending Noted By',
                    'Approved by the HR Head',
                    'Pending Governor Approval',
                    'Approved by the Governor',
                    'Disapproved by the Governor',
                ],
                form: new Form({
                    'personal_information_id': '',
                    'leave_type_id': '',
                    'from': '',
                    'to': '',
                    'governor_id': '',
                    'noted_by_id': '',
                    'recommendation_officer_id': '',
                    'recommendation_status': '',
                    'recommendation_remark_approved': '',
                    'recommendation_remark_disapproved': '',
                    'stage_status': '',
                    'days_with_pay': '',
                    'days_without_pay': '',
                    'others': '',
                    'disapproved_due_to': ''
                }),
                curr_vacation_balance: '',
                curr_sick_balance: '',
                prev_balance_total: '',
                less_total: '',
                balance_total: '',
                date: null,
                search:{
                    personal_information_id: null,
                    leave_type_id: null,
                    stage_status: null,
                    date_of_filing: null,
                    status: 'final',
                },
                options: {
                    format: 'yyyy-MM-DD',
                    useCurrent: false,
                }

            }
        },
        components: {
            datePicker
        },
        methods: {
            showDate(date) {
                this.date = date
            },
            paginate(page = 1){
                axios.get('api/leaveapplication?page=' + page)
                .then(({data}) => {
                    this.leaveapplications = data;
                }).catch(error => {
                    console.log(error.reponse.data.message);
                    Swal.fire(
                        'Oops...',
                        'Something went wrong',
                        'error'
                    )
                });
            },
            calculate() {
                this.curr_vacation_balance = parseFloat(this.leave_details.vacation_balance) - parseFloat(this.leave_details.vacation_less);
                this.curr_sick_balance = parseFloat(this.leave_details.sick_balance) - parseFloat(this.leave_details.sick_less);

                this.prev_balance_total = parseFloat(this.leave_details.vacation_balance) + parseFloat(this.leave_details.sick_balance);
                this.less_total = parseFloat(this.leave_details.vacation_less) + parseFloat(this.leave_details.sick_less);

                this.balance_total = parseFloat(this.curr_vacation_balance) + parseFloat(this.curr_sick_balance);
            },

            clear()
            {
                this.search = {
                    personal_information_id: null,
                    leave_type_id: null,
                    stage_status: null,
                    date_of_filing: null,
                    status: this.search.status
                }

                this.filter_data()

            },

            filter_data() {
                this.$Progress.start()
                axios.post('api/searchLeave', this.search)
                .then(({data}) => {
                    this.leaveapplications.data = data
                    this.$Progress.finish()
                    toast.fire({
                        icon: 'success',
                        title: 'Done'
                    })
                })
                .catch(e => {
                    console.log(e)
                    toast.fire({
                        icon: 'error',
                        title: 'Error'
                    })
                })
            },
            loadContent() {
                axios.get('api/leaveapplication')
                    .then( ({ data }) => {
                        this.leaveapplications = data;
                        this.leaveapplications.data = _.filter(data.data, {'status': this.search.status});
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
            },
            getAllLeave: function(){
                 axios.get('api/getAllLeave')
                    .then(({data}) => {
                        this.leaveapplicationsdata = data.data;
                        console.log(this.leaveapplicationsdata)
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            editLeaveApplication: function(leaveapplication)
            {
                if(leaveapplication.stage_status == 'Pending Recommendation')
                {
                    this.$router.push({path: '/leave-form', query: {id: leaveapplication.id, mode: 1}})
                }else{
                    Swal.fire(
                        'Oops...',
                        'Cannot Edit Application at this point...',
                        'error'
                    )
                }
            },
            deleteLeaveApplication: function(id, index)
            {
                 Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if(result.isDismissed == true)
                    {
                        toast.fire({
                            icon: 'success',
                            title: 'Cancelled'
                        });
                    }else{
                        this.$Progress.start()
                        axios.delete('api/leaveapplication/'+ id)
                        .then(response => {
                            toast.fire({
                                icon: 'success',
                                title: 'Deleted successfully'
                            });

                            this.loadContent()
                            this.$Progress.finish()
                        })
                        .catch(error => {
                            console.log(error)
                            Swal.fire(
                                'Oops...',
                                'Something went wrong',
                                'error'
                            )
                        })
                    }
                })

            },
            load_user: function()
            {
                axios.get('api/load_user')
                .then(({data}) => {
                    this.user.id = data['id']
                    this.user.role = data['role']
                    this.user.dept = data['dept']
                })
                .catch(error => {
                    console.log(error)
                })
            },
            viewApplication: function(leaveapplication){
                this.leave_details = leaveapplication
                this.calculate()
                this.submit_mode = 'view'
                this.modal = true
                $('#leave_application_modal').modal('show')
            },
            recommendation: function(leaveapplication)
            {
                this.form.reset()
                this.leave_details = leaveapplication
                this.form.fill(leaveapplication)
                this.leave_application_id = leaveapplication.id
                this.submit_mode = 'recommendation'
                this.calculate()

                if(this.form.stage_status == 'Pending Noted By' || this.form.stage_status == 'Recommendation Disapproved')
                {
                    Swal.fire({
                    title: 'Ooops...',
                    text: "Employee already has a recommendation!!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Proceed to edit'
                        }).then((result) => {
                        if(result.isDismissed == true)
                        {
                            toast.fire({
                                icon: 'success',
                                title: 'Cancelled'
                            });
                        }else{
                            this.modal = true
                            $('#leave_application_modal').modal('show')
                        }
                    })
                }else if(this.form.stage_status == 'Pending Recommendation'){
                    this.modal = true
                    $('#leave_application_modal').modal('show')
                }else{
                    Swal.fire(
                        'Oops...',
                        'Cannot edit recommendation at this point',
                        'error'
                    )
                }
            },
            review_recommendation: function(mode)
            {

                let save = false

                switch(mode){
                    case(1):
                    {

                        if(this.form.recommendation_officer_id != null && this.form.recommendation_status != null){
                            this.form.stage_status = this.form.recommendation_status == 'APPROVED' ? 'Pending Noted By' : this.form.recommendation_status == 'DISAPPROVED' ? 'Recommendation Disapproved' : ''
                            this.submit_reccomendation()
                            break;
                        }

                        Swal.fire(
                            'Oops...',
                            this.form.recommendation_officer_id == null ? 'Recommendation Officer Required' : 'Recommendation needs to be Approved or Disapproved',
                            'error'
                        )

                        break

                    }
                    case(2):
                    {

                        Swal.fire({
                            title: 'Ooops...',
                            text: "You cannot revert this!!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Proceed'
                        }).then((result) => {
                            if(result.isDismissed == true)
                            {
                                toast.fire({
                                    icon: 'success',
                                    title: 'Cancelled'
                                });
                            }else{

                                this.form.recommendation_officer_id = null,
                                this.form.recommendation_status = null,
                                this.form.recommendation_remark_approved = null,
                                this.form.recommendation_remark_disapproved = null,
                                this.form.stage_status = 'Pending Recommendation'

                                this.submit_reccomendation()

                            }
                        })

                        break

                    }
                }
            },
            submit_reccomendation: function()
            {
                this.$Progress.start()
                axios.patch('api/leaveapplication/'+this.leave_application_id, this.form)
                .then(response => {
                    this.$Progress.finish()
                    $('#leave_application_modal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'Submitted'
                    });
                    this.loadContent()
                })
                .catch(error => {
                    console.log(error.response.data.message);
                })
            },
            noted_by: function(leaveapplication)
            {

                this.form.reset()
                this.leave_details = leaveapplication
                this.form.fill(leaveapplication)
                this.leave_application_id = leaveapplication.id
                this.submit_mode = 'noted_by'
                this.calculate()

                if(leaveapplication.stage_status == 'Pending Noted By')
                {

                    this.modal = true
                    $('#leave_application_modal').modal('show')

                }else if(   leaveapplication.stage_status == 'Approved by the HR Head' ||
                            leaveapplication.stage_status == 'Pending Governor Approval' ){

                    Swal.fire({
                    title: 'Ooops...',
                    text: "Employee is already noted!!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Proceed to edit'
                        }).then((result) => {
                        if(result.isDismissed == true)
                        {
                            toast.fire({
                                icon: 'success',
                                title: 'Cancelled'
                            });
                        }else{

                            this.modal = true
                            $('#leave_application_modal').modal('show')

                        }
                    })

                }else if(this.form.stage_status == 'Approved by the Governor' || this.form.stage_status == 'Disapproved by the Governor'){
                    Swal.fire(
                        'Oops...',
                        'Cannot edit Noted By at this point',
                        'error'
                    )
                }else{
                    Swal.fire(
                        'Oops...',
                        leaveapplication.stage_status,
                        'error'
                    )
                }

            },
            submit_noted_by: function(mode)
            {

                if(mode == 1)
                {

                    this.$Progress.start()

                    this.form.noted_by_id = this.user.id
                    this.form.stage_status = 'Pending Governor Approval'

                    axios.patch('api/leaveapplication/'+this.leave_application_id, this.form)
                    .then(response => {
                        this.$Progress.finish()
                        toast.fire({
                            icon: 'success',
                            title: 'Submitted'
                        });
                        $('#leave_application_modal').modal('hide')
                        this.loadContent()

                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    })

                }else if(mode == 2){

                    if(this.form.stage_status == 'Disapproved by the Governor' || this.form.stage == 'Approved by the Governor')
                    {

                        Swal.fire(
                            'Oops...',
                            'Cannot undo Noted By at this stage',
                            'error'
                        )

                    }else if(this.form.noted_by_id == null){

                        Swal.fire(
                            'Oops...',
                            'Nothing to undo',
                            'error'
                        )

                    }else{
                        Swal.fire({
                        title: 'Ooops...',
                        text: "You cannot revert this!!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Proceed'
                            }).then((result) => {
                            if(result.isDismissed == true)
                            {
                                toast.fire({
                                    icon: 'success',
                                    title: 'Cancelled'
                                });
                            }else{

                                this.$Progress.start()

                                this.form.noted_by_id = null
                                this.form.days_with_pay = null
                                this.form.days_without_pay = null
                                this.form.others = null
                                this.form.stage_status = 'Pending Noted By'

                                axios.patch('api/leaveapplication/'+this.leave_application_id, this.form)
                                .then(response => {
                                    this.$Progress.finish()
                                    toast.fire({
                                        icon: 'success',
                                        title: 'Submitted'
                                    });
                                    $('#leave_application_modal').modal('hide')
                                    this.loadContent()
                                })
                                .catch(error => {
                                    console.log(error.response.data.message);
                                })

                            }
                        })
                    }


                }else if(mode == 3){

                    Swal.fire({
                    title: 'Are you sure?',
                    text: "This will skip the Governors approval and approve the application ending the transaction",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Proceed'
                        }).then((result) => {
                        if(result.isDismissed == true)
                        {
                            toast.fire({
                                icon: 'success',
                                title: 'Cancelled'
                            });
                        }else{

                            this.$Progress.start()

                            this.form.noted_by_id = this.user.id
                            this.form.stage_status = 'Approved by the HR Head'

                            axios.patch('api/leaveapplication/'+this.leave_application_id, this.form)
                            .then(response => {
                                this.$Progress.finish()
                                toast.fire({
                                    icon: 'success',
                                    title: 'Submitted'
                                });
                                $('#leave_application_modal').modal('hide')
                                this.loadContent()
                            })
                            .catch(error => {
                                console.log(error.response.data.message);
                            })

                        }
                    })

                }
            },
            governor: function(leaveapplication)
            {
                this.form.reset()
                this.leave_details = leaveapplication
                this.form.fill(leaveapplication)
                this.leave_application_id = leaveapplication.id
                this.submit_mode = 'gov'
                this.calculate()

                if(leaveapplication.stage_status == 'Disapproved by the Governor')
                {
                    this.gov_approval = 0
                }

                 if(leaveapplication.stage_status == 'Pending Governor Approval')
                {

                    this.modal = true
                    $('#leave_application_modal').modal('show')

                }else if(leaveapplication.stage_status == 'Approved by the Governor' || leaveapplication.stage_status == 'Disapproved by the Governor'){

                    Swal.fire({
                    title: 'Ooops...',
                    text: "Employee leave is already approved!!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Proceed to edit'
                        }).then((result) => {
                        if(result.isDismissed == true)
                        {
                            toast.fire({
                                icon: 'success',
                                title: 'Cancelled'
                            });
                        }else{

                            this.modal = true
                            $('#leave_application_modal').modal('show')

                        }
                    })

                }else{
                    Swal.fire(
                        'Oops...',
                        leaveapplication.stage_status,
                        'error'
                    )
                }
            },
            submit_governor: function(mode)
            {
                if(mode == 1)
                {

                    this.$Progress.start()

                    this.form.governor_id = this.user.id

                    if(this.gov_approval == 0)
                    {
                        this.form.stage_status = 'Disapproved by the Governor'
                    }else{
                        this.form.stage_status = 'Approved by the Governor'
                        this.form.disapproved_due_to = null
                    }

                    axios.patch('api/leaveapplication/'+this.leave_application_id, this.form)
                    .then(response => {
                        this.$Progress.finish()
                        toast.fire({
                            icon: 'success',
                            title: 'Submitted'
                        });
                        $('#leave_application_modal').modal('hide')
                        this.loadContent()

                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    })

                }else if(mode == 2 && this.form.governor_id != null){


                    Swal.fire({
                    title: 'Ooops...',
                    text: "You cannot revert this!!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Proceed'
                        }).then((result) => {
                        if(result.isDismissed == true)
                        {
                            toast.fire({
                                icon: 'success',
                                title: 'Cancelled'
                            });
                        }else{

                            this.$Progress.start()

                            this.form.governor_id = null
                            this.form.disapproved_due_to = null
                            this.form.stage_status = 'Pending Governor Approval'

                            axios.patch('api/leaveapplication/'+this.leave_application_id, this.form)
                            .then(response => {
                                this.$Progress.finish()
                                toast.fire({
                                    icon: 'success',
                                    title: 'Submitted'
                                });
                                $('#leave_application_modal').modal('hide')
                                this.loadContent()
                            })
                            .catch(error => {
                                console.log(error.response.data.message);
                            })

                        }
                    })
                }else if(mode == 2 && this.form.governor_id == null){
                    Swal.fire(
                        'Oops...',
                        'Nothing to undo',
                        'error'
                    )
                }
            }
        },
        created() {
            this.$Progress.start()
            this.load_user()
            this.loadContent()
            this.getAllLeave()
            this.$Progress.finish()
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
