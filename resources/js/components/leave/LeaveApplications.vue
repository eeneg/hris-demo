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
                            <small style="margin-left: 2px;">Manage and review employee leave applications.</small>
                        </div>
                        <div class="form-group col-md-6 mt-2">
                            <router-link class="btn btn-primary float-right" to="/leave-form">Create <span><i class="fas fa-plus"></i></span></router-link>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            </div>
                                            <!-- employee name search -->
                                            <input v-model="search.employee_name" @keyup.prevent="searchLeaveApplications" type="text" class="form-control" placeholder="Search Employee" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 p-0">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-filter"></i>
                                            </button>
                                            <div class="dropdown-menu py-4 px-3" @click.stop>
                                               <div class="row">
                                                    <div class="col-md-12">
                                                        <!-- leave status search selection start -->
                                                        <h5 class="text-primary">Leave Status</h5>
                                                        <div class="py-2" style="overflow: auto; max-height: 10rem; border: 1px solid #ccc; border-radius: 5px;">
                                                            <ul style="list-style-type:none;padding: 0;margin-left: 20px; width: 16rem;">
                                                                <li v-for="leave_stage in leave_stages" :key="leave_stage.data">
                                                                    <label class="filter_check_box" :for="leave_stage.data">
                                                                        <input type="checkbox" :name="leave_stage.data" :id="leave_stage.data" v-model="search.leave_stages" :value="leave_stage.data">
                                                                        {{leave_stage.label}}
                                                                    </label>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- leave status search selection end -->
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <!-- leave type search selection start -->
                                                        <div class="dropdown-divider"></div>
                                                        <h5 class="text-primary">Leave Type</h5>
                                                        <div class="py-2" style="overflow: auto; max-height: 10rem; border: 1px solid #ccc; border-radius: 5px;">
                                                            <ul style="list-style-type:none;padding: 0;margin-left: 20px; width: 16rem;">
                                                                <li v-for="leave_type in leave_types" :key="leave_type.id">
                                                                    <label class="filter_check_box" :for="leave_type.id">
                                                                        <input type="checkbox" :name="leave_type.id" :id="leave_type.id" v-model="search.leave_types" :value="leave_type.id">
                                                                        {{ leave_type.title }}
                                                                    </label>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- leave type search selection end -->
                                                    </div>
                                                    <div class="col-md-12">
                                                        <!-- leave type department selection end -->
                                                        <div class="dropdown-divider"></div>
                                                        <h5 class="text-primary">Department</h5>
                                                        <select class="input-group p-2" name="department" id="department" v-model="search.department">
                                                            <option :value="null" selected>--Select--</option>
                                                            <option :value="department.id" v-for="department in departments.data" :key="department.id">
                                                                {{ department.title }}
                                                            </option>
                                                        </select>
                                                        <!-- leave type department selection end -->
                                                    </div>
                                                    <div class="col-md-12 float-right">
                                                        <div class="dropdown-divider"></div>
                                                        <!-- apply filter button -->
                                                        <div class="float-right">
                                                            <button type="button" class="btn btn-danger" @click="resetFilter()">Reset</button>
                                                            <button type="button" class="btn btn-primary" @click="searchLeaveApplications()">Apply Filter</button>
                                                        </div>
                                                    </div>
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Leave Type</th>
                                                <th>Date of filing</th>
                                                <th>Status</th>
                                                <th>Remark</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="leave_application in leave_applications.data" :key="leave_application.id">
                                                <td>{{ leave_application.personalinformation.fullName }}</td>
                                                <td>{{ leave_application.leavetype.title }}</td>
                                                <td>{{ leave_application.date_of_filing }}</td>
                                                <td class="text-md">
                                                    <span v-if="leave_application.application_stage == 'pending_leave_credit_calculation'" class="badge badge-warning">Leave Credit Calculation</span>
                                                    <span v-if="leave_application.application_stage == 'pending_recommendation'" class="badge badge-warning">Pending Recommendation</span>
                                                    <span v-if="leave_application.application_stage == 'disapproved_recommendation'" class="badge badge-danger">Recommendation Disapproved</span>
                                                    <span v-if="leave_application.application_stage == 'pending_noted_by'" class="badge badge-warning">Pending Noted By</span>
                                                    <span v-if="leave_application.application_stage == 'noted_by_disapproved'" class="badge badge-danger">Noted By Disapproved</span>
                                                    <span v-if="leave_application.application_stage == 'pending_governor_approval'" class="badge badge-warning">Pending Governor Approval</span>
                                                    <span v-if="leave_application.application_stage == 'governor_disapproved'" class="badge badge-danger">Dissaproved by the Governor</span>
                                                    <span v-if="leave_application.application_stage == 'approved'" class="badge badge-success">Approved</span>
                                                    <span v-if="leave_application.state == 'draft'" class="badge badge-secondary">Draft</span>
                                                </td>
                                                <td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{
                                                        leave_application.application_stage == 'disapproved_recommendation' ? leave_application.recommendation_disapproved_due_to :
                                                        leave_application.application_stage == 'noted_by_disapproved' ? leave_application.noted_disapproved_due_to :
                                                        leave_application.application_stage == 'governor_disapproved' ? leave_application.gov_disapproved_due_to : ''
                                                    }}
                                                </td>
                                                <td>
                                                    <div class="dropdown show">
                                                        <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" role="button" @click="viewLeaveApplication(leave_application.id)">View</a>
                                                            <a class="dropdown-item" role="button" @click="editLeaveApplication(leave_application.id, leave_application.application_stage)">Edit</a>
                                                            <a
                                                                class="dropdown-item"
                                                                role="button"

                                                                @click="takeAction(leave_application.id, leave_application.personal_information_id, leave_application.application_stage, leave_application)"
                                                            >
                                                                Resolve
                                                            </a>
                                                            <a class="dropdown-item text-danger" role="button" @click="deleteLeaveApplication(leave_application.id)">Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <pagination size="default" :data="leave_applications" @pagination-change-page="searchLeaveApplications" :limit="5">
                                        <span slot="prev-nav">&lt; Previous</span>
                                        <span slot="next-nav">Next &gt;</span>
                                    </pagination>
                                    <span style="margin-left: 10px;">Page {{ leave_applications.meta && leave_applications.meta.current_page }} of {{ leave_applications.meta && leave_applications.meta.last_page }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="resolve_modal" ref="leaveModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Leave Application</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
                <form @submit.prevent="submitLeave()" action="" ref="leave_form">
                    <div class="modal-body p-0">
                        <div class="row">
                            <div class="col-md-12 px-5 py-2 ml-1">
                                <div class="row">
                                    <div class="col-md-12 p-0">
                                        <h5 class="text-success">Leave Application Information</h5>
                                    </div>
                                    <div class="col-md-6 p-0">
                                        <div class="col-md-12 p-0">
                                            Name: <strong> {{ current_leave_application.name }} </strong>
                                        </div>
                                        <div class="col-md-12 p-0 mt-2">
                                            Working Days: <strong> {{ current_leave_application.working_days }} </strong>
                                        </div>
                                        <div class="col-md-12 p-0 mt-2">
                                            Inclusive Dates: <strong> {{ current_leave_application.inclusive_dates }} </strong>
                                        </div>
                                        <div class="col-md-12 p-0 mt-2">
                                            Leave Type: <strong> {{ current_leave_application.leave_type.title }} </strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12 p-0 mt-2">
                                            Spent:
                                            <strong>
                                                {{
                                                    current_leave_application.spent == "within_the_philippines" ? "Within the Philippines" :
                                                    current_leave_application.spent == "abroad" ? "Abroad" :
                                                    current_leave_application.spent == "in_hospital" ? "In Hospital" :
                                                    current_leave_application.spent == "out_patient" ? "Out Patient" :
                                                    current_leave_application.spent == "completion_of_masters_degree" ? "Completion of Masters Degree" :
                                                    current_leave_application.spent == "board_examination_review" ? "Board Examination Review" :
                                                    current_leave_application.spent == "monetization" ? "Monetization" :
                                                    current_leave_application.spent == "terminal_leave" ? "Terminal Leave" : ""
                                                }}
                                            </strong>
                                        </div>
                                        <div class="col-md-12 p-0 mt-2">
                                            Specified: <strong> {{ current_leave_application.spent_specified }} </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <LeaveCreditCalculation
                                    v-if="isModalOpen && current_application_stage == 'pending_leave_credit_calculation'"
                                    :leave_application_id="leave_application_id"
                                    :personal_information_id="personal_information_id"
                                    :serverErrors="serverErrors"
                                    ref="leave_credit_calculation"
                                />
                                <LeaveRecommendation
                                    v-if="isModalOpen && current_application_stage == 'pending_recommendation'"
                                    :leave_application_id="leave_application_id"
                                    :personal_information_id="personal_information_id"
                                    :serverErrors="serverErrors"
                                    ref="recommendation"
                                />
                                <LeaveNotedBy
                                    v-if="isModalOpen && current_application_stage == 'pending_noted_by'"
                                    :leave_application_id="leave_application_id"
                                    :personal_information_id="personal_information_id"
                                    :serverErrors="serverErrors"
                                    ref="noted_by"
                                />
                                <LeaveGovernorApproval
                                    v-if="isModalOpen && current_application_stage == 'pending_governor_approval'"
                                    :leave_application_id="leave_application_id"
                                    :personal_information_id="personal_information_id"
                                    :serverErrors="serverErrors"
                                    ref="governor_approval"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex">
                        <div class="flex-grow-1" style="">
                            <a class="back-link" v-if="current_application_stage != 'pending_leave_credit_calculation'" @click="returnStep()" style="float: left !important; hover:text-decoration: underline; color: blue;cursor: pointer;">Return to Previous Step</a>
                        </div>
                        <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" :disabled="loading">Submit <i class="fas fa-save"></i></button>
                    </div>
                </form>
              </div>
          </div>
        </div>

        <!-- leave application format view -->
        <iframe id="i" frameborder="0" hidden></iframe>
    </div>
</template>

<style>
.back-link:hover {
    text-decoration: underline;
    color: blue;
    cursor: pointer;
}
.filter_check_box {
    display: block;
    cursor: pointer;
}
.filter_check_box:hover {
    cursor: pointer;
    text-shadow: 1px 1px 1px #bdbdbd
}
</style>

<script>
import LeaveCreditCalculation from './leaveApplicationPartials/LeaveCreditCalculation.vue';
import LeaveRecommendation from './leaveApplicationPartials/LeaveRecommendation.vue';
import LeaveNotedBy from './leaveApplicationPartials/LeaveNotedBy.vue';
import LeaveGovernorApproval from './leaveApplicationPartials/LeaveGovernorApproval.vue';
import axios from 'axios';
import _ from 'lodash';
import Swal from 'sweetalert2';
    export default {
        data() {
            return {
                leave_stages: [     //Leave stages selection data
                    {
                        data: 'pending_leave_credit_calculation',
                        label: 'Leave Credit Calculation'
                    },
                    {   data: 'pending_recommendation',
                        label: 'Pending Recommendation'
                    },
                    {   data: 'disapproved_recommendation',
                        label: 'Recommendation Disapproved'
                    },
                    {
                        data: 'pending_noted_by',
                        label: 'Pending Noted By'
                    },
                    {
                        data: 'pending_governor_approval',
                        label: 'Pending Governor Approval'
                    },
                    {
                        data: 'governor_disapproved',
                        label: 'Disapproved by the Governor'
                    },
                    {
                        data: 'approved',
                        label: 'Approved'
                    },
                ],
                current_leave_application: {
                    name: "",
                    working_days: "",
                    spent: "",
                    spent_specified: "",
                    inclusive_dates: {},
                    leave_type: {},
                },
                leave_types: [], //leave types data
                departments: [], //department data
                search:{    //search data
                    employee_name: null,
                    leave_stages: [],
                    leave_types: [],
                    department: null
                },
                leave_application_id: null, //leave application id
                personal_information_id: null, //personal information id
                current_application_stage: null, //used for conditional rendering of leave application form
                leave_applications: {}, //leave application list
                isModalOpen: false,
                serverErrors: {}, // server errors from child components
                loading: false, //loading state (disable submit button when true)
                is_hr: true, // check if office user is hr
                role: null // user role
            }
        },
        components: {
            datePicker,
            LeaveCreditCalculation,
            LeaveRecommendation,
            LeaveNotedBy,
            LeaveGovernorApproval
        },
        watch: {

        },
        methods: {

            // get user department for authorization
            getUserDepartment: function(){
                axios.get('/api/leaveUserDepartment')
                .then(response => {
                    this.is_hr = response.data.is_hr
                    this.role = response.data.role
                })
                .catch(error => {
                    console.log(error)
                })
            },

            // return application to previous step
            returnStep: function(){
                Swal.fire({
                    title: 'Return to Previous Step?',
                    html: "This will revert your application to an earlier stage, which may overwrite recent progress. <br><br><b>Are you sure you want to proceed?</b>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, proceed!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.patch('/api/leaveReturnPreviousStage/'+this.leave_application_id, {application_stage: this.current_application_stage})
                        .then(response => {
                            this.getLeaveApplications()
                            toast.fire({
                                icon: 'success',
                                title: 'Leave application has been returned to the previous stage!'
                            })
                            this.closeModal()
                        })
                        .catch(error => {
                            toast.fire({
                                icon: 'error',
                                title: 'Something went wrong!'
                            })
                            console.log(error)
                        })
                    }
                })
            },

            openModal() {
                $(this.$refs.leaveModal).modal('show');
            },
            closeModal() {
                $(this.$refs.leaveModal).modal('hide');
            },

            // edit leave application
            editLeaveApplication: function(id, stage){
                if(stage == "pending_leave_credit_calculation"){
                    this.$router.push({path: '/leave-form', query:{id: id}})
                }else{
                    Swal.fire({
                        title: 'You cannot edit this leave application',
                        text: 'This leave application is already in the approval stage',
                        icon: 'info',
                        confirmButtonText: 'Ok'
                    })
                }
            },

            // submit leave application recommendation/noted_by/governor_approval
            async submitLeave() {
                this.$Progress.start()
                this.loading = true
                let data = {};

                if (this.current_application_stage === 'pending_leave_credit_calculation' && this.$refs.leave_credit_calculation) {
                    data = await this.$refs.leave_credit_calculation.getFormData();
                }

                if (this.current_application_stage === 'pending_recommendation' && this.$refs.recommendation) {
                    data = await this.$refs.recommendation.getFormData();
                }

                if(this.current_application_stage === 'pending_noted_by' && this.$refs.noted_by){
                    data = await this.$refs.noted_by.getFormData();
                }

                if(this.current_application_stage == 'pending_governor_approval' && this.$refs.governor_approval){
                    data = await this.$refs.governor_approval.getFormData();
                }

                axios.patch('api/leaveapplication/'+this.leave_application_id, data)
                .then(e => {
                    this.$Progress.finish()
                    this.recommendation_approved = true
                    toast.fire({
                        icon: 'success',
                        title: 'Leave application recommendation submitted successfully'
                    })
                    this.loading = false
                    this.closeModal()
                    this.getLeaveApplications()
                })
                .catch(e => {
                    this.$Progress.fail()
                    this.serverErrors = e.response.data.errors
                    toast.fire({
                        icon: 'error',
                        title: 'Leave application recommendation submission failed'
                    })
                    this.loading = false
                })
            },

            // delete leave application
            deleteLeaveApplication: function(id){
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
                        axios.delete('/api/leaveapplication/'+id)
                        .then(response => {
                            this.getLeaveApplications()
                            toast.fire({
                                icon: 'success',
                                title: 'Leave application deleted successfully!'
                            })
                        })
                        .catch(error => {
                            toast.fire({
                                icon: 'error',
                                title: 'Something went wrong!'
                            })
                            console.log(error)
                        })
                    }
                })
            },

            //view Leave Application
            viewLeaveApplication: function(id){

                Swal.fire({
                    title: '<strong>Loading data...</strong>',
                    html: 'Dont <u>reload</u> or <u>close</u> the application ...',
                    icon: 'info',
                    willOpen () {
                        Swal.showLoading ()
                    },
                    didClose () {
                        Swal.hideLoading()
                    },
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        showConfirmButton: false
                })

                axios.get('/api/leaveapplication/'+id)
                .then(e => {
                    Swal.close()
                    var f = document.getElementById('i')
                    f.contentWindow.document.write(e.data)
                    setTimeout(function () {
                        f.contentWindow.focus()
                        f.contentWindow.print()

                        f.contentWindow.document.open();
                        f.contentWindow.document.write("");
                        f.contentWindow.document.close();
                    }, 500);
                })
                .catch(error => {
                    Swal.close()
                    toast.fire({
                        icon: 'error',
                        title: 'Something went wrong!'
                    })
                    console.log(error)
                })
            },

            // take action
            takeAction: function(leave_application_id, personal_information_id, application_stage, leave_application){
                this.leave_application_id = leave_application_id
                this.personal_information_id = personal_information_id
                this.current_application_stage = application_stage
                this.current_leave_application.name = leave_application.personalinformation.fullName
                this.current_leave_application.inclusive_dates = leave_application.inclusive_dates
                this.current_leave_application.leave_type = leave_application.leavetype
                this.current_leave_application.working_days = leave_application.working_days
                this.current_leave_application.spent = leave_application.spent
                this.current_leave_application.spent_specified = leave_application.spent_specified
                $('#resolve_modal').modal('show')
            },

            //search leave
            searchLeaveApplications: _.debounce(function (page = 1){
                this.$Progress.start()
                axios.post('/api/leaveApplicationSearch?page='+page, this.search)
                .then(response => {
                    this.leave_applications = response.data;
                    this.$Progress.finish()
                })
                .catch(error => {
                    this.$Progress.fail()
                    console.log(error);
                });
            }, 300),

            // reset filter
            resetFilter: function(){
                this.search = {
                    employee_name: null,
                    leave_stages: [],
                    leave_types: [],
                    department: null
                }
                this.getLeaveApplications()
            },

            //fetch data

            //fetch leave applications
            getLeaveApplications: function() {
                this.$Progress.start()
                axios.get('/api/leaveapplication')
                .then(response => {
                    this.$Progress.finish()
                    this.leave_applications = response.data;
                })
                .catch(error => {
                    this.$Progress.fail()
                    console.log(error);
                });
            },

            // fetch leave types
            getLeaveTypes: function(){
                axios.get('api/leaveFormLeaveTypes')
                .then(response => {
                    this.leave_types = response.data
                })
                .catch(e => {
                    console.log(e)
                })
            },

            // fetch departments
            getDepartments: function(){
                axios.get('api/department')
                .then(response => {
                    this.departments = response.data
                })
                .catch(e => {
                    console.log(e)
                })
            }
        },
        created() {
            this.getUserDepartment()
        },
        mounted() {
            // Attach Bootstrap modal event listeners
            $(this.$refs.leaveModal).on('shown.bs.modal', () => {
                this.isModalOpen = true;
            });

            $(this.$refs.leaveModal).on('hidden.bs.modal', () => {
                this.isModalOpen = false;
            });
            this.getLeaveApplications()
            this.getLeaveTypes()
            this.getDepartments()
            console.log('Component mounted.')
        }
    }
</script>
