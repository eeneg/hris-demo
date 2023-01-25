<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Leave Form <router-link to="/employee-leave-applications" style="float: right;"><i class="fas fa-arrow-left"></i></router-link></h2>
                    <small style="margin-left: 2px;">Leave Application Form</small>
                </div>

                <form @submit.prevent="mode == 1 ? submitApplication() : editApplication()">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6" style="position: relative;margin-bottom: 0.3rem;">
                            <label style="margin: 0;">Applicant</label>
                            <h3>{{ employee.name }}</h3>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date_of_filing" style="margin: 0;">Date of filing <span style="font-weight: normal;">(yyyy-mm-dd)</span></label>
                            <date-picker v-model="form.date_of_filing" id="date_of_filing" :config="options" class="form-control form-control-border border-width-2"></date-picker>
                        </div>
                    </div>
                    <h5 class="green mt-3">Details of Application</h5>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label style="margin: 0;">Type of leave</label>
                            <v-select class="form-control form-control-border border-width-2" v-model="form.leave_type_id" :options="leavetypes" label="title"
                            :reduce="leavetypes => leavetypes.id" :class="{ 'is-invalid': form.errors.has('leave_type_id') }"></v-select>
                            <has-error :form="form" field="leave_type_id"></has-error>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="working_days" style="margin: 0;">Number of working days applied</label>
                            <input v-model="form.working_days" id="working_days" class="form-control form-control-border border-width-2" type="text"
                            name="working_days" placeholder="Number of working days" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <div class="custom-control custom-radio">
                                <input v-model="form.spent" value="Within the Philippines" class="custom-control-input" type="radio" id="within_the_ph" name="spent">
                                <label for="within_the_ph" class="custom-control-label">Within the Philippines <br> <span class="font-weight-normal">(in case of vacation leave)</span></label>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="custom-control custom-radio">
                                <input v-model="form.spent" class="custom-control-input" value="Abroad" type="radio" id="abroad" name="spent">
                                <label for="abroad" class="custom-control-label">Abroad <br> <span class="font-weight-normal">(in case of vacation leave)</span></label>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="custom-control custom-radio">
                                <input v-model="form.spent" class="custom-control-input" value="In Hospital" type="radio" id="in_hospital" name="spent">
                                <label for="in_hospital" class="custom-control-label">In Hospital <br> <span class="font-weight-normal">(in case of sick leave)</span></label>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="custom-control custom-radio">
                                <input v-model="form.spent" class="custom-control-input" value="Out Patient" type="radio" id="out_patient" name="spent">
                                <label for="out_patient" class="custom-control-label">Out Patient <br> <span class="font-weight-normal">(in case of sick leave)</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <input v-model="form.spent_spec" id="spent_spec" class="form-control form-control-border border-width-2" type="text" name="spent_spec" placeholder="Specify" required>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-8" style="margin: 0;">Inclusive Dates</label>
                        <label class="col-md-4" style="margin: 0;">Commutation</label>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="from" style="margin: 0;"><span style="font-weight: normal;">From (yyyy-mm-dd)</span></label>
                            <date-picker v-model="form.from" id="from" :config="options" class="form-control form-control-border border-width-2"></date-picker>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="to" style="margin: 0;"><span style="font-weight: normal;">To (yyyy-mm-dd)</span></label>
                            <date-picker v-model="form.to" id="to" :config="options" class="form-control form-control-border border-width-2"></date-picker>
                        </div>
                        <div class="form-group col-md-4" style="margin-top: 5px;">
                            <div class="custom-control custom-radio d-inline">
                                <input v-model="form.commutation" value="Requested" class="custom-control-input" type="radio" id="requested" name="commutation" checked>
                                <label for="requested" class="custom-control-label"><span class="font-weight-normal">Requested</span></label>
                            </div>
                            <div class="custom-control custom-radio d-inline ml-3">
                                <input v-model="form.commutation" value="Not Requested" class="custom-control-input" type="radio" id="not_requested" name="commutation">
                                <label for="not_requested" class="custom-control-label"><span class="font-weight-normal">Not Requested</span></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <button type="submit" class="btn btn-primary" @click="form.status = 'final'">Finalize</button>
                    <button type="submit" class="btn btn-secondary" @click="form.status = 'draft'">Save as draft</button>
                </div>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios'
import { Toast } from 'bootstrap';

    export default {
        data() {
            return {
                mode: null,
                status: '',
                personalinformations: [],
                leavetypes: [],
                leave_application_id: '',
                form: new Form({
                    'personal_information_id': '',
                    'personal_information_id_7b': '',
                    'personal_information_id_7c': '',
                    'personal_information_id_7d': '',
                    'recommendation_officer_id': '',
                    'noted_by_id': '',
                    'governor_id': '',
                    'date_of_filing': moment(new Date()).format('YYYY-MM-DD'),
                    'leave_type_id': '',
                    'working_days': '',
                    'spent': 'Within the Philippines',
                    'spent_spec': '',
                    'from': moment(new Date()).format('YYYY-MM-DD'),
                    'to': moment(new Date()).format('YYYY-MM-DD'),
                    'credit_as_of': moment(new Date()).format('YYYY-MM-DD'),
                    'commutation': 'Requested',
                    'vacation_balance': 0.0,
                    'sick_balance': 0.0,
                    'vacation_less': 0.0,
                    'sick_less': 0.0,
                    'status': '',
                    'stage_status': '',
                    'recommendation_status': '',
                    'recommendation_remark_approved': '',
                    'recommendation_remark_disapproved': '',
                }),
                options: {
                    format: 'yyyy-MM-DD',
                    useCurrent: false,
                },
                employee: { id:'', name:'' },
            }
        },
        components: {
            datePicker
        },

        beforeRouteEnter(to, from, next)
        {

            next(vm => vm.getData(to.query.mode, to.query.applicationId))

        },

        methods:{
            getData: function(mode, id)
            {
                this.mode = mode
                this.$Progress.start();
                axios.get('api/employeepersonalinformation')
                .then(({data}) => {
                    this.employee.id = data.id
                    this.employee.name = data.firstname + ' ' + data.surname

                    this.$Progress.finish();
                })
                .catch(e => {
                    console.log(e)
                })

                console.log(mode, id)

                if(mode == 2)
                {
                    this.getApplication(id)
                }
            },

            getApplication: function(id)
            {
                this.leave_application_id = id
                axios.post('api/getLeaveApplication', {id: id})
                .then(({data}) => {
                    Object.assign(this.form, data)
                })
                .catch(e => {
                    console.log(e)
                })
            },

            getLeaveTypes: function()
            {
                axios.get('api/getLeaveTypesForEmployee')
                .then(({data}) => {
                    this.leavetypes = data
                })
                .catch(e => {
                    console.log(e)
                })
            },

            submitApplication: function()
            {
                this.form.personal_information_id = this.employee.id
                this.form.personal_information_id_7b = this.employee.id
                this.form.personal_information_id_7c = this.employee.id
                this.form.personal_information_id_7d = this.employee.id
                this.form.stage_status = 'Pending Recommendation'

                this.$Progress.start();

                axios.post('api/submitLeaveApplication', this.form)
                .then(e => {
                    toast.fire({
                        icon: 'success',
                        title:'Success'
                    })
                    this.$Progress.finish();
                })
                .catch(e => {
                    console.log(e)
                })
            },

            editApplication: function()
            {
                this.$Progress.start();

                axios.patch('api/editLeaveApplication/' + this.leave_application_id, this.form)
                .then(e => {
                    toast.fire({
                        icon: 'success',
                        title:'Success'
                    })
                    this.$Progress.finish();
                })
                .catch(e => {
                    console.log(e)
                })
            }
        },

        created(){
        },
        mounted() {
            this.getLeaveTypes()
            console.log('Component mounted.')
        }
    }
</script>
