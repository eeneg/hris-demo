<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                   <div class="row">
                       <div class="col-md-6">
                            <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Leave Credits</h2>
                            <small style="margin-left: 2px;">Subtitle Subtitle Subtitle Subtitle Subtitle Subtitle</small>
                       </div>
                        <div class="col-md-6">
                            <div class="form-group" style="position: relative;margin-bottom: 0.3rem;">
                                <v-select @input="getEmployeeLeaveCredit()" v-model="form.personal_information_id" class="form-control form-control-border border-width-2"
                                :options="employees.data" label="name" placeholder="Search employee" :reduce="employees => employees.id">
                                </v-select>
                            </div>
                       </div>
                   </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col"></th>
                            <th scope="col">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Vacation Leave</th>
                                <td>{{ display.vacation_leave }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Sick Leave</th>
                                <td>{{ display.sick_leave }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Forced Leave</th>
                                <td>m</td>
                            </tr>
                            <tr>
                                <th scope="row">Special Leave Previliges (as of)</th>
                                <td>m</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6 text-left">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-primary" @click="getleavesummary()">Leave card</button>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-primary" @click="balance_modal()">Leave Credits</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal -->

        <div class="modal fade" id="balanceModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-6">
                        <h5 class="modal-title" id="balanceModal">Sick Leave</h5>
                    </div>
                    <div class="col-md-3">
                        <h5 class="modal-title" id="balanceModal">Vacation Leave</h5>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                    <form @submit.prevent="submit_leave_credits()" action="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="leave_earned">Leave Earned</label>
                                                <input type="text" class="form-control" v-model="form.sl_earned" name="leave_earned" id="leave_earned">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="leave_earned">Leave Absence Undertime w/ Pay</label>
                                                <input type="text" class="form-control" v-model="form.sl_withpay" name="leave_earned" id="leave_earned">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="leave_earned">Leave Absence Undertime w/o Pay</label>
                                                <input type="text" class="form-control" v-model="form.sl_withoutpay" name="leave_earned" id="leave_earned">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="leave_earned">Leave Earned</label>
                                                <input type="text" class="form-control" v-model="form.vl_earned" name="leave_earned" id="leave_earned">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="leave_earned">Leave Absence Undertime w/ Pay</label>
                                                <input type="text" class="form-control" v-model="form.vl_withpay" name="leave_earned" id="leave_earned">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="leave_earned">Leave Absence Undertime w/o Pay</label>
                                                <input type="text" class="form-control" v-model="form.vl_withoutpay" name="leave_earned" id="leave_earned">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leave_earned">Period</label>
                                        <input type="text" class="form-control" v-model="month" name="period" id="period">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leave_earned">Year</label>
                                        <input type="text" class="form-control" v-model="year" name="year" id="year">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="particulars">Particulars</label>
                                        <input type="text" class="form-control" v-model="form.particulars" name="particulars" id="particulars">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remarks">Remarks</label>
                                        <input type="text" class="form-control" v-model="form.remarks" name="remarks" id="remarks">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary float-right" data-toggle="modal">Save <i class="fas fa-save"></i></button>
                    </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- modal end -->

        <!-- modal -->

        <div class="modal fade" id="summaryModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document" style="overflow-y: initial !important">
                <div class="modal-content" style="height: 90vh;">
                <div class="modal-header">
                    <div class="col-md-6">
                        <h5 class="modal-title" id="summaryModal">Leave Summary</h5>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                    <div class="modal-body" style="height: 80vh; overflow-y: auto;">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th rowspan="2" colspan="1">
                                        Period
                                    </th>
                                    <th rowspan="2" colspan="1">
                                        Particulars
                                    </th>
                                    <th rowspan="1" colspan="5">
                                        Vacation Leave
                                    </th>
                                    <th rowspan="1" colspan="3" >
                                        Sick Leave
                                    </th>
                                    <th rowspan="2" colspan="1" >
                                        Remarks
                                    </th>
                                </tr>
                                <tr>
                                    <th>EARNED</th>
                                    <th>Absence undertime w/ pay</th>
                                    <th>Absence undertime w/o pay</th>
                                    <th>BALANCE</th>
                                    <th>EARNED</th>
                                    <th>Absence undertime w/ pay</th>
                                    <th>Absence undertime w/o pay</th>
                                    <th>BALANCE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="leave_card in leave_cards" :key=leave_card.id>
                                    <td>{{ leave_card.period }}</td>
                                    <td>{{ leave_card.particulars }}</td>
                                    <td>{{ leave_card.vl_earned }}</td>
                                    <td>{{ leave_card.vl_withpay }}</td>
                                    <td>{{ leave_card.vl_withoutpay }}</td>
                                    <td>{{ leave_card.vl_balance }}</td>
                                    <td>{{ leave_card.sl_earned }}</td>
                                    <td>{{ leave_card.vl_withpay }}</td>
                                    <td>{{ leave_card.sl_withoutpay }}</td>
                                    <td>{{ leave_card.sl_balance }}</td>
                                    <td>{{ leave_card.remarks }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary float-right" data-toggle="modal" @click="generateleavecard()">Print <i class="fas fa-print"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal end -->

        <!-- pdf modal -->

       <div class="modal" id="pdfModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Print Leave Card</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="pdf-viewer">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

                </div>
            </div>
        </div>

        <!-- pdf modal -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                mode: '',
                employees: [],
                employee_data: {},
                display: {vacation_leave: '', sick_leave: ''},
                leave_cards: {},
                month: '',
                year: '',
                form: new Form({
                    'personal_information_id': '',
                    'leave_type_id': '',
                    'particulars': '',
                    'period': '',
                    'vl_earned': '',
                    'vl_withpay': '',
                    'vl_balance': '',
                    'vl_withoutpay': '',
                    'sl_earned': '',
                    'sl_balance': '',
                    'sl_withpay': '',
                    'sl_withoutpay': '',
                    'remarks': '',
                    'detail1': '',
                    'detail2': '',
                    'detail3': '',
                }),
            }
        },
        methods: {
            getEmployeeLeaveCredit: _.debounce(function(){

                this.$Progress.start()
                this.display = this.employee_data[this.form.personal_information_id] != null ? this.employee_data[this.form.personal_information_id] : {vacation_leave: 0, sick_leave: 0}
                this.$Progress.finish()

            }, 500),
            getEmployees: function()
            {
                axios.get('api/employeeList')
                .then(({data})=> {
                this.employees = data
                })
                .catch(error => {
                    console.log(error)
                    toast.fire({
                        icon: 'error',
                        title: 'Employee data not retrieved'
                    });
                })
            },
            getLeaveCredits: function()
            {
                this.$Progress.start()
                axios.get('api/leavecredits')
                .then(({data}) => {

                    this.$Progress.finish()
                    this.employee_data = data

                })
                .catch(error => {
                    console.log(error)
                    let e = error.response.data.message
                    Swal.fire(
                        'Oops...',
                        e == 'Leave balance not found, possible leave type data change' ? e : 'Something went wrong',
                        'error'
                    )
                })
            },
            balance_modal: function()
            {

                this.form.sl_earned = ''
                this.form.vl_earned = ''
                this.form.sl_withpay =''
                this.form.sl_withoutpay = ''
                this.form.vl_withpay =''
                this.form.vl_withoutpay = ''
                this.form.particulars = ''
                this.form.remarks = ''
                this.month = ''
                this.year = ''

                if(this.form.personal_information_id != null && this.form.personal_information_id != '')
                {
                    $('#balanceModal').modal('show')
                }else{
                    Swal.fire(
                        'Oops...',
                        'Please select and employee first',
                        'error'
                    )
                }

            },
            submit_leave_credits: function()
            {
                this.form.period = this.month+ ' ' +this.year
                this.vl_earned = this.vl_earned - this.vl_withpay != null && this.vl_withpay != '' ? this.vl_withpay : 0

                this.$Progress.start()
                axios.post('api/leavecredits', this.form)
                .then(response => {

                    $('#balanceModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'Submitted'
                    });
                    this.getLeaveCredits()
                    this.getEmployeeLeaveCredit()
                    this.$Progress.finish()

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
            getleavesummary: function()
            {
                if(this.form.personal_information_id != null && this.form.personal_information_id != '')
                {
                    this.$Progress.start()
                    axios.get('api/getleavesummary?id=' + this.form.personal_information_id)
                    .then(({data}) => {
                        $('#summaryModal').modal('show')
                        this.leave_cards = data
                        this.$Progress.finish()

                        console.log(this.leave_card)
                    })
                    .catch(error => {
                        console.log(error)
                        Swal.fire(
                            'Oops...',
                            'Unable to fetch leave card',
                            'error'
                        )
                    })
                }else{
                    Swal.fire(
                        'Oops...',
                        'Please select and employee first',
                        'error'
                    )
                }
            },
            generateleavecard(id){
                axios.post('generateleavecard', {id: this.form.personal_information_id})
                .then(response => {
                    let options = {
                        height: screen.height * 0.65 + 'px',
                        page: '1'
                    };
                    $('#summaryModal').modal('hide');
                    $('#pdfModal').modal('show');
                    PDFObject.embed("/storage/employee_leave_card/" + response.data.title, "#pdf-viewer", options);
                })
                .catch(error => {
                    console.log(error);
                });
            },
        },
        mounted() {
            console.log('Component mounted.')
            this.getEmployees()
            this.getLeaveCredits()
        }
    }
</script>
