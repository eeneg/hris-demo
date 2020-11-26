<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="custom-select">Salary Schedule</label>
                            <div class="btn-group">
                                <select class="custom-select" v-model="selected">
                                    <option v-for="tranche in tranches" v-bind:value="{tranche}" :key="tranche.id"> {{ tranche }} </option>
                                </select>
                            </div>
                            <div class="btn-group float-right">
                                <button v-if="$gate.isAdministrator()" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCreate" v-on:click="createSalaryGradeModal">
                                  Add <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <td style="width: calc(100%-150px); font-weight:bold">Grade</td>
                                <td style="width: calc(100%-150px); font-weight:bold" v-for="step in steps" :key="step.id">Step {{ step }}</td>
                                <td style="width: calc(100%-150px); font-weight:bold" v-if="$gate.isAdministrator()">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="salarygrade in salarygrades" :key="salarygrade.id" class="text-center">
                                <td style="width: calc(100%-150px);" v-text="salarygrade[0].grade"></td>
                                <td style="width: calc(100%-150px);" v-for="amount in salarygrade" :key="amount.id">{{ amount.amount }}</td>
                                <td style="width: calc(100%-150px);" v-if="$gate.isAdministrator()">
                                    <button v-if="$gate.isAdministrator()" @click.prevent="editSalaryGradeModal(salarygrade)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalUpdate">
                                       Edit <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- create modal -->
         <div v-if="editMode == false" class="modal fade" id="modalCreate" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="closed">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="createSalaryGrade()" action="" id="1">
                    <div class="modal-body">
                        <div class="forms p-0 col-md-12">
                            <div class="row justify-content-center">
                                <div class="form-group col-md-6 text-center">
                                    <label for="tranche">Tranche</label>
                                    <input type="text" v-model="form.tranche" list="tranche" required>
                                    <datalist id="tranche">
                                        <option v-for="tranche in tranches" :key="tranche.id">{{ tranche }}</option>
                                    </datalist>
                                </div>
                                <div class="form-group col-md-6 text-center">
                                    <label for="grade">Grade</label>
                                    <input type="number" name="grade" v-model="form.grade" required>
                                </div>
                                <div class="form-group col-md-6" v-for="index in 8" :key="index.id">
                                    <div class="row">
                                        <div class="input-group col-md-6">
                                            <label for="step">Step {{ index }}</label>
                                            <input type="number" v-model="form.amount[index]" required>
                                        </div>
                                        <div class="input-group col-md-6">
                                            <label for="date">Effective Date:</label>
                                            <input type="date" name="effective_date" v-model="form.effective_date[index]" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="closed">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!-- end create modal -->

        <!-- update modal -->
        <div v-else class="modal fade" id="modalUpdate" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-grade"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="closed">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="updateSalaryGrade()" action="" id="2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6" v-for="(data, index) in form" :key="data.id">
                                <div class="row">
                                    <div class="input-group col-md-6">
                                        <label for="amount">Step {{ data.step }}</label>
                                        <input type="number" name="amount" v-model="data.amount" required>
                                    </div>

                                    <div class="input-group col-md-6">
                                        <label for="date">Effective Date</label>
                                        <input type="date" name="date" v-model="data.effective_date" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="closed">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!-- end update modal -->
    </div>
</template>

<script>
    export default {
        data () {
            return {
                editMode: false,
                selected: {tranche:"SSL V First Tranche"},
                steps:{},
                salarygrades: {},
                tranches: {},
                form: {amount: [], effective_date: []},
            }
        },
        watch:
        {
            selected: function()
            {
                this.debouncedgetSalaryGrades();
            },
        },
        created: function()
        {
            this.getSalaryGrade()
            this.debouncedgetSalaryGrades = _.debounce(this.getSalaryGrade, 500);
        },
        methods:
        {
            getSalaryGrade: function()
            {
                var select = this.selected.tranche
                axios.get('api/salarygrade')
                .then(({data}) =>
                {
                    this.tranches = Object.keys(data)
                    var step = _.map(data[select], 'step')
                    var max = _.max(step)
                    this.salarygrades = _.chunk(data[select], max)
                    this.steps = max
                })
                .catch(error =>
                {
                    // do something
                });
            },
            createSalaryGradeModal: function()
            {
                this.editMode = false
                this.form = {amount: [], effective_date: []}
            },
            editSalaryGradeModal: function(salarygrade)
            {
                this.editMode = true
                $('#modal-grade').text("Grade "+ salarygrade[0]['grade'])
                this.form = salarygrade
            },
            closed: function()
            {
                this.getSalaryGrade();
            },
            createSalaryGrade()
            {
               this.form.amount.forEach((e, index) => {
                   axios.post('api/salarygrade', {
                       tranche: this.form.tranche,
                       step:    index,
                       grade:   this.form.grade,
                       amount:  e,
                       effective_date: this.form.effective_date[index]
                   })
                   .then(response => {
                        if(index === this.form.length - 1)
                        {
                            toast.fire({
                                icon: 'success',
                                title: 'Updated successfully'
                            });
                            this.selected = { tranche: this.form.tranche }
                            $('#modalCreate').modal('hide')
                        }
                    })
                    .catch(error => {
                        //do something
                    })
               })
            },
            updateSalaryGrade: function()
            {
                this.form.forEach((e, index)=> {
                    axios.patch('api/salarygrade/'+ e.id, e)
                    .then(response => {
                        if(index === this.form.length - 1)
                        {
                            toast.fire({
                                icon: 'success',
                                title: 'Updated successfully'
                            });
                            $('#modalUpdate').modal('hide')
                        }
                    })
                    .catch(error =>{
                        //do something
                    })
                });
            },
        },
        mounted() {
            console.log('mounted');
        }
    }
</script>
