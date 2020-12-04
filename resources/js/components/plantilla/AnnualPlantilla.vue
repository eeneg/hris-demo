<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Annual Plantilla {{ this.$parent.settings.plantilla }}</h2>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="form-group" style="margin-bottom:0;">
                                <label style="margin: 0;font-weight: normal;">Select Department</label>
                                <select class="custom-select" v-model="selectedDepartment" @change="loadContents()">
                                    <option v-for="department in departments" :key="department.id">{{ department.title }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped text-nowrap plantilla-table">
                        <thead>
                            <tr>
                                <th colspan="2" rowspan="2" style="font-size: 1rem;">Item No.</th>
                                <th rowspan="3" style="font-size: 1rem;">Position Title</th>
                                <th rowspan="3" style="font-size: 1rem;">Name of Incumbent</th>
                                <th colspan="2" style="font-size: 1rem;">Current Year Authorized</th>
                                <th colspan="2" style="font-size: 1rem;">Budget Year Proposed</th>
                                <th rowspan="3" style="font-size: 1rem;">Increase / Decrease</th>
                                <th rowspan="3"></th>
                            </tr>
                            <tr>
                                <th colspan="2" style="font-weight: normal;">Rate/Annum Previous</th>
                                <th colspan="2" style="font-weight: normal;">Rate/Annum {{ this.$parent.settings.plantilla }}</th>
                            </tr>
                            <tr>
                                <th style="font-weight: normal;">Old</th>
                                <th style="font-weight: normal;">New</th>
                                <th style="font-weight: normal;">Salary Grade/Step</th>
                                <th style="font-weight: normal;">Amount</th>
                                <th style="font-weight: normal;">Salary Grade/Step</th>
                                <th style="font-weight: normal;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="record in records" :key="record.id">
                                <td style="text-align: center;">{{ record.old_number }}</td>
                                <td style="text-align: center;">{{ record.new_number }}</td>
                                <td>{{ record.position }}</td>
                                <td>{{ record.surname ? (record.surname + ', ' + record.firstname + ' ' + record.nameextension + ' ' + record.middlename) : 'VACANT' }}</td>
                                <td style="text-align: center;">{{ record.salaryauthorized !== null ? (record.salaryauthorized.grade + ' / ' + record.salaryauthorized.step) : '' }}</td>
                                <td style="text-align: right;">{{ record.salaryauthorized !== null ? (record.salaryauthorized.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '' }}</td>
                                <td style="text-align: center;">{{ record.salaryproposed !== null ? (record.salaryproposed.grade + ' / ' + record.salaryproposed.step) : '' }}</td>
                                <td style="text-align: right;">{{ record.salaryproposed !== null ? (record.salaryproposed.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '' }}</td>
                                <td style="text-align: right;">{{ ((record.salaryproposed !== null ? record.salaryproposed.amount : 0) - (record.salaryauthorized !== null ? record.salaryauthorized.amount : 0)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                <td style="text-align: center;"><a href="#" @click.prevent="showEditModal(record)"><i class="fas fa-edit"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-info"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="plantilla-content-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Record</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form autocomplete="off" @submit.prevent="updatePlantillaRecord()">
                        <div class="modal-body">
                            <div class="form-group autocomplete">
                                <input class="form-control" id="nameInput" type="text" name="name" placeholder="Name">
                            </div>
                            <!-- <div class="form-group">
                                <select name="role" v-model="form.role" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('role') }">
                                    <option value="">Select User Role</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Office User">Office User</option>
                                    <option value="Author">Author</option>
                                </select>
                                <has-error :form="form" field="role"></has-error>
                            </div>

                            

                            <div class="form-group">
                                <input v-model="form.email" type="text" name="email" placeholder="Email Address"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.password" type="password" name="password" placeholder="Password"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.landline" type="text" name="landline" placeholder="Landline"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('landline') }">
                                <has-error :form="form" field="landline"></has-error>
                            </div> -->

                            <!-- <button :disabled="form.busy" type="submit" class="btn btn-primary">Log In</button> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                departments: {},
                selectedDepartment: '',
                records: {},
                test: {},
                form: new Form( {
                    'firstname': '',
                    'middlename': '',
                    'nameextension': '',
                    'new_number': '',
                    'old_number': '',
                    'position': '',
                    'surname': '',
                    'salaryauthorized': {},
                    'salaryproposed': {}
                })
            }
        },
        methods: {
            showEditModal(record) {
                $('#plantilla-content-modal').modal('show');
                this.form.fill(record);

                axios.get('api/forvacants')
                    .then(({data}) => {
                        this.test = data;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });

                // let countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
                // this.$parent.autocomplete(document.getElementById("nameInput"), countries);
            },
            updatePlantillaRecord() {

            },
            loadDepartments() {
                axios.get('api/department')
                    .then(({data}) => {
                        this.departments = data.data;
                        this.selectedDepartment = data.data[0].title;
                        this.loadContents();
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            loadContents() {
                axios.post('api/plantilladepartmentcontent', {department: this.selectedDepartment})
                    .then(({data}) => {
                        this.records = data.data;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            }
        },
        created() {
            this.$Progress.start();

            this.loadDepartments();

            this.$Progress.finish();
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
