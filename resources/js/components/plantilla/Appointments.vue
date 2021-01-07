<template>
      <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Appointment Records
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="custom-select">Department: </label>
                            <div class="btn-group">
                                <select class="custom-select" v-model="selected">
                                    <option v-for="department in departments" v-bind:value="department.title" :key="department.id"> {{ department.title }} </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" v-model="search">
                                <span class="input-group-text" id="basic-addon2"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Name</th>
                                        <th scope="col">Position</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Appointment Nature</th>
                                        <th scope="col">Reckoning Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center" v-for="(appointment, index) in filter" :key="appointment.id">
                                        <td>{{ appointment.surname }}, {{ appointment.firstname }} {{ appointment.nameextension }}</td>
                                        <td>{{ appointment.position.title }}</td>
                                        <td>{{ appointment.appointment.status }}</td>
                                        <td>{{ appointment.appointment.nature_of_appointment }}</td>
                                        <td>{{ appointment.appointment.reckoning_date }}</td>
                                        <td style="width: calc(100%-150px);" v-if="$gate.isAdministrator()">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" type="button" data-toggle="modal" @click="createAppointments(appointment)">Add Appointment</a>
                                                    <a class="dropdown-item" type="button" @click="editAppointments(appointment)">Edit Appointment</a>
                                                    <a class="dropdown-item" type="button" @click="deleteAppointment(appointment)">Delete Appointment</a>
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
        <div class="modal fade" id="appointmentsModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header kuz-header">
                    <h5 class="modal-title" id="modal-grade">Create Appointments</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="errors.deleteV()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode == false ? storeAppointments() : updateAppointments()" action="" id="pdsForm" @keydown="errors.clear($event.target.name)">
                    <div class="modal-body" style="padding: 2.5rem !important;">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="status">Status</label>
                                <input type="text" name="status" class="form-control kuz-control" v-model="form.status" equired>
                                <span class="text-danger" v-if="errors.has('status')" v-text="errors.get('status')"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="nature_of_appointment">Appointment Nature</label>
                                <input type="text" name="nature_of_appointment" class="form-control kuz-control" v-model="form.nature_of_appointment">
                                <span class="text-danger" v-if="errors.has('nature_of_appointment')" v-text="errors.get('nature_of_appointment')"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="reckoning_date">Reckoning Date</label>
                                <input type="date" name="reckoning_date" class="form-control kuz-control" v-model="form.reckoning_date" min="0">
                                <span class="text-danger" v-if="errors.has('reckoning_date')" v-text="errors.get('reckoning_date')"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer kuz-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" v-on:click="errors.deleteV()">Close</button>
                        <button type="submit" class="btn btn-success btn-sm">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div> <!-- modal -->

    </div> <!-- row -->
</template>
<script>

 class Errors
    {
        constructor()
        {
            this.errors = {};
        }

        get(field)
        {
            if(this.errors[field])
            {
                return this.errors[field][0];
            }
        }

        has(field)
        {
            return this.errors.hasOwnProperty(field);
        }

        record(errors)
        {
            this.errors = errors
        }

        clear(field)
        {
            delete this.errors[field]
        }

        deleteV()
        {
            return this.errors = new Errors()
        }
    }

export default {
    data()
    {
        return {
            editMode: false,
            search: '',
            selected: '',
            departments: '',
            appointments: [],
            tempData: {},
            errors: new Errors(),
            form: new Form({
                'personal_information_id': '',
                'position_id': '',
                'salary_grade_id': '',
                'status': '',
                'nature_of_appointment': '',
                'reckoning_date': ''
            }),
        }
    },
    watch:
    {
        selected: function()
        {
            this.debouncedgetAppointments();
        },
    },
    methods: {
        getDepartments: function()
        {
            this.$Progress.start()
            axios.get('api/department')
            .then(({data}) => {
                this.departments = data.data;
                this.selected = this.departments.title != null ? this.departments.title : this.departments[0].title
                this.$Progress.finish()
            })
            .catch(error => {
                console.log(error.response.data.message);
            });
        },
        getAppointments: function()
        {
            this.$Progress.start()
            axios.get('api/appointment?deptTitle='+this.selected)
            .then(({data}) => {
                this.appointments = data.data
                this.$Progress.finish()
            })
            .catch(this.$Progress.fail())
        },
        createAppointments: function(appointment)
        {
            this.form = {}
            if(appointment.appointment.id == "" || appointment.appointment.id == null)
            {
                this.editMode = false
                this.tempData = {personal_information_id: appointment.id, position_id: appointment.position.id, salary_grade_id: appointment.salary_grade_id}
                $('#appointmentsModal').modal('show')
            }else if(appointment.appointment.id != null){
                Swal.fire(
                    'Oops...',
                    'This employee already has an appointment',
                    'error'
                )
            }else if(appointment.salary_grade_id == "" || appointment.salary_grade_id == null){
                Swal.fire(
                    'Oops...',
                    'Missing salary grade ID',
                    'error'
                )
            }else if(appointment.position.id == "" || appointment.position.id == null){
                Swal.fire(
                    'Oops...',
                    'Missing position ID',
                    'error'
                )
            }
        },
        editAppointments: function(appointment)
        {
            this.form = {}
            if(appointment.appointment.id == "" || appointment.appointment.id == null)
            {
                Swal.fire(
                    'Oops...',
                    'Create an appointment first',
                    'error'
                )
            } else {
                this.editMode = true
                this.tempData = {personal_information_id: appointment.id, position_id: appointment.position.id, salary_grade_id: appointment.salary_grade_id}
                Object.assign(this.form, appointment.appointment)
                $('#appointmentsModal').modal('show')
            }
        },
        storeAppointments: function()
        {
            this.$Progress.start()
            axios.post('api/appointment',
                {
                    personal_information_id: this.tempData.personal_information_id,
                    position_id: this.tempData.position_id,
                    salary_grade_id: this.tempData.salary_grade_id,
                    status: this.form.status,
                    nature_of_appointment: this.form.nature_of_appointment,
                    reckoning_date: this.form.reckoning_date
                }
            )
            .then(({data}) => {
                toast.fire({
                    icon: 'success',
                    title: 'Saved'
                });
                this.tempData = {}
                this.getAppointments()
                this.$Progress.finish()
                $('#appointmentsModal').modal('hide')
            })
            .catch(error => this.errors.record(error.response.data.errors))
        },
        updateAppointments: function()
        {
            this.$Progress.start()
            axios.patch('api/appointment/'+this.form.id,
                {
                    personal_information_id: this.tempData.personal_information_id,
                    position_id: this.tempData.position_id,
                    salary_grade_id: this.tempData.salary_grade_id,
                    status: this.form.status,
                    nature_of_appointment: this.form.nature_of_appointment,
                    reckoning_date: this.form.reckoning_date
                }
            )
            .then(({data}) => {
                toast.fire({
                    icon: 'success',
                    title: 'Saved'
                });
                this.tempData = {}
                this.getAppointments()
                this.$Progress.finish()
                $('#appointmentsModal').modal('hide')
            })
            .catch(error => this.errors.record(error.response.data.errors))
        },
        deleteAppointment: function(appointment)
        {
            if(!appointment.appointment.id)
            {
                toast.fire({
                    icon: 'error',
                    title: 'No appointments to delete'
                });
            }else{
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
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
                            title: 'Data is safe'
                        });
                    }else{
                        this.$Progress.start()
                        axios.delete('api/appointment/'+appointment.appointment.id)
                        .then(response => {
                            toast.fire({
                                icon: 'success',
                                title: 'Deleted'
                            });
                            this.getAppointments()
                            this.$Progress.finish()
                        })
                        .catch(error => {
                            Swal.fire(
                                'Oops...',
                                'Something went wrong',
                                'error'
                            )
                        })
                    }
                })
            }
        },
    },
    computed: {
       filter: function () {
            var self = this;
            return this.appointments.filter(e => {
                return e.firstname.toLowerCase().indexOf(self.search.toLowerCase()) >= 0
                || e.surname.toLowerCase().indexOf(self.search.toLowerCase()) >= 0;
            });
        }
    },
    created: function() {
        this.$Progress.start()
        this.debouncedgetAppointments = _.debounce(this.getAppointments, 500);
        this.getDepartments()
    },

}
</script>
