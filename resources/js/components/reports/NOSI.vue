<template>
    <div class="row justify-content-center">
        <div class="col-md-12 text-center" v-if="!$gate.isAdministrator() && !$gate.isAuthor()">
            <not-authorized></not-authorized>
        </div>
        <div v-else class="col-md-12">
            <!-- Report -->
            <div class="row" id="nosi_div" style="display: none;margin-top: -1.4rem !important;">
                <div v-for="(employee, index) in print_data" :key="employee.id" class="col-md-12 nosi_div" :style="index + 1 == print_data.length ? '' : 'page-break-after: always;'">
                    <img src="storage/project_files/davsur.png" alt="Agency Logo" class="img-fluid nosi-logo">
                    <div class="row mt-3 mb-2">
                        <div class="col-12 text-center">
                            <h4 class="m-0">PROVINCE OF DAVAO DEL SUR</h4>
                            <h5 class="m-0">Matti, Digos City</h5>
                            <h4 class="m-0">OFFICE OF THE GOVERNOR</h4>
                            <h4 class="m-0 font-weight-bold">NOTICE OF STEP INCREMENT</h4>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-9 mt-3">
                            <h5 class="m-0">{{ employee.name }}</h5>
                            <h5 class="m-0">{{ employee.position }}</h5>
                            <h5 class="m-0">{{ employee.office }}</h5>
                            <h5 class="m-0">Province of Davao del Sur</h5>
                            <h5 class="mt-4">Sir/Madam:</h5>
                        </div>
                        <div class="col-3 text-right">
                            <h5><u>{{ date_printed | myDate }}</u></h5>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 text-justify">
                            <h5 class="m-0" style="text-indent: 50px;justify-content: center;">
                                Pursuant to Joint Civil Service Commission (CSC) and Department of Budget and Management (DBM) Circular No. 1, s. 1990 implementing Section 13 &copy; of RA No. 6765, your salary as <u>{{ employee.position }} SG {{ employee.salaryproposed && employee.salaryproposed.grade }}-{{ employee.salaryproposed && employee.salaryproposed.step }}</u> is hereby adjusted effective <u>{{ employee.appointment_date | myDate }}</u>.
                            </h5>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-8">
                            <h5 class="m-0" style="text-indent: 50px;">Basic Monthly Salary</h5>
                            <h5 class="m-0" style="text-indent: 75px;">As of <u>{{ employee.appointment_date | minusOneDay }}</u></h5>
                            <h5 class="m-0" style="text-indent: 50px;">Salary Adjustment</h5>
                            <h5 class="m-0" style="text-indent: 75px;">a. Merit (<u>0</u> step/s)</h5>
                            <h5 class="m-0" style="text-indent: 75px;">b. Length of Service <u>1</u> step/s</h5>
                            <h5 class="m-0" style="text-indent: 50px;">Adjusted Salary Effective <u>{{ employee.appointment_date | myDate }}</u></h5>
                        </div>
                        <div class="col-3 text-right">
                            <h5 class="m-0" style="color: white;">.</h5>
                            <h5 class="m-0">
                                <u v-if="employee.salaryproposed">₱{{ employee.salaryproposed.amount | amount }}</u>
                            </h5>
                            <h5 class="m-0" style="color: white;">.</h5>
                            <h5 class="m-0" style="color: white;">.</h5>
                            <h5 class="m-0" v-if="employee.nextStepAmount"><u>₱{{ (employee.nextStepAmount - employee.salaryproposed.amount) | amount }}.00</u></h5>
                            <h5 class="m-0" v-if="employee.nextStepAmount"><u>₱{{ employee.nextStepAmount | amount }}</u></h5>
                        </div>
                        <div class="col-1"></div>
                    </div>
                    <div class="row mt-4 mb-5">
                        <div class="col-12 text-justify">
                            <h5 class="m-0" style="text-indent: 50px;justify-content: center;">
                                The step increment/s is/are subject to review and Post Audit by the Department of Budget and Management and Subject to re-adjustment and refund if found not in order.
                            </h5>
                        </div>
                    </div>
                    <div class="row mt-5 mb-5">
                        <div class="col-6"></div>
                        <div class="col-6 mt-5">
                            <h5 class="m-0">Very truly yours,</h5>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-6"></div>
                        <div class="col-6 text-center mt-5">
                            <h5 class="m-0"><b>YVONNE R. CAGAS</b></h5>
                            <h5 class="m-0">Provincial Governor</h5>
                        </div>
                    </div>
                    <div class="row mt-5 mb-3">
                        <div class="col-12">
                            <h5 class="m-0">Copy Furnished</h5>
                            <h5 class="m-0">- GSIS</h5>
                            <h5 class="m-0">- Office Concerned</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="card card-primary card-outline nosi_card">
                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">NOSI Report</h2>
                    <p style="margin: 2px 0 0 2px;">Notice of Step Increment
                    (Employees are based on Annual Plantilla {{ this.$parent.settings.plantilla && this.$parent.settings.plantilla.year }})
                    </p>
                </div>
                <div class="card-body">
                    <div class="row pr-3">
                        <div class="col-md-6 pr-5">
                            <div class="form-group" style="margin-bottom: 0.3rem;">
                                <label style="font-weight: bold; margin: 0;">Select Employee</label>
                                <v-select class="form-control form-control-border border-width-2" v-model="employee" :options="plantilla_content" :getOptionLabel="employee => employee.name"></v-select>
                            </div>
                            <span class="d-block" style="font-size: 0.8rem;line-height: 0.8rem;">Date of last promotion / original appointment: <b class="text-primary">{{ employee.last_promotion ? employee.last_promotion : employee.original_appointment }}</b></span>
                            <span class="d-block" style="font-size: 0.8rem;line-height: 0.8rem;">{{ employee.office }}</span>
                            <div class="row mt-2 mb-1">
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label style="font-weight: bold; margin: 0;">Print Date</label>
                                        <span class="d-block" style="font-size: 0.8rem;line-height: 0.8rem;">Today's date (editable)</span>
                                        <input class="form-control form-control-border border-width-2" type="date" v-model="date_printed">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label class="m-0" style="font-weight: normal;"><b>Date </b>(Last day of current step)</label>
                                        <span class="d-block" style="font-size: 0.8rem;line-height: 0.8rem;">Based on date of original appointment / last promotion</span>
                                        <input class="form-control form-control-border border-width-2" type="date" v-model="employee.appointment_date">
                                    </div>
                                </div>
                            </div>
                            <button @click="print_report()" class="btn btn-primary btn-block" :disabled="!button_enable"><i class="fas fa-print"></i> Print Report</button>
                            <hr class="mt-4 mb-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-weight: bold; margin: 0;">NOSI Lookup</label>
                                    <form class="form-inline" @submit.prevent="lookup()">
                                        <input class="form-control form-control-border border-width-2 mr-2" type="number" v-model="nosi_year">
                                        <button type="submit" class="btn btn-success" :disabled="!button_enable">View</button>
                                        <button type="button" class="btn btn-primary ml-2" :disabled="lookup_data.length == 0" @click="print_report_lookup()"><i class="fas fa-print"></i> Print All</button>
                                    </form>
                                    <span class="text-primary d-block" style="font-size: 0.8rem;font-weight: bold;">Lookup results: {{ lookup_data.length }} records</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="card-body table-responsive p-0" style="height: 450px;">
                                        <table class="table table-striped text-nowrap custom-table">
                                            <tbody>
                                                <tr v-for="data in lookup_data" :key="data.id">
                                                    <td>
                                                        <b>{{ data.name }}</b> (SG {{ data.salaryproposed.grade + '-' + data.salaryproposed.step }})
                                                        <span class="d-block" style="font-size: 0.8rem;line-height: 0.8rem;">Date of last promotion / original appointment: <b class="text-primary">{{ data.last_promotion ? data.last_promotion : data.original_appointment }}</b></span>
                                                        <span class="d-block" style="font-size: 0.8rem;line-height: 0.8rem;">{{ data.position }}</span>
                                                        <span class="d-block" style="font-size: 0.8rem;line-height: 0.8rem;">{{ data.office }}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Report Preview -->
                        <div class="col-md-6 p-5 nosi_nosa_preview" style="border: 1px solid #dfdfdf;background-color: #fffae8;">
                            <div class="ribbon-wrapper ribbon-lg">
                                <div class="ribbon bg-primary">
                                    PREVIEW
                                </div>
                            </div>
                            <div class="row mt-3 mb-2">
                                <img src="storage/project_files/davsur.png" alt="Agency Logo" class="img-fluid" width="100" style="position: absolute;top: 55px;left: 80px;">
                                <div class="col-12 text-center">
                                    <h5 class="m-0">PROVINCE OF DAVAO DEL SUR</h5>
                                    <h5 class="m-0">Matti, Digos City</h5>
                                    <h5 class="m-0">OFFICE OF THE GOVERNOR</h5>
                                    <h5 class="m-0 font-weight-bold">NOTICE OF STEP INCREMENT</h5>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-9 mt-3">
                                    <h5 class="m-0">{{ employee.name }}</h5>
                                    <h5 class="m-0">{{ employee.position }}</h5>
                                    <h5 class="m-0">{{ employee.office }}</h5>
                                    <h5 class="m-0">Province of Davao del Sur</h5>
                                    <h5 class="mt-4">Sir/Madam:</h5>
                                </div>
                                <div class="col-3 text-right">
                                    <h5><u>{{ date_printed | myDate }}</u></h5>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 text-justify">
                                    <h5 class="m-0" style="text-indent: 50px;justify-content: center;">
                                        Pursuant to Joint Civil Service Commission (CSC) and Department of Budget and Management (DBM) Circular No. 1, s. 1990 implementing Section 13 &copy; of RA No. 6765, your salary as <u>{{ employee.position }} SG {{ employee.salaryproposed && employee.salaryproposed.grade }}-{{ employee.salaryproposed && employee.salaryproposed.step }}</u> is hereby adjusted effective <u>{{ employee.appointment_date | myDate }}</u>.
                                    </h5>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-8">
                                    <h5 class="m-0" style="text-indent: 50px;">Basic Monthly Salary</h5>
                                    <h5 class="m-0" style="text-indent: 75px;">As of <u>{{ employee.appointment_date | minusOneDay }}</u></h5>
                                    <h5 class="m-0" style="text-indent: 50px;">Salary Adjustment</h5>
                                    <h5 class="m-0" style="text-indent: 75px;">a. Merit (<u>0</u> step/s)</h5>
                                    <h5 class="m-0" style="text-indent: 75px;">b. Length of Service <u>1</u> step/s</h5>
                                    <h5 class="m-0" style="text-indent: 50px;">Adjusted Salary Effective <u>{{ employee.appointment_date | myDate }}</u></h5>
                                </div>
                                <div class="col-3 text-right">
                                    <h5 class="m-0" style="color: white;">.</h5>
                                    <h5 class="m-0">
                                        <u v-if="employee.salaryproposed">₱{{ employee.salaryproposed.amount | amount }}</u>
                                    </h5>
                                    <h5 class="m-0" style="color: white;">.</h5>
                                    <h5 class="m-0" style="color: white;">.</h5>
                                    <h5 class="m-0" v-if="employee.nextStepAmount"><u>₱{{ (employee.nextStepAmount - employee.salaryproposed.amount) | amount }}.00</u></h5>
                                    <h5 class="m-0" v-if="employee.nextStepAmount"><u>₱{{ employee.nextStepAmount | amount }}</u></h5>
                                </div>
                                <div class="col-1"></div>
                            </div>
                            <div class="row mt-4 mb-5">
                                <div class="col-12 text-justify">
                                    <h5 class="m-0" style="text-indent: 50px;justify-content: center;">
                                        The step increment/s is/are subject to review and Post Audit by the Department of Budget and Management and Subject to re-adjustment and refund if found not in order.
                                    </h5>
                                </div>
                            </div>
                            <div class="row mt-5 mb-5">
                                <div class="col-6"></div>
                                <div class="col-6 mt-5">
                                    <h5 class="m-0">Very truly yours,</h5>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-6"></div>
                                <div class="col-6 text-center mt-5">
                                    <h5 class="m-0"><b>YVONNE R. CAGAS</b></h5>
                                    <h5 class="m-0">Provincial Governor</h5>
                                </div>
                            </div>
                            <div class="row mt-5 mb-3">
                                <div class="col-12">
                                    <h5 class="m-0">Copy Furnished</h5>
                                    <h5 class="m-0">- GSIS</h5>
                                    <h5 class="m-0">- Office Concerned</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        data() {
            return {
                date_printed: moment(new Date()).format('YYYY-MM-DD'),
                // date_of_appointment: moment(new Date()).format('YYYY-MM-DD'),
                // date_of_effectivity: moment(this.date_of_appointment).add(1, "days"),
                employee: {},
                plantilla_content: [],
                nosi_year: moment(new Date()).format('YYYY'),
                lookup_data: [],
                print_data: [],
                button_enable: false
            }
        },
        watch: {
            // employee(newData) {
            //     this.date_of_appointment = newData.last_promotion ? moment(newData.last_promotion).year(moment().format('YYYY')).format('YYYY-MM-DD') : moment(newData.original_appointment).year(moment().format('YYYY')).format('YYYY-MM-DD')
            //     this.date_of_effectivity = moment(this.date_of_appointment).add(1, "days")
            // }
        },
        methods: {
            print_report() {
                this.print_data = []
                this.print_data.push(this.employee)
                this.$nextTick(function () {
                    window.print()
                })
            },
            print_report_lookup() {
                this.print_data = this.lookup_data
                this.$nextTick(function () {
                    window.print()
                })
            },
            fetch_employees() {
                this.$Progress.start()
                axios.get('api/plantillaForNosi')
                    .then(({data}) => {
                        this.plantilla_content = data.data;
                        var first_employee = data.data[0];
                        this.employee = first_employee;
                        this.date_of_appointment = first_employee.last_promotion ? moment(first_employee.last_promotion).year(moment().format('YYYY')).format('YYYY-MM-DD') : moment(first_employee.original_appointment).year(moment().format('YYYY')).format('YYYY-MM-DD')
                        this.print_data.push(first_employee)
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    })
                    .finally(() => {
                        this.button_enable = true
                        this.$Progress.finish()
                    });
            },
            lookup() {
                this.lookup_data = []
                this.plantilla_content.forEach(content => {
                    if (content.appointment_date && content.salaryproposed) {
                        if (this.nosi_year > moment(content.appointment_date).format('YYYY')) {
                            var divisible = (this.nosi_year - moment(content.appointment_date).format('YYYY')) % 3 == 0;
                            var included = (8 - content.salaryproposed.step) >= ((this.nosi_year - moment(content.appointment_date).format('YYYY')) / 3);
                            if (included && divisible) {
                                this.lookup_data.push(content)
                            }
                        }
                    }
                });
            }
        },
        mounted() {
            // console.log('Component mounted.')
        },
        created() {
            this.fetch_employees()
        }
    }
</script>
