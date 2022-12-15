<template>
   <div class="row justify-content-center" style="min-height: 100vh;">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">

                    <div class="row mt-1">
                        <div class="col-md-6">
                            <h2>Leave Reports</h2>
                            <small style="margin-left: 2px;">Generate Leave Reports</small>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-print"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>asd</td>
                                        <td>asd</td>
                                        <td>asd</td>
                                    </tr>
                                    <tr>
                                        <td>asd</td>
                                        <td>asd</td>
                                        <td>asd</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer">

                </div>

            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Input Year & Dates</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="number" class="form-control" v-model="form.year" name="year" id="year" placeholder="Input Year">
                            <p class="text-danger" v-for="year in errors.year" :key="year.id">
                                {{ year }}
                            </p>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mt-2">
                                <label for="month">Month</label>
                                <select class="form-control" style="width: 100%;" id="month" v-model="form.month">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <p class="text-danger" v-for="months in errors.months" :key="months.id">
                                {{ months }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="submit()">Save changes</button>
                </div>
                </div>
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal" id="pdfModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Report</h4>
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

<script>
import axios from 'axios'

    export default{
        data() {
            return{
                reports: [],
                form: new Form({
                    'year': null,
                    'month': null
                }),
                errors: {year: null, months: null}
            }
        },

        components: {

        },
        methods: {

            getReports: function()
            {
                axios.get('api/leaveReport')
                .then(({data}) => {
                    this.reports = data
                    console.log(this.reports)
                }).catch(e => {

                })
            },

            generateReport: function()
            {
                axios.post('api/generateLeaveReport', this.form)
                .then(e => {
                    // $('#exampleModal').modal('hide')
                    let options = {
                        height: screen.height * 0.65 + 'px',
                        page: '1'
                    };
                    $('#pdfModal').modal('show');
                    PDFObject.embed("/storage/leave_reports/" + e.data.title, "#pdf-viewer", options);

                }).catch(e => {
                    // this.errors = e.response.data.errors
                })
            },

            submit()
            {
                this.generateReport()
            },
        },

        mounted() {
            this.getReports()
        },
    }
</script>
