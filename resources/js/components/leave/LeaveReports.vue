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
                        <div class="col-md-4">
                            <div class="form-check ml-3 mt-3">
                                <input type="checkbox" class="form-check-input" @change=checked(1) name="jan" id="jan">
                                <label class="form-check-label" for="jan">January</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check ml-3 mt-3">
                                <input type="checkbox" class="form-check-input" @change=checked(2) name="feb" id="feb">
                                <label class="form-check-label" for="feb">February</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check ml-3 mt-3">
                                <input type="checkbox" class="form-check-input" @change=checked(3) name="mar" id="mar">
                                <label class="form-check-label" for="mar">March</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check ml-3 mt-3">
                                <input type="checkbox" class="form-check-input" @change=checked(4) name="apr" id="apr">
                                <label class="form-check-label" for="apr">April</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check ml-3 mt-3">
                                <input type="checkbox" class="form-check-input" @change=checked(5) name="may" id="may">
                                <label class="form-check-label" for="may">May</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check ml-3 mt-3">
                                <input type="checkbox" class="form-check-input" @change=checked(6) name="jun" id="jun">
                                <label class="form-check-label" for="jun">June</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check ml-3 mt-3">
                                <input type="checkbox" class="form-check-input" @change=checked(7) name="jul" id="jul">
                                <label class="form-check-label" for="jul">July</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check ml-3 mt-3">
                                <input type="checkbox" class="form-check-input" @change=checked(8) name="aug" id="aug">
                                <label class="form-check-label" for="aug">August</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check ml-3 mt-3">
                                <input type="checkbox" class="form-check-input" @change=checked(9) name="sept" id="sept">
                                <label class="form-check-label" for="sept">September</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check ml-3 mt-3">
                                <input type="checkbox" class="form-check-input" @change=checked(10) name="oct" id="oct">
                                <label class="form-check-label" for="oct">October</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check ml-3 mt-3">
                                <input type="checkbox" class="form-check-input" @change=checked(11) name="nov" id="nov">
                                <label class="form-check-label" for="nov">November</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check ml-3 mt-3">
                                <input type="checkbox" class="form-check-input" @change=checked(12) name="dec" id="dec">
                                <label class="form-check-label" for="dec">December</label>
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
                    'months': []
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
                .then(({data}) => {
                    data = this.null
                }).catch(e => {
                    this.errors = e.response.data.errors
                })
            },

            submit()
            {
                this.generateReport()
            },

            checked: function(month)
            {
                if(!this.form.months.includes(month))
                {
                    this.form.months.push(month)
                }else{
                    this.form.months = this.form.months.filter(function(e){ return e !== month })
                }
            }
        },

        mounted() {
            this.getReports()
        },
    }
</script>
