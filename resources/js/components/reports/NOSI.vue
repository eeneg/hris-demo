<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">NOSI Report</h2>
                    <p style="margin: 2px 0 0 2px;">Notice of Salary Increment
                    (Employees are based on Annual Plantilla {{ this.$parent.settings.plantilla && this.$parent.settings.plantilla.year }})
                    </p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom: 0.3rem;">
                                <label style="font-weight: bold; margin: 0;">Select Employee</label>
                                <v-select class="form-control form-control-border border-width-2" v-model="employee" :options="plantilla_content" :getOptionLabel="employee => employee.name"></v-select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label style="font-weight: bold; margin: 0;">Print Date</label>
                                        <input class="form-control form-control-border border-width-2" type="date" v-model="date_printed">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label style="font-weight: bold; margin: 0;">Date of Increment</label>
                                        <input class="form-control form-control-border border-width-2" type="date" v-model="date_increment">
                                    </div>
                                </div>
                            </div>
                            <button @click="print_report()" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <label style="font-weight: bold; margin: 0;">NOSI Lookup</label>
                                    <form class="form-inline">
                                        <input class="form-control form-control-border border-width-2 mr-2" type="number" v-model="nosi_year">
                                        <button type="button" class="btn btn-success">View</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="nosi_div" style="border: 1px solid #dfdfdf">
                            <div class="row mt-3 mb-2">
                                <div class="col-12 text-center">
                                    <h4 class="m-0">PROVINCE OF DAVAO DEL SUR</h4>
                                    <h5 class="m-0">Matti, Digos City</h5>
                                    <h4 class="m-0">OFFICE OF THE GOVERNOR</h4>
                                    <h4 class="m-0 font-weight-bold">NOTICE OF STEP INCREMENT</h4>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-8 mt-3">
                                    <h5 class="m-0">{{ employee.name }}</h5>
                                    <h5 class="m-0">{{ employee.position }}</h5>
                                    <h5 class="m-0">{{ employee.office }}</h5>
                                    <h5 class="m-0">Province of Davao del Sur</h5>
                                    <h5 class="mt-4">Sir/Madam:</h5>
                                </div>
                                <div class="col-4 text-right">
                                    <h5><u>{{ date_printed | myDate }}</u></h5>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 text-justify">
                                    <h5 class="m-0" style="text-indent: 50px;justify-content: center;">
                                        Pursuant to Joint Civil Service Commission (CSC) and Department of Budget and Management (DBM) Circular No. 1, s. 1990 implementing Section 13 &copy; of RA No. 6765, your salary as <u>{{ employee.position }} SG {{ employee.salaryproposed && employee.salaryproposed.grade }}-{{ employee.salaryproposed && employee.salaryproposed.step }}</u> is hereby adjusted effective <u>{{ date_increment | myDate }}</u>.
                                    </h5>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-8">
                                    <h5 class="m-0" style="text-indent: 50px;">Basic Monthly Salary</h5>
                                    <h5 class="m-0" style="text-indent: 75px;">As of <u>{{ date_previous | myDate }}</u></h5>
                                    <h5 class="m-0" style="text-indent: 50px;">Salary Adjustment</h5>
                                    <h5 class="m-0" style="text-indent: 75px;">a. Merit (<u>0</u> step/s)</h5>
                                    <h5 class="m-0" style="text-indent: 75px;">b. Length of Service <u>1</u> step/s</h5>
                                    <h5 class="m-0" style="text-indent: 50px;">Adjusted Salary Effective <u>{{ date_increment | myDate }}</u></h5>
                                </div>
                                <div class="col-3 text-right">
                                    <h5 class="m-0" style="color: white;">.</h5>
                                    <h5 class="m-0">
                                        <u v-if="employee.salaryproposed">{{ employee.salaryproposed.amount | amount }}</u>
                                    </h5>
                                    <h5 class="m-0" style="color: white;">.</h5>
                                    <h5 class="m-0" style="color: white;">.</h5>
                                    <h5 class="m-0" v-if="employee.nextStepAmount"><u>{{ (employee.nextStepAmount - employee.salaryproposed.amount) | amount }}.00</u></h5>
                                    <h5 class="m-0" v-if="employee.nextStepAmount"><u>{{ employee.nextStepAmount | amount }}</u></h5>
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

<style type="text/css">
    @media print {
        body * { visibility: hidden; }
        #nosi_div * { visibility: visible; }
        #nosi_div { position: absolute; top: 5px; left: 0; max-width: 100%; flex: unset;}
        #nosi_div h4 { font-size: 1.5rem }
        #nosi_div h5 { font-size: 1.275rem }
    }
</style>

<script>
    export default {
        data() {
            return {
                date_printed: moment(new Date()).format('YYYY-MM-DD'),
                date_increment: moment(new Date()).format('YYYY-MM-DD'),
                date_previous: moment(this.date_increment).subtract(1, "days"),
                employee: {},
                plantilla_content: [],
                nosi_year: moment(new Date()).add('1', 'year').format('YYYY'),
            }
        },
        watch: {
            date_increment(newData) {
                this.date_previous = moment(newData).subtract(1, "days")
            }
        },
        methods: {
            print_report() {
                window.print()
            },
            fetch_employees() {
                axios.get('api/plantillaForNosi')
                    .then(({data}) => {
                        this.plantilla_content = data.data;
                        this.employee = data.data[0];
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            test() {
                axios.get('https://kf.kobotoolbox.org/api/v2/assets/aJeAe6swtog2YvZU663XNq/data.json',
                    {
                        headers: { 
                            'Access-Control-Allow-Origin' : '*',
                            'Authorization': 'Basic ZWR3aW5yb2pvOml0Y3Bhc3MxMDA=',                             
                        }
                    }
                )
                .then(function (response) {
                    console.log(JSON.stringify(response.data));
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            // console.log('Component mounted.')
        },
        created() {
            this.$Progress.start()
            this.fetch_employees()
            this.test()
            this.$Progress.finish()
        }
    }
</script>
