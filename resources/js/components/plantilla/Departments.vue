<template>
   <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3>Departments and Positions</h3>
                </div>

                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-md-4">
                            <div class="form-group" style="position: relative;margin-bottom: 0.3rem;">
                                <v-select @input="filter_departments()" class="form-control form-control-border border-width-2" v-model="search_depts" :options="departments.data" label="title" placeholder="Search department" :reduce="departments => departments.id"></v-select>
                            </div>
                        </div>
                       <div class="col-md-8">
                            <button type="button" class="btn btn-primary float-right" @click.prevent="create_department_modal()">
                                Create <i class="fas fa-plus"></i>
                            </button>
                       </div>
                    </div>
                    <div class="row">
                        <div class="card-body table-responsive p-0" style="height: 650px;">
                            <table class="table table-striped text-nowrap custom-table">
                                <thead>
                                    <tr>
                                        <th>Department</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(department, index) in departments.data" :key="department.id">
                                        <td>
                                            <div style="display: inline-block;vertical-align: middle;line-height: 1.2rem;height: 35px;">
                                                <span style="font-size: 1rem;">{{ department.title }}</span>
                                                <br>
                                                <span style="font-size: 0.8rem;" class="text-muted"><i>{{ department.description }}</i></span>
                                            </div>
                                        </td>
                                        <td style="width: calc(100%-150px);" v-if="$gate.isAdministrator()">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a v-if="department.positions.length > 0" class="dropdown-item" type="button" @click="view_positions(department.positions, department.id)">View Positions</a>
                                                    <a class="dropdown-item" type="button" @click="edit_department_modal(department)">Edit Department</a>
                                                    <a class="dropdown-item" type="button" @click="delete_department(department.id)">Delete Department</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal -->

        <div class="modal fade" id="department_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ editMode == false ? 'Create Department' : 'Edit Department' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode == false ? submit_departments() : submit_edits_departments()" action="">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-6">
                                    <input v-model="dept_form.title" ref="title" class="form-control form-control-border border-width-2" type="text" name="title" placeholder="Title">
                                </div>
                                <div class="form-group col-6">
                                    <input v-model="dept_form.address" ref="address" class="form-control form-control-border border-width-2" type="text" name="address" placeholder="Address">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <input v-model="dept_form.description" ref="description" class="form-control form-control-border border-width-2" type="text" name="description" placeholder="Description">
                                </div>
                                <div class="form-group col-12">
                                    <input v-model="dept_form.projectactivity" ref="projectactivity" class="form-control form-control-border border-width-2" type="text" name="projectactivity" placeholder="Project Activity">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <input v-model="dept_form.function" ref="function" class="form-control form-control-border border-width-2" type="text" name="function" placeholder="Function">
                                </div>
                                <div class="form-group col-6">
                                    <input v-model="dept_form.fund" ref="fund" class="form-control form-control-border border-width-2" type="text" name="fund" placeholder="Fund">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary float-right" data-toggle="modal">Save <i class="fas fa-save"></i></button>
                    </div>
                </form>
                </div>
            </div>
        </div>

    <!-- modal end -->

    </div> <!-- row -->
</template>

<script>
    export default {
       data()
       {
           return {
               editMode: false,
               error: false,
               departments:{},
               filter_depts: {},
               search_depts: '',
               dept_id: '',
               dept_form: new Form({
                   'id': '',
                   'title': '',
                   'description': '',
                   'address': '',
                   'function': '',
                   'projectactivity': '',
                   'fund': '',
               }),
           }
       },
       methods: {
           filter_departments: function()
            {
                let data = this.filter_depts

                if (this.search_depts != null && this.search_depts != '') {
                    data = _.filter(data, {'id': this.search_depts});
                }

                this.departments.data = data
            },
           fetch_departments: function()
           {
                this.$Progress.start()
                return axios.get('api/fetch_depts')
                .then(({data}) => {
                    this.departments = data
                    this.filter_depts = data.data
                    this.$Progress.finish()
                })
                .catch(error => {
                    console.log(error)
                    Swal.fire(
                        'Oopss..',
                        'Unable to fetch Departments & Positions',
                        'error',
                    )
                    this.$Progress.fail()
                })
           },
            create_department_modal: function()
           {
               this.editMode = false
               this.dept_form.reset()
               $('#department_modal').modal('show')
           },
           submit_departments: function()
           {
                this.$Progress.start()
               axios.post('api/department', this.dept_form)
               .then(response => {
                    toast.fire({
                        icon: 'success',
                        title: 'Created'
                    });
                    this.fetch_departments()
                    $('#department_modal').modal('hide')
                    this.$Progress.finish()
               })
               .catch(error => {
                   console.log(error)
                    Swal.fire(
                        'Oopss..',
                        'Unable to create Department',
                        'error',
                    )
                    this.$Progress.fail()
               })
           },
           edit_department_modal: function(data)
           {
               Object.assign(this.dept_form, data)
               this.editMode = true
               $('#department_modal').modal('show')
           },
           submit_edits_departments: function()
           {
                this.$Progress.start()
               axios.patch('api/department/'+this.dept_form.id, this.dept_form)
               .then(response => {
                    toast.fire({
                        icon: 'success',
                        title: 'Edited'
                    });
                    this.fetch_departments()
                    $('#department_modal').modal('hide')
                    this.$Progress.finish()
               })
               .catch(error => {
                   console.log(error)
                    Swal.fire(
                        'Oopss..',
                        'Unable to edit Department',
                        'error',
                    )
                    this.$Progress.fail()
               })
           },
           delete_department: function(id)
           {
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
                        axios.delete('api/department/'+id)
                        .then(response => {
                            this.$Progress.finish()
                            toast.fire({
                                icon: 'success',
                                title: 'Deleted successfully'
                            });
                            this.fetch_departments()
                        })
                        .catch(error => {
                            console.log(error)
                            Swal.fire(
                                'Oops...',
                                'Unable to delete Department',
                                'error',
                            )
                            this.$Progress.fail()
                        })

                    }
                })
           },
           view_positions: function(data, id)
           {
               this.$router.push({path: '/positions', query: {dept_id: id}})
           }
       },
       created(){
           this.fetch_departments()
       },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
