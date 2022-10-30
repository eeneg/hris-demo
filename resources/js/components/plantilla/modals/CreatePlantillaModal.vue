<template>
    <div class="modal fade" id="create-plantilla-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header modal-border">
                    <h5 class="modal-title"><strong>Create New Plantilla</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="exitModal()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form autocomplete="off" @submit.prevent="createPlantilla()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group" style="margin-bottom: 0.3rem;">
                                    <label for="year" style="font-weight: normal; margin: 0;">Plantilla Year</label>
                                    <input v-model="plantillaForm.year" id="year" class="form-control form-control-border border-width-2" type="text" name="year" placeholder="Year"
                                    :class="{ 'is-invalid': plantillaForm.errors.has('year') }" required>
                                    <has-error :form="plantillaForm" field="year"></has-error>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group" style="position: relative;margin-bottom: 0.3rem;">
                                    <label style="font-weight: normal; margin: 0;">Authorized Salary Schedule</label>
                                    <select v-model="plantillaForm.salary_auth" class="custom-select form-control-border border-width-2" required>
                                        <option :value="salaryschedule.id" v-for="salaryschedule in schedules" :key="salaryschedule.id">{{ salaryschedule.tranche }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group" style="position: relative;margin-bottom: 0.3rem;">
                                    <label style="font-weight: normal; margin: 0;">Proposed Salary Schedule</label>
                                    <select v-model="plantillaForm.salary_prop" class="custom-select form-control-border border-width-2" required>
                                        <option :value="salaryschedule.id" v-for="salaryschedule in schedules" :key="salaryschedule.id">{{ salaryschedule.tranche }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 table-responsive" style="height: 450px;">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Office</th>
                                            <th>Description</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <draggable v-model="departments" tag="tbody">
                                        <tr v-for="(department, index) in departments" :key="department.id" class="tr-move-item">
                                            <td contenteditable="true">{{ index + 1 }}</td>
                                            <td>{{ department.title }}</td>
                                            <td>{{ department.description }}</td>
                                            <td>
                                                <a href="#" class="text-danger" @click.prevent="remove_item(index)" style="padding: 5px;"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    </draggable>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-border" style="display: flow-root;padding: 6px 10px;">
                        <div v-if="loading" class="spinner-border text-success" role="status" style="float: left;">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <button type="submit" class="btn btn-success" style="float: right;" :disabled="loading">Create</button>
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
                plantillaForm: new Form({
                    'year': '',
                    'salary_auth': '',
                    'salary_prop': '',
                    'date_approved': '',
                    'plantilla_depts': [],
                }),
                schedules: [],
                departments: [],
                loading: false,
            }
        },
        components: {
            draggable
        },
        props: {
            // key: Number,
        },
        methods: {
            createPlantilla() {
                this.$Progress.start();
                this.loading = true;
                this.plantillaForm.plantilla_depts = this.departments;
                this.plantillaForm.post('api/plantilla')
                    .then(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Annual Plantilla ' + this.plantillaForm.year + ' created successfully',
                        })
                        $('#create-plantilla-modal').modal('hide');
                        this.$Progress.finish();
                        this.loading = false;
                        this.$emit('exit');
                    })
                    .catch(error => {
                        this.$Progress.fail();
                        console.log(error.response.data.message);
                        this.loading = false;
                    });
            },
            exitModal() {
                this.$emit('exit');
            },
            remove_item(index) {
                this.departments.splice(index, 1);
            },
            init_contents() {
                axios.get('api/salaryschedule')
                    .then(({data}) => {
                        this.schedules = data;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });

                axios.get('api/complete_depts')
                    .then(({data}) => {
                        this.departments = data.data;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            }
        },
        mounted() {
            this.init_contents()
        },
        created() {
            
        }
    }
</script>