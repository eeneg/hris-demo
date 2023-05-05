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
                            <h4 class="m-0 font-weight-bold" v-if="report_type == 'Retirees of Specific Year'">Retirees of year {{ retirees_report.year }}</h4>
                            <h4 class="m-0 font-weight-bold" v-if="report_type == 'Birthday Celebrants'">Birthday Celebrants</h4>
                        </div>
                    </div>

                    <!-- Reports -->
                    <div v-if="report_type == 'Positions with specific salary grade/s'">
                        <div class="row mb-2">
                            <div class="col-12">
                                <h3 class="m-0"><b>Salary Grade:</b> {{ salary_grades_report.salary_grade }}</h3>
                                <h3 class="m-0"><b>Status:</b> <span class="badge bg-primary mr-2" v-if="salary_grades_report.status_occupied">OCCUPIED</span><span class="badge bg-success" v-if="salary_grades_report.status_vacant">VACANT</span></h3>
                                <h3 class="m-0"><b>Office:</b> {{ department }}</h3>
                                <h3 class="m-0"><b>Result count:</b> {{ print_data.length }}</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered m-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Position</th>
                                            <th>Item #</th>
                                            <th>SG</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in print_data" :key="index">
                                            <td class="align-middle pt-1 pb-1">{{ index + 1 }}.</td>
                                            <td class="align-middle pt-1 pb-1">
                                                {{ item.position }}
                                                <small class="d-block">{{ item.office }}</small>
                                                <small class="d-block font-weight-bold" :class="item.name == 'VACANT' ? 'text-success' : 'text-primary'">{{ item.name }}</small>
                                            </td>
                                            <td class="align-middle pt-1 pb-1">{{ item.new_number ? item.new_number : item.old_number }}</td>
                                            <td class="align-middle pt-1 pb-1">{{ item.salaryproposed.grade }}</td>
                                            <td class="align-middle pt-1 pb-1">{{ item.salaryproposed.amount | amount }} / month</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div v-if="report_type == 'Names & Position'">
                        <div class="row mb-2">
                            <div class="col-6">
                                <h3 class="m-0"><b>Office:</b> {{ department }}</h3>
                                <h3 class="m-0"><b>Gender:</b> {{ employee_names_report.gender }}</h3>
                                <h3 class="m-0"><b>Result count:</b> {{ print_data.length }}, Male {{ employee_names_report.male }}, Female {{ employee_names_report.female }}</h3>
                            </div>
                            <div class="col-6">
                                <h3 class="m-0"><b>Eligibility:</b> {{ employee_names_report.csc_level }}</h3>
                                <h3 class="m-0"><b>Age:</b> {{ employee_names_report.age_range != '' ? employee_names_report.age_range : 'All' }}</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered m-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Item#</th>
                                            <th>Position</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in print_data" :key="index">
                                            <td class="align-middle pt-1 pb-1">{{ index + 1 }}.</td>
                                            <td class="align-middle pt-1 pb-1">
                                                <span style="font-weight: bold;" :class="item.sex == 'Female' ? 'text-success' : 'text-primary'">{{ item.name }}</span>
                                                <small class="d-block">{{ item.office }}</small>
                                            </td>
                                            <td class="align-middle pt-1 pb-1">{{ item.new_number ? item.new_number : item.old_number }}</td>
                                            <td class="align-middle pt-1 pb-1">
                                                {{ item.position }} (SG {{ item.salaryproposed.grade }}-{{ item.salaryproposed.step }})
                                                <small class="d-block m-0">{{ item.salaryproposed.amount | amount }} / month</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div v-if="report_type == 'Retirees of Specific Year'">
                        <div class="row mb-2">
                            <div class="col-6">
                                <h3 class="m-0"><b>Office:</b> {{ department }}</h3>
                                <h3 class="m-0"><b>Result count:</b> {{ print_data.length }}</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered m-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Birthdate</th>
                                            <th>Position</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in print_data" :key="index">
                                            <td class="align-middle pt-1 pb-1">{{ index + 1 }}.</td>
                                            <td class="align-middle pt-1 pb-1">
                                                <span style="font-weight: bold;">{{ item.name }}</span>
                                                <small class="d-block">{{ item.office }}</small>
                                            </td>
                                            <td class="align-middle pt-1 pb-1">{{ item.birthdate | myDate }}</td>
                                            <td class="align-middle pt-1 pb-1">
                                                #{{ item.new_number ? item.new_number : item.old_number }} - 
                                                {{ item.position }} (SG {{ item.salaryproposed.grade }}-{{ item.salaryproposed.step }})
                                                <small class="d-block m-0">{{ item.salaryproposed.amount | amount }} / month</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div v-if="report_type == 'Birthday Celebrants'">
                        <div class="row mb-2">
                            <div class="col-6">
                                <h3 class="m-0">From <b>{{ birthdays_report.from | myDate }}</b> to <b>{{ birthdays_report.to | myDate }}</b></h3>
                                <h3 class="m-0"><b>Result count:</b> {{ print_data.length }}</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered m-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Office</th>
                                            <th>Birthday</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in print_data" :key="index">
                                            <td class="align-middle pt-1 pb-1">{{ index + 1 }}.</td>
                                            <td class="align-middle pt-1 pb-1"><span style="font-weight: bold;">{{ item.name }}</span></td>
                                            <td class="align-middle pt-1 pb-1">{{ item.office }}</td>
                                            <td class="align-middle pt-1 pb-1">{{ item.birthdate | myDate }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-primary card-outline report_card">
                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Custom Reports</h2>
                    <p style="margin: 2px 0 0 2px;">(Data is based on Annual Plantilla {{ this.$parent.settings.plantilla && this.$parent.settings.plantilla.year }})</p>
                </div>
                <div class="card-body">
                    <div class="row pr-3">

                        <!-- Options -->
                        <div class="col-md-6 pr-5">
                            <div class="form-group">
                                <label style="font-weight: bold;margin: 0;">Report</label>
                                <v-select class="form-control form-control-border border-width-2" v-model="report_type" :options="reports_type" placeholder="Select Report" req>
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" :required="!report_type" v-bind="attributes" v-on="events" />
                                    </template>
                                </v-select>
                                <!-- <select v-model="report_type" class="form-control form-control-border border-width-2">
                                    <option value="">Select Report</option>
                                    <option value="Salary Grades">Positions with specific salary grade/s</option>
                                    <option value="Employee Names">Names & Position</option>
                                    <option value="Retirees of Specific Year">Retirees of Specific Year</option>
                                </select> -->
                            </div>
                            <div class="form-group">
                                <label style="font-weight: bold; margin: 0;">Department</label>
                                <v-select class="form-control form-control-border border-width-2" v-model="department" :options="departments" :reduce="department => department.address"  :getOptionLabel="department => department.address"></v-select>
                            </div>
                            <button @click="print_report_all()" class="btn btn-info btn-block mt-2" :disabled="!button_enable"><i class="fas fa-print"></i>  Generate Report</button>
                        </div>

                        <!-- Options Right -->
                        <div v-if="report_type == 'Positions with specific salary grade/s'" class="col-md-6 pr-5">
                            <h3>Options</h3>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="m-0">Salary Grade</label>
                                        <input v-model="salary_grades_report.salary_grade" type="text" class="form-control" placeholder="eg. 15 or 12-15" onkeypress="return event.charCode != 32">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label style="font-weight: bold;margin: 0;">Status</label>
                                    <div class="form-group form-inline">
                                        <div class="custom-control custom-checkbox mr-4">
                                            <input v-model="salary_grades_report.status_vacant" class="custom-control-input" type="checkbox" id="vacant-check-box">
                                            <label for="vacant-check-box" class="custom-control-label">Vacant</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input v-model="salary_grades_report.status_occupied" class="custom-control-input" type="checkbox" id="occupied-check-box">
                                            <label for="occupied-check-box" class="custom-control-label">Occupied</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="report_type == 'Names & Position'" class="col-md-6 pr-5">
                            <h3>Options</h3>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label style="font-weight: bold;margin: 0;">Sort by</label>
                                        <select v-model="employee_names_report.sort" class="form-control form-control-border border-width-2">
                                            <option value="Surname">Surname</option>
                                            <option value="Item No.">Item No.</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label style="font-weight: bold;margin: 0;">Gender</label>
                                        <select v-model="employee_names_report.gender" class="form-control form-control-border border-width-2">
                                            <option value="All">All</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label style="font-weight: bold;margin: 0;">CSC Level</label>
                                        <select v-model="employee_names_report.csc_level" class="form-control form-control-border border-width-2">
                                            <option value="All">All</option>
                                            <option value="1">First Level</option>
                                            <option value="2">Second Level</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label style="font-weight: bold;margin: 0;">Age Range <small>(Separate with "-")</small></label>
                                        <input v-model="employee_names_report.age_range" type="text" class="form-control" placeholder="eg. 30 or 18-40" onkeypress="return event.charCode != 32">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="report_type == 'Retirees of Specific Year'" class="col-md-6 pr-5">
                            <h3>Options</h3>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="m-0">Year</label>
                                        <input v-model="retirees_report.year" type="number" class="form-control" placeholder="eg. 2025">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="report_type == 'Birthday Celebrants'" class="col-md-6 pr-5">
                            <h3>Options</h3>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="m-0">From</label>
                                        <input v-model="birthdays_report.from" type="date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="m-0">To</label>
                                        <input v-model="birthdays_report.to" type="date" class="form-control" required>
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
    export default {
        data() {
            return {
                date_printed: moment(new Date()).format('YYYY-MM-DD'),
                plantilla_content: [],
                departments: [],
                department: '',
                print_data: [],
                button_enable: false,
                report_type: '',
                reports_type: ['Positions with specific salary grade/s', 'Names & Position', 'Retirees of Specific Year', 'Birthday Celebrants'],
                salary_grades_report: {
                    salary_grade: '',
                    status_vacant: true,
                    status_occupied: true
                },
                employee_names_report: {
                    sort: 'Surname',
                    gender: 'All',
                    csc_level: 'All',
                    age_range: '',
                    male: 0,
                    female: 0
                },
                retirees_report: {
                    year: ''
                },
                birthdays_report: {
                    from: null,
                    to: null
                }
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
            report_type: function(data) {
                this.button_enable = data != ''
            }
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
                this.print_data = []
                var filtered = []

                if (this.report_type == 'Positions with specific salary grade/s') {
                    filtered = _.filter(this.plantilla_content, (content) => { 
                        if (this.salary_grades_report.salary_grade.includes('-')) {
                            let grade_from = this.salary_grades_report.salary_grade.split('-')[0]
                            let grade_to = this.salary_grades_report.salary_grade.split('-')[1]
                            return content.salaryproposed 
                                && content.salaryproposed.grade >= grade_from 
                                && content.salaryproposed.grade <= grade_to
                                && (!this.salary_grades_report.status_vacant ? content.personal_information_id != null : true)
                                && (!this.salary_grades_report.status_occupied ? content.personal_information_id == null : true)
                                && (this.department != 'All' ? content.office == this.department : true);
                        } else {
                            return content.salaryproposed 
                                && content.salaryproposed.grade == this.salary_grades_report.salary_grade
                                && (!this.salary_grades_report.status_vacant ? content.personal_information_id != null : true)
                                && (!this.salary_grades_report.status_occupied ? content.personal_information_id == null : true)
                                && (this.department != 'All' ? content.office == this.department : true);
                        }
                    });
                }

                if (this.report_type == 'Names & Position') {
                    this.employee_names_report.male = 0
                    this.employee_names_report.female = 0
                    filtered = _.filter(this.plantilla_content, (content) => { 

                        let age_input = this.employee_names_report.age_range
                        let age_res = true
                        let birthday = moment(content.birthdate)
                        if (age_input != '' && age_input.includes('-')) {
                            let age1 = age_input.split('-')[0]
                            let age2 = age_input.split('-')[1]
                            age_res = moment().diff(birthday, 'years') >= age1 && moment().diff(birthday, 'years') <= age2
                        } else if (age_input != '') {
                            age_res = moment().diff(birthday, 'years') == age_input
                        }

                        let inc = content.name != 'VACANT'
                            && (this.department != 'All' ? content.office == this.department : true)
                            && (this.employee_names_report.gender == 'All' ? true : (content.sex == this.employee_names_report.gender))
                            && (this.employee_names_report.csc_level != 'All' ? content.csc_level == this.employee_names_report.csc_level : true)
                            && age_res
                        if (inc) {
                            this.employee_names_report.male += content.sex == 'Male' ? 1 : 0
                            this.employee_names_report.female += content.sex == 'Female' ? 1 : 0
                        }
                        return inc;
                    });
                    if (this.employee_names_report.sort == 'Surname') {
                        filtered = _.sortBy(filtered, [function(o) { return o.name; }]);
                    }
                }

                if (this.report_type == 'Retirees of Specific Year') {
                    filtered = _.filter(this.plantilla_content, (content) => { 
                        return this.retirees_report.year - 65 == moment(content.birthdate).format('YYYY')
                            && (this.department != 'All' ? content.office == this.department : true)
                    });
                }

                if (this.report_type == 'Birthday Celebrants') {
                    filtered = _.filter(this.plantilla_content, (content) => { 
                        const dateFormat = '____-MM-DD'
                        return moment(content.birthdate, dateFormat).isBetween(this.birthdays_report.from, this.birthdays_report.to, null, '[]')
                            || moment(content.birthdate, dateFormat).add(1, 'y').isBetween(this.birthdays_report.from, this.birthdays_report.to, null, '[]')
                    });
                }
                
                this.print_data = filtered
                this.$nextTick(() => {
                    window.print()
                })
            },
            fetch_employees() {
                this.$Progress.start()
                axios.get('api/plantillaForOtherReports')
                    .then(({data}) => {
                        let all_depts = [{'address': 'All'}]
                        let for_select_depts = _.concat(all_depts, data.departments)
                        this.departments = for_select_depts;
                        var first_department = for_select_depts[0];
                        this.department = first_department.address;

                        this.plantilla_content = data.plantillacontents;
                        // var first_employee = data.plantillacontents[0];
                        // this.employee = first_employee;
                        // this.date_of_appointment = first_employee.last_promotion ? moment(first_employee.last_promotion).year(moment().format('YYYY')).format('YYYY-MM-DD') : moment(first_employee.original_appointment).year(moment().format('YYYY')).format('YYYY-MM-DD')
                        // this.print_data.push(first_employee)
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    })
                    .finally(() => {
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
