<template>


<div class="row justify-content-center">
    <div class="col-md-12">

        <form @submit.prevent="editMode == 1 ? storePersonalInformation() : editMode == 2 ? updatePersonalInformation() : editMode == 3 ? updateRequest() : ''" action="" id="pdsForm" @keydown="errors.clear($event.target.name)">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h4>PDS FORM</h4>
                </div>
                <div class="card-body">
                    <form-wizard ref="wizard" :start-index="0" shape="tab" title="" subtitle="" color="#3490dc">

                        <tab-content title="Personal Information" icon="ti-user">
                            <div class="form-group" style="display: flex;">
                                <div class="col-md-4">
                                    <div>
                                        <label class="text-center" for="surname" style="line-height: 10px;">Surname</label>
                                    </div>
                                        <input type="text" name="surname" class="form-control form-control-border border-width-2" id="surname" v-model="form.surname">
                                    <span>
                                        <strong class="text-danger" v-if="errors.has('surname')">Field Required</strong>
                                    </span>
                                </div>

                                <div class="col-md-4">
                                    <div>
                                        <label for="firstname" style="line-height: 10px;">Firstname</label>
                                    </div>
                                        <input type="text" name="firstname" class="form-control form-control-border border-width-2" id="firstname" v-model="form.firstname">
                                    <span>
                                        <strong class="text-danger" v-if="errors.has('firstname')">Field Required</strong>
                                    </span>
                                </div>

                                <div class="col-md-4">
                                    <div>
                                        <label for="citizenship" style="line-height: 10px;">Name Extention</label>
                                    </div>
                                    <select name="nameextension" id="nameextension" class="form-control form-control-border border-width-2" v-model="form.nameextension" placeholder="Jr., Sr.">
                                        <option>Jr.</option>
                                        <option>Sr.</option>
                                        <option>I</option>
                                        <option>II</option>
                                        <option>III</option>
                                        <option>IV</option>
                                        <option>V</option>
                                        <option>VI</option>
                                        <option>VII</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" style="display: flex;">
                                <div class="col-md-4">
                                    <div>
                                        <label for="middlename" style="line-height: 10px;">Middlename</label>
                                    </div>
                                        <input type="text" name="middlename" class="form-control form-control-border border-width-2" id="middlename" v-model="form.middlename">
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="birthdate" style="line-height: 10px;">Birth Date</label>
                                    </div>
                                        <input type="date" name="birthdate" class="form-control form-control-border border-width-2" id="birthdate" v-model="form.birthdate">
                                        <!-- <date-picker v-model="form.birthdate" name="birthdate" id="birthdate" :config="options" class="form-control form-control-border border-width-2" placeholder="yyyy-mm-dd"></date-picker> -->
                                    <span>
                                        <strong class="text-danger" v-if="errors.has('birthdate')">Field Required</strong>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="birthplace" style="line-height: 10px;">Birth Place</label>
                                    </div>
                                        <input type="text" name="birthplace" class="form-control form-control-border border-width-2" id="birthplace" v-model="form.birthplace">
                                </div>
                            </div>

                            <div class="form-group" style="display: flex;">
                                <div class="col-md-4">
                                    <div>
                                        <label for="sex" style="line-height: 10px;">Gender</label>
                                    </div>
                                    <select name="sex" id="sex" class="form-control form-control-border border-width-2" v-model="form.sex">
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="civilstatus" style="line-height: 10px;">Civil Status</label>
                                    </div>
                                    <select name="civilstatus" id="civilstatus" class="form-control form-control-border border-width-2" v-model="form.civilstatus">
                                        <option>Single</option>
                                        <option>Widowed</option>
                                        <option>Married</option>
                                        <option>Separated</option>
                                        <option>Other/s</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" style="display: flex;">
                                <div class="col-md-4">
                                    <div>
                                        <label for="height" style="line-height: 10px;">Height(m)</label>
                                    </div>
                                    <input type="text" name="height" class="form-control form-control-border border-width-2" id="height" v-model="form.height">
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="weight" style="line-height: 10px;">Weight(kg)</label>
                                    </div>
                                    <input type="text" name="weight" class="form-control form-control-border border-width-2" id="weight" v-model="form.weight">
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="bloodtype" style="line-height: 10px;">Blood Type</label>
                                    </div>
                                    <input type="text" name="bloodtype" class="form-control form-control-border border-width-2" id="bloodtype" v-model="form.bloodtype">
                                </div>
                            </div>

                            <div class="form-group" style="display: flex;">
                                <div class="col-md-4">
                                    <div>
                                        <label for="gsis" style="line-height: 10px;">GSIS ID Number</label>
                                    </div>
                                    <input type="text" name="gsis" class="form-control form-control-border border-width-2" id="gsis" v-model="form.gsis">
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="pagibig" style="line-height: 10px;">PAG-IBIG ID Number</label>
                                    </div>
                                    <input type="text" name="pagibig" class="form-control form-control-border border-width-2" id="pagibig" v-model="form.pagibig">
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="philhealth" style="line-height: 10px;">PHILHEALTH Number</label>
                                    </div>
                                    <input type="text" name="philhealth" class="form-control form-control-border border-width-2" id="philhealth" v-model="form.philhealth">
                                </div>
                            </div>

                            <div class="form-group" style="display: flex;">
                                <div class="col-md-4">
                                    <div>
                                        <label for="sss" style="line-height: 10px;">SSS Number</label>
                                    </div>
                                    <input type="text" name="sss" class="form-control form-control-border border-width-2" id="sss" v-model="form.sss">
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="tin" style="line-height: 10px;">TIN Number</label>
                                    </div>
                                    <input type="text" name="tin" class="form-control form-control-border border-width-2" id="tin" v-model="form.tin">
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="agencynumber" style="line-height: 10px;">Agency Employee Number</label>
                                    </div>
                                    <input type="text" name="agencynumber" class="form-control form-control-border border-width-2" id="agencynumber" v-model="form.agencynumber">
                                </div>
                            </div>

                            <div class="form-group" style="display: flex;">
                                <div class="col-md-4">
                                    <div>
                                        <label for="citizenship" style="line-height: 10px;">Citizenship</label>
                                    </div>
                                    <select name="citizenship" id="citizenship" class="form-control form-control-border border-width-2" v-model="form.citizenship">
                                        <option>Filipino</option>
                                        <option>Dual citizenship (By Birth)</option>
                                        <option>Dual citizenship (By Naturalization)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" style="display: flex;">
                                <div class="col-md-4">
                                    <div>
                                        <label for="residentialaddress" style="line-height: 10px;">Residential Address</label>
                                    </div>
                                    <input type="text" name="residentialaddress" class="form-control form-control-border border-width-2" id="residentialaddress" v-model="form.residentialaddress">
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="telephone1" style="line-height: 10px;">Telephone</label>
                                    </div>
                                    <input type="text" name="telephone1" class="form-control form-control-border border-width-2" id="telephone1" v-model="form.telephone1">
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="zipcode1" style="line-height: 10px;">Zip Code</label>
                                    </div>
                                    <input type="text" name="zipcode1" class="form-control form-control-border border-width-2" id="zipcode1" v-model="form.zipcode1">
                                </div>
                            </div>

                            <div class="form-group" style="display: flex;">
                                <div class="col-md-4">
                                    <div>
                                        <label for="permanentaddress" style="line-height: 10px;">Permanent Address</label>
                                    </div>
                                    <input type="text" name="permanentaddress" class="form-control form-control-border border-width-2" id="permanentaddress" v-model="form.permanentaddress">
                                        <span>
                                            <strong class="text-danger" v-if="errors.has('permanentaddress')">Field Required</strong>
                                        </span>
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="telephone2" style="line-height: 10px;">Telephone</label>
                                    </div>
                                    <input type="text" name="telephone2" class="form-control form-control-border border-width-2" id="telephone2" v-model="form.telephone2">
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="zipcode2" style="line-height: 10px;">Zip Code</label>
                                    </div>
                                    <input type="text" name="zipcode2" class="form-control form-control-border border-width-2" id="zipcode2" v-model="form.zipcode2">
                                </div>
                            </div>

                            <div class="form-group" style="display: flex;">
                                <div class="col-md-4">
                                    <div>
                                        <label for="cellphone" style="line-height: 10px;">Mobile Number</label>
                                    </div>
                                    <input type="text" name="cellphone" class="form-control form-control-border border-width-2" id="cellphone" v-model="form.cellphone">
                                        <span>
                                            <strong class="text-danger" v-if="errors.has('cellphone')">Field Required</strong>
                                        </span>
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="email" style="line-height: 10px;">Email</label>
                                    </div>
                                    <input type="email" name="email" class="form-control form-control-border border-width-2" id="email" v-model="form.email">
                                </div>
                            </div>
                        </tab-content>

                        <tab-content title="Family Background" icon="ti-star">
                            <div class="row">
                                <div class="col-md-6 float-left" style="padding: 0px;">
                                    <div class="form-group input-group" style="display: flex;">
                                        <div class="col-md-12 text-center">
                                            <h4>Spouse</h4>
                                            <hr>
                                        </div>
                                        <hr>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="spouseSurname" style="line-height: 10px;">Surname</label>
                                            </div>
                                            <input type="text" name="spouseSurname" class="form-control form-control-border border-width-2" id="spouseSurname" v-model="form.familybackground.spouseSurname">
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="spouseFirstname" style="line-height: 10px;">Firstname</label>
                                            </div>
                                            <input type="text" name="spouseFirstname" class="form-control form-control-border border-width-2" id="spouseFirstname" v-model="form.familybackground.spouseFirstname">
                                        </div>
                                    </div>

                                    <div class="form-group input-group" style="display: flex;">
                                        <div class="col-md-6">
                                            <div>
                                                <label for="spouseMiddlename" style="line-height: 10px;">Middlename</label>
                                            </div>
                                            <input type="text" name="spouseMiddlename" class="form-control form-control-border border-width-2" id="spouseMiddlename" v-model="form.familybackground.spouseMiddlename">
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="spouseOccupation" style="line-height: 10px;">Occupation</label>
                                            </div>
                                            <input type="text" name="spouseOccupation" class="form-control form-control-border border-width-2" id="spouseOccupation" v-model="form.familybackground.spouseOccupation">
                                        </div>
                                    </div>

                                    <div class="form-group input-group" style="display: flex;">
                                        <div class="col-md-6">
                                            <div>
                                                <label for="spouseBussiness" style="line-height: 10px;">Bussiness</label>
                                            </div>
                                            <input type="text" name="spouseBussiness" class="form-control form-control-border border-width-2" id="spouseBussiness" v-model="form.familybackground.spouseBussiness">
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="spouseBussinessAddress" style="line-height: 10px;">Bussiness Address</label>
                                            </div>
                                            <input type="text" name="spouseBussinessAddress" class="form-control form-control-border border-width-2" id="spouseBussinessAddress" v-model="form.familybackground.spouseBussinessAddress">
                                        </div>
                                    </div>

                                    <div class="form-group input-group" style="display: flex;">
                                        <div class="col-md-6">
                                            <div>
                                                <label for="spouseTelephone" style="line-height: 10px;">Telephone</label>
                                            </div>
                                            <input type="text" name="spouseTelephone" class="form-control form-control-border border-width-2" id="spouseTelephone" v-model="form.familybackground.spouseTelephone">
                                        </div>
                                    </div>

                                    <div class="form-group input-group" style="display: flex;">
                                        <div class="col-md-12 text-center">
                                            <h4>Father</h4>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="fatherSurname" style="line-height: 10px;">Surname</label>
                                            </div>
                                            <input type="text" name="fatherSurname" class="form-control form-control-border border-width-2" id="fatherSurname" v-model="form.familybackground.fatherSurname">
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="fatherFirstname" style="line-height: 10px;">Firstname</label>
                                            </div>
                                            <input type="text" name="fatherFirstname" class="form-control form-control-border border-width-2" id="fatherFirstname" v-model="form.familybackground.fatherFirstname">
                                        </div>
                                    </div>

                                    <div class="form-group input-group" style="display: flex;">
                                        <div class="col-md-6">
                                            <div>
                                                <label for="fatherMiddlename" style="line-height: 10px;">Middlename</label>
                                            </div>
                                            <input type="text" name="fatherMiddlename" class="form-control form-control-border border-width-2" id="fatherMiddlename" v-model="form.familybackground.fatherMiddlename">
                                        </div>
                                    </div>

                                    <div class="form-group input-group" style="display: flex;">
                                        <div class="col-md-12 text-center">
                                            <h4>Mother</h4>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="motherSurname" style="line-height: 10px;">Surname</label>
                                            </div>
                                            <input type="text" name="motherSurname" class="form-control form-control-border border-width-2" id="motherSurname" v-model="form.familybackground.motherSurname">
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="motherFirstname" style="line-height: 10px;">Firstname</label>
                                            </div>
                                            <input type="text" name="motherFirstname" class="form-control form-control-border border-width-2" id="motherFirstname" v-model="form.familybackground.motherFirstname">
                                        </div>
                                    </div>

                                    <div class="form-group input-group" style="display: flex;">
                                        <div class="col-md-6">
                                            <div>
                                                <label for="motherMiddlename" style="line-height: 10px;">Middlename</label>
                                            </div>
                                            <input type="text" name="motherMiddlename" class="form-control form-control-border border-width-2" id="motherMiddlename" v-model="form.familybackground.motherMiddlename">
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="motherMaidenName" style="line-height: 10px;">Maiden Name</label>
                                            </div>
                                            <input type="text" name="motherMaidenName" class="form-control form-control-border border-width-2" id="motherMaidenName" v-model="form.familybackground.motherMaidenName">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 float-right" style="padding: 0px;">
                                    <div class="col-md-12 text-center">
                                        <h4>Children</h4>
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-borderless no-datatable" id="child-tbl">
                                            <thead>
                                                <tr>
                                                <th scope="col" style="padding: 0px 0px 0px 10px; line-height: 16px;">Name of Child</th>
                                                <th scope="col" style="padding: 0px 0px 0px 10px; line-height: 16px;">Date Of Birth</th>
                                                <th scope="col" style="padding: 0px 0px 0px 10px; line-height: 16px;">
                                                    <a type="button" class="btn btn-primary btn-sm" name="add" id="add-btn" @click.prevent="addFields('children')"><i class="fas fa-plus"></i></a>
                                                </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(child, index) in form.children" :key="child.id">
                                                    <td>
                                                        <div class="form-group input-group">
                                                            <input type="text" :name="'name'+index" :id="'name'+index" class="form-control form-control-border border-width-2" v-model="child.name">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="form-group input-group">
                                                            <input type="date" :name="'birthday'+index" :id="'birthday'+index" class="form-control form-control-border border-width-2" v-model="child.birthday">
                                                            <!-- <date-picker v-model="child.birthday" id="birthday" :config="options" class="form-control form-control-border border-width-2" placeholder="yyyy-mm-dd"></date-picker> -->
                                                        </div>
                                                    </td>


                                                    <td style="vertical-align: middle;">
                                                        <div class="form-group input-group">
                                                            <a type="button" class="btn btn-danger remove-tr btn-sm" @click.prevent="deleteFields('children', index)"><i class="fas fa-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </tab-content>

                        <tab-content title="Educational Background" icon="ti-envelope">
                            <div class="row">
                                <table class="table table-md table-borderless table-responsive no-datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-center" scope="col" style="width: 1%;">Level</th>
                                            <th class="text-center" scope="col" style="width: 20%">Name Of School</th>
                                            <th class="text-center" scope="col" style="width: 10%">Degree Course</th>
                                            <th class="text-center" scope="col" style="width: 10%">Year Graduated</th>
                                            <th class="text-center" scope="col" style="width: 10%">Highest Grade/Units Earned</th>
                                            <th class="text-center" scope="col" style="width: 10%">From</th>
                                            <th class="text-center" scope="col" style="width: 10%">To</th>
                                            <th class="text-center" scope="col" style="width: 10%">Scholarship/ Academic Honors Received</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Elementary: </th>
                                            <td>
                                                <input type="text" name="elemSchoolName" id="elemSchoolName" class="form-control form-control-border border-width-2" v-model="form.educationalbackground.elemSchoolName">
                                            </td>

                                            <td>
                                                <input type="text" name="elemDegree" class="form-control form-control-border border-width-2" id="elemDegree" v-model="form.educationalbackground.elemDegree">
                                            </td>

                                            <td>
                                                <input type="number" name="elemYear" class="form-control form-control-border border-width-2" id="elemYear" v-model="form.educationalbackground.elemYear">
                                            </td>

                                            <td>
                                                <input type="text" name="elemHighestLevel" class="form-control form-control-border border-width-2" id="elemHighestLevel" v-model="form.educationalbackground.elemHighestLevel">
                                            </td>

                                            <td>
                                                <input type="text" name="elemFrom" class="form-control form-control-border border-width-2" id="elemFrom" v-model="form.educationalbackground.elemFrom">
                                            </td>

                                            <td>
                                                <input type="text" name="elemTo" class="form-control form-control-border border-width-2" id="elemTo" v-model="form.educationalbackground.elemTo">
                                            </td>

                                            <td>
                                                <input type="text" name="elemSOA" class="form-control form-control-border border-width-2" id="elemSOA" v-model="form.educationalbackground.elemSOA">
                                            </td>
                                        </tr>

                                        <tr>

                                            <th>Secondary: </th>

                                            <td>
                                                <input type="text" name="secSchoolName" id="secSchoolName" class="form-control form-control-border border-width-2" v-model="form.educationalbackground.secSchoolName">
                                            </td>

                                            <td>
                                                <input type="text" name="secDegree" class="form-control form-control-border border-width-2" id="secDegree" v-model="form.educationalbackground.secDegree">
                                            </td>

                                            <td>
                                                <input type="number" name="secYear" class="form-control form-control-border border-width-2" id="secYear" v-model="form.educationalbackground.secYear">
                                            </td>

                                            <td>
                                                <input type="text" name="secHighestLevel" class="form-control form-control-border border-width-2" id="secHighestLevel" v-model="form.educationalbackground.secHighestLevel">
                                            </td>

                                            <td>
                                                <input type="text" name="secFrom" class="form-control form-control-border border-width-2" id="secFrom" v-model="form.educationalbackground.secFrom">
                                            </td>

                                            <td>
                                                <input type="text" name="SecTo" class="form-control form-control-border border-width-2" id="SecTo" v-model="form.educationalbackground.secTo">
                                            </td>

                                            <td>
                                                <input type="text" name="secSOA" class="form-control form-control-border border-width-2" id="secSOA" v-model="form.educationalbackground.secSOA">
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Vocational: </th>

                                            <td>
                                                <input type="text" name="vocSchoolName" id="vocSchoolName" class="form-control form-control-border border-width-2" v-model="form.educationalbackground.vocSchoolName">
                                            </td>

                                            <td>
                                                <input type="text" name="vocDegree" class="form-control form-control-border border-width-2" id="vocDegree" v-model="form.educationalbackground.vocDegree">
                                            </td>

                                            <td>
                                                <input type="number" name="vocYear" class="form-control form-control-border border-width-2" id="vocYear" v-model="form.educationalbackground.vocYear">
                                            </td>

                                            <td>
                                                <input type="text" name="vocHighestLevel" class="form-control form-control-border border-width-2" id="vocHighestLevel" v-model="form.educationalbackground.vocHighestLevel">
                                            </td>

                                            <td>
                                                <input type="text" name="vocFrom" class="form-control form-control-border border-width-2" id="vocFrom" v-model="form.educationalbackground.vocFrom">
                                            </td>

                                            <td>
                                                <input type="text" name="vocTo" class="form-control form-control-border border-width-2" id="vocTo" v-model="form.educationalbackground.vocTo">
                                            </td>

                                            <td>
                                                <input type="text" name="vocSOA" class="form-control form-control-border border-width-2" id="vocSOA" v-model="form.educationalbackground.vocSOA">
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>College: </th>

                                            <td>
                                                <input type="text" name="collSchoolName1" id="collSchoolName1" class="form-control form-control-border border-width-2" v-model="form.educationalbackground.collSchoolName1">
                                            </td>

                                            <td>
                                                <input type="text" name="collDegree1" class="form-control form-control-border border-width-2" id="collDegree1" v-model="form.educationalbackground.collDegree1">
                                            </td>

                                            <td>
                                                <input type="number" name="collYear1" class="form-control form-control-border border-width-2" id="collYear1" v-model="form.educationalbackground.collYear1">
                                            </td>

                                            <td>
                                                <input type="text" name="collHighestLevel1" class="form-control form-control-border border-width-2" id="collHighestLevel1" v-model="form.educationalbackground.collHighestLevel1">
                                            </td>

                                            <td>
                                                <input type="text" name="collFrom1" class="form-control form-control-border border-width-2" id="collFrom1" v-model="form.educationalbackground.collFrom1">
                                            </td>

                                            <td>
                                                <input type="text" name="collTo1" class="form-control form-control-border border-width-2" id="collTo1" v-model="form.educationalbackground.collTo1">
                                            </td>

                                            <td>
                                                <input type="text" name="collSOA1" class="form-control form-control-border border-width-2" id="collSOA1" v-model="form.educationalbackground.collSOA1">
                                            </td>
                                        </tr>

                                        <tr>
                                            <th></th>

                                            <td>
                                                <input type="text" name="collSchoolName2" id="collSchoolName2" class="form-control form-control-border border-width-2" v-model="form.educationalbackground.collSchoolName2">
                                            </td>

                                            <td>
                                                <input type="text" name="collDegree2" class="form-control form-control-border border-width-2" id="collDegree2" v-model="form.educationalbackground.collDegree2">
                                            </td>

                                            <td>
                                                <input type="number" name="collYear2" class="form-control form-control-border border-width-2" id="collYear2" v-model="form.educationalbackground.collYear2">
                                            </td>

                                            <td>
                                                <input type="text" name="collHighestLevel2" class="form-control form-control-border border-width-2" id="collHighestLevel2" v-model="form.educationalbackground.collHighestLevel2">
                                            </td>

                                            <td>
                                                <input type="text" name="collFrom2" class="form-control form-control-border border-width-2" id="collFrom2" v-model="form.educationalbackground.collFrom2">
                                            </td>

                                            <td>
                                                <input type="text" name="collTo2" class="form-control form-control-border border-width-2" id="collTo2" v-model="form.educationalbackground.collTo2">
                                            </td>

                                            <td>
                                                <input type="text" name="collSOA2" class="form-control form-control-border border-width-2" id="collSOA2" v-model="form.educationalbackground.collSOA2">
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Graduate Studies: </th>

                                            <td>
                                                <input type="text" name="gradSchoolName" id="gradSchoolName" class="form-control form-control-border border-width-2" v-model="form.educationalbackground.gradSchoolName">
                                            </td>

                                            <td>
                                                <input type="text" name="gradDegree" class="form-control form-control-border border-width-2" id="gradDegree" v-model="form.educationalbackground.gradDegree">
                                            </td>

                                            <td>
                                                <input type="number" name="gradYear" class="form-control form-control-border border-width-2" id="gradYear" v-model="form.educationalbackground.gradYear">
                                            </td>

                                            <td>
                                                <input type="text" name="gradHighestLevel" class="form-control form-control-border border-width-2" id="gradHighestLevel" v-model="form.educationalbackground.gradHighestLevel">
                                            </td>

                                            <td>
                                                <input type="text" name="gradFrom" class="form-control form-control-border border-width-2" id="gradFrom" v-model="form.educationalbackground.gradFrom">
                                            </td>

                                            <td>
                                                <input type="text" name="gradTo" class="form-control form-control-border border-width-2" id="gradTo" v-model="form.educationalbackground.gradTo">
                                            </td>

                                            <td>
                                                <input type="text" name="gradSOA" class="form-control form-control-border border-width-2" id="gradSOA" v-model="form.educationalbackground.gradSOA">
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </tab-content>

                        <tab-content title="Civil Service Eligibility" icon="ti-folder">
                            <div class="row">
                                <table class="table table-responsive table-borderless table-sm no-datatable" id="eligibility-tbl">
                                    <thead>
                                        <tr>
                                        <th scope="col" class="text-center" style="width: 25%">CAREER SERVICE/Board/BAR/CES/CSEE</th>
                                        <th scope="col" class="text-center" style="width: 10%">Rating</th>
                                        <th scope="col" class="text-center" style="width: 10%">Date of Examination / Conferement</th>
                                        <th scope="col" class="text-center" style="width: 25%">Place Of Examination</th>
                                        <th scope="col" class="text-center" style="width: 10%">License Number (if applicable)</th>
                                        <th scope="col" class="text-center" style="width: 10%">Date of Release</th>
                                        <th scope="col" class="text-center" style="width: 5%;">
                                            <a type="button" class="btn btn-primary btn-sm" id="add-eli"  @click.prevent="addFields('eligibility')"><i class="fas fa-plus"></i></a>
                                        </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(eligibility, index) in form.eligibilities" :key="eligibility.id">
                                            <td>
                                                <div class="form-group input-group-sm">
                                                    <input type="text" :name="'careerService'+index" :id="'careerService'+index" class="form-control form-control-border border-width-2" v-model="eligibility.careerService">
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-group input-group-sm">
                                                    <input type="text" :name="'rating'+index" :id="'rating'+index" class="form-control form-control-border border-width-2" v-model="eligibility.rating">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group input-group-sm">
                                                    <input type="date" :name="'dateOfExam'+index" :id="'dateOfExam'+index" class="form-control form-control-border border-width-2" v-model="eligibility.dateOfExam">
                                                    <!-- <date-picker v-model="eligibility.dateOfExam" id="dateOfExam" :config="options" class="form-control form-control-border border-width-2" placeholder="yyyy-mm-dd"></date-picker> -->
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-group input-group-sm">
                                                    <input type="text" :name="'placeOfExam'+index" :id="'placeOfExam'+index" class="form-control form-control-border border-width-2" v-model="eligibility.placeOfExam">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group input-group-sm">
                                                    <input type="text" :name="'licenseNumber'+index" :id="'licenseNumber'+index" class="form-control form-control-border border-width-2" v-model="eligibility.licenseNumber">
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-group input-group-sm">
                                                    <input type="text" :name="'licenseRelease'+index" :id="'licenseRelease'+index" class="form-control form-control-border border-width-2" v-model="eligibility.licenseRelease">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group input-group-sm" style="text-align: center; line-height: 16px;">
                                                    <a type="button" class="btn btn-danger remove-tr btn-sm" @click.prevent="deleteFields('eligibility' ,index)"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </tab-content>

                        <tab-content title="Work Experience" icon="ti-briefcase">
                            <div class="row">
                                <table class="table table-responsive table-borderless table-sm no-datatable" id="workex_tbl">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center" style="width: 10%">From</th>
                                            <th scope="col" class="text-center" style="width: 10%">To</th>
                                            <th scope="col" class="text-center" style="width: 20%">Position Title</th>
                                            <th scope="col" class="text-center" style="width: 20%">Department / Agency / Office</th>
                                            <th scope="col" class="text-center" style="width: 10%">Monthly Salary</th>
                                            <th scope="col" class="text-center" style="width: 10%">Salary Grade & Step</th>
                                            <th scope="col" class="text-center" style="width: 10%">Status Appointment</th>
                                            <th scope="col" class="text-center" style="width: 10%">Gov't Service (YES/NO)</th>
                                            <th scope="col" class="text-center" style="width: 5%;">
                                                <a type="button" class="btn btn-primary btn-sm" id="add-workex" @click.prevent="addFields('workexperience')"><i class="fas fa-plus"></i></a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(workexperience, index) in form.workexperiences" :key="workexperience.id">
                                            <td>
                                                <div class="form-group input-group-sm">
                                                    <input type="date" :name="'we_inclusiveDateFrom'+index" :id="'we_inclusiveDateFrom'+index" class="form-control form-control-border border-width-2" v-model="workexperience.inclusiveDateFrom">
                                                    <!-- <date-picker v-model="workexperience.inclusiveDateFrom" id="we_inclusiveDateFrom" :config="options" class="form-control form-control-border border-width-2" placeholder="yyyy-mm-dd"></date-picker> -->
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-group input-group-sm">
                                                    <input type="date" :name="'we_inclusiveDateTo'+index" :id="'we_inclusiveDateTo'+index" class="form-control form-control-border border-width-2" v-model="workexperience.inclusiveDateTo">
                                                    <!-- <date-picker v-model="workexperience.inclusiveDateTo" id="we_inclusiveDateTo" :config="options" class="form-control form-control-border border-width-2" placeholder="yyyy-mm-dd"></date-picker> -->
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-group input-group-sm">
                                                    <input type="text" :name="'we_position'+index" :id="'we_position'+index" class="form-control form-control-border border-width-2" v-model="workexperience.position">
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-group input-group-sm">
                                                    <input type="text" :name="'department'+index" :id="'department'+index" class="form-control form-control-border border-width-2" v-model="workexperience.department">
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-group input-group-sm">
                                                    <input type="text" :name="'monthlySalary'+index" :id="'monthlySalary'+index" class="form-control form-control-border border-width-2" v-model="workexperience.monthlySalary">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group input-group-sm">
                                                    <input type="text" :name="'salaryGrade'+index" :id="'salaryGrade'+index" class="form-control form-control-border border-width-2" v-model="workexperience.salaryGrade">
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-group input-group-sm">
                                                    <input type="text" :name="'statusOfAppointment'+index" :id="'statusOfAppointment'+index" class="form-control form-control-border border-width-2" v-model="workexperience.statusOfAppointment">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group input-group-sm">
                                                    <select :name="'govService'+index" :id="'govService'+index" class="form-control form-control-border border-width-2" v-model="workexperience.govService">
                                                        <option>YES</option>
                                                        <option>NO</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group input-group-sm" style="text-align: center;">
                                                    <a type="button" class="btn btn-danger remove-tr btn-sm" @click.prevent="deleteFields('workexperience', index)"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </tab-content>

                        <tab-content title="Voluntary Works" icon="ti-heart">
                            <table class="table table-responsive table-borderless table-sm no-datatable" id="volwork-tbl">
                                <thead>
                                    <tr>
                                    <th scope="col" class="text-center" style="width: 25%">Name and Address of Organization</th>
                                    <th scope="col" class="text-center" style="width: 10%">From</th>
                                    <th scope="col" class="text-center" style="width: 10%">To</th>
                                    <th scope="col" class="text-center" style="width: 25%">Number Of Hours</th>
                                    <th scope="col" class="text-center" style="width: 30%">Position / Nature of Work</th>
                                    <th scope="col" class="text-center" style="width: 5%">
                                        <a type="button" class="btn btn-primary btn-sm" name="add" id="add-volwork" @click.prevent="addFields('voluntaryworks')"><i class="fas fa-plus"></i></a>
                                    </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(voluntarywork, index) in form.voluntaryworks" :key="voluntarywork.id">
                                        <td>
                                            <div class="form-group input-group-sm">
                                                <input type="text" :name="'nameAndAddress'+index" :id="'nameAndAddress'+index" class="form-control form-control-border border-width-2" v-model="voluntarywork.nameAndAddress">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group input-group-sm">
                                                <input type="date" :name="'vw_inclusiveDateFrom'+index" :id="'vw_inclusiveDateFrom'+index" class="form-control form-control-border border-width-2" v-model="voluntarywork.inclusiveDateFrom">
                                                <!-- <date-picker v-model="voluntarywork.inclusiveDateFrom" id="vw_inclusiveDateFrom" :config="options" class="form-control form-control-border border-width-2" placeholder="yyyy-mm-dd"></date-picker> -->
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group input-group-sm">
                                                <input type="date" :name="'vw_inclusiveDateTo'+index" :id="'vw_inclusiveDateTo'+index" class="form-control form-control-border border-width-2" v-model="voluntarywork.inclusiveDateTo">
                                                <!-- <date-picker v-model="voluntarywork.inclusiveDateFrom" id="vw_inclusiveDateTo" :config="options" class="form-control form-control-border border-width-2" placeholder="yyyy-mm-dd"></date-picker> -->
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group input-group-sm">
                                                <input type="text" :name="'vw_hours'+index" :id="'vw_hours'+index" class="form-control form-control-border border-width-2" v-model="voluntarywork.hours">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group input-group-sm">
                                                <input type="text" :name="'vw_position'+index" :id="'vw_position'+index" class="form-control form-control-border border-width-2" v-model="voluntarywork.position">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group input-group-sm" style="text-align: center; display: grid;">
                                                <a type="button" class="btn btn-danger remove-tr btn-sm" @click.prevent="deleteFields('voluntaryworks', index)"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </tab-content>

                        <tab-content title="Training Programs" icon="ti-book">
                            <table class="table table-responsive table-borderless table-sm no-datatable" id="learnanddev-tbl">
                                <thead>
                                    <tr>
                                    <th scope="col" class="text-center" style="width: 30%">Title of Learning and Development Interventions / Training Programs</th>
                                    <th scope="col" class="text-center" style="width: 10%">From</th>
                                    <th scope="col" class="text-center" style="width: 10%">To</th>
                                    <th scope="col" class="text-center" style="width: 10%">Number of Hours</th>
                                    <th scope="col" class="text-center" style="width: 30%">Conducted / Sponsored By</th>
                                    <th scope="col" class="text-center" style="width: 5%">
                                        <button type="button" class="btn btn-primary btn-sm" name="add" id="add-learn" @click.prevent="addFields('trainingprograms')"><i class="fas fa-plus"></i></button>
                                    </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(trainingprogram, index) in form.trainingprograms" :key="trainingprogram.id">
                                        <td>
                                            <div class="form-group input-group-sm">
                                                <input type="text" :name="'title'+index" :id="'title'+index" class="form-control form-control-border border-width-2" v-model="trainingprogram.title">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group input-group-sm">
                                                <input type="date" :name="'tp_inclusiveDateFrom'+index" :id="'tp_inclusiveDateFrom'+index" class="form-control form-control-border border-width-2" v-model="trainingprogram.inclusiveDateFrom">
                                                <!-- <date-picker v-model="trainingprogram.inclusiveDateFrom" id="tp_inclusiveDateFrom" :config="options" class="form-control form-control-border border-width-2" placeholder="yyyy-mm-dd"></date-picker> -->
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group input-group-sm">
                                                <input type="date" :name="'tp_inclusiveDateTo'+index" :id="'tp_inclusiveDateTo'+index" class="form-control form-control-border border-width-2" v-model="trainingprogram.inclusiveDateTo">
                                                <!-- <date-picker v-model="trainingprogram.inclusiveDateTo" id="tp_inclusiveDateTo" :config="options" class="form-control form-control-border border-width-2" placeholder="yyyy-mm-dd"></date-picker> -->
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group input-group-sm">
                                                <input type="number" :name="'tp_hours'+index" :id="'tp_hours'+index" class="form-control form-control-border border-width-2" v-model="trainingprogram.hours">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group input-group-sm">
                                                <input type="text" :name="'conductor'+index" :id="'conductor'+index" class="form-control form-control-border border-width-2" v-model="trainingprogram.conductor">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group input-group-sm" style="text-align: center;">
                                                <button type="button" class="btn btn-danger remove-tr btn-sm" @click.prevent="deleteFields('trainingprograms', index)"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </tab-content>

                        <tab-content title="Other Information" icon="ti-clipboard">
                            <table class="table table-responsive table-borderless table-sm no-datatable" id="otherinfo-tbl">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" style="width: 20%">Specail Skill and Hobby</th>
                                        <th scope="col" class="text-center" style="width: 50%">Non-Academic Distinctions / Recognition</th>
                                        <th scope="col" class="text-center" style="width: 20%">Membership in Association / Organization</th>
                                        <th scope="col" class="text-center" style="width: 5%">
                                            <a type="button" class="btn btn-primary btn-sm" name="add" id="add-otherinfo" @click.prevent="addFields('otherinfos')"><i class="fas fa-plus"></i></a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(otherinfo, index) in form.otherinfos" :key="otherinfo.id">
                                        <td>
                                            <div class="form-group input-group-sm">
                                                <input type="text" :name="'skill'+index" :id="'skill'+index" class="form-control form-control-border border-width-2" v-model="otherinfo.skill">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group input-group-sm">
                                                <input type="text" :name="'recognition'+index" :id="'recognition'+index" class="form-control form-control-border border-width-2" v-model="otherinfo.recognition">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group input-group-sm">
                                                <input type="text" :name="'membership'+index" :id="'membership'+index" class="form-control form-control-border border-width-2" v-model="otherinfo.membership">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group input-group-sm" style="text-align: center;">
                                                <a type="button" class="btn btn-danger remove-tr btn-sm" @click.prevent="deleteFields('otherinfos', index)"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </tab-content>

                        <tab-content title="Questions" icon="ti-check-box">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6" style="display: flex;">
                                        <strong for="" style="margin-right: 10px;">34.</strong>
                                        <p>
                                            Are you related by consanguinity or affinity to the appointing or recommending authority, or to the
                                            chief of bureau or office or to the person who has immediate supervision over you in the Office,
                                            Bureau or Department where you will be apppointed,
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7">
                                        <p style="margin-left: 30px;"> a. within the third degree?</p>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="q34a" style="margin-right: 50%;">
                                                <input class="q34a_yes" name="q34a_yes" id="q34a_yes" type="radio" value="YES" v-model="form.pdsquestion.q34a">
                                                YES
                                            </label>

                                            <label for="q34a">
                                                <input class="q34a_no" name="q34a_no" id="q34a_no" type="radio" value="NO" v-model="form.pdsquestion.q34a">
                                                NO
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7">
                                        <p style="margin-left: 30px;">b. within the fourth degree (for Local Government Unit - Career Employees)?</p>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="q34b" style="margin-right: 50%;">
                                                <input class="q34b_yes" name="q34b_yes" id="q34b_yes" type="radio" value="YES" v-model="form.pdsquestion.q34b">
                                                YES
                                            </label>

                                            <label for="q34b">
                                                <input class="q34b_no" name="q34b_no" id="q34b_no" type="radio" value="NO" v-model="form.pdsquestion.q34b">
                                                NO
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7">

                                    </div>
                                    <div class="col-md-5">
                                        <label for="q34bdetails">If YES give details:</label>
                                        <input type="text" name="q34bdetails" class="form-control form-control-border border-width-2" id="q34bdetails" v-model="form.pdsquestion.q34bdetails">
                                    </div>
                                </div>

                                <hr>

                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7" style="display: flex;">
                                        <strong for="" style="margin-right: 10px;">35.</strong>
                                        <p>
                                            a. Have you ever been found guilty of any administrative offense?
                                        </p>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="q35a_yes" style="margin-right: 50%;">
                                            <input type="radio" class="q35a_yes" name="q35a_yes" id="q35a_yes" value="YES" v-model="form.pdsquestion.q35a">
                                            YES
                                        </label>

                                        <label for="q35a">
                                            <input type="radio" class="q35a_no" name="q35a_no" id="q35a_no" value="NO" v-model="form.pdsquestion.q35a">
                                            NO
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3" style="display: flex;">
                                    <div class="col-md-7">

                                    </div>
                                    <div class="col-md-5">
                                        <label for="q35adetails">If YES give details:</label>
                                        <input type="text" name="q35adetails" class="form-control form-control-border border-width-2" id="q35adetails" v-model="form.pdsquestion.q35adetails">
                                    </div>
                                </div>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7" style="display: flex;">
                                        <strong></strong>
                                        <p style="margin-left: 30px;">
                                            b. Have you been criminally charged before any court?
                                        </p>
                                    </div>

                                    <div class="col-md-5">
                                        <label for="q35b" style="margin-right: 50%;">
                                            <input type="radio" class="q35b_yes" name="q35b_yes" id="q35b_yes" value="YES" v-model="form.pdsquestion.q35b">
                                            YES
                                        </label>

                                        <label for="q35b">
                                            <input type="radio" class="q35b_no" name="q35b_no" id="q35b_no" value="NO" v-model="form.pdsquestion.q35b">
                                            NO
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7">

                                    </div>
                                    <div class="col-md-2">
                                        <label for="q35bdatefiled">Date Filed:</label>
                                        <input type="date" name="q35bdatefiled" class="form-control form-control-border border-width-2" id="q35bdatefiled" v-model="form.pdsquestion.q35bdatefiled">
                                        <!-- <date-picker v-model="form.pdsquestion.q35bdatefiled" id="q35bdatefiled" :config="options" class="form-control form-control-border border-width-2" placeholder="yyyy-mm-dd"></date-picker> -->
                                    </div>
                                    <div class="col-md-3">
                                        <label for="q35bcasestatus">Status of Case/s:</label>
                                        <input type="text" name="q35bcasestatus" class="form-control form-control-border border-width-2" id="q35bcasestatus" v-model="form.pdsquestion.q35bcasestatus">
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7" style="display: flex;">
                                        <strong style="margin-right: 10px;">36.</strong>
                                        <p>
                                            Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?
                                        </p>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="q36a" style="margin-right: 50%;">
                                            <input type="radio" class="q36a_yes" name="q36a_yes" id="q36a_yes" value="YES" v-model="form.pdsquestion.q36a">
                                            YES
                                        </label>

                                        <label for="q36a">
                                            <input type="radio" class="q36a_no" name="q36a_no" id="q36a_no" value="NO" v-model="form.pdsquestion.q36a">
                                            NO
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7">

                                    </div>
                                    <div class="col-md-5">
                                        <label for="q36adetails">If YES give details:</label>
                                        <input type="text" name="q36adetails" class="form-control form-control-border border-width-2" id="q36adetails" v-model="form.pdsquestion.q36adetails">
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7" style="display: flex;">
                                        <strong style="margin-right: 10px;">37.</strong>
                                        <p>
                                            Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls,
                                            dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?
                                        </p>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="q37a" style="margin-right: 50%;">
                                            <input type="radio" class="q37a_yes" name="q37a_yes" id="q37a_yes" value="YES" v-model="form.pdsquestion.q37a">
                                            YES
                                        </label>

                                        <label for="q37a">
                                            <input type="radio" class="q37a_no" name="q37a_no" id="q37a_no" value="NO" v-model="form.pdsquestion.q37a">
                                            NO
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7">

                                    </div>
                                    <div class="col-md-5">
                                        <label for="q37adetails">If YES give details</label>
                                        <input type="text" name="q37adetails" class="form-control form-control-border border-width-2" id="q37adetails"  v-model="form.pdsquestion.q37adetails">
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7" style="display: flex;">
                                        <strong style="margin-right: 10px;">38.</strong>
                                        <p>
                                            a. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?
                                        </p>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="q38a" style="margin-right: 50%;">
                                            <input type="radio" class="q38a_yes" name="q38a_yes" id="q38a_yes" value="YES" v-model="form.pdsquestion.q38a">
                                            YES
                                        </label>

                                        <label for="q38a">
                                            <input type="radio" class="q38a_no" name="q38a_no" id="q38a_no" value="NO" v-model="form.pdsquestion.q38a">
                                            NO
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7">

                                    </div>
                                    <div class="col-md-5 mb-3">
                                        <label for="q38adetails">If YES give details:</label>
                                        <input type="text" name="q38adetails" class="form-control form-control-border border-width-2" id="q38adetails" v-model="form.pdsquestion.q38adetails">
                                    </div>
                                </div>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7">
                                        <p style="margin-left: 30px;">
                                            b. Have you resigned from the government service during the three
                                            (3)-month period before the last election to promote/actively campaign for a national or local candidate?
                                        </p>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="q38b" style="margin-right: 50%;">
                                            <input type="radio" class="q38b_yes" name="q38b_yes" id="q38b_yes" value="YES" v-model="form.pdsquestion.q38b">
                                            YES
                                        </label>

                                        <label for="q38b">
                                            <input type="radio" class="q38b_no" name="q38b_no" id="q38b_no" value="NO" v-model="form.pdsquestion.q38b">
                                            NO
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7">

                                    </div>
                                    <div class="col-md-5">
                                        <label for="q38bdetails">If YES give details:</label>
                                        <input type="text" name="q38bdetails" class="form-control form-control-border border-width-2" id="q38bdetails" v-model="form.pdsquestion.q38bdetails">
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7" style="display: flex;">
                                        <strong style="margin-right: 10px;">39.</strong>
                                        <p>
                                            Have you acquired the status of an immigrant or permanent resident of another country?
                                        </p>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="q39a" style="margin-right: 50%;">
                                            <input type="radio" class="q39a_yes" name="q39a_yes" id="q39a_yes" value="YES" v-model="form.pdsquestion.q39a">
                                            YES
                                        </label>

                                        <label for="q35a">
                                            <input type="radio" class="q39a_no" name="q39a_no" id="q39a_no" value="NO" v-model="form.pdsquestion.q39a">
                                            NO
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7">

                                    </div>
                                    <div class="col-md-5">
                                        <label for="q39adetails">If YES give details:</label>
                                        <input type="text" name="q39adetails" class="form-control form-control-border border-width-2" id="q39adetails" v-model="form.pdsquestion.q39adetails">
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7" style="display: flex;">
                                        <strong style="margin-right: 10px;">40.</strong>
                                        <p>
                                            Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for
                                            Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972),
                                            please answer the following items:
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7" style="display: flex;">
                                        <p style="margin-left: 30px;">
                                            a. Are you a member of any indigenous group?
                                        </p>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="q40a" style="margin-right: 50%;">
                                            <input type="radio" class="q40a_yes" name="q40a_yes" id="q40a_yes" value="YES" v-model="form.pdsquestion.q40a">
                                            YES
                                        </label>

                                        <label for="q40a">
                                            <input type="radio" class="q40a_no" name="q40a_no" id="q40a_no" value="NO" v-model="form.pdsquestion.q40a">
                                            NO
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3" style="display: flex;">
                                    <div class="col-md-7">

                                    </div>
                                    <div class="col-md-5">
                                        <label for="q40adetails">If YES please specify:</label>
                                        <input type="text" name="q40adetails" class="form-control form-control-border border-width-2" id="q40adetails" v-model="form.pdsquestion.q40adetails">
                                    </div>
                                </div>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7" style="display: flex;">
                                        <p style="margin-left: 30px;">
                                            b. Are you a person with disability?
                                        </p>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="q40b" style="margin-right: 50%;">
                                            <input type="radio" class="q40b_yes" name="q40b_yes" id="q40b_yes" value="YES" v-model="form.pdsquestion.q40b">
                                            YES
                                        </label>

                                        <label for="q40b">
                                            <input type="radio" class="q40b_no" name="q40b_no" id="q40b_no" value="NO" v-model="form.pdsquestion.q40b">
                                            NO
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3" style="display: flex;">
                                    <div class="col-md-7">

                                    </div>
                                    <div class="col-md-5">
                                        <label for="q40bdetails">If YES, please specify ID No:</label>
                                        <input type="text" name="q40bdetails" class="form-control form-control-border border-width-2" id="q40bdetails" v-model="form.pdsquestion.q40bdetails">
                                    </div>
                                </div>
                                <div class="col-md-12" style="display: flex;">
                                    <div class="col-md-7" style="display: flex;">
                                        <p style="margin-left: 30px;">
                                            c. Are you a solo parent?
                                        </p>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="q40c" style="margin-right: 50%;">
                                            <input type="radio" class="q40c_yes" name="q40c_yes" id="q40c_yes" value="YES" v-model="form.pdsquestion.q40c">
                                            YES
                                        </label>

                                        <label for="q40c">
                                            <input type="radio" class="q40c_no" name="q40c_no" id="q40c_no" value="NO" v-model="form.pdsquestion.q40c">
                                            NO
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3" style="display: flex;">
                                    <div class="col-md-7">

                                    </div>
                                    <div class="col-md-5">
                                        <label for="q40cdetails">If YES, please specify ID No:</label>
                                        <input type="text" name="q40cdetails" id="q40cdetails" class="form-control form-control-border border-width-2" v-model="form.pdsquestion.q40cdetails">
                                    </div>
                                </div>

                            </div>
                        </tab-content>

                        <tab-content title="Last step" icon="ti-check">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>REFERENCES (Person not related by consanguinity or affinity to applicant /appointee)</h4>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-borderless table-sm no-datatable" id="otherinfo-tbl">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center" style="width: 50%">Name</th>
                                                <th scope="col" class="text-center" style="width: 25%">Address</th>
                                                <th scope="col" class="text-center" style="width: 25%">Tel Number</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-group input-group-sm">
                                                        <input type="text" name="refname1" id="refname1" class="form-control form-control-border border-width-2" v-model="form.pdsquestion.refname1">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group input-group-sm">
                                                        <input type="text" name="refaddress1" id="refaddress1" class="form-control form-control-border border-width-2" v-model="form.pdsquestion.refaddress1">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group input-group-sm">
                                                        <input type="text" name="reftelephone1" id="reftelephone1" class="form-control form-control-border border-width-2" v-model="form.pdsquestion.reftelephone1">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-group input-group-sm">
                                                        <input type="text" name="refname2" id="refname2" class="form-control form-control-border border-width-2" v-model="form.pdsquestion.refname2">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group input-group-sm">
                                                        <input type="text" name="refaddress2" id="refaddress2" class="form-control form-control-border border-width-2" v-model="form.pdsquestion.refaddress2">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group input-group-sm">
                                                        <input type="text" name="reftelephone2" id="reftelephone2" class="form-control form-control-border border-width-2" v-model="form.pdsquestion.reftelephone2">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-group input-group-sm">
                                                        <input type="text" name="refname3" id="refname3" class="form-control form-control-border border-width-2" v-model="form.pdsquestion.refname3">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group input-group-sm">
                                                        <input type="text" name="refaddress3" id="refaddress3" class="form-control form-control-border border-width-2" v-model="form.pdsquestion.refaddress3">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group input-group-sm">
                                                        <input type="text" name="reftelephone3" id="reftelephone3" class="form-control form-control-border border-width-2" v-model="form.pdsquestion.reftelephone3">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-3">
                                  <div class="col-md-12">
                                      <h4>Government Issued ID (i.e.Passport, GSIS, SSS, PRC, Driver's License, etc.)</h4>
                                      <hr>
                                  </div>
                                  <div class="col-md-12">
                                        <div class="card-body" style="display: flex;">
                                            <div class="col-md-4 text-center">
                                                <label for="govid" style="line-height: 10px;">Government Issued ID:</label>
                                                <input type="text" placeholder="" name="govid" class="form-control form-control-border border-width-2" id="govid" v-model="form.pdsquestion.govid">
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <label for="idnumber" style="line-height: 10px;">ID/License/Passport Number:</label>
                                                <input type="text" placeholder="" name="idnumber" class="form-control form-control-border border-width-2" id="idnumber" v-model="form.pdsquestion.idnumber">
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <label for="dateissued" style="line-height: 10px;">Date/Place of Issuance:</label>
                                                <input type="text" placeholder="" name="dateissued" class="form-control form-control-border border-width-2" id="dateissued" v-model="form.pdsquestion.dateissued">
                                            </div>
                                        </div>
                                  </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h4>Picture</h4>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="card-body" style="display: flex;">
                                        <div class="form-group col-md-4">
                                            <label for="picture" class="col-form-label">Picture</label>
                                                <div>
                                                    <input type="file" @change="uploadPicture" @change.prevent="reset" name="picture" ref="picture" id="picture" accept="image/jpeg, image/png">
                                                </div>
                                            </div>
                                        <div class="form-group col-md-8 text-center">
                                            <div>
                                                <img v-if="form.picture !== '' && form.picture !== null" class="result" style="behavior: url(PIE.htc); border-radius: 50%; width: 200px; height: 200px; background: grey; border: 3px solid black;" :src="getAvatar()" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tab-content>

                        <template slot="footer" slot-scope="props">
                            <div class="wizard-footer-left">
                                <wizard-button  v-if="props.activeTabIndex > 0" @click.native="props.prevTab()" :style="props.fillButtonStyle">Previous</wizard-button>
                            </div>
                            <div class="wizard-footer-right">
                                <wizard-button v-if="!props.isLastStep" @click.native="props.nextTab()" class="wizard-footer-right" :style="props.fillButtonStyle">Next</wizard-button>
                            </div>
                            <div class="wizard-footer-right mr-1">
                                <wizard-button type="submit" :style="props.fillButtonStyle">Save</wizard-button>
                            </div>
                        </template>
                    </form-wizard>
                </div>
            </div>
        </form>
    </div>

    <!-- image resize modal -->
    <div class="modal" id="image-modal" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Resize</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <clipper-fixed  class="my-clipper" :round="true" ref="clipper" preview="my-preview" :src="getAvatar()" ><div class="placeholder" slot="placeholder">No image</div></clipper-fixed>
                        </div>

                        <div class="col-md-6">
                            <clipper-preview name="my-preview" class="my-clipper">
                                <div class="placeholder" slot="placeholder">preview area</div>
                            </clipper-preview>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="getResult">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    </div>

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
            editMode: 1,
            oldData: {},
            edits: [],
            errors: new Errors(),
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
                    'status': 'Still in service',
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
    beforeRouteEnter (to, from, next) {
       if(to.query.id == null)
       {
            next()
       }
       else if(to.query.id != null && to.query.mode == 1){
            axios.get('api/edit?id='+to.query.id)
            .then(({data}) => {
                next(vm => vm.fetchData(data))
            })
            .catch(error => {
                console.log(error)
                Swal.fire(
                    'Oops...',
                    error.response.data.message,
                    'error'
                )
            })
       }
       else if(to.query.id != null && to.query.mode == 2){
            axios.get('api/editemployee?id='+to.query.id)
            .then(({data, editMode}) => {
                next(vm => vm.fetchData(data, editMode = 3))
            })
            .catch(error => {
                console.log(error)
                Swal.fire(
                    'Oops...',
                    error.response.data.message,
                    'error'
                )
            })
       }
    },
    methods:
    {
        reset: function()
        {
            $('#picture').val('');
        },
        uploadPicture:function (e) {
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file.size < 2111775) {
                reader.onloadend = (file) => {
                    // console.log('RESULT', reader.result)
                    this.form.picture = reader.result;
                    $('#image-modal').modal('show')
                }
                reader.readAsDataURL(file);
            } else {
                // this.form.avatar = null;
                this.$refs.picture.value = null;
                Swal.fire(
                    'Oops...',
                    'You are uploading a large file',
                    'error'
                )
            }
        },
        getResult: function () {
            const canvas = this.$refs.clipper.clip();
            this.form.picture = canvas.toDataURL("image/png", 1);
        },
        getAvatar: function() {
            if(this.form.picture != null)
            {
                let prefix = (this.form.picture.match(/\//) ? '' : '/storage/employee_pictures/');
                return prefix + this.form.picture;
            }
        },
        storePersonalInformation: function()
        {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will save and reset the form",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!'
                }).then((result) => {
                    if(result.isDismissed == true)
                    {
                        toast.fire({
                            icon: 'success',
                            title: 'Cancelled'
                        });
                    }else{

                        this.$Progress.start();
                        axios.post('api/personalinformation', this.form)
                        .then(respose => {
                            Swal.fire(
                                'Success',
                                'Saved successfully',
                                'success'
                            )
                            this.$Progress.finish();
                            this.form.reset()
                        })
                        .catch(error =>{
                            this.$Progress.finish();

                            this.$refs.wizard.changeTab(null, 0);

                            this.errors.record(error.response.data.errors)

                            Swal.fire(
                                'Oops...',
                                error.response.data.message,
                                'error'
                            )
                        })

                    }
            })
        },
        updatePersonalInformation: function()
        {
            this.$Progress.start();
            axios.patch('api/personalinformation/'+this.form.id, this.form)
            .then(response => {
                Swal.fire(
                    'Success',
                    'Updated successfully',
                    'success'
                )
                this.$Progress.finish();
            })
             .catch(error =>{
                this.errors.record(error.response.data.errors)
                Swal.fire(
                    'Oops...',
                    error.response.data.message,
                    'error'
                )
            })
        },
        addFields: function(data)
        {
            switch(data)
            {
                case data = 'children':
                    if(this.form.children.length < 12)
                    {
                        this.form.children.push({})
                    }else{
                        Swal.fire(
                            'Failed',
                            'Limit Reached',
                            'warning'
                        )
                    }
                break;
                case data = 'eligibility':
                    if(this.form.eligibilities.length < 7)
                    {
                        this.form.eligibilities.push({})
                    }else{
                        Swal.fire(
                            'Failed',
                            'Limit Reached',
                            'warning'
                        )
                    }
                break;
                case data = 'workexperience':
                    this.form.workexperiences.push({})
                break;
                case data = 'voluntaryworks':
                    if(this.form.voluntaryworks.length < 7)
                    {
                        this.form.voluntaryworks.push({})
                    }else{
                        Swal.fire(
                            'Failed',
                            'Limit Reached',
                            'warning'
                        )
                    }
                break;
                case data = 'trainingprograms':
                    this.form.trainingprograms.push({})
                break;
                case data = 'otherinfos':
                    if(this.form.otherinfos.length < 7)
                    {
                        this.form.otherinfos.push({})
                    }else{
                        Swal.fire(
                            'Failed',
                            'Limit Reached',
                            'warning'
                        )
                    }
                break;
            }
        },
        deleteFields: function(data, index)
        {
            let vm = this;


            switch(data)
            {
                case data = 'children':
                    if(this.editMode == 3)
                    {
                        _.each(this.form.children[index], function(value, key){
                            if(key != 'id' && key != 'personal_information_id' && key != 'created_at' && key != 'updated_at')
                            {
                                vm.edits.push({model_id: vm.form.children[index]['id'], model: 'children', field: key, oldValue: value, newValue: null, status: 'PENDING'})
                            }
                        })
                    }
                    this.form.children.splice(index, 1)
                break;
                case data = 'eligibility':
                     if(this.editMode == 3)
                    {
                        _.each(this.form.eligibility[index], function(value, key){
                            if(key != 'id' && key != 'personal_information_id' && key != 'created_at' && key != 'updated_at')
                            {
                                vm.edits.push({model_id: vm.form.eligibility[index]['id'], model: 'eligibility', field: key, oldValue: value, newValue: null, status: 'PENDING'})
                            }
                        })
                    }
                    this.form.eligibilities.splice(index, 1)
                break;
                case data = 'workexperience':
                     if(this.editMode == 3)
                    {
                        _.each(this.form.workexperience[index], function(value, key){
                            if(key != 'id' && key != 'personal_information_id' && key != 'created_at' && key != 'updated_at')
                            {
                                vm.edits.push({model_id: vm.form.workexperience[index]['id'], model: 'workexperience', field: key, oldValue: value, newValue: null, status: 'PENDING'})
                            }
                        })
                    }
                    this.form.workexperiences.splice(index, 1)
                break;
                case data = 'voluntaryworks':
                     if(this.editMode == 3)
                    {
                        _.each(this.form.voluntaryworks[index], function(value, key){
                            if(key != 'id' && key != 'personal_information_id' && key != 'created_at' && key != 'updated_at')
                            {
                                vm.edits.push({model_id: vm.form.voluntaryworks[index]['id'], model: 'voluntaryworks', field: key, oldValue: value, newValue: null, status: 'PENDING'})
                            }
                        })
                    }
                    this.form.voluntaryworks.splice(index, 1)
                break;
                case data = 'trainingprograms':
                     if(this.editMode == 3)
                    {
                        _.each(this.form.trainingprograms[index], function(value, key){
                            if(key != 'id' && key != 'personal_information_id' && key != 'created_at' && key != 'updated_at')
                            {
                                vm.edits.push({model_id: vm.form.trainingprograms[index]['id'], model: 'trainingprograms', field: key, oldValue: value, newValue: null, status: 'PENDING'})
                            }
                        })
                    }
                    this.form.trainingprograms.splice(index, 1)
                break;
                case data = 'otherinfos':
                     if(this.editMode == 3)
                    {
                        _.each(this.form.otherinfos[index], function(value, key){
                            if(key != 'id' && key != 'personal_information_id' && key != 'created_at' && key != 'updated_at')
                            {
                                vm.edits.push({model_id: vm.form.otherinfos[index]['id'], model: 'otherinfos', field: key, oldValue: value, newValue: null, status: 'PENDING'})
                            }
                        })
                    }
                    this.form.otherinfos.splice(index, 1)
                break;
            }
        },
        updateRequest: function()
        {
            this.$Progress.start();

            this.oldData['errors'] ? delete this.oldData['errors'] : ''
            this.oldData['originalData'] ? delete this.oldData['originalData'] : ''
            this.form['errors'] ? delete this.form['errors'] : ''
            this.form['originalData'] ? delete this.form['originalData'] : ''

            this.difference(this.form, this.oldData)

            axios.post('api/employeepersonalinformation?id='+this.form.id, this.edits)
             .then(response => {
                toast.fire({
                    icon: 'success',
                    title: 'Request sent successfully'
                });
                this.$Progress.finish();
            })
             .catch(error =>{
                Swal.fire(
                    'Oops...',
                    'Something went wrong',
                    'error'
                )
            })
        },

        difference: function(newValue, oldValue)
        {
            let vm = this

            _.forEach(newValue, function(value, key)
            {

                if(((value || value != '') && !(typeof(value) === "object")) && value != oldValue[key])
                {
                    vm.edits.push({model_id: oldValue['id'], model: 'personalinformation', field: key, oldValue: oldValue[key], newValue: value, status: 'PENDING'})
                }

                if((value && (typeof(value) === "object")) && !Array.isArray(value))
                {
                    for(var field in value)
                    {
                        if(value[field] != oldValue[key][field])
                        {
                            vm.edits.push({model_id: oldValue['id'] ? oldValue['id'] : '', model: key, field: field, oldValue: oldValue[key][field], newValue: value[field], status: 'PENDING'})
                        }
                    }
                }

                if((value && (typeof(value) === "object")) && Array.isArray(value))
                {
                    if(value.length > 0)
                    {
                        value.forEach(function(data, index){
                            for(var field in data)
                            {
                                if(data['id'] && data[field] != oldValue[key][index][field])
                                {
                                    vm.edits.push({model_id: data['id'], model: key, field: field, oldValue: oldValue[key][index][field], newValue: data[field], status: 'PENDING'})
                                }else if(!data['id']){
                                    vm.edits.push({model_id: key+index, model: key, field: field, oldValue: null, newValue: data[field], status: 'PENDING'})
                                }
                            }

                        })
                    }
                }

            })
        },

        fetchData: function(data, editMode)
        {
            if(editMode == 3 && editMode)
            {
                this.editMode = editMode
            }else if(!data.editMode){
                this.editMode = 2
            }


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

            this.form = data

            if(this.form.children.length == 0)
            {
                this.form.children = [{}]
            }

            if(this.form.eligibilities.length == 0)
            {
                this.form.eligibilities = [{}]
            }

            if(this.form.workexperiences.length == 0)
            {
                this.form.workexperiences = [{}]
            }

            if(this.form.voluntaryworks.length == 0)
            {
                this.form.voluntaryworks = [{}]
            }

            if(this.form.trainingprograms.length == 0)
            {
                this.form.trainingprograms = [{}]
            }

            if(this.form.otherinfos.length == 0)
            {
                this.form.otherinfos = [{}]
            }

            this.oldData = JSON.parse(JSON.stringify(data))
        },

    },
    created()
    {

    },
    mounted()
    {
        this.$refs.wizard.activateAll();
    }

}
</script>
