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
                                        <td>{{ editrequests.status }}</td>
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
                                        <td>{{ edit.status }}</td>
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
            mode: 1
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

            this.mode = 1
            $('#editrequestsModal').modal('show')
        },
        validatedEdits: function(index)
        {
            this.edits = this.editrequests.data[index]['employee_edits'].filter(e => {
                return e.status != 'PENDING'
            })

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
                case 3:
                    this.cancel_edits = []
                    break
            }


            if(mode == 2)
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

            console.log(this.editrequests)

        }

    },
    created()
    {

    }

}
</script>
`
