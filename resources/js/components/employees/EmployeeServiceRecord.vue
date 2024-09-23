<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Employee Service Record</h3>
                            <p>Service Records</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row justify-content-between">

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
                                        <th colspan="2" class="border">Separation</th>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(record, index) in service_records">
                                        <td>{{record.orderNo}}</td>
                                        <td>{{ formatDate(record.from) }}</td>
                                        <td>{{ formatDate(record.to) }}</td>
                                        <td>{{ record.position }}</td>
                                        <td>{{ record.status }}</td>
                                        <td>{{ record.salary }}</td>
                                        <td>{{ record.station }}</td>
                                        <td>{{ record.branch }}</td>
                                        <td>{{ record.pay }}</td>
                                        <td>{{ record.remark }}</td>
                                        <td>{{ formatDate(record.date) }}</td>
                                        <td>{{ record.cause }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- row -->
</template>
<script>
import axios from 'axios';

export default {
  data()
    {
        return {
            service_records: {},
        }
    },

    methods: {

        formatDate: function(date)
        {
            return moment(date, ['MM/DD/YYYY', 'MM-DD-YY']).format('MM/DD/YYYY') == "Invalid date" ? date : moment(date, ['MM/DD/YYYY', 'MM-DD-YY']).format('MM/DD/YYYY')
        },

        getEmployeeServiceRecord: function(){
            axios.get('api/getEmployeeServiceRecord')
            .then(({data}) => {
                this.service_records = data
            })
            .catch(e => {
                console.log(e)
            })
        }

    },

    created: function() {

    },

    mounted: function() {
        this.getEmployeeServiceRecord()
    }
}
</script>
