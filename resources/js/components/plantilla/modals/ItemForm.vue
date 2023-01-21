<template>
    <div class="modal fade" id="item-form-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header modal-border">
                    <h5 class="modal-title"><strong>Create/Update Item</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="exitModal()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form autocomplete="off" @submit.prevent="createItem()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <p style="margin-bottom: 5px;"><b>Department: </b>{{ create_data.department ? create_data.department.address : '' }}</p>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label for="add_position" style="font-weight: bold; margin: 0;">Position</label>
                                    <v-select taggable @input="selectPos($event)" class="form-control form-control-border border-width-2" v-model="form.position" :options="create_data.positions" label="title" placeholder="Select Position">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" :required="!form.position" v-bind="attributes" v-on="events" />
                                        </template>
                                    </v-select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label style="font-weight: bold; margin: 0;">Employee name</label>
                                    <v-select @input="selectEmployee()" class="form-control form-control-border border-width-2" v-model="form.personal_information_id" :options="create_data.allEmployees" label="name" :reduce="employee => employee.id" placeholder="Select Employee"></v-select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-3">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label style="font-weight: bold; margin: 0;">Item No. (OLD)</label>
                                    <input v-model="form.old_number" class="form-control form-control-border border-width-2" step="1" type="number" name="old_number" placeholder="Old Item Number">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label style="font-weight: bold; margin: 0;">Item No. (NEW)</label>
                                    <input v-model="form.new_number" class="form-control form-control-border border-width-2" step="1" type="number" name="new_number" placeholder="New Item Number">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label style="font-weight: bold; margin: 0;">SG Authorized "Grade/Step"</label>
                                    <input v-model="form.salary_grade_auth" class="form-control form-control-border border-width-2" pattern="[1-3]?[0-9]\/[1-8]" type="text" name="salary_grade_auth" placeholder="Separate with /">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label style="font-weight: bold; margin: 0;">SG Proposed "Grade/Step"</label>
                                    <input v-model="form.salary_grade_prop" class="form-control form-control-border border-width-2" pattern="[1-3]?[0-9]\/[1-8]" type="text" name="salary_grade_prop" placeholder="Separate with /">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-3">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label style="font-weight: bold; margin: 0 0 10px 0;display: block;">Working Time</label>
                                    <div class="custom-control custom-radio mr-2" style="display: inline;">
                                        <input class="custom-control-input" type="radio" id="full_time" value="Full-time" v-model="form.working_time" name="working_time">
                                        <label for="full_time" class="custom-control-label" style="font-weight: normal; margin: 0;">Full-time</label>
                                    </div>
                                    <div class="custom-control custom-radio" style="display: inline;">
                                        <input class="custom-control-input" type="radio" id="part_time" value="Part-time" v-model="form.working_time" name="working_time">
                                        <label for="part_time" class="custom-control-label" style="font-weight: normal; margin: 0;">Part-time</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label style="font-weight: bold; margin: 0;">Level</label>
                                    <v-select class="form-control form-control-border border-width-2" v-model="form.level" :options="level" placeholder="Select Level">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" :required="!form.level" v-bind="attributes" v-on="events" />
                                        </template>
                                    </v-select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label style="font-weight: bold; margin: 0;">Date of Original Appointment</label>
                                    <input class="form-control form-control-border border-width-2" type="date" v-model="form.original_appointment" name="original_appointment">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label style="font-weight: bold; margin: 0;">Date of Last Promotion</label>
                                    <input class="form-control form-control-border border-width-2" type="date" v-model="form.last_promotion" name="last_promotion">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-3">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label style="font-weight: bold; margin: 0;">Appointment Status</label>
                                    <v-select class="form-control form-control-border border-width-2" v-model="form.appointment_status" :options="appointment_status" placeholder="Select Status" req>
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" :required="!form.appointment_status" v-bind="attributes" v-on="events" />
                                        </template>
                                    </v-select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label style="font-weight: bold; margin: 0;">Order Number</label>
                                    <input v-model="form.order_number" class="form-control form-control-border border-width-2" step="1" type="number" name="order_number" placeholder="Order number" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-border" style="display: flow-root;padding: 6px 10px;">
                        <div v-if="loading" class="spinner-border text-primary" role="status" style="float: right;">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <button type="submit" class="btn btn-primary" style="float: left;" :disabled="loading">Save Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: false,
                level: ['Key Positions', 'Administrative Positions', 'Support to Key Positions', 'Technical Positions'],
                appointment_status: ['Permanent', 'Elected', 'Temporary', 'Co-terminous', 'Presidential Appointee'],
                form: new Form( {
                    'id': '',
                    'personal_information_id': null,
                    'salary_grade_auth': '',
                    'salary_grade_prop': '',
                    'position': '',
                    'new_number': '',
                    'old_number': '',
                    'difference_amount': 0,
                    'working_time': 'Full-time',
                    'level': 'Key Positions',
                    'original_appointment': '',
                    'last_promotion': '',
                    'appointment_status': '',
                    'order_number': '',
                    'department_id': ''
                }),
            }
        },
        components: {
            // draggable
        },
        props: {
            create_data: {
                positions: [],
                allEmployees: [],
                department: {},
                plantillacontent: {},
                order_number: 0
            }
        },
        watch: {
            create_data: function(newData, oldData) {
                if(newData.plantillacontent != null) {
                    const planCont = newData.plantillacontent;
                    this.form.personal_information_id = planCont.personal_information_id;
                    this.form.position = {};
                    this.form.position.id = planCont.position_id;
                    this.form.position.title = planCont.position;
                    this.form.new_number = planCont.new_number;
                    this.form.old_number = planCont.old_number;
                    this.form.salary_grade_auth = planCont.salaryauthorized != null ? (planCont.salaryauthorized.grade + '/' + planCont.salaryauthorized.step) : '';
                    this.form.salary_grade_prop = planCont.salaryproposed != null ? (planCont.salaryproposed.grade + '/' + planCont.salaryproposed.step) : '';
                    this.form.working_time = planCont.working_time;
                    this.form.level = planCont.level;
                    this.form.original_appointment = planCont.original_appointment;
                    this.form.last_promotion = planCont.last_promotion;
                    this.form.appointment_status = planCont.appointment_status;
                    this.form.order_number = planCont.order_number;
                    this.form.department_id = newData.department.id;
                    this.form.id = planCont.id;
                } else {
                    this.form.order_number = newData.order_number + 1;
                }
            }
        },
        methods: {
            createItem() {
                this.$Progress.start();
                this.loading = true;
                this.form.department_id = this.create_data.department.id;
                if (this.form.id == '') {
                    this.form.post('api/plantillacontent')
                        .then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Item added successfully',
                            })
                            this.$emit('exit', 'sync');
                            this.$Progress.finish();
                            this.loading = false;
                            $('#item-form-modal').modal('hide');
                        })
                        .catch(error => {
                            this.$Progress.fail();
                            console.log(error.response.data.message);
                            this.loading = false;
                        });
                } else {
                    this.form.put('api/plantillacontent/' + this.form.id)
                        .then(() => {
                            toast.fire({
                                icon: 'success',
                                title: 'Item updated successfully'
                            });
                            this.$emit('exit', 'sync');
                            this.$Progress.finish();
                            this.loading = false;
                            $('#item-form-modal').modal('hide');
                        })
                        .catch(() => {
                            this.$Progress.fail();
                        });
                }
            },
            selectEmployee() {
                
            },
            selectPos(e) {
                
            },
            exitModal() {
                this.$emit('exit');
            },
            remove_item(index) {
                // this.departments.splice(index, 1);
            },
            init_contents() {
                // axios.get('api/salaryschedule')
                //     .then(({data}) => {
                //         this.schedules = data;
                //     })
                //     .catch(error => {
                //         console.log(error.response.data.message);
                //     });

                // axios.get('api/complete_depts')
                //     .then(({data}) => {
                //         this.departments = data.data;
                //     })
                //     .catch(error => {
                //         console.log(error.response.data.message);
                //     });
            }
        },
        mounted() {
            // this.init_contents()
        },
        created() {
            
        }
    }
</script>