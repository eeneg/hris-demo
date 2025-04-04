<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Leave Form <router-link to="/leave-applications" style="float: right;"><i class="fas fa-arrow-left"></i></router-link></h2>
                    <small style="margin-left: 2px;">Apply or Edit Leave Applications</small>
                </div>

                <div class="card-body">
                    <form action="">
                        <div class="col-md-12">
                            <div class="row">
                                <!-- <div class="col-md-12">
                                    <h3 class="text-primary">Application State</h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="final" id="final" :class="{ 'is-invalid': form.errors.has('final') }" v-model="form.final" :value="true" checked>
                                        <label class="form-check-label" for="final">
                                            Final
                                        </label>
                                        <has-error :form="form" field="final"></has-error>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="draft" id="draft" :class="{ 'is-invalid': form.errors.has('final') }" v-model="form.final" :value="false">
                                        <label class="form-check-label" for="draft">
                                            Draft
                                        </label>
                                        <has-error :form="form" field="final"></has-error>
                                    </div>
                                </div> -->
                                <div class="col-md-12 mt-3">
                                    <h3 class="text-primary">Employee Information</h3>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="personal_information_id">Employee</label>
                                        <v-select @input="getEmployeeDetails()" class="form-control form-control-border border-width-2" v-model="form.personal_information_id" :options="employees"
                                        :reduce="employees => employees.id" :class="{ 'is-invalid': form.errors.has('personal_information_id') }" label="fullName" :getOptionLabel="employees => employees.fullName"></v-select>
                                        <has-error :form="form" field="personal_information_id"></has-error>
                                    </div>
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
                                        <span v-if="fetching_dept_data" class="text-secondary">Loading...</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position">Position</label>
                                        <input type="text" class="form-control form-control-border border-width-2" v-model="form.position" :class="{ 'is-invalid': form.errors.has('position') }">
                                        <has-error :form="form" field="position"></has-error>
                                        <span v-if="fetching_dept_data" class="text-secondary">Loading...</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="salary">Salary</label>
                                        <input type="text" class="form-control form-control-border border-width-2" v-model="form.salary" :class="{ 'is-invalid': form.errors.has('salary') }">
                                        <has-error :form="form" field="salary"></has-error>
                                        <span v-if="fetching_salary_data" class="text-secondary">Loading...</span>
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
                                        <option value="monetization">Monetization of Leave Credits</option>
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
                                <div class="col-md-12 mt-5">
                                    <h5 class="text-success">Certification of Leave Credits</h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="credit_as_of">Credit as of</label>
                                        <input type="date" class="form-control form-control-border border-width-2" v-model="form.credit_as_of" :class="{ 'is-invalid': form.errors.has('credit_as_of') }">
                                        <has-error :form="form" field="credit_as_of"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <table style="margin: auto;">
                                            <tr>
                                                <th></th>
                                                <th>Vacation Leave</th>
                                                <th>Sick Leave</th>
                                            </tr>
                                        <tbody class="">
                                                <tr>
                                                    <td>
                                                        Total Earned
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-border border-width-2" v-model="form.vacation_balance" name="" id="" disabled>
                                                        <span
                                                            class="text-danger"
                                                            v-if="form.vacation_balance == null || form.vacation_balance == 0"
                                                        >
                                                            No Vacation Leave Credits
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-border border-width-2" v-model="form.sick_balance" name="" id="" disabled>
                                                        <span
                                                            class="text-danger"
                                                            v-if="form.sick_balance == null || form.sick_balance == 0"
                                                        >
                                                            No Sick Leave Credits
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Less this application
                                                    </td>
                                                    <td>
                                                        <!-- disable if sick_balance is null or zero -->
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-border border-width-2"
                                                            :class="{
                                                                'is-invalid': form.errors.has('vacation_less')
                                                            }"
                                                            v-model="form.vacation_less"
                                                            :disabled="form.vacation_balance == null || form.vacation_balance == 0"
                                                            name=""
                                                            id=""
                                                        >
                                                        <has-error :form="form" field="vacation_less"></has-error>
                                                    </td>
                                                    <td>
                                                        <!-- disable if sick_balance is null or zero -->
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-border border-width-2"
                                                            :class="{
                                                                'is-invalid': form.errors.has('sick_less')
                                                            }"
                                                            v-model="form.sick_less"
                                                            :disabled="form.sick_balance == null || form.sick_balance == 0"
                                                            name=""
                                                            id=""
                                                        >
                                                        <has-error :form="form" field="sick_less"></has-error>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Balance
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-border border-width-2" :value="Number(form.vacation_balance - form.vacation_less).toFixed(2)" name="" id="" disabled></td>
                                                    <td><input type="text" class="form-control form-control-border border-width-2" :value="Number(form.sick_balance - form.sick_less).toFixed(2)" name="" id="" disabled></td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="credit_officer_name">Authorized Officer</label>
                                        <v-select
                                            class="form-control form-control-border border-width-2"
                                            v-model="credit_officer"
                                            :options="employees"
                                            :reduce="employees => employees"
                                            :class="{ 'is-invalid': form.errors.has('credit_officer.name') }"
                                            label="fullName"
                                            :getOptionLabel="employees => employees.fullName"
                                        >
                                        </v-select>
                                        <has-error :form="form" field="credit_officer.name"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="credit_officer_position">Position</label>
                                        <input type="text" class="form-control form-control-border border-width-2" v-model="form.credit_officer.position" :class="{ 'is-invalid': form.errors.has('credit_officer.position') }">
                                        <has-error :form="form" field="credit_officer.position"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-5">
                                    <h5 class="text-success">Recommendation</h5>
                                </div>
                                <div class="col-md-6">
                                    <label for="">For Approval/Disapproval</label>
                                    <select class="form-control form-control-border border-width-2" v-model="form.recommendation_approved" :class="{ 'is-invalid': form.errors.has('recommendation_approved') }">
                                        <option :value="null">None</option>
                                        <option value="1">Approved</option>
                                        <option value="0">Disapproved due to</option>
                                    </select>
                                    <has-error :form="form" field="recommendation_approved"></has-error>
                                </div>
                                <div class="col-md-6" v-if="form.recommendation_approved == false && form.final == true">
                                    <div class="form-group">
                                        <label for="recommendation_disapproved_due_to">Remark</label>
                                        <input type="text" class="form-control form-control-border border-width-2" v-model="form.recommendation_disapproved_due_to" :class="{ 'is-invalid': form.errors.has('recommendation_disapproved_due_to') }">
                                        <has-error :form="form" field="recommendation_disapproved_due_to"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="recommendation_officer">Recommendation Officer</label>
                                        <v-select class="form-control form-control-border border-width-2" v-model="recommendation_officer" :options="employees"
                                        :reduce="employees => employees" :class="{ 'is-invalid': form.errors.has('recommendation_officer.name') }" label="fullName" :getOptionLabel="employees => employees.fullName"></v-select>
                                        <has-error :form="form" field="recommendation_officer.name"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="recommendation_officer_position">Position</label>
                                        <input type="text" class="form-control form-control-border border-width-2" v-model="form.recommendation_officer.position" :class="{ 'is-invalid': form.errors.has('recommendation_officer.position') }">
                                        <has-error :form="form" field="recommendation_officer.position"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-5">
                                    <h5 class="text-success">Approved For</h5>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="days_with_pay">Days with Pay</label>
                                                <input type="text" class="form-control form-control-border border-width-2" v-model="form.days_with_pay" :class="{ 'is-invalid': form.errors.has('days_with_pay') }" name="days_with_pay" id="days_with_pay">
                                                <has-error :form="form" field="days_with_pay"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="days_without_pay">Days without Pay</label>
                                                <input type="text" class="form-control form-control-border border-width-2" v-model="form.days_without_pay" :class="{ 'is-invalid': form.errors.has('days_without_pay') }" name="days_without_pay" id="days_without_pay">
                                                <has-error :form="form" field="days_without_pay"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="approved_for_others">Others(Specify)</label>
                                                <input type="text" class="form-control form-control-border border-width-2" v-model="form.approved_for_others" :class="{ 'is-invalid': form.errors.has('approved_for_others') }" name="approved_for_others" id="approved_for_others">
                                                <has-error :form="form" field="approved_for_others"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <button type="button" class="btn btn-primary w-100" @click="editMode ? updateForm() : submitForm()" :disabled="loading">Submit <i class="fas fa-save"></i></button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

    export default {
        data() {
            return {
                editMode: false,
                employees: [],
                leave_types: [],
                consecutive_dates: false, //consecutive dates or non-consecutive dates
                days: [], // non-consecutive dates data
                range: {start: null, end: null}, //consecutive dates data
                credit_officer: {}, //credit officer data v-select
                recommendation_officer: {}, //recommendation officer data v-select
                loading:false,
                fetching_dept_data: false,
                fetching_salary_data: false,
                form: new Form({
                    'id': null,
                    'personal_information_id':  null,
                    'leave_type_id':null,
                    'department':null,
                    'position':null,
                    'salary':null,
                    'working_days':null,
                    'date_of_filing': moment().format('YYYY-MM-DD'),
                    'working_days':null,
                    'spent':null,
                    'spent_specified':null,
                    'commutation':null,
                    'inclusive_dates':{mode: 3, data: null},
                    'credit_as_of':null,
                    'vacation_balance':null,
                    'vacation_less':null,
                    'sick_balance':null,
                    'sick_less':null,
                    'credit_officer':{personal_information_id: null, name: null, position: null, date: null},
                    'recommendation_officer':{personal_information_id: null, name: null, position: null, date: null},
                    'recommendation_approved':null,
                    'recommendation_disapproved_due_to':null,
                    'leave_type_others':null,
                    'final':true,
                    'days_with_pay':null,
                    'days_without_pay':null,
                    'approved_for_others':null,
                    'application_stage':null,
               }),
            }
        },
        beforeRouteEnter(to, from, next) {
            if(to.query.id != null){
                next( async (vm) => {
                    try {
                        await vm.getEmployees()
                        await vm.getLeaveTypes()
                        vm.setModeEdit()
                        vm.getLeaveApplication(to.query.id)
                    }catch(e){
                        console.log(e)
                    }
                });
            }else{
                next(vm => {
                    vm.getEmployees()
                    vm.getLeaveTypes()
                });
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
            credit_officer: { //credit officer data fetch and transform
                handler: function(){
                    if(this.credit_officer){
                        this.form.credit_officer.name = this.credit_officer.fullName
                        this.form.credit_officer.personal_information_id = this.credit_officer.id
                        this.getOfficerDetails(2, this.credit_officer.id)
                    }else{
                        this.form.credit_officer = {personal_information_id: null, name: null, position: null, date: null}
                    }
                }
            },
            recommendation_officer: { //recommendation officer data fetch and transform
                handler: function(){
                    if(this.recommendation_officer){
                        this.form.recommendation_officer.name = this.recommendation_officer.fullName
                        this.form.recommendation_officer.personal_information_id = this.recommendation_officer.id
                        this.getOfficerDetails(1, this.recommendation_officer.id)
                    }else{
                        this.form.recommendation_officer = {personal_information_id: null, name: null, position: null, date: null}
                    }
                }
            },
        },
        methods: {

            getOfficerDetails: function(mode, id){ // fetch officer details and set to form data recommendation_officer or credit_officer
                // mode 1 is for recommendation officer details fetch
                // mode 2 is for credit officer fetch
                axios.get('api/leaveFormDepartmentAndPositions/'+id)
                .then(response => {
                    if(mode == 1){
                        this.form.recommendation_officer.position = response.data.position
                        this.form.recommendation_officer.date = moment().format('YYYY-MM-DD')
                    }else if(mode == 2){
                        this.form.credit_officer.position = response.data.position
                        this.form.credit_officer.date = moment().format('YYYY-MM-DD')
                    }
                })
                .catch(e => {
                    console.log(e)
                })
            },

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


            //data post
            submitForm: function(){

                if(this.consecutive_dates == true){ //if consecutive dates set form inclusive_dates data to range
                    this.form.inclusive_dates.data = this.range
                }else{ //if non-consecutive dates set form inclusive_dates data to days
                    this.form.inclusive_dates.data = this.days
                }

                if(this.form.recommendation_approved == true){ //if recommendation_approved is null set application_stage to 'pending_noted_by'
                    this.form.application_stage = 'pending_noted_by'
                }else{
                    this.form.application_stage = 'pending_recommendation' //else set application_stage to 'pending_recommendation'
                }

                this.loading = true
                this.$Progress.start()
                // console.log(this.form.inclusive_dates)
                this.form.post('api/leaveapplication', this.form)
                .then(response => {
                    this.$Progress.finish()
                    toast.fire({
                        icon: 'success',
                        title: 'Leave Application Submitted'
                    })
                    this.loading = false
                    this.$router.push('/leave-applications')
                })
                .catch(e => {
                    this.$Progress.fail()
                    toast.fire({
                        icon: 'error',
                        title: 'Error Submitting Leave Application'
                    })
                    console.log(e)
                    this.loading = false
                })
            },

            //data fetch

            // employee fetch
            getEmployees: function(){
                axios.get('api/leaveFormEmployees')
                .then(response => {
                    this.employees = response.data
                })
                .catch(e => {
                    console.log(e)
                })
            },

            getEmployeeDetails() {
                Promise.all([
                    this.getEmployeeDepartment(),
                    this.getEmployeeSalary(),
                    this.getEmployeeLeaveCredits(),
                ])
                .catch(error => {
                    console.error("Error fetching employee details:", error);
                    this.fetching_data = false
                });
            },

            getEmployeeSalary() {
                this.fetching_salary_data = true;
                return axios.get(`api/leaveFormEmployeeSalary/${this.form.personal_information_id}`)
                    .then(response => {
                        this.form.salary = response.data.salary;
                        this.fetching_salary_data = false;
                    })
                    .catch(error => {
                        this.fetching_salary_data = false;
                        console.error("Error fetching salary:", error);
                    });
            },

            getEmployeeDepartment() {
                this.fetching_dept_data = true;
                return axios.get(`api/leaveFormDepartmentAndPositions/${this.form.personal_information_id}`)
                    .then(response => {
                        this.form.department = response.data.department;
                        this.form.position = response.data.position;
                        this.fetching_dept_data = false;
                    })
                    .catch(error => {
                        this.fetching_dept_data = false;
                        console.error("Error fetching department and position:", error);
                    });
            },

            getEmployeeLeaveCredits() {
                return axios.get(`api/leaveFormEmployeeLeaveCredits/${this.form.personal_information_id}`)
                    .then(response => {
                        this.form.vacation_balance = response.data.vl;
                        this.form.sick_balance = response.data.sl;
                    })
                    .catch(error => {
                        console.error("Error fetching leave credits:", error);
                    });
            },

            // leave type fetch
            getLeaveTypes: function(){
                axios.get('api/leaveFormLeaveTypes')
                .then(response => {
                    this.leave_types = response.data
                })
                .catch(e => {
                    console.log(e)
                })
            },

            setModeEdit: function(){
                this.editMode = true
            },

            // update leave application
            updateForm: function(){
                if(this.consecutive_dates == true){ //if consecutive dates set form inclusive_dates data to range
                    this.form.inclusive_dates.data = this.range
                }else{ //if non-consecutive dates set form inclusive_dates data to days
                    this.form.inclusive_dates.data = this.days
                }

                if(this.form.recommendation_approved == true){ //if recommendation_approved is null set application_stage to 'pending_noted_by'
                    this.form.application_stage = 'pending_noted_by'
                }else{
                    this.form.application_stage = 'pending_recommendation' //else set application_stage to 'pending_recommendation'
                }

                this.loading = true
                this.$Progress.start()
                axios.patch('api/leaveapplication/'+this.form.id, this.form)
                .then(response => {
                    this.$Progress.finish()
                    toast.fire({
                        icon: 'success',
                        title: 'Leave Application Submitted'
                    })
                    this.loading = false
                    this.$router.push('/leave-applications')
                })
                .catch(e => {
                    this.$Progress.fail()
                    toast.fire({
                        icon: 'error',
                        title: 'Error Submitting Leave Application'
                    })
                    console.log(e)
                    this.loading = false
                })
            },

            getLeaveApplication: function(id){
                axios.get('api/leaveFormEditLeaveApplication/'+id)
                .then(response => {
                    this.form.fill(response.data)
                    this.recommendation_officer = this.employees.find(employee => employee.id == response.data.recommendation_officer.personal_information_id)
                    this.credit_officer = this.employees.find(employee => employee.id == response.data.recommendation_officer.personal_information_id)
                    if(response.data.inclusive_dates.mode == 2){
                        this.range = response.data.inclusive_dates.data
                        this.consecutive_dates = true
                    }else{
                        this.consecutive_dates = false
                        this.days = this.form.inclusive_dates.data
                    }
                })
                .catch(e => {
                    console.log(e)
                })
            }
        },
        mounted(){
            this.getEmployees()
            this.getLeaveTypes()
        }
    }
</script>
