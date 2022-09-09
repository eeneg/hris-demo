
<template>
    <div class="row justify-content-center" style="min-height: 100vh;">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">

                    <div class="row mt-1">
                        <div class="col-md-6">
                            <h2>Leave Credits</h2>
                            <small style="margin-left: 2px;">Subtitle Subtitle Subtitle Subtitle Subtitle Subtitle</small>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <div class="row mt-1">
                        <div class="col-md-5">
                            <v-select @input="get_leave_info(false)" class="form-control form-control-border border-width-2" v-model="selected_employee" placeholder="Select Employee" :options="employees" label="name"
                            :reduce="employees => employees"></v-select>
                        </div>
                        <div class="col-md-7">
                            <div class="float-right" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-info" :disabled="selected_employee == null" @click="scroll_bottom">Scroll <i class="fas fa-arrow-down"></i></button>
                                <button type="button" class="btn btn-warning" :disabled="selected_employee == null" @click="print_leave_card"><i class="fas fa-print"></i> Print</button>
                                <button type="button" class="btn btn-primary" :disabled="selected_employee == null" @click="[edit_mode = true, edited = true]"><i class="fas fa-edit"></i> Edit</button>
                                <button type="button" class="btn btn-success" :disabled="edit_mode == false" @click="check_input()"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1" v-if="selected_employee !== null">
                        <div class="col-md-6 p-2">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Leave Title</th>
                                    <th scope="col">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in leave_credit" :key="data.id">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ data.title }}</td>
                                        <td>{{ data.balance }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 p-2">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Leave</th>
                                        <th scope="col">Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in custom_leave" :key="data.id">
                                        <td>{{ index }}</td>
                                        <td>{{ data }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-md-12 tableFixHead" ref="credit_table">
                            <table class="table table-borderless text-center" v-if="selected_employee !== null">
                                <thead>
                                    <tr>
                                        <th rowspan="2" colspan="1">#</th>
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
                                        <th rowspan="2" colspan="1" v-if="edit_mode">Action</th>
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
                                    <tr :class="{'border border-success': data.newly_added}" v-for="(data, index) in leave_summary" :key="data.id" style="width: 100%;">
                                        <td class="p-0"><input class="form-control p-0 text-center" type="text" :value="index+1" style="width: 33px;" disabled></td>
                                        <td class='p-0' v-bind:class="{'border border-danger': leave_summary[index].particulars != null && leave_summary[index].period == null}">
                                            <input :disabled="edit_mode == false" class="form-control p-0" v-on:focus="period_input()" type="text" id="period" v-model="leave_summary[index].period" style="border-radius: 0;" required>
                                        </td>
                                        <td class='p-0'>
                                            <input :disabled="edit_mode == false" v-on:focus="particulars_input(index, false)" class="form-control p-0" id="particulars" :value="format_particulars(leave_summary[index].particulars)" style="border-radius: 0">
                                        </td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" v-on:keyup.enter="press_enter(index, 'vl_earned', 'vl', $event)" v-on:blur="calculate_balance(index, 'vl_earned', 'vl')" v-on:focus="save_old_value(index, 'vl_earned')" id="vl_earned" v-model="leave_summary[index].vl_earned" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" v-on:keyup.enter="press_enter(index, 'vl_withpay', 'vl',$event)" v-on:blur="calculate_balance(index, 'vl_withpay', 'vl')" v-on:focus="save_old_value(index, 'vl_withpay')" id="vl_withpay" v-model="leave_summary[index].vl_withpay" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" id="vl_withoutpay" v-model="leave_summary[index].vl_withoutpay" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" id="vl_balance" v-model="leave_summary[index].vl_balance" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" v-on:keyup.enter="press_enter(index, 'sl_earned', 'sl',$event)" v-on:blur="calculate_balance(index, 'sl_earned', 'sl')" v-on:focus="save_old_value(index, 'sl_earned')" id="sl_earned" v-model="leave_summary[index].sl_earned" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" v-on:keyup.enter="press_enter(index, 'sl_withpay', 'sl',$event)" v-on:blur="calculate_balance(index, 'sl_withpay', 'sl')" v-on:focus="save_old_value(index, 'sl_withpay')" id="sl_withpay" v-model="leave_summary[index].sl_withpay" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" id="psl_withoutpayeriod" v-model="leave_summary[index].sl_withoutpay" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" id="sl_balance" v-model="leave_summary[index].sl_balance" style="border-radius: 0"></td>
                                        <td class='p-0'><input :disabled="edit_mode == false" class="form-control p-0" id="remarks" v-model="leave_summary[index].remarks" style="border-radius: 0"></td>
                                        <td class='p-0' v-if="edit_mode">
                                            <div class="" style="display:inline-flex">
                                                <button type="button" class="btn d-inline btn-primary" style="border-radius: 0" @click="add_leave_data(index)"><i class="fas fa-plus"></i></button>
                                                <button type="button" class="btn d-inline btn-danger" style="border-radius: 0" @click="delete_leave_data(index)"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="periodModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Period</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class=" col-md-12 p-2 input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Options</label>
                            </div>
                            <select v-model="options" class="custom-select" id="inputGroupSelect01">
                                <option selected>Choose...</option>
                                <option value="1">Single Date</option>
                                <option value="2">Consecutive Dates</option>
                                <option value="3">Non-Consecutive Dates</option>
                            </select>
                        </div>

                        <div class="col-md-12 p-2" v-if="options == 1">
                            <label for="leave_type">Single Date</label>
                            <input type="date" v-model="period_date" class="form-control">
                        </div>
                        <div class="col-md-12 p-2" v-if="options == 2">
                            <label for="leave_type">Date Range</label>
                            <v-date-picker v-model="range" is-range>
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
                        </div>
                        <div class="col-md-12 p-2" v-if="options == 3">
                            <label for="">Multiple Non-consecutive Dates</label>
                            <div class="bg-white p-2 w-full border rounded">
                                <v-date-picker v-model="selected.date">
                                    <template #default="{ inputValue, togglePopover, hidePopover }">
                                        <div class="flex flex-wrap">
                                        <button
                                            v-if="date.date != null"
                                            v-for="(date, i) in dates"
                                            :key="date?.date?.getTime()"
                                            class="flex btn btn-info items-center bg-indigo-100 hover:bg-indigo-200 text-sm text-indigo-600 font-semibold h-8 px-2 m-1 rounded-lg border-2 border-transparent focus:border-indigo-600 focus:outline-none"
                                            style=""
                                            @click.stop="dateSelected($event, date, togglePopover)"
                                            ref="button"
                                        >
                                            {{ date?.date?.toLocaleDateString() }}
                                            <svg
                                                class="w-4 h-4 text-gray-600 hover:text-indigo-600 ml-1 -mr-1"
                                                style="height: 20px; width: 20px;"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                @click.stop="removeDate(date, hidePopover)"
                                            >
                                            <path d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                        </div>
                                    </template>
                                </v-date-picker>
                                <button
                                    class="btn btn-primary"
                                    @click.stop="addDate"
                                    >
                                    + Add Date
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Particulars</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 p-2">
                            <label for="leave_type">Custom</label>
                            <select :disabled="edit_mode == false" v-model="particulars.leave_type" class="form-control" id="leave_type">
                                <option v-for="data in leave_types" :key="data.id" :value="data.abbreviation">{{data.title}}</option>
                                <option value="Undertime">Undertime</option>
                                <option value="Tardy">Tardy</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12" v-if="particulars.leave_type == 'Tardy' || particulars.leave_type == 'Undertime'">
                            <label for="days">Number of times</label>
                            <input type="number" v-model="particulars.count" class="form-control" id="days" aria-describedby="emailHelp" placeholder="Enter">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="days">Days</label>
                            <input type="number" v-model="particulars.days" class="form-control" id="days" aria-describedby="emailHelp" placeholder="Enter Days">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="hours">Hours</label>
                            <input type="number" v-model="particulars.hours" class="form-control" id="hours" aria-describedby="emailHelp" placeholder="Enter Hours">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="minutes">Minutes</label>
                            <input type="number"  v-model="particulars.mins" class="form-control" id="minutes" aria-describedby="emailHelp" placeholder="Enter Minutes">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="populate_particulars">Save changes</button>
                </div>
                </div>
            </div>
        </div>

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

    </div>
</template>

<style>
    .tableFixHead {
        overflow-y: auto;
        max-height: 55vh;
    }
    .tableFixHead thead {
        position: sticky;
        top: 0;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        padding: 8px 16px;
        border: none;
    }
    th {
        background: #eee;
    }
</style>

<script>
import axios from 'axios'
    export default {
        data() {
            return {
                selected_employee: null,
                selected_summary: [],
                edit_mode: false,
                disable: true,
                edited: false,
                employees: [],
                leave_credit: [],
                leave_summary: [],
                form: [],
                leave_types: [],
                input_history: null,
                validation: false,
                running: false,
                custom_leave: [],
                particulars: {
                    leave_type: null,
                    count: null,
                    days: null,
                    hours: null,
                    mins: null
                },
                index: null,
                period_date: null,
                range: {
                    start: null,
                    end: null,
                },
                dates:[
                    {
                        date: null
                    }
                ],
                selected: {},
                options: null,
            }
        },
        components: {

        },
        beforeRouteLeave (to, from , next) {
            if(this.edited)
            {
                const answer = window.confirm('Do you really want to leave? you have unsaved changes!')
                if (answer) {
                    next()
                } else {
                    next(false)
                }
            }else{
                next()
            }
        },
        beforeRouteUpdate()
        {
            window.confirm('Do you really want to leave? you have unsaved changes!')
        },
        computed: {
            leave_summary_length: function()
            {
                return this.summary.length
            },
        },
        watch: {
            leave_summary: {
                handler: function(){
                    if(this.leave_summary.length == 0)
                    {
                        this.add_leave_data()
                    }
                },
                deep: true
            }
        },
        methods: {

            clear(type)
            {
                if(type == 1)
                {
                    this.range = {
                        start: null,
                        end: null,
                    }
                    this.dates = [
                        {
                            date:new Date()
                        }
                    ]
                }else if(type == 2)
                {
                    period_date = null,
                    dates = [
                        {
                            date:new Date()
                        }
                    ]
                }else if(type == 3){
                    period_date = null,
                    range = {
                        start: null,
                        end: null,
                    }
                }
            },

            addDate() {
                this.dates.push({
                    date: new Date(),
                });
                this.$nextTick(() => {
                    const btn = this.$refs.button[this.$refs.button.length - 1];
                    btn.click();
                });
            },

            removeDate(date, hide) {
                this.dates = this.dates.filter((d) => d !== date);
                hide();
            },

            dateSelected(e, date, toggle) {
                this.selected = date;
                toggle({ ref: e.target });
            },

            scroll_bottom()
            {
                var x = this.$refs.credit_table
                x.scrollTop = x.scrollHeight
            },

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

            get_employees: function(){

                axios.get('api/leavecredits')
                .then(({data}) => {
                    this.employees = data.data
                }).catch(e => {
                    console.log(e)
                })
            },

            get_leave_info: function(edit){

                if(this.selected_employee !== null)
                {
                    this.$Progress.start()
                    axios.get('api/leavecredits/'+this.selected_employee.id)
                    .then(({data}) => {

                        this.leave_summary = data.summary

                        this.leave_credit = data.credit

                        this.custom_leave = data.custom_leave

                        this.$Progress.finish()

                        if(data.length == 0 && this.selected_employee.id !== null)
                        {
                            this.add_leave_data(-1)
                        }
                    })
                    .catch(e => {
                        console.log(e)
                    })
                }

            },

            period_input: function(index)
            {
                this.index = index
                this.options = null
                $("#periodModal").modal('show');
            },

            populate_period: function()
            {
                // this.leave_summary[this.index]['period'] = this
            },

            particulars_input: function(index)
            {
                $("#exampleModal").modal('show');
                this.index = index
                this.particulars = this.leave_summary[index].particulars ??
                    {
                        leave_type: null,
                        days: null,
                        hours: null,
                        mins: null
                    }
            },

            populate_particulars: function()
            {
                this.leave_summary[this.index].particulars = this.particulars
                $("#exampleModal").modal('hide');
            },

            format_particulars: function(particulars)
            {
                return particulars?  `${particulars?.leave_type}${particulars?.leave_type == 'Tardy' || particulars?.leave_type == 'Undertime' ? particulars?.count+'x' : ''} ${particulars?.days ?? 0}-${particulars?.hours ?? 0}-${particulars?.mins ?? 0}` : '';
            },

            get_leave_types: function(){

                this.$Progress.start()
                axios.get('api/getleavetypes')
                .then(({data}) => {

                    this.leave_types = data.filter(function(e){
                        if(e.title != 'Sick Leave' && e.title != 'Vacation Leave')
                        {
                            return e
                        }
                    })

                    this.$Progress.finish()

                })
                .catch(e => {
                    console.log(e)
                })

            },

            check_input: function(index)
            {

                let validation = true

                this.leave_summary.map(function(e){

                    if(e.particulars != null && e.period == null)
                    {
                        validation = false
                    }

                })

                this.validation = validation

                if(this.validation == true)
                {
                    this.submit_leave(false)
                }else{
                    toast.fire({
                        icon:'error',
                        title: 'Period Empty'
                    })
                }


            },

            submit_leave: function(delete_save)
            {

                if(delete_save == false)
                {
                    Swal.fire({
                        title: '<strong>Saving...</strong>',
                        html: 'Dont <u>reload</u> or <u>close</u> the application ...',
                        icon: 'info',
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
                }

                for (let x = 0; x < this.leave_summary.length; x++) {
                    this.leave_summary[x].sort = x
                }

                axios.post('api/leavecredits', {data: this.leave_summary, id: this.selected_employee.id})
                .then(e => {
                    this.edited = false
                    this.get_leave_info(true)
                    if(delete_save == false)
                    {
                        Swal.close()
                    }
                    toast.fire({
                        icon:'success',
                        title: 'Saved'
                    })
                })
                .catch(e => {
                    console.log(e)
                })

            },

            formatNumber (num) {
                return parseFloat(num).toFixed(2)
            },

            add_leave_data(index)
            {

                this.leave_summary.splice(index+1, 0, {
                    'personal_information_id': this.selected_employee.id,
                    'particulars': '',
                    'period': '',
                    'custom_leave':'',
                    'vl_earned': 1.25,
                    'vl_withpay': 0,
                    'vl_balance': 1.25,
                    'vl_withoutpay': '',
                    'sl_earned': 1.25,
                    'sl_balance': 1.25,
                    'sl_withpay': 0,
                    'sl_withoutpay': '',
                    'remarks': '',
                    'sort': index+1,
                    'newly_added': true
                })

                if(this.leave_summary.length != 1)
                {
                    for(let x = index+1; x < this.leave_summary.length; x++)
                    {
                        this.leave_summary[x]['vl_balance'] = this.leave_summary[x-1]['vl_balance'] + this.leave_summary[x]['vl_earned'] - this.leave_summary[x]['vl_withpay']
                        this.leave_summary[x]['sl_balance'] = this.leave_summary[x-1]['sl_balance'] + this.leave_summary[x]['sl_earned'] - this.leave_summary[x]['sl_withpay']
                        this.formatNumber(this.leave_summary[x]['sl_balance'])
                    }
                }


            },

            calculate_balance: function(index, field, leave_type)
            {

                if(this.running == false)
                {
                    let data = this.leave_summary

                    let x = index

                    if(this.input_history != data[index][field])
                    {
                        for (let index = x; index < data.length; index++) {

                            this.leave_summary[index][leave_type + '_balance'] = 0
                            this.leave_summary[index][leave_type + '_balance'] = data[index][leave_type + '_earned'] - data[index][leave_type + '_withpay'] + (this.leave_summary[index][leave_type + '_balance'] + this.leave_summary[index != 0 ? index-1 : index][leave_type + '_balance'])

                        }

                        this.input_history = null
                    }

                    this.running = true
                }
            },


            press_enter(index, field, leave_type, event)
            {
                this.calculate_balance(index, field, leave_type)
                event.target.blur()

                console.log('1')
            },

            save_old_value(index, field)
            {
                this.running = false
                this.input_history = this.leave_summary[index][field]
            },

            delete_leave_data: _.debounce(function(index)
            {

                var id = this.leave_summary[index].id

                var length = this.leave_summary.length

                if(id)
                {
                    Swal.fire({
                    title: 'Delete and Save Leave Summary?',
                    text: "This is saved data!! You cannot revert this!!",
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

                            this.$Progress.start()

                            Swal.fire({
                                title: '<strong>Deleting...</strong>',
                                html: 'Dont <u>reload</u> or <u>close</u> the application ...',
                                icon: 'info',
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

                            this.decrease_balance(index)
                            axios.delete('api/leavecredits/'+this.leave_summary[index].id)
                            .then(e => {
                                this.leave_summary.splice(index, 1)
                                this.submit_leave(true)
                                this.$Progress.finish()
                                Swal.close()
                                toast.fire({
                                    icon: 'success',
                                    title: 'Deleted'
                                });
                            })
                            .catch(e => {
                                Swal.fire(
                                    'Oops...',
                                    'Failed to Delete Item',
                                    'error'
                                )
                                this.$Progress.finish()
                                console.log(e)
                            })

                        }
                    })
                }else{
                    this.decrease_balance(index)
                    this.leave_summary.splice(index, 1)
                }

            }, 300),

            decrease_balance: function(index)
            {

                let vl_balance = this.leave_summary[index]['vl_earned'] - this.leave_summary[index]['vl_withpay']

                let sl_balance = this.leave_summary[index]['sl_earned'] - this.leave_summary[index]['sl_withpay']

                for(let x = index; x < this.leave_summary.length; x++)
                {
                    this.leave_summary[x]['vl_balance'] = this.leave_summary[x]['vl_balance'] - vl_balance
                    this.leave_summary[x]['sl_balance'] = this.leave_summary[x]['sl_balance'] - sl_balance
                }



            },

            print_leave_card(){

                if(this.edited && this.leave_summary.length == 0)
                {
                    toast.fire({
                        icon: 'error',
                        title: 'Save Changes First'
                    })
                }else{
                    Swal.fire({
                        title: '<strong>Generating Leave Card</strong>',
                        html: 'Dont <u>reload</u> or <u>close</u> the application ...',
                        icon: 'info',
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

                    axios.post('generateleavecard', {id: this.selected_employee.id})
                    .then(response => {
                        let options = {
                            height: screen.height * 0.65 + 'px',
                            page: '1'
                        };
                        Swal.close()
                        $('#summaryModal').modal('hide');
                        $('#pdfModal').modal('show');
                        PDFObject.embed("/storage/employee_leave_card/" + response.data.title, "#pdf-viewer", options);
                    })
                    .catch(error => {
                        Swal.close()
                        Swal.fire(
                            'Failed',
                            'Something went wrong',
                            'warning'
                        )
                        console.log(error);
                    });
                }

            },

        },
        mounted() {
            console.log('Component mounted.')
            this.get_employees()
            this.get_leave_types()
        }
    }
</script>
