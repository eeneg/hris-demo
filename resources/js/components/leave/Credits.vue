
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
                                <button type="button" class="btn btn-info" :disabled="selected_employee == null" @click="view_awol">AWOL/UA <i class="fas fa-calendar"></i></button>
                                <button type="button" class="btn btn-warning" :disabled="selected_employee == null" @click="print_leave_card"><i class="fas fa-print"></i> Print</button>
                                <button type="button" class="btn btn-primary" :disabled="selected_employee == null" @click="[edit_mode = true, edited = true]"><i class="fas fa-edit"></i> Edit</button>
                                <button type="button" class="btn btn-success" :disabled="edit_mode == false" @click="check_input()"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row p-0">
                                <div class="col-md-4">
                                    Name: {{ selected_employee.name }} <br>
                                    Birth Date: {{ selected_employee.birthdate }} <br>
                                    Civil Status: {{ selected_employee.civilstatus }} <br>
                                </div>
                                <div class="col-md-4">
                                    Office: {{ position.title ?? '' }}<br>
                                    Position: {{ dept.address ?? '' }}<br>
                                    Salary Grade: {{ salary.grade ?? '' }}<br>
                                </div>
                                <div class="col-md-4">
                                    Date Hired: <br>
                                    Retirement Date: {{ calculate_retirement_date(selected_employee.birthdate) }} <br>
                                    Status:
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1" v-if="selected_employee !== null">
                        <div class="col-md-4 p-2">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col">Leave Title</th>
                                    <th scope="col">Credit Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in leave_credit" :key="data.id">
                                        <td>{{ data.title }}</td>
                                        <td>{{ data.balance }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4 mt-2 p-0 border" style="display:block; overflow-y: auto; max-height: 120px;">
                            <table class="table table-sm table-bordered p-0">
                                <thead>
                                    <tr>
                                        <th>Leave this Year</th>
                                        <th>Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in custom_leave.leave" :key="data.id">
                                        <td>{{ index }}</td>
                                        <td>{{ data }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4 p-2">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Month</th>
                                        <th scope="col">Tardy & Undertime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in tardy" :key="data.id">
                                        <td>{{ format_tardy(index) }}</td>
                                        <td><p class="p-0 m-0" style="display:inline-table" v-for="(tardy, index) in data" :key="tardy.id">{{ index + ' ' + tardy + ', ' }}</p></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-md-12 tableFixHead" ref="credit_table">
                            <credits-table
                                :leave_summary="leave_summary"
                                :selected_employee="selected_employee"
                                :edit_mode="edit_mode"
                                @period_input="index = $event"
                                @particulars_input="index = $event"
                            >
                            </credits-table>
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
                            <select v-model="options" @change="clear" class="custom-select" id="inputGroupSelect01">
                                <option selected>Choose...</option>
                                <option value="1">Single Date</option>
                                <option value="2">Consecutive Dates</option>
                                <option value="3">Non-Consecutive Dates</option>
                                <option value="4">Month</option>
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
                                            :key="i"
                                            class="flex btn btn-info items-center bg-indigo-100 hover:bg-indigo-200 text-sm text-indigo-600 font-semibold h-8 px-2 m-1 rounded-lg border-2 border-transparent focus:border-indigo-600 focus:outline-none"
                                            style=""
                                            @click.stop="dateSelected($event, date, togglePopover)"
                                            ref="button"
                                        >
                                            {{ format_date(date?.date) }}
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
                        <div class="col-md-12 p-2" v-if="options == 4">
                            <label for="leave_type">Month</label>
                            <input type="month" v-model="period_month" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <p v-if="period_validation == false" v-bind:class="{'text-danger': period_validation == false}">Input Required</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="validate_period()">Save changes</button>
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
                                <option selected>Choose...</option>
                                <option v-for="data in leave_types" :key="data.id" :value="data.abbreviation">{{data.title}}</option>
                                <option value="Undertime">Undertime</option>
                                <option value="Tardy">Tardy</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12" v-if="particulars.leave_type == 'Tardy' || particulars.leave_type == 'Undertime' || particulars.leave_type == 'AWOL' ||
                        particulars.leave_type == 'UA'">
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

        <!-- modal -->
        <div class="modal fade" id="awolModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">AWOL and UA {{ get_year() }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 p-2">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Month</th>
                                        <th scope="col">Tardy & Undertime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in sortAwol" :key="data.id">
                                        <td>{{ format_tardy(index) }}</td>
                                        <td>
                                            <p class="p-0 m-0" style="display:inline-table" v-for="(value, index) in data" :key="value.id">{{ '&nbsp' + index + ' ' + value + ', ' }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
import moment from 'moment'
import CreditsTable from './CreditsTable.vue'
    export default {
        data() {
            return {
                prev_month: moment().subtract(1, "month").format("MMMM"),
                current_month: moment().format("MMMM"),
                selected_employee: {},
                selected_summary: [],
                edit_mode: false,
                edited: false,
                employees: [],
                leave_credit: [],
                leave_summary: [],
                leave_types: [],
                validation: true,
                period_validation: true,
                custom_leave: [],
                tardy: [],
                position: {},
                dept: {},
                salary: {},
                particulars: {
                    leave_type: null,
                    count: null,
                    days: null,
                    hours: null,
                    mins: null
                },
                index: null,
                period_date: null,
                period_month: null,
                range: {
                    start: null,
                    end: null,
                },
                dates:[],
                selected: {},
                options: null,
                awol: {}
            }
        },
        components: {
            CreditsTable
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
            sortAwol: function () {
                return this.awol
            }
        },
        watch: {

        },
        methods: {

            calculate_retirement_date: function(data)
            {
                return data == null ? '' : moment(data).add(60, 'years').format('YYYY-MM-DD')
            },

            format_tardy: function (date) {
                return moment(date).format('MMMM');
            },

            format_date(date)
            {
                return moment(date).format("YYYY/MM/DD")
            },

            get_year()
            {
                return moment().format('YYYY')
            },

            clear()
            {
                if(this.options == 1)
                {
                    this.range = {
                        start: null,
                        end: null,
                    }
                    this.dates = []
                }else if(this.options == 2)
                {
                    this.period_date = null
                    this.dates = []
                    this.selected = []
                }else if(this.options == 3){
                    this.period_date = null
                    this.range = {
                        start: null,
                        end: null,
                    }
                }
            },

            view_awol: function()
            {
                $('#awolModal').modal('show')
            },

            addDate() {
                let date = moment().format("YYYY/MM/DD")

                this.dates.push({
                    date: date,
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

                        this.tardy = data.tardy

                        this.position = data.position ?? {}

                        this.dept = data.position.department ?? {}

                        this.salary = data.salary ?? {}

                        this.awol = data.awol

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

            validate_period: function()
            {
                if(this.options == 1)
                {
                   if(this.period_date == null || this.period_date == '')
                   {
                        this.period_validation = false
                   }else{
                        this.populate_period()
                        this.period_validation = true
                   }
                }else if(this.options == 2){

                    if(this.range.start == null || this.range.end == null)
                    {
                        this.period_validation = false
                    }else{
                        this.populate_period()
                        this.period_validation = true
                    }

                }else if(this.options == 3){

                    if(this.dates.length == 0)
                    {
                        this.period_validation = false
                    }else{
                        this.populate_period()
                        this.period_validation = true
                    }

                }else if(this.options == 4){

                    if(this.period_month == null){
                        this.period_validation = false
                    }else{
                        this.populate_period()
                        this.period_validation = true
                    }

                }
            },

            populate_period: function()
            {
                console.log(this.index)

                let period = null

                if(this.options == 1)
                {
                    period = this.period_date
                }else if(this.options == 2){
                    period = this.range
                }else if(this.options == 3){
                    period = this.dates
                }else if(this.options == 4){
                    period = this.period_month
                }

                this.leave_summary[this.index].period = {mode: this.options, data: period}

                this.options = null
                this.period_date = null
                this.range = {
                    start: null,
                    end: null,
                }
                this.period_month = null

                this.period_validation = true
                $("#periodModal").modal('hide');
            },

            populate_particulars: function()
            {
                this.leave_summary[this.index].particulars = this.particulars
                $("#exampleModal").modal('hide');
            },

            get_leave_types: function(){

                this.$Progress.start()
                axios.get('api/getleavetypes')
                .then(({data}) => {

                    this.leave_types = data

                    this.$Progress.finish()

                })
                .catch(e => {
                    console.log(e)
                })

            },

            check_input: function()
            {
                // this.leave_summary.map((e) => {

                //     if(e.period == null || e.period.mode == null || e.period.mode == '')
                //     {
                //         this.validation = false
                //     }

                // })

                // if(this.validation)
                // {
                //     this.submit_leave(false)
                // }else{
                //     toast.fire({
                //         icon:'error',
                //         title: 'Period Empty'
                //     })
                // }
                this.submit_leave(false)
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
                    this.validation = true
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
