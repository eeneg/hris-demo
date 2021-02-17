<template>
    <div class="row justify-content-center">
        <div class="col-md-12 text-center" v-if="$gate.isOfficeUser()">
            <not-authorized></not-authorized>
        </div>
        <div class="col-md-12" v-if="!$gate.isOfficeUser()">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h3>Pending Requests</h3>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-3 float-right">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search" v-model="search" @keyup.prevent="searchRequest">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fas fa-search"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Name</th>
                                        <th scope="col">Request status</th>
                                        <th scope="col">Date created</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center" v-for="(pendingRequest, index) in pendingRequest.data" :key="pendingRequest.id">
                                        <td>{{ pendingRequest.surname }}, {{ pendingRequest.firstname }} {{ pendingRequest.nameextension }}</td>
                                        <td>{{ pendingRequest.status }}</td>
                                        <td>{{ pendingRequest.created_at }}</td>
                                        <td style="width: calc(100%-150px);">
                                            <button type="button" class="btn btn-primary btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <a type="button" @click.prevent="viewPending(index)" class="dropdown-item" aria-haspopup="true" aria-expanded="false" data-toggle="modal">
                                                    View Pending
                                                </a>
                                                <a class="dropdown-item" @click.prevent="viewReviewed(index)" type="button" aria-haspopup="true" aria-expanded="false" data-toggle="modal">
                                                    View Reviewed
                                                </a>
                                                <a class="dropdown-item" type="button" @click.prevent="deleteRequest(pendingRequest.id)">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <pagination size="default" :data="pendingRequest" @pagination-change-page="getSearchResults" :limit="5">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                    <span style="margin-left: 10px;">Page {{ pendingRequest.current_page }} of {{ pendingRequest.last_page }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-12" v-if="!$gate.isOfficeUser()">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h3>Validated Requests</h3>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-3 float-right">
                                <input type="text" name="searchReviewed" id="searchReviewed" class="form-control" placeholder="Search" v-model="searchReviewed" @keyup.prevent="reviwedRequestSearch">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fas fa-search"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Name</th>
                                        <th scope="col">Request status</th>
                                        <th scope="col">Date approved</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center" v-for="(reviwedRequest, index) in reviwedRequest.data" :key="reviwedRequest.id">
                                        <td>{{ reviwedRequest.surname }}, {{ reviwedRequest.firstname }} {{ reviwedRequest.nameextension }}</td>
                                        <td>{{ reviwedRequest.status }}</td>
                                        <td>{{ reviwedRequest.updated_at }}</td>
                                        <td style="width: calc(100%-150px);">
                                            <button type="button" class="btn btn-primary btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <a type="button" class="dropdown-item" @click.prevent="viewValidatedRequestRequest(index)" aria-haspopup="true" aria-expanded="false" data-toggle="modal">
                                                    View
                                                </a>
                                                <a class="dropdown-item" type="button" @click.prevent="deleteRequest(reviwedRequest.id)">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <pagination size="default" :data="reviwedRequest" @pagination-change-page="getReviewedSearchResults" :limit="5">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                    <span style="margin-left: 10px;">Page {{ reviwedRequest.current_page }} of {{ reviwedRequest.last_page }}</span>
                </div>
            </div>
        </div>

        <!-- modal -->
        <div class="modal fade" id="pendingRequestsModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                <div class="modal-header kuz-header">
                    <h5 class="modal-title" id="modal-grade">View Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 p-1">
                                <div class="col">
                                    <div class="btn-group float-right p-1">
                                        <button class="btn btn-primary float-right" @click.prevent="save(2)">Save</button>
                                    </div>
                                    <div class="btn-group float-right p-1">
                                        <button type="button" class="btn btn-primary btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" type="button" @click.prevent="save(3)">Reset</a>
                                            <a class="dropdown-item" type="button" @click.prevent="save(0)">Deny All</a>
                                            <a class="dropdown-item" type="button" @click.prevent="save(1)">Accept all</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-striped table-responsive-sm">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">Section</th>
                                                <th scope="col">Field</th>
                                                <th scope="col">Old input</th>
                                                <th scope="col">New input</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Accept</th>
                                                <th scope="col">Deny</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center" v-for="(edit, index) in edits" :key="edit.id">
                                                <td>{{ edit.model }}</td>
                                                <td>{{ edit.field }}</td>
                                                <td>{{ edit.oldValue }}</td>
                                                <td>{{ edit.newValue }}</td>
                                                <td v-bind:class="{ 'text-success': edit.status == 'APPROVED',
                                                                    'text-danger': edit.status == 'DENIED',
                                                                    'text-primary': edit.status == 'PENDING',
                                                                }">{{ edit.status }}</td>
                                                <td>
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" v-model="acceptedRequest.accept" v-bind:value="edit.id">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" v-model="acceptedRequest.deny" v-bind:value="edit.id">
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
            </div>
        </div><!-- modal -->

         <!-- modal -->
        <div class="modal fade" id="reviewedModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                <div class="modal-header kuz-header">
                    <h5 class="modal-title" id="modal-grade">Reviewed</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col">
                                    <div class="btn-group float-right p-1">
                                        <button class="btn btn-primary float-right" @click.prevent="revertRequest(0)">Save</button>
                                    </div>
                                    <div class="btn-group float-right p-1">
                                        <button class="btn btn-primary float-right" @click.prevent="revertRequest(1)">Revert all</button>
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
                                                <th scope="col">Revert</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center" v-for="(data, index) in reviewed" :key="data.id">
                                                <td>{{ data.model }}</td>
                                                <td>{{ data.field }}</td>
                                                <td>{{ data.oldValue }}</td>
                                                <td>{{ data.newValue }}</td>
                                                <td v-bind:class="{ 'text-success': data.status == 'APPROVED',
                                                                    'text-danger': data.status == 'DENIED',
                                                                }">{{ data.status }}
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" v-model="revert" v-bind:value="data">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- modal -->

         <!-- modal -->
        <div class="modal fade" id="validatedRequestModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                <div class="modal-header kuz-header">
                    <h5 class="modal-title" id="modal-grade">Reviewed</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col">
                                    <div class="btn-group float-right p-1">
                                        <button class="btn btn-primary float-right" @click.prevent="revertRequest(0)">Save</button>
                                    </div>
                                    <div class="btn-group float-right p-1">
                                        <button class="btn btn-primary float-right" @click.prevent="revertRequest(2)">Revert all</button>
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
                                                <th scope="col">Revert</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center" v-for="(data, index) in validatedRequest" :key="data.id">
                                                <td>{{ data.model }}</td>
                                                <td>{{ data.field }}</td>
                                                <td>{{ data.oldValue }}</td>
                                                <td>{{ data.newValue }}</td>
                                                <td v-bind:class="{ 'text-success': data.status == 'APPROVED',
                                                                    'text-danger': data.status == 'DENIED',
                                                                }">{{ data.status }}
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" v-model="revert" v-bind:value="data">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- modal -->

    </div>
</template>

<script>
    export default {
         data()
    {
        return {
            search: '',
            searchReviewed: '',
            acceptedRequest: {accept: [], deny: []},
            pendingRequest: {},
            reviwedRequest: {},
            edits: {},
            reviewed: {},
            validatedRequest: {},
            editIndex: '',
            revert: [],
            personal_information_id: ''
        }
    },
    beforeRouteEnter (to, from, next) {
        axios.get('api/request')
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
        searchRequest: _.debounce(function(){
                this.getSearchResults();
        }, 400),
        reviwedRequestSearch: _.debounce(function(){
                this.getReviewedSearchResults();
        }, 400),
        viewPending: function(index)
        {
            this.edits = this.pendingRequest.data[index]['employee_edits'].filter(e => {
                return e.status == 'PENDING'
            })

            this.acceptedRequest = {accept: [], deny: []}
            $('#pendingRequestsModal').modal('show')

            this.editIndex = index
        },
        viewReviewed: function(index)
        {
            this.reviewed = this.pendingRequest.data[index]['employee_edits'].filter(e => {
                return e.status != 'PENDING'
            })

            this.acceptedRequest = {accept: [], deny: []}
            this.revert = []
            this.editIndex = index
            this.personal_information_id = this.pendingRequest.data[this.editIndex]['personal_information_id']
            $('#reviewedModal').modal('show')

        },
        viewValidatedRequestRequest: function(index)
        {
            this.validatedRequest = this.reviwedRequest.data[index]['employee_edits']

            this.acceptedRequest = {accept: [], deny: []}
            this.revert = []
            this.editIndex = index
            this.personal_information_id = this.reviwedRequest.data[this.editIndex]['personal_information_id']
            $('#validatedRequestModal').modal('show')
        },
        getSearchResults: function(page = 1)
        {
            axios.get('api/request?page=' + page + '&search=' + this.search)
            .then(({data}) => {
                this.pendingRequest = data;
            }).catch(error => {
                console.log(error.reponse.data.message);
            });
        },
        getReviewedSearchResults: function(page = 1)
        {
            axios.get('api/reviewedRequest?page=' + page + '&search=' + this.searchReviewed)
            .then(({data}) => {
                this.reviwedRequest = data;
            }).catch(error => {
                console.log(error.reponse.data.message);
            });
        },
        save: function(mode)
        {
            let s = false

            switch (mode){
                case 1:
                    this.acceptedRequest.deny = []
                    this.edits.forEach(e => {
                        if(e.id)
                        {
                            this.acceptedRequest.accept.push(e.id)
                        }
                    });
                    break
                case 2:
                    if(this.acceptedRequest.accept.length != 0 || this.acceptedRequest.deny.length != 0)
                    {
                        s = true
                    }else{
                        toast.fire({
                            icon: 'error',
                            title: 'Empty'
                        });
                    }
                    break
                case 3:
                    this.acceptedRequest = {accept: [], deny: []}
                    break
                case 0:
                    this.acceptedRequest.accept = []
                    this.edits.forEach(e => {
                        if(e.id)
                        {
                            this.acceptedRequest.deny.push(e.id)
                        }
                    });
                    break
            }

            if(s == true)
            {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Please review changes before confirming',
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
                        this.$Progress.start()

                        const intersection = this.acceptedRequest.accept.filter(e => this.acceptedRequest.deny.indexOf(e) !== -1);

                        if(intersection.length == 0)
                        {
                            axios.post('api/acceptEditRequest?id='+this.pendingRequest.data[this.editIndex]['id'] + '&mode=' +mode, this.acceptedRequest)
                            .then(response => {
                                toast.fire({
                                    icon: 'success',
                                    title: 'Submitted'
                                });
                                this.$Progress.finish()
                                this.acceptedRequest.accept = []
                                this.acceptedRequest.deny = []
                                this.getSearchResults()
                                this.getReviewedSearchResults()
                                $('#pendingRequestsModal').modal('hide')
                            })
                            .catch(error => {
                                Swal.fire(
                                    'Oops...',
                                    error.response.statusText,
                                    'error'
                                )
                                console.log(error)
                            })
                        }else{
                             Swal.fire(
                                'Oops...',
                                'Can only select one option for each edits',
                                'error'
                            )
                        }
                    }
                })
            }
        },
        deleteRequest: function(id)
        {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if(result.isDismissed == true)
                {
                    toast.fire({
                        icon: 'success',
                        title: 'Cancelled'
                    });
                }else{
                    this.$Progress.start()

                    axios.delete('api/request/'+ id)
                    .then(response => {
                        toast.fire({
                            icon: 'success',
                            title: 'Deleted'
                        });
                        this.$Progress.finish()
                        this.acceptedRequest.accept = []
                        this.acceptedRequest.deny = []
                        this.getSearchResults()
                        this.getReviewedSearchResults()
                    })
                    .catch(error => {
                        Swal.fire(
                            'Oops...',
                            error.response.statusText,
                            'error'
                        )
                        console.log(error)
                    })
                }
            })
        },
        revertRequest: function(mode)
        {
            let s = false

            switch (mode){
                case 0:
                    s = true
                    break
                case 1:
                    this.revert = []
                    this.reviewed.forEach(e => {
                        this.revert.push(e)
                    })
                    this.personal_information_id = this.pendingRequest.data[this.editIndex]['personal_information_id']
                    break
                case 2:
                    this.revert = []
                    this.validatedRequest.forEach(e => {
                        this.revert.push(e)
                    })
                    this.personal_information_id = this.reviwedRequest.data[this.editIndex]['personal_information_id']
                    break
            }

            if(s == true)
            {
                Swal.fire({
                title: 'Are you sure?',
                text: "Please review changes!",
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
                        this.$Progress.start()

                        axios.post('api/revertRequest?id='+ this.personal_information_id, this.revert)
                        .then(response => {
                            toast.fire({
                                icon: 'success',
                                title: 'Submitted'
                            });
                            this.$Progress.finish()
                            this.revert = []
                            this.getSearchResults()
                            this.getReviewedSearchResults()
                            $('#validatedRequestModal').modal('hide')
                            $('#reviewedModal').modal('hide')
                        })
                        .catch(error => {
                            Swal.fire(
                                'Oops...',
                                error.response.statusText,
                                'error'
                            )
                            console.log(error)
                        })
                    }
                })
            }
        },
        fetchData: function(pending)
        {
            this.pendingRequest = pending

            axios.get('api/reviewedRequest')
            .then(({data}) => {
                this.reviwedRequest = data
            })
            .catch(error => {
                Swal.fire(
                    'Failed',
                    error.response.statusText,
                    'warning'
                )
            })
        },


    },
    created()
    {

    }

}
</script>
