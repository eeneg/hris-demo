<template>

<div class="card">
    <div class="card-header p-2">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group p-1 text-center">
                    <h5 class="float-left">PDS</h5>
                </div>

                <div class="btn-group float-right p-1">
                    <a href="#" class="btn btn-success float-right" @click.prevent="generatePDS(personalinformation.id)">Print <i class="fas fa-print mr-2"></i></a>
                </div>

                <div class="btn-group float-right p-1">
                    <!-- <button class="btn btn-primary" type="button">Edit <i class="fa fa-edit"></i></button> -->
                    <router-link class="btn btn-primary" type="button" :to="{path: '/employees-pds', query: {id: this.personalinformation.id, mode: 2, editMode: 3}}">Edit <i class="fa fa-edit"></i></router-link>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">

            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" :src="getAvatar(personalinformation.picture)" alt="User profile picture">
            </div>

            <h3 class="text-center mt-1" style="margin-bottom: 0;"><b>{{ personalinformation.firstname + ' ' + personalinformation.middlename + ' ' + personalinformation.surname + ' ' + personalinformation.nameextension }}</b></h3>

            <!-- <span v-if="getPlantillaDetails(form)">
                <p class="text-muted text-center mt-1" style="font-size: 1rem;line-height: 1.2rem;">
                    {{ getPlantillaDetails(form).designation }}<br>
                    {{ getPlantillaDetails(form).department }}
                </p>
            </span>
            <span v-else><br></span> -->

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
                            {{ personalinformation.birthdate }}<br>{{ personalinformation.birthplace }}
                        </p>
                        <hr>

                        <strong><i class="fas fa-info-circle mr-1"></i> Sex / Civil Status / Citizenship</strong>
                        <p class="text-muted">
                            {{ personalinformation.sex + ' / ' + personalinformation.civilstatus + ' / ' + personalinformation.citizenship }}
                        </p>
                        <hr>

                        <strong><i class="fas fa-balance-scale mr-1"></i> Height(m) / Weight(kg) / Bloodtype</strong>
                        <p class="text-muted">
                            {{ personalinformation.height + ' / ' + personalinformation.weight + ' / ' + personalinformation.bloodtype }}
                        </p>
                        <hr>

                        <strong v-if="personalinformation.gsis"><i class="fas fa-id-badge mr-1"></i> GSIS ID No.</strong>
                        <p class="text-muted" v-if="personalinformation.gsis" style="margin-bottom: 0;">
                            {{ personalinformation.gsis }}
                        </p>
                        <strong v-if="personalinformation.pagibig"><i class="fas fa-id-badge mr-1"></i> Pag-ibig ID No.</strong>
                        <p class="text-muted" v-if="personalinformation.pagibig" style="margin-bottom: 0;">
                            {{ personalinformation.pagibig }}
                        </p>
                        <strong v-if="personalinformation.philhealth"><i class="fas fa-id-badge mr-1"></i> PhilHealth No.</strong>
                        <p class="text-muted" v-if="personalinformation.philhealth" style="margin-bottom: 0;">
                            {{ personalinformation.philhealth }}
                        </p>
                        <strong v-if="personalinformation.sss"><i class="fas fa-id-badge mr-1"></i> SSS No.</strong>
                        <p class="text-muted" v-if="personalinformation.sss" style="margin-bottom: 0;">
                            {{ personalinformation.sss }}
                        </p>
                        <strong v-if="personalinformation.tin"><i class="fas fa-id-badge mr-1"></i> TIN No.</strong>
                        <p class="text-muted" v-if="personalinformation.tin">
                            {{ personalinformation.tin }}
                        </p>
                        <hr v-if="personalinformation.gsis || personalinformation.pagibig || personalinformation.philhealth || personalinformation.sss || personalinformation.tin">
                    </div>

                    <div class="col-md-6">
                        <strong v-if="personalinformation.residentialaddress"><i class="fas fa-map-marker-alt mr-1"></i> Residential Address</strong>
                        <p class="text-muted" v-if="personalinformation.residentialaddress">
                            {{ personalinformation.residentialaddress }}
                            <br v-if="personalinformation.residentialaddress">
                            <span v-if="personalinformation.residentialaddress">{{ personalinformation.zipcode1 }}</span>
                            <br v-if="personalinformation.residentialaddress">
                            <span v-if="personalinformation.residentialaddress">{{ personalinformation.telephone1 }}</span>
                        </p>
                        <hr v-if="personalinformation.residentialaddress">

                        <strong v-if="personalinformation.permanentaddress"><i class="fas fa-map-marker-alt mr-1"></i> Permanent Address</strong>
                        <p class="text-muted" v-if="personalinformation.permanentaddress">
                            {{ personalinformation.permanentaddress }}
                            <br v-if="personalinformation.permanentaddress">
                            <span v-if="personalinformation.permanentaddress">{{ personalinformation.zipcode2 }}</span>
                            <br v-if="personalinformation.permanentaddress">
                            <span v-if="personalinformation.permanentaddress">{{ personalinformation.telephone2 }}</span>
                        </p>
                        <hr v-if="personalinformation.permanentaddress">

                        <strong><i class="fas fa-mobile-alt mr-1"></i> Mobile No.</strong>
                        <p class="text-muted">
                            {{ personalinformation.cellphone }}
                        </p>
                        <hr>

                        <strong><i class="fas fa-at mr-1"></i> Email Address</strong>
                        <p class="text-muted">
                            {{ personalinformation.email }}
                        </p>
                        <hr>

                        <strong><i class="fas fa-id-card-alt mr-1"></i> Agency Employee No.</strong>
                        <p class="text-muted">
                            {{ personalinformation.agencynumber }}
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
                        <p v-if="personalinformation.familybackground.spouseSurname" class="text-muted">
                            <span v-if="personalinformation.familybackground.spouseSurname">
                                Name: {{ personalinformation.familybackground.spouseFirstname + ' ' + personalinformation.familybackground.spouseMiddlename + ' ' + personalinformation.familybackground.spouseSurname }}
                            </span>
                            <span v-if="personalinformation.familybackground.spouseOccupation">
                                <br>
                                Occupation: {{ personalinformation.familybackground.spouseOccupation }}
                            </span>
                            <span v-if="personalinformation.familybackground.spouseBussiness">
                                <br>
                                Employer/Business Name: {{ personalinformation.familybackground.spouseBussiness }}
                            </span>
                            <span v-if="personalinformation.familybackground.spouseBussinessAddress">
                                <br>
                                Employer/Business Address: {{ personalinformation.familybackground.spouseBussinessAddress }}
                            </span>
                            <span v-if="personalinformation.familybackground.spouseTelephone">
                                <br>
                                Telephone No.: {{ personalinformation.familybackground.spouseTelephone }}
                            </span>
                        </p>
                        <p class="text-muted" v-if="personalinformation.familybackground.spouseSurname == ''">No data</p>
                        <hr>

                        <strong><i class="fas fa-male mr-1"></i> Father</strong>
                        <p class="text-muted">
                            {{ personalinformation.familybackground.fatherFirstname + ' ' + personalinformation.familybackground.fatherMiddlename + ' ' + personalinformation.familybackground.fatherSurname }}
                        </p>
                        <hr>

                        <strong><i class="fas fa-female mr-1"></i> Mother</strong>
                        <p class="text-muted">
                            <span v-if="personalinformation.familybackground.motherMaidenName">Maiden Name: {{ personalinformation.familybackground.motherMaidenName }}</span>
                            <br v-if="personalinformation.familybackground.motherMaidenName">
                            {{ personalinformation.familybackground.motherFirstname + ' ' + personalinformation.familybackground.motherMiddlename + ' ' + personalinformation.familybackground.motherSurname }}
                        </p>
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <strong><i class="fas fa-child mr-1"></i> Children</strong>
                        <p class="text-muted" v-for="child in personalinformation.children" :key="child.id" style="margin-bottom: 0;">
                            Name: {{ child.name }}<br>
                            Birthday: {{ child.birthday }}
                        </p>
                        <p class="text-muted" v-if="personalinformation.children == 0">No data</p>
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
                        <p class="text-muted" v-if="personalinformation.educationalbackground.elemSchoolName">
                            <span v-if="personalinformation.educationalbackground.elemSchoolName">
                                School: {{ personalinformation.educationalbackground.elemSchoolName }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.elemTo">
                                <br>
                                Period: {{ personalinformation.educationalbackground.elemFrom + ' - ' + personalinformation.educationalbackground.elemTo }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.elemHighestLevel">
                                <br>
                                Level: {{ personalinformation.educationalbackground.elemHighestLevel }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.elemYear">
                                <br>
                                Year Graduated: {{ personalinformation.educationalbackground.elemYear }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.elemSOA">
                                <br>
                                Academic Honors: {{ personalinformation.educationalbackground.elemSOA }}
                            </span>
                        </p>
                        <p class="text-muted" v-if="personalinformation.educationalbackground.elemSchoolName == ''">No data</p>
                        <hr>

                        <strong><i class="fas fa-graduation-cap mr-1"></i> College</strong>
                        <p class="text-muted" v-if="personalinformation.educationalbackground.collSchoolName1">
                            <span v-if="personalinformation.educationalbackground.collSchoolName1">
                                School: {{ personalinformation.educationalbackground.collSchoolName1 }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.collTo1">
                                <br>
                                Period: {{ personalinformation.educationalbackground.collFrom1 + ' - ' + personalinformation.educationalbackground.collTo1 }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.collHighestLevel1">
                                <br>
                                Level: {{ personalinformation.educationalbackground.collHighestLevel1 }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.collYear1">
                                <br>
                                Year Graduated: {{ personalinformation.educationalbackground.collYear1 }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.collSOA1">
                                <br>
                                Academic Honors: {{ personalinformation.educationalbackground.collSOA1 }}
                            </span>
                        </p>
                        <p class="text-muted" v-if="personalinformation.educationalbackground.collSchoolName2">
                            <span v-if="personalinformation.educationalbackground.collSchoolName2">
                                School: {{ personalinformation.educationalbackground.collSchoolName2 }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.collTo2">
                                <br>
                                Period: {{ personalinformation.educationalbackground.collFrom2 + ' - ' + personalinformation.educationalbackground.collTo2 }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.collHighestLevel2">
                                <br>
                                Level: {{ personalinformation.educationalbackground.collHighestLevel2 }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.collYear2">
                                <br>
                                Year Graduated: {{ personalinformation.educationalbackground.collYear2 }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.collSOA2">
                                <br>
                                Academic Honors: {{ personalinformation.educationalbackground.collSOA2 }}
                            </span>
                        </p>
                        <p class="text-muted" v-if="personalinformation.educationalbackground.collSchoolName2 == '' && personalinformation.educationalbackground.collSchoolName1 == ''">No data</p>
                        <hr>

                        <strong><i class="fas fa-graduation-cap mr-1"></i> Graduate Studies</strong>
                        <p class="text-muted" v-if="personalinformation.educationalbackground.gradSchoolName">
                            <span v-if="personalinformation.educationalbackground.gradSchoolName">
                                School: {{ personalinformation.educationalbackground.gradSchoolName }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.gradTo">
                                <br>
                                Period: {{ personalinformation.educationalbackground.gradFrom + ' - ' + personalinformation.educationalbackground.gradTo }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.gradHighestLevel">
                                <br>
                                Level: {{ personalinformation.educationalbackground.gradHighestLevel }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.gradYear">
                                <br>
                                Year Graduated: {{ personalinformation.educationalbackground.gradYear }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.gradSOA">
                                <br>
                                Academic Honors: {{ personalinformation.educationalbackground.gradSOA }}
                            </span>
                        </p>
                        <p class="text-muted" v-if="personalinformation.educationalbackground.gradSchoolName == ''">No data</p>
                        <hr>
                    </div>

                    <div class="col-md-6">
                        <strong><i class="fas fa-graduation-cap mr-1"></i> Secondary</strong>
                        <p class="text-muted" v-if="personalinformation.educationalbackground.secSchoolName">
                            <span v-if="personalinformation.educationalbackground.secSchoolName">
                                School: {{ personalinformation.educationalbackground.secSchoolName }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.secTo">
                                <br>
                                Period: {{ personalinformation.educationalbackground.secFrom + ' - ' + personalinformation.educationalbackground.secTo }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.secHighestLevel">
                                <br>
                                Level: {{ personalinformation.educationalbackground.secHighestLevel }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.secYear">
                                <br>
                                Year Graduated: {{ personalinformation.educationalbackground.secYear }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.secSOA">
                                <br>
                                Academic Honors: {{ personalinformation.educationalbackground.secSOA }}
                            </span>
                        </p>
                        <p class="text-muted" v-if="personalinformation.educationalbackground.secSchoolName == ''">No data</p>
                        <hr>

                        <strong><i class="fas fa-graduation-cap mr-1"></i> Vocational / Trade Course</strong>
                        <p class="text-muted" v-if="personalinformation.educationalbackground.vocSchoolName">
                            <span v-if="personalinformation.educationalbackground.vocSchoolName">
                                School: {{ personalinformation.educationalbackground.vocSchoolName }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.vocTo">
                                <br>
                                Period: {{ personalinformation.educationalbackground.vocFrom + ' - ' + personalinformation.educationalbackground.vocTo }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.vocHighestLevel">
                                <br>
                                Level: {{ personalinformation.educationalbackground.vocHighestLevel }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.vocYear">
                                <br>
                                Year Graduated: {{ personalinformation.educationalbackground.vocYear }}
                            </span>
                            <span v-if="personalinformation.educationalbackground.vocSOA">
                                <br>
                                Academic Honors: {{ personalinformation.educationalbackground.vocSOA }}
                            </span>
                        </p>
                        <p class="text-muted" v-if="personalinformation.educationalbackground.vocSchoolName == ''">No data</p>
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
                        <p class="text-muted" v-for="(eligibility, index) in personalinformation.eligibilities" :key="eligibility.id" style="margin-bottom: 0;">
                            Eligibility: {{ eligibility.careerService }}<br>
                            Rating: {{ eligibility.rating }}<br>
                            Date of Examination: {{ eligibility.dateOfExam }}<br>
                            Place of Examination: {{ eligibility.placeOfExam }}<br>
                            License Number: {{ eligibility.licenseNumber }}<br>
                            Date of Validity: {{ eligibility.licenseRelease }}
                            <br v-if="index != Object.keys(personalinformation.eligibilities).length - 1">
                            <br v-if="index != Object.keys(personalinformation.eligibilities).length - 1">
                        </p>
                        <p class="text-muted" v-if="personalinformation.eligibilities == 0">No data</p>
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <strong><i class="fas fa-tools mr-1"></i> Special Skills & Hobbies</strong>
                        <p class="text-muted" style="margin-bottom: 0;">
                            <span v-for="(otherinfo, index) in personalinformation.otherinfos" :key="otherinfo.id" >
                                <span v-if="otherinfo.skill">
                                    {{ otherinfo.skill }}<span v-if="index != Object.keys(personalinformation.otherinfos).length - 1">, </span>
                                </span>
                            </span>
                        </p>
                        <strong><i class="fas fa-award mr-1"></i> NON-ACADEMIC DISTINCTIONS / RECOGNITION</strong>
                        <p class="text-muted" style="margin-bottom: 0;">
                            <span v-for="(otherinfo, index) in personalinformation.otherinfos" :key="otherinfo.id">
                                <span v-if="otherinfo.recognition">
                                    {{ otherinfo.recognition }}<span v-if="index != Object.keys(personalinformation.otherinfos).length - 1">, </span>
                                </span>
                            </span>
                        </p>
                        <strong><i class="fas fa-users mr-1"></i> MEMBERSHIP IN ASSOCIATION/ORGANIZATION</strong>
                        <p class="text-muted" style="margin-bottom: 0;">
                            <span v-for="(otherinfo, index) in personalinformation.otherinfos" :key="otherinfo.id" >
                                <span v-if="otherinfo.membership">
                                    {{ otherinfo.membership }}<span v-if="index != Object.keys(personalinformation.otherinfos).length - 1">, </span>
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
</div>

</template>

<script>


export default {

    data()
    {
        return {
            personalinformation: {
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
                    'children': [{}],
                    'eligibilities': [{}],
                    'otherinfos': [{}],
                    'workexperiences': [{}],
                    'voluntaryworks': [{}],
                    'trainingprograms': [{}],
                    'plantillacontents': {},
                    'pdsquestion': {}
            },
            request: null
        }
    },
    beforeRouteEnter (to, from, next) {
        axios.get('api/employeepersonalinformation')
        .then(({data}) => {
            next(vm => vm.fetchData(data))
        })
        .catch(error => {
            Swal.fire(
                'Failed',
                error.response.statusText,
                'warning'
            )
            next(false)
        })
    },
    methods:
    {
        workexperiences() {
            return _.orderBy(this.personalinformation.workexperiences, 'orderNo');
        },
        voluntaryworks() {
            return _.orderBy(this.personalinformation.voluntaryworks, 'orderNo');
        },
        trainingprograms() {
            return _.orderBy(this.personalinformation.trainingprograms, 'orderNo');
        },

        generatePDS(id){
            axios.post('generatePDS', {id: id})
                .then(response => {
                    let options = {
                        height: screen.height * 0.65 + 'px',
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

        getAvatar(picture) {
            if (picture != null && picture != '') {
                let prefix = (picture.match(/\//) ? '' : '/storage/employee_pictures/');
                return prefix + picture;
            } else {
                return '/storage/project_files/profile.png';
            }
        },

        fetchData: function(data)
        {

            if(!data.familybackground)
            {
                data.familybackground = {}
            }

            if(!data.educationalbackground)
            {
                data.educationalbackground = {}
            }

            if(!data.pdsquestion)
            {
                data.pdsquestion = {}
            }


            Object.assign(this.personalinformation, data)
        },
    },
    created()
    {

    }

}
</script>
