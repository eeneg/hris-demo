<template>
   <div class="row justify-content-center" style="min-height: 100vh;">
        <div class="col-md-12 text-center" v-if="$gate.isEmployee()">
            <not-authorized></not-authorized>
        </div>
        <div v-else class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">

                    <div class="row mt-1">
                        <div class="col-md-12">
                            <h2 style="display: inline-block;">Leave Reports</h2>
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#withoutPay" @click="withoutPayFormType('VLWOP')">
                                <i class="fas fa-print"></i> VLWOP
                            </button>
                            <button type="button" class="btn btn-primary float-right mr-2" data-toggle="modal" data-target="#withoutPay" @click="withoutPayFormType('SLWOP')">
                                <i class="fas fa-print"></i> SLWOP
                            </button>
                            <button type="button" class="btn btn-primary float-right mr-2" data-toggle="modal" data-target="#foreign_travel">
                                <i class="fas fa-print"></i> Foreign Travel
                            </button>
                            <button type="button" class="btn btn-primary float-right mr-2" data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-print"></i> Summary
                            </button>
                        </div>
                        <div class="col-md-12">
                            <span><small style="margin-left: 2px;">Generate Leave Reports</small></span>
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
                                        <th>Date Created</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="report in reports.data" :key="report.id">
                                        <td>{{ report.title }}</td>
                                        <td>{{ formatDate(report.created_at) }}</td>
                                        <td style="width: 3px;">
                                            <div style="display:inline-flex; padding: auto; margin: auto;">
                                                <button class="btn btn-primary" @click="viewReport(report.path)"><i class="fas fa-eye"></i></button>
                                                <button class="btn btn-danger" style="margin-left: 2px;" @click="deleteReport(report.id)"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

               <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <pagination size="default" :data="reports" @pagination-change-page="paginate" :limit="5">
                        <span slot="prev-nav">&lt; Previous</span>
	                    <span slot="next-nav">Next &gt;</span>
                    </pagination>
                    <span style="margin-left: 10px;">Showing {{ reports.from }} to {{ reports.to }} of {{ reports.total }} records</span>
                </div>

            </div>
        </div>

        <!-- Modal -->

        <div class="modal fade" id="foreign_travel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Foreign Travel Report</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" v-model="foreignForm.title" id="title" class="form-control" placeholder="Enter Title">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="number" v-model="foreignForm.year" id="year" class="form-control" placeholder="Enter Year">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="month">Month</label>
                                <select class="custom-select" v-model="foreignForm.month">
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" v-for="(preparedBy, index) in foreignForm.preparedBy" :key="preparedBy.id">
                            <label for="author">Prepared By:</label>
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" v-model="preparedBy.name" name="author" id="author" placeholder="Name">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" v-model="preparedBy.position" name="position" id="position"  placeholder="Position">
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-danger" @click="destroyPreparedBy(index, 2)"><i class="fas fa-minus"></i></button>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-success" @click="addPreparedBy(index, 2)"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <label for="noted">Noted By:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="foreignForm.notedBy.name" name="noted" id="noted" placeholder="Name">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="foreignForm.notedBy.position" name="positionN" id="positionN" placeholder="Position">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="generateForeignTravelReport()">Generate report</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal -->

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
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
                            <label for="title">Report Title</label>
                            <input type="title" class="form-control" v-model="summaryForm.title" name="title" id="title" placeholder="Input Title">
                            <p class="text-danger" v-for="title in errors.title" :key="title.id">
                                {{ title }}
                            </p>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mt-2">
                                <label for="year">Year</label>
                                <input type="number" class="form-control" v-model="summaryForm.year" name="year" id="year" placeholder="Input Year">
                                <p class="text-danger" v-for="year in errors.year" :key="year.id">
                                    {{ year }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="month">Month</label>
                                <select class="form-control" style="width: 100%;" id="month" v-model="summaryForm.month">
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
                            <p class="text-danger" v-for="month in errors.month" :key="month.id">
                                {{ month }}
                            </p>
                        </div>
                        <div class="col-md-12" v-for="(preparedBy, index) in summaryForm.preparedBy" :key="preparedBy.id">
                            <label for="author">Prepared By:</label>
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" v-model="preparedBy.name" name="author" id="author" placeholder="Name">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" v-model="preparedBy.position" name="position" id="position"  placeholder="Position">
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-danger" @click="destroyPreparedBy(index, 1)"><i class="fas fa-minus"></i></button>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-success" @click="addPreparedBy(index, 1)"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <label for="noted">Noted By:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="summaryForm.notedBy.name" name="noted" id="noted" placeholder="Name">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="summaryForm.notedBy.position" name="positionN" id="positionN" placeholder="Position">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="generateSummaryReport()">Generate report</button>
                </div>
                </div>
            </div>
        </div>

        <!-- VLOP && SLWOP -->

        <div class="modal fade" id="withoutPay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
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
                            <label for="title">Report Title</label>
                            <input type="title" class="form-control" v-model="withoutPayForm.title" name="title" id="title" placeholder="Input Title">
                            <p class="text-danger" v-for="title in errors.title" :key="title.id">
                                {{ title }}
                            </p>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mt-2">
                                <label for="year">Year</label>
                                <input type="number" class="form-control" v-model="withoutPayForm.year" name="year" id="year" placeholder="Input Year">
                                <p class="text-danger" v-for="year in errors.year" :key="year.id">
                                    {{ year }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="month">Month</label>
                                <select class="form-control" style="width: 100%;" id="month" v-model="withoutPayForm.month">
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
                            <p class="text-danger" v-for="month in errors.month" :key="month.id">
                                {{ month }}
                            </p>
                        </div>
                        <div class="col-md-12" v-for="(preparedBy, index) in withoutPayForm.preparedBy" :key="preparedBy.id">
                            <label for="author">Prepared By:</label>
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" v-model="preparedBy.name" name="author" id="author" placeholder="Name">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" v-model="preparedBy.position" name="position" id="position"  placeholder="Position">
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-danger" @click="destroyPreparedBy(index, 1)"><i class="fas fa-minus"></i></button>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-success" @click="addPreparedBy(index, 1)"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <label for="noted">Noted By:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="withoutPayForm.notedBy.name" name="noted" id="noted" placeholder="Name">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="withoutPayForm.notedBy.position" name="positionN" id="positionN" placeholder="Position">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="getWithoutPayReport()">Generate report</button>
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
import moment from 'moment'

    export default{
        data() {
            return{
                reports: {},
                summaryForm: new Form({
                    'title': null,
                    'year': null,
                    'month': null,
                    'preparedBy': [{ name: null, position: null }],
                    'notedBy': { name: null, position: null }
                }),
                foreignForm: new Form({
                    'title': null,
                    'year': null,
                    'month': null,
                    'preparedBy': [{ name: null, position: null }],
                    'notedBy': { name: null, position: null }
                }),
                withoutPayForm: new Form({
                    'type': null,
                    'title': null,
                    'year': null,
                    'month': null,
                    'preparedBy': [{ name: null, position: null }],
                    'notedBy': { name: null, position: null }
                }),
                errors: {year: null, months: null}
            }
        },

        components: {

        },
        methods: {

            withoutPayFormType: function(type){
                this.withoutPayForm.type = type
            },

            getWithoutPayReport: function(){
                axios.post('api/withoutPay', this.withoutPayForm)
                .then(e => {
                    $('#withoutPay').modal('hide')
                    let options = {
                        height: screen.height * 0.65 + 'px',
                        page: '1'
                    };
                    this.getReports()
                    $('#pdfModal').modal('show');
                    PDFObject.embed("/storage/leave_reports/" + e.data.title, "#pdf-viewer", options);
                })
                .catch( e => {
                    Swal.fire(
                        'Failed!!',
                        e.response.data.message,
                        'warning'
                    )
                    this.errors = e.response.data.errors
                })
            },

            destroyPreparedBy: function(index, mode)
            {
                if(this.summaryForm.preparedBy.length !== 1 && mode == 1)
                {
                    this.summaryForm.preparedBy.splice(index, 1)
                }else if(this.summaryForm.preparedBy.length == 1 && mode == 1){
                    this.summaryForm.preparedBy[index] = {name: null, position: null}
                }

                if(this.foreignForm.preparedBy.length !== 1 && mode == 2)
                {
                    this.foreignForm.preparedBy.splice(index, 1)
                }else if(this.foreignForm.preparedBy.length == 1 && mode == 2){
                    this.foreignForm.preparedBy[index] = {name: null, position: null}
                }
            },

            addPreparedBy: function(index, mode)
            {
                if(this.summaryForm.preparedBy.length <= 2 && mode == 1)
                {
                    this.summaryForm.preparedBy.splice(index+1, 0, {name: null, position: null})
                }

                if(this.foreignForm.preparedBy.length <= 2 && mode == 2)
                {
                    this.foreignForm.preparedBy.splice(index+1, 0, {name: null, position: null})
                }
            },

            formatDate: function()
            {
                return moment().format('MMMM M Y')
            },

            viewReport: function(path)
            {
                let options = {
                        height: screen.height * 0.65 + 'px',
                        page: '1'
                };
                $('#pdfModal').modal('show');
                PDFObject.embed(path, "#pdf-viewer", options);
            },

            getReports: function()
            {
                axios.get('api/leaveReport')
                .then(({data}) => {
                    this.reports = data
                }).catch(error => {
                    Swal.fire(
                        'Oops...',
                        'Something went wrong',
                        'error'
                    )
                })
            },

            paginate(page = 1){
                axios.get('api/leaveReport?page=' + page)
                .then(({data}) => {
                    this.reports = data
                }).catch(error => {
                    console.log(error.reponse.data.message);
                    Swal.fire(
                        'Oops...',
                        'Something went wrong',
                        'error'
                    )
                });
            },

            generateSummaryReport: function()
            {
                axios.post('api/leaveReport', this.summaryForm)
                .then(e => {
                    $('#exampleModal').modal('hide')
                    let options = {
                        height: screen.height * 0.65 + 'px',
                        page: '1'
                    };
                    $('#pdfModal').modal('show');
                    PDFObject.embed("/storage/leave_reports/" + e.data.title, "#pdf-viewer", options);
                    this.getReports()
                }).catch(e => {
                    Swal.fire(
                        'Failed!!',
                        e.response.data.message,
                        'warning'
                    )
                    this.errors = e.response.data.errors
                })
            },

            deleteReport: function($id)
            {

                Swal.fire({
                title: 'Delete Report?',
                text: "You cannot revert this!!",
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

                        axios.delete('api/leaveReport/'+ $id)
                        .then(response => {
                            toast.fire({
                                icon: 'success',
                                title: 'Deleted'
                            })
                            this.getReports()
                            this.$Progress.finish()
                        })
                        .catch(e => {
                            Swal.fire(
                                'Failed!!',
                                'Something went wrong!',
                                'warning'
                            )
                            console.log(e)
                        })

                    }
                })
            },

            generateForeignTravelReport()
            {
                this.$Progress.start()
                axios.post('api/foreignTravel', this.foreignForm)
                .then(e => {
                    this.$Progress.finish()
                    $('#foreign_travel').modal('hide')
                    let options = {
                        height: screen.height * 0.65 + 'px',
                        page: '1'
                    };
                    $('#pdfModal').modal('show');
                    PDFObject.embed("/storage/leave_reports/" + e.data.title, "#pdf-viewer", options);
                    this.getReports()
                })
                .catch(e => {
                    console.log(e)
                    Swal.fire(
                        'Failed!!',
                        e.response.data.message,
                        'warning'
                    )
                    this.errors = e.response.data.errors
                })
            },
        },

        mounted() {
            this.getReports()
        },
    }
</script>
