<template>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>SWORN STATEMENT OF ASSETS, LIABILITIES AND NET WORTH (SALN)</h3>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success float-right" @click="printSaln()">Print <i class="fas fa-print"></i></button>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">
                        <form autocomplete="off" @submit.prevent="editMode ? update() : submit()">
                            <div class="col-md-12">
                                <h5 for="" class="text-primary">Declarant</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="">Family Name*</label>
                                        <input type="text" class="form-control" name="" id="" v-model="form.declarant_ln" placeholder="Family Name" :class="{'is-invalid':form.errors.has('declarant_ln')}">
                                        <has-error :form="form" field="declarant_ln"></has-error>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">First Name*</label>
                                        <input type="text" class="form-control" name="" id="" v-model="form.declarant_fn" placeholder="First Name" :class="{'is-invalid':form.errors.has('declarant_fn')}">
                                        <has-error :form="form" field="declarant_fn"></has-error>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="">M.I.*</label>
                                        <input type="text" class="form-control" name="" id="" v-model="form.declarant_mi" placeholder="M.I." :class="{'is-invalid':form.errors.has('declarant_mi')}">
                                        <has-error :form="form" field="declarant_mi"></has-error>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="dec_address">Address*</label>
                                        <input type="text" class="form-control" name="dec_address" id="dec_address" v-model="form.declarant_address" placeholder="Address" :class="{'is-invalid':form.errors.has('declarant_address')}">
                                        <has-error :form="form" field="declarant_address"></has-error>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="dec_position">Date*</label>
                                        <input type="date" class="form-control" name="dec_position" id="dec_position" v-model="form.date" :class="{'is-invalid':form.errors.has('date')}">
                                        <has-error :form="form" field="date"></has-error>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="dec_position">Position*</label>
                                        <input type="text" class="form-control" name="dec_position" id="dec_position" v-model="form.declarant_position" placeholder="Position" :class="{'is-invalid':form.errors.has('declarant_position')}">
                                        <has-error :form="form" field="declarant_position"></has-error>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="dec_agency">Agency/Office*</label>
                                        <input type="text" class="form-control" name="dec_agency" id="dec_agency" v-model="form.declarant_agency" placeholder="Agency/Office" :class="{'is-invalid':form.errors.has('declarant_agency')}">
                                        <has-error :form="form" field="declarant_agency"></has-error>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="dec_office">Office Address*</label>
                                        <input type="text" class="form-control" name="dec_office" id="dec_office" v-model="form.declarant_office_address" placeholder="Office Address" :class="{'is-invalid':form.errors.has('declarant_office_address')}">
                                        <has-error :form="form" field="declarant_office_address"></has-error>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr>
                            </div>

                            <div class="col-md-12">
                                <h5 for="spouce_name" class="text-primary">Spouse</h5>
                            </div>

                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="">Family Name</label>
                                        <input type="text" class="form-control" name="" id="" v-model="form.spouse_ln" placeholder="Family Name">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">First Name</label>
                                        <input type="text" class="form-control" name="" id="" v-model="form.spouse_fn" placeholder="First Name">
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="">M.I.</label>
                                        <input type="text" class="form-control" name="" id="" v-model="form.spouse_mi" placeholder="M.I.">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="dec_position">Position</label>
                                        <input type="text" class="form-control" name="dec_position" id="dec_position" v-model="form.spouse_position" placeholder="Position">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="dec_agency">Agency/Office</label>
                                        <input type="text" class="form-control" name="dec_agency" id="dec_agency" v-model="form.spouse_agency" placeholder="Agency/Office">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="dec_office">Office Address</label>
                                        <input type="text" class="form-control" name="dec_office" id="dec_office" v-model="form.spouse_agency_address" placeholder="Office Address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr>
                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5 class="text-primary">
                                                    UNMARRIED CHILDREN BELOW EIGHTEEN (18) YEARS OF AGE LIVING IN DECLARANT’S HOUSEHOLD
                                                </h5>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-primary float-right" @click="addChildren()">Add <i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="col-md-6"><label for="">Name</label></div>
                                            <div class="col-md-3"><label for="">Date of Birth</label></div>
                                            <div class="col-md-2"><label for="">Age</label></div>
                                            <div class="col-md-2"><label for=""></label></div>
                                        </div>
                                        <div class="form-row" v-for="(c, i) in form.children">
                                            <div class="col-md-11">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <input type="text" class="form-control" name="Name" id="Name" v-model="c.name" placeholder="Name">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <input type="date" class="form-control" name="dob" id="dob" v-model="c.dob">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <input type="text" class="form-control" name="Age" id="Age" v-model="c.age" placeholder="Age">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-danger" @click="removeChildren(i)">Remove <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h5 class="text-primary">
                                                    ASSETS, LIABILITIES AND NETWORTH
                                                </h5>
                                                <h6>
                                                    (Including those of the spouse and unmarried children below eighteen (18)
                                                    years of age living in declarant’s household)
                                                </h6>
                                                <h4 class="text-primary">
                                                    Total Assests: {{ form.total_asset }}
                                                </h4>
                                            </div>
                                            <div class="col-md-12 mt-4">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5 class="text-primary">
                                                            Assets
                                                        </h5>
                                                        <div class="col-md-12 p-0">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <h5 class="text-success mb-0">
                                                                        Real Properties
                                                                    </h5>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h5 class="mb-0">
                                                                        Total: {{form.real_property_subtotal}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="button" class="btn btn-primary float-right" @click="addRealProperties()">Add <i class="fas fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                        <div class="form-row" v-for="(rp, i) in form.real_property">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5>
                                                            {{ i + 1 }}
                                                        </h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-danger float-right" @click="removeRealProperties(i)">Remove <i class="fas fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="">Description (e.g. lot, house and lot, condominium and improvements)</label>
                                                <input type="text" class="form-control" name="Description" id="Description" v-model="rp.description" placeholder="Description">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="">Kind (e.g. residential, commercial, industrial, agricultural and mixed use)</label>
                                                <input type="text" class="form-control" name="Kind" id="Kind" v-model="rp.kind" placeholder="Kind">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="">Exact Location</label>
                                                <input type="text" class="form-control" name="location" id="location" v-model="rp.location" placeholder="Exact Location">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="">Assessed Value</label>
                                                <input type="numbers" step="0.001" class="form-control" name="Assessed_Value" id="Assessed_Value" v-model="rp.assessed_value" placeholder="Assessed Value">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="">Current Fair Market Value</label>
                                                <input type="number" step="0.001" class="form-control" name="Market_Value" id="Market_Value" v-model="rp.market_value" placeholder="Current Fair Market Value">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="">Acquisition Year</label>
                                                <input type="number" step="0.001" class="form-control" name="Acquisition_Year" id="Acquisition_Year" v-model="rp.acquisition_year" placeholder="Acquisition Year">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="">Acquisition Mode</label>
                                                <input type="text" class="form-control" name="Acquisition_Mode" id="Acquisition_Mode" v-model="rp.acquisition_mode" placeholder="Acquisition Mode">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="">Acquisition Cost</label>
                                                <input type="number" step="0.001" class="form-control" name="Acquisition_Cost" @input="totaAddlRealProperties()" id="Acquisition_Cost" v-model="rp.acquisition_cost" placeholder="Acquisition Cost">
                                            </div>
                                            <div class="col-md-12">
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h5 class="text-success mb-0">
                                                            Personal Properties
                                                        </h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5 class="mb-0">
                                                            Total: {{form.personal_property_subtotal}}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-primary float-right" @click="addPersonalProperties()">Add <i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <label for="">Description</label>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Year Acquired</label>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">Acquisition Cost/Ammount</label>
                                            </div>
                                        </div>
                                        <div class="form-row" v-for="(pp, i) in form.personal_property">
                                            <div class="col-md-11">
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <input type="text" class="form-control" name="description" id="description" v-model="pp.description" placeholder="Description">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <input type="text" class="form-control" name="year" id="year" v-model="pp.year" placeholder="Year Acquired">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <input type="number" step="0.001" class="form-control" name="cost" id="cost" @input="totalPersonalProperties" v-model="pp.cost" placeholder="Acquisition Cost/Ammount">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-danger" @click="removePersonalProperties(i)">Remove <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h5 class="text-primary mb-0">
                                                            Liabilities
                                                        </h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5 class="mb-0">
                                                            Total: {{ form.total_liability }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-primary float-right" @click="addLiabilities()">Add <i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="col-md-4"><label for="Nature">Nature</label></div>
                                            <div class="col-md-4"><label for="Creditors">Name of Creditors</label></div>
                                            <div class="col-md-4"><label for="Balance">Oustanding Balance</label></div>
                                        </div>
                                        <div class="form-row" v-for="(l, i) in form.liability">
                                            <div class="col-md-11">
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                    <input type="text" class="form-control" name="Nature" id="Nature" v-model="l.nature" placeholder="Nature">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <input type="text" class="form-control" name="Creditors" id="Creditors" v-model="l.creditor_name" placeholder="Name of Creditors">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <input type="number" step="0.001" class="form-control" name="Balance" id="Balance" v-model="l.balance" @input="totalLiabilities()" placeholder="Oustanding Balance">
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-danger" @click="removeLiabilities(i)">Remove <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h4 class="text-success">Total Net Worth:</h4>
                                        </div>
                                        <div class="col-md-10">
                                            <h4>
                                                {{ form.net_worth }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h5 class="text-primary">
                                                    BUSINESS INTERESTS AND FINANCIAL CONNECTIONS
                                                </h5>
                                                <h6>
                                                    (Of Declarant /Declarant’s spouse/ Unmarried Children Below Eighteen (18) years of Age Living in Declarant’s Household)
                                                </h6>
                                                <div class="row justify-content-center">
                                                    <input type="checkbox" @change="resetBusiness" v-model="business_check">
                                                    <h6 class="mt-2 ml-2">
                                                        * I/We do not have any business interest or financial connection.
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-4" v-if="business_check == false">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5>

                                                        </h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="button" class="btn btn-primary float-right" @click="addBusiness()">Add <i class="fas fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-row" v-if="business_check == false">
                                            <div class="col-md-3"><label for="name">Name of Entity/Busines Enterprise</label></div>
                                            <div class="col-md-3"><label for="address">Business Address</label></div>
                                            <div class="col-md-3"><label for="nature" class="">Nature of Business Interest &/or Financial Connection</label></div>
                                            <div class="col-md-3"><label for="date">Date of Acquisition of Interest or Connection</label></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-row" v-for="(b, i) in form.business" v-if="business_check == false">
                                            <div class="col-md-11">
                                                <div class="form-row">
                                                    <div class="form-group col-md-3">
                                                        <input type="text" class="form-control" name="name" id="name" v-model="b.name" placeholder="Name of Entity">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <input type="text" class="form-control" name="address" id="address" v-model="b.address" placeholder="Business Address">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <input type="text" class="form-control" name="nature" id="nature" v-model="b.nature" placeholder="Nature of Business">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <input type="text" class="form-control" name="date" id="date" v-model="b.date" placeholder="Date of Acquisition">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-danger" @click="removeBusiness(i)">Remove <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h5 class="text-primary">
                                                    RELATIVES IN THE GOVERNMENT SERVICE
                                                </h5>
                                                <h6>
                                                    (Within the Fourth Degree of Consanguinity or Affinity. Include also Bilas, Balae and Inso)
                                                </h6>
                                                <div class="row justify-content-center">
                                                    <input type="checkbox" @change="resetRelatives" v-model="relatives_check">
                                                    <h6 class="mt-2 ml-2">
                                                        * I/We do not know of any relative/s in the government service)
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-4" v-if="relatives_check == false">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5>

                                                        </h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="button" class="btn btn-primary float-right" @click="addRelatives()">Add <i class="fas fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-row" v-if="relatives_check == false">
                                            <div class="col-md-3"><label for="">Name of Relative</label></div>
                                            <div class="col-md-3"><label for="">Relationship</label></div>
                                            <div class="col-md-3"><label for="" class="">Position</label></div>
                                            <div class="col-md-3"><label for="">Name of Agency/Office and Address</label></div>
                                        </div>
                                        <div class="form-row" v-for="(r, i) in form.relative" v-if="relatives_check == false">
                                            <div class="col-md-11">
                                                <div class="form-row">
                                                    <div class="form-group col-md-3">
                                                    <input type="text" class="form-control" name="name" id="name" v-model="r.name" placeholder="Name">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input type="text" class="form-control" name="relationship" id="relationship" v-model="r.relationship" placeholder="Relationship">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input type="text" class="form-control" name="postion" id="postion" v-model="r.postion" placeholder="Position">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input type="text" class="form-control" name="agency_name_and_address" id="agency_name_and_address" v-model="r.agency_name_and_address" placeholder="Name of Agency/Office and Address">
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-danger" @click="removeRelatives(i)">Remove <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="gov_id1">Government Issued ID*:</label>
                                        <input type="text" class="form-control" name="gov_id1" id="gov_id1" v-model="form.gov_id1" placeholder="Government Issued ID" :class="{'is-invalid':form.errors.has('gov_id1')}">
                                        <has-error :form="form" field="gov_id1"></has-error>
                                        <label for="id1_no" class="mt-1">ID No.*:</label>
                                        <input type="text" class="form-control" name="id1_no" id="id1_no" v-model="form.idNo_id1" placeholder="ID No." :class="{'is-invalid':form.errors.has('idNo_id1')}">
                                        <has-error :form="form" field="idNo_id1"></has-error>
                                        <label for="date1_issued" class="mt-1">Date Issued*: </label>
                                        <input type="text" class="form-control" name="date1_issued" id="date1_issued" v-model="form.idDate_id1" placeholder="Date Issued" :class="{'is-invalid':form.errors.has('idDate_id1')}">
                                        <has-error :form="form" field="idDate_id1"></has-error>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="gov_id2">Government Issued ID*:</label>
                                        <input type="text" class="form-control" name="gov_id2" id="gov_id2" v-model="form.gov_id2" placeholder="Government Issued ID" :class="{'is-invalid':form.errors.has('gov_id2')}">
                                        <has-error :form="form" field="gov_id2"></has-error>
                                        <label for="id2_no" class="mt-1">ID No.*:</label>
                                        <input type="text" class="form-control" name="id2_no" id="id2_no" v-model="form.idNo_id2" placeholder="ID No." :class="{'is-invalid':form.errors.has('idNo_id2')}">
                                        <has-error :form="form" field="idNo_id2"></has-error>
                                        <label for="date2_issued" class="mt-1">Date Issued*: </label>
                                        <input type="text" class="form-control" name="date2_issued" id="date2_issued" v-model="form.idDate_id2" placeholder="Date Issued" :class="{'is-invalid':form.errors.has('idDate_id2')}">
                                        <has-error :form="form" field="idDate_id2"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary btn-block">SUBMIT</button>
                            </div>
                        </form>
                    </div> <!-- row -->
                </div>
            </div>
        </div>

        <iframe id="i" frameborder="0" hidden></iframe>

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

    </div> <!-- row -->

</template>

<script>
import axios from 'axios'

    export default {
        data(){

            return {
                editMode: false,
                business_check: false,
                relatives_check: false,
                saln_id: null,
                form: new Form({
                    'personal_information_id': null,
                    'declarant_fn': null,
                    'declarant_ln': null,
                    'declarant_mi': null,
                    'declarant_address': null,
                    'declarant_position': null,
                    'declarant_agency': null,
                    'declarant_office_address': null,
                    'spouse_ln': null,
                    'spouse_fn': null,
                    'spouse_mi': null,
                    'spouse_position': null,
                    'spouse_agency': null,
                    'real_property_subtotal': null,
                    'personal_property_subtotal': null,
                    'total_asset': null,
                    'total_liability': null,
                    'net_worth': null,
                    'date': null,
                    'gov_id1': null,
                    'idNo_id1': null,
                    'idDate_id1': null,
                    'gov_id2': null,
                    'idNo_id2': null,
                    'idDate_id2': null,
                    'children': [
                        {
                            name: null,
                            dob: null,
                            age: null,
                        }
                    ],
                    'real_property': [
                        {
                            description: null,
                            kind: null,
                            location: null,
                            assessed_value: null,
                            market_value: null,
                            acquisition_year: null,
                            acquisition_mode: null,
                            acquisition_cost: null,
                        }
                    ],
                    'personal_property': [
                        {
                            description: null,
                            year: null,
                            cost: null,
                        }
                    ],
                    'liability': [
                        {
                            nature: null,
                            creditor_name: null,
                            balance: null,
                        }
                    ],
                    'business': [
                        {
                            name: null,
                            address: null,
                            nature: null,
                            date: null,
                        }
                    ],
                    'relative': [
                        {
                            name: null,
                            relationship: null,
                            postion: null,
                            agency_name_and_address: null,
                        }
                    ]
                })
            }

        },

        beforeRouteEnter (to, from, next) {
            axios.get('api/saln?id='+to.query.id)
            .then(({data}) => {
                next(vm => vm.fetchData(data, to.query.id))
            })
            .catch(e => {

            })
        },

        methods: {
            fetchData: function(data, id){
                this.form.personal_information_id = id
                if(data != ''){
                    this.editMode = true
                    this.saln_id = data.id
                    Object.assign(this.form, data)
                }
            },
            addChildren: function(){
                this.form.children.push({
                    name: null,
                    dob: null,
                    age: null,
                })
            },
            removeChildren: function(index){
                this.form.children.splice(index, 1)
            },
            addRealProperties:  function(){
                this.form.real_property.push({
                    description: null,
                    kind: null,
                    location: null,
                    assessed_value: null,
                    market_value: null,
                    acquisition_year: null,
                    acquisition_mode: null,
                    acquisition_cost: null,
                })
            },
            removeRealProperties: function(index){
                this.form.real_property.splice(index, 1)
            },
            addPersonalProperties: function(){
                this.form.personal_property.push({
                    description: null,
                    year: null,
                    cost: null,
                })
            },
            removePersonalProperties: function(index){
                this.form.personal_property.splice(index, 1)
            },
            addLiabilities: function(){
                this.form.liability.push({
                    nature: null,
                    creditor_name: null,
                    balance: null,
                })
            },
            removeLiabilities: function(index){
                this.form.liability.splice(index, 1)
            },
            addBusiness: function (){
                this.form.business.push({
                    name: null,
                    address: null,
                    nature: null,
                    date: null,
                })
            },
            removeBusiness: function(index){
                this.form.business.splice(index, 1)
            },
            addRelatives: function(){
                this.form.relative.push({
                    name: null,
                    relationship: null,
                    postion: null,
                    agency_name_and_address: null,
                })
            },
            removeRelatives: function(index){
                this.form.relative.splice(index, 1)
            },
            resetBusiness: function(){
                this.form.business = [{name: null,
                    address: null,
                    nature: null,
                    date: null,
                }]
            },
            resetRelatives: function(){
                this.form.relative = [{
                    name: null,
                    relationship: null,
                    postion: null,
                    agency_name_and_address: null,
                }]
            },
            totaAddlRealProperties: function(){
                let total = parseInt(0)
                this.form.real_property.forEach(function(e){
                    total+=parseFloat(e.acquisition_cost ?? 0)
                })
                this.form.real_property_subtotal = total
                this.form.total_asset = this.form.real_property_subtotal + this.form.personal_property_subtotal
                this.form.net_worth = this.form.total_asset - this.form.total_liability
            },
            totalPersonalProperties: function(){
                let total = parseInt(0)
                this.form.personal_property.forEach(function(e){
                    total+=parseFloat(e.cost ?? 0)
                })
                this.form.personal_property_subtotal = total
                this.form.total_asset = this.form.real_property_subtotal + this.form.personal_property_subtotal
                this.form.net_worth = this.form.total_asset - this.form.total_liability
            },
            totalLiabilities: function(){
                let total = parseInt(0)
                this.form.liability.forEach(function(e){
                    total+=parseFloat(e.balance ?? 0)
                })
                this.form.total_liability = total
                this.form.net_worth = this.form.total_asset - this.form.total_liability
            },
            submit: function(){
                this.$Progress.start();
                this.form.post('api/saln')
                .then(e => {
                    this.$Progress.finish();
                    this.editMode = true
                    toast.fire({
                        icon: 'success',
                        title: 'SALN saved successfully'
                    });
                })
                .catch(error => {
                    this.$Progress.fail();
                    console.log(error.response.data.message)
                    toast.fire({
                        icon: 'error',
                        title: 'Something went wrong'
                    });
                })
            },
            update: function(){
                this.$Progress.start()
                this.form.patch('api/saln/'+this.saln_id)
                .then(({data}) => {
                    this.saln_id = data
                    this.$Progress.finish();
                    toast.fire({
                        icon: 'success',
                        title: 'SALN saved successfully'
                    });
                })
                .catch(e => {
                    this.$Progress.fail();
                    console.log(error.response.data.message)
                    toast.fire({
                        icon: 'error',
                        title: 'Something went wrong'
                    });
                })
            },

            printSaln:function(){
                Swal.fire({
                    title: '<strong>Generating PDS</strong>',
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

                axios.get('api/printSaln/'+this.saln_id)
                .then(e => {
                    var f = document.getElementById('i')
                    f.contentWindow.document.write(e.data)
                    setTimeout(function () {
                        f.contentWindow.focus()
                        f.contentWindow.print()

                        f.contentWindow.document.open();
                        f.contentWindow.document.write("");
                        f.contentWindow.document.close();
                    }, 500);
                    Swal.close()
                })
                .catch(error => {
                    console.log(error);
                });

            }

        }
    }

</script>
