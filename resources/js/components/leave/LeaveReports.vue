<template>
   <div class="row justify-content-center" style="min-height: 100vh;">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">

                    <div class="row mt-1">
                        <div class="col-md-6">
                            <h2>Leave Reports</h2>
                            <small style="margin-left: 2px;">Subtitle Subtitle Subtitle Subtitle Subtitle Subtitle</small>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary float-right" @click="generateReport()"><i class="fas fa-print"></i></button>
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
    </div>
</template>

<script>
import axios from 'axios'
    export default{
        data() {
            return{
                report: null
            }
        },

        methods: {
            generateReport: function()
            {
                axios.get('api/generateLeaveReport')
                .then(({data}) => {
                    data = this.null
                }).catch(e => {
                    console.log(e)
                })
            }
        },

        mounted() {

        },
    }
</script>
