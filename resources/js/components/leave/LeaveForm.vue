<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Leave Form <router-link to="/leave-applications" style="float: right;"><i class="fas fa-arrow-left"></i></router-link></h2>
                    <small style="margin-left: 2px;">Subtitle Subtitle Subtitle Subtitle Subtitle Subtitle</small>
                </div>

                <form autocomplete="off" @submit.prevent="submitForm()">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-4" style="position: relative;margin-bottom: 0.3rem;">
                            <label style="margin: 0;">Applicant</label>
                            <v-select class="form-control form-control-border border-width-2" v-model="form.personal_information_id" :options="personalinformations" label="name" 
                            :reduce="personalinformations => personalinformations.id" :class="{ 'is-invalid': form.errors.has('personal_information_id') }"></v-select>
                            <has-error :form="form" field="personal_information_id"></has-error>
                        </div>
                        <div class="form-group col-4">
                            <label for="date_of_filing" style="margin: 0;">Date of filing <span style="font-weight: normal;">(yyyy-mm-dd)</span></label>
                            <date-picker v-model="form.date_of_filing" id="date_of_filing" :config="options" class="form-control form-control-border border-width-2"></date-picker>
                        </div>
                    </div>
                    <h5 class="green mt-3">Details of Application</h5>
                    <div class="row">
                        <div class="form-group col-4">
                            <label style="margin: 0;">Type of leave</label>
                            <v-select class="form-control form-control-border border-width-2" v-model="form.leave_type_id" :options="leavetypes" label="title" 
                            :reduce="leavetypes => leavetypes.id" :class="{ 'is-invalid': form.errors.has('leave_type_id') }"></v-select>
                            <has-error :form="form" field="leave_type_id"></has-error>
                        </div>
                        <div class="form-group col-4">
                            <label for="working_days" style="margin: 0;">Number of working days applied</label>
                            <input v-model="form.working_days" id="working_days" class="form-control form-control-border border-width-2" type="text" 
                            name="working_days" placeholder="Number of working days" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-3">
                            <div class="custom-control custom-radio">
                                <input v-model="form.spent" value="Within the Philippines" class="custom-control-input" type="radio" id="within_the_ph" name="spent" checked>
                                <label for="within_the_ph" class="custom-control-label">Within the Philippines <span class="font-weight-normal">(in case of vacation leave)</span></label>
                                <input v-model="form.spent_specify1" ref="within_the_ph_input" class="form-control form-control-border border-width-2" type="text" name="spent_spec1" placeholder="Specify" :disabled="form.spent != 'Within the Philippines'">
                            </div>
                        </div>
                        <div class="form-group col-3">
                            <div class="custom-control custom-radio">
                                <input v-model="form.spent" class="custom-control-input" value="Abroad" type="radio" id="abroad" name="spent">
                                <label for="abroad" class="custom-control-label">Abroad <span class="font-weight-normal">(in case of vacation leave)</span></label>
                                <input v-model="form.spent_specify2" ref="abroad_input" class="form-control form-control-border border-width-2" type="text" name="spent_spec2" placeholder="Specify" :disabled="form.spent != 'Abroad'">
                            </div>
                        </div>
                        <div class="form-group col-3">
                            <div class="custom-control custom-radio">
                                <input v-model="form.spent" class="custom-control-input" value="In Hospital" type="radio" id="in_hospital" name="spent">
                                <label for="in_hospital" class="custom-control-label">In Hospital <span class="font-weight-normal">(in case of sick leave)</span></label>
                                <input v-model="form.spent_specify3" ref="in_hospital_input" class="form-control form-control-border border-width-2" type="text" name="spent_spec3" placeholder="Specify" :disabled="form.spent != 'In Hospital'">
                            </div>
                        </div>
                        <div class="form-group col-3">
                            <div class="custom-control custom-radio">
                                <input v-model="form.spent" class="custom-control-input" value="Out Patient" type="radio" id="out_patient" name="spent">
                                <label for="out_patient" class="custom-control-label">Out Patient <span class="font-weight-normal">(in case of sick leave)</span></label>
                                <input v-model="form.spent_specify4" ref="out_patient_input" class="form-control form-control-border border-width-2" type="text" name="spent_spec4" placeholder="Specify" :disabled="form.spent != 'Out Patient'">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-6" style="margin: 0;">Inclusive Dates</label>
                        <label class="col-6" style="margin: 0;">Commutation</label>
                    </div>
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="from" style="margin: 0;"><span style="font-weight: normal;">From (yyyy-mm-dd)</span></label>
                            <date-picker v-model="form.from" id="from" :config="options" class="form-control form-control-border border-width-2"></date-picker>
                        </div>
                        <div class="form-group col-3">
                            <label for="to" style="margin: 0;"><span style="font-weight: normal;">To (yyyy-mm-dd)</span></label>
                            <date-picker v-model="form.to" id="to" :config="options" class="form-control form-control-border border-width-2"></date-picker>
                        </div>
                        <div class="form-group col-6" style="margin-top: 5px;">
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
                    <h5 class="green mt-3">Details of action on Application</h5>
                    <div class="row">
                        <label class="col-2" style="margin: 0;"></label>
                        <label class="col-1" style="margin: 0;">Vacation</label>
                        <label class="col-1" style="margin: 0;">Sick</label>
                        <label class="col-1" style="margin: 0;">Total</label>
                        <label class="col-3" style="margin: 0;">Certification of Leave Credits</label>
                    </div>
                    <div class="row">
                        <div class="col-2" style="padding-top: 10px;text-align: right;">
                            <label class="d-block" style="margin: 0;height: 37px;">Previous Balance</label>
                            <label class="d-block" style="margin: 0;height: 37px;">Less this Leave</label>
                            <label class="d-block" style="margin: 0;height: 37px;">Leave Balance</label>
                        </div>
                        <div class="col-1">
                            <input v-model="form.vacation_balance" type="text" @keypress="isNumberKey($event)" @keyup="calculate()" class="form-control form-control-border border-width-2" onclick="this.select()">
                            <input v-model="form.vacation_less" type="text" @keypress="isNumberKey($event)" @keyup="calculate()" class="form-control form-control-border border-width-2" onclick="this.select()">
                            <label class="d-block" style="margin: 0;padding: 10px 13px;height: 37px;">{{ curr_vacation_balance }}</label>
                        </div>
                        <div class="col-1">
                            <input v-model="form.sick_balance" type="text" @keypress="isNumberKey($event)" @keyup="calculate()" class="form-control form-control-border border-width-2" onclick="this.select()">
                            <input v-model="form.sick_less" type="text" @keypress="isNumberKey($event)" @keyup="calculate()" class="form-control form-control-border border-width-2" onclick="this.select()">
                            <label class="d-block" style="margin: 0;padding: 10px 13px;height: 37px;">{{ curr_sick_balance }}</label>
                        </div>
                        <div class="col-1">
                            <label class="d-block" style="margin: 0;padding-top: 10px;height: 37px;">{{ prev_balance_total }}</label>
                            <label class="d-block" style="margin: 0;padding-top: 10px;height: 37px;">{{ less_total }}</label>
                            <label class="d-block" style="margin: 0;padding-top: 10px;height: 37px;">{{ balance_total }}</label>
                        </div>
                        <div class="form-group col-3">
                            <label for="credit_as_of" style="margin: 0;"><span style="font-weight: normal;">As of</span></label>
                            <date-picker v-model="form.credit_as_of" id="credit_as_of" :config="options" class="form-control form-control-border border-width-2"></date-picker>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <button type="submit" class="btn btn-success" @click="status = 'final'">Finalize</button>
                    <button type="submit" class="btn btn-secondary" @click="status = 'draft'">Save as draft</button>
                </div>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                status: '',
                personalinformations: [],
                leavetypes: [],
                prev_balance_total: 0.0,
                less_total: 0.0,
                balance_total: 0.0,
                curr_vacation_balance: 0.0,
                curr_sick_balance: 0.0,
                form: new Form({
                    'personal_information_id': '',
                    'date_of_filing': moment(new Date()).format('YYYY-MM-DD'),
                    'leave_type_id': '',
                    'working_days': '',
                    'spent': 'Within the Philippines',
                    'spent_specify1': '',
                    'spent_specify2': '',
                    'spent_specify3': '',
                    'spent_specify4': '',
                    'from': moment(new Date()).format('YYYY-MM-DD'),
                    'to': moment(new Date()).format('YYYY-MM-DD'),
                    'credit_as_of': moment(new Date()).format('YYYY-MM-DD'),
                    'commutation': 'Requested',
                    'vacation_balance': 0.0,
                    'sick_balance': 0.0,
                    'vacation_less': 0.0,
                    'sick_less': 0.0,
                    'status': ''
                }),
                options: {
                    format: 'yyyy-MM-DD',
                    useCurrent: false,
                }
            }
        },
        components: {
            datePicker
        },
        methods: {
            isNumberKey(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                    evt.preventDefault();;
                } else {
                    return true;
                }
            },
            calculate() {
                this.curr_vacation_balance = parseFloat(this.form.vacation_balance) - parseFloat(this.form.vacation_less);
                this.curr_sick_balance = parseFloat(this.form.sick_balance) - parseFloat(this.form.sick_less);

                this.prev_balance_total = parseFloat(this.form.vacation_balance) + parseFloat(this.form.sick_balance);
                this.less_total = parseFloat(this.form.vacation_less) + parseFloat(this.form.sick_less);

                this.balance_total = parseFloat(this.curr_vacation_balance) + parseFloat(this.curr_sick_balance);
            },
            submitForm() {
                this.$Progress.start();
                if (this.status == 'final') {
                    this.form.status = 'final';
                    this.form.post('api/leaveapplication')
                        .then(({data}) => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'New leave application is created successfully',
                            })
                            this.$router.push({ path: '/leave-applications'});
                            this.$Progress.finish();
                        })
                        .catch(error => {
                            console.log(error.response.data.message);
                            this.$Progress.fail();
                        });
                } else {

                }
            },
            loadFormData() {
                axios.post('api/forleave')
                    .then(({data}) => {
                        this.personalinformations = data;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
                axios.get('api/getleavetypes')
                    .then(({data}) => {
                        this.leavetypes = data;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });

            }
        },
        created(){
            this.$Progress.start();
            this.loadFormData();
            this.$Progress.finish();
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
