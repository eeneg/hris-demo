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
                        <div class="col-md-5">
                            <div class="form-group">
                                <v-select class="form-control form-control-border border-width-2" @input="getRecord()" placeholder="Select Employee" v-model.lazy="record" :options="data" label="name"></v-select>
                                <span v-if="errors.personal_information_id">
                                    <p class="text-danger">Please select and employee</p>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary w-100" :disabled="form.personal_information_id == null" @click="addModal()">Add <i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="card-body table-responsive border p-0" style="height: 400px;">
                            <table class="table table-striped text-nowrap custom-table text-center">
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
                                        <th class="border">Salary</th>
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
                                        <td>{{ record.position_title }}</td>
                                        <td>{{ record.status }}</td>
                                        <td>{{ record.salary }}</td>
                                        <td>{{ record.dept_name }}</td>
                                        <td>{{ record.branch }}</td>
                                        <td>{{ record.pay }}</td>
                                        <td>{{ record.remark }}</td>
                                        <td>{{ formatDate(record.date) }}</td>
                                        <td>{{ record.cause }}</td>
                                        <td>
                                            <button class="btn btn-primary" @click="editModal(record)"><i class="fas fa-edit"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ORNo">O.R. Number</label>
                                        <input type="text" class="form-control form-control-border border-width-2" v-model="form.ORNo" id="ORNo" placeholder="Enter O.R. Number">
                                        <span v-if="errors.ORNo">
                                            <p class="text-danger">Field Required</p>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dateIssued">Date Issued</label>
                                        <input type="date" class="form-control form-control-border border-width-2" v-model="form.dateIssued" id="dateIssued" placeholder="Enter Date Issued">
                                        <span v-if="errors.dateIssued">
                                            <p class="text-danger">Field Required</p>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="text" class="form-control form-control-border border-width-2" v-model="form.amount" id="amount" placeholder="amount">
                                        <span v-if="errors.amount">
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
                                    <v-select class="form-control form-control-border border-width-2" @input="getPosition()" v-model.lazy="record_form.station" placeholder="Select Station" :options="depts" :reduce="depts => depts.id" label="title"></v-select>
                                    <span v-if="errors.station">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="position">Designation (Position)</label>
                                    <v-select class="form-control form-control-border border-width-2" v-bind:class="{ disabled: true }" v-model.lazy="record_form.position_id" placeholder="Select Designation" :options="positions" label="title" :reduce="positions => positions.id"></v-select>
                                    <span v-if="errors.position_id">
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <input type="text" class="form-control form-control-border border-width-2" v-model="record_form.status" id="status" placeholder="Enter Status">
                                    <span v-if="errors.status">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="salary">Salary</label>
                                    <input type="text" class="form-control form-control-border border-width-2" v-model="record_form.salary" id="salary" placeholder="Enter">
                                    <span v-if="errors.salary">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch">Branch</label>
                                    <input type="text" class="form-control form-control-border border-width-2" v-model="record_form.branch" id="branch" placeholder="Enter Branch">
                                    <span v-if="errors.branch">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                                    <span v-if="errors.remarks">
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
                                    <span v-if="errors.text">
                                        <p class="text-danger">Field Required</p>
                                    </span>
                                </div>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" v-if="edit = false" class="btn btn-primary" @click="submitEmployeeServiceRecord()">Save changes</button>
                        <button type="button" v-if="edit = true" class="btn btn-primary" @click="submitEmployeeServiceRecordUpdates()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
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
                    'position_id': null,
                    'status': null,
                    'salary': null,
                    'station': null,
                    'branch': null,
                    'pay': null,
                    'remark': null,
                    'date': null,
                    'cause': null
                }),
                data: [],
                depts: [],
                selected_station: {},
                positions: [],
                record: {'id': null, 'name': null, 'service_record': {}},
                service_records: [],
                errors: {},
                service_record_id: null
            }
        },
        methods:{

            formatDate: function(date)
            {
                return moment(date).format('MM/DD/YYYY')
            },

            addModal: function()
            {
                $('#recordModal').modal('show')
                this.edit = false
            },

            editModal: function(data)
            {
                this.$Progress.start()
                this.record_form.reset()
                Object.assign(this.record_form, data)
                this.edit = true
                this.getPosition()
                this.record_form.position_id = data.position_id
                this.$Progress.finish()
                $('#recordModal').modal('show')
            },

            getServiceRecord: function()
            {
                axios.get('api/servicerecord')
                .then(({data}) => {
                    this.data = data
                })
                .catch(e => {
                    console.log(e)
                })
            },

            getEmployeeServiceRecords: function()
            {
                this.$Progress.start()
                axios.get('api/employeeservicerecord?id='+this.service_record_id ?? this.record.service_record.id)
                .then(({data}) => {
                    this.service_records = data
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
                axios.get('api/fetch_positions?id=' + this.record_form.station)
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
                    Object.assign(this.form, this.record.service_record)
                    this.service_record_id = this.record.service_record.id
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
                    console.log(this.service_record_id)
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
                axios.patch('api/employeeservicerecord/'+this.record_form.id, this.record_form)
                .then(e => {
                    toast.fire({
                        icon:'success',
                        title: 'Success'
                    })
                    this.edit = false
                    $('#recordModal').modal('hide')
                    this.getEmployeeServiceRecords()
                })
                .catch(e => {
                    toast.fire({
                        icon:'success',
                        title: 'Failed to edit record'
                    })
                })
            }
        },
        created(){
            this.getServiceRecord()
            this.getDepartments()
        }
    }
</script>
