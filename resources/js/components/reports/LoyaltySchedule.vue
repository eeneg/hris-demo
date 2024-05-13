<template>
    <div class="row justify-content-center">
        <div class="col-md-12 text-center" v-if="!$gate.isAdministrator() && !$gate.isAuthor()">
            <not-authorized></not-authorized>
        </div>
        <div v-else class="col-md-12">
            <!-- Report -->
            <div class="row" id="report_div" style="display: none;margin-top: -1.4rem !important;">
                <div class="col-md-12 report_div" style="page-break-after: always;" v-if="print_data.length > 0">
                    <img src="storage/project_files/davsur.png" alt="Agency Logo" class="img-fluid nosi-logo">
                    <div class="row mt-3 mb-2">
                        <div class="col-12 text-center">
                            <h5 class="m-0">Republic of the Philippines</h5>
                            <h4 class="m-0 font-weight-bold">PROVINCE OF DAVAO DEL SUR</h4>
                            <h5 class="m-0 mb-5">Matti, Digos City</h5>
                            <h4 class="m-0 font-weight-bold">PROVINCIAL HUMAN RESOURCE MANAGEMENT OFFICE</h4>
                            <h3 class="m-0 font-weight-bold">LOYALTY BENEFITS SCHEDULE</h3>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-9 mt-3">
                            <h5 class="m-0">Office: <b>{{ department.address     }}</b></h5>
                            <h5 class="m-0">Year: <b>{{ loyalty_year }}</b>, Month: <b>{{ loyalty_month }}</b></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered transmittal-table">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td><b>NAME</b></td>
                                        <td><b>OFFICE & POSITION</b></td>
                                        <td><b>LOYALTY SCHEDULE</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in lookup_data" :key="data.id">
                                        <td style="line-height: 1.2rem;">{{ index + 1 }}</td>
                                        <td style="line-height: 1.2rem;"><b>{{ data.name }}</b></td>
                                        <td style="line-height: 1.2rem;">
                                            {{ data.office }}<br>
                                            {{ data.position }}<br>
                                            Item No: {{ data.item_no }}, Salary Grade: {{ data.salaryproposed ? data.salaryproposed.grade : data.salaryauthorized.grade }}
                                        </td>
                                        <td style="line-height: 1.5rem;">
                                            {{ data.loyalty_schedule | myDate }}<br>
                                            {{ data.years }} years
                                        </td>
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
            </div>

            <!-- Settings -->
            <div class="card card-primary card-outline nosi_card">
                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Loyalty Benefits Schedule</h2>
                    <p style="margin: 2px 0 0 2px;">Loyalty Benefits Schedule for specific year. (Employees are based on Annual Plantilla {{ this.$parent.settings.plantilla && this.$parent.settings.plantilla.year }})</p>
                </div>
                <div class="card-body">
                    <div class="row pr-3">
                        <div class="col-md-6 pr-5">
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
                                    <form @submit.prevent="viewRecords()">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label style="font-weight: bold; margin: 0;">Year</label>
                                                    <input class="form-control form-control-border border-width-2 mr-2" type="number" v-model="loyalty_year">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label style="font-weight: bold; margin: 0;">Month</label>
                                                    <v-select class="form-control form-control-border border-width-2 mr-2" v-model="loyalty_month" :options="months"></v-select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-success">View</button>
                                                <button type="button" class="btn btn-primary ml-2" :disabled="lookup_data.length == 0" @click="print_report_lookup()"><i class="fas fa-print"></i> Print</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Report Preview -->
                        <div class="col-md-6 table-responsive" style="height: 1000px;">
                            <table class="table table-bordered table-hover table-bordered table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td><b>NAME</b></td>
                                        <td><b>OFFICE & POSITION</b></td>
                                        <td><b>LOYALTY SCHEDULE</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in lookup_data" :key="data.id">
                                        <td style="line-height: 1rem;">{{ index + 1 }}</td>
                                        <td style="line-height: 1rem;"><b>{{ data.name }}</b></td>
                                        <td style="line-height: 1rem;">
                                            {{ data.office }}<br>
                                            {{ data.position }}<br>
                                            Item No: {{ data.item_no }}, Salary Grade: {{ data.salaryproposed ? data.salaryproposed.grade : data.salaryauthorized.grade }}
                                        </td>
                                        <td style="line-height: 1.5rem;">
                                            {{ data.loyalty_schedule | myDate }}<br>
                                            {{ data.years }} years
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
                loyalty_year: moment(new Date()).format('YYYY'),
                loyalty_month: "All",
                lookup_data: [],

                print_data: [],
                button_enable: false,
                departments: [],
                department: {},
                included: false,
            }
        },
        watch: {
            // employee(newData) {
            //     this.date_of_appointment = newData.last_promotion ? moment(newData.last_promotion).year(moment().format('YYYY')).format('YYYY-MM-DD') : moment(newData.original_appointment).year(moment().format('YYYY')).format('YYYY-MM-DD')
            //     this.date_of_effectivity = moment(this.date_of_appointment).add(1, "days")
            // }
        },
        methods: {
            print_report_lookup() {
                this.print_data = this.lookup_data
                this.$nextTick(function () {
                    window.print()
                })
            },
            viewRecords() {
                this.$Progress.start()
                this.lookup_data = []
                this.plantilla_content.forEach(content => {
                    if (content.loyalty_schedule) {
                        if (this.loyalty_year > moment(content.loyalty_schedule).format('YYYY')) {
                            var loyalty_years = []
                            var loyalty_sched = parseInt(moment(content.loyalty_schedule).format('YYYY'))

                            loyalty_years.push(loyalty_sched + 10)
                            for (let index = 1; index <= 8; index++) {
                                loyalty_years.push((loyalty_sched + 10) + (5 * index))
                            }

                            var included = loyalty_years.includes(parseInt(this.loyalty_year));
                            var office = this.department.address == 'All' ? true : content.office == this.department.address

                            if (this.loyalty_month != "All") {
                                var month_inc = moment(content.loyalty_schedule).format('MMMM') == this.loyalty_month
                            } else {
                                var month_inc = true
                            }

                            if (included && office && month_inc) {
                                // content = this.generateForReport(content, loyalty_sched, this.loyalty_year)
                                var tbp = _.assign({years: (this.loyalty_year - loyalty_sched)}, content)
                                this.lookup_data.push(tbp)
                            }
                        
                        }
                    }
                });
                this.$Progress.finish()
            },
            fetch_employees() {
                this.$Progress.start()
                axios.get('api/plantillaForLoyalty')
                    .then(({data}) => {
                        this.plantilla_content = data.plantillacontents;
                        var first_employee = data.plantillacontents[0];
                        this.employee = first_employee;

                        this.departments = data.departments;
                        this.departments.unshift({'address': 'All'})
                        var first_department = data.departments[0];
                        this.department = first_department;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    })
                    .finally(() => {
                        // this.button_enable = true
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
