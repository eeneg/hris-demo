
<template>
    <div class="row justify-content-center" style="min-height: 100vh;">
        <div class="col-md-12 text-center" v-if="$gate.isEmployee()">
            <not-authorized></not-authorized>
        </div>
        <div v-else class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">

                    <div class="row mt-1">
                        <div class="col-md-6">
                            <h2>Leave Credits</h2>
                            <small style="margin-left: 2px;">Employee Leave Credit</small>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <div class="row mt-1">
                        <div class="col-md-5">
                            <v-select @input="get_leave_info(false)" class="form-control form-control-border border-width-2" v-model.lazy="selected_employee" placeholder="Select Employee" :options="employees" label="name"
                            :reduce="employees => employees"></v-select>
                        </div>
                        <div class="col-md-7">
                            <div class="float-right" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-info" :disabled="selected_employee == null" @click="scroll_bottom">Bottom <i class="fas fa-arrow-down"></i></button>
                                <button type="button" class="btn btn-warning" :disabled="selected_employee == null" @click="print_leave_card"><i class="fas fa-print"></i> Print</button>
                                <button type="button" class="btn btn-primary" :disabled="selected_employee == null" @click="[edit_mode = true, edited = true]"><i class="fas fa-edit"></i> Edit</button>
                                <button type="button" class="btn btn-success" :disabled="edit_mode == false" @click="check_input()"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
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
                                    Retirement Date: {{ selected_employee.retirement_date }} <button v-if="selected_employee.id !== null"  type="button" @click="retirement_date_modal()" class="btn p-0"><i class="fas fa-edit"></i></button><br>
                                    Status: {{ selected_employee.status }} <button v-if="selected_employee.id !== null" @click="status_modal()" type="button" class="btn p-0"><i class="fas fa-edit"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <input type="number" name="year" id="year" placeholder="Input Year" v-model="year" class="form-control">
                        </div>
                    </div>

                    <div class="row mt-1" v-if="selected_employee !== null">
                        <div class="col-md-4 p-2">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col">Leave Title</th>
                                    <th scope="col">Credit Balance</th>
                                    <!-- <th scope="col">Anticipated Balance</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in leave_credit" :key="data.id">
                                        <td>{{ data.title }}</td>
                                        <td>{{ data.balance }}</td>
                                        <!-- <td v-if="data.anticipated != null">{{ data.anticipated }}</td>
                                        <td v-if="data.anticipated == null"><a type="button" data-toggle="modal" data-target="#infomodal"><u>Click</u></a></td> -->
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
                                    <tr v-for="(data, index) in custom_leave[year]" :key="data.id">
                                        <td>{{ index }}</td>
                                        <td>{{ data }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4 p-2">
                            <table class="table table-sm table-bordered" style="display:block; overflow-y: auto; max-height: 120px;">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 30%;">Month</th>
                                        <th scope="col" style="width: 15%;">Tardy</th>
                                        <th scope="col" style="width: 15%;">Undertime</th>
                                        <th scope="col" style="width: 15%;">UA</th>
                                        <th scope="col" style="width: 15%;">AWOL</th>
                                        <th scope="col" style="width: 15%;">VLWOP</th>
                                        <th scope="col" style="width: 15%;">SLWOP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in tardy[year]" :key="data.id">
                                        <td>{{ index }}</td>
                                        <td>
                                            {{ data.Tardy }}
                                        </td>
                                         <td>
                                            {{ data.Undertime }}
                                        </td>
                                         <td>
                                            {{ data.UA }}
                                        </td>
                                         <td>
                                            {{ data.AWOL }}
                                        </td>
                                        <td>
                                            {{ data.VLWOP }}
                                        </td>
                                        <td>
                                            {{ data.SLWOP }}
                                        </td>
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
                                        <th rowspan="2" colspan="1" >
                                            FT
                                        </th>
                                        <th rowspan="2" colspan="1" v-if="edit_mode">Action</th>
                                    </tr>
                                    <tr>
                                        <th>EARNED</th>
                                        <th>Absence undertime w/ pay</th>
                                        <th class="text-success">BALANCE</th>
                                        <th class="text-danger">Absence undertime w/o pay</th>
                                        <th>EARNED</th>
                                        <th>Absence undertime w/ pay</th>
                                        <th class="text-success">BALANCE</th>
                                        <th class="text-danger">Absence undertime w/o pay</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr :class="{'border border-success': data.newly_added}" v-for="(data, index) in leave_summary" :key="data.id" style="width: 100%;">
                                        <td class="p-0">
                                            <input
                                                class="form-control p-0 text-center"
                                                type="text"
                                                :value="index+1"
                                                style="width: 33px;"
                                                disabled
                                            >
                                        </td>
                                        <td class='p-0' v-bind:class="{'border border-danger': leave_summary[index].period == null || leave_summary[index].period.mode == null}">

                                            <input
                                                :disabled="edit_mode == false"
                                                class="form-control p-0"
                                                v-on:focus="period_input(index)"
                                                type="text"
                                                id="period"
                                                :value="format_period(leave_summary[index].period)"
                                                style="border-radius: 0; min-width: 200px;"
                                                required
                                            >

                                        </td>
                                        <td class='p-0'>
                                            <input
                                                :disabled="edit_mode == false"
                                                v-on:focus="particulars_input(index, false)"
                                                class="form-control p-0" id="particulars"
                                                :value="format_particulars(leave_summary[index].particulars)"
                                                style="border-radius: 0; min-width: 150px;"
                                            >
                                        </td>
                                        <td class='p-0'>
                                            <input
                                                type="number"
                                                :disabled="edit_mode == false"
                                                class="form-control p-0"
                                                v-on:keyup.enter="press_enter(index, 'vl_earned', 'vl', $event)"
                                                v-on:blur="calculate_balance(index, 'vl_earned', 'vl')"
                                                v-on:focus="save_old_value(index, 'vl_earned')"
                                                id="vl_earned"
                                                v-model.lazy="leave_summary[index].vl_earned"
                                                style="border-radius: 0"
                                            >
                                        </td>
                                        <td class='p-0'>
                                            <input
                                                type="number"
                                                :disabled="edit_mode == false"
                                                class="form-control p-0"
                                                v-on:keyup.enter="press_enter(index, 'vl_withpay', 'vl',$event)"
                                                v-on:blur="calculate_balance(index, 'vl_withpay', 'vl')"
                                                v-on:focus="save_old_value(index, 'vl_withpay')"
                                                id="vl_withpay"
                                                v-model.lazy="leave_summary[index].vl_withpay"
                                                style="border-radius: 0"
                                            >
                                        </td>
                                        <td class='p-0'>
                                            <input
                                                type="number"
                                                class="form-control p-0"
                                                id="vl_balance"
                                                v-model.lazy="leave_summary[index].vl_balance"
                                                style="border-radius: 0"
                                                disabled
                                            >
                                        </td>
                                        <td class='p-0'>
                                            <input
                                                type="number"
                                                :disabled="edit_mode == false"
                                                class="form-control p-0"
                                                id="vl_withoutpay"
                                                v-model.lazy="leave_summary[index].vl_withoutpay"
                                                style="border-radius: 0"
                                            >
                                        </td>
                                        <td class='p-0'>
                                            <input
                                                type="number"
                                                :disabled="edit_mode == false"
                                                class="form-control p-0"
                                                v-on:keyup.enter="press_enter(index, 'sl_earned', 'sl',$event)"
                                                v-on:blur="calculate_balance(index, 'sl_earned', 'sl')"
                                                v-on:focus="save_old_value(index, 'sl_earned')"
                                                id="sl_earned"
                                                v-model.lazy="leave_summary[index].sl_earned"
                                                style="border-radius: 0"
                                            >
                                        </td>
                                        <td class='p-0'>
                                            <input
                                                type="number"
                                                :disabled="edit_mode == false"
                                                class="form-control p-0"
                                                v-on:keyup.enter="press_enter(index, 'sl_withpay', 'sl',$event)"
                                                v-on:blur="calculate_balance(index, 'sl_withpay', 'sl')"
                                                v-on:focus="save_old_value(index, 'sl_withpay')"
                                                id="sl_withpay"
                                                v-model.lazy="leave_summary[index].sl_withpay"
                                                style="border-radius: 0"
                                            >
                                        </td>
                                        <td class='p-0'>
                                            <input
                                                type="number"
                                                class="form-control p-0"
                                                id="sl_balance"
                                                v-model.lazy="leave_summary[index].sl_balance"
                                                style="border-radius: 0"
                                                disabled
                                            >
                                        </td>
                                        <td class='p-0'>
                                            <input
                                                type="number"
                                                :disabled="edit_mode == false"
                                                class="form-control p-0"
                                                id="psl_withoutpayeriod"
                                                v-model.lazy="leave_summary[index].sl_withoutpay"
                                                style="border-radius: 0"
                                            >
                                        </td>
                                        <td class='p-0'>
                                            <input
                                                :disabled="edit_mode == false"
                                                class="form-control p-0"
                                                id="remarks"
                                                v-model.lazy="leave_summary[index].remarks"
                                                style="border-radius: 0; min-width: 200px;"
                                            >
                                        </td>
                                        <td class='p-0 border' style="vertical-align: middle; width: 3px;">
                                            <input
                                                type="checkbox"
                                                :disabled="edit_mode == false"
                                                class="p-0"
                                                id="foreign_travel"
                                                v-model.lazy="leave_summary[index].foreign_travel"
                                            >
                                        </td>
                                        <td class='p-0' v-if="edit_mode">
                                            <div class="" style="display:inline-flex">
                                                <button
                                                    type="button"
                                                    class="btn d-inline btn-primary"
                                                    style="border-radius: 0"
                                                    @click="add_leave_data(index)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn d-inline btn-danger"
                                                    style="border-radius: 0"
                                                    @click="delete_leave_data(index)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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

        <!-- info modal -->

        <div class="modal fade" id="infomodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Error!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3 class="text-danger">Unable to calculate Anticipated Credits</h3>
                            <h6>Please input similar data below at the appropriate index</h6>
                        </div>
                        <div class="col-md-12">
					        <img style="max-width: 100%; max-height: 100%;" :src="'/storage/leave_image/leave.png'" alt="Leave">
                        </div>
                        <div class="col-md-12 mt-3">
                            <ul>
                                <li>Period must be the month of <b>December</b> last year</li>
                                <li>Credits Earned must <b>not be empty</b></li>
                                <li>There must be <b>no deductions</b></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>

        <!-- !info modal -->

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
                            <select v-model.lazy="options" @change="clear" class="custom-select" id="inputGroupSelect01">
                                <option selected>Choose...</option>
                                <option value="1">Single Date</option>
                                <option value="2">Consecutive Dates</option>
                                <option value="3">Non-Consecutive Dates</option>
                                <option value="4">Month</option>
                            </select>
                        </div>

                        <div class="col-md-12 p-2" v-if="options == 1">
                            <label for="leave_type">Single Date</label>
                            <input type="date" v-model.lazy="period_date" class="form-control">
                        </div>
                        <div class="col-md-12 p-2" v-if="options == 2">
                            <label for="leave_type">Date Range</label>
                            <v-date-picker v-model.lazy="range" is-range>
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
                                <v-date-picker v-model.lazy="selected.date">
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
                            <input type="month" v-model.lazy="period_month" class="form-control">
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
                            <select :disabled="edit_mode == false" v-model.lazy="particulars.leave_type" class="form-control" id="leave_type">
                                <option v-for="data in leave_types" :key="data.id" :value="data.abbreviation">{{data.title}}</option>
                                <option value="Undertime">Undertime</option>
                                <option value="Tardy">Tardy</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12" v-if="particulars.leave_type == 'Tardy' || particulars.leave_type == 'Undertime' || particulars.leave_type == 'AWOL' ||
                        particulars.leave_type == 'UA' || particulars.leave_type == 'VLWOP' || particulars.leave_type == 'SLWOP'">
                            <label for="days">Number of times</label>
                            <input type="number" v-model.lazy="particulars.count" class="form-control" id="days" aria-describedby="emailHelp" placeholder="Enter">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="days">Days</label>
                            <input type="number" v-model.lazy="particulars.days" class="form-control" id="days" aria-describedby="emailHelp" placeholder="Enter Days">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="hours">Hours</label>
                            <input type="number" v-model.lazy="particulars.hours" class="form-control" id="hours" aria-describedby="emailHelp" placeholder="Enter Hours">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="minutes">Minutes</label>
                            <input type="number"  v-model.lazy="particulars.mins" class="form-control" id="minutes" aria-describedby="emailHelp" placeholder="Enter Minutes">
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

         <!-- Modal -->
        <div class="modal fade" id="retirementDate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Retirement Date</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 p-2">
                            <input type="date"  v-model.lazy="retirement_date" class="form-control" id="retirement_date">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="submit_edits(1)">Save changes</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 p-2">
                            <label for="leave_type">Status</label>
                            <select v-model.lazy="status" class="form-control" id="leave_type">
                                <option v-for="status in status_data" :key="status.id" :value="status.status">{{status.status}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="submit_edits(2)">Save changes</button>
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
                selected_employee: { id: null, name: null },
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
                retirement_date: null,
                status: null,
                status_data: [],
                year: moment().year()
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

                Swal.fire({
                    title: '<strong>LOADING...</strong>',
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

                        this.$Progress.finish()

                        if(data.length == 0 && this.selected_employee.id !== null)
                        {
                            this.add_leave_data(-1)
                        }

                        Swal.close()
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
                        this.dates = this.dates.filter(e => e.date !== null );
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

            check_input: _.debounce(function()
            {
                this.leave_summary.map((e) => {

                    if(e.period == null || e.period.mode == null || e.period.mode == '')
                    {
                        this.validation = false
                    }

                })

                if(this.validation)
                {
                    this.submit_leave(false)
                }else{
                    toast.fire({
                        icon:'error',
                        title: 'Period Empty'
                    })
                }
            }, 100),

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

                if(this.leave_summary.length != 0)
                {
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
                }else{
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
                }

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

            retirement_date_modal: function()
            {
                this.retirement_date = null
                $('#retirementDate').modal('show')
            },

            status_modal: function()
            {
                this.status = null
                $('#statusModal').modal('show')
            },


            submit_edits: function(mode)
            {

                var data = mode == 1 ? data = this.retirement_date : data = this.status

                Swal.fire({
                    title: '<strong>LOADING...</strong>',
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

                axios.patch('api/editPersonalInfo', {id: this.selected_employee.id, data: data, mode: mode})
                .then(response => {
                    Swal.close()
                    $('#retirementDate').modal('hide')
                    $('#statusModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'Success'
                    });
                    mode == 1 ? this.selected_employee.retirement_date = this.retirement_date : this.selected_employee.status = this.status
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
            },

            period_input: function(index)
            {
                let data = this.leave_summary[index].period
                this.index = index

                if(data == null || data.mode == null && data.data == null)
                {
                    this.options = null
                    this.period_date = null
                    this.range = {
                            start: null,
                            end: null,
                        }
                    this.dates = []
                }else if(data != null && data.mode == 1){
                    this.options = 1
                    this.period_date = data.data
                }else if(data != null && data.mode == 2){
                    this.options = 2
                    this.range = data.data
                }else if(data != null && data.mode == 3){
                    this.options = 3
                    this.dates = data.data
                }else if(data != null && data.mode == 4){
                    this.options = 4
                    this.period_month = data.data
                }

                this.validation = true

                $("#periodModal").modal('show');
            },

            particulars_input: function(index)
            {
                $("#exampleModal").modal('show');
                this.index = index
                this.particulars = this.leave_summary[index].particulars ??
                {
                    leave_type: "",
                    days: null,
                    hours: null,
                    mins: null
                }
            },

            calculate_balance: _.debounce(function(index, field, leave_type)
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

            }, 100),


            press_enter(index, field, leave_type, event)
            {
                this.calculate_balance(index, field, leave_type)
                event.target.blur()
            },

            save_old_value(index, field)
            {
                this.input_history = this.leave_summary[index][field]
            },

            add_leave_data(index)
            {

                this.leave_summary.splice(index+1, 0, {
                    'personal_information_id': this.selected_employee.id,
                    'period': {
                        mode: null,
                        data: null
                    },
                    'particulars': {
                        leave_type: '',
                        count: null,
                        days: null,
                        hours: null,
                        mins: null
                    },
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

                this.check_balance(index)

            },

            check_balance(index){

                let prev_slbalance = 0

                let prev_vlbalance = 0

                if(this.leave_summary.length != 1)
                {
                    for(let x = index+1; x < this.leave_summary.length; x++)
                    {

                        if(this.leave_summary[x-1]['vl_balance'] == 0 || this.leave_summary[x-1]['vl_balance'] == null)
                        {
                            let index = x-1

                            do{
                                prev_vlbalance = this.leave_summary[index]['vl_balance']
                                index--
                            }while(prev_vlbalance == 0 || prev_vlbalance == null && index != -1)

                            if(this.leave_summary[x]['particulars']['leave_type'] != 'SPL')
                            {
                                this.leave_summary[x]['vl_balance'] = prev_vlbalance + this.leave_summary[x]['vl_earned'] - this.leave_summary[x]['vl_withpay']
                            }

                        }else{

                            if(this.leave_summary[x]['particulars']['leave_type'] != 'SPL')
                            {
                                this.leave_summary[x]['vl_balance'] = this.leave_summary[x-1]['vl_balance'] + this.leave_summary[x]['vl_earned'] - this.leave_summary[x]['vl_withpay']
                            }

                        }

                        if(this.leave_summary[x-1]['sl_balance'] == 0 || this.leave_summary[x-1]['sl_balance'] == null)
                        {
                            let index = x-1

                            do{
                                prev_slbalance = this.leave_summary[index]['sl_balance']
                                index--
                            }while(prev_slbalance == 0 || prev_slbalance == null && index != -1)

                            if(this.leave_summary[x]['particulars']['leave_type'] != 'SPL')
                            {
                                this.leave_summary[x]['sl_balance'] = prev_slbalance + this.leave_summary[x]['sl_balance'] - this.leave_summary[x]['vl_withpay']
                            }

                        }else{

                            if(this.leave_summary[x]['particulars']['leave_type'] != 'SPL')
                            {
                                this.leave_summary[x]['sl_balance'] = this.leave_summary[x-1]['sl_balance'] + this.leave_summary[x]['vl_earned'] - this.leave_summary[x]['vl_withpay']
                            }

                        }
                        // this.formatNumber(this.leave_summary[x]['sl_balance'])
                    }
                }

            },

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

            format_particulars: function(particulars)
            {
                return particulars?  `${particulars?.leave_type == 'Tardy' ? 'T' :  particulars?.leave_type == 'Undertime' ? 'UT' : particulars?.leave_type == null ? '' : particulars?.leave_type}${particulars?.leave_type == 'Tardy' || particulars?.leave_type == 'Undertime' || particulars?.leave_type == 'UA' || particulars?.leave_type == 'AWOL' ? particulars?.count+'x' : ''} ${particulars?.days ?? 0}-${particulars?.hours ?? 0}-${particulars?.mins ?? 0}` : '';
            },

            format_period: function(data)
            {
                if(data != null)
                {
                    if(data.mode == 1){
                        return moment(data.data).format("MMM DD, YYYY")
                    }else if(data.mode == 2){
                        return moment(data.data.start).format("MMM DD, YYYY") + ' to ' +  moment(data.data.end).format("MMM DD, YYYY")

                    }else if(data.mode == 3){

                        let dates = data.data
                            .filter(function(el){
                                return el.date != null
                            })
                            .map(e => moment(e.date).format('YYYY-MM-DD'))
                            .sort()
                            .map(function (date) {
                                return {
                                    month: moment(date).format('YYYY-MM'),
                                    date: moment(date).format('DD')
                                }
                            })

                        let formatted = _.map(_.groupBy(dates, 'month'), function (dates) {
                            return moment(_.head(dates).month).format('MMM') + ' ' + dates.map(e => e.date).join(',') + ' ' + moment(_.head(dates).month).format('YYYY')
                        })

                        return formatted.join(' — ')
                    }else if(data.mode == 4){
                        return moment(data.data).format('MMMM YYYY')
                    }
                }
            },

            get_status: function()
            {
                axios.get('api/status')
                .then(({data}) => {
                    this.status_data = data
                })
                .catch(e => {
                    console.log(e)
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.get_employees()
            this.get_leave_types()
            this.get_status()
        }
    }
</script>
