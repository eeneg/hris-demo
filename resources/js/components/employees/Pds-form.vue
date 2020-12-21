<template>

<div class="row justify-content-center">
    <div class="col-md-12">

        <form @submit.prevent="editMode == false ? storePersonalInformation() : updatePersonalInformation()" action="" id="pdsForm" @keydown="errors.clear($event.target.name)">
            <div class="row">
                <div class="flex col-md-12 p-0">
                    <div class="form-group  col-md-3 float-right">
                        <label for="status">Employment Status</label>
                        <select name="status" id="status" class="form-control" v-model="form.status">
                            <option>Still in Service</option>
                            <option>Resigned</option>
                            <option>Retired</option>
                            <option>Transfered</option>
                            <option>Dropped From the Roll</option>
                            <option>Newly Added</option>
                            <option>Deceased</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex border-left text-white" style="border-left: 100px solid red; background-color: #01579b">
                <h3>Personal Information</h3>
            </div>

            <div class="row">

                <div class="form-group  col-md-4">

                    <label for="surname">Surname</label>
                    <input type="text" placeholder="surname" name="surname" class="form-control" id="surname" v-model="form.surname">
                    <span>
                        <strong class="text-danger" v-if="errors.has('surname')">Required</strong>
                    </span>

                </div>

                <div class="form-group  col-md-4">

                    <label for="firstname">Firstname</label>
                    <input type="text" placeholder="firstname" name="firstname" class="form-control" id="firstname" v-model="form.firstname">
                    <span>
                        <strong class="text-danger" v-if="errors.has('firstname')">Required</strong>
                    </span>

                </div>

                <div class="form-group  col-md-4">

                    <label for="nameextension">Name Ext. (Jr., Sr.)</label>
                    <input type="text" placeholder="Name Extension" name="nameextension" class="form-control" id="nameextension" v-model="form.nameextension">

                </div>

            </div>

            <div class="row">

                <div class="form-group  col-md-4">
                    <label for="middlename">Middlename</label>
                    <input type="text" placeholder="middlename" name="middlename" class="form-control" id="middlename" v-model="form.middlename">
                </div>

                <div class="form-group  col-md-4">
                    <label for="birthdate">Birth Date</label>
                    <input type="date" name="birthdate" class="form-control" id="birthdate" v-model="form.birthdate">
                    <span>
                        <strong class="text-danger" v-if="errors.has('birthdate')">Required</strong>
                    </span>
                </div>

                <div class="form-group  col-md-4">
                    <label for="birthplace">Birth Place</label>
                    <input type="text" placeholder="Birtd Place" name="birthplace" class="form-control" id="birthplace" v-model="form.birthplace">
                </div>

            </div>

            <div class="row">

                <div class="form-group  col-md-6">
                    <label for="sex">Gender</label>
                    <select name="sex" id="sex" class="form-control" v-model="form.sex">
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>

                <div class="form-group  col-md-6">
                    <label for="civilstatus">Civil Status</label>
                    <select name="civilstatus" id="civilstatus" class="form-control" v-model="form.civilstatus">
                        <option>Single</option>
                        <option>Widowed</option>
                        <option>Married</option>
                        <option>Separated</option>
                        <option>Other/s</option>
                    </select>
                </div>

            </div>

            <div class="row">

                <div class="form-group  col-md-4">
                    <label for="height">Height(m)</label>
                    <input type="text" placeholder="height (m)" name="height" class="form-control" id="height" v-model="form.height">
                </div>

                <div class="form-group  col-md-4">
                    <label for="weight">Weight(kg)</label>
                    <input type="text" placeholder="weight (kg)" name="weight" class="form-control" id="weight" v-model="form.weight">
                </div>

                <div class="form-group  col-md-4">
                    <label for="bloodtype">Blood Type</label>
                    <input type="text" placeholder="Blood Type" name="bloodtype" class="form-control" id="bloodtype" v-model="form.bloodtype">
                </div>
            </div>

            <div class="row">

                <div class="form-group  col-md-4">
                    <label for="gsis">GSIS ID No.</label>
                    <input type="text" placeholder="gsis ID No." name="gsis" class="form-control" id="gsis" v-model="form.gsis">
                </div>

                <div class="form-group  col-md-4">
                    <label for="pagibig">PAG-IBIG ID No.</label>
                    <input type="text" placeholder="PAG-IBIG ID No." name="pagibig" class="form-control" id="pagibig" v-model="form.pagibig">
                </div>

                <div class="form-group  col-md-4">
                    <label for="philhealth">PHILHEALtd No.</label>
                    <input type="text" placeholder="PHILHEALtd No." name="philhealth" class="form-control" id="philhealth" v-model="form.philhealth">
                </div>

            </div>

            <div class="row">

                <div class="form-group  col-md-4">
                    <label for="sss">SSS No.</label>
                    <input type="text" placeholder="sss No." name="sss" class="form-control" id="sss" v-model="form.sss">
                </div>

                <div class="form-group  col-md-4">
                    <label for="tin">TIN No.</label>
                    <input type="text" placeholder="tin No." name="tin" class="form-control" id="tin" v-model="form.tin">
                </div>

                <div class="form-group  col-md-4">
                    <label for="agencynumber">Agency Employee No.</label>
                    <input type="text" placeholder="AGENCY EMPLOYEE No." name="agencynumber" class="form-control" id="agencynumber" v-model="form.agencynumber">
                </div>
            </div>

            <div class="row">
                <div class="form-group  col-md-6">
                    <label for="citizenship">Citizenship</label>
                    <select name="citizenship" id="citizenship" class="form-control" v-model="form.citizenship">
                        <option>Filipino</option>
                        <option>Dual citizenship (By Birth)</option>
                        <option>Dual citizenship (By Naturalization)</option>
                    </select>
                </div>
            </div>

            <div class="row">

                <div class="form-group  col-md-6">
                    <label for="residentialaddress">Residential Address</label>
                    <input type="text" name="residentialaddress" placeholder="Residential Address" class="form-control" id="residentialaddress" v-model="form.residentialaddress">
                </div>

                <div class="form-group  col-md-6">
                    <label for="telephone1">Telephone</label>
                    <input type="text" name="telephone1" placeholder="Telephone 1" class="form-control" id="telephone1" v-model="form.telephone1">
                </div>

                <div class="form-group  col-md-6">
                    <label for="zipcode1">Zip Code</label>
                    <input type="text" placeholder="Zip Code" name="zipcode1" class="form-control" id="zipcode1" v-model="form.zipcode1">
                </div>

            </div>

            <div class="row">

                <div class="form-group  col-md-6">
                    <label for="permanentaddress">Permanent Address</label>
                    <input type="text" name="permanentaddress" placeholder="Permanent Address" class="form-control" id="permanentaddress" v-model="form.permanentaddress">
                    <span>
                        <strong class="text-danger" v-if="errors.has('permanentaddress')">Required</strong>
                    </span>
                </div>

                <div class="form-group  col-md-6">
                    <label for="telephone2">Telephone</label>
                    <input type="text" name="telephone2" placeholder="Telephone 2" class="form-control" id="telephone2" v-model="form.telephone2">
                </div>

                <div class="form-group  col-md-6">
                    <label for="zipcode2">Zip Code</label>
                    <input type="text" placeholder="Zip Code" name="zipcode2" class="form-control" id="zipcode2" v-model="form.zipcode2">
                </div>

            </div>

            <div class="row">

                <div class="form-group  col-md-4">
                    <label for="cellphone">Mobile No.</label>
                    <input type="text" placeholder="Mobile No." name="cellphone" class="form-control" id="cellphone" v-model="form.cellphone">
                    <span>
                        <strong class="text-danger" v-if="errors.has('cellphone')">Required</strong>
                    </span>
                </div>

                <div class="form-group  col-md-4">
                    <label for="email">email</label>
                    <input type="email" placeholder="email" name="email" class="form-control" id="email" v-model="form.email">
                </div>

            </div>

            <div class="flex border-left text-white" style="background-color: #01579b">
                <h3>Family Background</h3>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="row">

                        <div class="form-group input-group-sm col-md-6">
                            <label for="spouseSurname">Spouse Surname</label>
                            <input type="text" placeholder="spouseSurname" name="spouseSurname" class="form-control" id="spouseSurname" v-model="form.familybackground.spouseSurname">
                        </div>

                        <div class="form-group input-group-sm col-md-6">
                            <label for="spouseFirstname">Spouse Firstname</label>
                            <input type="text" placeholder="spouseFirstname" name="spouseFirstname" class="form-control" id="spouseFirstname" v-model="form.familybackground.spouseFirstname">
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group input-group-sm col-md-6">
                            <label for="spouseMiddlename">Spouse Middlename</label>
                            <input type="text" placeholder="spouse Middlename" name="spouseMiddlename" class="form-control" id="spouseMiddlename" v-model="form.familybackground.spouseMiddlename">
                        </div>

                        <div class="form-group input-group-sm col-md-6">
                            <label for="spouseOccupation">Spouse Occupation</label>
                            <input type="text" placeholder="spouseOccupation" name="spouseOccupation" class="form-control" id="spouseOccupation" v-model="form.familybackground.spouseOccupation">
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group input-group-sm col-md-6">
                            <label for="spouseBussiness">Spouse Bussiness</label>
                            <input type="text" placeholder="spouseBussiness" name="spouseBussiness" class="form-control" id="spouseBussiness" v-model="form.familybackground.spouseBussiness">
                        </div>

                        <div class="form-group input-group-sm col-md-6">
                            <label for="spouseBussinessAddress">Spouse Bussiness Address</label>
                            <input type="text" placeholder="spouse Bussiness Address" name="spouseBussinessAddress" class="form-control" id="spouseBussinessAddress" v-model="form.familybackground.spouseBussinessAddress">
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group input-group-sm col-md-6">
                            <label for="spouseTelephone">Spouse Telephone</label>
                            <input type="text" placeholder="spouse Telephone" name="spouseTelephone" class="form-control" id="spouseTelephone" v-model="form.familybackground.spouseTelephone">
                        </div>
                    </div>

                    <div class="row">

                        <div class="form-group input-group-sm col-md-6">
                            <label for="fatherSurname">Father Surname</label>
                            <input type="text" placeholder="fatherSurname" name="fatherSurname" class="form-control" id="fatherSurname" v-model="form.familybackground.fatherSurname">
                        </div>

                        <div class="form-group input-group-sm col-md-6">
                            <label for="fatherFirstname">Father Firstname</label>
                            <input type="text" placeholder="fatherFirstname" name="fatherFirstname" class="form-control" id="fatherFirstname" v-model="form.familybackground.fatherFirstname">
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group input-group-sm col-md-6">
                            <label for="fatherMiddlename">Father Middlename</label>
                            <input type="text" placeholder="father Middlename" name="fatherMiddlename" class="form-control" id="fatherMiddlename" v-model="form.familybackground.fatherMiddlename">
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group input-group-sm col-md-6">
                            <label for="motherSurname">Mother Surname</label>
                            <input type="text" placeholder="motherSurname" name="motherSurname" class="form-control" id="motherSurname" v-model="form.familybackground.motherSurname">
                        </div>

                        <div class="form-group input-group-sm col-md-6">
                            <label for="motherFirstname">Mother Firstname</label>
                            <input type="text" placeholder="motherFirstname" name="motherFirstname" class="form-control" id="motherFirstname" v-model="form.familybackground.motherFirstname">
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group input-group-sm col-md-6">
                            <label for="motherMiddlename">Mother Middlename</label>
                            <input type="text" placeholder="motherMiddlename" name="motherMiddlename" class="form-control" id="motherMiddlename" v-model="form.familybackground.motherMiddlename">
                        </div>

                        <div class="form-group input-group-sm col-md-6">
                            <label for="motherMaidenName">mother MaidenName</label>
                            <input type="text" placeholder="motherMaidenName" name="motherMaidenName" class="form-control" id="motherMaidenName" v-model="form.familybackground.motherMaidenName">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group input-group-sm">
                        <button type="button" class="btn btn-primary btn-sm float-right" name="add" id="add-btn" @click="addFields('children')">Add Field</button>
                    </div>
                    <table class="table table-responsive table-borderless table-sm no-datatable" id="child-tbl">
                        <thead>
                            <tr>
                            <th scope="col" class="p-0" style="width: 50%">Name of Child</th>
                            <th scope="col" class="p-0" style="width: 45%">Date Of Birth</th>
                            <th scope="col" class="p-0" style="width: 5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(child, index) in form.children" :key="child.id">
                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="name" id="name" class="form-control" v-model="child.name">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="date" name="birthday" id="birthday" class="form-control" v-model="child.birthday">
                                    </div>
                                </td>


                                <td>
                                    <div class="form-group input-group-sm">
                                        <button type="button" class="btn btn-danger remove-tr btn-sm" @click="deleteFields('children', index)">Remove</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex border-left text-white" style="background-color: #01579b">
                <h3>Educational Background</h3>
            </div>

            <div class="row">
                <div class="col-md-12">
                <table class="table table-sm table-borderless table-responsive no-datatable">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 1%">Level</th>
                            <th scope="col" style="width: 20%">Name Of School</th>
                            <th scope="col" style="width: 10%">Degree Course</th>
                            <th scope="col" style="width: 10%">Year Graduated</th>
                            <th scope="col" style="width: 10%">Highest Grade/Units Earned</th>
                            <th scope="col" style="width: 10%">From</th>
                            <th scope="col" style="width: 10%">To</th>
                            <th scope="col" style="width: 10%">Scholarship/ Academic Honors Received</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Elementary: </th>
                            <td>
                                <input type="text" name="elemSchoolName" id="elemSchoolName" class="form-control" v-model="form.educationalbackground.elemSchoolName">
                            </td>

                            <td>
                                <input type="text" name="elemDegree" class="form-control" id="elemDegree" v-model="form.educationalbackground.elemDegree">
                            </td>

                            <td>
                                <input type="number" name="elemYear" class="form-control" id="elemYear" v-model="form.educationalbackground.elemYear">
                            </td>

                            <td>
                                <input type="text" name="elemHighestLevel" class="form-control" id="elemHighestLevel" v-model="form.educationalbackground.elemHighestLevel">
                            </td>

                            <td>
                                <input type="text" name="elemFrom" class="form-control" id="elemFrom" v-model="form.educationalbackground.elemFrom">
                            </td>

                            <td>
                                <input type="text" name="elemTo" class="form-control" id="elemTo" v-model="form.educationalbackground.elemTo">
                            </td>

                            <td>
                                <input type="text" name="elemSOA" class="form-control" id="elemSOA" v-model="form.educationalbackground.elemSOA">
                            </td>
                        </tr>

                        <tr>

                            <th>Secondary: </th>

                            <td>
                                <input type="text" name="secSchoolName" id="secSchoolName" class="form-control" v-model="form.educationalbackground.secSchoolName">
                            </td>

                            <td>
                                <input type="text" name="secDegree" class="form-control" id="secDegree" v-model="form.educationalbackground.secDegree">
                            </td>

                            <td>
                                <input type="number" name="secYear" class="form-control" id="secYear" v-model="form.educationalbackground.secYear">
                            </td>

                            <td>
                                <input type="text" name="secHighestLevel" class="form-control" id="secHighestLevel" v-model="form.educationalbackground.secHighestLevel">
                            </td>

                            <td>
                                <input type="text" name="secFrom" class="form-control" id="secFrom" v-model="form.educationalbackground.secFrom">
                            </td>

                            <td>
                                <input type="text" name="SecTo" class="form-control" id="SecTo" v-model="form.educationalbackground.secTo">
                            </td>

                            <td>
                                <input type="text" name="secSOA" class="form-control" id="secSOA" v-model="form.educationalbackground.secSOA">
                            </td>
                        </tr>

                        <tr>
                            <th>Vocational: </th>

                            <td>
                                <input type="text" name="vocSchoolName" id="vocSchoolName" class="form-control" v-model="form.educationalbackground.vocSchoolName">
                            </td>

                            <td>
                                <input type="text" name="vocDegree" class="form-control" id="vocDegree" v-model="form.educationalbackground.vocDegree">
                            </td>

                            <td>
                                <input type="number" name="vocYear" class="form-control" id="vocYear" v-model="form.educationalbackground.vocYear">
                            </td>

                            <td>
                                <input type="text" name="vocHighestLevel" class="form-control" id="vocHighestLevel" v-model="form.educationalbackground.vocHighestLevel">
                            </td>

                            <td>
                                <input type="text" name="vocFrom" class="form-control" id="vocFrom" v-model="form.educationalbackground.vocFrom">
                            </td>

                            <td>
                                <input type="text" name="vocTo" class="form-control" id="vocTo" v-model="form.educationalbackground.vocTo">
                            </td>

                            <td>
                                <input type="text" name="vocSOA" class="form-control" id="vocSOA" v-model="form.educationalbackground.vocSOA">
                            </td>
                        </tr>

                        <tr>
                            <th>College: </th>

                            <td>
                                <input type="text" name="collSchoolName1" id="collSchoolName1" class="form-control" v-model="form.educationalbackground.collSchoolName1">
                            </td>

                            <td>
                                <input type="text" name="collDegree1" class="form-control" id="collDegree1" v-model="form.educationalbackground.collDegree1">
                            </td>

                            <td>
                                <input type="number" name="collYear1" class="form-control" id="collYear1" v-model="form.educationalbackground.collYear1">
                            </td>

                            <td>
                                <input type="text" name="collHighestLevel1" class="form-control" id="collHighestLevel1" v-model="form.educationalbackground.collHighestLevel1">
                            </td>

                            <td>
                                <input type="text" name="collFrom1" class="form-control" id="collFrom1" v-model="form.educationalbackground.collFrom1">
                            </td>

                            <td>
                                <input type="text" name="collTo1" class="form-control" id="collTo1" v-model="form.educationalbackground.collTo1">
                            </td>

                            <td>
                                <input type="text" name="collSOA1" class="form-control" id="collSOA1" v-model="form.educationalbackground.collSOA1">
                            </td>
                        </tr>

                        <tr>
                            <th></th>

                            <td>
                                <input type="text" name="collSchoolName2" id="collSchoolName2" class="form-control" v-model="form.educationalbackground.collSchoolName2">
                            </td>

                            <td>
                                <input type="text" name="collDegree2" class="form-control" id="collDegree2" v-model="form.educationalbackground.collDegree2">
                            </td>

                            <td>
                                <input type="number" name="collYear2" class="form-control" id="collYear2" v-model="form.educationalbackground.collYear2">
                            </td>

                            <td>
                                <input type="text" name="collHighestLevel2" class="form-control" id="collHighestLevel2" v-model="form.educationalbackground.collHighestLevel2">
                            </td>

                            <td>
                                <input type="text" name="collFrom2" class="form-control" id="collFrom2" v-model="form.educationalbackground.collFrom2">
                            </td>

                            <td>
                                <input type="text" name="collTo2" class="form-control" id="collTo2" v-model="form.educationalbackground.collTo2">
                            </td>

                            <td>
                                <input type="text" name="collSOA2" class="form-control" id="collSOA2" v-model="form.educationalbackground.collSOA2">
                            </td>
                        </tr>

                        <tr>
                            <th>Graduate Stud: </th>

                            <td>
                                <input type="text" name="gradSchoolName" id="gradSchoolName" class="form-control" v-model="form.educationalbackground.gradSchoolName">
                            </td>

                            <td>
                                <input type="text" name="gradDegree" class="form-control" id="gradDegree" v-model="form.educationalbackground.gradDegree">
                            </td>

                            <td>
                                <input type="number" name="gradYear" class="form-control" id="gradYear" v-model="form.educationalbackground.gradYear">
                            </td>

                            <td>
                                <input type="text" name="gradHighestLevel" class="form-control" id="gradHighestLevel" v-model="form.educationalbackground.gradHighestLevel">
                            </td>

                            <td>
                                <input type="text" name="gradFrom" class="form-control" id="gradFrom" v-model="form.educationalbackground.gradFrom">
                            </td>

                            <td>
                                <input type="text" name="gradTo" class="form-control" id="gradTo" v-model="form.educationalbackground.gradTo">
                            </td>

                            <td>
                                <input type="text" name="gradSOA" class="form-control" id="gradSOA" v-model="form.educationalbackground.gradSOA">
                            </td>
                        </tr>

                    </tbody>
                </table>
                </div>
            </div>

            <div class="flex border-left text-white" style="background-color: #01579b">
                <h3>Eligibility</h3>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary float-right btn-sm" id="add-eli"  @click="addFields('eligibility')">Add Field</button>
                    <table class="table table-responsive table-borderless table-sm no-datatable" id="eligibility-tbl">
                        <thead>
                            <tr>
                            <th scope="col" class="" style="width: 25%">CAREER SERVICE/Board/BAR/CES/CSEE</th>
                            <th scope="col" class="" style="width: 10%">Rating</th>
                            <th scope="col" class="" style="width: 10%">Date of Examination / Conferement</th>
                            <th scope="col" class="" style="width: 25%">Place Of Examination</th>
                            <th scope="col" class="" style="width: 10%">License Number (if applicable)</th>
                            <th scope="col" class="" style="width: 10%">Date of Release</th>
                            <th scope="col" class="" style="width: 5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(eligibility, index) in form.eligibilities" :key="eligibility.id">
                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="careerService" id="careerService" class="form-control" v-model="eligibility.careerService">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="rating" id="rating" class="form-control" v-model="eligibility.rating">

                                    </div>
                                </td>
                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="date" name="dateOfExam" id="dateOfExam" class="form-control" v-model="eligibility.dateOfExam">

                                    </div>
                                </td>

                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="placeOfExam" id="placeOfExam" class="form-control" v-model="eligibility.placeOfExam">

                                    </div>
                                </td>
                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="licenseNumber" id="licenseNumber" class="form-control" v-model="eligibility.licenseNumber">

                                    </div>
                                </td>

                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="licenseRelease" id="licenseRelease" class="form-control" v-model="eligibility.licenseRelease">

                                    </div>
                                </td>
                                <td>
                                    <div class="form-group input-group-sm">
                                        <button type="button" class="btn btn-danger remove-tr btn-sm" @click="deleteFields('eligibility' ,index)">Remove</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex border-left text-white" style="background-color: #01579b">
                <h3>Work Experience</h3>
            </div>

            <div class="row">
                <div class="col-md-12">
                <button type="button" class="btn btn-primary float-right btn-sm" id="add-workex" @click="addFields('workexperience')">Add Field</button>
                <table class="table table-responsive table-borderless table-sm no-datatable" id="workex_tbl">
                    <thead>
                        <tr>
                            <th scope="col" class="" style="width: 10%">From</th>
                            <th scope="col" class="" style="width: 10%">To</th>
                            <th scope="col" class="" style="width: 20%">Position Title</th>
                            <th scope="col" class="" style="width: 20%">Department / Agency / Office</th>
                            <th scope="col" class="" style="width: 10%">Monthly Salary</th>
                            <th scope="col" class="" style="width: 10%">Salary Grade & Step</th>
                            <th scope="col" class="" style="width: 10%">Status Appointment</th>
                            <th scope="col" class="" style="width: 10%">Gov't Service (YES/NO)</th>
                            <th scope="col" class="" style="width: 5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(workexperience, index) in form.workexperiences" :key="workexperience.id">
                            <td>
                                <div class="form-group input-group-sm">
                                    <input type="date" name="inclusiveDateFrom" id="inclusiveDateFrom" class="form-control" v-model="workexperience.inclusiveDateFrom">
                                </div>
                            </td>

                            <td>
                                <div class="form-group input-group-sm">
                                    <input type="date" name="inclusiveDateTo" id="inclusiveDateTo" class="form-control" v-model="workexperience.inclusiveDateTo">
                                </div>
                            </td>

                            <td>
                                <div class="form-group input-group-sm">
                                    <input type="text" name="position" id="position" class="form-control" v-model="workexperience.position">
                                </div>
                            </td>

                            <td>
                                <div class="form-group input-group-sm">
                                    <input type="text" name="department" id="department" class="form-control" v-model="workexperience.department">
                                </div>
                            </td>

                            <td>
                                <div class="form-group input-group-sm">
                                    <input type="text" name="monthlySalary" id="monthlySalary" class="form-control" v-model="workexperience.monthlySalary">
                                </div>
                            </td>
                            <td>
                                <div class="form-group input-group-sm">
                                    <input type="text" name="salaryGrade" id="salaryGrade" class="form-control" v-model="workexperience.salaryGrade">
                                </div>
                            </td>

                            <td>
                                <div class="form-group input-group-sm">
                                    <input type="text" name="statusOfAppointment" id="statusOfAppointment" class="form-control" v-model="workexperience.statusOfAppointment">
                                </div>
                            </td>
                            <td>
                                <div class="form-group input-group-sm">
                                    <select name="govService" id="govService" class="form-control" v-model="workexperience.govService">
                                        <option>YES</option>
                                        <option>NO</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group input-group-sm">
                                    <button type="button" class="btn btn-danger remove-tr btn-sm" @click="deleteFields('workexperience', index)">Remove</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>

            <div class="flex border-left text-white" style="background-color: #01579b">
                <h3>Voluntary Work</h3>
            </div>

            <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary btn-sm float-right" name="add" id="add-volwork" @click="addFields('voluntaryworks')">Add Field</button>
                        <table class="table table-responsive table-borderless table-sm no-datatable" id="volwork-tbl">
                        <thead>
                            <tr>
                            <th scope="col" class="" style="width: 25%">Name and Address of Organization</th>
                            <th scope="col" class="" style="width: 10%">From</th>
                            <th scope="col" class="" style="width: 10%">To</th>
                            <th scope="col" class="" style="width: 25%">Number Of Hours</th>
                            <th scope="col" class="" style="width: 30%">Position / Nature of Work</th>
                            <th scope="col" class="" style="width: 5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(voluntarywork, index) in form.voluntaryworks" :key="voluntarywork.id">
                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="nameAndAddress" id="nameAndAddress" class="form-control" v-model="voluntarywork.nameAndAddress">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="date" name="inclusiveDateFrom" id="inclusiveDateFrom" class="form-control" v-model="voluntarywork.inclusiveDateFrom">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="date" name="inclusiveDateTo" id="inclusiveDateTo" class="form-control" v-model="voluntarywork.inclusiveDateTo">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="hours" id="hours" class="form-control" v-model="voluntarywork.hours">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="position" id="position" class="form-control" v-model="voluntarywork.position">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group input-group-sm">
                                        <button type="button" class="btn btn-danger remove-tr btn-sm" @click="deleteFields('voluntaryworks', index)">Remove</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex border-left text-white" style="background-color: #01579b">
                <h3>Learning and Development</h3>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-sm float-right" name="add" id="add-learn" @click="addFields('trainingprograms')">Add Field</button>
                    <table class="table table-responsive table-borderless table-sm no-datatable" id="learnanddev-tbl">
                        <thead>
                            <tr>
                            <th scope="col" class="" style="width: 30%">Title of Learning and Development Interventions / Training Programs</th>
                            <th scope="col" class="" style="width: 10%">From</th>
                            <th scope="col" class="" style="width: 10%">To</th>
                            <th scope="col" class="" style="width: 10%">Number of Hours</th>
                            <th scope="col" class="" style="width: 30%">Conducted / Sponsored By</th>
                            <th scope="col" class="" style="width: 5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(trainingprogram, index) in form.trainingprograms" :key="trainingprogram.id">
                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="title" id="title" class="form-control" v-model="trainingprogram.title">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="date" name="inclusiveDateFrom" id="inclusiveDateFrom" class="form-control" v-model="trainingprogram.inclusiveDateFrom">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="date" name="inclusiveDateTo" id="inclusiveDateTo" class="form-control" v-model="trainingprogram.inclusiveDateTo">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="number" name="hours" id="hours" class="form-control" v-model="trainingprogram.hours">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="conductor" id="conductor" class="form-control" v-model="trainingprogram.conductor">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group input-group-sm">
                                        <button type="button" class="btn btn-danger remove-tr btn-sm" @click="deleteFields('trainingprograms', index)">Remove</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex border-left text-white" style="background-color: #01579b">
                <h3>Other Information</h3>
            </div>

            <div class="row">
                <div class="col-md-12">
                <button type="button" class="btn btn-primary btn-sm float-right" name="add" id="add-otherinfo" @click="addFields('otherinfos')">Add Field</button>
                <table class="table table-responsive table-borderless table-sm no-datatable" id="otherinfo-tbl">
                    <thead>
                        <tr>
                            <th scope="col" class="" style="width: 20%">Specail Skill and Hobby</th>
                            <th scope="col" class="" style="width: 50%">Non-Academic Distinctions / Recognition</th>
                            <th scope="col" class="" style="width: 20%">Membership in Association / Organization</th>
                            <th scope="col" class="" style="width: 5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(otherinfo, index) in form.otherinfos" :key="otherinfo.id">
                            <td>
                                <div class="form-group input-group-sm">
                                    <input type="text" name="skill" id="skill" class="form-control" v-model="otherinfo.skill">
                                </div>
                            </td>

                            <td>
                                <div class="form-group input-group-sm">
                                    <input type="text" name="recognition" id="recognition" class="form-control" v-model="otherinfo.recognition">
                                </div>
                            </td>

                            <td>
                                <div class="form-group input-group-sm">
                                    <input type="text" name="membership" id="membership" class="form-control" v-model="otherinfo.membership">
                                </div>
                            </td>
                            <td>
                                <div class="form-group input-group-sm">
                                    <button type="button" class="btn btn-danger remove-tr btn-sm" @click="deleteFields('otherinfos', index)">Remove</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>

             <div class="flex border-left text-white" style="background-color: #01579b">
                <h3>lp</h3>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col p-0" style="max-width:20.59px;background-color: #D9D9D9;">
                        <label for="">34.</label>
                    </div>
                    <div class="col-md-7" style="background-color: #D9D9D9;">
                        <div>
                            <p>
                                Are you related by consanguinity or affinity to the appointing or recommending authority, or to the
                                chief of bureau or office or to the person who has immediate supervision over you in the Office,
                                Bureau or Department where you will be apppointed,
                            </p>
                        </div>
                        <div>
                            <p>a. within the third degree?</p>
                        </div>
                        <div>
                            <p>b. within the fourth degree (for Local Government Unit - Career Employees)?</p>
                        </div>
                    </div>
                    <div class="col" style="width:100%; padding-top:8%;">
                        <div class="input-group d-flex justify-content-around">
                            <label for="q34a">
                                <input class="q34a" name="q34a" id="q34a" type="radio" value="1" v-model="form.pdsquestion.q34a">
                                YES
                            </label>

                            <label for="q34a">
                                <input class="q34a" name="q34a" id="q34a" type="radio" value="0" v-model="form.pdsquestion.q34a">
                                NO
                            </label>
                        </div>

                        <div class="input-group d-flex justify-content-around">
                            <label for="q34b">
                                <input class="q34b" name="q34b" id="q34b" type="radio" value="1" v-model="form.pdsquestion.q34b">
                                YES
                            </label>

                            <label for="q34b">
                                <input class="q34b" name="q34b" id="q34b" type="radio" value="0" v-model="form.pdsquestion.q34b">
                                NO
                            </label>
                        </div>

                        <div class="input-group-sm pb-1">
                            <label for="q34bdetails">If YES give details::</label>
                            <input type="text" name="q34bdetails" class="form-control" id="q34bdetails" v-model="form.pdsquestion.q34bdetails">
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col p-0" style="max-width:20.59px;background-color: #D9D9D9;">
                        <label for="">35.</label>
                    </div>
                    <div class="col-md-7" style="background-color: #D9D9D9;">
                        <div>
                            <p>
                                a. Have you ever been found guilty of any administrative offense?
                            </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group-sm d-flex justify-content-around mt-1">
                            <label for="q35a">
                                <input type="radio" class="q35a" name="q35a" id="q35a" value="1" v-model="form.pdsquestion.q35a">
                                YES
                            </label>

                            <label for="q35a">
                                <input type="radio" class="q35a" name="q35a" id="q35a" value="0" v-model="form.pdsquestion.q35a">
                                NO
                            </label>
                        </div>
                        <div class="input-group-sm pb-1">
                            <label for="q35adetails">If YES give details::</label>
                            <input type="text" name="q35adetails" class="form-control" id="q35adetails" v-model="form.pdsquestion.q35adetails">
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col p-0" style="max-width:20.59px;background-color: #D9D9D9;">

                    </div>
                    <div class="col-md-7" style="background-color: #D9D9D9;">
                        <div>
                            <p>
                                b. Have you been criminally charged before any court?
                            </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group-sm d-flex justify-content-around mt-1">
                            <label for="q35b">
                                <input type="radio" class="q35b" name="q35b" id="q35b" value="1" v-model="form.pdsquestion.q35b">
                                YES
                            </label>

                            <label for="q35b">
                                <input type="radio" class="q35b" name="q35b" id="q35b" value="0" v-model="form.pdsquestion.q35b">
                                NO
                            </label>
                        </div>
                        <div class="input-group-sm">
                            <p>If YES give details:</p>
                        </div>
                        <div class="form-group row input-group-sm pb-1">
                            <label for="q35bdatefiled" class="col-sm-4 col-form-label">Date Filed:</label>
                            <div class="col-sm-8">
                                <input type="date" name="q35bdatefiled" class="form-control" id="q35bdatefiled" v-model="form.pdsquestion.q35bdatefiled">
                            </div>
                        </div>
                        <div class="form-group row input-group-sm pb-1">
                            <label for="q35bcasestatus" class="col-sm-4 col-form-label">Status of Case/s:</label>
                            <div class="col-sm-8">
                                <input type="text" name="q35bcasestatus" class="form-control" id="q35bcasestatus" v-model="form.pdsquestion.q35bcasestatus">
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col p-0" style="max-width:20.59px;background-color: #D9D9D9;">
                        <label for="">36.</label>
                    </div>
                    <div class="col-md-7" style="background-color: #D9D9D9;">
                        <div>
                            <p>
                                Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?
                            </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group-sm d-flex justify-content-around mt-1">
                            <label for="q36a">
                                <input type="radio" class="q36a" name="q36a" id="q36a" value="1" v-model="form.pdsquestion.q36a">
                                YES
                            </label>

                            <label for="q36a">
                                <input type="radio" class="q36a" name="q36a" id="q36a" value="0" v-model="form.pdsquestion.q36a">
                                NO
                            </label>
                        </div>
                        <div class="input-group-sm pb-1">
                            <label for="q36adetails">If YES give details:</label>
                            <input type="text" name="q36adetails" class="form-control" id="q36adetails" v-model="form.pdsquestion.q36adetails">
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col p-0" style="max-width:20.59px;background-color: #D9D9D9;">
                        <label for="">37.</label>
                    </div>
                    <div class="col-md-7" style="background-color: #D9D9D9;">
                        <div>
                            <p>
                                Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls,
                                dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?
                            </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group-sm d-flex justify-content-around mt-1">
                            <label for="q37a">
                                <input type="radio" class="q37a" name="q37a" id="q37a" value="1" v-model="form.pdsquestion.q37a">
                                YES
                            </label>

                            <label for="q37a">
                                <input type="radio" class="q37a" name="q37a" id="q37a" value="0" v-model="form.pdsquestion.q37a">
                                NO
                            </label>
                        </div>
                        <div class="input-group-sm pb-1">
                            <label for="q37adetails">If YES give details</label>
                            <input type="text" name="q37adetails" class="form-control" id="q37adetails"  v-model="form.pdsquestion.q37adetails">
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col p-0" style="max-width:20.59px;background-color: #D9D9D9;">
                        <label for="">38.</label>
                    </div>
                    <div class="col-md-7" style="background-color: #D9D9D9;">
                        <div>
                            <p>
                                a. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?
                            </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group-sm d-flex justify-content-around mt-1">
                            <label for="q38a">
                                <input type="radio" class="q38a" name="q38a" id="q38a" value="1" v-model="form.pdsquestion.q38a">
                                YES
                            </label>

                            <label for="q38a">
                                <input type="radio" class="q38a" name="q38a" id="q38a" value="0" v-model="form.pdsquestion.q38a">
                                NO
                            </label>
                        </div>
                        <div class="input-group-sm pb-1">
                            <label for="q38adetails">If YES give details:</label>
                            <input type="text" name="q38adetails" class="form-control" id="q38adetails" v-model="form.pdsquestion.q38adetails">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col p-0" style="max-width:20.59px;background-color: #D9D9D9;">
                        <label for=""></label>
                    </div>
                    <div class="col-md-7" style="background-color: #D9D9D9;">
                        <div>
                            <p>
                                b. Have you resigned from the government service during the three
                                (3)-month period before the last election to promote/actively campaign for a national or local candidate?
                            </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group-sm d-flex justify-content-around mt-1">
                            <label for="q38b">
                                <input type="radio" class="q38b" name="q38b" id="q38b" value="1" v-model="form.pdsquestion.q38b">
                                YES
                            </label>

                            <label for="q38b">
                                <input type="radio" class="q38b" name="q38b" id="q38b" value="0" v-model="form.pdsquestion.q38b">
                                NO
                            </label>
                        </div>
                        <div class="input-group-sm pb-1">
                            <label for="q38bdetails">If YES give details:</label>
                            <input type="text" name="q38bdetails" class="form-control" id="q38bdetails" v-model="form.pdsquestion.q38bdetails">
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col p-0" style="max-width:20.59px;background-color: #D9D9D9;">
                        <label for="">39.</label>
                    </div>
                    <div class="col-md-7" style="background-color: #D9D9D9;">
                        <div>
                            <p>
                                Have you acquired the status of an immigrant or permanent resident of another country?
                            </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group-sm d-flex justify-content-around mt-1">
                            <label for="q39a">
                                <input type="radio" class="q39a" name="q39a" id="q39a" value="1" v-model="form.pdsquestion.q39a">
                                YES
                            </label>

                            <label for="q35a">
                                <input type="radio" class="q39a" name="q39a" id="q39a" value="0" v-model="form.pdsquestion.q39a">
                                NO
                            </label>
                        </div>
                        <div class="input-group-sm pb-1">
                            <label for="q39adetails">If YES give details:</label>
                            <input type="text" name="q39adetails" class="form-control" id="q39adetails" v-model="form.pdsquestion.q39adetails">
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col p-0" style="max-width:20.59px;background-color: #D9D9D9;">
                        <label for="">40.</label>
                    </div>
                    <div class="col-md-7" style="background-color: #D9D9D9;">
                        <div>
                            <p>
                                Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for
                                Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972),
                                please answer the following items:
                            </p>
                        </div>
                    </div>
                    <div class="col">

                    </div>
                </div>

                <div class="row">
                    <div class="col p-0" style="max-width:20.59px;background-color: #D9D9D9;">
                        <label for=""></label>
                    </div>
                    <div class="col-md-7" style="background-color: #D9D9D9;">
                        <div>
                            <p>
                                a. Are you a member of any indigenous group?
                            </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group-sm d-flex justify-content-around mt-1">
                            <label for="q40a">
                                <input type="radio" class="q40a" name="q40a" id="q40a" value="1" v-model="form.pdsquestion.q40a">
                                YES
                            </label>

                            <label for="q40a">
                                <input type="radio" class="q40a" name="q40a" id="q40a" value="0" v-model="form.pdsquestion.q40a">
                                NO
                            </label>
                        </div>
                        <div class="input-group-sm pb-1">
                            <label for="q40adetails">If YES please specify:</label>
                            <input type="text" name="q40adetails" class="form-control" id="q40adetails" v-model="form.pdsquestion.q40adetails">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col p-0" style="max-width:20.59px;background-color: #D9D9D9;">
                        <label for=""></label>
                    </div>
                    <div class="col-md-7" style="background-color: #D9D9D9;">
                        <div>
                            <p>
                                b. Are you a person with disability?
                            </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group-sm d-flex justify-content-around mt-1">
                            <label for="q40b">
                                <input type="radio" class="q40b" name="q40b" id="q40b" value="1" v-model="form.pdsquestion.q40b">
                                YES
                            </label>

                            <label for="q40b">
                                <input type="radio" class="q40b" name="q40b" id="q40b" value="0" v-model="form.pdsquestion.q40b">
                                NO
                            </label>
                        </div>
                        <div class="input-group-sm pb-1">
                            <label for="q40bdetails">If YES, please specify ID No:</label>
                            <input type="text" name="q40bdetails" class="form-control" id="q40bdetails" v-model="form.pdsquestion.q40bdetails">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col p-0" style="max-width:20.59px;background-color: #D9D9D9;">
                        <label for=""></label>
                    </div>
                    <div class="col-md-7" style="background-color: #D9D9D9;">
                        <div>
                            <p>
                                c. Are you a solo parent?
                            </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group-sm d-flex justify-content-around mt-1">
                            <label for="q40c">
                                <input type="radio" class="q40c" name="q40c" id="q40c" value="1" v-model="form.pdsquestion.q40c">
                                YES
                            </label>

                            <label for="q40c">
                                <input type="radio" class="q40c" name="q40c" id="q40c" value="0" v-model="form.pdsquestion.q40c">
                                NO
                            </label>
                        </div>
                        <div class="input-group-sm pb-1">
                            <label for="q40cdetails">If YES, please specify ID No:</label>
                            <input type="text" name="q40cdetails" id="q40cdetails" class="form-control" v-model="form.pdsquestion.q40cdetails">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex border-left text-white" style="background-color: #01579b">
                <h3>REFERENCES (Person not related by consanguinity or affinity to applicant /appointee)</h3>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <table class="table table-borderless table-sm no-datatable" id="otherinfo-tbl">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" style="width: 50%">Name</th>
                                <th scope="col" class="text-center" style="width: 25%">Address</th>
                                <th scope="col" class="text-center" style="width: 25%">Tel No.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="refname1" id="refname1" class="form-control" v-model="form.pdsquestion.refname1">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="refaddress1" id="refaddress1" class="form-control" v-model="form.pdsquestion.refaddress1">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="reftelephone1" id="reftelephone1" class="form-control" v-model="form.pdsquestion.reftelephone1">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="refname2" id="refname2" class="form-control" v-model="form.pdsquestion.refname2">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="refaddress2" id="refaddress2" class="form-control" v-model="form.pdsquestion.refaddress2">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="reftelephone2" id="reftelephone2" class="form-control" v-model="form.pdsquestion.reftelephone2">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="refname3" id="refname3" class="form-control" v-model="form.pdsquestion.refname3">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="refaddress3" id="refaddress3" class="form-control" v-model="form.pdsquestion.refaddress3">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group input-group-sm">
                                        <input type="text" name="reftelephone3" id="reftelephone3" class="form-control" v-model="form.pdsquestion.reftelephone3">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex border-left text-white" style="background-color: #01579b">
                <h3>Government Issued ID (i.e.Passport, GSIS, SSS, PRC, Driver's License, etc.)</h3>
            </div>
            <div class="col-md-12 p-0">
                <h5>PLEASE INDICATE ID Number and Date of Issuance</h5>
                <div class="row mt-3">
                    <div class="form-group col-md-4">
                        <label for="govid">Government Issued ID:</label>

                        <input type="text" placeholder="" name="govid" class="form-control" id="govid" v-model="form.pdsquestion.govid">

                    </div>
                    <div class="form-group col-md-4">
                        <label for="idnumber">ID/License/Passport No.:</label>

                        <input type="text" placeholder="" name="idnumber" class="form-control" id="idnumber" v-model="form.pdsquestion.idnumber">

                    </div>
                    <div class="form-group col-md-4">
                        <label for="dateissued">Date/Place of Issuance:</label>

                        <input type="text" placeholder="" name="dateissued" class="form-control" id="dateissued" v-model="form.pdsquestion.dateissued">

                    </div>
                </div>
            </div>

            <div class="flex border-left text-white" style="background-color: #01579b">
                <h3>ID Picture</h3>
            </div>
            <div class="col-md-12 p-0">
                <div class="form-group col-md-3">
                    <label for="picture" class="col-sm-2 col-form-label">Picture</label>
                    <div class="col-sm-10">
                        <input type="file" @click="reset()" @change="uploadPicture" name="picture" ref="picture" id="picture" accept="image/jpeg, image/png">
                    </div>
                </div>
                <div class="form-group col-md-9">
                    <div>
                        <img class="result" style="height: 100%; width: 100%;" :src="getAvatar()" alt="">
                    </div>
                </div>
            </div>

            <div class="flex">
                <div class="col-md-12">
                    <div class="form-group input-group-sm row mb-0 float-right d-flex">
                        <button type="submit" class="btn btn-primary m-1">Save</button>
                    </div>
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
                        <clipper-fixed  class="my-clipper" :ratio="132/170" ref="clipper" preview="my-preview" :src="getAvatar()"><div class="placeholder" slot="placeholder">No image</div></clipper-fixed>
                    </div>

                    <div class="col-md-6">
                        <clipper-preview name="my-preview" class="my-clipper">
                            <div class="placeholder" slot="placeholder">preview area</div>
                        </clipper-preview>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="getResult">Confirm</button>
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
            editMode: false,
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
            })
        }
    },
    beforeRouteEnter (to, from, next) {
       if(to.query.id == null)
       {
            next()
       }else{
            axios.get('api/edit?id='+to.query.id)
            .then(({data}) => {
                next(vm => vm.fetchData(data))
            })
            .catch(error => {
                Swal.fire(
                    'Failed',
                    error.response.status.toString(),
                    'warning'
                )
                next(false)
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
            let prefix = (this.form.picture.match(/\//) ? '' : '/storage/pds_employeePictures/');
            return prefix + this.form.picture;
        },
        storePersonalInformation: function()
        {
            console.log(this.form)
            axios.post('api/personalinformation', this.form)
            .then(respose => {
                Swal.fire(
                    'Success',
                    'Registered successfully',
                    'success'
                )
                this.form.reset()
            })
            .catch(error => this.errors.record(error.response.data.errors))
        },
        updatePersonalInformation: function()
        {
            axios.patch('api/personalinformation/'+this.form.id, this.form)
            .then(response => {
                Swal.fire(
                    'Success',
                    'Updated successfully',
                    'success'
                )
            })
            .catch(error => this.errors.record(error.response.data.errors))
            console.log(this.form);
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
            switch(data)
            {
                case data = 'children':
                    this.form.children.splice(index, 1)
                break;
                case data = 'eligibility':
                    this.form.eligibilities.splice(index, 1)
                break;
                case data = 'workexperience':
                    this.form.workexperiences.splice(index, 1)
                break;
                case data = 'voluntaryworks':
                    this.form.voluntaryworks.splice(index, 1)
                break;
                case data = 'trainingprograms':
                    this.form.trainingprograms.splice(index, 1)
                break;
                case data = 'otherinfos':
                    this.form.otherinfos.splice(index, 1)
                break;
            }
        },
        fetchData: function(data)
        {
            this.editMode = true

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

            this.form.fill(data)
        }

    },
    created()
    {

    }

}
</script>
