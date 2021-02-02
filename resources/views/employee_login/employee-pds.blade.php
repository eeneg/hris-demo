@extends('employee_login.index')

@section('styles')

@endsection

@section('content')
<div class="flex-center full-height bg">
    <div class="row">


        <div id="circularMenu" class="circular-menu">

            <a class="floating-btn" onclick="document.getElementById('circularMenu').classList.toggle('active');">
                <i class="fa fa-bars" style="color:white"></i>
            </a>

            <menu class="items-wrapper">

            <a href="" class="menu-item">
                <i class="fa fa-edit"></i>
            </a>

            <a href="{{ route('log-out') }}" class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
            </a>

            </menu>

        </div>


        <div class="col-md-12">
            <img src="{{ asset('img.jpg') }}" class="img-fluid" alt="Responsive image" style="position:absolute;"/>
        </div>

    </div>
    <div class="login-box mt-5" style="width: 90%; height: 94%;">
        <!-- /.login-logo -->
        <div class="card" style="height: 700px;">
            <div class="card-body login-card-body" style="height: 100%;">
                <div class="login-logo">
                    <img src="/storage/project_files/davsur.png" alt="logo" width="120px" height="120px">
                </div>
                <div class="title-container">
                    <p class="logo-title">Human Resource<br></p>
                    <span class="logo-title2">Information System</span>
                </div>
                <div class="view-profile-container" style="height: 400px;">
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
                                {{ @$employee->birthdate }}<br>{{ @$employee->birthplace }}
                            </p>
                            <hr>

                            <strong><i class="fas fa-info-circle mr-1"></i> Sex / Civil Status / Citizenship</strong>
                            <p class="text-muted">
                                {{ @$employee->sex . ' / ' . @$employee->civilstatus . ' / ' . @$employee->citizenship }}
                            </p>
                            <hr>

                            <strong><i class="fas fa-balance-scale mr-1"></i> Height(m) / Weight(kg) / Bloodtype</strong>
                            <p class="text-muted">
                                {{ @$employee->height . ' / ' . @$employee->weight . ' / ' . @$employee->bloodtype }}
                            </p>
                            <hr>

                            <strong v-if="@$employee->gsis"><i class="fas fa-id-badge mr-1"></i> GSIS ID No.</strong>
                            <p class="text-muted" v-if="@$employee->gsis" style="margin-bottom: 0;">
                                {{ @$employee->gsis }}
                            </p>
                            <strong v-if="@$employee->pagibig"><i class="fas fa-id-badge mr-1"></i> Pag-ibig ID No.</strong>
                            <p class="text-muted" v-if="@$employee->pagibig" style="margin-bottom: 0;">
                                {{ @$employee->pagibig }}
                            </p>
                            <strong v-if="@$employee->philhealth"><i class="fas fa-id-badge mr-1"></i> PhilHealth No.</strong>
                            <p class="text-muted" v-if="@$employee->philhealth" style="margin-bottom: 0;">
                                {{ @$employee->philhealth }}
                            </p>
                            <strong v-if="@$employee->sss"><i class="fas fa-id-badge mr-1"></i> SSS No.</strong>
                            <p class="text-muted" v-if="@$employee->sss" style="margin-bottom: 0;">
                                {{ @$employee->sss }}
                            </p>
                            <strong v-if="@$employee->tin"><i class="fas fa-id-badge mr-1"></i> TIN No.</strong>
                            <p class="text-muted" v-if="@$employee->tin">
                                {{ @$employee->tin }}
                            </p>
                            <hr v-if="@$employee->gsis || @$employee->pagibig || @$employee->philhealth || @$employee->sss || @$employee->tin">
                        </div>

                        <div class="col-md-6">
                            <strong v-if="@$employee->residentialaddress"><i class="fas fa-map-marker-alt mr-1"></i> Residential Address</strong>
                            <p class="text-muted" v-if="@$employee->residentialaddress">
                                {{ @$employee->residentialaddress }}
                                <br v-if="@$employee->residentialaddress">
                                <span v-if="@$employee->residentialaddress">{{ @$employee->zipcode1 }}</span>
                                <br v-if="@$employee->residentialaddress">
                                <span v-if="@$employee->residentialaddress">{{ @$employee->telephone1 }}</span>
                            </p>
                            <hr v-if="@$employee->residentialaddress">

                            <strong v-if="@$employee->permanentaddress"><i class="fas fa-map-marker-alt mr-1"></i> Permanent Address</strong>
                            <p class="text-muted" v-if="@$employee->permanentaddress">
                                {{ @$employee->permanentaddress }}
                                <br v-if="@$employee->permanentaddress">
                                <span v-if="@$employee->permanentaddress">{{ @$employee->zipcode2 }}</span>
                                <br v-if="@$employee->permanentaddress">
                                <span v-if="@$employee->permanentaddress">{{ @$employee->telephone2 }}</span>
                            </p>
                            <hr v-if="@$employee->permanentaddress">

                            <strong><i class="fas fa-mobile-alt mr-1"></i> Mobile No.</strong>
                            <p class="text-muted">
                                {{ @$employee->cellphone }}
                            </p>
                            <hr>

                            <strong><i class="fas fa-at mr-1"></i> Email Address</strong>
                            <p class="text-muted">
                                {{ @$employee->email }}
                            </p>
                            <hr>

                            <strong><i class="fas fa-id-card-alt mr-1"></i> Agency Employee No.</strong>
                            <p class="text-muted">
                                {{ @$employee->agencynumber }}
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
                            <p v-if="@$employee->familybackground->spouseSurname" class="text-muted">
                                <span v-if="@$employee->familybackground->spouseSurname">
                                    Name: {{ @$employee->familybackground->spouseFirstname . ' ' . @$employee->familybackground->spouseMiddlename . ' ' . @$employee->familybackground->spouseSurname }}
                                </span>
                                <span v-if="@$employee->familybackground->spouseOccupation">
                                    <br>
                                    Occupation: {{ @$employee->familybackground->spouseOccupation }}
                                </span>
                                <span v-if="@$employee->familybackground->spouseBussiness">
                                    <br>
                                    Employer/Business Name: {{ @$employee->familybackground->spouseBussiness }}
                                </span>
                                <span v-if="@$employee->familybackground->spouseBussinessAddress">
                                    <br>
                                    Employer/Business Address: {{ @$employee->familybackground->spouseBussinessAddress }}
                                </span>
                                <span v-if="@$employee->familybackground->spouseTelephone">
                                    <br>
                                    Telephone No.: {{ @$employee->familybackground->spouseTelephone }}
                                </span>
                            </p>
                            <p class="text-muted" v-if="@$employee->familybackground->spouseSurname == ''">No data</p>
                            <hr>

                            <strong><i class="fas fa-male mr-1"></i> Father</strong>
                            <p class="text-muted">
                                {{ @$employee->familybackground->fatherFirstname . ' ' . @$employee->familybackground->fatherMiddlename . ' ' . @$employee->familybackground->fatherSurname }}
                            </p>
                            <hr>

                            <strong><i class="fas fa-female mr-1"></i> Mother</strong>
                            <p class="text-muted">
                                <span v-if="@$employee->familybackground->motherMaidenName">Maiden Name: {{ @$employee->familybackground->motherMaidenName }}</span>
                                <br v-if="@$employee->familybackground->motherMaidenName">
                                {{ @$employee->familybackground->motherFirstname . ' ' . @$employee->familybackground->motherMiddlename . ' ' . @$employee->familybackground->motherSurname }}
                            </p>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <strong><i class="fas fa-child mr-1"></i> Children</strong>
                            <p class="text-muted" v-for="child in @$employee->children" :key="child->id" style="margin-bottom: 0;">
                                {{-- Name: {{ child->name }}<br>
                                Birthday: {{ child->birthday }} --}}
                            </p>
                            <p class="text-muted" v-if="@$employee->children == 0">No data</p>
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
                            <p class="text-muted" v-if="@$employee->educationalbackground->elemSchoolName">
                                <span v-if="@$employee->educationalbackground->elemSchoolName">
                                    School: {{ @$employee->educationalbackground->elemSchoolName }}
                                </span>
                                <span v-if="@$employee->educationalbackground->elemTo">
                                    <br>
                                    Period: {{ @$employee->educationalbackground->elemFrom . ' - ' . @$employee->educationalbackground->elemTo }}
                                </span>
                                <span v-if="@$employee->educationalbackground->elemHighestLevel">
                                    <br>
                                    Level: {{ @$employee->educationalbackground->elemHighestLevel }}
                                </span>
                                <span v-if="@$employee->educationalbackground->elemYear">
                                    <br>
                                    Year Graduated: {{ @$employee->educationalbackground->elemYear }}
                                </span>
                                <span v-if="@$employee->educationalbackground->elemSOA">
                                    <br>
                                    Academic Honors: {{ @$employee->educationalbackground->elemSOA }}
                                </span>
                            </p>
                            <p class="text-muted" v-if="@$employee->educationalbackground->elemSchoolName == ''">No data</p>
                            <hr>

                            <strong><i class="fas fa-graduation-cap mr-1"></i> College</strong>
                            <p class="text-muted" v-if="@$employee->educationalbackground->collSchoolName1">
                                <span v-if="@$employee->educationalbackground->collSchoolName1">
                                    School: {{ @$employee->educationalbackground->collSchoolName1 }}
                                </span>
                                <span v-if="@$employee->educationalbackground->collTo1">
                                    <br>
                                    Period: {{ @$employee->educationalbackground->collFrom1 . ' - ' . @$employee->educationalbackground->collTo1 }}
                                </span>
                                <span v-if="@$employee->educationalbackground->collHighestLevel1">
                                    <br>
                                    Level: {{ @$employee->educationalbackground->collHighestLevel1 }}
                                </span>
                                <span v-if="@$employee->educationalbackground->collYear1">
                                    <br>
                                    Year Graduated: {{ @$employee->educationalbackground->collYear1 }}
                                </span>
                                <span v-if="@$employee->educationalbackground->collSOA1">
                                    <br>
                                    Academic Honors: {{ @$employee->educationalbackground->collSOA1 }}
                                </span>
                            </p>
                            <p class="text-muted" v-if="@$employee->educationalbackground->collSchoolName2">
                                <span v-if="@$employee->educationalbackground->collSchoolName2">
                                    School: {{ @$employee->educationalbackground->collSchoolName2 }}
                                </span>
                                <span v-if="@$employee->educationalbackground->collTo2">
                                    <br>
                                    Period: {{ @$employee->educationalbackground->collFrom2 . ' - ' . @$employee->educationalbackground->collTo2 }}
                                </span>
                                <span v-if="@$employee->educationalbackground->collHighestLevel2">
                                    <br>
                                    Level: {{ @$employee->educationalbackground->collHighestLevel2 }}
                                </span>
                                <span v-if="@$employee->educationalbackground->collYear2">
                                    <br>
                                    Year Graduated: {{ @$employee->educationalbackground->collYear2 }}
                                </span>
                                <span v-if="@$employee->educationalbackground->collSOA2">
                                    <br>
                                    Academic Honors: {{ @$employee->educationalbackground->collSOA2 }}
                                </span>
                            </p>
                            <p class="text-muted" v-if="@$employee->educationalbackground->collSchoolName2 == '' && @$employee->educationalbackground->collSchoolName1 == ''">No data</p>
                            <hr>

                            <strong><i class="fas fa-graduation-cap mr-1"></i> Graduate Studies</strong>
                            <p class="text-muted" v-if="@$employee->educationalbackground->gradSchoolName">
                                <span v-if="@$employee->educationalbackground->gradSchoolName">
                                    School: {{ @$employee->educationalbackground->gradSchoolName }}
                                </span>
                                <span v-if="@$employee->educationalbackground->gradTo">
                                    <br>
                                    Period: {{ @$employee->educationalbackground->gradFrom . ' - ' . @$employee->educationalbackground->gradTo }}
                                </span>
                                <span v-if="@$employee->educationalbackground->gradHighestLevel">
                                    <br>
                                    Level: {{ @$employee->educationalbackground->gradHighestLevel }}
                                </span>
                                <span v-if="@$employee->educationalbackground->gradYear">
                                    <br>
                                    Year Graduated: {{ @$employee->educationalbackground->gradYear }}
                                </span>
                                <span v-if="@$employee->educationalbackground->gradSOA">
                                    <br>
                                    Academic Honors: {{ @$employee->educationalbackground->gradSOA }}
                                </span>
                            </p>
                            <p class="text-muted" v-if="@$employee->educationalbackground->gradSchoolName == ''">No data</p>
                            <hr>
                        </div>

                        <div class="col-md-6">
                            <strong><i class="fas fa-graduation-cap mr-1"></i> Secondary</strong>
                            <p class="text-muted" v-if="@$employee->educationalbackground->secSchoolName">
                                <span v-if="@$employee->educationalbackground->secSchoolName">
                                    School: {{ @$employee->educationalbackground->secSchoolName }}
                                </span>
                                <span v-if="@$employee->educationalbackground->secTo">
                                    <br>
                                    Period: {{ @$employee->educationalbackground->secFrom . ' - ' . @$employee->educationalbackground->secTo }}
                                </span>
                                <span v-if="@$employee->educationalbackground->secHighestLevel">
                                    <br>
                                    Level: {{ @$employee->educationalbackground->secHighestLevel }}
                                </span>
                                <span v-if="@$employee->educationalbackground->secYear">
                                    <br>
                                    Year Graduated: {{ @$employee->educationalbackground->secYear }}
                                </span>
                                <span v-if="@$employee->educationalbackground->secSOA">
                                    <br>
                                    Academic Honors: {{ @$employee->educationalbackground->secSOA }}
                                </span>
                            </p>
                            <p class="text-muted" v-if="@$employee->educationalbackground->secSchoolName == ''">No data</p>
                            <hr>

                            <strong><i class="fas fa-graduation-cap mr-1"></i> Vocational / Trade Course</strong>
                            <p class="text-muted" v-if="@$employee->educationalbackground->vocSchoolName">
                                <span v-if="@$employee->educationalbackground->vocSchoolName">
                                    School: {{ @$employee->educationalbackground->vocSchoolName }}
                                </span>
                                <span v-if="@$employee->educationalbackground->vocTo">
                                    <br>
                                    Period: {{ @$employee->educationalbackground->vocFrom . ' - ' . @$employee->educationalbackground->vocTo }}
                                </span>
                                <span v-if="@$employee->educationalbackground->vocHighestLevel">
                                    <br>
                                    Level: {{ @$employee->educationalbackground->vocHighestLevel }}
                                </span>
                                <span v-if="@$employee->educationalbackground->vocYear">
                                    <br>
                                    Year Graduated: {{ @$employee->educationalbackground->vocYear }}
                                </span>
                                <span v-if="@$employee->educationalbackground->vocSOA">
                                    <br>
                                    Academic Honors: {{ @$employee->educationalbackground->vocSOA }}
                                </span>
                            </p>
                            <p class="text-muted" v-if="@$employee->educationalbackground->vocSchoolName == ''">No data</p>
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
                            <p class="text-muted" v-for="(eligibility, index) in @$employee->eligibilities" :key="@$employee->eligibility->id" style="margin-bottom: 0;">
                                Eligibility: {{ @$employee->eligibility->careerService }}<br>
                                Rating: {{ @$employee->eligibility->rating }}<br>
                                Date of Examination: {{ @$employee->eligibility->dateOfExam }}<br>
                                Place of Examination: {{ @$employee->eligibility->placeOfExam }}<br>
                                License Number: {{ @$employee->eligibility->licenseNumber }}<br>
                                Date of Validity: {{ @$employee->eligibility->licenseRelease }}
                                <br v-if="index != Object.keys(@$employee->eligibilities).length - 1">
                                <br v-if="index != Object.keys(@$employee->eligibilities).length - 1">
                            </p>
                            <p class="text-muted" v-if="@$employee->eligibilities == 0">No data</p>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <strong><i class="fas fa-tools mr-1"></i> Special Skills & Hobbies</strong>
                            <p class="text-muted" style="margin-bottom: 0;">
                                <span v-for="(otherinfo, index) in @$employee->otherinfos" :key="@$employee->otherinfo->id" >
                                    <span v-if="@$employee->otherinfo->skill">
                                        {{ @$employee->otherinfo->skill }}<span v-if="index != Object.keys(@$employee->otherinfos).length - 1">, </span>
                                    </span>
                                </span>
                            </p>
                            <strong><i class="fas fa-award mr-1"></i> NON-ACADEMIC DISTINCTIONS / RECOGNITION</strong>
                            <p class="text-muted" style="margin-bottom: 0;">
                                <span v-for="(otherinfo, index) in @$employee->otherinfos" :key="@$employee->otherinfo->id">
                                    <span v-if="@$employee->otherinfo->recognition">
                                        {{ @$employee->otherinfo->recognition }}<span v-if="index != Object.keys(@$employee->otherinfos).length - 1">, </span>
                                    </span>
                                </span>
                            </p>
                            <strong><i class="fas fa-users mr-1"></i> MEMBERSHIP IN ASSOCIATION/ORGANIZATION</strong>
                            <p class="text-muted" style="margin-bottom: 0;">
                                <span v-for="(otherinfo, index) in @$employee->otherinfos" :key="@$employee->otherinfo->id" >
                                    <span v-if="@$employee->otherinfo->membership">
                                        {{ @$employee->otherinfo->membership }}<span v-if="index != Object.keys(@$employee->otherinfos).length - 1">, </span>
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
                                    @foreach (@$employee->workexperiences as $data)
                                        <tr>
                                            <td class="text-center" style="white-space: nowrap;">{{ @$data->inclusiveDateFrom }}</td>
                                            <td class="text-center" style="white-space: nowrap;">{{ @$data->inclusiveDateTo }}</td>
                                            <td>{{ @$data->position }}</td>
                                            <td>{{ @$data->department }}</td>
                                            <td class="text-center">{{ @$data->monthlySalary }}</td>
                                            <td class="text-center">{{ @$data->salaryGrade }}</td>
                                            <td class="text-center">{{ @$data->statusOfAppointment }}</td>
                                            <td class="text-center">{{ @$data->govService }}</td>
                                        </tr>
                                    @endforeach
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
                                    @foreach (@$employee->voluntaryworks as $data)
                                        <tr>
                                            <td>{{ @$data->nameAndAddress }}</td>
                                            <td class="text-center" style="white-space: nowrap;">{{ @$data->inclusiveDateFrom }}</td>
                                            <td class="text-center" style="white-space: nowrap;">{{ @$data->inclusiveDateTo }}</td>
                                            <td class="text-center">{{ @$data->hours }}</td>
                                            <td>{{ @$data->position }}</td>
                                        </tr>
                                    @endforeach
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
                                    @foreach (@$employee->trainingprograms as $data)
                                        <tr>
                                            <td>{{ @$data->title }}</td>
                                            <td class="text-center" style="white-space: nowrap;">{{ @$data->inclusiveDateFrom }}</td>
                                            <td class="text-center" style="white-space: nowrap;">{{ @$data->inclusiveDateTo }}</td>
                                            <td class="text-center">{{ @$data->hours }}</td>
                                            <td></td>
                                            <td>{{ @$data->conductor }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
