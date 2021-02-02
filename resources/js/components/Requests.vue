<template>
    <div class="row justify-content-center">
        <div class="col-md-12 text-center" v-if="$gate.isOfficeUser()">
            <not-authorized></not-authorized>
        </div>
        <div class="col-md-12" v-if="!$gate.isOfficeUser()">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        Requests
                    </div>
                </div>

                    <div class="card-body">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Search" v-model="search" @keyup.prevent="searchRequest">
                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fas fa-search"></i></div>
                                    </div>
                                </div>
                            </div>
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
                                        <tr class="text-center" v-for="(editrequests, index) in editrequests.data" :key="editrequests.id">
                                            <td>{{ editrequests.surname }}, {{ editrequests.firstname }} {{ editrequests.nameextension }}</td>
                                            <td>{{ editrequests.status }}</td>
                                            <td>{{ editrequests.created_at }}</td>
                                            <td style="width: calc(100%-150px);">
                                                <div class="btn-group">
                                                    <button type="button" @click="view(index)" class="btn btn-sm btn-info" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#editrequestssModal">
                                                        View
                                                    </button>
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
        <div class="modal fade" id="editrequestssModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                        <button class="btn btn-success float-right" @click.prevent="save(1)">Accept all</button>
                                    </div>
                                    <div class="btn-group float-right p-1">
                                        <button class="btn btn-danger" @click.prevent="save(0)">Deny all</button>
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
                                                            <input class="form-check-input" type="checkbox" v-model="acceptedRequest" v-bind:value="edit.id">
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

    </div>
</template>

<script>
    export default {
         data()
    {
        return {
            search: '',
            acceptedRequest: [],
            editrequests: {},
            edits: {},
            editIndex: '',
            name: ''
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
        view: function(index)
        {
            this.edits = this.editrequests.data[index]['employee_edits']
            this.editIndex = index
        },
        getSearchResults: function(page = 1)
        {
            axios.get('api/request?page=' + page + '&search=' + this.search)
            .then(({data}) => {
                this.editrequests = data;
                console.log(this.editrequests)
            }).catch(error => {
                console.log(error.reponse.data.message);
            });
        },
        save: function(mode)
        {
            let s = false


            switch (mode){
                case 1:
                    this.edits.forEach(e => {
                        if(e.id)
                        {
                            this.acceptedRequest.push(e.id)
                        }
                    });
                    break
                case 2:
                    console.log(this.acceptedRequest.length)
                    if(this.acceptedRequest.length != 0)
                    {
                        s = true
                    }else{
                        toast.fire({
                            icon: 'error',
                            title: 'Empty'
                        });
                    }
                    break
                case 0:
                        this.acceptedRequest = []
                        s = true
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
                        // this.acceptedRequest = []
                        toast.fire({
                            icon: 'success',
                            title: 'Cancelled'
                        });
                    }else{
                        this.$Progress.start()
                        axios.post('api/acceptEditRequest?id='+this.editrequests.data[this.editIndex]['id'] + '&mode=' +mode, this.acceptedRequest)
                        .then(response => {
                            toast.fire({
                                icon: 'success',
                                title: 'Submitted'
                            });
                            this.$Progress.finish()
                            this.acceptedRequest = []
                            this.getSearchResults()
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
