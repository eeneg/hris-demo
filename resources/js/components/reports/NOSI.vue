<template>
    <div class="row justify-content-center">
        <div class="col-md-12 text-center" v-if="!$gate.isAdministrator() && !$gate.isAuthor()">
            <not-authorized></not-authorized>
        </div>
        <div v-else class="col-md-12">
            <!-- Report -->
            <div class="row" id="nosi_div" style="display: none;margin-top: -1.4rem !important;">
                <div class="col-md-12 nosi_div" style="page-break-after: always;" v-if="print_data.length > 1">
                    <img src="storage/project_files/davsur.png" alt="Agency Logo" class="img-fluid nosi-logo">
                    <div class="row mt-3 mb-2">
                        <div class="col-12 text-center">
                            <h5 class="m-0">Republic of the Philippines</h5>
                            <h4 class="m-0 font-weight-bold">PROVINCE OF DAVAO DEL SUR</h4>
                            <h5 class="m-0 mb-5">Matti, Digos City</h5>
                            <h4 class="m-0 mb-5 font-weight-bold">PROVINCIAL HUMAN RESOURCE MANAGEMENT OFFICE</h4>
                            <h5 class="m-0 font-weight-bold">TRANSMITTAL</h5>
                            <h5 class="m-0">Notice of Step Increment for CY {{ nosi_year }}</h5>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-9 mt-3">
                            <h5 class="m-0">Office: <b>{{ department.title }}</b></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered transmittal-table">
                                <thead>
                                    <tr>
                                        <td><b>EMPLOYEE</b></td>
                                        <td><b>DATE HIRED/PROMOTION</b></td>
                                        <td><b>DATE OF STEP INCREMENT</b></td>
                                        <td><b>AMOUNT</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="data in print_data" :key="data.id">
                                        <td><b>{{ data.name2 }}</b><p style="margin: 0 !important"><small>{{ data.position }}</small></p></td>
                                        <td>{{ data.nosi_schedule }}</td>
                                        <td>{{ data.nosi_schedule | myDateWithYear(nosi_year) }}</td>
                                        <td>
                                            <p style="margin: 0 !important"><small>Actual: <b>₱{{ data.forReport.current_amount | amount }}</b></small></p>
                                            <p style="margin: 0 !important"><small>Adjusted: <b>₱{{ data.forReport.next_amount | amount }}</b></small></p>
                                            <p style="margin: 0 !important"><small>Difference: <b>₱{{ (data.forReport.next_amount - data.forReport.current_amount) | amount }}</b></small></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right"><b>Total Difference:</b></td>
                                        <td><b>₱{{ print_data.reduce((acc, curr) => acc + (curr.forReport.next_amount - curr.forReport.current_amount), 0) | amount }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-5 mb-3">
                        <div class="col-12">
                            <h5 class="m-0">Total: {{ print_data.length }} employees</h5>
                        </div>
                    </div>
                </div>
                <div v-for="(employee, index) in print_data" :key="employee.id" class="col-md-12 nosi_div" :style="index + 1 == print_data.length ? '' : 'page-break-after: always;'">
                    <img src="storage/project_files/davsur.png" alt="Agency Logo" class="img-fluid nosi-logo">
                    <div class="row mt-3 mb-2">
                        <div class="col-12 text-center">
                            <h5 class="m-0">Republic of the Philippines</h5>
                            <h4 class="m-0 font-weight-bold">PROVINCIAL GOVERNMENT OF DAVAO DEL SUR</h4>
                            <h5 class="m-0">Brgy. Matti, Digos City</h5>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 text-right">
                            <h5 class="m-0 font-weight-bold">Annex "B"</h5>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 text-center">
                            <h4 class="m-0 font-weight-bold">NOTICE OF STEP INCREMENT DUE TO LENGTH OF SERVICE</h4>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-9 mt-5">
                            <h5 class="m-0 font-weight-bold" style="text-transform: uppercase;">{{ employee.title }} {{ employee.name }}</h5>
                            <h5 class="m-0">{{ employee.position }}</h5>
                            <h5 class="m-0">{{ employee.office }}</h5>
                            <h5 class="mt-5">Dear {{ employee.title }} {{ employee.surname }}:</h5>
                        </div>
                        <div class="col-3 text-right">
                            <h5>Date: {{ date_printed | myDate }}</h5>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 text-justify">
                            <h5 class="m-0" style="text-indent: 65px;justify-content: center;">
                                Pursuant to the Civil Service Commission and Department of Budget and Management Joint Circular No. 1 dated September 3, 2012, implementing item (4)(d) of the Senate and House of Representatives Joint Resolution No. 4, s. 2009, approved on June 17, 2009, your salary as <u><b>{{ employee.position }}</b></u> is hereby adjusted effective <u><b>{{ employee.nosi_schedule | myDateWithYear(nosi_year) }}</b></u>, as follows:
                            </h5>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-9">
                            <h5 class="m-0">1.<span style="padding-left: 50px;">Actual monthly basic salary as of <b><u>{{ employee.nosi_schedule | minusOneDayWithYear(nosi_year) }}</u></b></span></h5>
                            <h5 class="m-0"><span style="padding-left: 65px;">(SG-<b><u>{{ employee.salaryproposed && employee.salaryproposed.grade }}</u></b>, Step <b><u>{{ employee.forReport.step }}</u></b>)</span></h5>
                            <h5 class="m-0 mt-3">2.<span style="padding-left: 50px;">Add: one (1) Step Increment</span></h5>
                            <h5 class="m-0"><span style="padding-left: 65px;">Due to Length of Service</span></h5>
                            <h5 class="m-0 mt-3">3.<span style="padding-left: 50px;">Adjusted monthly basic salary effective <b><u>{{ employee.nosi_schedule | myDateWithYear(nosi_year) }}</u></b></span></h5>
                        </div>
                        <div class="col-3 text-right">
                            <h5 class="m-0">
                                ₱<b><u v-if="employee.salaryproposed">{{ employee.forReport.current_amount | amount }}</u></b>
                            </h5>
                            <h5 class="m-0" style="color: white;">.</h5>
                            <h5 class="m-0 mt-3">₱<b><u>{{ (employee.forReport.next_amount - employee.forReport.current_amount) | amount }}</u></b></h5>
                            <h5 class="m-0" style="color: white;">.</h5>
                            <h5 class="m-0 mt-3">₱<b><u>{{ employee.forReport.next_amount | amount }}</u></b></h5>
                        </div>
                    </div>
                    <div class="row mt-4 mb-5">
                        <div class="col-12 text-justify">
                            <h5 class="m-0" style="text-indent: 65px;justify-content: center;">
                                This salary adjustment is subject to review and post-audit, and to appropriate re-adjustment and refund if found not in order.
                            </h5>
                        </div>
                    </div>
                    <div class="row mt-5 mb-5">
                        <div class="col-8"></div>
                        <div class="col-4 mt-5">
                            <h5 class="ml-5">Very truly yours,</h5>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-8"></div>
                        <div class="col-4 mt-5 text-center">
                            <h5 class="m-0"><b>{{ signatory }}</b></h5>
                            <h5 class="m-0">{{ position }}</h5>
                        </div>
                    </div>
                    <div class="row mt-5 mb-3">
                        <div class="col-12">
                            <h5 class="m-0">Item No. <b><u>{{ employee.item_no }}</u></b></h5>
                            <h5 class="m-0">FY <b><u>{{ nosi_year }}</u></b> Plantilla of Personnel</h5>
                            <h5 class="m-0 mt-5">CF: GSIS</h5>
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
                            <div class="row mt-2 mb-1">
                                <div class="col-md-9">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label style="font-weight: bold; margin: 0;">Select Employee</label>
                                        <v-select class="form-control form-control-border border-width-2" @input="generateNOSI()" v-model="employee"  :options="plantilla_content" :getOptionLabel="employee => employee.name"></v-select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label style="font-weight: bold; margin: 0;">Year</label>
                                        <input class="form-control form-control-border border-width-2 mr-2" type="number" v-model="ind_nosi_year">
                                    </div>
                                </div>
                            </div>
                            <span class="d-block" style="font-size: 0.8rem;line-height: 0.8rem;">Date of last promotion / original appointment: <b class="text-primary">{{ employee.nosi_schedule }}</b></span>
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
                                        <span class="d-block" style="font-size: 0.8rem;line-height: 0.8rem;">Based on NOSI Schedule</span>
                                        <input class="form-control form-control-border border-width-2" type="date" v-model="employee.nosi_schedule">
                                    </div>
                                </div>
                            </div>
                            <div class="row row mt-2 mb-1">
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label style="font-weight: bold; margin: 0;">Signatory</label>
                                        <input v-model="signatory" class="form-control form-control-border border-width-2" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label style="font-weight: bold; margin: 0;">Position</label>
                                        <input v-model="position" class="form-control form-control-border border-width-2" type="text">
                                    </div>
                                </div>
                            </div>
                            <button @click="print_report()" class="btn btn-primary btn-block" :disabled="!button_enable"><i class="fas fa-print"></i> Print Report</button>
                            <hr class="mt-4 mb-3">
                            <h4>NOSI Lookup</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group" style="margin-bottom: 0.3rem;">
                                                <label style="font-weight: bold; margin: 0;">Department</label>
                                                <v-select class="form-control form-control-border border-width-2" v-model="department" :options="departments" :getOptionLabel="department => department.address"></v-select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <form @submit.prevent="lookup()">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label style="font-weight: bold; margin: 0;">Year</label>
                                                    <input class="form-control form-control-border border-width-2 mr-2" type="number" v-model="nosi_year">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label style="font-weight: bold; margin: 0;">Month</label>
                                                    <v-select class="form-control form-control-border border-width-2 mr-2" v-model="nosi_month" :options="months"></v-select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-success">View</button>
                                                <button type="button" class="btn btn-primary ml-2" :disabled="lookup_data.length == 0" @click="print_report_lookup()"><i class="fas fa-print"></i> Print All</button>
                                            </div>
                                        </div>
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
                                                        <span class="d-block" style="font-size: 0.8rem;line-height: 0.8rem;">{{ data.position }}</span>
                                                        <span class="d-block" style="font-size: 0.8rem;line-height: 0.8rem;">NOSI Schedule: <b class="text-primary">{{ data.nosi_schedule }}</b></span>
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
                            <div v-if="included">
                                <div class="ribbon-wrapper ribbon-lg">
                                    <div class="ribbon bg-primary">
                                        PREVIEW
                                    </div>
                                </div>
                                <div class="row mt-3 mb-2">
                                    <img src="storage/project_files/davsur.png" alt="Agency Logo" class="img-fluid" width="100" style="position: absolute;top: 55px;left: 80px;">
                                    <div class="col-12 text-center">
                                        <h5 class="m-0">Republic of the Philippines</h5>
                                        <h4 class="m-0 font-weight-bold">PROVINCIAL GOVERNMENT OF DAVAO DEL SUR</h4>
                                        <h5 class="m-0">Brgy. Matti, Digos City</h5>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-12 text-center">
                                        <h4 class="m-0 font-weight-bold">NOTICE OF STEP INCREMENT DUE TO LENGTH OF SERVICE</h4>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-9 mt-5">
                                        <h5 class="m-0 font-weight-bold" style="text-transform: uppercase;">{{ employee.title }} {{ employee.name }}</h5>
                                        <h5 class="m-0">{{ employee.position }}</h5>
                                        <h5 class="m-0">{{ employee.office }}</h5>
                                        <h5 class="mt-5">Dear {{ employee.title }} {{ employee.surname }}:</h5>
                                    </div>
                                    <div class="col-3 text-right">
                                        <h5>Date: {{ date_printed | myDate }}</h5>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 text-justify">
                                        <h5 class="m-0" style="text-indent: 65px;justify-content: center;">
                                            Pursuant to the Civil Service Commission and Department of Budget and Management Joint Circular No. 1 dated September 3, 2012, implementing item (4)(d) of the Senate and House of Representatives Joint Resolution No. 4, s. 2009, approved on June 17, 2009, your salary as <u><b>{{ employee.position }}</b></u> is hereby adjusted effective <u><b>{{ employee.nosi_schedule | myDateWithYear(nosi_year) }}</b></u>, as follows:
                                        </h5>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-9">
                                        <h5 class="m-0">1.<span style="padding-left: 50px;">Actual monthly basic salary as of <b><u>{{ employee.nosi_schedule | minusOneDayWithYear(nosi_year) }}</u></b></span></h5>
                                        <h5 class="m-0"><span style="padding-left: 65px;">(SG-<b><u>{{ employee.salaryproposed && employee.salaryproposed.grade }}</u></b>, Step <b><u>{{ employee.forReport.step }}</u></b>)</span></h5>
                                        <h5 class="m-0 mt-3">2.<span style="padding-left: 50px;">Add: one (1) Step Increment</span></h5>
                                        <h5 class="m-0"><span style="padding-left: 65px;">Due to Length of Service</span></h5>
                                        <h5 class="m-0 mt-3">3.<span style="padding-left: 50px;">Adjusted monthly basic salary effective <b><u>{{ employee.nosi_schedule | myDateWithYear(nosi_year) }}</u></b></span></h5>
                                    </div>
                                    <div class="col-3 text-right">
                                        <h5 class="m-0">
                                            ₱<b><u v-if="employee.salaryproposed">{{ employee.forReport.current_amount | amount }}</u></b>
                                        </h5>
                                        <h5 class="m-0" style="color: white;">.</h5>
                                        <h5 class="m-0 mt-3">₱<b><u>{{ (employee.forReport.next_amount - employee.forReport.current_amount) | amount }}</u></b></h5>
                                        <h5 class="m-0" style="color: white;">.</h5>
                                        <h5 class="m-0 mt-3">₱<b><u>{{ employee.forReport.next_amount | amount }}</u></b></h5>
                                    </div>
                                </div>
                                <div class="row mt-4 mb-5">
                                    <div class="col-12 text-justify">
                                        <h5 class="m-0" style="text-indent: 65px;justify-content: center;">
                                            This salary adjustment is subject to review and post-audit, and to appropriate re-adjustment and refund if found not in order.
                                        </h5>
                                    </div>
                                </div>
                                <div class="row mt-5 mb-3">
                                    <div class="col-12">
                                        <h5 class="m-0">Item No. <b><u>{{ employee.item_no }}</u></b></h5>
                                        <h5 class="m-0">FY <b><u>{{ nosi_year }}</u></b> Plantilla of Personnel</h5>
                                        <h5 class="m-0 mt-5">CF: GSIS</h5>
                                    </div>
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
                months: ["All", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                // date_of_appointment: moment(new Date()).format('YYYY-MM-DD'),
                // date_of_effectivity: moment(this.date_of_appointment).add(1, "days"),
                employee: {},
                plantilla_content: [],
                nosi_year: moment(new Date()).format('YYYY'),
                nosi_month: "All",
                lookup_data: [],
                print_data: [],
                button_enable: false,
                departments: [],
                department: {},
                ind_nosi_year: moment(new Date()).format('YYYY'),
                included: false,
                signatory: 'YVONNE R. CAGAS',
                position: 'Provincial Governor',
                forReport: {
                    step: 0,
                    current_amount: 0,
                    next_amount: 0,
                }
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
            generateForReport(employee, nosi_sched, year) {
                let current_step = (parseInt(year) - nosi_sched) / 3
                let forReport = {
                    step: current_step,
                    current_amount: current_step == employee.salaryproposed.step ? (employee.working_time == "Full-time" ? employee.salaryproposed.amount : (employee.salaryproposed.amount / 2)) : employee.previousStepAmount,
                    next_amount: current_step == employee.salaryproposed.step ? employee.nextStepAmount : (employee.working_time == "Full-time" ? employee.salaryproposed.amount : (employee.salaryproposed.amount / 2))
                }
                return _.assign({forReport: forReport}, employee)
            },
            generateNOSI() {
                if (!this.employee) {
                    this.included = false
                    this.button_enable = false
                    return
                }

                var nosi_years = []
                let nosi_sched = parseInt(moment(this.employee.nosi_schedule).format('YYYY'))
                for (let index = 1; index <= 7; index++) {
                    nosi_years.push(nosi_sched + (3 * index))
                }
                if(nosi_years.includes(parseInt(this.ind_nosi_year))) {
                    this.employee = this.generateForReport(this.employee, nosi_sched, this.ind_nosi_year)

                    this.included = true
                    this.button_enable = true
                } else {
                    this.included = false
                    this.button_enable = false
                }
            },
            fetch_employees() {
                this.$Progress.start()
                axios.get('api/plantillaForNosi')
                    .then(({data}) => {
                        this.plantilla_content = data.plantillacontents;
                        var first_employee = data.plantillacontents[0];
                        this.employee = first_employee;

                        this.departments = data.departments;
                        this.departments.unshift({'address': 'All'})
                        var first_department = data.departments[0];
                        this.department = first_department;

                            // this.date_of_appointment = first_employee.last_promotion ? moment(first_employee.last_promotion).year(moment().format('YYYY')).format('YYYY-MM-DD') : moment(first_employee.original_appointment).year(moment().format('YYYY')).format('YYYY-MM-DD')
                            // this.print_data.push(first_employee)
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    })
                    .finally(() => {
                        // this.button_enable = true
                        this.$Progress.finish()
                    });
            },
            lookup() {
                this.lookup_data = []
                this.plantilla_content.forEach(content => {
                    if (content.nosi_schedule && content.salaryproposed) {
                        if (this.nosi_year > moment(content.nosi_schedule).format('YYYY')) {
                            var nosi_years = []
                            var nosi_sched = parseInt(moment(content.nosi_schedule).format('YYYY'))
                            for (let index = 1; index <= 7; index++) {
                                nosi_years.push(nosi_sched + (3 * index))
                            }

                            var included = nosi_years.includes(parseInt(this.nosi_year));
                            var office = this.department.address == 'All' ? true : content.office == this.department.address

                            if (this.nosi_month != "All") {
                                var month_inc = moment(content.nosi_schedule).format('MMMM') == this.nosi_month
                            } else {
                                var month_inc = true
                            }

                            if (included && office && month_inc) {
                                content = this.generateForReport(content, nosi_sched, this.nosi_year)
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
