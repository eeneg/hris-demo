<template>
<div class="row justify-content-center">
        <div class="col-md-12 text-center" v-if="$gate.isEmployee() !== true">
            <not-authorized></not-authorized>
        </div>
        <div v-else class="col-md-12">
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Leave Applications</h3>
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
                                <td class="text-center">{{ application.leavetype.title }}</td>
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
                                            <button class="dropdown-item" href="#">View</button>
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
        }
    },
    methods:{

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
    }
}
</script>
