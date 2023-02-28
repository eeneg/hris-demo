<template>
    <div class="row justify-content-center">
        <div class="col-md-12 text-center" v-if="!$gate.isAdministrator() && !$gate.isAuthor()">
            <not-authorized></not-authorized>
        </div>
        <div v-else class="col-md-12">
            <!-- Report -->
            <div class="row" id="nosa_div" style="display: none;margin-top: -1.4rem !important;">
                <div v-for="(employee, index) in print_data" :key="employee.id" class="col-md-12 nosa_div" :style="index + 1 == print_data.length ? '' : 'page-break-after: always;'">
                    <img src="storage/project_files/davsur.png" alt="Agency Logo" class="img-fluid nosi-logo">
                    <div class="row mt-3 mb-2">
                        <div class="col-12 text-center">
                            <h4 class="m-0">PROVINCE OF DAVAO DEL SUR</h4>
                            <h5 class="m-0">Matti, Digos City</h5>
                            <h4 class="m-0">OFFICE OF THE GOVERNOR</h4>
                            <h4 class="m-0 font-weight-bold">NOTICE OF SALARY ADJUSTMENT</h4>
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
                                Pursuant to Local Budget Circular No. <u>{{ lbcn }}</u> dated <u>{{ lbcn_dated | myDate }}</u>, implementing Republic Act No. 11466 dated January 8, 2020 your salary is hereby adjusted effective <u>{{ date_of_effectivity | myDate }}</u> as follows.
                            </h5>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-9">
                            <h5 class="m-0">1. Adjusted monthly basic salary effective <u>{{ date_of_effectivity | myDate }}</u></h5>
                            <h5 class="m-0 mb-3" style="text-indent: 20px;">Under the New Salary Schedule: SG <u>{{ employee.salaryproposed && employee.salaryproposed.grade }}</u> Step <u>{{ employee.salaryproposed && employee.salaryproposed.step }}</u>.</h5>
                            <h5 class="m-0">2. Actual monthly basic salary as of <u>{{ date_of_effectivity | yesterday | myDate }}</u></h5>
                            <h5 class="m-0 mb-3" style="text-indent: 20px;">SG <u>{{ employee.salaryproposed && employee.salaryproposed.grade }}</u> Step <u>{{ employee.salaryproposed && employee.salaryproposed.step }}</u>.</h5>
                            <h5 class="m-0">3. Monthly salary adjustment effective <u>{{ date_of_effectivity | myDate }}</u> (1-2).</h5>
                        </div>
                        <div class="col-3 text-right">
                            <h5 class="m-0"><u v-if="employee.salaryproposed">₱{{ employee.salaryproposed.amount | amount }}</u></h5>
                            <h5 class="m-0 mb-3" style="color: white;">.</h5>
                            <h5 class="m-0"><u v-if="employee.salaryauthorized">₱{{ employee.salaryauthorized.amount | amount }}</u></h5>
                            <h5 class="m-0 mb-3" style="color: white;">.</h5>
                            <h5 class="m-0" v-if="employee.salaryproposed && employee.salaryauthorized"><u>₱{{ (employee.salaryproposed.amount - employee.salaryauthorized.amount) | amount }}.00</u></h5>
                        </div>
                        <div class="col-1"></div>
                    </div>
                    <div class="row mt-4 mb-5">
                        <div class="col-12 text-justify">
                            <h5 class="m-0" style="text-indent: 50px;justify-content: center;">
                                It is understood that this salary adjustment is subject to usual accounting and auditing rules and regulations, and to appropriate re-adjustment and refund if found not in order.
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
                            <h5 class="m-0">Position Title: <u>{{ employee.position }}</u></h5>
                            <h5 class="m-0">Salary Grade: <u>{{ employee.salaryproposed && employee.salaryproposed.grade }}</u></h5>
                            <h5 class="m-0 mb-3">Item No.: <u>{{ employee.item_no }}</u>, FY <u>{{ date_of_effectivity | get_year }}</u> Plantilla of Personnel</h5>
                            <h5 class="m-0">Copy Furnished: GSIS</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-primary card-outline nosa_card">
                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">NOSA Report</h2>
                    <p style="margin: 2px 0 0 2px;">Notice of Salary Adjustment
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
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label style="font-weight: bold; margin: 0;">Print Date</label>
                                        <span class="d-block" style="font-size: 0.8rem;line-height: 0.8rem;">Today's date (editable)</span>
                                        <input class="form-control form-control-border border-width-2" type="date" v-model="date_printed">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label class="m-0" style="font-weight: normal;"><b>Effectivity Date</b></label>
                                        <span class="d-block" style="font-size: 0.8rem;line-height: 0.8rem;">New Salary Schedule effectivity date</span>
                                        <input class="form-control form-control-border border-width-2" type="date" v-model="date_of_effectivity">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2 mb-1">
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label style="font-weight: bold; margin: 0;">Local Budget Circular No.</label>
                                        <input class="form-control form-control-border border-width-2" type="text" v-model="lbcn">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label style="font-weight: bold; margin: 0;">Dated</label>
                                        <input class="form-control form-control-border border-width-2" type="date" v-model="lbcn_dated">
                                    </div>
                                </div>
                            </div>
                            <button @click="print_report()" class="btn btn-primary btn-block" :disabled="!button_enable"><i class="fas fa-print"></i> Print Selected Employee</button>
                            <hr class="mt-4 mb-3">
                            <div class="form-group" style="margin-bottom: 0.3rem;">
                                <label style="font-weight: bold; margin: 0;">Print by Department</label>
                                <v-select class="form-control form-control-border border-width-2" v-model="department" :options="departments" :getOptionLabel="department => department.address"></v-select>
                            </div>
                            <button @click="print_report_all()" class="btn btn-info btn-block mt-2" :disabled="!button_enable"><i class="fas fa-print"></i> Print All Employees from selected Department</button>
                        </div>

                        <!-- Report Preview -->
                        <div class="col-md-6 p-5 nosi_nosa_preview" style="border: 1px solid #dfdfdf;background-color: #fffae8;">
                            <div class="ribbon-wrapper ribbon-lg">
                                <div class="ribbon bg-primary">
                                    PREVIEW
                                </div>
                            </div>
                            <div class="row mt-3 mb-2">
                                <img src="storage/project_files/davsur.png" alt="Agency Logo" class="img-fluid" width="120" style="position: absolute;top: 55px;left: 50px;">
                                <div class="col-12 text-center">
                                    <h4 class="m-0">PROVINCE OF DAVAO DEL SUR</h4>
                                    <h5 class="m-0">Matti, Digos City</h5>
                                    <h4 class="m-0">OFFICE OF THE GOVERNOR</h4>
                                    <h4 class="m-0 font-weight-bold">NOTICE OF SALARY ADJUSTMENT</h4>
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
                                        Pursuant to Local Budget Circular No. <u>{{ lbcn }}</u> dated <u>{{ lbcn_dated | myDate }}</u>, implementing Republic Act No. 11466 dated January 8, 2020 your salary is hereby adjusted effective <u>{{ date_of_effectivity | myDate }}</u> as follows.
                                    </h5>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-9">
                                    <h5 class="m-0">1. Adjusted monthly basic salary effective <u>{{ date_of_effectivity | myDate }}</u></h5>
                                    <h5 class="m-0 mb-3" style="text-indent: 20px;">Under the New Salary Schedule: SG <u>{{ employee.salaryproposed && employee.salaryproposed.grade }}</u> Step <u>{{ employee.salaryproposed && employee.salaryproposed.step }}</u>.</h5>
                                    <h5 class="m-0">2. Actual monthly basic salary as of <u>{{ date_of_effectivity | yesterday | myDate }}</u>.</h5>
                                    <h5 class="m-0 mb-3" style="text-indent: 20px;">SG <u>{{ employee.salaryproposed && employee.salaryproposed.grade }}</u> Step <u>{{ employee.salaryproposed && employee.salaryproposed.step }}</u></h5>
                                    <h5 class="m-0">3. Monthly salary adjustment effective <u>{{ date_of_effectivity | myDate }}</u> (1-2).</h5>
                                </div>
                                <div class="col-3 text-right">
                                    <h5 class="m-0"><u v-if="employee.salaryproposed">₱{{ employee.salaryproposed.amount | amount }}</u></h5>
                                    <h5 class="m-0 mb-3" style="color: white;">.</h5>
                                    <h5 class="m-0"><u v-if="employee.salaryauthorized">₱{{ employee.salaryauthorized.amount | amount }}</u></h5>
                                    <h5 class="m-0 mb-3" style="color: white;">.</h5>
                                    <h5 class="m-0" v-if="employee.salaryproposed && employee.salaryauthorized"><u>₱{{ (employee.salaryproposed.amount - employee.salaryauthorized.amount) | amount }}.00</u></h5>
                                </div>
                                <div class="col-1"></div>
                            </div>
                            <div class="row mt-4 mb-5">
                                <div class="col-12 text-justify">
                                    <h5 class="m-0" style="text-indent: 50px;justify-content: center;">
                                        It is understood that this salary adjustment is subject to usual accounting and auditing rules and regulations, and to appropriate re-adjustment and refund if found not in order.
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
                                    <h5 class="m-0">Position Title: <u>{{ employee.position }}</u></h5>
                                    <h5 class="m-0">Salary Grade: <u>{{ employee.salaryproposed && employee.salaryproposed.grade }}</u></h5>
                                    <h5 class="m-0 mb-3">Item No.: <u>{{ employee.item_no }}</u>, FY <u>{{ date_of_effectivity | get_year }}</u> Plantilla of Personnel</h5>
                                    <h5 class="m-0">Copy Furnished: GSIS</h5>
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
    export default {
        data() {
            return {
                date_printed: moment(new Date()).format('YYYY-MM-DD'),
                date_of_effectivity: moment(new Date()).format('YYYY-MM-DD'),
                lbcn: '0',
                lbcn_dated: moment(new Date()).format('YYYY-MM-DD'),
                employee: {},
                plantilla_content: [],
                departments: [],
                department: {},
                print_data: [],
                button_enable: false
            }
        },
        filters: {
            get_year: (value) => {
                return moment(value).format('YYYY')
            },
            yesterday: (value) => {
                return moment(value).subtract(1, 'days').format('YYYY-MM-DD')
            }
        },
        watch: {

        },
        methods: {
            print_report() {
                this.print_data = []
                this.print_data.push(this.employee)
                this.$nextTick(function () {
                    window.print()
                })
            },
            print_report_all() {
                var filtered = _.filter(this.plantilla_content, (content) => { 
                    return content.office == this.department.address
                });
                this.print_data = filtered
                this.$nextTick(function () {
                    window.print()
                })
            },
            fetch_employees() {
                this.$Progress.start()
                axios.get('api/plantillaForNosa')
                    .then(({data}) => {
                        this.departments = data.departments;
                        var first_department = data.departments[0];
                        this.department = first_department;

                        this.plantilla_content = data.plantillacontents;
                        var first_employee = data.plantillacontents[0];
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
