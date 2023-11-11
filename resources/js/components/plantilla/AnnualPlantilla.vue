<template>
    <div class="row justify-content-center">
        <div class="col-md-12 text-center" v-if="!$gate.isAdministrator() && !$gate.isAuthor()">
            <not-authorized></not-authorized>
        </div>
        <div v-else class="col-md-12">

            <csc-report></csc-report>

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="d-inline-flex">
                        <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Annual Plantilla {{ this.$parent.settings.plantilla && this.$parent.settings.plantilla.year }}</h2>
                        <a href="" @click.prevent="showEditPlantillaModal()" class="blue ml-2"><i class="far fa-edit"></i></a>
                    </div>
                    <p style="margin: 0;">Date Approved: <span>{{ this.$parent.settings.plantilla && this.$parent.settings.plantilla.date_approved }}</span> </p>
                    <div class="row mt-2">
                        <div class="col-md-5">
                            <div class="form-group" style="margin-bottom:0;">
                                <label style="margin: 0;font-weight: normal;line-height:25px;">Select Department</label>
                                <v-select @input="loadContents($event)" class="form-control form-control-border border-width-2" v-model="selectedDepartment" :getOptionLabel="dept => dept.address" :clearable="false" :options="departments" placeholder="Search Department"></v-select>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <a class="ml-2" style="float: right;margin-top: 26px;font-size: 2.3rem;line-height: 2.3rem;" href="" @click.prevent="plantillaReport()"><i class="fas fa-print"></i></a>
                            <button style="float: right;margin-top: 25px;" type="button" class="btn btn-primary ml-2" @click="duplicatePlantillaModal()">Duplicate Plantilla</button>
                            <button style="float: right;margin-top: 25px;" type="button" class="btn btn-success ml-2" @click="createPlantillaModal()">Create New Plantilla</button>
                            <button style="float: right;margin-top: 25px;" type="button" class="btn btn-success" @click="createItemModal()">Create New Item</button>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0" style="height: 650px;">
                    <table class="table table-hover table-bordered table-striped text-nowrap custom-table plantilla-table">
                        <thead class="plantilla-thead">
                            <tr>
                                <th rowspan="3" style="color: #0088ff;font-size: 0.7rem;">#</th>
                                <th colspan="2" rowspan="2">Item No.</th>
                                <th rowspan="3">Position Title<br>& Name of Incumbent</th>
                                <!-- <th rowspan="3">Name of Incumbent</th> -->
                                <th colspan="2">Current Year Authorized</th>
                                <th colspan="2">Budget Year Proposed</th>
                                <!-- <th rowspan="3">Increase / Decrease</th> -->
                                <th rowspan="3">Date of Birth</th>
                                <th rowspan="3">Date of<br>Original<br>Appointment</th>
                                <th rowspan="3">Date of Last<br>Promotion/<br>Appointment</th>
                                <th rowspan="3">Status</th>
                                <th rowspan="3"></th>
                            </tr>
                            <tr>
                                <th colspan="2" style="font-weight: normal;">Rate/Annum {{ this.previousPlantilla }}</th>
                                <th colspan="2" style="font-weight: normal;">Rate/Annum {{ this.$parent.settings.plantilla && this.$parent.settings.plantilla.year }}</th>
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
                        <tbody class="plantilla-tbody">
                            <tr v-for="record in records" :key="record.id">
                                <td style="text-align: center;color: #0088ff;font-size: 0.7rem;">{{ record.order_number }}</td>
                                <td style="text-align: center;">{{ record.old_number }}</td>
                                <td style="text-align: center;">{{ record.new_number }}</td>
                                <td>
                                    <span style="font-weight: bold;">{{ record.position }}</span>
                                    <br>
                                    <span v-if="record.surname">{{ record | name }}</span>
                                    <span v-else class="green"><b>VACANT</b></span>
                                    <br>
                                    <span v-if="incomplete(record)" class="badge bg-danger">Incomplete Data</span>
                                </td>
                                <!-- <td>{{ record.position }} <span v-if="!record.new_number" class="red"><br>ABOLISHED</span></td> -->
                                <!-- <td v-if="record.surname">{{ record.surname + ', ' + record.firstname + ' ' + (record.nameextension || '') + ' ' + record.middlename }}</td>
                                <td v-else class="green"><b>VACANT</b></td> -->
                                <td style="text-align: center;">{{ record.salaryauthorized !== null ? (record.salaryauthorized.grade + ' / ' + record.salaryauthorized.step) : '' }}</td>
                                <td style="text-align: right;">{{ (record.salaryauthorized !== null ? ((record.working_time == 'Full-time' ? record.salaryauthorized.amount * 12 : (record.salaryauthorized.amount / 2) * 12)) : '')  | amount}}</td>
                                <td style="text-align: center;">{{ record.salaryproposed !== null ? (record.salaryproposed.grade + ' / ' + record.salaryproposed.step) : '' }}</td>
                                <td style="text-align: right;">{{ (record.salaryproposed !== null ? ((record.working_time == 'Full-time' ? record.salaryproposed.amount * 12 : (record.salaryproposed.amount / 2) * 12)) : '') | amount}}</td>
                                <!-- <td style="text-align: right;">{{ getDifference(record) }}</td> -->
                                <td>{{ record.birthdate }}</td>
                                <td>{{ record.original_appointment }}</td>
                                <td>{{ record.last_promotion }}</td>
                                <td>{{ record.appointment_status }}</td>
                                <td style="text-align: center;"><a href="#" @click.prevent="updateItemModal(record)"><i class="fas fa-edit"></i></a></td>
                                <!-- <td style="text-align: center;"><a href="#" @click.prevent="record.new_number ? showEditModal(record) : showRevertConfirmation(record)"><i :class="record.new_number ?'fas fa-edit' : 'fas fa-history'"></i></a></td> -->
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

        <!-- Edit Plantilla Modal -->
        <div class="modal fade" id="edit-plantilla-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-border">
                        <h5 class="modal-title">Edit Plantilla {{ this.$parent.settings.plantilla && this.$parent.settings.plantilla.year }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form autocomplete="off" @submit.prevent="editPlantilla()">
                        <div class="modal-body">
                            <p style="margin-bottom: 5px;"><b>Authorized Salary Schedule: </b>{{ this.$parent.settings.plantilla && this.$parent.settings.plantilla.salaryauthorizedschedule.tranche }}</p>
                            <div class="form-group" style="position: relative;margin-bottom: 0.3rem;">
                                <label style="font-weight: normal; margin: 0;">Proposed Salary Schedule</label>
                                <select v-model="plantillaForm.salary_prop" class="custom-select form-control-border border-width-2">
                                    <option :value="salaryschedule.id" v-for="salaryschedule in schedules" :key="salaryschedule.id">{{ salaryschedule.tranche }}</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="edit_year" style="font-weight: normal; margin: 0;">Plantilla Year</label>
                                        <input v-model="plantillaForm.year" id="edit_year" class="form-control form-control-border border-width-2" type="text" name="year" placeholder="Year"
                                        :class="{ 'is-invalid': plantillaForm.errors.has('year') }" required>
                                        <has-error :form="plantillaForm" field="year"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="edit_date_approved" style="font-weight: normal; margin: 0;">Date Approved (yyyy-mm-dd)</label>
                                        <input v-model="plantillaForm.date_approved" id="edit_date_approved" class="form-control form-control-border border-width-2" type="text" name="date_approved" placeholder="yyyy-mm-dd"
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
                                            maxlength="10">
                                        <has-error :form="plantillaForm" field="date_approved"></has-error>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer modal-border" style="display: flow-root;padding: 6px 10px;">
                            <div id="editLoadingIcon" class="spinner-border text-success d-none" role="status" style="float: left;">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <button id="editButton" type="submit" class="btn btn-success" style="float: right;">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <create-plantilla-modal :key="create_plantilla_modal_key" @exit="createPlantillaModalExit"></create-plantilla-modal>
        <item-form :key="create_item_modal_key" @exit="createItemModalExit" :create_data="create_data"></item-form>
        <duplicate-plantilla-modal :key="duplicate_plantilla_modal_key" @exit="duplicatePlantillaModalExit" :plantilla="plantilla" :schedules="schedules"></duplicate-plantilla-modal>

        <!-- Report Modal -->
        <div class="modal" id="pdfModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header modal-border">
                        <h4 class="modal-title">Print Report</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body" id="pdf-viewer">

                    </div>

                    <div class="modal-footer modal-border">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import createplantillamodal from "./modals/CreatePlantillaModal"
    import itemForm from "./modals/ItemForm"
    import duplicateplantillamodal from "./modals/DuplicatePlantillaModal"
    import cscReport from "./reports/CSC"

    export default {
        data() {
            return {
                departments: [{}],
                itemMin: 0,
                itemMax: 0,
                plantilla: {},
                selectedDepartment: {},
                create_data: {},
                records: [],
                forvacants: [],
                schedules: [],
                plantillaNameForEdit: '',
                previousPlantilla: '',
                prevSalaryauthorized: {},
                prevSalaryproposed: {},
                dateApproved: '',
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
                }),
                create_plantilla_modal_key: 0,
                create_item_modal_key: 1000,
                duplicate_plantilla_modal_key: 2000,
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
            incomplete(record) {
                if (record.personal_information_id != null) {
                    let app_stat = record.appointment_status != "" && record.appointment_status != null
                    let csc = record.csc_level != null
                    let level = record.level != "" && record.level != null
                    let orig_appoint = record.original_appointment != "" && record.original_appointment != null
                    return !(app_stat && csc && level && orig_appoint)
                } else {
                    let csc = record.csc_level != null
                    let level = record.level != "" && record.level != null
                    return !(csc && level)
                }
            },
            showEditPlantillaModal() {
                $('#edit-plantilla-modal').modal('show');
                this.plantillaForm.reset();
                this.plantillaForm.salary_prop = this.$parent.settings.plantilla.salaryproposedschedule.id;
                this.plantillaForm.salary_auth = this.prevSalaryproposed.id;
                this.plantillaForm.year = this.$parent.settings.plantilla.year;
                this.plantillaForm.date_approved = this.$parent.settings.plantilla.date_approved;
            },
            editPlantilla() {
                this.$Progress.start();
                $('#editLoadingIcon').removeClass('d-none');
                $('#editButton').attr('disabled','disabled');
                this.plantillaForm.put('api/plantilla/' + this.$parent.settings.plantilla.id)
                    .then(() => {
                        this.loadContents();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Annual Plantilla ' + this.plantillaForm.year + ' updated successfully',
                        })
                        this.$parent.getSettings();
                        $('#edit-plantilla-modal').modal('hide');
                        this.$Progress.finish();
                        $('#editLoadingIcon').addClass('d-none');
                        $('#editButton').removeAttr('disabled');
                    })
                    .catch(error => {
                        this.$Progress.fail();
                        $('#editLoadingIcon').addClass('d-none');
                        $('#editButton').removeAttr('disabled');
                    });
            },
            createPlantillaModal() {
                $('#create-plantilla-modal').modal('show');
            },
            createPlantillaModalExit(value) {
                this.create_plantilla_modal_key += 1;
            },
            duplicatePlantillaModalExit(value) {
                this.duplicate_plantilla_modal_key += 1;
            },
            updateItemModal(plantillacontent) {
                axios.post('api/department_positions', {department_id: this.selectedDepartment.id})
                    .then(({data}) => {
                        this.create_data = _.assign({department: this.selectedDepartment}, data);
                        this.create_data = _.assign({plantillacontent: plantillacontent}, this.create_data);
                        $('#item-form-modal').modal('show');
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            createItemModal() {
                axios.post('api/department_positions', {department_id: this.selectedDepartment.id})
                    .then(({data}) => {
                        this.create_data = _.assign({department: this.selectedDepartment}, data);
                        this.create_data = _.assign({plantillacontent: null}, this.create_data);
                        this.create_data = _.assign({order_number: this.records.length}, this.create_data);
                        $('#item-form-modal').modal('show');
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            createItemModalExit(value) {
                this.create_item_modal_key += 1;
                if (value == 'sync') {
                    this.loadContents();
                }
            },
            duplicatePlantillaModal() {
                $('#duplicate-plantilla-modal').modal('show');
                this.plantilla = this.$parent.settings.plantilla;
                this.plantillaForm.reset();

                this.plantillaForm.salary_prop = this.schedules[0].id;
                this.plantillaForm.salary_auth = this.prevSalaryproposed.id;
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
            getDifference(record) {
                let difference = ((record.salaryproposed !== null ? record.salaryproposed.amount * 12 : 0) - (record.salaryauthorized !== null ? record.salaryauthorized.amount * 12 : 0));
                if (record.working_time == 'Part-time') {
                    difference = difference / 2;
                }
                return difference < 0 ? '(' + (difference * -1).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ')' : difference.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            getPreviousPlantilla() {
                axios.post('api/previousplantilla', {current: this.$parent.settings.plantilla.year})
                    .then(({data}) => {
                        this.previousPlantilla = data.year;
                        this.prevSalaryauthorized = data.salaryauthorizedschedule;
                        this.prevSalaryproposed = data.salaryproposedschedule;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            generatePlantilla(type){
                if (type == 'CSC') {
                    window.print()
                } else {
                    this.$Progress.start();
                    axios.post('generatePlantilla', {type: type, dept_id: this.selectedDepartment.id})
                        .then(response => {
                            let options = {
                                height: screen.height * 0.65 + 'px',
                                page: '1'
                            };
                            $('#pdfModal').modal('show');
                            PDFObject.embed(response.data.path, "#pdf-viewer", options);
                            this.$Progress.finish();
                        })
                        .catch(error => {
                            console.log(error);
                        })
                        .finally(() => {
                            
                        });
                }
            },
            async plantillaReport() {
                const { value: report } = await Swal.fire({
                    title: 'Select report',
                    input: 'radio',
                    inputOptions: {
                        'DBM': 'DBM',
                        'CSC': 'CSC',
                        'Summary': 'Summary'
                    },
                    inputValidator: (value) => {
                        if (!value) {
                            return 'You need to choose a format!'
                        }
                    }
                })

                if (report) {
                    this.generatePlantilla(report);
                    
                    // wal.fire({ html: `You selected: ${report}` })
                }
            },
            loadDepartments() {
                axios.get('api/department')
                    .then(({data}) => {
                        this.departments = data.data;

                        // Pre select Departments if from Employees component
                        if (this.$route.params.dept != null) {
                            this.selectedDepartment = this.$route.params.dept;
                        } else {
                            this.selectedDepartment = data.data[0];
                        }
                        this.loadContents();
                        this.getPreviousPlantilla();
                        
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            loadSchedules() {
                axios.get('api/salaryschedule')
                    .then(({data}) => {
                        this.schedules = data;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            highlight(element) {
                let defaultBG = element.style.backgroundColor;
                let defaultTransition = element.style.transition;

                element.style.transition = "background 3s";
                element.style.backgroundColor = "#78ff9c";

                setTimeout(function()
                {
                    element.style.backgroundColor = defaultBG;
                    setTimeout(function() {
                        element.style.transition = defaultTransition;
                    }, 3000);
                }, 3000);
            },
            loadContents(e) {
                this.$Progress.start();
                axios.post('api/plantilladepartmentcontent', {department: this.selectedDepartment})
                    .then(({data}) => {
                        this.records = data.data;
                        if (data.data.length > 0) {
                            this.itemMin = data.data[0].new_number;
                            this.itemMax = data.data[data.data.length - 1].new_number;
                        }
                        // this.footnoteForm.department = this.selectedDepartment;

                        // axios.post('api/footnotespec', {department: this.selectedDepartment})
                        //     .then(({data}) => {
                        //         this.footnote = data.note;
                        //         this.footnoteForm.footnote = data.note;
                        //     })
                        //     .catch(error => {
                        //         console.log(error.response.data.message);
                        //     });

                        // Scroll to specific employee
                        this.$nextTick(() => {
                            if (this.$route.params.dept != null) {
                                var table = document.getElementsByClassName("plantilla-table")[0].getElementsByTagName("tbody")[0];
                                for (var r = 0; r < table.rows.length; r++) {
                                    let tb_order_number = parseInt(table.rows[r].cells[0].innerHTML);
                                    let order_number = this.$route.params.order_number;
                                    if (order_number == tb_order_number) {
                                        table.rows[r].scrollIntoView({
                                            behavior: 'smooth',
                                            block: 'center'
                                        });
                                        this.highlight(table.rows[r]);
                                    }
                                }
                            }
                        });

                        this.$Progress.finish();

                    })
                    .catch(error => {
                        this.$Progress.fail();
                        console.log(error.response.data.message);
                    });
            }
        },
        components: {
            'create-plantilla-modal': createplantillamodal,
            'item-form': itemForm,
            'duplicate-plantilla-modal': duplicateplantillamodal,
            'csc-report': cscReport
        },
        created() {
            this.$Progress.start();
            this.loadDepartments();
            this.loadSchedules();
            this.$Progress.finish();
        },
        mounted() {
            
            // console.log('Component mounted.')
        }
    }
</script>
