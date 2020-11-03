<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h2 class="card-header">Employees</h2>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap employees-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th></th>
                                <!-- <th>Email</th>
                                <th>Landline</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Registered At</th>
                                <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="employee in employees.data" :key="employee.id">
                                <!-- <td>{{ user.name | capitalize }}</td> -->
                                <td style="width: calc(100%-150px);">{{ employee.surname + ', ' }}{{ employee.firstname + ' ' }}{{ employee.nameextension + ' ' }}{{ employee.middlename }} </td>
                                <td style="width: 150px;">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info">Action</button>
                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item" @click.prevent="viewProfileModal(employee)" href="#">View Profile</a>
                                                <a class="dropdown-item" href="#">Basic Information</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" @click.prevent="generateBarcode(employee)" href="#">Generate Barcode</a>
                                            </div>
                                        </button>
                                    </div>
                                </td>
                                <!-- <td>{{ user.email }}</td>
                                <td>{{ user.landline }}</td>
                                <td><span class="tag tag-success">{{ user.role }}</span></td>
                                <td>{{ user.status }}</td>
                                <td>{{ user.created_at | myDate }}</td>
                                <td>
                                    <a href="" @click.prevent="editUserModal(user)">
                                        <i class="fas fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="" @click.prevent="deleteUser(user.id)">
                                        <i class="fas fa-trash red"></i>
                                    </a>
                                </td> -->
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <pagination size="default" :data="employees" @pagination-change-page="getResults" :limit="5">
                        <span slot="prev-nav">&lt; Previous</span>
	                    <span slot="next-nav">Next &gt;</span>
                    </pagination>
                    <span style="margin-left: 10px;">Showing {{ employees.from | validateCount }} to {{ employees.to | validateCount }} of {{ employees.total }} records</span>
                </div>
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="viewProfileModal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content employee-modal-content">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" :src="getAvatar(form.picture)" alt="User profile picture">
                    </div>

                    <h3 class="text-center mt-1" style="margin-bottom: 0;"><b>{{ form.firstname + ' ' }}{{ form.middlename + ' ' }}{{ form.surname + ' ' }}{{ form.nameextension }}</b></h3>

                    <p class="text-muted text-center" style="font-size: 1.1rem;">Software Engineer</p>
                    <div class="view-profile-container">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Personal Information</h4>
                                <hr style="margin: 0 0 0.5rem 0;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-birthday-cake mr-1"></i> Birthday</strong>
                                <p class="text-muted">
                                    {{ form.birthdate | myDate }}<br>{{ form.birthplace }}
                                </p>
                                <hr>

                                <strong><i class="fas fa-info-circle mr-1"></i> Sex / Civil Status / Citizenship</strong>
                                <p class="text-muted">
                                    {{ form.sex }} / {{ form.civilstatus }} / {{ form.citizenship }}
                                </p>
                                <hr>
                                
                                <strong><i class="fas fa-balance-scale mr-1"></i> Height(m) / Weight(kg) / Bloodtype</strong>
                                <p class="text-muted">
                                    {{ form.height }} / {{ form.weight }} / {{ form.bloodtype }}
                                </p>
                                <hr>

                                <strong v-if="form.gsis"><i class="fas fa-id-badge mr-1"></i> GSIS ID No.</strong>
                                <p class="text-muted" v-if="form.gsis" style="margin-bottom: 0;">
                                    {{ form.gsis }}
                                </p>
                                <strong v-if="form.pagibig"><i class="fas fa-id-badge mr-1"></i> Pag-ibig ID No.</strong>
                                <p class="text-muted" v-if="form.pagibig" style="margin-bottom: 0;">
                                    {{ form.pagibig }}
                                </p>
                                <strong v-if="form.philhealth"><i class="fas fa-id-badge mr-1"></i> PhilHealth No.</strong>
                                <p class="text-muted" v-if="form.philhealth" style="margin-bottom: 0;">
                                    {{ form.philhealth }}
                                </p>
                                <strong v-if="form.sss"><i class="fas fa-id-badge mr-1"></i> SSS No.</strong>
                                <p class="text-muted" v-if="form.sss" style="margin-bottom: 0;">
                                    {{ form.sss }}
                                </p>
                                <strong v-if="form.tin"><i class="fas fa-id-badge mr-1"></i> TIN No.</strong>
                                <p class="text-muted" v-if="form.tin">
                                    {{ form.tin }}
                                </p>
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <strong v-if="form.residentialaddress"><i class="fas fa-map-marker-alt mr-1"></i> Residential Address</strong>
                                <p class="text-muted" v-if="form.residentialaddress">
                                    {{ form.residentialaddress }}
                                    <br v-if="form.residentialaddress">
                                    <span v-if="form.residentialaddress">{{ form.zipcode1 }}</span>
                                    <br v-if="form.residentialaddress">
                                    <span v-if="form.residentialaddress">{{ form.telephone1 }}</span>
                                </p>
                                <hr v-if="form.residentialaddress">

                                <strong v-if="form.permanentaddress"><i class="fas fa-map-marker-alt mr-1"></i> Permanent Address</strong>
                                <p class="text-muted" v-if="form.permanentaddress">
                                    {{ form.permanentaddress }}
                                    <br v-if="form.permanentaddress">
                                    <span v-if="form.permanentaddress">{{ form.zipcode2 }}</span>
                                    <br v-if="form.permanentaddress">
                                    <span v-if="form.permanentaddress">{{ form.telephone2 }}</span>
                                </p>
                                <hr v-if="form.permanentaddress">

                                <strong><i class="fas fa-mobile-alt mr-1"></i> Mobile No.</strong>
                                <p class="text-muted">
                                    {{ form.cellphone }}
                                </p>
                                <hr>

                                <strong><i class="fas fa-at mr-1"></i> Email Address</strong>
                                <p class="text-muted">
                                    {{ form.email }}
                                </p>
                                <hr>

                                <strong><i class="fas fa-id-card-alt mr-1"></i> Agency Employee No.</strong>
                                <p class="text-muted">
                                    {{ form.agencynumber }}
                                </p>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4>Family Background</h4>
                                <hr style="margin: 0 0 0.5rem 0;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                Data..
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4>Educational Background</h4>
                                <hr style="margin: 0 0 0.5rem 0;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                Data..
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4>Civil Service Eligibility</h4>
                                <hr style="margin: 0 0 0.5rem 0;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                Data..
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4>Work Experience</h4>
                                <hr style="margin: 0 0 0.5rem 0;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                Data..
                                <hr>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="btn btn-primary btn-block"><i class="fas fa-print mr-2"></i>Generate Personal Data Sheet</a>
                    <button class="btn btn-danger btn-block" data-dismiss="modal"><i class="fas fa-times mr-2"></i>Close</button>
                </div>
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="scanModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    
                    <!-- Modal body -->
                    <div class="modal-body text-center">
                        <h4 class="modal-title">Scan barcode from ID</h4>
                        <input @keyup="readBarcode" v-model="barcode" ref="barcodeField" type="password" class="form-control text-center"
                            id="barcodeField" placeholder="Barcode" style="caret-color: transparent;">
                        <div class="barcode-validate elp-block invalid-feedback">Invalid barcode!</div>
                        <!-- <img src="/storage/project_files/barcode.png" alt="" width="80%"> -->
                        <button type="button" class="btn btn-danger mt-2" data-dismiss="modal">Close</button>
                    </div>
                    
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                employees: {},
                barcode: '',
                form: new Form({
                    'id': '',
                    'surname': '',
                    'firstname': '',
                    'middlename': '',
                    'nameextension': '',
                    'birthdate': '',
                    'birthplace': '',
                    'sex': '',
                    'civilstatus': '',
                    'citizenship': '',
                    'height': '',
                    'weight': '',
                    'bloodtype': '',
                    'gsis': '',
                    'pagibig': '',
                    'philhealth': '',
                    'sss': '',
                    'residentialaddress': '',
                    'zipcode1': '',
                    'telephone1': '',
                    'permanentaddress': '',
                    'zipcode2': '',
                    'telephone2': '',
                    'email': '',
                    'cellphone': '',
                    'agencynumber': '',
                    'tin': '',
                    'picture': '',
                    'status': ''
                })
            }
        },
        methods: {
            processBarcode() {
                axios.post('api/verifybarcode', {barcode: this.barcode, employee_id: this.form.id})
                    .then(response => {                 
                        if (response.data != '') {
                            this.form.fill(response.data);
                            $('#scanModal').modal('hide');
                            this.barcode = '';
                            $('#viewProfileModal').modal('show');
                        } else {
                            this.barcode = '';
                            $('.barcode-validate').show();
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            readBarcode: _.debounce(function(){
                this.processBarcode();
            }, 200),
            focusBarcode: _.debounce(function(){
                this.$refs.barcodeField.focus();
            }, 200),
            viewProfileModal(employee) {
                $('#scanModal').modal('show');
                $('#barcodeField').val('');
                $('.barcode-validate').hide();
                

                this.form.fill(employee);
                this.focusBarcode();
            },
            getAvatar(picture) {
                if (picture != null) {
                    let prefix = (picture.match(/\//) ? '' : '/storage/user_avatars/');
                    return prefix + picture;
                } else {
                    return '/storage/project_files/profile.png';
                }
            },
            getResults(page = 1) {
                axios.get('api/personalinformation?page=' + page + '&query=' + this.$parent.search)
                    .then(response => {
                        this.employees = response.data;
                    }).catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            loadEmployees() {
                axios.get('api/personalinformation')
                    .then(({data}) => {
                        this.employees = data;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            generateBarcode(employee) {
                this.$Progress.start();
                axios.post('api/barcode', { id: employee.id })
                    .then(response => {
                        if (response.data == '') {
                            Swal.fire(
                                'Failed',
                                'Barcode for this employee was already generated.',
                                'warning'
                            )
                        } else {
                            Swal.fire(
                                'Success',
                                'Barcode is generated successfully.',
                                'success'
                            )
                        }
                        this.$Progress.finish();
                    })
                    .catch(error => {
                        this.$Progress.fail();
                    });
            }
        },
        created() {
            Fire.$on('searching', () => {
                this.getResults();
            });
            this.$Progress.start();
            this.loadEmployees();
            this.$Progress.finish();
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
