<template>
    <div class="row justify-content-center">
         <div class="col-md-12 text-center" v-if="!$gate.isAdministrator() && !$gate.isAuthor()">
             <not-authorized></not-authorized>
         </div>
         <div v-else class="col-md-12">
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
                                         <th style="width:5px">#</th>
                                         <th>Department</th>
                                         <th>Status</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <tr v-for="(department, index) in departments.data" :key="department.id">
                                         <td>
                                             {{ index+1 }}
                                         </td>
                                         <td>
                                             <div style="display: inline-block;vertical-align: middle;line-height: 1.2rem;height: 35px;">
                                                 <span style="font-size: 1rem;">{{ department.title }}</span>
                                                 <br>
                                                 <span style="font-size: 0.8rem;" class="text-muted"><i>{{ department.description }}</i></span>
                                             </div>
                                         </td>
                                         <td>
                                             <span v-if="department.status == 'active'" class="badge badge-success">Active</span>
                                             <span v-else class="badge badge-danger">Inactive</span>
                                         </td>
                                         <td style="width: calc(100%-150px);" v-if="$gate.isAdministrator()">
                                             <div class="btn-group">
                                                 <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                     Action
                                                 </button>
                                                 <div class="dropdown-menu">
                                                     <a class="dropdown-item" type="button" @click="view_positions(department.positions, department.id)">View Positions</a>
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
                                     <label for="title">Title</label>
                                     <input v-model="dept_form.title" ref="title" class="form-control form-control-border border-width-2" type="text" name="title" placeholder="Title">
                                     <span v-if="error.title" class="text-danger">{{ error.title[0] }}</span>
                                 </div>
                                 <div class="form-group col-6">
                                     <label for="address">Address</label>
                                     <input v-model="dept_form.address" ref="address" class="form-control form-control-border border-width-2" type="text" name="address" placeholder="Address">
                                     <span v-if="error.address" class="text-danger">{{ error.address[0] }}</span>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="form-group col-12">
                                     <label for="description">Description</label>
                                     <input v-model="dept_form.description" ref="description" class="form-control form-control-border border-width-2" type="text" name="description" placeholder="Description">
                                     <span v-if="error.description" class="text-danger">{{ error.description[0] }}</span>
                                 </div>
                                 <div class="form-group col-12">
                                     <label for="projectactivity">Project Activity</label>
                                     <input v-model="dept_form.projectactivity" ref="projectactivity" class="form-control form-control-border border-width-2" type="text" name="projectactivity" placeholder="Project Activity">
                                     <span v-if="error.projectactivity" class="text-danger">{{ error.projectactivity[0] }}</span>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="form-group col-6">
                                     <label for="function">Function</label>
                                     <input v-model="dept_form.function" ref="function" class="form-control form-control-border border-width-2" type="text" name="function" placeholder="Function">
                                     <span v-if="error.function" class="text-danger">{{ error.function[0] }}</span>
                                 </div>
                                 <div class="form-group col-6">
                                     <label for="fund">Fund</label>
                                     <input v-model="dept_form.fund" ref="fund" class="form-control form-control-border border-width-2" type="text" name="fund" placeholder="Fund">
                                     <span v-if="error.fund" class="text-danger">{{ error.fund[0] }}</span>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="form-group col-12">
                                     <label for="exampleFormControlSelect1">Status</label>
                                     <select class="form-control" v-model="dept_form.status" id="exampleFormControlSelect1" required>
                                         <option value="active">Active</option>
                                         <option value="inactive">Inactive</option>
                                     </select>
                                     <span v-if="error.status" class="text-danger">{{ error.status[0] }}</span>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         <button type="submit" class="btn btn-primary float-right" :disabled="loading" data-toggle="modal">Save <i class="fas fa-save"></i></button>
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
                loading: false,
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
                    'status': '',
                }),
                error: {}
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
                 this.error = {}
                 this.editMode = false
                 this.dept_form.reset()
                 $('#department_modal').modal('show')
            },
            submit_departments: function()
            {
                 this.loading = true
                 this.$Progress.start()
                 axios.post('api/department', this.dept_form)
                 .then(response => {
                     $('#department_modal').modal('hide')
                     toast.fire({
                         icon: 'success',
                         title: 'Created'
                     });
                     this.fetch_departments()
                     this.$Progress.finish()
                     this.loading = false
                 })
                 .catch(error => {
                         this.error = error.response.data.errors
                         Swal.fire(
                             'Oopss..',
                             'Unable to create Department',
                             'error',
                         )
                         this.$Progress.fail()
                         this.loading = false
                 })
            },
            edit_department_modal: function(data)
            {
                 this.error = {}
                 Object.assign(this.dept_form, data)
                 this.editMode = true
                 $('#department_modal').modal('show')
            },
            submit_edits_departments: function()
            {
                 this.loading = true
                 this.$Progress.start()
                axios.patch('api/department/'+this.dept_form.id, this.dept_form)
                .then(response => {
                    $('#department_modal').modal('hide')
                     toast.fire({
                         icon: 'success',
                         title: 'Edited'
                     });
                     this.fetch_departments()
                     this.$Progress.finish()
                     this.loading = false
                })
                .catch(error => {
                     console.log(error)
                     this.error = error.response.data.errors
                     Swal.fire(
                         'Oopss..',
                         'Unable to edit Department',
                         'error',
                     )
                     this.$Progress.fail()
                     this.loading = false
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
