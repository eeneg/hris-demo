<template>
      <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3>Employee Reassignments</h3>
                </div>

                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-md-4">
                            <div class="form-group" style="position: relative;margin-bottom: 0.3rem;">
                                <v-select @input="filter_reappointments()" class="form-control form-control-border border-width-2" v-model="search" :options="employees.data" label="name" placeholder="Search employee" :reduce="employees => employees.id"></v-select>
                                <has-error :form="form" field="personal_information_id"></has-error>
                            </div>
                        </div>
                       <div class="col-md-8">
                           <button type="button" class="btn btn-primary float-right" @click.prevent="reappointment_modal()">
                                Reappoint <i class="fas fa-plus"></i>
                            </button>
                       </div>
                    </div>
                    <div class="row">
                        <div class="card-body table-responsive p-0" style="height: 600px;">
                            <table class="table table-striped text-nowrap custom-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Assigned from</th>
                                        <th>Reassigned to</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(reappointment, index) in reappointments.data" :key="reappointment.id">
                                        <td>{{ reappointment.name }}</td>
                                        <td>{{ reappointment.dept_from }}</td>
                                        <td>{{ reappointment.dept_to }}</td>
                                        <td>{{ reappointment.date }}</td>
                                        <td style="width: calc(100%-150px);" v-if="$gate.isAdministrator()">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" type="button" @click="edit_reappointments(reappointment)">Edit Appointment</a>
                                                    <a class="dropdown-item" type="button" @click="delete_reappointment(reappointment.id)">Delete Appointment</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <pagination size="default" :data="reappointments" @pagination-change-page="get_search_esults" :limit="5">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                    <span style="margin-left: 10px;">Page {{ reappointments.meta && reappointments.meta.current_page }} of {{ reappointments.meta && reappointments.meta.last_page }}</span>
                </div>
            </div>
        </div>


        <!-- modal -->

        <div class="modal fade" id="reappointment_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reappoint</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode == false ? submit_reappointments() : submit_edits_reappointments()" action="">
                    <div class="modal-body">
                        <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-12" style="position: relative;margin-bottom: 0.3rem;">
                                        <v-select class="form-control form-control-border border-width-2" v-model="form.personal_information_id" :options="employees.data" label="name" placeholder="Reappoint employee" :reduce="employees => employees.id"></v-select>
                                        <has-error :form="form" field="personal_information_id"></has-error>
                                    </div>
                                    <div class="form-group col-12 mt-5">
                                        <v-select class="form-control form-control-border border-width-2" v-model="form.assigned_to" :options="departments.data" label="title" placeholder="Reappoint to" :reduce="departments => departments.id"></v-select>
                                        <has-error :form="form" field="assigned_to"></has-error>
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
            search: '',
            reappointments: {},
            reappointment_id: '',
            employees: [{}],
            departments: [{}],
            filter: {},
            form: new Form({
                'personal_information_id': '',
                'assigned_from': '',
                'assigned_to': '',
                'date': moment(new Date()).format("YYYY-MM-DD")
            })
        }
    },

    created: function() {
        this.fetch_reappointments()
    },
    methods: {
        filter_reappointments: function()
        {
            let data = this.filter

            if (this.search != null && this.search != '') {
                 data = _.filter(data, {'personal_information_id': this.personal_information_id});
            }

            this.reappointments.data = data
        },
        fetch_reappointments: function()
        {

            axios.get('api/reappointments')
            .then(({data}) => {
                this.reappointments = data
                this.filter = data.data
            })
            .catch(error => {
                console.log(error)
            })

            axios.get('api/department')
            .then(({data}) => {
                this.departments = data
            })
            .catch(error => {
                console.log(error)
            })

            axios.get('api/employeeList')
            .then(({data}) => {
                this.employees = data
            })
            .catch(error => {
                console.log(error)
            })

        },
        get_search_esults: function(page = 1)
        {
            axios.get('api/reappointments?page=' + page + '&search=' + this.search)
            .then(({data}) => {
                this.reappointments = data;
            }).catch(error => {
                console.log(error.reponse.data.message);
                Swal.fire(
                    'Oops...',
                    'Something went wrong',
                    'error'
                )
            });
        },
        reappointment_modal: function()
        {
            this.form.reset()
            this.editMode = false
            $('#reappointment_modal').modal('show')
        },
        edit_reappointments: function(reappointment)
        {
            this.form.reset()
            this.form.fill(reappointment)
            this.reappointment_id = reappointment.id
            this.editMode = true
            $('#reappointment_modal').modal('show')
        },
        submit_reappointments: function()
        {
            if(this.form.personal_information_id == null || this.form.personal_information_id == '' && this.form.assigned_to == null || this.form.assigned_to == '')
            {
                toast.fire({
                    icon: 'error',
                    title: 'Missing inputs on fields'
                });
            }else{
                this.$Progress.start()
                axios.post('api/reappointments', this.form)
                .then(({data}) => {
                    toast.fire({
                        icon: 'success',
                        title: 'Submitted'
                    });
                    this.fetch_reappointments()
                    this.$Progress.finish()
                    $('#reappointment_modal').modal('hide')
                }).catch(error => {
                    console.log(error.reponse.data.message);
                    Swal.fire(
                        'Oops...',
                        'Something went wrong',
                        'error'
                    )
                    this.$Progress.fail()
                });
            }
        },
        submit_edits_reappointments: function()
        {
            this.$Progress.start()
            axios.patch('api/reappointments/'+this.reappointment_id, this.form)
            .then(({data}) => {
                toast.fire({
                    icon: 'success',
                    title: 'Submitted'
                });
                this.editMode = false
                this.fetch_reappointments()
                this.$Progress.finish()
                $('#reappointment_modal').modal('hide')
            }).catch(error => {
                console.log(error.reponse.data.message);
                Swal.fire(
                    'Oops...',
                    'Something went wrong',
                    'error'
                )
                this.$Progress.fail()
            });
        },
        delete_reappointment: function(id)
        {
            Swal.fire({
            title: 'Ooops...',
            text: "You cannot revert this!!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Proceed'
                }).then((result) => {
                if(result.isDismissed == true)
                {
                    toast.fire({
                        icon: 'success',
                        title: 'Cancelled'
                    });
                }else{
                    this.$Progress.start()
                    axios.delete('api/reappointments/'+id)
                    .then(response => {
                        toast.fire({
                            icon: 'success',
                            title: 'Deleted'
                        });
                        this.$Progress.finish()
                        this.fetch_reappointments()
                    }).catch(error => {
                        console.log(error.reponse.data.message);
                        Swal.fire(
                            'Oops...',
                            'Something went wrong, unable to delete',
                            'error'
                        )
                    });
                }
            })
        }
    },
}
</script>
