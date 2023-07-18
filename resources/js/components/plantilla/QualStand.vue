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
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Qualification Standards</h2>
                    <p style="margin: 2px 0 0 2px;">Civil Service Qualification Standards</p>
                    <div class="row mt-1">
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input v-model="search" @keyup.prevent="searchit" type="text" class="form-control" placeholder="Search" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-primary float-right" href="" @click.prevent="add_qs()">
                                        <i class="fas fa-plus mr-2"></i>Add
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-9">
                            <div class="row">
                                <div class="col-2">

                                </div>
                                <div class="col-2">
                                    <a class="btn btn-primary float-right" href="" @click.prevent="print_data()">
                                        <i class="fas fa-print mr-2"></i>PRINT
                                    </a>
                                </div>
                                <div class="col-4">
                                    <div class="form-group row m-0">
                                        <label for="" class="col-sm-2 col-form-label">From</label>
                                        <div class="col-sm-10">
                                            <input class="form-control form-control-border border-width-2" type="date" v-model="report.date_from" name="original_appointment" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group row m-0">
                                        <label for="" class="col-sm-2 col-form-label">To</label>
                                        <div class="col-sm-10">
                                            <input class="form-control form-control-border border-width-2" type="date" v-model="report.date_to" name="original_appointment" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>

                <div class="card-body table-responsive p-0" style="height: 650px;">
                    <table class="table table-striped text-nowrap custom-table">
                        <thead>
                            <tr>
                                <th>Position</th>
                                <th>SG</th>
                                <th>Educational Requirements</th>
                                <th>Experience Requirements</th>
                                <th>Training Requirements</th>
                                <th>Eligibility Requirements</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in qss.data" :key="item.id">
                                <td>{{ item.position.title }}</td>
                                <td>{{ item.sg }}</td>
                                <td>{{ item.education }}</td>
                                <td>{{ item.experience }}</td>
                                <td>{{ item.training }}</td>
                                <td>{{ item.eligibility }}</td>
                                <td style="text-align: center;"><a href="#" @click.prevent="updateRecord(item)"><i class="fas fa-edit"></i></a></td>
                                <!-- <td style="width: calc(100%-150px);">
                                    <img style="width: 45px;height: 45px;" class="img-circle mr-2" :src="getAvatar(item.picture)" alt="User Avatar">
                                    <div style="display: inline-block;vertical-align: middle;line-height: 1.2rem;height: 35px;">
                                        <span style="font-size: 1rem;text-transform: uppercase;">{{ item.surname + ', ' + item.firstname + ' ' + (item.nameextension || '') + ' ' + (item.middlename || '') }}</span>
                                        <br>
                                        <span style="font-size: 0.8rem;" class="text-muted">Birthdate: <i>{{ item.birthdate | myDate }}</i></span>
                                    </div>
                                </td>
                                <td>
                                    <span style="text-transform: uppercase;">{{ item.mode }}</span>
                                    <div style="line-height: 1rem;">
                                        <span style="font-size: 0.8rem;" class="text-muted">Last Position: <i>{{ item.position }}, {{ item.appointment_status }}, SG-{{ item.salary_grade }}</i></span>
                                    </div>
                                </td>
                                <td>
                                    {{ item.effectivity_date | myDate }}
                                </td> -->
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <pagination size="default" :data="qss" @pagination-change-page="getResults" :limit="5">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                    <span style="margin-left: 10px;">Page {{ qss.meta && qss.meta.current_page }} of {{ qss.meta && qss.meta.last_page }}</span>
                </div>
            </div>
        </div>

        
        <qs-form-modal :key="create_modal_key" @exit="createModalExit" :positions="positions" :foredit="foredit"></qs-form-modal>
    </div> <!-- row -->
    
</template>
<script>
import moment from 'moment'
import qsFormModal from './modals/QSForm'

export default {
    data() {
        return {
            report: {
                date_from: null,
                date_to: null,
                data: []
            },
            qss: {},
            search: '',
            options: {
                format: 'yyyy-MM-DD',
                useCurrent: false,
            },
            positions: [],
            create_modal_key: 0,
            foredit: {}
        }
    },
    components: {
        datePicker,
        'qs-form-modal': qsFormModal
    },
    watch:
    {

    },
    created: function() {

        this.$Progress.start()
        this.fetch_data()
        this.fetch_positions()
        
    },
    methods: {
        searchit: _.debounce(function(){
            this.getResults();
        }, 400),
        getResults(page = 1) {
            axios.get('api/qs?page=' + page + '&query=' + this.search)
                .then(({data}) => {
                    this.qss = data;
                }).catch(error => {
                    console.log(error.reponse.data.message);
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
        fetch_data() {
            axios.get('api/qs')
                .then(({data}) => {
                    this.qss = data;
                    this.$Progress.finish()
                })
                .catch(error => {
                    this.$Progress.fail()
                    console.log(error.response.data.message);
                });
        },
        fetch_positions() {
            axios.get('api/position')
                .then(({data}) => {
                    this.positions = data;
                    this.$Progress.finish()
                })
                .catch(error => {
                    this.$Progress.fail()
                    console.log(error.response.data.message);
                });
        },
        add_qs() {
            this.foredit = {}
            $('#qs-form-modal-div').modal('show')
        },
        updateRecord(record) {
            this.foredit = record
            $('#qs-form-modal-div').modal('show')
        },
        createModalExit(value) {
            this.create_modal_key += 1;
            if (value == 'sync') {
                this.fetch_data();
            }
        }
    },
}
</script>
