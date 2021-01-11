<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="d-inline-flex">
                        <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Annual Plantilla {{ this.$parent.settings.plantilla }}</h2>
                        <a href="" @click.prevent="showEditPlantillaModal()" class="blue ml-2"><i class="far fa-edit"></i></a>
                    </div>
                    <p style="margin: 0;">Date Approved: <span>{{  }}</span> </p>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="form-group" style="margin-bottom:0;">
                                <label style="margin: 0;font-weight: normal;line-height:25px;">Select Department</label>
                                <select class="custom-select" v-model="selectedDepartment" @change="loadContents()">
                                    <option v-for="department in departments" :key="department.id">{{ department.address }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <a class="ml-2" style="float: right;margin-top: 26px;font-size: 2.3rem;line-height: 2.3rem;" href="" @click.prevent="generatePlantilla()"><i class="fas fa-print"></i></a>
                            <button style="float: right;margin-top: 25px;" type="button" class="btn btn-primary ml-2" @click="duplicatePlantillaModal()">Duplicate Plantilla</button>
                            <button style="float: right;margin-top: 25px;" type="button" class="btn btn-success" @click="addItemModal()">Create New Item</button>
                        </div>                        
                    </div>
                </div>

                <div class="card-body table-responsive p-0" style="height: 650px;">
                    <table class="table table-hover table-bordered table-striped text-nowrap plantilla-table">
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
                                <td>{{ record.position }} <span v-if="!record.new_number" class="red"><br>ABOLISHED</span></td>
                                <td v-if="record.surname">{{ record.surname + ', ' + record.firstname + ' ' + (record.nameextension != '' ? record.nameextension + ' ' : '') + record.middlename }}</td>
                                <td v-else class="green"><b>VACANT</b></td>
                                <td style="text-align: center;">{{ record.salaryauthorized !== null ? (record.salaryauthorized.grade + ' / ' + record.salaryauthorized.step) : '' }}</td>
                                <td style="text-align: right;">{{ record.salaryauthorized !== null ? ((record.working_time == 'Full-time' ? record.salaryauthorized.amount * 12 : (record.salaryauthorized.amount / 2) * 12).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '' }}</td>
                                <td style="text-align: center;">{{ record.salaryproposed !== null ? (record.salaryproposed.grade + ' / ' + record.salaryproposed.step) : '' }}</td>
                                <td style="text-align: right;">{{ record.salaryproposed !== null ? ((record.working_time == 'Full-time' ? record.salaryproposed.amount * 12 : (record.salaryproposed.amount / 2) * 12).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '' }}</td>
                                <td style="text-align: right;">{{ getDifference(record) }}</td>
                                <td style="text-align: center;"><a href="#" @click.prevent="record.new_number ? showEditModal(record) : showRevertConfirmation(record)"><i :class="record.new_number ?'fas fa-edit' : 'fas fa-history'"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="callout callout-info mb-0">
                        <div class="d-inline-flex">
                            <h5 class="mr-2"><b>Footnote</b></h5>
                            <a href="" @click.prevent="footnoteEdit()" class="blue"><i class="far fa-edit"></i></a>
                        </div>
                        <p id="footnotetext">{{ footnote ? footnote : 'No data' }}</p>
                        <form id="footnoteForm" style="display: none;" autocomplete="off" @submit.prevent="saveFootnote()">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <input v-model="footnoteForm.footnote" id="footnote" class="form-control" type="text" name="footnote" placeholder="Enter your footnote here. . ."
                                        :class="{ 'is-invalid': footnoteForm.errors.has('footnote') }" required>
                                        <has-error :form="footnoteForm" field="footnote"></has-error>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
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
                                <select v-model="form.personal_information_id" class="custom-select form-control-border" id="employeesDropdown">
                                    <option value="null">VACANT</option>
                                    <option :value="forvacant.id" v-for="forvacant in forvacants" :key="forvacant.id">{{ forvacant.surname + ', ' + forvacant.firstname + ' ' + (forvacant.nameextension != '' ? forvacant.nameextension + ' ' : '') + forvacant.middlename }}</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-3" style="padding-right: 5px;">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="new_number" style="font-weight: normal; margin: 0;">Item No.</label>
                                        <input v-model="form.new_number" id="new_number" value="" class="form-control form-control-border" step="1" :min="itemMin" :max="itemMax" type="number" name="new_number" placeholder="New Item Number" required>
                                    </div>
                                </div>
                                <div class="col-9" style="padding-left: 5px;">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="position" style="font-weight: normal; margin: 0;">Position</label>
                                        <input v-model="form.position" id="position" class="form-control form-control-border" type="text" name="position" placeholder="Position" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="budget-grade" style="font-weight: normal; margin: 0;">Budget Year Salary Grade</label>
                                        <input v-model="form.salaryproposed.grade" id="budget-grade" class="form-control form-control-border" step="1" min="1" max="30" type="number" name="budget-grade" placeholder="Grade" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="budget-step" style="font-weight: normal; margin: 0;">Budget Year Salary Step</label>
                                        <input v-model="form.salaryproposed.step" id="budget-step" class="form-control form-control-border" step="1" min="1" max="8" type="number" name="budget-step" placeholder="Step" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="display: block;">
                            <button v-if="form.surname == '' && form.salaryauthorized" type="button" class="btn btn-danger" @click="abolishItem()">Abolish Item</button>
                            <button v-if="form.surname == '' && form.salaryauthorized == null" type="button" class="btn btn-danger" @click="removeItem()">Remove</button>
                            <button type="submit" class="btn btn-success mb-3" style="float: right;">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Item Modal -->
        <div class="modal fade" id="add-item-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Plantilla Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form autocomplete="off" @submit.prevent="addPlantillaItem()">
                        <div class="modal-body">
                            <p style="margin-bottom: 5px;"><b>Department: </b>{{ selectedDepartment }}</p>
                            <div class="row">
                                <div class="col-3" style="padding-right: 5px;">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="add_new_number" style="font-weight: normal; margin: 0;">Item No. (new)</label>
                                        <input v-model="form.new_number" id="add_new_number" class="form-control" step="1" :min="itemMin" :max="(parseInt(itemMax) + 1)" type="number" name="new_number" placeholder="New Item Number" required>
                                    </div>
                                </div>
                                <div class="col-9" style="padding-left: 5px;">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="add_position" style="font-weight: normal; margin: 0;">Position</label>
                                        <input v-model="form.position" id="add_position" class="form-control" type="text" name="position" placeholder="Position" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 0.3rem;">
                                <div class="custom-control custom-radio mr-2" style="display: inline;">
                                    <input class="custom-control-input" type="radio" id="customRadio1" value="Full-time" v-model="form.working_time" name="working_time" checked>
                                    <label for="customRadio1" class="custom-control-label" style="font-weight: normal; margin: 0;">Full-time</label>
                                </div>
                                <div class="custom-control custom-radio" style="display: inline;">
                                    <input class="custom-control-input" type="radio" id="customRadio2" value="Part-time" v-model="form.working_time" name="working_time">
                                    <label for="customRadio2" class="custom-control-label" style="font-weight: normal; margin: 0;">Part-time</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="add_budget-grade" style="font-weight: normal; margin: 0;">Budget Year Salary Grade</label>
                                        <input v-model="form.salaryproposed.grade" id="add_budget-grade" class="form-control" step="1" min="1" max="30" type="number" name="budget-grade" placeholder="Grade" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="add_budget-step" style="font-weight: normal; margin: 0;">Budget Year Salary Step</label>
                                        <input v-model="form.salaryproposed.step" id="add_budget-step" class="form-control" step="1" min="1" max="8" type="number" name="budget-step" placeholder="Step" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Duplicate Plantilla Modal -->
        <div class="modal fade" id="duplicate-plantilla-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Duplicate Annual Plantilla {{ this.$parent.settings.plantilla }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form autocomplete="off" @submit.prevent="duplicatePlantilla()">
                        <div class="modal-body">
                            <p style="margin-bottom: 5px;"><b>Authorized Salary Schedule: </b>{{ salaryproposed.tranche }}</p>
                            <div class="form-group" style="position: relative;margin-bottom: 0.3rem;">
                                <label style="font-weight: normal; margin: 0;">Proposed Salary Schedule</label>
                                <select v-model="plantillaForm.salary_prop" class="custom-select form-control-border border-width-2">
                                    <option :value="salaryschedule.id" v-for="salaryschedule in schedules" :key="salaryschedule.id">{{ salaryschedule.tranche }}</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="year" style="font-weight: normal; margin: 0;">Plantilla Year</label>
                                        <input v-model="plantillaForm.year" id="year" class="form-control" type="text" name="year" placeholder="Year"
                                        :class="{ 'is-invalid': plantillaForm.errors.has('year') }" required>
                                        <has-error :form="plantillaForm" field="year"></has-error>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="display: flow-root;padding: 6px 10px;">
                            <div id="duplicateLoadingIcon" class="spinner-border text-success d-none" role="status" style="float: left;">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <button id="duplicateButton" type="submit" class="btn btn-success" style="float: right;">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Plantilla Modal -->
        <div class="modal fade" id="edit-plantilla-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Plantilla {{ this.$parent.settings.plantilla }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form autocomplete="off" @submit.prevent="editPlantilla()">
                        <div class="modal-body">
                            <p style="margin-bottom: 5px;"><b>Authorized Salary Schedule: </b>{{ salaryproposed.tranche }}</p>
                            <div class="form-group" style="position: relative;margin-bottom: 0.3rem;">
                                <label style="font-weight: normal; margin: 0;">Proposed Salary Schedule</label>
                                <select v-model="plantillaForm.salary_prop" class="custom-select form-control-border border-width-2">
                                    <option :value="salaryschedule.id" v-for="salaryschedule in schedules" :key="salaryschedule.id">{{ salaryschedule.tranche }}</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="year" style="font-weight: normal; margin: 0;">Plantilla Year</label>
                                        <input v-model="plantillaForm.year" id="year" class="form-control" type="text" name="year" placeholder="Year"
                                        :class="{ 'is-invalid': plantillaForm.errors.has('year') }" required>
                                        <has-error :form="plantillaForm" field="year"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="date_approved" style="font-weight: normal; margin: 0;">Date Approved (yyyy-mm-dd)</label>
                                        <input v-model="plantillaForm.date_approved" id="date_approved" class="form-control" type="text" name="date_approved" placeholder="yyyy-mm-dd"
                                        :class="{ 'is-invalid': plantillaForm.errors.has('date_approved') }" 
                                            onkeypress="return event.charCode > 47 && event.charCode < 58;" 
                                            onkeydown="var date = this.value;
                                                if (window.event.keyCode == 8) {
                                                    this.value = date;
                                                } else if (date.match(/^\d{4}$/) !== null) {
                                                    this.value = date + '-';
                                                } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                    this.value = date + '-';
                                                }
                                            " 
                                            maxlength="10" required>
                                        <has-error :form="plantillaForm" field="date_approved"></has-error>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="display: flow-root;padding: 6px 10px;">
                            <div id="duplicateLoadingIcon" class="spinner-border text-success d-none" role="status" style="float: left;">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <button id="duplicateButton" type="submit" class="btn btn-success" style="float: right;">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Report Modal -->
        <div class="modal" id="pdfModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Print Report</h4>
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

    </div>
</template>

<script>
    export default {
        data() {
            return {
                departments: {},
                itemMin: 0,
                itemMax: 0,
                selectedDepartment: '',
                records: [],
                forvacants: [],
                schedules: [],
                plantillaNameForEdit: '',
                previousPlantilla: '',
                salaryauthorized: {},
                salaryproposed: {},
                footnote: '',
                footnoteForm: new Form({
                    'footnote': '',
                    'department': ''
                }),
                plantillaForm: new Form({
                    'year': '',
                    'salary_auth': '',
                    'salary_prop': '',
                    'date_approved': ''
                }),
                form: new Form( {
                    'id': '',
                    'personal_information_id': '',
                    'department': '',
                    'firstname': '',
                    'middlename': '',
                    'nameextension': '',
                    'new_number': '',
                    'old_number': '',
                    'original_position': '',
                    'original_item_number': '',
                    'position': '',
                    'position_id': '',
                    'surname': '',
                    'working_time': 'Full-time',
                    'salaryauthorized': {},
                    'salaryproposed': {}
                })
            }
        },
        methods: {
            footnoteEdit() {
                $('#footnotetext').toggle("slide");
                $('#footnoteForm').toggle("slide");
            },
            saveFootnote() {
                this.footnoteForm.post('api/footnote')
                    .then(({data}) => {
                        toast.fire({
                            icon: 'success',
                            title: 'Footnote updated successfully'
                        });
                        $('#footnotetext').toggle("slide");
                        $('#footnoteForm').toggle("slide");
                        this.footnote = data.note;
                        this.footnoteForm.footnote = '';
                        this.$Progress.finish();
                    })
                    .catch(error => {
                        this.$Progress.fail();
                    });
            },
            showEditPlantillaModal() {
                $('#edit-plantilla-modal').modal('show');
                this.plantillaForm.reset();
                axios.get('api/salaryschedule')
                    .then(({data}) => {
                        this.schedules = data;
                        this.plantillaForm.salary_prop = data[0].id;
                        this.plantillaForm.salary_auth = this.salaryproposed.id;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            addItemModal() {
                $('#add-item-modal').modal('show');
                this.form.reset();
                this.form.department = this.selectedDepartment;
            },
            duplicatePlantilla() {
                this.$Progress.start();
                $('#duplicateLoadingIcon').removeClass('d-none');
                $('#duplicateButton').attr('disabled','disabled');
                this.plantillaForm.post('api/plantilla')
                    .then(() => {
                        this.loadContents();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Annual Plantilla ' + this.plantillaForm.year + ' created successfully',
                        })
                        $('#duplicate-plantilla-modal').modal('hide');     
                        this.$Progress.finish();
                        $('#duplicateLoadingIcon').addClass('d-none');
                        $('#duplicateButton').removeAttr('disabled');
                    })
                    .catch(error => {
                        this.$Progress.fail();
                        $('#duplicateLoadingIcon').addClass('d-none');
                        $('#duplicateButton').removeAttr('disabled');
                    });
            },
            duplicatePlantillaModal() {
                $('#duplicate-plantilla-modal').modal('show');
                this.plantillaForm.reset();
                axios.get('api/salaryschedule')
                    .then(({data}) => {
                        this.schedules = data;
                        this.plantillaForm.salary_prop = data[0].id;
                        this.plantillaForm.salary_auth = this.salaryproposed.id;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            showRevertConfirmation(record) {
                axios.get('api/abolisheditem/' + record.id)
                    .then(({data}) => {
                        Swal.fire({
                            title: 'Revert abolished item?',
                            text: record.position + ' (Item No. ' + data.data.new_number + ')',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Proceed'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.$Progress.start();
                                axios.put('api/abolisheditem/' + data.data.id)
                                    .then(({data}) => {
                                        this.loadContents();
                                        toast.fire({
                                            icon: 'success',
                                            title: 'Record updated successfully'
                                        });
                                        this.$Progress.finish();
                                    })
                                    .catch(error => {
                                        this.$Progress.fail();
                                    });
                            }
                        });
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            removeItem() {
                $('#plantilla-content-modal').modal('hide');
                Swal.fire({
                    title: 'Are you sure you want to remove this item?',
                    text: this.form.original_position + ' (Item No. ' + this.form.original_item_number + ')',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Remove'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$Progress.start();
                        axios.delete('api/plantillacontent/' + this.form.id)
                            .then(({data}) => {
                                this.loadContents();
                                toast.fire({
                                    icon: 'success',
                                    title: 'Record removed successfully'
                                });
                                this.$Progress.finish();
                            })
                            .catch(error => {
                                this.$Progress.fail();
                            });
                    }
                });
            },
            abolishItem() {
                $('#plantilla-content-modal').modal('hide');
                Swal.fire({
                    title: 'Are you sure you want to abolish this item?',
                    text: this.form.original_position + ' (Item No. ' + this.form.original_item_number + ')',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Proceed'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$Progress.start();
                        this.form.put('api/plantillacontentabolish')
                            .then(() => {
                                this.loadContents();
                                toast.fire({
                                    icon: 'success',
                                    title: 'Record updated successfully'
                                });
                                this.$Progress.finish();
                            })
                            .catch(() => {
                                this.$Progress.fail();
                            });
                    }
                });
            },
            showEditModal(record) {
                $('#plantilla-content-modal').modal('show');
                this.form.reset();
                if (record.salaryproposed) {
                    this.form.fill(record);
                    this.form.original_position = record.position;
                    this.form.original_item_number = record.new_number;
                    this.plantillaNameForEdit =  record.surname ? (record.surname + ', ' + record.firstname + ' ' + (record.nameextension != '' ? record.nameextension + ' ' : '') + record.middlename) : 'VACANT';
                } else {
                    this.form.id = record.id;
                    this.form.new_number = '';
                    this.form.surname = '';
                    this.form.original_item_number = '';
                    this.form.original_position = record.position;
                    this.form.personal_information_id = null;
                    this.form.position = record.position;
                    this.form.position_id = record.position_id;
                    this.form.salaryauthorized = record.salaryauthorized;
                    this.form.salaryproposed.grade = '';
                    this.form.salaryproposed.step = '';
                    this.form.working_time = record.working_time;
                    this.plantillaNameForEdit = 'VACANT';
                }
                axios.post('api/forvacants', {personal_information_id: this.form.personal_information_id})
                    .then(({data}) => {
                        this.forvacants = data;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            getDifference(record) {
                let difference = ((record.salaryproposed !== null ? record.salaryproposed.amount * 12 : 0) - (record.salaryauthorized !== null ? record.salaryauthorized.amount * 12 : 0));
                if (record.working_time == 'Part-time') {
                    difference = difference / 2;
                }
                return difference < 0 ? '(' + (difference * -1).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ')' : difference.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            getPreviousPlantilla() {
                axios.post('api/previousplantilla', {current: this.$parent.settings.plantilla})
                    .then(({data}) => {
                        this.previousPlantilla = data.year;
                        this.salaryauthorized = data.salaryauthorizedschedule;
                        this.salaryproposed = data.salaryproposedschedule;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            addPlantillaItem() {
                this.form.post('api/plantillacontent')
                    .then(() => {
                        this.loadContents();
                        toast.fire({
                            icon: 'success',
                            title: 'Item added successfully'
                        });
                        $('#add-item-modal').modal('hide');     
                        this.$Progress.finish();
                    })
                    .catch(error => {
                        this.$Progress.fail();
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
            generatePlantilla(){
                axios.post('generatePlantilla')
                    .then(response => {
                        let options = {
                            height: screen.height * 0.65 + 'px',
                            page: '1'
                        };
                        $('#pdfModal').modal('show');
                        PDFObject.embed("/storage/plantilla_reports/test.pdf", "#pdf-viewer", options);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            loadDepartments() {
                axios.get('api/department')
                    .then(({data}) => {
                        this.departments = data.data;
                        this.selectedDepartment = data.data[0].address;
                        this.loadContents();
                        this.getPreviousPlantilla();
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            loadContents() {
                this.$Progress.start();
                axios.post('api/plantilladepartmentcontent', {department: this.selectedDepartment})
                    .then(({data}) => {
                        this.records = data.data;
                        this.itemMin = data.data[0].new_number;
                        this.itemMax = data.data[data.data.length - 1].new_number;
                        this.footnoteForm.department = this.selectedDepartment;
                        this.$Progress.finish();
                        axios.post('api/footnotespec', {department: this.selectedDepartment})
                            .then(({data}) => {
                                this.footnote = data.note;
                                this.footnoteForm.footnote = data.note;
                            })
                            .catch(error => {
                                console.log(error.response.data.message);
                            })
                    })
                    .catch(error => {
                        this.$Progress.fail();
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
