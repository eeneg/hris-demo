<template>
    <div class="row justify-content-center">
         <div class="col-md-12 text-center" v-if="!$gate.isAdministrator() && !$gate.isAuthor()">
             <not-authorized></not-authorized>
         </div>
         <div v-else class="col-md-12">
             <div class="card card-primary card-outline">
                 <div class="card-header">
                     <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Positions: {{ dept_title }} <router-link to="/departments" style="float: right;"><i class="fas fa-arrow-left"></i></router-link></h2>
                 </div>

                 <div class="card-body">
                     <div class="row justify-content-between">
                         <div class="col-md-5">
                                 <div class="form-group" style="position: relative;margin-bottom: 0.3rem;">
                                     <v-select @input="filter_positions()" class="form-control form-control-border border-width-2" v-model="search_pos" :options="positions" label="title" placeholder="Search positions" :reduce="positions => positions.id"></v-select>
                                 </div>
                         </div>
                         <div class="col-md-5">
                                 <button type="button" class="btn btn-primary float-right" @click.prevent="create_position_modal()">
                                     Create <i class="fas fa-plus"></i>
                                 </button>
                         </div>
                     </div>
                     <div class="row">
                         <div class="table-responsive p-0" style="height: 500px; overflow :auto;">
                             <table class="table table-striped text-nowrap custom-table">
                                 <thead>
                                     <tr>
                                         <th style="width: 1%">#</th>
                                         <th style="width: 45%">Position</th>
                                         <th style="width: 45%">Number of Items</th>
                                         <th style="width: 10%">Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <tr v-for="(position, index) in positions" :key="position.id">
                                         <td>
                                             {{ index+1 }}
                                         </td>
                                         <td>
                                             {{ position.title }}
                                         </td><td>
                                             {{ position.count ?? 0 }}
                                         </td>
                                         <td style="width: calc(100%-150px);" v-if="$gate.isAdministrator()">
                                             <div class="btn-group">
                                                 <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                     Action
                                                 </button>
                                                 <div class="dropdown-menu">
                                                     <a class="dropdown-item" type="button" @click="edit_position_modal(position)">Edit Position</a>
                                                     <a class="dropdown-item" type="button" @click="delete_position(position.id)">Delete Position</a>
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


         <!-- modal start -->

         <div class="content-modal">
             <div class="modal hide fade" id="positions_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLabel">{{ editMode == false ? 'Create Position' : 'Edit Position' }}</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                         <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                     <form @submit.prevent="editMode == false ? submit_position() : submit_edit_position()" @keydown="form.onKeydown($event)">
                         <div class="modal-body">
                             <div class="col-md-12">
                                 <div class="row">
                                     <div class="form-group col-12">
                                         <input id="title" v-model="form.title" type="text" name="title" placeholder="Position Title"
                                             class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('title') }">
                                         <has-error :form="form" field="title"></has-error>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                             <button type="submit" class="btn btn-primary float-right" :disabled="loading" data-toggle="modal">Save <i class="fas fa-save"></i></button>
                         </div>
                     </form>
                     </div>
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
                loading: false,
                positions: [],
                filter_pos: [],
                dept_title: '',
                search_pos: '',
                dept_id: '',
                form: new Form({
                    'id': '',
                    'department_id': '',
                    'title': '',
                })
            }
        },
         beforeRouteEnter (to, from, next) {
             if(to.query.dept_id == null)
             {
                     next()
             }
             else if(to.query.dept_id != null){
                 Vue.prototype.$Progress.start()
                 axios.get('api/fetch_positions?id='+to.query.dept_id)
                 .then(({data}) => {
                     next(vm => vm.fetch_positions(data, to.query.dept_id))
                     Vue.prototype.$Progress.finish()
                 })
                 .catch(error => {
                     console.log(error)
                     Swal.fire(
                         'Oops...',
                         'Unable to retrieve positions',
                         'error'
                     )
                     Vue.prototype.$Progress.fail()
                 })
             }
         },
        methods: {
             filter_positions: function()
             {
                 let data = this.filter_pos

                 if (this.search_pos != null && this.search_pos != '') {
                     data = _.filter(data, {'id': this.search_pos});
                 }

                 this.positions = data
             },
             refresh_positions: function()
             {

                 this.$Progress.start()
                 axios.get('api/fetch_positions?id='+this.department_id)
                 .then(({data}) => {
                     this.positions = data
                     this.filter_pos = data
                     this.$Progress.finish()
                 })
                 .catch(error => {
                     console.log(error)
                     Swal.fire(
                         'Oops...',
                         'Unable to retrieve positions',
                         'error'
                     )
                 })

             },
            fetch_positions: function(data, id)
            {
                 this.positions = data
                 this.filter_pos = data
                 this.department_id = id
                 this.dept_title = data[0]?.department.title
            },
            create_position_modal: function(){
                this.editMode = false
                this.form.reset()
                this.form.clear()
                $('#positions_modal').modal('show')
            },
            submit_position: function(){
                 this.loading = true
                 this.$Progress.start()
                 this.form.department_id = this.department_id
                 this.form.post('api/store_position', this.form)
                 .then(response => {
                     $('#positions_modal').modal('hide')
                     toast.fire({
                         icon: 'success',
                         title: 'Created'
                     });
                     this.refresh_positions()
                     this.$Progress.finish()
                     this.loading = false
                 })
                     .catch(error => {
                         this.$Progress.fail();
                         this.loading = false
                         console.log(error)
                     })
            },
            edit_position_modal: function(data){
                this.editMode = true
                Object.assign(this.form, data)
                this.form.clear()
                $('#positions_modal').modal('show')
            },
            submit_edit_position: function()
            {
                 this.loading = true
                 this.$Progress.start()
                 this.form.patch('api/update_position/'+this.form.id, this.form)
                 .then(response => {
                     $('#positions_modal').modal('hide')
                     toast.fire({
                         icon: 'success',
                         title: 'Edited'
                     });
                     this.refresh_positions()
                     this.$Progress.finish()
                     this.loading = false
                 })
                 .catch(error => {
                     this.$Progress.fail();
                     console.log(error)
                     this.loading = false
                 })
            },
            delete_position: function(id)
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
                         axios.delete('api/delete_position/'+id)
                         .then(response => {
                             this.$Progress.finish()
                             toast.fire({
                                 icon: 'success',
                                 title: 'Deleted successfully'
                             });
                             this.refresh_positions()
                         })
                         .catch(error => {
                             this.$Progress.fail();
                             Swal.fire(
                                 'Oops...',
                                 'Failed to delete position',
                                 'error'
                             )
                             console.log(error)
                         })

                     }
                 })

            }
        },
        created(){

        },
         mounted() {
             console.log('Component mounted.')
         }
     }
 </script>
