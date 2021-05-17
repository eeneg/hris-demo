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
                        <div class="col-md-5">
                            <div class="form-group" style="position: relative;margin-bottom: 0.3rem;">
                                <v-select @input="getEmployeeLeaveCredit()" v-model="form.personal_information_id" class="form-control form-control-border border-width-2"
                                :options="employees.data" label="name" placeholder="Search employee" :reduce="employees => employees.id">
                                </v-select>
                            </div>
                       </div>
                       <div class="col-md-1">
                            <div class="btn-group dropleft float-right" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                </button>
                                <div class="dropdown-menu">
                                    <a type="button" class="dropdown-item" @click.prevent="balance_modal()" aria-haspopup="true" aria-expanded="false" data-toggle="modal">
                                        Leave Credits
                                    </a>
                                    <a type="button" class="dropdown-item" @click.prevent="getleavesummary()" aria-haspopup="true" aria-expanded="false" data-toggle="modal">
                                        Leave Card
                                    </a>
                                    <a type="button" class="dropdown-item" @click.prevent="slp_fl_modal()" aria-haspopup="true" aria-expanded="false" data-toggle="modal">
                                        Forced and SLP Credits
                                    </a>
                                    <a type="button" class="dropdown-item" @click.prevent="global_credits()" aria-haspopup="true" aria-expanded="false" data-toggle="modal">
                                        Global Credits
                                    </a>
                                </div>
                            </div>
                       </div>
                   </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col" style="width: 800px">
                                <h4>{{ display.name ? display.name : 'No Leave Credits data for this employee' }}</h4>
                            </th>
                            <th scope="col">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Vacation Leave</th>
                                <td>{{ display.vacation_leave ? display.vacation_leave.balance : 0  }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Sick Leave</th>
                                <td>{{ display.sick_leave ? display.sick_leave.balance : 0 }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Forced Leave</th>
                                <td>{{ display.forced_leave && display.forced_leave.year ==  display_year ? display.forced_leave.balance : display.forced_leave.balance = 0 }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Special Leave Previliges (as of {{ display_year }})</th>
                                <td>
                                    {{
                                        display.special_leave_previliges &&
                                        display.special_leave_previliges.year == display_year ?
                                        display.special_leave_previliges.balance :
                                        display.special_leave_previliges.balance = 0
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">

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
                                                <input type="text" class="form-control form-control-border border-width-2" v-model="form.sl_earned" name="leave_earned" id="leave_earned">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="leave_earned">Leave Absence Undertime w/ Pay</label>
                                                <input type="text" class="form-control form-control-border border-width-2" v-model="form.sl_withpay" name="leave_earned" id="leave_earned">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="leave_earned">Leave Absence Undertime w/o Pay</label>
                                                <input type="text" class="form-control form-control-border border-width-2" v-model="form.sl_withoutpay" name="leave_earned" id="leave_earned">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="leave_earned">Leave Earned</label>
                                                <input type="text" class="form-control form-control-border border-width-2" v-model="form.vl_earned" name="leave_earned" id="leave_earned">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="leave_earned">Leave Absence Undertime w/ Pay</label>
                                                <input type="text" class="form-control form-control-border border-width-2" v-model="form.vl_withpay" name="leave_earned" id="leave_earned">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="leave_earned">Leave Absence Undertime w/o Pay</label>
                                                <input type="text" class="form-control form-control-border border-width-2" v-model="form.vl_withoutpay" name="leave_earned" id="leave_earned">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leave_earned">Month</label>
                                        <select name="leave_earned" id="leave_earned" class="form-control form-control-border border-width-2" v-model="month" placeholder="Month">
                                            <option>January</option>
                                            <option>February</option>
                                            <option>March</option>
                                            <option>April</option>
                                            <option>May</option>
                                            <option>June</option>
                                            <option>July</option>
                                            <option>August</option>
                                            <option>September</option>
                                            <option>October</option>
                                            <option>November</option>
                                            <option>December</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leave_earned">Year</label>
                                        <input type="text" class="form-control form-control-border border-width-2" v-model="year" name="year" id="year">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="particulars">Particulars</label>
                                        <input type="text" class="form-control form-control-border border-width-2" v-model="form.particulars" name="particulars" id="particulars">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remarks">Remarks</label>
                                        <input type="text" class="form-control form-control-border border-width-2" v-model="form.remarks" name="remarks" id="remarks">
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
                                    <th rowspan="1" colspan="4">
                                        Vacation Leave
                                    </th>
                                    <th rowspan="1" colspan="4" >
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
                                    <td>{{ leave_card.sl_withpay }}</td>
                                    <td>{{ leave_card.sl_withoutpay }}</td>
                                    <td>{{ leave_card.sl_balance }}</td>
                                    <td>{{ leave_card.remarks }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="editLeaveSummary()">Edit <i class="fas fa-edit"></i></button>
                        <button type="submit" class="btn btn-primary float-right" data-toggle="modal" @click="generateleavecard()">Print <i class="fas fa-print"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal end -->

        <!-- modal -->

        <div class="modal fade" id="editSummary" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document" style="overflow-y: initial !important">
                <div class="modal-content" style="height: 90vh;">
                <div class="modal-header">
                    <div class="col-md-6">
                        <h5 class="modal-title" id="editSummary">Edit Leave Summary</h5>
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
                                    <th rowspan="1" colspan="4">
                                        Vacation Leave
                                    </th>
                                    <th rowspan="1" colspan="4" >
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
                                <tr v-for="(leave_card, index) in leave_cards" :key=leave_card.id>
                                    <td class='p-0'>
                                        <input type="text" class="form-control p-0" v-model="leave_card.period" style="border-radius: 0">
                                    </td>
                                    <td class='p-0'>
                                        <input type="text" class="form-control p-0" v-model="leave_card.particulars" style="border-radius: 0">
                                    </td>
                                    <td class='p-0'>
                                        <input type="text" class="form-control p-0" v-model="leave_card.vl_earned" style="border-radius: 0">
                                    </td>
                                    <td class='p-0'>
                                        <input type="text" class="form-control p-0" v-model="leave_card.vl_withpay" style="border-radius: 0">
                                    </td>
                                    <td class='p-0'>
                                        <input type="text" class="form-control p-0" v-model="leave_card.vl_withoutpay" style="border-radius: 0">
                                    </td>
                                    <td class='p-0'>
                                        <input type="text" class="form-control p-0" v-model="leave_card.vl_balance" style="border-radius: 0">
                                    </td>
                                    <td class='p-0'>
                                        <input type="text" class="form-control p-0" v-model="leave_card.sl_earned" style="border-radius: 0">
                                    </td>
                                    <td class='p-0'>
                                        <input type="text" class="form-control p-0" v-model="leave_card.sl_withpay" style="border-radius: 0">
                                    </td>
                                    <td class='p-0'>
                                        <input type="text" class="form-control p-0" v-model="leave_card.sl_withoutpay" style="border-radius: 0">
                                    </td>
                                    <td class='p-0'>
                                        <input type="text" class="form-control p-0" v-model="leave_card.sl_balance" style="border-radius: 0">
                                    </td>
                                    <td class='p-0'>
                                        <input type="text" class="form-control p-0" v-model="leave_card.remarks" style="border-radius: 0">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="calculate_summary()">Calculate</button>
                        <button type="submit" class="btn btn-primary float-right" data-toggle="modal" @click="submitEditSummary()">Save <i class="fas fa-save"></i></button>
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

        <div class="modal fade" id="slp_fl_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="overflow-y: initial !important">
                <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-6">
                        <h5 class="modal-title" id="summaryModal">Forced Leave and Special Leave Previliges credits</h5>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fl">Forced Leave</label>
                                    <input v-model="slp_fl.fl" type="text" class="form-control form-control-border border-width-2" name="fl" id="fl">
                                </div>
                                <div class="form-group">
                                    <label for="slp">Special Leave Previliges</label>
                                    <input v-model="slp_fl.slp" type="text" class="form-control form-control-border border-width-2" name="slp" id="slp">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary float-right" data-toggle="modal" @click="slp_fl_credits()">Save <i class="fas fa-save"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal end -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                mode: '',
                employees: [],
                employee_data: {},
                display: {
                    name: '',
                    vacation_leave: {balance: 0, year: 0},
                    sick_leave: {balance: 0, year: 0},
                    forced_leave: {balance: 0, year: 0},
                    special_leave_previliges: {balance: 0, year: 0}
                },
                display_year: '',
                leave_cards: [],
                leave_card_input: [],
                month: '',
                year: '',
                slp_fl: {id: '', slp: 0, fl: 0},
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

                this.display_year =  moment(new Date()).format('Y')

                this.display =  this.employee_data[this.form.personal_information_id] != '' &&
                                this.employee_data[this.form.personal_information_id] != null ?
                                Object.assign(this.display, this.employee_data[this.form.personal_information_id]) :
                                {
                                    name: '',
                                    vacation_leave: {balance: 0, year: 0},
                                    sick_leave: {balance: 0, year: 0},
                                    forced_leave: {balance: 0, year: 0},
                                    special_leave_previliges: {balance: 0, year: 0}
                                }

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
                    this.display =  this.employee_data[this.form.personal_information_id] != '' &&
                                this.employee_data[this.form.personal_information_id] != null ?
                                Object.assign(this.display, this.employee_data[this.form.personal_information_id]) :
                                {
                                    name: '',
                                    vacation_leave: {balance: 0, year: 0},
                                    sick_leave: {balance: 0, year: 0},
                                    forced_leave: {balance: 0, year: 0},
                                    special_leave_previliges: {balance: 0, year: 0}
                                }
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
                        'Please select an employee first',
                        'error'
                    )
                }

            },
            submit_leave_credits: function()
            {
                this.form.period = this.month+ ' ' +this.year

                this.$Progress.start()
                axios.post('api/leavecredits', this.form)
                .then(response => {

                    $('#balanceModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'Submitted'
                    });
                    this.getLeaveCredits()
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
                        this.leave_card_input = JSON.parse(JSON.stringify(data))
                        this.$Progress.finish()
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
            editLeaveSummary: function(){
                $('#summaryModal').modal('hide');
                $('#editSummary').modal('show')
            },
            submitEditSummary: function(){
                this.$Progress.start()
                axios.post('api/editleavesummary', this.leave_cards)
                .then(response => {
                    $('#editSummary').modal('hide')
                    this.getleavesummary()
                    $('#editSummary').modal('show')
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
            calculate_summary: function(){

                let result = 0

                let old_result = 0

                let type = ['vl', 'sl']

                type.forEach(type => {
                    for (let i = 0; i < this.leave_cards.length; i++) {

                        if(this.leave_cards[i][type+'_earned'] != this.leave_card_input[i][type+'_earned'] && this.leave_cards[i][type+'_withpay'] == this.leave_card_input[i][type+'_withpay'])
                        {

                                result = this.leave_cards[i][type+'_earned'] - this.leave_card_input[i][type+'_earned']

                                if(this.leave_cards[i][type+'_earned'] > this.leave_card_input[i][type+'_earned'])
                                {
                                    for (let x = i; x < this.leave_cards.length; x++) {
                                        this.leave_cards[x][type+'_balance'] =  this.leave_cards[x][type+'_balance'] + result
                                    }
                                }else{
                                    for (let x = i; x < this.leave_cards.length; x++) {
                                        this.leave_cards[x][type+'_balance'] =  this.leave_cards[x][type+'_balance'] - result
                                    }
                                }

                        }else if(this.leave_cards[i][type+'_withpay'] != this.leave_card_input[i][type+'_withpay'] && this.leave_cards[i][type+'_earned'] == this.leave_card_input[i][type+'_earned']){

                                result = this.leave_cards[i][type+'_withpay'] - this.leave_card_input[i][type+'_withpay']

                                if(this.leave_cards[i][type+'_withpay'] < this.leave_card_input[i][type+'_withpay'])
                                {
                                    for (let x = i; x < this.leave_cards.length; x++) {
                                        this.leave_cards[x][type+'_balance'] =  this.leave_cards[x][type+'_balance'] + result
                                    }
                                }else{
                                    for (let x = i; x < this.leave_cards.length; x++) {
                                        this.leave_cards[x][type+'_balance'] =  this.leave_cards[x][type+'_balance'] - result
                                    }
                                }

                        }else if(this.leave_cards[i][type+'_withpay'] != this.leave_card_input[i][type+'_withpay'] && this.leave_cards[i][type+'_earned'] != this.leave_card_input[i][type+'_earned']){

                                result = this.leave_cards[i][type+'_earned'] - this.leave_cards[i][type+'_withpay']


                                for (let x = i; x < this.leave_cards.length; x++) {
                                    if(x == 0)
                                    {
                                        this.leave_cards[x][type+'_balance'] = result
                                    }else{
                                        this.leave_cards[x][type+'_balance'] = (this.leave_cards[x][type+'_earned'] - this.leave_cards[x][type+'_withpay']) +  this.leave_cards[x-1][type+'_balance']
                                    }
                                }

                        }

                    }
                })


            },
            reset: function()
            {
                this.leave_cards = this.leave_card_input
            },
            slp_fl_modal: function()
            {
                if(this.form.personal_information_id != '' && this.form.personal_information_id != null)
                {
                    this.slp_fl.fl = this.display.forced_leave.balance
                    this.slp_fl.slp = this.display.special_leave_previliges.balance
                    $('#slp_fl_modal').modal('show')
                }else{
                    Swal.fire(
                        'Oops...',
                        'Please select an employee first',
                        'error'
                    )
                }
            },
            slp_fl_credits: function()
            {

                if(this.form.personal_information_id != null && this.form.personal_information_id != '')
                {
                    Swal.fire({
                    title: 'Ooops...',
                    text: "Are you sure you want to add Forced Leave and Special Leave Previliges credits this year to this employee?",
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
                            this.slp_fl.id = this.form.personal_information_id
                            axios.post('api/slp_fl_leave', this.slp_fl)
                            .then(response => {
                                toast.fire({
                                    icon: 'success',
                                    title: 'Submitted'
                                });
                                $('#slp_fl_modal').modal('hide')
                                this.getLeaveCredits()
                            })
                            .catch(error => {
                                console.log(error)
                                Swal.fire(
                                    'Oops...',
                                    'Something went wrong',
                                    'error'
                                )
                            })
                        }
                    })
                }else{
                    Swal.fire(
                        'Oops...',
                        'Please select an employee first',
                        'error'
                    )
                }


            },
            global_credits: function()
            {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will add leave credits for this month to all employees",
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
                        Swal.fire({
                        title: 'Dont reload or close the application ...',
                        willOpen () {
                            Swal.showLoading ()
                        },
                        didClose () {
                            Swal.hideLoading()
                        },
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        showConfirmButton: false
                        })

                        axios.post('api/global_credits')
                        .then(response => {
                            Swal.close()
                            Swal.fire(
                                'Done!',
                                'Process Finished!',
                                'success'
                            )
                        })
                        .catch(error => {
                            console.log(error)
                            Swal.close()
                            Swal.fire(
                                    'Oopss ...',
                                    'Something went wrong',
                                    'error'
                                )
                        })
                    }
                })

            }
        },
        mounted() {
            console.log('Component mounted.')
            this.getEmployees()
            this.getLeaveCredits()
        }
    }
</script>
