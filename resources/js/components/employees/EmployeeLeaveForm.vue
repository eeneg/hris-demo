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
                            <div class="col-md-12 mt-3">
                                <h3 class="text-primary">Employee Information</h3>
                            </div>
                            <div class="col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control form-control-border border-width-2" v-model="employee" readonly>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_of_filing">Date of filing</label>
                                    <input type="date" class="form-control form-control-border border-width-2" v-model="form.date_of_filing" :class="{ 'is-invalid': form.errors.has('date_of_filing') }">
                                    <has-error :form="form" field="date_of_filing"></has-error>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department">Department</label>
                                    <input type="text" class="form-control form-control-border border-width-2" v-model="form.department" :class="{ 'is-invalid': form.errors.has('department') }">
                                    <has-error :form="form" field="department"></has-error>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="position">Position</label>
                                    <input type="text" class="form-control form-control-border border-width-2" v-model="form.position" :class="{ 'is-invalid': form.errors.has('position') }">
                                    <has-error :form="form" field="position"></has-error>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="salary">Salary</label>
                                    <input type="text" class="form-control form-control-border border-width-2" v-model="form.salary" :class="{ 'is-invalid': form.errors.has('salary') }">
                                    <has-error :form="form" field="salary"></has-error>
                                </div>
                            </div>
                            <div class="col-md-12 mt-5">
                                <h5 class="text-primary">Details of Application</h5>
                            </div>
                            <div class="col-md-12">
                                <h5 class="text-success">Type of Leave to be availed of</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="leave_type_id">Leave Type</label>
                                    <v-select class="form-control form-control-border border-width-2" v-model="form.leave_type_id" :options="leave_types"
                                    :reduce="leave_types => leave_types.id" :class="{ 'is-invalid': form.errors.has('leave_type_id') }" label="title"></v-select>
                                    <has-error :form="form" field="leave_type_id"></has-error>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="leave_type_others">Others</label>
                                    <input type="text" class="form-control form-control-border border-width-2" v-model="form.leave_type_others" :class="{ 'is-invalid': form.errors.has('leave_type_others') }">
                                    <has-error :form="form" field="leave_type_others"></has-error>
                                </div>
                            </div>
                            <div class="col-md-12 mt-5">
                                <h5 class="text-success">Details of Leave</h5>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="spent">Spent</label>
                                <select class="form-control form-control-border border-width-2" v-model="form.spent" :class="{ 'is-invalid': form.errors.has('spent') }">
                                    <option class="bg-dark" value="" disabled>In case of Vacation/Special Previlage Leave:</option>
                                    <option value="within_the_philippines">Within the Philippines</option>
                                    <option value="abroad">Abroad</option>
                                    <option class="bg-dark" value="" disabled>In case of Sick Leave:</option>
                                    <option value="in_hospital">In Hospital</option>
                                    <option value="out_patient">Out Patient</option>
                                    <option class="bg-dark" value="" disabled>In case of Study Leave:</option>
                                    <option value="completion_of_masters_degree">Completion of Masters Degree</option>
                                    <option value="board_examination_review">BAR/Board Examination Review</option>
                                    <option class="bg-dark" value="" disabled>Other purpose:</option>
                                    <option value="monetiztion">Monetization of Leave Credits</option>
                                    <option value="terminal_leave">Terminal Leave</option>
                                </select>
                                <has-error :form="form" field="spent"></has-error>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="working_days">Working Days</label>
                                    <input type="text" v-model="form.working_days" class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('working_days') }">
                                    <has-error :form="form" field="working_days"></has-error>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3" v-if="form.spent == 'abroad' || form.spent == 'within_the_philippines' || form.spent == 'in_hospital' || form.spent == 'out_patient'">
                                <div class="form-group">
                                    <label for="spent_specified">Specify</label>
                                    <input type="text" class="form-control form-control-border border-width-2" v-model="form.spent_specified" :class="{ 'is-invalid': form.errors.has('spent_specified') }">
                                    <has-error :form="form" field="spent_specified"></has-error>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h5 class="text-success">Inclusive Dates</h5>
                                <div class="form-group">
                                    <input type="radio" name="consecutive_dates" :class="{ 'inclusive_dates': form.errors.has('inclusive_dates') }" v-model="consecutive_dates" id="consecutive_dates" :value="true">
                                    <label for=""><h5 class="text-bold">Consecutive Dates</h5></label>
                                    <input type="radio" class="ml-3" name="non_consecutive_dates" v-model="consecutive_dates" id="non_consecutive_dates" :value="false">
                                    <label for=""><h5 class="text-bold">Non-Consecutive Dates</h5></label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <v-date-picker v-model.lazy="range" is-range v-if="consecutive_dates">
                                    <template v-slot="{ inputValue, inputEvents }">
                                        <div class="flex justify-center items-center">
                                            <input
                                                :value="inputValue.start"
                                                v-on="inputEvents.start"
                                                class="border px-2 py-1 w-32 rounded focus:outline-none focus:border-indigo-300"
                                            />
                                            <input
                                                :value="inputValue.end"
                                                v-on="inputEvents.end"
                                                class="border px-2 py-1 w-32 rounded focus:outline-none focus:border-indigo-300"
                                            />
                                        </div>
                                    </template>
                                </v-date-picker>
                                <v-calendar :attributes="attributes" @dayclick="onDayClick" v-if="consecutive_dates == false" ref="calendar"/>
                            </div>
                            <div class="col-md-12">
                                <div class="mt-2">
                                    <span class="text-red" v-if="form.inclusive_dates.data == null"> Please input inclusive dates </span>
                                </div>
                            </div>
                            <div class="col-md-12 mt-5">
                                <h5 class="text-success">Commutation</h5>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control form-control-border border-width-2" v-model="form.commutation" :class="{ 'is-invalid': form.errors.has('commutation') }">
                                    <option value="requested">Requested</option>
                                    <option value="not_requested">Not Requested</option>
                                </select>
                                <has-error :form="form" field="commutation"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                        <button type="submit" class="btn btn-primary">Submit <i class="fas fa-save"></i></button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios'
import { Toast } from 'bootstrap';
import moment from 'moment';

    export default {
        data() {
            return {
                mode: null,
                status: '',
                personalinformations: [],
                leave_types: [],
                leave_application_id: '',
                consecutive_dates: false, //consecutive dates or non-consecutive dates
                days: [], // non-consecutive dates data
                range: {start: null, end: null}, //consecutive dates data
                form: new Form({
                    'id': null,
                    'personal_information_id':  null,
                    'leave_type_id':null,
                    'department':null,
                    'position':null,
                    'salary':null,
                    'working_days':null,
                    'date_of_filing':moment().format('YYYY-MM-DD'),
                    'working_days':null,
                    'spent':null,
                    'spent_specified':null,
                    'commutation':null,
                    'inclusive_dates':{mode: 3, data: null},
                    'final':true,
                    'application_stage': 'pending_leave_credit_calculation'
                }),
                options: {
                    format: 'yyyy-MM-DD',
                    useCurrent: false,
                },
                employee: null,
            }
        },
        computed: {
            mdates() {
                return this.days.map(day => day.date)
            },
            attributes() {
                return this.mdates.map(date => ({
                    highlight: true,
                    dates: date,
                }));
            },
            dateSort(){
                return this.days.sort((a, b) => a.date - b.date) //sort non-consecutive dates
            }
        },
        watch: {
            consecutive_dates: { //consecutive dates or non-consecutive dates data reset
                handler: function(){
                    if(this.consecutive_dates){
                        this.form.inclusive_dates = {mode: 2, data: null}
                    }else{
                        this.form.inclusive_dates = {mode: 3, data: null}
                    }
                }
            },
        },
        beforeRouteEnter(to, from, next)
        {
            next(vm => vm.getData(to.query.mode, to.query.applicationId))
        },

        methods:{

             //v-calendar on click dates
             onDayClick(day) {
                const idx = this.days.findIndex(d => d.id === day.id);
                if (idx >= 0) {
                    this.days.splice(idx, 1);
                } else {
                    this.days.push({
                        id: day.id,
                        date: day.date,
                    });
                }
            },


            getData: function(mode, id)
            {
                this.mode = mode
                this.$Progress.start();
                axios.get('api/employeepersonalinformation')
                .then(({data}) => {
                    this.form.personal_information_id = data.id
                    this.employee = data.fullName
                    this.form.department = data.department
                    this.form.position = data.position
                    this.form.salary = data.salary
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
                    if(data.inclusive_dates.mode == 2){
                        this.range = data.inclusive_dates.data
                        this.consecutive_dates = true
                    }else{
                        this.consecutive_dates = false
                        this.days = this.form.inclusive_dates.data
                    }
                })
                .catch(e => {
                    console.log(e)
                })
            },

            // leave type fetch
            getLeaveTypes: function(){
                axios.get('api/getLeaveTypes')
                .then(response => {
                    this.leave_types = response.data
                })
                .catch(e => {
                    console.log(e)
                })
            },

            submitApplication: function()
            {
                if(this.consecutive_dates == true){ //if consecutive dates set form inclusive_dates data to range
                    this.form.inclusive_dates.data = this.range
                }else{ //if non-consecutive dates set form inclusive_dates data to days
                    this.form.inclusive_dates.data = this.days
                }

                this.form.stage_status = 'pending_recommendation'

                console.log(this.form)

                // this.$Progress.start();

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

                if(this.consecutive_dates == true){ //if consecutive dates set form inclusive_dates data to range
                    this.form.inclusive_dates.data = this.range
                }else{ //if non-consecutive dates set form inclusive_dates data to days
                    this.form.inclusive_dates.data = this.days
                }

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
