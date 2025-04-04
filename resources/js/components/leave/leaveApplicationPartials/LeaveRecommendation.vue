<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="col-md-12 mt-5 px-4">
                <h5 class="text-success">Approve or disapprove leave application recommendation</h5>
            </div>
            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-md-12 px-4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="approve" id="approve" v-model="recommendation_approved" :value="true" checked>
                            <label class="form-check-label" for="approve">
                                Approve
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="disapprove" id="disapprove" v-model="recommendation_approved" :value="false" checked>
                            <label class="form-check-label" for="disapprove">
                                Disapproved
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 px-4" v-if="recommendation_approved == false">
                        <div class="form-group">
                            <label for="recommendation_disapproved_due_to">Disapproved due to</label>
                            <input
                                type="text"
                                class="form-control form-control-border border-width-2"
                                v-model="form.recommendation_disapproved_due_to"
                                :class="{ 'is-invalid': errors && errors.hasOwnProperty('recommendation_disapproved_due_to') }"
                            >
                            <span class="text-danger" v-if="errors && errors.recommendation_disapproved_due_to">
                                {{ errors.recommendation_disapproved_due_to[0] }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 px-4 mt-2">
                        <div class="form-group">
                            <label for="name">Authorized Officer</label>
                            <v-select
                                class="form-control form-control-border border-width-2"
                                v-model="employee"
                                :options="employees"
                                :reduce="employees => employees"
                                :class="{ 'is-invalid': errors && errors.hasOwnProperty('name') }"
                                label="fullName"
                                :getOptionLabel="employees => employees.fullName"
                            >
                            </v-select>
                            <span class="text-danger" v-if="errors && errors.name">
                                {{ errors.name[0] ?? '' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group">
                            <label for="position">Position</label>
                            <input type="text" class="form-control form-control-border border-width-2" v-model="form.position" :class="{ 'is-invalid': errors && errors.hasOwnProperty('position') }">
                            <span class="text-danger" v-if="errors && errors.name">
                                <!-- {{ errors?.position[0] ?? '' }} -->
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { values } from 'lodash';


    export default {
        data() {
            return {
                employees: [],
                recommendation_approved: true,
                errors: {},
                employee: {},
                form: new Form({ //recommendation form data
                    personal_information_id: null,
                    recommendation_approved: true,
                    recommendation_disapproved_due_to: '',
                    name: '',
                    position: '',
                    date: '',
                    application_stage: 'pending_noted_by',
                    type: 'recommendation',
                }),
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
            recommendation_approved: {
                handler: function(){
                    if(this.recommendation_approved == true){
                        this.form.recommendation_approved = true
                        this.form.application_stage = 'pending_noted_by'
                    }else{
                        this.form.recommendation_approved = false
                        this.form.application_stage = 'recommendation_disapproved'
                    }
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

            // submit recommendation form data to parent component
            getFormData() {
                return {
                    leave_application_id: this.leave_application_id,
                    personal_information_id: this.personal_information_id,
                    recommendation_approved: this.recommendation_approved,
                    recommendation_disapproved_due_to: this.recommendation_approved ? null : this.form.recommendation_disapproved_due_to,
                    name: this.form.name,
                    position: this.form.position,
                    application_stage: this.form.application_stage,
                    type: this.form.type,
                };
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
        },
        mounted(){
            this.getEmployees()
        }
    }
</script>
