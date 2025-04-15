<template>
<div class="row justify-content-center">
        <div class="col-md-12 text-center" v-if="$gate.isEmployee() !== true">
            <not-authorized></not-authorized>
        </div>
        <div v-else class="col-md-12">
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 inline-block">
                            <h3>Leave Applications</h3>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary float-right" @click="createApplication">Apply <i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0" style="height: 600px;">

                    <div class="col-md-6 py-3">
                        <div class="col-md-12 p-0">
                            <div class="d-inline-block" style="width: 12rem;">
                                {{ 'Vacation Leave Balance:' }}
                            </div>
                            <div class="d-inline-block">
                                {{ credits['Vacation Leave'] ?? 0 }}
                            </div>
                        </div>
                        <div class="col-md-12 p-0">
                            <div class="d-inline-block" style="width: 12rem;">
                                {{ 'Sick Leave Balance:' }}
                            </div>
                            <div class="d-inline-block">
                                {{ credits['Sick Leave'] ?? 0 }}
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped text-nowrap custom-table">
                        <thead>
                            <tr>
                                <th class="text-center">Type of leave</th>
                                <th class="text-center">Date of filing</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Remark</th>
                                <th class="text-center" style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="application in applications.data" :key="application.id">
                                <td class="text-center">{{ application.title }}</td>
                                <td class="text-center">{{ application.date_of_filing }}</td>
                                <td class="text-center">
                                    <span v-if="application.application_stage == 'pending_leave_credit_calculation'" class="badge badge-warning">Leave Credit Calculation</span>
                                    <span v-if="application.application_stage == 'pending_recommendation'" class="badge badge-warning">Pending Recommendation</span>
                                    <span v-if="application.application_stage == 'disapproved_recommendation'" class="badge badge-danger">Recommendation Disapproved</span>
                                    <span v-if="application.application_stage == 'pending_noted_by'" class="badge badge-warning">Pending Noted By</span>
                                    <span v-if="application.application_stage == 'noted_by_disapproved'" class="badge badge-danger">Noted By Disapproved</span>
                                    <span v-if="application.application_stage == 'pending_governor_approval'" class="badge badge-warning">Pending Governor Approval</span>
                                    <span v-if="application.application_stage == 'governor_disapproved'" class="badge badge-danger">Dissaproved by the Governor</span>
                                    <span v-if="application.application_stage == 'approved'" class="badge badge-success">Approved</span>
                                    <span v-if="application.state == 'draft'" class="badge badge-secondary">Draft</span>
                                </td>
                                <td class="text-center" style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{
                                        application.application_stage == 'disapproved_recommendation' ? application.recommendation_disapproved_due_to :
                                        application.application_stage == 'noted_by_disapproved' ? application.noted_disapproved_due_to :
                                        application.application_stage == 'governor_disapproved' ? application.gov_disapproved_due_to : ''
                                    }}
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <button class="dropdown-item" @click="viewApplication(application)">View</button>
                                            <button class="dropdown-item" @click="editApplication(application.id, application.application_stage)">Edit</button>
                                            <button class="dropdown-item" @click="deleteApplication(application.id, application.application_stage)">Delete</button>
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

        <iframe id="i" frameborder="0" hidden></iframe>
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
        }
    },
    methods:{

        viewApplication: function(leaveapplication){
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

            axios.get('/api/getEmployeeLeaveApplications/'+leaveapplication.id)
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

        createApplication: function()
        {
            this.$router.push({path: '/employee-leave-form', query: {mode: 1}})
        },

        editApplication: function(data ,status)
        {
            if(status == 'pending_leave_credit_calculation')
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
            if(status != 'approved')
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
