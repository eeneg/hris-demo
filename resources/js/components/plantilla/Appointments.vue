<template>
    <div class="row justify-content-center">
      <div class="col-md-12 text-center" v-if="!$gate.isAdministrator() && !$gate.isAuthor()">
          <not-authorized></not-authorized>
      </div>
      <div v-else class="col-md-12">
          <div class="card card-primary card-outline">
              <div class="card-header">
                  <h3>Appointment Records</h3>
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
                      <div class="col-md-2">
                          <div class="form-group">
                              <label for="" class="p-0">Reckoning date from: </label>
                              <input type="date" name="reckoning_date_from" id="reckoning_date_from" class="form-control form-control-border border-width-2" v-model="reckoning_date_from" @change="searchAppointment">
                              <!-- <date-picker v-model="reckoning_date_from" id="reckoning_date_from" :config="options" class="form-control form-control-border border-width-2" @change="searchAppointment" placeholder="(yyyy-mm-dd)"></date-picker> -->
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="form-group">
                              <label for="" class="p-0">Reckoning date to: </label>
                              <input type="date" name="reckoning_date_to" id="reckoning_date_to" class="form-control form-control-border border-width-2" v-model="reckoning_date_to" @change="searchAppointment">
                              <!-- <date-picker v-model="reckoning_date_to" id="reckoning_date_to" :config="options" class="form-control form-control-border border-width-2" @change="searchAppointment" placeholder="(yyyy-mm-dd)"></date-picker> -->
                          </div>
                      </div>
                      <div class="col-md-2">
                          <button v-if="salaryschedules.length > 0 && departments.length > 0" class="btn btn-danger float-left mr-2 mb-3" type="button" @click="resetSearch()" data-toggle="modal">Reset <i class="fas fa-redo"></i></button>
                          <button v-if="salaryschedules.length > 0 && departments.length > 0" class="btn btn-success mr-2 mb-3" type="button" @click="print()" data-toggle="modal">Print <i class="fas fa-print"></i></button>
                      </div>
                      <div class="col-md-2">
                          <button v-if="salaryschedules.length > 0 && departments.length > 0" class="btn btn-primary float-right mb-3" type="button" @click="createAppointments()" data-toggle="modal">Create <i class="fas fa-plus"></i></button>
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
                                          <div v-if="salaryschedules.length > 0 && departments.length > 0" class="btn-group">
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
                              <v-select class="form-control form-control-border border-width-2" v-model="form.personal_information_id" :options="employees.data" label="name" :reduce="employees => employees.id"></v-select>
                              <span class="text-danger" v-if="errors.has('personal_information_id')">Employee not found</span>
                          </div>
                          <div class="col-md-6">
                              <label for="selectedDept">Department</label>
                              <select name="selectedDept" @change="removePosition()" class="custom-select form-control-border border-width-2" id="selectedDept" v-model="selectedDept">
                                  <option v-for="department in departments" :key="department.id" :value="department">{{ department.title }}</option>
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
                                  <option v-for="salaryschedule in salaryschedules" :key="salaryschedule.id" :value="salaryschedule">{{ salaryschedule.tranche }}</option>
                              </select>
                          </div>
                          <div class="col-md-3">
                              <label for="grade">Grade</label>
                              <select name="grade" class="custom-select form-control-border border-width-2" id="grade" v-model="form.grade">
                                  <option v-for="grade in salarygrades" :key="grade.id" :value="grade[0].grade">{{ grade[0].grade }}</option>
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
                              <!-- <input type="date" name="reckoning_date" class="form-control form-control-border border-width-2" v-model="form.reckoning_date" min="0"> -->
                              <date-picker v-model="form.reckoning_date" id="reckoning_date" :config="options" class="form-control form-control-border border-width-2" placeholder="(yyyy-mm-dd)"></date-picker>
                              <span class="text-danger" v-if="errors.has('reckoning_date')" v-text="errors.get('reckoning_date')"></span>
                          </div>
                          <div class="col-md-12">
                              <label for="previous_employee">Previous Employee</label>
                              <v-select class="form-control form-control-border border-width-2" v-model="form.previous_employee" :options="employees.data" label="name" :reduce="employees => employees.name"></v-select>
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
                      <button type="submit" class="btn btn-primary" :disabled="loading">Save <i class="fas fa-save"></i></button>
                  </div>
              </form>
              </div>
          </div>
      </div> <!-- modal -->

      <iframe src="" frameborder="0" id="i" hidden></iframe>

  </div> <!-- row -->
</template>
<script>
import Swal from 'sweetalert2';


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
          from: null,
          to: null,
          employees: [{}],
          search: null,
          reckoning_date_from: null,
          reckoning_date_to: null,
          departments: [],
          positions: [],
          salaryschedules: [],
          salarygrades: [],
          appointments: {personal_information:{}},
          selectedDept: [],
          loading:false,
          selectedSalarySched: [],
          errors: new Errors(),
          form: new Form({
              'personal_information_id': null,
              'position_id': null,
              'salary_sched_id': null,
              'grade': null,
              'step': null,
              'status': null,
              'agency': null,
              'nature_of_appointment': null,
              'previous_employee': null,
              'previous_status': null,
              'itemno':'',
              'page':'',
              'reckoning_date': null
          }),
          options: {
              format: 'yyyy-MM-DD',
              useCurrent: false,
          }
      }
  },
  components: {
      datePicker
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
      this.getDepartments()
      this.getSalarySched()

      this.debouncedgetDepartments = _.debounce(this.getPositions);
      this.debouncedgetSalaryScheds = _.debounce(this.getSalaryGrades);
  },
  methods: {
      searchAppointment: _.debounce(function(){
              this.getSearchResults();
      }, 600),

      removePosition: function(){
        this.form.position_id = null
      },

      print: function()
      {
          if(this.reckoning_date_from == null || this.reckoning_date_to == null)
          {
              Swal.fire(
                  'Oops...',
                  'Please input reckoning dates',
                  'error'
              )
          }else{

              Swal.fire({
              title: '<strong>Generating Appointment Records</strong>',
              html: 'Dont <u>reload</u> or <u>close</u> the application ...',
              icon: 'info',
              willOpen () {
                  Swal.showLoading ()
              },
              didClose () {
                  Swal.hideLoading()
              },
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  allowEnterKey: false,
                  showConfirmButton: false
              })

              axios.post('api/printAppointmentRecords', {data: this.appointments.data, from: this.reckoning_date_from, to: this.reckoning_date_to})
              .then(({data}) => {
                  var f = document.getElementById('i')
                  f.contentWindow.document.write(data)
                  setTimeout(function () {
                      f.contentWindow.focus()
                      f.contentWindow.print()

                      f.contentWindow.document.open();
                      f.contentWindow.document.write("");
                      f.contentWindow.document.close();
                  }, 500);
                    Swal.close()
              })
              .catch(e => {
                    Swal.close()
                    Swal.fire(
                        'Oops...',
                        'Something went wrong',
                        'error'
                    )
              })
          }
      },
      getPositions: function()
      {
          let vm = this
          this.positions = []

          _.each(this.selectedDept.positions, function(value){
              vm.positions.push(value)
          })
      },
      getSalaryGrades: function()
      {
          let ar = []
          this.salarygrades = []

          _.each(this.selectedSalarySched.salarygrades, function(value){
              ar.push(value)
          })

          this.salarygrades = _.groupBy(ar, 'grade')
      },
      getSearchResults: function(page = 1)
      {

          this.$Progress.start()

          Swal.fire({
              title: '<strong>Generating Appointment Records</strong>',
              html: 'Dont <u>reload</u> or <u>close</u> the application ...',
              icon: 'info',
              willOpen () {
                  Swal.showLoading ()
              },
              didClose () {
                  Swal.hideLoading()
              },
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  allowEnterKey: false,
                  showConfirmButton: false
          })

          let data = {
              page: page,
              search: this.search,
              from: this.reckoning_date_from,
              to: this.reckoning_date_to,
          }

          axios.get('api/appointment', {params: data})
          .then(({data}) => {
              this.appointments = data;
              this.$Progress.finish()
              Swal.close()
          }).catch(error => {
              console.log(error.reponse.data.message);
          });
      },
      getEmployees: function()
      {
          axios.get('api/employeeList')
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
          axios.get('api/fetchDepartments')
          .then(({data}) => {
              this.departments = data
          })
          .catch(error => {
              console.log(error)
              toast.fire({
                  icon: 'error',
                  title: 'Departments not retrieved'
              });
          })
      },
      getSalarySched: function()
      {
          axios.get('api/fetchSalarySched')
          .then(({data}) => {
              this.salaryschedules = data
          })
          .catch(error => {
              console.log(error)
              toast.fire({
                  icon: 'error',
                  title: 'Salary Schedules not retrieved'
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
              console.log(error)
              this.$Progress.fail();
              toast.fire({
                  icon: 'error',
                  title: 'Appointments not retrieved'
              });
          })
      },
      createAppointments: function()
      {
          this.form.reset()
          this.salarygrades = []
          this.selectedDept = []
          this.selectedSalarySched = []

          this.errors.deleteV()

          $('#appointmentsModal').modal('show')
          this.editMode = false
      },
      editAppointments: function(appointment)
      {
          this.form.reset()
          this.errors.deleteV()

          this.selectedDept = _.find(this.departments, {title: appointment.department.title})
          this.selectedSalarySched = _.find(this.salaryschedules, {tranche: appointment.salary_sched.tranche})

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
          if(this.selectedSalarySched)
          {
              this.form.salary_sched_id = this.selectedSalarySched.id
          }

          this.$Progress.start()
          this.loading = true
          axios.post('api/appointment', this.form)
          .then(({data}) => {
              $('#appointmentsModal').modal('hide')
              toast.fire({
                  icon: 'success',
                  title: 'Success'
              });
              this.getAppointments()
              this.$Progress.finish()
              this.loading = false
          })
          .catch(error => {
              this.errors.record(error.response.data.errors)
              this.$Progress.fail()
              this.loading = false
          })
      },
      updateAppointments: function()
      {
          this.$Progress.start()

          if(this.selectedSalarySched)
          {
              this.form.salary_sched_id = this.selectedSalarySched.id
          }

          this.loading = true
          axios.patch('api/appointment/'+this.form.id, this.form)
          .then(({data}) => {
              $('#appointmentsModal').modal('hide')
              toast.fire({
                  icon: 'success',
                  title: 'Saved'
              });
              this.getAppointments()
              this.$Progress.finish()
              this.loading = false
          })
          .catch(error =>{
              this.errors.record(error.response.data.errors)
              this.$Progress.fail()
              this.loading = false
          })
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
      resetSearch: function()
      {
          this.search = null
          this.reckoning_date_from = null
          this.reckoning_date_to = null
          this.getSearchResults()
      }
  },
}
</script>
