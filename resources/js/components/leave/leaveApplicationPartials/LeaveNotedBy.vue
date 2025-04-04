<template>
    <div class="row justify-content-center">
        <div class="col-md-12 px-4">
            <div class="col-md-12 mt-5">
                <h5 class="text-success">HR Department Head Approval</h5>
            </div>
            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="form.name">Authorized Officer</label>
                            <v-select
                                class="form-control form-control-border border-width-2"
                                @input="getEmployeeDetails()"
                                v-model="employee"
                                :options="employees"
                                :class="{ 'is-invalid': errors && errors.hasOwnProperty('name') }"
                                label="fullName"
                                :getOptionLabel="employees => employees.fullName"
                            >
                            </v-select>
                            <span class="text-danger" v-if="errors && errors.name">
                                {{ errors.name[0] }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="position">Position</label>
                            <input
                                type="text"
                                class="form-control form-control-border border-width-2"
                                v-model="form.position"
                                :class="{ 'is-invalid': errors && errors.hasOwnProperty('position') }"
                            >
                            <span class="text-danger" v-if="errors && errors.name">
                                <!-- {{ errors.position[0] }} -->
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h5 class="text-success">Options</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" v-model="approved" type="radio" id="approved" :value="true">
                                <label class="form-check-label" for="approved">
                                    Approve Leave
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" v-model="approved" type="radio" id="disapproved" :value="false">
                                <label class="form-check-label" for="disapproved">
                                    Disapprove
                                </label>
                            </div>
                            <div class="form-group" v-if="approved == false">
                                <label for="remark">Remark</label>
                                <input
                                    type="text"
                                    class="form-control form-control-border border-width-2"
                                    v-model="form.remark"
                                    :class="{ 'is-invalid': errors && errors.hasOwnProperty('remark') }"
                                >
                                <span class="text-danger" v-if="errors && errors.remark">
                                    {{ errors.remark[0] }}
                                </span>
                            </div>
                            <hr>
                            <div class="form-check" v-if="approved == true">
                                <input class="form-check-input" type="checkbox" id="disapproved" v-model="for_gorvernor_approval">
                                <label class="form-check-label text-primary" for="gridCheck">
                                    Forward for Governor Approval
                                </label>
                            </div>
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
                employee: {},
                for_gorvernor_approval: null,
                approved: true,
                errors: {},
                form: new Form({ //noted by form data
                    personal_information_id: null,
                    name: null,
                    position: null,
                    remark: null,
                    type: 'noted_by',
                }),
            }
        },
        props: {
            personal_information_id: String,
            leave_application_id: String,
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
            approved: {
                handler: function(){
                    if(this.approved == false){
                        this.for_gorvernor_approval = false
                    }
                }
            }
        },
        methods: {

            // submit form data to parent component
            getFormData: function(){
                return {
                    leave_application_id: this.leave_application_id,
                    personal_information_id: this.form.personal_information_id,
                    name: this.form.name,
                    position: this.form.position,
                    remark: this.form.remark,
                    approved: this.approved,
                    type: this.form.type,
                    application_stage: this.approved == true && this.for_gorvernor_approval == true ? 'pending_governor_approval' :
                        this.approved == false && this.for_gorvernor_approval == false ? 'noted_by_disapproved' : 'approved'
                }
            },

            //employee position fetch
            getEmployeeDetails: function(){
                if(this.employee)
                {
                    this.form.personal_information_id = this.employee.id
                    this.form.name = this.employee.fullName
                    axios.get('api/leaveFormDepartmentAndPositions/'+this.employee.id)
                    .then(response => {
                        this.form.position = response.data.position
                    })
                    .catch(e => {
                        console.log(e)
                    })
                }else{
                    this.form.position = null
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
        },
        mounted(){
            this.getEmployees()
        }
    }
</script>
