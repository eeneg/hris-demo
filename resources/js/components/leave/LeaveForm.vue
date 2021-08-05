<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Leave Form <router-link to="/leave-applications" style="float: right;"><i class="fas fa-arrow-left"></i></router-link></h2>
                    <small style="margin-left: 2px;">Subtitle Subtitle Subtitle Subtitle Subtitle Subtitle</small>
                </div>

                <form autocomplete="off" @submit.prevent="mode == null ? check_credits() : mode == 1 ? submitEdits() : '' ">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6" style="position: relative;margin-bottom: 0.3rem;">
                            <label style="margin: 0;">Applicant</label>
                            <v-select class="form-control form-control-border border-width-2" v-model="form.personal_information_id" :options="personalinformations" label="name"
                            :reduce="personalinformations => personalinformations.id" :class="{ 'is-invalid': form.errors.has('personal_information_id') }"></v-select>
                            <has-error :form="form" field="personal_information_id"></has-error>
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
                                <input v-model="form.spent" value="Within the Philippines" class="custom-control-input" type="radio" id="within_the_ph" name="spent" checked>
                                <label for="within_the_ph" class="custom-control-label">Within the Philippines <br> <span class="font-weight-normal">(in case of vacation leave)</span></label>
                                <input v-model="form.spent_specify1" ref="within_the_ph_input" class="form-control form-control-border border-width-2" type="text" name="spent_spec1" placeholder="Specify" :disabled="form.spent != 'Within the Philippines'">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="custom-control custom-radio">
                                <input v-model="form.spent" class="custom-control-input" value="Abroad" type="radio" id="abroad" name="spent">
                                <label for="abroad" class="custom-control-label">Abroad <br> <span class="font-weight-normal">(in case of vacation leave)</span></label>
                                <input v-model="form.spent_specify2" ref="abroad_input" class="form-control form-control-border border-width-2" type="text" name="spent_spec2" placeholder="Specify" :disabled="form.spent != 'Abroad'">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="custom-control custom-radio">
                                <input v-model="form.spent" class="custom-control-input" value="In Hospital" type="radio" id="in_hospital" name="spent">
                                <label for="in_hospital" class="custom-control-label">In Hospital <br> <span class="font-weight-normal">(in case of sick leave)</span></label>
                                <input v-model="form.spent_specify3" ref="in_hospital_input" class="form-control form-control-border border-width-2" type="text" name="spent_spec3" placeholder="Specify" :disabled="form.spent != 'In Hospital'">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="custom-control custom-radio">
                                <input v-model="form.spent" class="custom-control-input" value="Out Patient" type="radio" id="out_patient" name="spent">
                                <label for="out_patient" class="custom-control-label">Out Patient <br> <span class="font-weight-normal">(in case of sick leave)</span></label>
                                <input v-model="form.spent_specify4" ref="out_patient_input" class="form-control form-control-border border-width-2" type="text" name="spent_spec4" placeholder="Specify" :disabled="form.spent != 'Out Patient'">
                            </div>
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
                    <h5 class="green mt-3">Details of action on Application</h5>
                    <div class="row">
                        <div class="col-md-12 form-group" style="display: contents;">
                            <div class="col-md-2">
                                <label class="d-block" style="margin: 0; color: #495057;"><i>Previous Balance</i> </label>
                            </div>
                            <div class="col-md-1  form-group">
                                <label style="margin: 0;">Vacation</label>
                                <input v-model="form.vacation_balance" type="text" @keypress="isNumberKey($event)" @keyup="calculate()" class="form-control form-control-border border-width-2" onclick="this.select()">
                            </div>
                            <div class="col-md-1 form-group">
                                <label style="margin: 0;">Sick</label>
                                <input v-model="form.sick_balance" type="text" @keypress="isNumberKey($event)" @keyup="calculate()" class="form-control form-control-border border-width-2" onclick="this.select()">
                            </div>
                            <div class="col-md-1  form-group">
                                <label style="margin: 0;">Total</label>
                                <label class="d-block form-control form-control-border border-width-2" style="margin: 0;padding: 10px 13px;height: 37px;">{{ curr_vacation_balance }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group" style="display: contents;">
                            <div class="col-md-2">
                                <label class="d-block" style="margin: 0; color: #495057;"><i>Less this Leave</i> </label>
                            </div>
                            <div class="col-md-1  form-group">
                                <label style="margin: 0;">Vacation</label>
                                <input v-model="form.vacation_less" type="text" @keypress="isNumberKey($event)" @keyup="calculate()" class="form-control form-control-border border-width-2" onclick="this.select()">
                            </div>
                            <div class="col-md-1 form-group">
                                <label style="margin: 0;">Sick</label>
                                <input v-model="form.sick_less" type="text" @keypress="isNumberKey($event)" @keyup="calculate()" class="form-control form-control-border border-width-2" onclick="this.select()">
                            </div>
                            <div class="col-md-1 form-group">
                                <label style="margin: 0;">Total</label>
                                <label class="d-block form-control form-control-border border-width-2" style="margin: 0;padding: 10px 13px;height: 37px;">{{ curr_sick_balance }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group" style="display: contents;">
                            <div class="col-md-2">
                                <label class="d-block" style="margin: 0; color: #495057;"><i>Leave Balance</i> </label>
                            </div>
                            <div class="col-md-1 form-group">
                                <label class="d-block form-control form-control-border border-width-2" style="margin: 0;padding-top: 10px;height: 37px;">{{ prev_balance_total }}</label>
                            </div>
                            <div class="col-md-1 form-group">
                                <label class="d-block form-control form-control-border border-width-2" style="margin: 0;padding-top: 10px;height: 37px;">{{ less_total }}</label>
                            </div>
                            <div class="col-md-1 form-group">
                                <label class="d-block form-control form-control-border border-width-2" style="margin: 0;padding-top: 10px;height: 37px;">{{ balance_total }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="credit_as_of" class="d-block" style="margin: 0; color: #495057;">Certification of Leave Credits <span style="font-weight: normal; color: black;">As of</span></label>
                            <date-picker v-model="form.credit_as_of" id="credit_as_of" :config="options" class="form-control form-control-border border-width-2"></date-picker>
                        </div>
                    </div>

                    <h5 class="green mt-3">Recommendation</h5>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <div class="custom-control custom-radio">
                                <input v-model="form.recommendation_status" value="APPROVED" class="custom-control-input" type="radio" id="recommendation_status_approved" name="recommendation_status">
                                <label for="recommendation_status_approved" class="custom-control-label">Approved</label>
                                <input v-model="form.recommendation_remark_approved" ref="recommendation_status_approved" class="form-control form-control-border border-width-2" type="text" name="recommendation_remark" placeholder="Remark" :disabled="form.recommendation_status != 'APPROVED'">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="custom-control custom-radio">
                                <input v-model="form.recommendation_status" class="custom-control-input" value="DISAPPROVED" type="radio" id="recommendation_status_disapproved" name="recommendation_status">
                                <label for="recommendation_status_disapproved" class="custom-control-label">Dissaproved due to</label>
                                <input v-model="form.recommendation_remark_disapproved" ref="recommendation_status_disapproved" class="form-control form-control-border border-width-2" type="text" name="recommendation_remark" placeholder="Remark" :disabled="form.recommendation_status != 'DISAPPROVED'">
                            </div>
                        </div>
                        <div class="form-group col-md-6" style="position: relative;margin-bottom: 0.3rem;">
                            <label style="margin: 0;">Recommendation Officer</label>
                            <v-select class="form-control form-control-border border-width-2" v-model="form.recommendation_officer_id" :options="personalinformations" label="name"
                            :reduce="personalinformations => personalinformations.id" :class="{ 'is-invalid': form.errors.has('personal_information_id') }"></v-select>
                            <has-error :form="form" field="personal_information_id"></has-error>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <button type="submit" class="btn btn-primary" @click="status = 'final'">Finalize</button>
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
                mode: null,
                status: '',
                personalinformations: [],
                leavetypes: [],
                prev_balance_total: 0.0,
                less_total: 0.0,
                balance_total: 0.0,
                curr_vacation_balance: 0.0,
                curr_sick_balance: 0.0,
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
                    'status': '',
                    'stage_status': '',
                    'recommendation_status': '',
                    'recommendation_remark_approved': '',
                    'recommendation_remark_disapproved': '',
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
        beforeRouteEnter (to, from, next) {
            if(to.query.id == null)
            {
                    next()
            }
            else if(to.query.id != null && to.query.mode == 1){
                axios.get('api/editLeaveApplication?id='+to.query.id)
                .then(({data}) => {
                    next(vm => vm.fetchData(data))
                })
                .catch(error => {
                    console.log(error)
                    Swal.fire(
                        'Oops...',
                        error.response.data.message,
                        'error'
                    )
                })
            }
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

                 if((this.form.recommendation_officer_id == '' || this.form.recommendation_officer_id == null)  &&  (this.form.recommendation_status != '' && this.form.recommendation_status != null))
                {

                    Swal.fire(
                        'Oops...',
                        'Please select an Administrative Officer below the Recommendation section',
                        'error'
                    )

                }else{
                    this.$Progress.start();
                    this.form.personal_information_id_7b = this.form.personal_information_id
                    this.form.personal_information_id_7c = this.form.personal_information_id
                    this.form.personal_information_id_7d = this.form.personal_information_id
                    this.form.stage_status =    this.form.recommendation_officer_id != null && this.form.recommendation_status == 'APPROVED' ? 'Pending Noted By' :
                                                this.form.recommendation_officer_id != null && this.form.recommendation_status == 'DISAPPROVED' ? 'Recommendation Disapproved' : 'Pending Recommendation'

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
                }
            },
            submitEdits: function()
            {

                if((this.form.recommendation_status != null && this.form.recommendation_status != '') && (this.form.recommendation_officer_id == null && this.form.recommendation_officer_id == ''))
                {

                     Swal.fire(
                        'Oops...',
                        'Please select an Administrative Officer below the Recommendation section',
                        'error'
                    )

                }else{
                    Swal.fire({
                    title: 'Are you sure?',
                    text: "This will save and restart the application process",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Proceed'
                    }).then((result) => {
                        if(result.isDismissed == true)
                        {
                            toast.fire({
                                icon: 'success',
                                title: 'Cancelled'
                            });
                        }else{
                            this.$Progress.start();
                            this.form.personal_information_id_7b = this.form.personal_information_id
                            this.form.personal_information_id_7c = this.form.personal_information_id
                            this.form.personal_information_id_7d = this.form.personal_information_id
                            this.form.stage_status =    this.form.recommendation_officer_id != null && this.form.recommendation_status == 'APPROVED' ? 'Pending Noted By' :
                                                        this.form.recommendation_officer_id != null && this.form.recommendation_status == 'DISAPPROVED' ? 'Recommendation Disapproved' : 'Pending Recommendation'
                            this.form.governor_id = null
                            this.form.noted_by_id = null
                            this.form.days_with_pay = null
                            this.form.days_without_pay = null
                            this.form.others = null
                            this.form.disapproved_due_to = null

                            if (this.status == 'final') {
                                this.form.status = 'final';
                                axios.patch('api/leaveapplication/'+this.leave_application_id, this.form)
                                    .then(({data}) => {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: 'New leave application is updated successfully',
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
                        }
                    })
                }
            },
            check_credits: function()
            {
                axios.post('api/checkcredits', {personal_information_id: this.form.personal_information_id, leave_type_id: this.form.leave_type_id})
                .then(response => {
                    if(response.data.code == true)
                    {
                        this.submitForm()
                    }else{
                        Swal.fire(
                        'Oops...',
                        response.data.message,
                        'error'
                        )
                    }
                })
                .catch(error => {
                    console.log(error)
                    Swal.fire(
                        'Oops...',
                        'Something went wrong',
                        'error'
                    )
                })
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

            },
            fetchData: function(data){

               this.form.fill(data.data[0])
               this.mode = 1
               this.leave_application_id = data.data[0].id
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
