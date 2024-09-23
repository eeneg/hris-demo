<template>
<div class="row justify-content-center">
        <div class="col-md-12 text-center" v-if="$gate.isEmployee() !== true">
            <not-authorized></not-authorized>
        </div>
        <div v-else class="col-md-12">
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2 inline-block">
                            <h3>Leave Applications</h3>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex justify-content-around align-items-center">
                                <div v-for="x in credits"><h3>{{ x.title + ': ' + x.balance}}</h3></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary float-right" @click="createApplication">Apply <i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0" style="height: 600px;">

                    <table class="table table-striped text-nowrap custom-table">
                        <thead>
                            <tr>
                                <th class="text-center">Type of leave</th>
                                <th class="text-center">Date of filing</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Remark</th>
                                <th class="text-center">State</th>
                                <th class="text-center" style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="application in applications.data" :key="application.id">
                                <td class="text-center">{{ application.title }}</td>
                                <td class="text-center">{{ application.date_of_filing }}</td>
                                <td class="text-center">{{ application.stage_status }}</td>
                                <td class="text-center">
                                    {{
                                        application.stage_status == 'Pending Noted By' ? application.recommendation_remark_approved :
                                        application.stage_status == 'Recommendation Disapproved' ? application.recommendation_remark_disapproved :
                                        application.stage_status == 'Disapproved by the Governor' ? application.disapproved_due_to :
                                        application.sick_balance == 0 && application.vacation_balance == 0 ? 'Leave Credits Uncalculated' : ''
                                    }}
                                </td>
                                <td class="text-center">
                                    {{ application.status == 'final' ? 'Final' : 'Draft' }}
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <button class="dropdown-item" @click="viewApplication(application)">View</button>
                                            <button class="dropdown-item" @click="editApplication(application.id, application.stage_status)">Edit</button>
                                            <button class="dropdown-item" @click="deleteApplication(application.id, application.stage_status)">Delete</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <pagination size="default" :data="applications" @pagination-change-page="paginate" :limit="5">
                        <span slot="prev-nav">&lt; Previous</span>
	                    <span slot="next-nav">Next &gt;</span>
                    </pagination>
                    <span style="margin-left: 10px;">Showing {{ applications.meta && applications.meta.from | validateCount }} to {{ applications.meta && applications.meta.to | validateCount }} of {{ applications.meta && applications.meta.total }} records</span>
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
                    <div class="modal-body">
                        <div class="row col-md-12" v-if="modal == true">
                            <div class="col-md-6">
                                <p>Name:
                                    <strong>
                                        {{ leave_details.surname }},
                                        {{ leave_details.firstname }}
                                        {{ leave_details.middlename }}
                                        {{ leave_details.nameextension }}
                                    </strong>
                                </p>
                                <p>Date of filing: <strong> {{ leave_details.date_of_filing }} </strong></p>
                                <p>Type of leave: <strong> {{ leave_details.title }} </strong></p>
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
                                        <td>{{ parseFloat(prev_balance_total).toFixed(2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Less this Leave</td>
                                        <td>{{ leave_details.vacation_less }}</td>
                                        <td>{{ leave_details.sick_less }}</td>
                                        <td>{{ parseFloat(less_total).toFixed(2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Leave Balance</td>
                                        <td>{{ curr_vacation_balance }}</td>
                                        <td>{{ curr_sick_balance }}</td>
                                        <td>{{ parseFloat(balance_total).toFixed(2) }}</td>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->
</div>
</template>

<script>
import axios from 'axios'
import Swal from 'sweetalert2'

export default{
    data()
    {
        return{
            applications: {},
            leave_details: {},
            credits: {},
            modal: false,
            curr_vacation_balance: '',
            curr_sick_balance: '',
            prev_balance_total: '',
            less_total: '',
            balance_total: '',
        }
    },
    methods:{

        calculate: function() {
            this.curr_vacation_balance = parseFloat(this.leave_details.vacation_balance) - parseFloat(this.leave_details.vacation_less);
            this.curr_sick_balance = parseFloat(this.leave_details.sick_balance) - parseFloat(this.leave_details.sick_less);

            this.prev_balance_total = parseFloat(this.leave_details.vacation_balance) + parseFloat(this.leave_details.sick_balance);
            this.less_total = parseFloat(this.leave_details.vacation_less) + parseFloat(this.leave_details.sick_less);

            this.balance_total = parseFloat(this.curr_vacation_balance) + parseFloat(this.curr_sick_balance);
        },

        viewApplication: function(leaveapplication){
            this.leave_details = leaveapplication
            this.calculate()
            this.modal = true
            $('#leave_application_modal').modal('show')
        },

        createApplication: function()
        {
            this.$router.push({path: '/employee-leave-form', query: {mode: 1}})
        },

        editApplication: function(data ,status)
        {
            if(status == 'Pending Recommendation')
            {
                this.$router.push({path: '/employee-leave-form', query: {mode: 2, applicationId: data}})
            }else{
                Swal.fire(
                    'Forbidden!',
                    'Cannot edit at this point',
                    'error'
                )
            }
        },

        getApplications: function()
        {
            axios.get('api/getLeaveApplications')
            .then(({data}) => {
                this.applications = data
            })
            .catch(e => {
                console.log(e)
            })
        },

        getLeaveCredits: function()
        {
            axios.get('api/getLeaveCredits')
            .then(({data}) => {
                this.credits = data
            })
            .catch(e => {
                console.log(e)
            })
        },

        paginate: function(page = 1)
        {
            axios.get('api/getLeaveApplications?page=' + page)
            .then(({data}) => {
                this.applications = data
            })
            .catch(e => {
                console.log(e)
            })
        },

        deleteApplication: function(id, status)
        {
            if(status == 'Pending Recommendation')
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
                        axios.delete('api/deleteLeaveApplication/' + id)
                        .then(response => {
                            toast.fire({
                                icon: 'success',
                                title: 'Deleted successfully'
                            });

                            this.getApplications()
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
            }else{
                Swal.fire(
                    'Forbidden!',
                    'Cannot delete at this point',
                    'error'
                )
            }
        }
    },
    mounted(){
        this.getApplications()
        this.getLeaveCredits()
    }
}
</script>
