<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="col-md-12 mt-5">
                <h5 class="text-success">Certification of Leave Credits</h5>
            </div>
            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="credit_as_of">Credit as of</label>
                            <input type="date" class="form-control form-control-border border-width-2" v-model="form.credit_as_of" :class="{ 'is-invalid': errors && errors.hasOwnProperty('credit_as_of') }">
                            <span class="text-danger" v-if="errors && errors.credit_as_of">
                                {{ errors.credit_as_of[0] ?? '' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="credit_officer">Authorized Officer</label>
                            <v-select class="form-control form-control-border border-width-2" v-model="employee" :options="employees"
                            :reduce="employees => employees" :class="{ 'is-invalid': errors && errors.hasOwnProperty('name') }" label="fullName" :getOptionLabel="employees => employees.fullName"></v-select>
                            <span class="text-danger" v-if="errors && errors.name">
                                {{ errors.name[0] ?? '' }}
                            </span>
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
                                        <td><input type="text" class="form-control form-control-border border-width-2" v-model="form.vacation_balance" name="" id="" disabled></td>
                                        <td><input type="text" class="form-control form-control-border border-width-2" v-model="form.sick_balance" name="" id="" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Less this application
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-border border-width-2" :class="{ 'is-invalid': errors && errors.hasOwnProperty('vacation_less') }" v-model="form.vacation_less" name="" id="">
                                            <span class="text-danger" v-if="errors && errors.vacation_less">
                                                {{ errors.vacation_less[0] ?? '' }}
                                            </span>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-border border-width-2" :class="{ 'is-invalid': errors && errors.hasOwnProperty('sick_less') }" v-model="form.sick_less" name="" id="">
                                            <span class="text-danger" v-if="errors && errors.sick_less">
                                                {{ errors.sick_less[0] ?? '' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Balance
                                        </td>
                                        <td><input type="text" class="form-control form-control-border border-width-2" :value="form.vacation_balance - form.vacation_less" name="" id="" disabled></td>
                                        <td><input type="text" class="form-control form-control-border border-width-2" :value="form.sick_balance - form.sick_less" name="" id="" disabled></td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <h5 class="text-success">Days With/Without Pay</h5>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="days_with_pay">Days with Pay</label>
                                    <input type="text" class="form-control form-control-border border-width-2" v-model="form.days_with_pay" :class="{ 'is-invalid': errors && errors.hasOwnProperty('days_with_pay') }" name="days_with_pay" id="days_with_pay">
                                    <span class="text-danger" v-if="errors && errors.days_with_pay">
                                        {{ errors.days_with_pay[0] ?? '' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="days_without_pay">Days without Pay</label>
                                    <input type="text" class="form-control form-control-border border-width-2" v-model="form.days_without_pay" :class="{ 'is-invalid': errors && errors.hasOwnProperty('days_without_pay') }" name="days_without_pay" id="days_without_pay">
                                    <span class="text-danger" v-if="errors && errors.days_without_pay">
                                        {{ errors.days_without_pay[0] ?? '' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="approved_for_others">Others(Specify)</label>
                                    <input type="text" class="form-control form-control-border border-width-2" v-model="form.approved_for_others" :class="{ 'is-invalid': errors && errors.hasOwnProperty('approved_for_others') }" name="approved_for_others" id="approved_for_others">
                                    <span class="text-danger" v-if="errors && errors.approved_for_others">
                                        {{ errors.approved_for_others[0] ?? '' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        data() {
            return {
                employees: [],
                employee: {},
                form: new Form({ //leave credit calculation form data
                    personal_information_id: null,
                    name: null,
                    position: null,
                    credit_as_of: null,
                    vacation_balance: null,
                    sick_balance: null,
                    vacation_less: null,
                    sick_less: null,
                    days_with_pay: null,
                    days_without_pay: null,
                    approved_for_others: null,
                    application_stage: 'pending_recommendation',
                    type: 'leave_credit_calculation',
                }),
                errors: {},
            }
        },
        props: {
            personal_information_id: {
                type: String,
                default: ''
            },
            leave_application_id: {
                type: String,
                default: ''
            },
            serverErrors: Object, // server errors from parent component
        },
        computed: {

        },
        watch: {
            serverErrors: { // watch for server errors
                deep: true,
                handler(newErrors) {
                    this.errors = newErrors;
                }
            },
            employee: {
                handler: function(){
                   if(this.employee){
                        this.form.personal_information_id = this.employee.id
                        this.form.name = this.employee.fullName
                        this.getOfficerDetails()
                   }else{
                        this.form.personal_information_id = null
                        this.form.name = null
                        this.form.position = null
                   }
                }
            }
        },
        methods: {

            getOfficerDetails: function(){ // fetch officer details
                axios.get('api/leaveFormDepartmentAndPositions/'+this.employee.id)
                .then(response => {
                    this.form.position = response.data.position
                })
                .catch(e => {
                    console.log(e)
                })
            },

            // submit form data to parent component
            getFormData: function(){
                return {
                    personal_information_id: this.form.personal_information_id,
                    name: this.form.name,
                    position: this.form.position,
                    credit_as_of: this.form.credit_as_of,
                    vacation_balance: this.form.vacation_balance,
                    sick_balance: this.form.sick_balance,
                    vacation_less: this.form.vacation_less,
                    sick_less: this.form.sick_less,
                    days_with_pay: this.form.days_with_pay,
                    days_without_pay: this.form.days_without_pay,
                    approved_for_others: this.form.approved_for_others,
                    application_stage: this.form.application_stage,
                    type: this.form.type,
                    application_stage: 'pending_recommendation',
                }
            },

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

            //fetch employee leave credits
            getEmployeeLeaveCredits: function(){
                axios.get('api/leaveFormEmployeeLeaveCredits/'+this.personal_information_id)
                .then(response => {
                    this.form.vacation_balance = response.data.vl
                    this.form.sick_balance = response.data.sl
                })
                .catch(e => {
                    console.log(e)
                })
            },


        },
        mounted(){
            this.getEmployees()
            this.getEmployeeLeaveCredits()
        }
    }
</script>
