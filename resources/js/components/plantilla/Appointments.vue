<template>
      <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Appointment Records
                </div>

                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search" v-model="search" @keyup.prevent="searchAppointment">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fas fa-search"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="p-0">Reckoning date from: </label>
                                <input type="date" name="reckoning_date_from" id="reckoning_date_from" class="form-control form-control-border border-width-2" v-model="reckoning_date_from" @change="searchAppointment">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="p-0">Reckoning date to: </label>
                                <input type="date" name="reckoning_date_to" id="reckoning_date_to" class="form-control form-control-border border-width-2" v-model="reckoning_date_to" @change="searchAppointment">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button class="btn btn-primary float-right mb-3" type="button" @click="createAppointments()" data-toggle="modal">Create <i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Appointment Nature</th>
                                        <th scope="col">Reckoning Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center" v-for="(appointment, index) in appointments.data" :key="appointment.id">
                                        <td>{{ appointment.personal_information.surname }}, {{ appointment.personal_information.firstname }} {{ appointment.personal_information.nameextension }}</td>
                                        <td>{{ appointment.status }}</td>
                                        <td>{{ appointment.nature_of_appointment }}</td>
                                        <td>{{ appointment.reckoning_date }}</td>
                                        <td style="width: calc(100%-150px);" v-if="$gate.isAdministrator()">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu">
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
                <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <pagination size="default" :data="appointments" @pagination-change-page="getSearchResults" :limit="5">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                    <span style="margin-left: 10px;">Page {{ appointments.meta && appointments.meta.current_page }} of {{ appointments.meta && appointments.meta.last_page }}</span>
                </div>
            </div>
        </div>

          <!-- modal -->
        <div class="modal fade" id="appointmentsModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header modal-border">
                    <h5 class="modal-title" id="modal-grade">Create Appointments</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="errors.deleteV()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode == false ? storeAppointments() : updateAppointments()" action="" id="pdsForm" @keydown="errors.clear($event.target.name)">
                    <div class="modal-body pb-0 pt-0">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="firstname">First Name</label>
                                <v-select v-model="form.personal_information_id" :options="employees.data" label="name" :reduce="employees => employees.id" class="form-control-border border-width-2"></v-select>
                                <span class="text-danger" v-if="errors.has('personal_information_id')">Employee not found</span>
                            </div>
                            <div class="col-md-6">
                                <label for="selectedDept">Department</label>
                                <select name="selectedDept" class="custom-select form-control-border border-width-2" id="selectedDept" v-model="selectedDept">
                                    <option v-for="department in departments" :key="department.id" :value="department.id">{{ department.title }}</option>
                                </select>
                            </div>
                             <div class="col-md-6">
                                <label for="position_id">Position</label>
                                <select name="position_id" class="custom-select form-control-border border-width-2" id="position_id" v-model="form.position_id">
                                    <option v-for="position in positions" :key="position.id" :value="position.id">{{ position.title }}</option>
                                </select>
                            </div>
                            <div class="col-md-12 text-center">
                                <span class="text-danger" v-if="errors.has('position_id')">Missing Department/Position</span>
                            </div>
                            <div class="col-md-6">
                                <label for="selectedSalarySched">Salary Schedule</label>
                                <select name="selectedSalarySched" class="custom-select form-control-border border-width-2" id="selectedSalarySched" v-model="selectedSalarySched">
                                    <option v-for="salaryschedule in salaryschedules" :key="salaryschedule.id" :value="salaryschedule.id">{{ salaryschedule.tranche }}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="grade">Grade</label>
                                <select name="grade" class="custom-select form-control-border border-width-2" id="grade" v-model="form.grade">
                                    <option v-for="grade in salarygrades" :key="grade.id">{{ grade.grade }}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="step">Step</label>
                                <select name="step" class="custom-select form-control-border border-width-2" id="step" v-model="form.step">
                                    <option v-for="step in 8" :key="step.id">{{ step }}</option>
                                </select>
                            </div>
                            <div class="col-md-12 text-center">
                                <span class="text-danger" v-if="errors.has('salary_sched_id')">Missing Salary Schedule</span>
                            </div>
                            <div class="col-md-12 text-center">
                                <span class="text-danger" v-if="errors.has('salary_grade_id')">Missing Salary Grade</span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control form-control-border border-width-2" v-model="form.status">
                                    <option>Permanent</option>
                                    <option>Co-terminus</option>
                                    <option>Elected</option>
                                </select>
                                <span class="text-danger" v-if="errors.has('status')" v-text="errors.get('status')"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="agency">Agency</label>
                                <input type="text" name="agency" class="form-control form-control-border border-width-2" v-model="form.agency">
                                <span class="text-danger" v-if="errors.has('agency')" v-text="errors.get('agency')"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nature_of_appointment">Nature of Appointment</label>
                                 <select name="nature_of_appointment" id="nature_of_appointment" class="form-control form-control-border border-width-2" v-model="form.nature_of_appointment">
                                    <option>Original</option>
                                    <option>Promotion</option>
                                </select>
                                <span class="text-danger" v-if="errors.has('nature_of_appointment')" v-text="errors.get('nature_of_appointment')"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="reckoning_date">Reckoning Date</label>
                                <input type="date" name="reckoning_date" class="form-control form-control-border border-width-2" v-model="form.reckoning_date" min="0">
                                <span class="text-danger" v-if="errors.has('reckoning_date')" v-text="errors.get('reckoning_date')"></span>
                            </div>
                            <div class="col-md-12">
                                <label for="previous_employee">Previous Employee</label>
                                <v-select v-model="form.previous_employee" :options="employees.data" label="name" :reduce="employees => employees.name"></v-select>
                                <span class="text-danger" v-if="errors.has('previous_employee')" v-text="errors.get('previous_employee')"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="previous_status">Previous Employee Status</label>
                                <input type="text" name="previous_status" class="form-control form-control-border border-width-2" v-model="form.previous_status">
                                <span class="text-danger" v-if="errors.has('previous_status')" v-text="errors.get('previous_status')"></span>
                            </div>
                            <div class="col-md-3">
                                <label for="itemno">Item No.</label>
                                <input type="number" name="itemno" class="form-control form-control-border border-width-2" v-model="form.itemno">
                                <span class="text-danger" v-if="errors.has('itemno')">The item number field is required.</span>
                            </div>
                            <div class="col-md-3">
                                <label for="page">Page</label>
                                <input type="number" name="page" class="form-control form-control-border border-width-2" v-model="form.page">
                                <span class="text-danger" v-if="errors.has('page')" v-text="errors.get('page')"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-border">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" v-on:click="errors.deleteV()">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
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
            from: '',
            to: '',
            employees: [{}],
            search: '',
            reckoning_date_from: '',
            reckoning_date_to: '',
            departments: [{}],
            positions: [{}],
            salaryschedules: [{}],
            salarygrades: [],
            appointments: {personal_information:{}},
            selectedDept: '',
            selectedSalarySched: '',
            errors: new Errors(),
            form: new Form({
                'personal_information_id': '',
                'position_id': '',
                'salary_sched_id': '',
                'grade': '',
                'step': '',
                'status': '',
                'agency': '',
                'nature_of_appointment': '',
                'previous_employee': '',
                'previous_status': '',
                'itemno':'',
                'page':'',
                'reckoning_date': ''
            }),
        }
    },
    watch:
    {
        selectedDept: function()
        {
            this.debouncedgetDepartments();
        },
        selectedSalarySched: function()
        {
            this.debouncedgetSalaryScheds();
        }
    },
     created: function() {

        this.$Progress.start()
        this.getAppointments()
        this.getEmployees()

        this.debouncedgetDepartments = _.debounce(this.getDepartments);
        this.debouncedgetSalaryScheds = _.debounce(this.getSalarySched);
    },
    methods: {
        searchAppointment: _.debounce(function(){
                this.getSearchResults();
        }, 400),
        getSearchResults: function(page = 1)
        {
            axios.get('api/appointment?page=' + page + '&search=' + this.search + '&from=' + this.reckoning_date_from + '&to=' + this.reckoning_date_to)
            .then(({data}) => {
                this.appointments = data;
            }).catch(error => {
                console.log(error.reponse.data.message);
            });
        },
        getEmployees: function()
        {
            axios.get('api/appointmentemployeelist')
            .then(({data})=> {
               this.employees = data
            })
            .catch(error => {
                console.log(error)
                toast.fire({
                    icon: 'error',
                    title: 'Employee data not retrieved'
                });
            })
        },
        getDepartments: function()
        {
            axios.get('api/department')
            .then(({data}) => {
                this.departments = data.data

                if(this.selectedDept.length != 0)
                {
                    this.getPositions()
                }
            })
            .catch(error => {
                console.log(error)
                toast.fire({
                    icon: 'error',
                    title: 'Departments not retrieved'
                });
            })
        },
        getPositions: function()
        {
            this.$Progress.start()
            axios.get('api/fetchPosition?deptId='+this.selectedDept)
            .then(({data})=> {
                this.positions = data

                this.$Progress.finish()
            })
            .catch(error => {
                console.log(error)
                toast.fire({
                    icon: 'error',
                    title: 'Positions not retrieved'
                });
            })
        },
        getSalarySched: function()
        {
            axios.get('api/salaryschedule')
            .then(({data}) => {
                this.salaryschedules = data

                if(this.selectedSalarySched.length != 0)
                {
                    this.getSalaryGrade()
                }
            })
            .catch(error => {
                console.log(error)
                toast.fire({
                    icon: 'error',
                    title: 'Salary Schedules not retrieved'
                });
            })
        },
        getSalaryGrade: function()
        {
            this.$Progress.start()
            axios.get('api/salarygrade?id='+ this.selectedSalarySched)
            .then(({data}) => {
                let ar = _.chunk(data, 8)

                _.each(ar, e => {
                    if(e[0].grade)
                    {
                        this.salarygrades.push({grade: e[0].grade})
                    }
                })

                this.$Progress.finish()
            })
            .catch(error => {
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Salary Grades not retrieved'
                });
            })
        },
        getAppointments: function()
        {
            this.$Progress.start()
            axios.get('api/appointment')
            .then(({data}) => {
                this.appointments = data

                this.$Progress.finish()
            })
            .catch(error => {
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Appointments not retrieved'
                });
            })
        },
        createAppointments: function(appointment)
        {
            this.form.reset()
            this.salarygrades = []
            this.selectedDept = ''
            this.selectedSalarySched = ''

            this.getDepartments()
            this.getSalarySched()

            this.errors.deleteV()

            $('#appointmentsModal').modal('show')
            this.editMode = false
        },
        editAppointments: function(appointment)
        {
            this.form.reset()
            this.errors.deleteV()

            this.selectedDept = appointment.department.id
            this.selectedSalarySched = appointment.salary_sched.id

            this.form.id                        = appointment.id
            this.form.personal_information_id   = appointment.personal_information.id
            this.form.position_id               = appointment.position.id
            this.form.salary_sched_id           = appointment.salary_sched.id
            this.form.grade                     = appointment.salary_grade.grade
            this.form.step                      = appointment.salary_grade.step
            this.form.status                    = appointment.status
            this.form.agency                    = appointment.agency
            this.form.nature_of_appointment     = appointment.nature_of_appointment
            this.form.previous_employee         = appointment.previous_employee
            this.form.previous_status           = appointment.previous_status
            this.form.itemno                    = appointment.itemno
            this.form.page                      = appointment.page
            this.form.reckoning_date            = appointment.reckoning_date

            this.editMode = true
            $('#appointmentsModal').modal('show')
        },
        storeAppointments: function()
        {
            if(this.selectedSalarySched != '' || this.selectedSalarySched)
            {
                this.form.salary_sched_id = this.selectedSalarySched
            }
            this.$Progress.start()
            axios.post('api/appointment', this.form)
            .then(({data}) => {
                toast.fire({
                    icon: 'success',
                    title: 'Saved'
                });
                this.getAppointments()
                this.$Progress.finish()
                $('#appointmentsModal').modal('hide')
            })
            .catch(error => this.errors.record(error.response.data.errors))
        },
        updateAppointments: function()
        {
            this.$Progress.start()

            axios.patch('api/appointment/'+this.form.id, this.form)
            .then(({data}) => {
                toast.fire({
                    icon: 'success',
                    title: 'Saved'
                });
                this.getAppointments()
                this.$Progress.finish()
                $('#appointmentsModal').modal('hide')
            })
            .catch(error => this.errors.record(error.response.data.errors))
        },
        deleteAppointment: function(appointment)
        {
            if(!appointment.id)
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
                        axios.delete('api/appointment/'+appointment.id)
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
                            console.log(error)
                        })
                    }
                })
            }
        },
    },
}
</script>
