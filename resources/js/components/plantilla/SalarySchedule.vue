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
                                <button v-if="$gate.isAdministrator()" @click.prevent="editSalaryScheduleModal()" type="button" class="btn btn-outline-primary">
                                Edit Salary Schedule <i class="fa fa-edit"></i>
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
                                    <button v-if="$gate.isAdministrator()" @click.prevent="createSalaryGradeModal()" type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#salaryGradeModal">
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
                                         <td style="width: calc(100%-150px);"> {{ salarygrade[0].grade }} </td>
                                        <td style="width: calc(100%-150px);" v-for="amounts in salarygrade" :key="amounts.id">{{ amounts.amount }}</td>
                                        <td style="width: calc(100%-150px);" v-if="$gate.isAdministrator()">
                                            <a href="#" v-if="$gate.isAdministrator()" @click.prevent="editSalaryGradeModal(salarygrade)" data-toggle="modal" data-target="#salaryGradeModal">
                                            <i class="fa fa-edit"></i>
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
                                    <option v-for="grade in 33" v-bind:value="grade" :key="grade.id">Grade: {{ grade }}</option>
                                </select>
                                <span class="text-danger" v-if="errors.has('grade')" v-text="errors.get('grade')"></span>
                            </div>
                            <div class="form-group col-md-6" v-for="(n, index) in 8" :key="index.id">
                                <label for="amount" style="margin-bottom: 2px;">Step {{ index+1 }}</label>
                                <input type="number" class="form-control form-control-border border-width-2" @keypress="onlyNumber" v-model="salaryGradeForm.amount[index]" min="0" required>
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
                salaryGradeForm: {amount:[]},
                display: {},
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
                axios.get('api/salaryschedule')
                .then(({data}) => {
                    this.salaryschedules = data
                    this.selected = this.salarySchedForm.tranche != null ? this.salarySchedForm.tranche : this.salaryschedules[0].tranche
                })
                .catch(error => {

                })
            },
            createSalarySchedule: function()
            {
                axios.post('api/salaryschedule', this.salarySchedForm)
                .then(response => {
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
                axios.patch('api/salaryschedule/'+this.salarySchedForm.id, this.salarySchedForm)
                .then(response => {
                   toast.fire({
                        icon: 'success',
                        title: 'Updated successfully'
                    });
                    this.getSalarySchedule()
                    $('#salarySchedModal').modal('hide')
                })
                .catch(error => this.errors.record(error.response.data.errors))

            },
            getSalaryGrade: function()
            {
                var sched = _.find(this.salaryschedules, ['tranche', this.selected])
                axios.get('api/salarygrade?id='+ sched.id)
                .then(({data}) => {

                    this.salarygrades = _.chunk(data, 8)
                    this.display = sched
                    this.$Progress.finish();
                })
                .catch(error => {
                    this.$Progress.fail();
                })
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
                if(this.salaryGradeForm.amount.length < 8 || this.salaryGradeForm.amount.includes(''))
                {
                    this.errors.record({ amount: ['Amount Required']})
                }else{
                    var ar = _.merge(this.salaryGradeForm, _.find(this.salaryschedules, ['tranche', this.selected]))
                    axios.post('api/salarygrade', ar)
                    .then(response => {
                        toast.fire({
                            icon: 'success',
                            title: 'Created successfully'
                        });
                        this.getSalaryGrade()
                        $('#salaryGradeModal').modal('hide')
                    })
                .catch(error => this.errors.record(error.response.data.errors))
                }
            },
            updateSalaryGrade: function()
            {
                if(this.salaryGradeForm.amount.length < 8 || this.salaryGradeForm.amount.includes(''))
                {
                    this.errors.record({ amount: ['Amount Required']})
                }else{
                    axios.patch('api/salarygrade/', {id: this.salaryGradeForm.id, grade: this.salaryGradeForm.grade, amount: this.salaryGradeForm.amount})
                    .then(response => {
                        toast.fire({
                            icon: 'success',
                            title: 'Updated successfully'
                        });
                        this.getSalaryGrade()
                        $('#salaryGradeModal').modal('hide')
                    })
                    .catch(error => this.errors.record(error.response.data.errors))
                }
            },
            onlyNumber: function($event) {
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
                if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) {
                    $event.preventDefault();
                }
            }
        },
        mounted() {
            // console.log('mounted');
        }
    }
</script>
