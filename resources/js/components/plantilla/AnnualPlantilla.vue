<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Annual Plantilla {{ this.$parent.settings.plantilla }}</h2>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="form-group" style="margin-bottom:0;">
                                <label style="margin: 0;font-weight: normal;">Select Department</label>
                                <select class="custom-select" v-model="selectedDepartment" @change="loadContents()">
                                    <option v-for="department in departments" :key="department.id">{{ department.title }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped text-nowrap plantilla-table">
                        <thead>
                            <tr>
                                <th colspan="2" rowspan="2" style="font-size: 1rem;">Item No.</th>
                                <th rowspan="3" style="font-size: 1rem;">Position Title</th>
                                <th rowspan="3" style="font-size: 1rem;">Name of Incumbent</th>
                                <th colspan="2" style="font-size: 1rem;">Current Year Authorized</th>
                                <th colspan="2" style="font-size: 1rem;">Budget Year Proposed</th>
                                <th rowspan="3" style="font-size: 1rem;">Increase / Decrease</th>
                                <th rowspan="3"></th>
                            </tr>
                            <tr>
                                <th colspan="2" style="font-weight: normal;">Rate/Annum {{ this.previousPlantilla }}</th>
                                <th colspan="2" style="font-weight: normal;">Rate/Annum {{ this.$parent.settings.plantilla }}</th>
                            </tr>
                            <tr>
                                <th style="font-weight: normal;">Old</th>
                                <th style="font-weight: normal;">New</th>
                                <th style="font-weight: normal;">Salary Grade/Step</th>
                                <th style="font-weight: normal;">Amount</th>
                                <th style="font-weight: normal;">Salary Grade/Step</th>
                                <th style="font-weight: normal;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="record in records" :key="record.id">
                                <td style="text-align: center;">{{ record.old_number }}</td>
                                <td style="text-align: center;">{{ record.new_number }}</td>
                                <td>{{ record.position }}</td>
                                <td>{{ record.surname ? (record.surname + ', ' + record.firstname + ' ' + (record.nameextension != '' ? record.nameextension + ' ' : '') + record.middlename) : 'VACANT' }}</td>
                                <td style="text-align: center;">{{ record.salaryauthorized !== null ? (record.salaryauthorized.grade + ' / ' + record.salaryauthorized.step) : '' }}</td>
                                <td style="text-align: right;">{{ record.salaryauthorized !== null ? ((record.salaryauthorized.amount * 12).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '' }}</td>
                                <td style="text-align: center;">{{ record.salaryproposed !== null ? (record.salaryproposed.grade + ' / ' + record.salaryproposed.step) : '' }}</td>
                                <td style="text-align: right;">{{ record.salaryproposed !== null ? ((record.salaryproposed.amount * 12).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '' }}</td>
                                <td style="text-align: right;">{{ getDifference(record.salaryauthorized, record.salaryproposed) }}</td>
                                <td style="text-align: center;"><a href="#" @click.prevent="showEditModal(record)"><i class="fas fa-edit"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-info"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="plantilla-content-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Plantilla Record</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form autocomplete="off" @submit.prevent="updatePlantillaRecord()">
                        <div class="modal-body">
                            <div class="form-group" style="position: relative;margin-bottom: 0.3rem;">
                                <label style="font-weight: normal; margin: 0;">Employee name</label>
                                <select v-model="form.personal_information_id" class="custom-select" id="employeesDropdown">
                                    <option value="null">VACANT</option>
                                    <option :value="forvacant.id" v-for="forvacant in forvacants" :key="forvacant.id">{{ forvacant.surname + ', ' + forvacant.firstname + ' ' + (forvacant.nameextension != '' ? forvacant.nameextension + ' ' : '') + forvacant.middlename }}</option>
                                </select>
                            </div>
                            <div class="form-group" style="margin-bottom: 0.3rem;">
                                <label for="new_number" style="font-weight: normal; margin: 0;">Item No. (new)</label>
                                <input v-model="form.new_number" id="new_number" class="form-control" step="1" :min="itemMin" :max="itemMax" type="number" name="new_number" placeholder="New Item Number" required>
                            </div>
                            <div class="form-group" style="margin-bottom: 0.3rem;">
                                <label for="position" style="font-weight: normal; margin: 0;">Position</label>
                                <input v-model="form.position" id="position" class="form-control" type="text" name="position" placeholder="Position" required>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="budget-grade" style="font-weight: normal; margin: 0;">Budget Year Salary Grade</label>
                                        <input v-model="form.salaryproposed.grade" id="budget-grade" class="form-control" step="1" min="1" max="30" type="number" name="budget-grade" placeholder="Grade" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="budget-step" style="font-weight: normal; margin: 0;">Budget Year Salary Step</label>
                                        <input v-model="form.salaryproposed.step" id="budget-step" class="form-control" step="1" min="1" max="8" type="number" name="budget-step" placeholder="Step" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                departments: {},
                itemMin: '',
                itemMax: '',
                selectedDepartment: '',
                records: {},
                forvacants: {},
                plantillaNameForEdit: '',
                previousPlantilla: '',
                form: new Form( {
                    'id': '',
                    'personal_information_id': '',
                    'firstname': '',
                    'middlename': '',
                    'nameextension': '',
                    'new_number': '',
                    'old_number': '',
                    'position': '',
                    'position_id': '',
                    'surname': '',
                    'salaryauthorized': {},
                    'salaryproposed': {}
                })
            }
        },
        methods: {
            showEditModal(record) {
                $('#plantilla-content-modal').modal('show');
                this.form.reset();
                this.form.fill(record);
                this.plantillaNameForEdit =  record.surname ? (record.surname + ', ' + record.firstname + ' ' + (record.nameextension != '' ? record.nameextension + ' ' : '') + record.middlename) : 'VACANT';
                axios.post('api/forvacants', {personal_information_id: this.form.personal_information_id})
                    .then(({data}) => {
                        this.forvacants = data;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            getDifference(authorized, proposed) {
                let difference = ((proposed !== null ? proposed.amount * 12 : 0) - (authorized !== null ? authorized.amount * 12 : 0));
                return difference < 0 ? '(' + (difference * -1).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ')' : difference.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            getPreviousPlantilla() {
                axios.post('api/previousplantilla', {current: this.$parent.settings.plantilla})
                    .then(({data}) => {
                        this.previousPlantilla = data.year;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            updatePlantillaRecord() {
                this.$Progress.start();
                this.form.put('api/plantillacontent/' + this.form.id)
                    .then(() => {
                        this.loadContents();
                        toast.fire({
                            icon: 'success',
                            title: 'Record updated successfully'
                        });
                        $('#plantilla-content-modal').modal('hide');    
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });
            },
            loadDepartments() {
                axios.get('api/department')
                    .then(({data}) => {
                        this.departments = data.data;
                        this.selectedDepartment = data.data[0].title;
                        this.loadContents();
                        this.getPreviousPlantilla();
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            loadContents() {
                axios.post('api/plantilladepartmentcontent', {department: this.selectedDepartment})
                    .then(({data}) => {
                        this.records = data.data;
                        this.itemMin = data.data[0].new_number;
                        this.itemMax = data.data[data.data.length - 1].new_number;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            }
        },
        created() {
            this.$Progress.start();

            this.loadDepartments();

            this.$Progress.finish();
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
