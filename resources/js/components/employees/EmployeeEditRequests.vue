`<template>

  <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3>Requests</h3>
                </div>

                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Request status</th>
                                        <th scope="col">Date created</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center" v-for="(editrequests, index) in editrequests.data" :key="editrequests.id">
                                        <td v-bind:class="{ 'text-success': editrequests.status == 'APPROVED' || editrequests.status == 'VALIDATED',
                                                    'text-danger': editrequests.status == 'DENIED',
                                                    'text-primary': editrequests.status == 'PENDING',
                                                }">{{ editrequests.status }}</td>
                                        <td>{{ editrequests.created_at }}</td>
                                        <td style="width: calc(100%-150px);">
                                            <button type="button" class="btn btn-primary btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <a type="button" @click.prevent="view(index)" class="dropdown-item" aria-haspopup="true" aria-expanded="false" data-toggle="modal">
                                                    View Pending
                                                </a>
                                                <a class="dropdown-item" @click.prevent="validatedEdits(index)" type="button" aria-haspopup="true" aria-expanded="false" data-toggle="modal">
                                                    View Validated
                                                </a>
                                                <a class="dropdown-item" type="button" @click.prevent="deleteRequest(editrequests.id)">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <pagination size="default" :data="editrequests" @pagination-change-page="getSearchResults" :limit="5">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                    <span style="margin-left: 10px;">Page {{ editrequests.current_page }} of {{ editrequests.last_page }}</span>
                </div>
            </div>
        </div>

          <!-- modal -->
        <div class="modal fade" id="editrequestsModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                <div class="modal-header kuz-header">
                    <h5 class="modal-title" id="modal-grade">View Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                         <div class="col" v-if="mode == 1">
                            <div class="btn-group float-right p-1">
                                <button class="btn btn-primary float-right" @click.prevent="cancelEdits(2)">Cancel Request</button>
                            </div>
                            <div class="btn-group float-right p-1">
                                <button type="button" class="btn btn-primary btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" type="button" @click.prevent="cancelEdits(3)">Reset</a>
                                    <a class="dropdown-item" type="button" @click.prevent="cancelEdits(1)">Cancel all</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-responsive-sm">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Section</th>
                                        <th scope="col">Field</th>
                                        <th scope="col">Old input</th>
                                        <th scope="col">New input</th>
                                        <th scope="col">Status</th>
                                        <th v-if="mode == 1" scope="col">Cancel</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center" v-for="(edit, index) in edits" :key="edit.id">
                                        <td>{{ edit.model }}</td>
                                        <td>{{ edit.field }}</td>
                                        <td>{{ edit.oldValue }}</td>
                                        <td>{{ edit.newValue }}</td>
                                        <td v-bind:class="{ 'text-success': edit.status == 'APPROVED' || edit.status == 'VALIDATED',
                                                    'text-danger': edit.status == 'DENIED',
                                                    'text-primary': edit.status == 'PENDING',
                                                }">{{ edit.status }}</td>
                                        <td>
                                        <td v-if="mode == 1" >
                                             <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" v-model="cancel_edits" v-bind:value="edit.id">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->

</div> <!-- row -->

</template>

<script>


export default {

    data()
    {
        return {
            editrequests: {},
            edits: {},
            cancel_edits: [],
            validated_edits: {},
            mode: 1,
            personalinformation: {
                'surname':          'Surname',
                'firstname':        'First name',
                'middlename':       'Middle Name',
                'nameextension':    'Name Extension',
                'birthdate':        'Birthdate',
                'birthplace':       'Birthplace',
                'sex':              'Sex',
                'civilstatus':      'Civil Status',
                'citizenship':      'Citizenship',
                'height':           'Height',
                'weight':           'Weight',
                'bloodtype':        'Blood Type',
                'gsis':             'GSIS',
                'pagibig':          'Pag-IBIG',
                'philhealth':       'PhilHealth',
                'sss':              'SSS',
                'residentialaddress': 'Residential Address',
                'zipcode1':         'Zipcode 1',
                'telephone1':       'Telephone 1',
                'permanentaddress': 'Permanent Address',
                'zipcode2':         'Zipcode 2',
                'telephone2':       'Telephone 2',
                'email':            'Email',
                'cellphone':        'Cellphone',
                'agencynumber':     'Agency Number',
                'tin':              'TIN',
                'picture':          'Picture',
                'status':           'Status',
            },
            educationalbackground: {
                'elemSchoolName'        : 'Elementary School Name',
                'secSchoolName'         : 'Secondary  School Name',
                'vocSchoolName'         : 'Vocational  School Name',
                'collSchoolName1'       : 'College 1 School Name',
                'collSchoolName2'       : 'College 2 School Name',
                'gradSchoolName'        : 'Graduate  School Name',
                'elemDegree'            : 'Elementary Basic Educ./Degree/Course',
                'secDegree'             : 'Secondary Basic Educ./Degree/Course',
                'vocDegree'             : 'Vocational Basic Educ./Degree/Course',
                'collDegree1'           : 'College 1 Basic Educ./Degree/Course',
                'collDegree2'           : 'College 2 Basic Educ./Degree/Course',
                'gradDegree'            : 'Graduate Basic Educ./Degree/Course',
                'elemYear'              : 'Elementary Year Graduated',
                'secYear'               : 'Secondary Year Graduated',
                'vocYear'               : 'Vocational Year Graduated',
                'collYear1'             : 'College 1 Year Graduated',
                'collYear2'             : 'College 2 Year Graduated',
                'gradYear'              : 'Graduate Year Graduated',
                'elemHighestLevel'      : 'Elementary Highest Level/Units Earned',
                'secHighestLevel'       : 'Secondary Highest Level/Units Earned',
                'vocHighestLevel'       : 'Vocational Highest Level/Units Earned',
                'collHighestLevel1'     : 'College 1 Highest Level/Units Earned',
                'collHighestLevel2'     : 'College 2 Highest Level/Units Earned',
                'gradHighestLevel'      : 'Graduate Highest Level/Units Earned',
                'elemFrom'              : 'Elementary Attendance From',
                'elemTo'                : 'Elementary Attendance To',
                'secFrom'               : 'Secondary Attendance From',
                'secTo'                 : 'Secondary Attendance To',
                'vocFrom'               : 'Vocational Attendance From',
                'vocTo'                 : 'Vocational Attendance To',
                'collFrom1'             : 'College 1 Attendance From',
                'collFrom2'             : 'College 2 Attendance From',
                'collTo1'               : 'College 1 Attendance To',
                'collTo2'               : 'College 2 Attendance To',
                'gradFrom'              : 'Graduate Attendance From',
                'gradTo'                : 'Graduate Attendance To',
                'elemSOA'               : 'Elementary Scholarship/Academic Honors Recevied',
                'secSOA'                : 'Secondary Scholarship/Academic Honors Recevied',
                'vocSOA'                : 'Vocational Scholarship/Academic Honors Recevied',
                'collSOA1'              : 'College Scholarship/Academic Honors Recevied',
                'collSOA2'              : 'College Scholarship/Academic Honors Recevied',
                'gradSOA'               : 'Graduate Scholarship/Academic Honors Recevied',
            },
            educationalbackground: {
                'elemSchoolName'        : 'Elementary School Name',
                'secSchoolName'         : 'Secondary  School Name',
                'vocSchoolName'         : 'Vocational  School Name',
                'collSchoolName1'       : 'College 1 School Name',
                'collSchoolName2'       : 'College 2 School Name',
                'gradSchoolName'        : 'Graduate  School Name',
                'elemDegree'            : 'Elementary Basic Educ./Degree/Course',
                'secDegree'             : 'Secondary Basic Educ./Degree/Course',
                'vocDegree'             : 'Vocational Basic Educ./Degree/Course',
                'collDegree1'           : 'College 1 Basic Educ./Degree/Course',
                'collDegree2'           : 'College 2 Basic Educ./Degree/Course',
                'gradDegree'            : 'Graduate Basic Educ./Degree/Course',
                'elemYear'              : 'Elementary Year Graduated',
                'secYear'               : 'Secondary Year Graduated',
                'vocYear'               : 'Vocational Year Graduated',
                'collYear1'             : 'College 1 Year Graduated',
                'collYear2'             : 'College 2 Year Graduated',
                'gradYear'              : 'Graduate Year Graduated',
                'elemHighestLevel'      : 'Elementary Highest Level/Units Earned',
                'secHighestLevel'       : 'Secondary Highest Level/Units Earned',
                'vocHighestLevel'       : 'Vocational Highest Level/Units Earned',
                'collHighestLevel1'     : 'College 1 Highest Level/Units Earned',
                'collHighestLevel2'     : 'College 2 Highest Level/Units Earned',
                'gradHighestLevel'      : 'Graduate Highest Level/Units Earned',
                'elemFrom'              : 'Elementary Attendance From',
                'elemTo'                : 'Elementary Attendance To',
                'secFrom'               : 'Secondary Attendance From',
                'secTo'                 : 'Secondary Attendance To',
                'vocFrom'               : 'Vocational Attendance From',
                'vocTo'                 : 'Vocational Attendance To',
                'collFrom1'             : 'College 1 Attendance From',
                'collFrom2'             : 'College 2 Attendance From',
                'collTo1'               : 'College 1 Attendance To',
                'collTo2'               : 'College 2 Attendance To',
                'gradFrom'              : 'Graduate Attendance From',
                'gradTo'                : 'Graduate Attendance To',
                'elemSOA'               : 'Elementary Scholarship/Academic Honors Recevied',
                'secSOA'                : 'Secondary Scholarship/Academic Honors Recevied',
                'vocSOA'                : 'Vocational Scholarship/Academic Honors Recevied',
                'collSOA1'              : 'College Scholarship/Academic Honors Recevied',
                'collSOA2'              : 'College Scholarship/Academic Honors Recevied',
                'gradSOA'               : 'Graduate Scholarship/Academic Honors Recevied',
            },

            pdsquestion: {
                'refname1'          : 'Reference Name 1',
                'refaddress1'       : 'Reference Address 1',
                'reftelephone1'     : 'Reference Telephone 1',
                'refname2'          : 'Reference Name 2',
                'refaddress2'       : 'Reference Address 2',
                'reftelephone2'     : 'Reference Telephone 2',
                'refname3'          : 'Reference Name 3',
                'refaddress3'       : 'Reference Address 3',
                'reftelephone3'     : 'Reference Telephone 3',
                'govid'             : 'Government ID',
                'idnumber'          : 'ID Number',
                'dateissued'        : 'Date Issued',
            }
        }
    },
    beforeRouteEnter (to, from, next) {
        axios.get('api/getpdsEdits')
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
    },
    methods:
    {
        view: function(index)
        {
            this.edits = this.editrequests.data[index]['employee_edits'].filter(e => {
                return e.status == 'PENDING'
            })

            this.changeData(this.edits, 1)

            this.mode = 1
            $('#editrequestsModal').modal('show')
        },
        validatedEdits: function(index)
        {
            this.edits = this.editrequests.data[index]['employee_edits'].filter(e => {
                return e.status != 'PENDING'
            })

            this.changeData(this.edits, 2)

            this.mode = 2
            $('#editrequestsModal').modal('show')
        },
        getSearchResults: function(page = 1)
        {
            axios.get('api/getpdsEdits?page=' + page)
            .then(({data}) => {
                this.editrequests = data;
            }).catch(error => {
                Swal.fire(
                    'Failed',
                    error.response.statusText,
                    'warning'
                )
                console.log(error.reponse.data.message);
            });
        },
        cancelEdits: function(mode)
        {

            switch (mode){
                case 1:
                    this.cancel_edits = []
                    this.edits.forEach(e => {
                        this.cancel_edits.push(e.id)
                    })
                    break
                case 2:
                    if(this.cancel_edits.length > 0)
                    {
                        Swal.fire({
                        title: 'Are you sure?',
                        text: 'Please review changes before confirming',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Confirm'
                        }).then((result) => {
                            if(result.isDismissed == true)
                            {
                                toast.fire({
                                    icon: 'success',
                                    title: 'Cancelled'
                                });
                            }else{
                                this.$Progress.start()
                                axios.post('api/cancelEdits', this.cancel_edits)
                                .then(response => {
                                    this.$Progress.finish()
                                    toast.fire({
                                        icon: 'success',
                                        title: 'Edits Canceled'
                                    });
                                    $('#editrequestsModal').modal('hide')
                                    this.getSearchResults()
                                })
                                .catch(error => {
                                    Swal.fire(
                                        'Failed',
                                        error.response.statusText,
                                        'warning'
                                    )
                                    console.log(error.reponse.data.message);
                                })
                            }
                        })
                    }else{
                        toast.fire({
                            icon: 'warning',
                            title: 'Nothing to cancel'
                        });
                    }
                    break
                case 3:
                    this.cancel_edits = []
                    break
            }
        },
        deleteRequest: function(id)
        {
            Swal.fire({
            title: 'Are you sure?',
            text: 'Please review changes before confirming',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm'
            })
            .then((result) => {
                if(result.isDismissed == true)
                {
                    toast.fire({
                        icon: 'success',
                        title: 'Cancelled'
                    });
                }else{
                    this.$Progress.start()
                    axios.delete('api/employeepersonalinformation/'+id)
                    .then(response =>{
                        toast.fire({
                            icon: 'success',
                            title: 'Request Canceled'
                        });
                        this.$Progress.finish()
                        this.getSearchResults()
                    })
                    .catch(error => {
                        Swal.fire(
                            'Failed',
                            error.response.data.message,
                            'warning'
                        )
                        this.$Progress.finish()
                        console.log(error.response.data.message);
                    })
                }
            })
        },
        fetchData: function(data)
        {

            this.editrequests = data

        },
        changeData: function(edits, mode)
        {
            edits.forEach(e => {
                if(e.model == "personalinformation")
                {
                    e.model = 'Personal Information'

                    for(var data in this.personalinformation)
                    {
                        if(data == e.field)
                        {
                            e.field = this.personalinformation[data]
                        }
                    }
                }

                if(e.model == "familybackground")
                {
                    e.model = 'Family Background'

                    let s = e.field.replace(/([A-Z])/g, ' $1').trim()

                    e.field = s.charAt(0).toUpperCase() + s.slice(1)
                }

                if(e.model == "children")
                {
                    e.model = 'Children'

                    e.field = e.field.charAt(0).toUpperCase() + e.field.slice(1)
                }

                if(e.model == "educationalbackground")
                {
                    e.model = 'Educational Background'

                    for(var data in this.educationalbackground)
                    {
                        if(data == e.field)
                        {
                            e.field = this.educationalbackground[data]
                        }
                    }
                }

                if(e.model == "eligibilities")
                {
                    e.model = 'Eligibilities'

                    let s = e.field.replace(/([A-Z])/g, ' $1').trim()

                    e.field = s.charAt(0).toUpperCase() + s.slice(1)
                }

                if(e.model == "otherinfos")
                {
                    e.model = 'Other Information'

                    let s = e.field.replace(/([A-Z])/g, ' $1').trim()

                    e.field = s.charAt(0).toUpperCase() + s.slice(1)
                }

                if(e.model == "workexperiences")
                {
                    e.model = 'Work Experiences'

                    let s = e.field.replace(/([A-Z])/g, ' $1').trim()

                    e.field = s.charAt(0).toUpperCase() + s.slice(1)
                }

                if(e.model == "voluntaryworks")
                {
                    e.model = 'Voluntary Works'

                    let s = e.field.replace(/([A-Z])/g, ' $1').trim()

                    e.field = s.charAt(0).toUpperCase() + s.slice(1)
                }

                if(e.model == "trainingprograms")
                {
                    e.model = 'Training Programs'

                    let s = e.field.replace(/([A-Z])/g, ' $1').trim()

                    e.field = s.charAt(0).toUpperCase() + s.slice(1)
                }

                if(e.model == "pdsquestion")
                {
                    e.model = 'Last Page'

                    for(var data in this.pdsquestion)
                    {
                        if(data == e.field)
                        {
                            e.field = this.pdsquestion[data]
                        }
                    }
                }
            })

            if(mode == 1)
            {
                this.edits = edits
            }else if(mode == 2){
                this.reviewed = edits
            }

        }

    },
    created()
    {

    }

}
</script>
`
