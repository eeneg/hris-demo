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
                            <h3>
                               (Under Development)
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <h2 for="">Declarant</h2>
                        </div>

                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="">Family Name*</label>
                                    <input type="text" class="form-control" name="" id="" placeholder="Family Name">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">First Name*</label>
                                    <input type="text" class="form-control" name="" id="" placeholder="First Name">
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">M.I.*</label>
                                    <input type="text" class="form-control" name="" id="" placeholder="M.I.">
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="dec_address">Address*</label>
                                    <input type="text" class="form-control" name="dec_address" id="dec_address" placeholder="Address">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dec_position">Position*</label>
                                    <input type="text" class="form-control" name="dec_position" id="dec_position" placeholder="Position">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dec_agency">Agency/Office*</label>
                                    <input type="text" class="form-control" name="dec_agency" id="dec_agency" placeholder="Agency/Office">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dec_office">Office Address*</label>
                                    <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Office Address">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        <div class="col-md-12">
                            <h2 for="spouce_name">Spouse</h2>
                        </div>

                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="">Family Name*</label>
                                    <input type="text" class="form-control" name="" id="" placeholder="Family Name">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">First Name*</label>
                                    <input type="text" class="form-control" name="" id="" placeholder="First Name">
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">M.I.*</label>
                                    <input type="text" class="form-control" name="" id="" placeholder="M.I.">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dec_position">Position*</label>
                                    <input type="text" class="form-control" name="dec_position" id="dec_position" placeholder="Position">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dec_agency">Agency/Office*</label>
                                    <input type="text" class="form-control" name="dec_agency" id="dec_agency" placeholder="Agency/Office">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dec_office">Office Address*</label>
                                    <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Office Address">
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
                                            <h5>
                                                UNMARRIED CHILDREN BELOW EIGHTEEN (18) YEARS OF AGE LIVING IN DECLARANT’S HOUSEHOLD
                                            </h5>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-primary float-right">Add <i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="col-md-6"><label for="">Name</label></div>
                                        <div class="col-md-3"><label for="">Date of Birth</label></div>
                                        <div class="col-md-2"><label for="">Age</label></div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Name">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="date" class="form-control" name="dec_office" id="dec_office" placeholder="Office Address">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Age">
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
                                            <h5>
                                                ASSETS, LIABILITIES AND NETWORTH
                                            </h5>
                                            <h6>
                                                (Including those of the spouse and unmarried children below eighteen (18)
                                                years of age living in declarant’s household)
                                            </h6>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5>
                                                        ASSETS
                                                    </h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <button class="btn btn-primary float-right">Add <i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="">Description (e.g. lot, house and lot, condominium and improvements)</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Description">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Kind (e.g. residential, commercial, industrial, agricultural and mixed use)</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Kind">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Exact Location</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Exact Location">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="">Assessed Value</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Assessed Value">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="">Current Fair Market Value</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Current Fair Market Value">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="">Acquisition Year</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Acquisition Year">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="">Acquisition Mode</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Acquisition Mode">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Acquisition Cost</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Acquisition Cost">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>
                                                PERSONAL PROPERTIES
                                            </h5>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-primary float-right">Add <i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="">Description</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Description">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Year Acquired</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Year Acquired">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Acquisition Cost/Ammount</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Acquisition Cost/Ammount">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>
                                                LIABILITIES
                                            </h5>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-primary float-right">Add <i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="">Nature</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Nature">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Name of Creditors</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Name of Creditors">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Oustanding Balance</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Oustanding Balance">
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
                                            <h5>
                                                BUSINESS INTERESTS AND FINANCIAL CONNECTIONS
                                            </h5>
                                            <h6>
                                                (Of Declarant /Declarant’s spouse/ Unmarried Children Below Eighteen (18) years of Age Living in Declarant’s Household)
                                            </h6>
                                            <h6>
                                                * I/We do not have any business interest or financial connection.
                                            </h6>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5>

                                                    </h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <button class="btn btn-primary float-right">Add <i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="">Name of Entity/Busines Enterprise</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Name of Entity">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="">Business Address</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Business Address">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="" class="">Nature of Business Interest &/or Financial Connection</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Nature of Business">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="">Date of Acquisition of Interest or Connection</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Date of Acquisition">
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
                                            <h5>
                                                RELATIVES IN THE GOVERNMENT SERVICE
                                            </h5>
                                            <h6>
                                                (Within the Fourth Degree of Consanguinity or Affinity. Include also Bilas, Balae and Inso)
                                            </h6>
                                            <h6>
                                                * I/We do not know of any relative/s in the government service)
                                            </h6>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5>

                                                    </h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <button class="btn btn-primary float-right">Add <i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="">Name of Relative</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Name">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="">Relationship</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Relationship">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="" class="">Position</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Position">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="">Name of Agency/Office and Address</label>
                                            <input type="text" class="form-control" name="dec_office" id="dec_office" placeholder="Name of Agency/Office and Address">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button>SUBMIT!</button>
                        </div>
                    </div> <!-- row -->
                </div>
            </div>
        </div>
    </div> <!-- row -->

</template>

<script>

    export default {

        data(){

            return {

            }

        },

        methods: {


        }
    }

</script>
