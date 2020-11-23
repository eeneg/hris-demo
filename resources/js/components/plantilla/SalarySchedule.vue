<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="custom-select">Salary Schedule</label>
                            <div class="btn-group">
                                <select class="custom-select" v-model="selected">
                                    <option v-for="tranche in tranches" v-bind:value="{tranche}"> {{ tranche }} </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <td style="width: calc(100%-150px); font-weight:bold">Grade</td>
                                <td style="width: calc(100%-150px); font-weight:bold" v-for="step in steps">Step {{ step }}</td>
                                <td style="width: calc(100%-150px); font-weight:bold" v-if="$gate.isAdministrator()">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(salarygrade, index) in salarygrades" :key="salarygrade.id" class="text-center">
                                <td style="width: calc(100%-150px);" > {{ index+1 }} </td>
                                <td style="width: calc(100%-150px);" v-for="amount in salarygrade">{{ amount.amount }}</td>
                                <td style="width: calc(100%-150px);" v-if="$gate.isAdministrator()">
                                    <button v-if="$gate.isAdministrator()" @click.prevent="editSalaryGradeModal(salarygrade)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal">
                                       Edit
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- modal -->
        <div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-grade"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="updateSalaryGrade()" action="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col" v-for="(data, index) in form" :key="data.id">
                                <label for="">Step {{ index+1 }}</label>
                                <input type="text" v-model="data.amount" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                selected: {tranche:"SSL V First Tranche"},
                steps:{},
                salarygrades: {},
                tranches: {},
                form: {}
            }
        },
        watch:
        {
            selected: function()
            {
                this.debouncedgetSalaryGrades();
            }
        },
        created: function()
        {
            this.getSalaryGrade()
            this.debouncedgetSalaryGrades = _.debounce(this.getSalaryGrade, 0);
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
                    console.log(error.response.data.message);
                });
            },
            editSalaryGradeModal: function(salarygrade)
            {
                $('#modal-grade').text("Grade "+ salarygrade[0]['grade'])
                this.form = salarygrade
            },
            updateSalaryGrade: function()
            {
                var c = this.form.length
                this.form.forEach(e => {
                    axios.patch('api/salarygrade/'+ e.id, e)
                    .then(() => {
                        c--;
                        if(c == 0)
                        {
                            toast.fire({
                                icon: 'success',
                                title: 'Updated successfully'
                            });
                        }
                        $('#modal').modal('hide');
                    })
                    .catch(() =>{
                        this.$Progress.fail();
                    })
                });
            }
        },
        mounted() {
            console.log('mounted');
        }
    }
</script>
