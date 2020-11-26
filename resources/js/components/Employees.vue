<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h2>Employees</h2>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input v-model="search" @keyup.prevent="searchit" type="text" class="form-control" placeholder="Search">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped text-nowrap employees-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="employee in employees.data" :key="employee.id">
                                <!-- <td>{{ user.name | capitalize }}</td> -->
                                <td style="width: calc(100%-150px);">
                                    <img style="width: 38px;height: 38px;" class="img-circle mr-2" :src="getAvatar(employee.picture)" alt="User Avatar">
                                    <div style="display: inline-block;vertical-align: middle;line-height: 1.2rem;height: 35px;">
                                        <span style="font-size: 1rem;">{{ employee.surname + ', ' + employee.firstname + ' ' + employee.nameextension + ' ' + employee.middlename }}</span>
                                        <br>
                                        <span style="font-size: 0.8rem;" class="text-muted"><i>{{ employee.status }}</i></span>
                                    </div>
                                    
                                </td>
                                <td v-if="employee.plantillacontents.length > 0">
                                    <p style="margin: 0;line-height: 1.2rem;">{{ employee.plantillacontents[0].position && employee.plantillacontents[0].position.title }}</p>
                                    <p style="margin: 0;line-height: 1.2rem;" class="text-muted">{{ employee.plantillacontents[0].position && employee.plantillacontents[0].position.department.description }}</p>
                                </td>
                                <td v-else></td>
                                <td style="width: 150px;">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-info">Action</button>
                                        <button type="button" class="btn btn-sm btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item" @click.prevent="viewProfileModal(employee)" href="#">View Profile</a>
                                                <a class="dropdown-item" href="#">Basic Information</a>
                                                <a class="dropdown-item" href="#">Latest Plantilla Record</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" @click.prevent="generateBarcode(employee)" href="#">Generate Barcode</a>
                                                <a class="dropdown-item" @click.prevent="generateId(employee)" href="#">Generate ID</a>
                                            </div>
                                        </button>
                                    </div>
                                </td>
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
            <div class="modal-dialog modal-xl modal-dialog-centered" style="height: 100%; margin-top: 0px;">
                <div class="modal-content employee-modal-content" style="height: 95%;">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" :src="getAvatar(form.picture)" alt="User profile picture">
                    </div>

                    <h3 class="text-center mt-1" style="margin-bottom: 0;"><b>{{ form.firstname + ' ' + form.middlename + ' ' + form.surname + ' ' + form.nameextension }}</b></h3>

                    <span v-if="form.plantillacontents.length > 0">
                        <p class="text-muted text-center mt-1" style="font-size: 1rem;line-height: 1.2rem;">
                            {{ form.plantillacontents[0].position && form.plantillacontents[0].position.title }}<br>
                            {{ form.plantillacontents[0].position && form.plantillacontents[0].position.department.title }}
                        </p>
                    </span>
                    <span v-else><br></span>
                    
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
                                    {{ form.sex + ' / ' + form.civilstatus + ' / ' + form.citizenship }}
                                </p>
                                <hr>
                                
                                <strong><i class="fas fa-balance-scale mr-1"></i> Height(m) / Weight(kg) / Bloodtype</strong>
                                <p class="text-muted">
                                    {{ form.height + ' / ' + form.weight + ' / ' + form.bloodtype }}
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
                                <hr v-if="form.gsis || form.pagibig || form.philhealth || form.sss || form.tin">
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
                            <div class="col-md-6">
                                <strong><i class="fas fa-user-friends mr-1"></i> Spouse</strong>
                                <p v-if="form.familybackground.spouseSurname" class="text-muted">
                                    <span v-if="form.familybackground.spouseSurname">
                                        Name: {{ form.familybackground.spouseFirstname + ' ' + form.familybackground.spouseMiddlename + ' ' + form.familybackground.spouseSurname }}
                                    </span>
                                    <span v-if="form.familybackground.spouseOccupation">
                                        <br>
                                        Occupation: {{ form.familybackground.spouseOccupation }}
                                    </span>
                                    <span v-if="form.familybackground.spouseBussiness">
                                        <br>
                                        Employer/Business Name: {{ form.familybackground.spouseBussiness }}
                                    </span>
                                    <span v-if="form.familybackground.spouseBussinessAddress">
                                        <br>
                                        Employer/Business Address: {{ form.familybackground.spouseBussinessAddress }}
                                    </span>
                                    <span v-if="form.familybackground.spouseTelephone">
                                        <br>
                                        Telephone No.: {{ form.familybackground.spouseTelephone }}
                                    </span>
                                </p>
                                <p class="text-muted" v-if="form.familybackground.spouseSurname == ''">No data</p>
                                <hr>

                                <strong><i class="fas fa-male mr-1"></i> Father</strong>
                                <p class="text-muted">
                                    {{ form.familybackground.fatherFirstname + ' ' + form.familybackground.fatherMiddlename + ' ' + form.familybackground.fatherSurname }}
                                </p>
                                <hr>

                                <strong><i class="fas fa-female mr-1"></i> Mother</strong>
                                <p class="text-muted">
                                    <span v-if="form.familybackground.motherMaidenName">Maiden Name: {{ form.familybackground.motherMaidenName }}</span>
                                    <br v-if="form.familybackground.motherMaidenName">
                                    {{ form.familybackground.motherFirstname + ' ' + form.familybackground.motherMiddlename + ' ' + form.familybackground.motherSurname }}
                                </p>
                                <hr>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="fas fa-child mr-1"></i> Children</strong>
                                <p class="text-muted" v-for="child in form.children" :key="child.id" style="margin-bottom: 0;">
                                    Name: {{ child.name }}<br>
                                    Birthday: {{ child.birthday }}
                                </p>
                                <p class="text-muted" v-if="form.children == 0">No data</p>
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
                            <div class="col-md-6">
                                <strong><i class="fas fa-graduation-cap mr-1"></i> Elementary</strong>
                                <p class="text-muted" v-if="form.educationalbackground.elemSchoolName">
                                    <span v-if="form.educationalbackground.elemSchoolName">
                                        School: {{ form.educationalbackground.elemSchoolName }}
                                    </span>
                                    <span v-if="form.educationalbackground.elemTo">
                                        <br>
                                        Period: {{ form.educationalbackground.elemFrom + ' - ' + form.educationalbackground.elemTo }}
                                    </span>
                                    <span v-if="form.educationalbackground.elemHighestLevel">
                                        <br>
                                        Level: {{ form.educationalbackground.elemHighestLevel }}
                                    </span>
                                    <span v-if="form.educationalbackground.elemYear">
                                        <br>
                                        Year Graduated: {{ form.educationalbackground.elemYear }}
                                    </span>
                                    <span v-if="form.educationalbackground.elemSOA">
                                        <br>
                                        Academic Honors: {{ form.educationalbackground.elemSOA }}
                                    </span>
                                </p>
                                <p class="text-muted" v-if="form.educationalbackground.elemSchoolName == ''">No data</p>
                                <hr>

                                <strong><i class="fas fa-graduation-cap mr-1"></i> College</strong>
                                <p class="text-muted" v-if="form.educationalbackground.collSchoolName1">
                                    <span v-if="form.educationalbackground.collSchoolName1">
                                        School: {{ form.educationalbackground.collSchoolName1 }}
                                    </span>
                                    <span v-if="form.educationalbackground.collTo1">
                                        <br>
                                        Period: {{ form.educationalbackground.collFrom1 + ' - ' + form.educationalbackground.collTo1 }}
                                    </span>
                                    <span v-if="form.educationalbackground.collHighestLevel1">
                                        <br>
                                        Level: {{ form.educationalbackground.collHighestLevel1 }}
                                    </span>
                                    <span v-if="form.educationalbackground.collYear1">
                                        <br>
                                        Year Graduated: {{ form.educationalbackground.collYear1 }}
                                    </span>
                                    <span v-if="form.educationalbackground.collSOA1">
                                        <br>
                                        Academic Honors: {{ form.educationalbackground.collSOA1 }}
                                    </span>
                                </p>
                                <p class="text-muted" v-if="form.educationalbackground.collSchoolName2">
                                    <span v-if="form.educationalbackground.collSchoolName2">
                                        School: {{ form.educationalbackground.collSchoolName2 }}
                                    </span>
                                    <span v-if="form.educationalbackground.collTo2">
                                        <br>
                                        Period: {{ form.educationalbackground.collFrom2 + ' - ' + form.educationalbackground.collTo2 }}
                                    </span>
                                    <span v-if="form.educationalbackground.collHighestLevel2">
                                        <br>
                                        Level: {{ form.educationalbackground.collHighestLevel2 }}
                                    </span>
                                    <span v-if="form.educationalbackground.collYear2">
                                        <br>
                                        Year Graduated: {{ form.educationalbackground.collYear2 }}
                                    </span>
                                    <span v-if="form.educationalbackground.collSOA2">
                                        <br>
                                        Academic Honors: {{ form.educationalbackground.collSOA2 }}
                                    </span>
                                </p>
                                <p class="text-muted" v-if="form.educationalbackground.collSchoolName2 == '' && form.educationalbackground.collSchoolName1 == ''">No data</p>
                                <hr>

                                <strong><i class="fas fa-graduation-cap mr-1"></i> Graduate Studies</strong>
                                <p class="text-muted" v-if="form.educationalbackground.gradSchoolName">
                                    <span v-if="form.educationalbackground.gradSchoolName">
                                        School: {{ form.educationalbackground.gradSchoolName }}
                                    </span>
                                    <span v-if="form.educationalbackground.gradTo">
                                        <br>
                                        Period: {{ form.educationalbackground.gradFrom + ' - ' + form.educationalbackground.gradTo }}
                                    </span>
                                    <span v-if="form.educationalbackground.gradHighestLevel">
                                        <br>
                                        Level: {{ form.educationalbackground.gradHighestLevel }}
                                    </span>
                                    <span v-if="form.educationalbackground.gradYear">
                                        <br>
                                        Year Graduated: {{ form.educationalbackground.gradYear }}
                                    </span>
                                    <span v-if="form.educationalbackground.gradSOA">
                                        <br>
                                        Academic Honors: {{ form.educationalbackground.gradSOA }}
                                    </span>
                                </p>
                                <p class="text-muted" v-if="form.educationalbackground.gradSchoolName == ''">No data</p>
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <strong><i class="fas fa-graduation-cap mr-1"></i> Secondary</strong>
                                <p class="text-muted" v-if="form.educationalbackground.secSchoolName">
                                    <span v-if="form.educationalbackground.secSchoolName">
                                        School: {{ form.educationalbackground.secSchoolName }}
                                    </span>
                                    <span v-if="form.educationalbackground.secTo">
                                        <br>
                                        Period: {{ form.educationalbackground.secFrom + ' - ' + form.educationalbackground.secTo }}
                                    </span>
                                    <span v-if="form.educationalbackground.secHighestLevel">
                                        <br>
                                        Level: {{ form.educationalbackground.secHighestLevel }}
                                    </span>
                                    <span v-if="form.educationalbackground.secYear">
                                        <br>
                                        Year Graduated: {{ form.educationalbackground.secYear }}
                                    </span>
                                    <span v-if="form.educationalbackground.secSOA">
                                        <br>
                                        Academic Honors: {{ form.educationalbackground.secSOA }}
                                    </span>
                                </p>
                                <p class="text-muted" v-if="form.educationalbackground.secSchoolName == ''">No data</p>
                                <hr>

                                <strong><i class="fas fa-graduation-cap mr-1"></i> Vocational / Trade Course</strong>
                                <p class="text-muted" v-if="form.educationalbackground.vocSchoolName">
                                    <span v-if="form.educationalbackground.vocSchoolName">
                                        School: {{ form.educationalbackground.vocSchoolName }}
                                    </span>
                                    <span v-if="form.educationalbackground.vocTo">
                                        <br>
                                        Period: {{ form.educationalbackground.vocFrom + ' - ' + form.educationalbackground.vocTo }}
                                    </span>
                                    <span v-if="form.educationalbackground.vocHighestLevel">
                                        <br>
                                        Level: {{ form.educationalbackground.vocHighestLevel }}
                                    </span>
                                    <span v-if="form.educationalbackground.vocYear">
                                        <br>
                                        Year Graduated: {{ form.educationalbackground.vocYear }}
                                    </span>
                                    <span v-if="form.educationalbackground.vocSOA">
                                        <br>
                                        Academic Honors: {{ form.educationalbackground.vocSOA }}
                                    </span>
                                </p>
                                <p class="text-muted" v-if="form.educationalbackground.vocSchoolName == ''">No data</p>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Civil Service Eligibility</h4>
                            </div>
                            <div class="col-md-6">
                                <h4>Other Information</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr style="margin: 0 0 0.5rem 0;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-book mr-1"></i> Civil Service Eligibility</strong>
                                <p class="text-muted" v-for="(eligibility, index) in form.eligibilities" :key="eligibility.id" style="margin-bottom: 0;">
                                    Eligibility: {{ eligibility.careerService }}<br>
                                    Rating: {{ eligibility.rating }}<br>
                                    Date of Examination: {{ eligibility.dateOfExam }}<br>
                                    Place of Examination: {{ eligibility.placeOfExam }}<br>
                                    License Number: {{ eligibility.licenseNumber }}<br>
                                    Date of Validity: {{ eligibility.licenseRelease }}
                                    <br v-if="index != Object.keys(form.eligibilities).length - 1">
                                    <br v-if="index != Object.keys(form.eligibilities).length - 1">
                                </p>
                                <p class="text-muted" v-if="form.eligibilities == 0">No data</p>
                                <hr>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="fas fa-tools mr-1"></i> Special Skills & Hobbies</strong>
                                <p class="text-muted" style="margin-bottom: 0;">
                                    <span v-for="(otherinfo, index) in form.otherinfos" :key="otherinfo.id" >
                                        <span v-if="otherinfo.skill">
                                            {{ otherinfo.skill }}<span v-if="index != Object.keys(form.otherinfos).length - 1">, </span>
                                        </span>
                                    </span>
                                </p>
                                <strong><i class="fas fa-award mr-1"></i> NON-ACADEMIC DISTINCTIONS / RECOGNITION</strong>
                                <p class="text-muted" style="margin-bottom: 0;">
                                    <span v-for="(otherinfo, index) in form.otherinfos" :key="otherinfo.id">
                                        <span v-if="otherinfo.recognition">
                                            {{ otherinfo.recognition }}<span v-if="index != Object.keys(form.otherinfos).length - 1">, </span>
                                        </span>
                                    </span>
                                </p>
                                <strong><i class="fas fa-users mr-1"></i> MEMBERSHIP IN ASSOCIATION/ORGANIZATION</strong>
                                <p class="text-muted" style="margin-bottom: 0;">
                                    <span v-for="(otherinfo, index) in form.otherinfos" :key="otherinfo.id" >
                                        <span v-if="otherinfo.membership">
                                            {{ otherinfo.membership }}<span v-if="index != Object.keys(form.otherinfos).length - 1">, </span>
                                        </span>
                                    </span>
                                </p>
                                <hr>
                            </div>
                        </div>
                        <div class="row" v-if="workexperiences().length > 0">
                            <div class="col-md-12">
                                <h4>Work Experience</h4>
                            </div>
                        </div>
                        <div class="row" v-if="workexperiences().length > 0">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover pds-table">
                                    <thead>                  
                                        <tr class="text-center">
                                            <th colspan="2">Inclusive Dates</th>
                                            <th rowspan="2">Position Title</th>
                                            <th rowspan="2">Department / Agency / Office / Company</th>
                                            <th rowspan="2">Monthly Salary</th>
                                            <th rowspan="2">Salary Grade</th>
                                            <th rowspan="2">Status of Appointment</th>
                                            <th rowspan="2">Gov't Service (Y/N)</th>
                                        </tr>
                                        <tr class="text-center">
                                            <th>From</th>
                                            <th>To</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(workexperience) in workexperiences()" :key="workexperience.id">
                                            <td class="text-center" style="white-space: nowrap;">{{ workexperience.inclusiveDateFrom }}</td>
                                            <td class="text-center" style="white-space: nowrap;">{{ workexperience.inclusiveDateTo }}</td>
                                            <td>{{ workexperience.position }}</td>
                                            <td>{{ workexperience.department }}</td>
                                            <td class="text-center">{{ workexperience.monthlySalary }}</td>
                                            <td class="text-center">{{ workexperience.salaryGrade }}</td>
                                            <td class="text-center">{{ workexperience.statusOfAppointment }}</td>
                                            <td class="text-center">{{ workexperience.govService }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row" v-if="voluntaryworks().length > 0">
                            <div class="col-md-12">
                                <h4>Voluntary Work or Involvement In Civic / Non-Government / People / Voluntary Organization/s</h4>
                            </div>
                        </div>
                        <div class="row" v-if="voluntaryworks().length > 0">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover pds-table">
                                    <thead>                  
                                        <tr class="text-center">
                                            <th rowspan="2">Name & Address of Organization</th>
                                            <th colspan="2">Inclusive Dates</th>
                                            <th rowspan="2">Number of Hours</th>
                                            <th rowspan="2">Position / Nature of Work</th>
                                        </tr>
                                        <tr class="text-center">
                                            <th>From</th>
                                            <th>To</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(voluntarywork) in voluntaryworks()" :key="voluntarywork.id">
                                            <td>{{ voluntarywork.nameAndAddress }}</td>
                                            <td class="text-center" style="white-space: nowrap;">{{ voluntarywork.inclusiveDateFrom }}</td>
                                            <td class="text-center" style="white-space: nowrap;">{{ voluntarywork.inclusiveDateTo }}</td>
                                            <td class="text-center">{{ voluntarywork.hours }}</td>
                                            <td>{{ voluntarywork.position }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row" v-if="trainingprograms().length > 0">
                            <div class="col-md-12">
                                <h4>Learning & Development (L&D) Interventions / Training Programs Attended</h4>
                            </div>
                        </div>
                        <div class="row" v-if="trainingprograms().length > 0">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover pds-table">
                                    <thead>                  
                                        <tr class="text-center">
                                            <th rowspan="2">Learning & Development Interventions / Training Program</th>
                                            <th colspan="2">Inclusive Dates of Attendance</th>
                                            <th rowspan="2">Number of Hours</th>
                                            <th rowspan="2">Type of LD (Managerial / Supervisory / Technical / etc)</th>
                                            <th rowspan="2">Conducted/Sponsored by</th>
                                        </tr>
                                        <tr class="text-center">
                                            <th>From</th>
                                            <th>To</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(trainingprogram) in trainingprograms()" :key="trainingprogram.id">
                                            <td>{{ trainingprogram.title }}</td>
                                            <td class="text-center" style="white-space: nowrap;">{{ trainingprogram.inclusiveDateFrom }}</td>
                                            <td class="text-center" style="white-space: nowrap;">{{ trainingprogram.inclusiveDateTo }}</td>
                                            <td class="text-center">{{ trainingprogram.hours }}</td>
                                            <td></td>
                                            <td>{{ trainingprogram.conductor }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="btn btn-primary btn-block" @click.prevent="generatePDS(form.id)"><i class="fas fa-print mr-2"></i>Generate Personal Data Sheet</a>
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

        <!-- The Modal -->
        <div class="modal" id="pdfModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Print Report</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="pdf-viewer">
                    
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
                search: '',
                personalinformation: {},
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
                    'status': '',
                    'educationalbackground': {},
                    'familybackground': {},
                    'children': {},
                    'eligibilities': {},
                    'otherinfos': {},
                    'workexperiences': {},
                    'voluntaryworks': {},
                    'trainingprograms': {},
                    'plantillacontents': {}
                })
            }
        },
        methods: {
            workexperiences() {
                return _.orderBy(this.form.workexperiences, 'orderNo'); 
            },
            voluntaryworks() {
                return _.orderBy(this.form.voluntaryworks, 'orderNo'); 
            },
            trainingprograms() {
                return _.orderBy(this.form.trainingprograms, 'orderNo'); 
            },
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
            searchit: _.debounce(function(){
                this.getResults();
            }, 400),
            viewProfileModal(employee) {
                $('#scanModal').modal('show');
                $('#barcodeField').val('');
                $('.barcode-validate').hide();
                
                this.form.fill(employee);
                this.focusBarcode();
            },
            getAvatar(picture) {
                if (picture != null) {
                    let prefix = (picture.match(/\//) ? '' : '/storage/employee_pictures/');
                    return prefix + picture;
                } else {
                    return '/storage/project_files/profile.png';
                }
            },
            getResults(page = 1) {
                axios.get('api/personalinformation?page=' + page + '&query=' + this.search)
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
            },
            generatePDS(id){
                axios.post('generatePDS', {id: id})
                    .then(response => {                 
                        let options = {
                            height: screen.height * 0.75 + 'px',
                            page: '1'
                        };
                        $('#viewProfileModal').modal('hide');
                        $('#pdfModal').modal('show');
                        PDFObject.embed("/storage/employee_pds/" + response.data.title + ".pdf", "#pdf-viewer", options);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            generateId(employee) {
                axios.post('generateId', {id: employee.id})
                    .then(response => {                 
                        let options = {
                            height: screen.height * 0.75 + 'px',
                            page: '1'
                        };
                        $('#pdfModal').modal('show');
                        PDFObject.embed("/storage/employee_ids/" + response.data.title + ".pdf", "#pdf-viewer", options);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        created() {
            // Fire.$on('searching', () => {
            //     this.getResults();
            // });
            this.$Progress.start();
            this.loadEmployees();
            this.$Progress.finish();
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
