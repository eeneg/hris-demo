<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="custom-select">Salary Schedule: </label>
                            <div class="btn-group">
                                <select class="custom-select" v-model="selected">
                                    <option v-for="salaryschedule in salaryschedules" v-bind:value="salaryschedule.tranche" :key="salaryschedule.id"> {{ salaryschedule.tranche }} </option>
                                </select>
                            </div>
                             <div class="btn-group">
                                <button v-if="$gate.isAdministrator()" @click.prevent="generate_salarysched()" type="button" class="btn btn-outline-success">
                                    <i class="fa fa-print"></i>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button v-if="$gate.isAdministrator()" @click.prevent="editSalaryScheduleModal()" type="button" class="btn btn-outline-primary">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </div>
                             <div class="btn-group">
                                <button v-if="$gate.isAdministrator()" @click.prevent="deleteSalarySchedule()" type="button" class="btn btn-outline-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            <div class="btn-group float-right">
                                <button v-if="$gate.isAdministrator()" @click="createSalaryScheduleModal()" type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#salarySchedModal">
                                  Add Salary Schedule <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex mb-1">
                                <div class="d-flex flex-column bd-highlight">
                                    <div class="bd-highlight">Tranche: {{ display.tranche }}</div>
                                    <div class="bd-highlight">Effective Date: {{ display.effective_date }}</div>
                                </div>
                                <div class="ml-auto p-1">
                                    <button v-if="$gate.isAdministrator() && add == true" @click.prevent="createSalaryGradeModal()" type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#salaryGradeModal">
                                    Create <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <td style="width: calc(100%-150px); font-weight:bold">Grade</td>
                                        <td style="width: calc(100%-150px); font-weight:bold" v-for="n in 8" :key="n.id">Step {{ n }}</td>
                                        <td style="width: calc(100%-150px); font-weight:bold" v-if="$gate.isAdministrator()">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(salarygrade, index) in salarygrades" :key="salarygrade.id" class="text-center">
                                        <td style="width: calc(100%-150px);"> {{ salarygrade[0]['grade'] }} </td>
                                        <td style="width: calc(100%-150px);" v-for="amounts in salarygrade" :key="amounts.id">
                                            {{ amounts.amount }} <br>
                                            ({{ amounts.annual | amount }})
                                        </td>
                                        <td style="width: calc(100%-150px);" v-if="$gate.isAdministrator()">
                                            <a href="#" class="btn btn-sm btn-outline-primary" v-if="$gate.isAdministrator()" @click.prevent="editSalaryGradeModal(salarygrade)" data-toggle="modal" data-target="#salaryGradeModal">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-outline-danger" v-if="$gate.isAdministrator()" @click.prevent="deleteSalaryGrade(salarygrade)">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- salary sched modal -->
         <div class="modal fade" id="salarySchedModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header modal-border">
                    <h5 class="modal-title">Salary Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="errors.deleteV()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode == false ? createSalarySchedule() : updateSalarySchedule()" action="" id="1" @keydown="errors.clear($event.target.name)">
                    <div class="modal-body">
                        <div class="forms p-0 col-md-12">
                           <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="tranche">Tranche</label>
                                    <input type="text" class="form-control form-control-border border-width-2" name="tranche" id="tranche" v-model="salarySchedForm.tranche" required>
                                    <span class="text-danger" v-if="errors.has('tranche')" v-text="errors.get('tranche')"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="effective_date">Effective Date (yyyy-mm-dd)</label>
                                    <!-- <input type="date" class="form-control form-control-border border-width-2" name="effective_date" id="effective_date" v-model="salarySchedForm.effective_date" required> -->
                                    <date-picker v-model="salarySchedForm.effective_date" id="effective_date" :config="options" class="form-control form-control-border border-width-2" required></date-picker>
                                    <span class="text-danger" v-if="errors.has('effective_date')" v-text="errors.get('effective_date')"></span>
                                </div>
                           </div>
                       </div>
                    </div>
                    <div class="modal-footer modal-border">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="errors.deleteV()">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!-- end sc modal -->

        <!-- salaryGradeModal modal -->
        <div class="modal fade" id="salaryGradeModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header modal-border">
                    <h5 class="modal-title" id="modal-grade">Create Salary Grade</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="errors.deleteV()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent=" editMode == false ? createSalaryGrade() : updateSalaryGrade()" action="" id="2" @keydown="errors.clear($event.target.name)">
                    <div class="modal-body pt-0 pb-0">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="grade">Grade</label>
                                <select class="form-control form-control-border border-width-2" id="grade" v-model="salaryGradeForm.grade" required>
                                    <option v-for="grade in 33" v-bind:value="grade" :key="grade.id" v-text="'Grade: ' + grade"></option>
                                    <!-- <option v-for="grade in 33" v-if="editMode == true" v-bind:value="grade" :key="grade.id" v-text="'Grade: ' + grade"></option> -->
                                </select>
                                <span class="text-danger" v-if="errors.has('grade')" v-text="errors.get('grade')"></span>
                            </div>
                            <div class="form-group col-md-6" v-for="(n, index) in 8" :key="index.id">
                                <label for="amount" style="margin-bottom: 2px;">Step {{ index+1 }}</label>
                                <input type="number" class="form-control form-control-border border-width-2" @keypress="onlyNumber" v-model="salaryGradeForm.amount[index]" min="0">
                            </div>
                            <div class="form-group col-md-12 text-center">
                                <span class="text-danger" v-if="errors.has('amount')" v-text="errors.get('amount')"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-border pt-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="errors.deleteV()">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!-- end sg modal -->

         <!-- pdf modal -->

        <div class="modal" id="pdfModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Print/Save as PDS</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="pdf-viewer">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

                </div>
            </div>
        </div>

        <!-- end pdf modal -->
    </div>
</template>

<script>

    class Errors
    {
        constructor()
        {
            this.errors = {};
        }

        get(field)
        {
            if(this.errors[field])
            {
                return this.errors[field][0];
            }
        }

        has(field)
        {
            return this.errors.hasOwnProperty(field);
        }

        record(errors)
        {
            this.errors = errors
        }

        clear(field)
        {
            delete this.errors[field]
        }

        deleteV()
        {
            return this.errors = new Errors()
        }
    }

    export default {
        data () {
            return {
                editMode: false,
                salaryschedules: {},
                salarygrades: {},
                selected: '',
                salarySchedForm: {},
                salaryGradeForm: {amount: []},
                display: {},
                add: false,
                errors: new Errors(),
                options: {
                    format: 'yyyy-MM-DD',
                    useCurrent: false,
                }
            }
        },
        components: {
            datePicker
        },
        watch:
        {
            selected: function()
            {
                this.debouncedgetSalaryGrade();
            },
        },
        created: function()
        {
            this.$Progress.start();
            this.getSalarySchedule();
            this.debouncedgetSalaryGrade = _.debounce(this.getSalaryGrade, 500);
        },
        methods:
        {
            getSalarySchedule: function()
            {
                this.$Progress.start()
                axios.get('api/salaryschedule')
                .then(({data}) => {
                    this.salaryschedules = data

                    if(this.salaryschedules.length == 0 )
                    {
                        this.display = {}
                        this.add = false
                        this.salarygrades = {}
                        this.selected = null
                    }else{
                        this.selected = this.salarySchedForm.tranche != null ? this.salarySchedForm.tranche : this.salaryschedules[0].tranche
                    }

                    this.$Progress.finish()
                })
                .catch(error => {
                    console.log(error)
                })
            },
            createSalarySchedule: function()
            {
                this.$Progress.start()
                axios.post('api/salaryschedule', this.salarySchedForm)
                .then(response => {
                    this.$Progress.finish()
                    toast.fire({
                        icon: 'success',
                        title: 'Created successfully'
                    });
                    this.getSalarySchedule()
                    $('#salarySchedModal').modal('hide')
                })
                .catch(error => this.errors.record(error.response.data.errors))
            },
            createSalaryScheduleModal: function()
            {
                this.salarySchedForm = {}
                this.editMode = false
            },
            editSalaryScheduleModal: function()
            {
                if(this.selected == null || this.selected == '')
                {
                    toast.fire({
                        icon: 'error',
                        title: 'Nothing to edit'
                    });
                }else{
                    var ar =  _.find(this.salaryschedules, ['tranche', this.selected])
                    this.salarySchedForm = {id: ar.id, tranche: ar.tranche, effective_date:ar.effective_date}
                    this.editMode = true
                    $('#salarySchedModal').modal('show')
                }
            },
            updateSalarySchedule: function()
            {
                this.$Progress.start()
                axios.patch('api/salaryschedule/'+this.salarySchedForm.id, this.salarySchedForm)
                .then(response => {
                    this.$Progress.finish()
                    toast.fire({
                        icon: 'success',
                        title: 'Updated successfully'
                    });
                    this.getSalarySchedule()
                    $('#salarySchedModal').modal('hide')
                })
                .catch(error => this.errors.record(error.response.data.errors))

            },
            deleteSalarySchedule: function()
            {
                Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the salary schedule as well as the salary grades under it!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if(result.isDismissed == true)
                    {
                        toast.fire({
                            icon: 'success',
                            title: 'Cancelled'
                        });
                    }else if(this.salaryschedules.length == 0){
                        toast.fire({
                            icon: 'error',
                            title: 'Nothing to delete'
                        });
                    }else{
                        this.$Progress.start()
                        axios.delete('api/salaryschedule/'+_.find(this.salaryschedules, ['tranche', this.selected]).id)
                        .then(response => {
                            this.getSalarySchedule()
                            this.$Progress.finish()
                            toast.fire({
                                icon: 'success',
                                title: 'Deleted successfully'
                            });
                            this.salarySchedForm = {}
                        })
                        .catch(error => {
                            Swal.fire(
                                'Oops...',
                                error.response.data.message,
                                'error',
                            )
                        })

                    }
                })
            },
            getSalaryGrade: function()
            {
                this.$Progress.start()

                if(this.salaryschedules.length > 0)
                {
                    var sched = _.find(this.salaryschedules, ['tranche', this.selected]) ? _.find(this.salaryschedules, ['tranche', this.selected]) : {}
                    axios.get('api/salarygrade?id='+ sched.id)
                    .then(({data}) => {
                        this.salarygrades = data.sort((a,b) => (a[0].grade > b[0].grade) ? 1 : ((b[0].grade > a[0].grade) ? -1 : 0))
                        this.display = sched
                        this.add = true
                        this.$Progress.finish();
                    })
                    .catch(error => {
                        this.$Progress.fail();
                    })
                }else{
                    this.display = {}
                    this.add = false
                }
            },
            createSalaryGradeModal: function()
            {
                this.salaryGradeForm = {amount: []}
                this.editMode = false
            },
            editSalaryGradeModal: function(salarygrade)
            {
                var ar = {id: [], grade: salarygrade[0].grade, amount: []}
                salarygrade.forEach(e=>{
                   ar.id.push(e.id)
                   ar.amount.push(e.amount)
                })

                this.salaryGradeForm = ar
                this.editMode = true
            },
            createSalaryGrade: function()
            {
                if(this.salaryGradeForm.amount.length < 1)
                {
                    this.errors.record({ amount: ['Amount Required']})
                }else if(this.selected == null || this.selected == ''){
                    Swal.fire(
                        'Oops...',
                        'No Salary Schedule selected',
                        'error'
                    )
                }else if($.inArray(this.salaryGradeForm.grade, $.map(this.salarygrades, function(v, i) { return v[0]['grade']; })) > -1){
                    Swal.fire(
                        'Oops...',
                        'Salary Grade already exists',
                        'error'
                    )
                }else{
                    this.$Progress.start()
                    var ar = _.merge(this.salaryGradeForm, _.find(this.salaryschedules, ['tranche', this.selected]))
                    axios.post('api/salarygrade', ar)
                    .then(response => {
                        this.$Progress.finish()
                        toast.fire({
                            icon: 'success',
                            title: 'Created successfully'
                        });
                        this.getSalaryGrade()
                        $('#salaryGradeModal').modal('hide')
                    })
                    .catch(error => {
                        this.errors.record(error.response.data.errors)
                        Swal.fire(
                            'Oops...',
                            error.response.data.message,
                            'error'
                        )
                    })
                }
            },
            updateSalaryGrade: function()
            {
                if(this.salaryGradeForm.amount.length < 1)
                {
                    this.errors.record({ amount: ['Amount Required']})
                }else if(this.selected == null || this.selected == ''){
                    Swal.fire(
                        'Oops...',
                        'No Salary Schedule selected',
                        'error'
                    )
                }else{
                    this.$Progress.start()
                    axios.patch('api/salarygrade/', {id: this.salaryGradeForm.id, grade: this.salaryGradeForm.grade, amount: this.salaryGradeForm.amount})
                    .then(response => {
                        this.$Progress.finish()
                        toast.fire({
                            icon: 'success',
                            title: 'Updated successfully'
                        });
                        this.getSalaryGrade()
                        $('#salaryGradeModal').modal('hide')
                    })
                    .catch(error => {
                        this.errors.record(error.response.data.errors)
                        Swal.fire(
                            'Oops...',
                            error.response.data.message,
                            'error'
                        )
                    })
                }
            },
            deleteSalaryGrade: function(salarygrade){

                var ar = []

                salarygrade.forEach(e=>{
                   ar.push(e.id)
                })

                Swal.fire({
                title: 'Are you sure?',
                text: "You wont be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if(result.isDismissed == true)
                    {
                        toast.fire({
                            icon: 'success',
                            title: 'Cancelled'
                        });
                    }else{
                        this.$Progress.start()
                        axios.post('api/deleteSalaryGrade', ar)
                            .then(response => {
                                this.$Progress.finish()
                                toast.fire({
                                    icon: 'success',
                                    title: 'Deleted successfully'
                                });
                                this.getSalaryGrade()
                                $('#salaryGradeModal').modal('hide')
                            })
                            .catch(error => {
                                this.errors.record(error.response.data.errors)
                                Swal.fire(
                                    'Oops...',
                                    error.response.data.message,
                                    'error'
                                )
                        })
                    }
                })
            },
            generate_salarysched(id){

                Swal.fire({
                title: '<strong>Generating PDS</strong>',
                html: 'Dont <u>reload</u> or <u>close</u> the application ...',
                icon: 'info',
                willOpen () {
                    Swal.showLoading ()
                },
                didClose () {
                    Swal.hideLoading()
                },
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false
                })

                axios.post('generateSalarySched', {tranche: this.selected})
                .then(response => {
                    Swal.close()
                    let options = {
                        height: screen.height * 0.65 + 'px',
                        page: '1'
                    };
                    $('#pdfModal').modal('show');
                    PDFObject.embed("/storage/salary_sched_report/" + response.data.title, "#pdf-viewer", options);
                })
                .catch(error => {
                    console.log(error);
                });
            },
            onlyNumber: function($event) {
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
                if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) {
                    $event.preventDefault();
                }
            }
        },
        mounted() {
            // console.log(this.salarygrades);
        },
    }
</script>
