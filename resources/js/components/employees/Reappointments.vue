<template>
    <div class="row justify-content-center">
      <div class="col-md-12 text-center" v-if="!$gate.isAdministrator() && !$gate.isAuthor()">
          <not-authorized></not-authorized>
      </div>
      <div v-else class="col-md-12">
          <div class="card card-primary card-outline">
              <div class="card-header">
                  <h3>Employee Reassignments</h3>
              </div>

              <div class="card-body">
                  <div class="row">
                      <div class="col-md-4">
                          <div class="input-group mb-3">
                              <input type="text" name="search" id="search" class="form-control" placeholder="Search" v-model="searchForm.search" @keyup.prevent="searchReappointments()">
                              <div class="input-group-append">
                                  <div class="input-group-text"><i class="fas fa-search"></i></div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-3">
                        <button type="button" class="btn btn-secondary" @click="openAdvancedSearchModal" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-filter"></i>
                        </button>
                        <button class="btn d-inline btn-primary" @click="print"><i class="fas fa-print"></i></button>
                      </div>
                      <div class="col-md-5">
                          <button type="button" class="btn btn-primary float-right mb-3" @click.prevent="reappointment_modal()">
                                  Reassign <i class="fas fa-plus"></i>
                          </button>
                      </div>
                  </div>
                  <div class="row">
                      <div class="card-body table-responsive p-0" style="height: 600px;">
                          <table class="table table-striped text-nowrap custom-table">
                              <thead>
                                  <tr>
                                      <th>Name</th>
                                      <th class="text-center">Reassigned to</th>
                                      <th class="text-center">Effectivity Date</th>
                                      <th class="text-center">Termination Date</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr v-for="(reappointment, index) in reappointments.data" :key="reappointment.id">
                                      <td>
                                        <div class="row p-0">
                                            <div class="col-md-12">
                                                {{ reappointment.name }}
                                            </div>
                                            <div class="col-md-12 text-gray">
                                                {{ reappointment.position }}
                                            </div>
                                            <div class="col-md-12 text-gray">
                                                <small><i>{{ reappointment.dept_from }}</i></small>
                                            </div>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="row p-0 text-center">
                                            <div class="col-md-12">
                                                {{ reappointment.dept_to }}
                                            </div>
                                            <div class="col-md-12 text-gray">
                                                {{ reappointment.type }}
                                            </div>
                                        </div>
                                      </td>
                                      <td class="text-center">{{ reappointment.effectivity_date }}</td>
                                      <td>
                                            <span
                                                :class="
                                                    {
                                                        'badge badge-warning ' : checkDate(reappointment.termination_date) < 30,
                                                        'badge badge-danger' : checkDate(reappointment.termination_date) < 0,
                                                    }
                                                "
                                                style="font-size: 0.9rem;"
                                            >
                                                {{ reappointment.termination_date }}
                                            </span>
                                      </td>
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
                  <pagination size="default" :data="reappointments" @pagination-change-page="get_search_results" :limit="5">
                      <span slot="prev-nav">&lt; Previous</span>
                      <span slot="next-nav">Next &gt;</span>
                  </pagination>
                  <span style="margin-left: 10px;">Page {{ reappointments.meta && reappointments.meta.current_page }} of {{ reappointments.meta && reappointments.meta.last_page }}</span>
              </div>
          </div>
      </div>


      <!-- modal -->

      <div class="modal fade" id="reappointment_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Reassign</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form @submit.prevent="editMode == false ? submit_reappointments() : submit_edits_reappointments()" action="">
                  <div class="modal-body">
                      <div class="col-md-12">
                              <div class="row">
                                  <div class="form-group col-12" style="position: relative;margin-bottom: 0.3rem;">
                                      <label for="date">Employee</label>
                                      <v-select class="form-control form-control-border border-width-2" @input="getEmployeePosition" :class="{ 'is-invalid': form.errors.has('personal_information_id') }" v-model="form.personal_information_id" :options="employees.data" label="name" placeholder="Reassign employee" :reduce="employees => employees.id"></v-select>
                                      <has-error :form="form" field="personal_information_id"></has-error>
                                  </div>
                                  <div class="form-group col-12">
                                    <label for="position">
                                        Position
                                        <div class="spinner-border spinner-border-sm ml-1" role="status" v-if="loading_position">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </label>
                                      <input class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('position') }" :disabled="loading_position" type="text" v-model="form.position" name="position">
                                      <has-error :form="form" field="position"></has-error>
                                  </div>
                                  <div class="form-group col-12">
                                      <label for="assigned_to">Reassign To</label>
                                      <v-select class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('assigned_to') }" v-model="form.assigned_to" :options="departments.data" label="title" placeholder="Reassign to" :reduce="departments => departments.id"></v-select>
                                      <has-error :form="form" field="assigned_to"></has-error>
                                  </div>
                                  <div class="form-group col-6">
                                      <label for="effectivity_date">Effectivity Date</label>
                                      <input class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('effectivity_date') }" type="date" v-model="form.effectivity_date" name="effectivity_date">
                                      <has-error :form="form" field="effectivity_date"></has-error>
                                  </div>
                                  <div class="form-group col-6">
                                      <label for="termination_date">Termination Date</label>
                                      <input class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('termination_date') }" type="date" v-model="form.termination_date" name="termination_date">
                                      <has-error :form="form" field="termination_date"></has-error>
                                  </div>
                                  <div class="form-group col-12">
                                      <label for="type">Type</label>
                                      <select name="type" id="type" class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('type') }" v-model="form.type">
                                        <option value="Reassigned">Reassigned</option>
                                        <option value="Designated">Designated</option>
                                        <option value="Detail">Detail</option>
                                      </select>
                                      <has-error :form="form" field="type"></has-error>
                                  </div>
                                  <div class="form-group col-12">
                                      <label for="duties">Duties</label>
                                      <textarea class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('duties') }" v-model="form.duties" name="original_appointment"></textarea>
                                      <has-error :form="form" field="duties"></has-error>
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

      <!-- modal -->

      <div class="modal fade" id="advancedSearchModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="advancedSearchModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="advancedSearchModalLabel">Advanced Search</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form @submit.prevent="getResults" action="">
                  <div class="modal-body">
                      <div class="col-md-12">
                              <div class="row">
                                  <div class="form-group col-12">
                                      <label for="assigned_to">Reassign From</label>
                                      <v-select class="form-control form-control-border border-width-2" :class="{ 'is-invalid': searchForm.errors.has('assigned_to') }" v-model="searchForm.assigned_from" :options="departments.data" label="title" placeholder="select employee" :reduce="departments => departments.id"></v-select>
                                      <has-error :form="searchForm" field="assigned_to"></has-error>
                                  </div>
                                  <div class="form-group col-12">
                                      <label for="assigned_to">Reassign To</label>
                                      <v-select class="form-control form-control-border border-width-2" :class="{ 'is-invalid': searchForm.errors.has('assigned_to') }" v-model="searchForm.assigned_to" :options="departments.data" label="title" placeholder="select employee" :reduce="departments => departments.id"></v-select>
                                      <has-error :form="searchForm" field="assigned_to"></has-error>
                                  </div>
                                  <div class="form-group col-6">
                                      <label for="effectivity_date">Effectivity Date</label>
                                      <input class="form-control form-control-border border-width-2" :class="{ 'is-invalid': searchForm.errors.has('effectivity_date') }" type="date" v-model="searchForm.effectivity_date" name="effectivity_date">
                                      <has-error :form="searchForm" field="effectivity_date"></has-error>
                                  </div>
                                  <div class="form-group col-6">
                                      <label for="termination_date">Termination Date</label>
                                      <input class="form-control form-control-border border-width-2" :class="{ 'is-invalid': searchForm.errors.has('termination_date') }" type="date" v-model="searchForm.termination_date" name="termination_date">
                                      <has-error :form="searchForm" field="termination_date"></has-error>
                                  </div>
                                  <div class="form-group col-4">
                                      <label for="type">Type</label>
                                      <select name="type" id="type" class="form-control form-control-border border-width-2" :class="{ 'is-invalid': searchForm.errors.has('type') }" v-model="searchForm.type">
                                        <option value="Reassigned">Reassigned</option>
                                        <option value="Designated">Designated</option>
                                        <option value="Detail">Detail</option>
                                      </select>
                                      <has-error :form="searchForm" field="type"></has-error>
                                  </div>
                                  <div class="form.group col-4">
                                    <label for="sort">Sort By</label>
                                    <select name="type" id="type" class="form-control form-control-border border-width-2" :class="{ 'is-invalid': searchForm.errors.has('sort') }" v-model="searchForm.sort">
                                        <option value="termination_date" selected>Termination date</option>
                                        <option value="effectivity_date">Effectivity Date</option>
                                      </select>
                                  </div>
                                  <div class="form.group col-4">
                                    <label for="sort">Ascending/Descending</label>
                                    <select name="type" id="type" class="form-control form-control-border border-width-2" :class="{ 'is-invalid': searchForm.errors.has('sort_type') }" v-model="searchForm.sort_type">
                                        <option value="asc" selected>Ascending</option>
                                        <option value="desc">Descending</option>
                                      </select>
                                  </div>
                              </div>
                      </div>
                    </div>
                  <div class="modal-footer">
                      <button type="button" class="float-left btn btn-danger" @click="clearSearchForm">Clear <i class="fas fa-eraser"></i></button>
                      <button type="submit" class="btn btn-primary float-right" :disabled="loading" data-toggle="modal">Search <i class="fas fa-search"></i></button>
                  </div>
              </form>
              </div>
          </div>
      </div>

      <!-- modal end -->

      <iframe src="" frameborder="0" id="print" hidden></iframe>

  </div> <!-- row -->
</template>
<script>
import Swal from 'sweetalert2';
import moment from 'moment';


export default {
  data()
  {
      return {
          editMode: false,
          reappointments: {},
          reappointment_id: null,
          employees: [{}],
          departments: [{}],
          filter: {},
          loading: false,
          loading_position: false,
          form: new Form({
              'personal_information_id': null,
              'assigned_from': null,
              'assigned_to': null,
              'position': null,
              'effectivity_date': null,
              'termination_date': null,
              'type': null,
              'duties': null,
          }),
          searchForm: new Form({
              'search': '',
              'assigned_to': '',
              'assigned_from': '',
              'effectivity_date': '',
              'termination_date': '',
              'type': '',
              'sort': '',
              'sort_type': '',
          })
      }
  },

  created: function() {
      this.fetch_reappointments()
  },
  methods: {

      searchReappointments:  _.debounce(function(){
          this.getResults();
      }, 600),

    checkDate: function(date) {
        const now = moment();
        const target = moment(date);
        const daysDiff = target.diff(now, 'days');

        return daysDiff
    },

      openAdvancedSearchModal() {
        $('#advancedSearchModal').modal('show')
      },

      clearSearchForm() {
        this.searchForm.reset()
        this.getResults()
      },

      getResults: function()
      {
          Swal.fire({
              title: '<strong>Loading data...</strong>',
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

          axios.post('api/searchReappointments', this.searchForm)
          .then(({data}) => {
              this.reappointments = data;
              this.$Progress.finish()
              $('#advancedSearchModal').modal('hide')
              Swal.close()
          }).catch(error => {
              Swal.close()
              toast.fire({
                icon: 'error',
                title: 'Search unsuccessful.'
              });
              $('#advancedSearchModal').modal('hide')
              this.$Progress.fail()
              console.log(error.reponse.data.message);
          });

      },

      print: function()
      {

        Swal.fire({
            title: '<strong>Loading data...</strong>',
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

        axios.post('api/printReappointments', this.searchForm)
        .then(({data}) => {
            var f = document.getElementById('print')
            f.contentWindow.document.write(data)
            setTimeout(function () {
                f.contentWindow.focus()
                f.contentWindow.print()

                f.contentWindow.document.open();
                f.contentWindow.document.write("");
                f.contentWindow.document.close();
                Swal.close()
            }, 500);
        })
        .catch(e => {
            Swal.close()
        })

      },
      getEmployeePosition: function(id)
      {
            this.loading_position = true
            axios.get('api/getEmployeePosition/'+id)
            .then(({data}) => {
                this.loading_position = false
                this.form.position = data
            })
            .catch(error => {
                this.loading_position = false
                console.log(error)
            })
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
      get_search_results: function(page = 1)
      {
          axios.post('api/searchReappointments?page=' + page, this.searchForm)
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
          this.form.clear()
          this.editMode = false
          $('#reappointment_modal').modal('show')
      },
      edit_reappointments: function(reappointment)
      {
          this.form.reset()
          this.form.clear()
          this.form.fill(reappointment)
          this.reappointment_id = reappointment.id
          this.editMode = true
          $('#reappointment_modal').modal('show')
      },
      submit_reappointments: function()
      {
            this.$Progress.start()
            this.loading = true
            console.log(this.form)
            this.form.post('api/reappointments', this.form)
            .then(({data}) => {
                $('#reappointment_modal').modal('hide')
                toast.fire({
                    icon: 'success',
                    title: 'Submitted'
                });
                this.fetch_reappointments()
                this.$Progress.finish()
                this.loading = false
            }).catch(error => {
                this.loading = false
                toast.fire({
                    icon: 'error',
                    title: 'Missing Inputs'
                });
                this.$Progress.fail()
            });
      },
      submit_edits_reappointments: function()
      {
          this.$Progress.start()
          this.loading = true
          this.form.patch('api/reappointments/'+this.reappointment_id, this.form)
          .then(({data}) => {
              $('#reappointment_modal').modal('hide')
              toast.fire({
                  icon: 'success',
                  title: 'Submitted'
              });
              this.editMode = false
              this.fetch_reappointments()
              this.$Progress.finish()
              this.loading = false
          }).catch(error => {
              Swal.fire(
                  'Oops...',
                  'Something went wrong',
                  'error'
              )
              this.$Progress.fail()
              this.loading = false
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
      },
  },
}
</script>
