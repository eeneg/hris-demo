<template>
    <div class="modal fade" id="add-department-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header modal-border">
                    <h5 class="modal-title">Add department for <strong>Annual Plantilla {{ plantilla.year }}</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="exitModal()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form autocomplete="off" @submit.prevent="saveChanges()">
                    <div class="modal-body">
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
                                    <draggable v-model="departments_to_be_displayed" tag="tbody">
                                        <tr v-for="(department, index) in departments_to_be_displayed" :key="department.id" class="tr-move-item" :style="newDept(department) ? 'background-color: #d1ffe4' : ''">
                                            <td contenteditable="true">{{ index + 1 }}</td>
                                            <td>{{ department.title }}</td>
                                            <td>{{ department.description }}</td>
                                            <td>
                                                <a v-if="newDept(department)" href="#" class="text-danger" @click.prevent="remove_item(index)" style="padding: 5px;"><i class="fas fa-trash"></i></a>
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
                        <button type="submit" class="btn btn-success" :disabled="loading">Save Changes</button>
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
                form: new Form({
                    'id': '',
                    'plantilla_depts': [],
                }),
                schedules: [],
                loading: false,
                availableDepartments: [],
                departments_to_be_displayed: []
            }
        },
        components: {
            draggable
        },
        props: {
            departments: Array,
            plantilla: Object
        },
        methods: {
            saveChanges() {
                this.$Progress.start();
                this.loading = true;
                this.form.id = this.plantilla.id
                this.form.plantilla_depts = this.departments_to_be_displayed
                this.form.post('api/add_departments')
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Departments are updated successfully',
                        })
                        $('#add-department-modal').modal('hide');

                        this.$Progress.finish();
                        this.loading = false;
                        this.$emit('exit');
                    })
                    .catch(error => {
                        console.log(error.response.data.message)
                    })
            },
            newDept(department) {
                return _.includes(this.availableDepartments, department)
            },
            exitModal() {
                // this.$emit('exit');
            },
            remove_item(index) {
                this.departments_to_be_displayed.splice(index, 1);
            },
            loadAvailableDepartments() {
                axios.get('api/complete_depts')
                    .then(response => {
                        var all_departments = response.data.data
                        _.pullAllBy(all_departments, this.departments, 'id')
                        this.availableDepartments = all_departments

                        this.departments_to_be_displayed = _.concat(this.availableDepartments, this.departments)
                    })
                    .catch(error => {
                        console.log(error.response.data.message)
                    })
            },
        },
        watch: {
            departments: {
                handler: function() {
                    this.loadAvailableDepartments()
                },
            }
        },
        mounted() {
            
        },
        created() {
            
        }
    }
</script>