<template>
    <div class="row justify-content-center">
        <div class="col-md-12 px-4">
            <div class="col-md-12 mt-5">
                <h5 class="text-success">Governor</h5>
            </div>
            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="noted_by.name">Authorized Officer</label>
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
                            <span class="text-danger" v-if="errors && errors.position">
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
                                <input class="form-check-input" v-model="form.approved" type="radio" id="approved" :value="true">
                                <label class="form-check-label" for="gridCheck">
                                    Approve Leave
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" v-model="form.approved" type="radio" id="disapproved" :value="false">
                                <label class="form-check-label" for="gridCheck">
                                    Disapprove
                                </label>
                            </div>
                            <div class="form-group">
                                <span class="text-danger" v-if="errors && errors.approved">
                                    {{ errors.approved[0] }}
                                </span>
                            </div>
                            <div class="form-group" v-if="form.approved == false">
                                <label for="application_stage">Remark</label>
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
                form: new Form({ //noted by form data
                    personal_information_id: null,
                    name: null,
                    position: null,
                    remark: null,
                    approved: true,
                    application_stage: null,
                    type: 'governor_approval'
                }),
                errors: {}
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
        },
        methods: {

            // submit form data to parent component
            getFormData: function(){
                return {
                    personal_information_id: this.form.personal_information_id,
                    name: this.form.name,
                    position: this.form.position,
                    remark: this.form.remark,
                    approved: this.form.approved,
                    type: this.form.type,
                    application_stage: this.form.approved == false ? 'governor_disapproved' : 'approved',
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
            this.form.employee = {}
            this.getEmployees()
        }
    }
</script>
