<template>
      <div class="row justify-content-center">
        <div class="col-md-12 text-center" v-if="!$gate.isAdministrator() && !$gate.isAuthor()">
            <not-authorized></not-authorized>
        </div>
        <div v-else class="col-md-12">

            <!-- Reports -->
            <div class="row" id="report_div" style="display: none;margin-top: -1.4rem !important;">
                <div class="col-md-12 report_div">
                    <img src="storage/project_files/davsur.png" alt="Agency Logo" class="img-fluid nosi-logo" style="top: 20px;">
                    <div class="row others-report-fixed">
                        <p class="m-0"><small>THIS IS A SYSTEM GENERATED REPORT</small></p>
                    </div>
                    <div class="row mt-3 mb-5">
                        <div class="col-12 text-center">
                            <h4 class="m-0">Republic of the Philippines</h4>
                            <h4 class="m-0 font-weight-bold">PROVINCE OF DAVAO DEL SUR</h4>
                            <h5 class="m-0">Matti, Digos City</h5>
                            <h4 class="m-0 font-weight-bold">Provincial Human Resource Management Office</h4>
                            <h4 class="m-0 font-weight-bold">Separations</h4>
                        </div>
                    </div>

                    <!-- Reports -->
                    <div class="row mb-2">
                        <div class="col-6">
                            <h3 class="m-0"><b>From </b> {{ report.date_from }} to {{ report.date_to }}</h3>
                            <h3 class="m-0"><b>Result count:</b> {{ report.data.length }}</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered m-0">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Employee</th>
                                        <th>Mode of Separation</th>
                                        <th>Effectivity Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in report.data" :key="index">
                                        <td class="align-middle pt-1 pb-1">{{ index + 1 }}.</td>
                                        <td class="align-middle pt-1 pb-1">
                                            <div style="display: inline-block;vertical-align: middle;line-height: 1.2rem;height: 35px;">
                                                <span style="font-size: 1rem;">{{ item.surname + ', ' + item.firstname + ' ' + (item.nameextension || '') + ' ' + (item.middlename || '') }}</span>
                                                <br>
                                                <span style="font-size: 0.8rem;" class="text-muted">Birthdate: <i>{{ item.birthdate | myDate }}</i></span>
                                            </div>
                                        </td>
                                        <td class="align-middle pt-1 pb-1">
                                            <span style="text-transform: uppercase;">{{ item.mode }}</span>
                                            <div style="line-height: 1rem;">
                                                <span style="font-size: 0.8rem;" class="text-muted">Last Position: <i>{{ item.position }}, {{ item.appointment_status }}, SG-{{ item.salary_grade }}</i></span>
                                            </div>
                                        </td>
                                        <td>
                                            {{ item.effectivity_date | myDate }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Job Descriptions</h2>
                    <p style="margin: 2px 0 0 2px;">List of Job Descriptions based on current default plantilla</p>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group" style="margin-bottom:0;">
                                <v-select @input="loadContents($event)" class="form-control form-control-border border-width-2" v-model="selectedDepartment" :getOptionLabel="dept => dept.address" :clearable="false" :options="departments" placeholder="Search Department"></v-select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <div class="input-group">
                                <input v-model="search" @keyup.prevent="searchit" type="text" class="form-control form-control-border border-width-2" placeholder="Search Position" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0" style="height: 800px;">
                    <table class="table table-striped text-nowrap custom-table">
                        <thead>
                            <tr>
                                <th>Item #</th>
                                <th>Position</th>
                                <th>Salary Grade</th>
                                <th>Salary</th>
                                <th style="text-align: center;">Job Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in records" :key="item.id">
                                <td>{{ item.new_number ? item.new_number : item.old_number }}</td>
                                <td>
                                    <b>{{ item.position }}</b>
                                    <br>
                                    <span v-if="item.surname">{{ item | name }}</span>
                                    <span v-else class="green"><b>VACANT</b></span>
                                </td>
                                <td>SG-{{ item.salaryproposed ? item.salaryproposed.grade : item.salaryauthorized.grade }}</td>
                                <td>
                                    ₱{{ (item.salaryproposed !== null ? ((item.working_time == 'Full-time' ? item.salaryproposed.amount * 12 : (item.salaryproposed.amount / 2) * 12)) : '') | amount}}.00 / annum <br>
                                    ₱{{ (item.salaryproposed !== null ? ((item.working_time == 'Full-time' ? item.salaryproposed.amount : item.salaryproposed.amount / 2)) : '') | amount}}.00 / month
                                </td>
                                <td style="text-align: center;"><a :class="item.has_job_description ? 'text-primary' : 'text-danger'" href="#" @click.prevent="updateRecord(item)"><i class="fas fa-eye"></i> View</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <jd-form-modal :key="create_modal_key" @exit="createModalExit" :foredit="foredit" :details="details" :plantilla_content_id="plantilla_content_id"></jd-form-modal>
    </div> <!-- row -->
    
</template>
<script>
import moment from 'moment'
import jdFormModal from './modals/JDForm'
import axios from 'axios';

export default {
    data() {
        return {
            report: {
                date_from: null,
                date_to: null,
                data: []
            },
            search: '',
            positions: {},
            create_modal_key: 0,
            records: {},
            foredit: {},
            plantilla: {},
            departments: [{}],
            selectedDepartment: null,
            details: {},
            plantilla_content_id: ''
        }
    },
    components: {
        'jd-form-modal': jdFormModal
    },
    watch:
    {

    },
    created: function() {

        this.$Progress.start()
        // this.fetch_data()
        this.loadDepartments()
    },
    methods: {
        searchit: _.debounce(function(){
            this.getResults();
        }, 400),
        getResults(page = 1) {
            axios.get('api/plantillaContentSearch?page=' + page + '&keyword=' + this.search + '&department=' + this.selectedDepartment.id)
                .then(({data}) => {
                    this.records = data.data;
                }).catch(error => {
                    console.log(error.reponse.data.message);
                });
        },
        loadDepartments() {
            axios.get('api/department')
                .then(({data}) => {
                    this.departments = data.data;
                    this.plantilla = this.$parent.settings.plantilla;
                    // Pre select Departments if from Employees component
                    if (this.$route.params.dept != null) {
                        this.selectedDepartment = this.$route.params.dept;
                    } else {
                        this.selectedDepartment = data.data[0];
                    }
                    this.loadContents();                    
                })
                .catch(error => {
                    console.log(error.response.data.message);
                });
        },
        loadContents() {
            axios.post('api/plantilladepartmentcontent', {department: this.selectedDepartment})
                .then(({data}) => {
                    this.records = data.data;
                    if (data.data.length > 0) {
                        this.itemMin = data.data[0].new_number;
                        this.itemMax = data.data[data.data.length - 1].new_number;
                    }

                    this.$Progress.finish();

                })
                .catch(error => {
                    this.$Progress.fail();
                    console.log(error.response.data.message);
                });
        },
        print_data() {
            this.report.data = []
            var filtered = []

            filtered = _.filter(this.qss.data, (content) => { 
                return moment(this.report.date_from) <= moment(content.effectivity_date)
                    && moment(this.report.date_to) >= moment(content.effectivity_date)
            });
            
            this.report.data = filtered
            this.$nextTick(() => {
                window.print()
            })
        },
        // fetch_data() {
        //     axios.get('api/qs')
        //         .then(({data}) => {
        //             this.qss = data;
        //             this.$Progress.finish()
        //         })
        //         .catch(error => {
        //             this.$Progress.fail()
        //             console.log(error.response.data.message);
        //         });
        // },
        updateRecord(record) {
            axios.get('api/job_description?plantilla_content_id=' + record.id)
                .then(({data}) => {
                    this.foredit = data
                    this.details = {
                        position: record.position,
                        department: this.selectedDepartment.address,
                    }
                    this.plantilla_content_id = record.id
                    $('#jd-form-modal-div').modal('show')
                })
                .catch(error => {
                    console.log(error.response.data.message);
                });
        },
        createModalExit(value) {
            this.create_modal_key += 1;
            if (value == 'sync') {
                this.loadContents();
            }
        }
    },
}
</script>
