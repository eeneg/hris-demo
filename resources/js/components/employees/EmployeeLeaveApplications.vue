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
                                <th class="text-center" style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="application in applications.data" :key="application.id">
                                <td class="text-center">{{ application.leavetype.title }}</td>
                                <td class="text-center">{{ application.date_of_filing }}</td>
                                <td class="text-center">{{ application.stage_status }}</td>
                                <td class="text-center">{{ application.disapproved_due_to }}</td>
                                <td class="text-center">{{  }}</td>
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

export default{
    data()
    {
        return{
            id: '',
            applications: {},
        }
    },
    methods:{

        createApplication: function()
        {
            this.$router.push({path: '/leave-form', query: {id: this.id, mode: 2}})
        },

        getApplications: function()
        {
            axios.get('api/getLeaveApplications')
            .then(({data}) => {
                this.applications = data.data
                this.id = data.id
            })
            .catch(e => {
                console.log(e)
            })
        },

        paginate: function(page = 1)
        {
            axios.get('api/getLeaveApplications?page=' + page)
            .then(({data}) => {
                this.applications = data.data
            })
            .catch(e => {
                console.log(e)
            })
        }
    },
    mounted(){
        this.getApplications()
    }
}
</script>
