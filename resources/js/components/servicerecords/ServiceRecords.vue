<template>
    <div class="row justify-content-center">
        <div class="col-md-12 text-center" v-if="!$gate.isAdministrator() && !$gate.isAuthor()">
            <not-authorized></not-authorized>
        </div>
        <div v-else class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Employee Service Record</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <v-select class="form-control form-control-border border-width-2" @input="getRecord()" placeholder="Select Employee" v-model.lazy="record" :options="data" label="name"></v-select>
                                <span v-if="errors.personal_information_id">
                                    <p class="text-danger">Please select and employee</p>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-2 pt-3">
                            Date Retired: {{ record !== null ? record.retirement_date : '' }} <button v-if="record !== null" type="button" class="btn p-0" @click="retirementDateModal()"><i class="fas fa-edit"></i></button>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success float-right mr-2" :disabled="form.personal_information_id == null" @click="printRecord()">Print <i class="fas fa-print"></i></button>
                            <button type="submit" class="btn btn-primary float-right mr-2" :disabled="form.personal_information_id == null && record.service_record == null" @click="addModal()">Add <i class="fas fa-plus"></i></button>
                            <button type="submit" class="btn btn-warning float-right mr-2" :disabled="form.personal_information_id == null && record.service_record == null" @click="copyData">Copy <i class="fas fa-file"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card-body table-responsive border p-0" style="height: 400px;">
                            <table class="table table-striped text-nowrap custom-table text-center w-100">
                                <thead>
                                    <tr>
                                        <th colspan="1" class="border"></th>
                                        <th colspan="2" class="border">Service</th>
                                        <th colspan="3" class="border">Record of Appointment</th>
                                        <th colspan="2" class="border">Office Entity / Division</th>
                                        <th colspan="1" class="border">Leave of Absences</th>
                                        <th colspan="3" class="border">Separation</th>
                                        <th colspan="1" class="border"></th>
                                    </tr>
                                    <tr>
                                        <th class="border">#</th>
                                        <th class="border">From</th>
                                        <th class="border">To</th>
                                        <th class="border">Designation<br>(Positon)</th>
                                        <th class="border">Status</th>
                                        <th class="border">Salary (P.A.)</th>
                                        <th class="border">Station/ <br>Place Assignment</th>
                                        <th class="border">Branch</th>
                                        <th class="border">Absences w/o<br>Pay</th>
                                        <th class="border">Remarks</th>
                                        <th class="border">Date</th>
                                        <th class="border">Cause</th>
                                        <th class="border">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(record, index) in service_records">
                                        <td>{{index + 1}}</td>
                                        <td>{{ formatDate(record.from) }}</td>
                                        <td>{{ formatDate(record.to) }}</td>
                                        <td>{{ record.position }}</td>
                                        <td>{{ record.status }}</td>
                                        <td>{{ record.salary }}</td>
                                        <td>{{ record.station }}</td>
                                        <td>{{ record.branch }}</td>
                                        <td>{{ record.pay }}</td>
                                        <td>{{ record.remark }}</td>
                                        <td>{{ record.date }}</td>
                                        <td>{{ record.cause }}</td>
                                        <td>
                                            <button class="btn btn-primary" @click="editModal(record)"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger" @click="deleteEmployeeServiceRecord(record.id)"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 text-center" v-if="record !== null && form.personal_information_id == null">
                            <p class="text-danger p-0 m-0">Complete Information Below First</p>
                        </div>
                        <div class="col-md-12" :class="{'border border-danger p-2': record !== null && form.personal_information_id == null}" v-if="record">
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Certified Correct By:</label>
                                        <v-select class="form-control form-control-border border-width-2" v-model.lazy="form.certifier_id" placeholder="Select Employee" :options="data" label="name" :reduce="data => data.id"></v-select>
                                        <span v-if="errors.certifier_id">
                                            <p class="text-danger">Please select and employee</p>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dateCertified">Date Certified</label>
                                        <input type="date" class="form-control form-control-border border-width-2" v-model="form.dateCertified" id="dateCertified" placeholder="Password">
                                        <span v-if="errors.dateCertified">
                                            <p class="text-danger">Field Required</p>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="ORNo">O.R. Number</label>
                                        <input type="text" class="form-control form-control-border border-width-2" v-model="form.ORNo" id="ORNo" placeholder="Enter O.R. Number">
                                        <span v-if="errors.ORNo">
                                            <p class="text-danger">Field Required</p>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="dateIssued">Date Issued</label>
                                        <input type="date" class="form-control form-control-border border-width-2" v-model="form.dateIssued" id="dateIssued" placeholder="Enter Date Issued">
                                        <span v-if="errors.dateIssued">
                                            <p class="text-danger">Field Required</p>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="text" class="form-control form-control-border border-width-2" v-model="form.amount" id="amount" placeholder="Amount">
                                        <span v-if="errors.amount">
                                            <p class="text-danger">Field Required</p>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount">Note</label>
                                        <input type="text" class="form-control form-control-border border-width-2" v-model="form.note" id="note" placeholder="Note">
                                        <span v-if="errors.note">
                                            <p class="text-danger">Field Required</p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" @click="submitServiceRecord()">Submit <i class="fas fa-save"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="recordModal" tabindex="-1" role="dialog" aria-labelledby="recordModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="recordModalLabel">Add Service Record</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="station">Station/Place of Assignment</label>
                                    <v-select class="form-control form-control-border border-width-2" @input="getPosition()" v-model.lazy="record_form.station" placeholder="Select Station" :options="depts" :reduce="depts => depts" label="title"></v-select>
                                    <span v-if="errors.station">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="position">Designation (Position) <span class="text-danger" v-if="record_form.station == null">(Select Station First)</span></label>
                                    <v-select class="form-control form-control-border border-width-2" :disabled="record_form.station == null" v-model.lazy="record_form.position" placeholder="Select Designation" :options="positions" label="title" :reduce="positions => positions.title"></v-select>
                                    <span v-if="errors.position">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="from">From</label>
                                    <input type="date" class="form-control form-control-border border-width-2" v-model="record_form.from"  id="from" placeholder="Enter Date">
                                    <span v-if="errors.from">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="to">To</label>
                                    <input type="date" class="form-control form-control-border border-width-2" v-model="record_form.to" id="to" placeholder="Enter Date">
                                    <span v-if="errors.to">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="status">To Date</label>
                                    <input type="radio" class="form-control form-control-border border-width-2" v-model="record_form.to" id="to1" value="to date">
                                    <span v-if="errors.to">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control form-control-border border-width-2" v-model="record_form.status">
                                        <option value="Perm.">Permanent</option>
                                        <option value="Casual">Casual</option>
                                        <option value="Temp.">Temporary</option>
                                        <option value="CT">Co Terminus</option>
                                    </select>
                                    <span v-if="errors.status">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="salary">Salary (P.A.)</label>
                                    <input type="text" class="form-control form-control-border border-width-2" v-model="record_form.salary" id="salary" placeholder="Enter">
                                    <span v-if="errors.salary">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch">Branch</label>
                                    <select name="branch" id="branch" class="form-control form-control-border border-width-2" v-model="record_form.branch">
                                        <option value="Prov'l" selected>Provincial</option>
                                        <option value="Nat'l">National</option>
                                        <option value="Muni">Municipal</option>
                                    </select>
                                    <span v-if="errors.branch">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pay">Leave of Absences w/o Pay</label>
                                    <input type="text" class="form-control form-control-border border-width-2" v-model="record_form.pay" id="pay" placeholder="Enter Leave of Absences w/o Pay">
                                    <span v-if="errors.pay">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <input type="text" class="form-control form-control-border border-width-2" v-model="record_form.remark" id="remarks" placeholder="Enter Remarks">
                                    <span v-if="errors.remark">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date1">Date</label>
                                    <input type="date" class="form-control form-control-border border-width-2" v-model="record_form.date" id="date1" placeholder="Enter Date">
                                    <span v-if="errors.date">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cause">Cause</label>
                                    <input type="text" class="form-control form-control-border border-width-2" v-model="record_form.cause" id="cause" placeholder="Enter Cause">
                                    <span v-if="errors.cause">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" v-if="edit == false" class="btn btn-primary" @click="submitEmployeeServiceRecord()">Save changes</button>
                        <button type="button" v-if="edit == true" class="btn btn-primary" @click="submitEmployeeServiceRecordUpdates()">Save changes</button>
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
                            <span v-if="errors.retirement_date">
                                <p class="text-danger">Field Required</p>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger float-left" @click="setRetirementDateToNull()">Remove Retirement Date</button>
                    <button type="button" class="btn btn-primary" @click="submitRetirementDate()">Save changes</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="copyData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Copy from excel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" style="height: 10rem;">
                                <textarea class="form-control" id="exampleFormControlTextarea1" v-model="parse" placeholder="Paste Here" rows="5"></textarea>
                                <button type="button" class="btn btn-success float-left mt-2" style="width: 100%;" @click="parseToArray">Parse</button>
                            </div>
                            <div class="col-md-12 p-2 mt-4" style="overflow: auto;">
                                <table class="table table-striped text-nowrap custom-table text-center w-100">
                                    <thead>
                                        <tr>
                                            <th colspan="1" class="border"></th>
                                            <th colspan="2" class="border">Service</th>
                                            <th colspan="3" class="border">Record of Appointment</th>
                                            <th colspan="2" class="border">Office Entity / Division</th>
                                            <th colspan="1" class="border">Leave of Absences</th>
                                            <th colspan="3" class="border">Separation</th>
                                        </tr>
                                        <tr>
                                            <th class="border">#</th>
                                            <th class="border">From</th>
                                            <th class="border">To</th>
                                            <th class="border">Designation<br>(Positon)</th>
                                            <th class="border">Status</th>
                                            <th class="border">Salary (P.A.)</th>
                                            <th class="border">Station/ <br>Place Assignment</th>
                                            <th class="border">Branch</th>
                                            <th class="border">Absences w/o<br>Pay</th>
                                            <th class="border">Remarks</th>
                                            <th class="border">Date</th>
                                            <th class="border">Cause</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(data, index) in parsedArray" :id="index">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ data[0] }}</td>
                                            <td>{{ data[1] }}</td>
                                            <td>{{ data[2] }}</td>
                                            <td>{{ data[3] }}</td>
                                            <td>{{ data[4] }}</td>
                                            <td>{{ data[5] }}</td>
                                            <td>{{ data[6] }}</td>
                                            <td>{{ data[7] }}</td>
                                            <td>{{ data[8] }}</td>
                                            <td>{{ data[9] }}</td>
                                            <td>{{ data[10] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary float-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="checkEmployeeHasServiceRecord()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="checkExistModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-center" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Records Exist</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="overflow-x: auto; overflow-y: auto;">
                        <p>Employee has existing Service Records</p>
                        <button class="btn btn-warning" @click="addToExistingServiceRecord()" :disabled="overwrite == true">Add to existing records <i class="fas fa-plus"></i></button>
                        <hr>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" v-model="overwrite">
                            <label class="form-check-label" for="exampleCheck1">Overwrite existing records <p class="text-danger" style="display:inline">(this will replace all existing data)</p></label>
                        </div>
                        <button class="btn btn-danger mt-2" v-if="overwrite == true" @click="overwriteServiceRecord()">PRESS TO CONFIRM <i class="fas fa-exclamation-triangle"></i></button>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>


        <iframe id="i" frameborder="0" hidden></iframe>

    </div>
</template>

<script>
import axios from 'axios'
import Swal from 'sweetalert2'

    export default{
        data(){
            return{
                edit: false,
                form: new Form({
                    'personal_information_id': null,
                    'ORNo': null,
                    'dateCertified': null,
                    'dateIssued': null,
                    'certifier_id': null,
                    'amount': null,
                }),
                record_form: new Form({
                    'from': null,
                    'to': null,
                    'position': null,
                    'status': "Perm.",
                    'salary': null,
                    'station': null,
                    'branch': "Prov'l",
                    'pay': null,
                    'remark': null,
                    'date': null,
                    'cause': null,
                    'orderNo': null
                }),
                data: [],
                depts: [],
                selected_station: {},
                positions: [],
                record: {id: null, name: null, retirement_date: null, service_record: null},
                service_records: [],
                errors: {},
                service_record_id: null,
                print: '',
                retirement_date: null,
                parse: "",
                parsedArray: [],
                overwrite: false
            }
        },
        watch:{
            "record_form.station": function(val, oldValue){
                if(val == null){this.emptyPositionArray()}
            }
        },
        methods:{

            emptyPositionArray: function(){
                this.positions = []
                this.record_form.position = null
            },

            formatDate: function(date)
            {
                return moment(date).format('MM/DD/YYYY') == "Invalid date" ? date : moment(date).format('MM/DD/YYYY')
            },

            addModal: function()
            {
                this.record_form.reset()
                $('#recordModal').modal('show')
                this.edit = false
            },

            parseToArray: function()
            {
                let text = this.$papa.parse(this.parse, {delimiter: "\t"})
                this.parsedArray = text.data.filter(function(e){
                    if(e.length > 1)
                    {
                        return e
                    }
                })
            },

            checkEmployeeHasServiceRecord: function()
            {
                if(this.service_records.length > 0){
                    $('#checkExistModal').modal('show')
                }else{
                    this.addEmployeeServiceRecords(this.fixData())
                }
            },

            fixData: function()
            {
                let data = []
                this.parsedArray.forEach((e, i) => {
                    let obj = {}
                    obj.from        = e[0]
                    obj.to          = e[1]
                    obj.position    = e[2]
                    obj.status      = e[3]
                    obj.salary      = e[4]
                    obj.station     = e[5]
                    obj.branch      = e[6]
                    obj.pay         = e[7]
                    obj.remark      = e[8]
                    obj.date        = e[9]
                    obj.cause       = e[10]
                    obj.orderNo     = data.length + 1
                    data.push(obj)
                })
                return data
            },

            overwriteServiceRecord: function()
            {
                axios.post('api/overwriteEmployeeServiceRecords', {'service_record_id' : this.record.service_record.id, 'data' : this.fixData()})
                .then(({data}) => {
                    $('#copyData').modal('hide')
                    $('#checkExistModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'Saved'
                    })
                })
                .finally(e => {
                    this.getEmployeeServiceRecords()
                })
                .catch(e => {
                    toast.fire({
                        icon: 'error',
                        title: 'Failed to save records!!!'
                    })
                })
            },

            addToExistingServiceRecord: function()
            {
                axios.post('api/addToExistingServiceRecord', {'service_record_id' : this.record.service_record.id, 'data' : this.fixData()})
                .then(e => {
                    $('#copyData').modal('hide')
                    $('#checkExistModal').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'Saved'
                    })
                })
                .finally(e => {
                    this.getEmployeeServiceRecords()
                })
                .catch(e => {
                    toast.fire({
                        icon: 'error',
                        title: 'Failed to save records!!!'
                    })
                })
            },

            addEmployeeServiceRecords: function(data)
            {
                axios.post('api/addServiceRecord', {'service_record_id' : this.service_record_id, 'data' : data})
                .then(e => {
                    toast.fire({
                        icon: 'success',
                        title: 'Saved'
                    })
                    $('#copyData').modal('hide')
                })
                .finally(e => {
                    this.getEmployeeServiceRecords()
                })
                .catch(e => {
                    toast.fire({
                        icon: 'error',
                        title: 'Failed to save records!!!'
                    })
                })
            },

            retirementDateModal: function()
            {
                this.retirement_date = this.record !== null ? this.record.retirement_date : null
                $('#retirementDate').modal('show')
            },

            setRetirementDateToNull: function()
            {
                this.$Progress.start()
                axios.post('api/retirementDate', {id: this.record.id, retirement_date: null})
                .then(e => {
                    toast.fire({
                        icon: 'success',
                        title: 'Saved'
                    })
                    this.retirement_date = null
                    this.record.retirement_date = null
                    $('#retirementDate').modal('hide')
                    this.$Progress.finish()
                })
                .catch(e => {
                    toast.fire({
                        icon: 'error',
                        title: 'Failed to save'
                    })
                    this.errors = e.response.data.errors
                })
            },

            submitRetirementDate: function()
            {
                this.$Progress.start()
                if(this.retirement_date)
                {
                    axios.post('api/retirementDate', {id: this.record.id, retirement_date: this.retirement_date})
                    .then(e => {
                        toast.fire({
                            icon: 'success',
                            title: 'Saved'
                        })
                        this.record.retirement_date = this.retirement_date
                        $('#retirementDate').modal('hide')
                        this.$Progress.finish()
                    })
                    .catch(e => {
                        toast.fire({
                            icon: 'error',
                            title: 'Failed to save'
                        })
                        this.errors = e.response.data.errors
                    })
                }else{
                    toast.fire({
                        icon: 'error',
                        title: 'Invalid Input!!'
                    })
                }
            },

            editModal: function(data)
            {
                this.$Progress.start()
                this.record_form.reset()
                Object.assign(this.record_form, data)
                this.record_form.station = _.find(this.depts, {'title':data.station})
                this.edit = true
                if(this.record_form.station)
                {
                    this.getPosition()
                }
                this.$Progress.finish()
                $('#recordModal').modal('show')
            },

            getServiceRecord: function()
            {
                Swal.fire({
                    title: '<strong>Loading data...</strong>',
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
                axios.get('api/servicerecord')
                .then(({data}) => {
                    this.data = data
                    Swal.close()
                })
                .catch(e => {
                    console.log(e)
                    Swal.close()
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    })

                })
            },

            getEmployeeServiceRecords: function()
            {

                Swal.fire({
                    title: '<strong>Loading data...</strong>',
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

                this.$Progress.start()
                axios.get('api/employeeservicerecord?id='+this.service_record_id ?? this.record.service_record.id)
                .then(({data}) => {
                    this.service_records = data
                    Swal.close()
                    this.$Progress.finish()
                })
                .catch(e => {
                    console.log(e)
                    toast.fire({
                        icon:'error',
                        title:'Failed to retrieve Service Records'
                    })
                })
            },

            getDepartments: function()
            {
                axios.get('api/fetchDepartments')
                .then(({data}) => {
                    this.depts = data
                })
                .catch(error => {
                    console.log(error)
                    toast.fire({
                        icon: 'error',
                        title: 'Departments not retrieved'
                    });
                })
            },

            getPosition: function()
            {
                this.record_form.position_id = null
                if(this.record_form.station){
                    axios.get('api/fetch_positions?id=' + this.record_form.station.id)
                    .then(({data}) => {
                        this.positions = data
                    })
                    .catch(e => {
                        console.log(e)
                        toast.fire({
                            icon:'error',
                            title:'Failed to fetch positions'
                        })
                    })
                }
            },

            getRecord: function()
            {
                if(this.record == null){
                    this.form.reset()
                    this.service_records = []
                }else if(this.record.service_record == null){
                    this.form.reset()
                    this.service_records = []
                }else{
                    this.form.reset()
                    this.service_record_id = this.record.service_record.id
                    Object.assign(this.form, this.record.service_record)
                    this.getEmployeeServiceRecords()
                }
            },

            submitServiceRecord: function()
            {
                this.form.personal_information_id = this.record.id
                axios.post('api/servicerecord', this.form)
                .then(e => {
                    toast.fire({
                        icon:'success',
                        title: 'Success'
                    })
                    this.service_record_id = e.data
                })
                .catch(e => {
                    console.log(e)
                    this.errors = e.response.data.errors
                })
            },

            submitEmployeeServiceRecord: function()
            {
                if(this.service_record_id == null)
                {
                    this.service_record_id = this.record.service_record.id
                }

                this.record_form.service_record_id = this.service_record_id
                this.record_form.station = this.record_form.station.title
                this.record_form.orderNo = this.service_records.length + 1

                axios.post('api/employeeservicerecord', this.record_form)
                .then(e => {
                    toast.fire({
                        icon:'success',
                        title:'Success'
                    })
                    this.record_form.reset()
                    this.selected_station = null
                    $('#recordModal').modal('hide')
                    this.getEmployeeServiceRecords()
                })
                .catch(e => {
                    console.log(e)
                    this.errors = e.response.data.errors
                })
            },

            submitEmployeeServiceRecordUpdates: function()
            {
                this.record_form.station = this.record_form.station.title
                axios.patch('api/employeeservicerecord/'+this.record_form.id, this.record_form)
                .then(e => {
                    toast.fire({
                        icon:'success',
                        title: 'Success'
                    })
                    this.edit = false
                    $('#recordModal').modal('hide')
                    this.record_form.reset()
                    this.getEmployeeServiceRecords()
                })
                .catch(e => {
                    toast.fire({
                        icon:'error',
                        title: 'Failed to edit record'
                    })
                })
            },

            deleteEmployeeServiceRecord: function(id)
            {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if(result.isDismissed == true)
                    {
                        toast.fire({
                            icon: 'warning',
                            title: 'Cancelled'
                        });
                    }else{

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

                        this.$Progress.start()
                        axios.delete('api/employeeservicerecord/'+id)
                        .then(e => {
                            toast.fire({
                                icon:'success',
                                title: 'Record Deleted'
                            })
                            this.getEmployeeServiceRecords()
                        })
                        .catch(e => {
                            toast.fire({
                                icon:'error',
                                title: 'Failed to Delete'
                            })
                            Swal.close()
                        })
                    }
                })
            },

            printRecord: function(){

                Swal.fire({
                    title: '<strong>Loading data...</strong>',
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

                axios.get('api/employeeservicerecord/'+this.service_record_id)
                .then(e => {
                    var f = document.getElementById('i')
                    f.contentWindow.document.write(e.data)
                    setTimeout(function () {
                        f.contentWindow.focus()
                        f.contentWindow.print()

                        f.contentWindow.document.open();
                        f.contentWindow.document.write("");
                        f.contentWindow.document.close();
                    }, 500);

                    Swal.close()
                })
                .catch(e => {
                    console.log(e)
                    Swal.close()
                    toast.fire({
                        icon: 'error',
                        title: 'Something went wrong!'
                    })
                })
            },

            copyData: function()
            {
                this.parse = ""
                this.parsedArray = []
                $('#copyData').modal('show')
            }
        },
        created(){
            this.getServiceRecord()
            this.getDepartments()
        }
    }
</script>
