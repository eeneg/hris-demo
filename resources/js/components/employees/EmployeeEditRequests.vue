<template>

  <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Requests
                </div>

                <div class="card-body">
                    <div class="row align-items-end">
                        <!-- <div class="col-md-4">
                            <div class="input-group mb-3">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search" v-model="search" @keyup.prevent="searchAppointment">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fas fa-search"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="" class="p-0">Reckoning date from: </label>
                                <input type="date" name="reckoning_date_from" id="reckoning_date_from" class="form-control" v-model="reckoning_date_from" @change="searchAppointment">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="" class="p-0">Reckoning date to: </label>
                                <input type="date" name="reckoning_date_to" id="reckoning_date_to" class="form-control" v-model="reckoning_date_to" @change="searchAppointment">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button class="btn btn-primary float-right mb-3" type="button" @click="createAppointments()" data-toggle="modal">Create <i class="fas fa-plus"></i></button>
                            </div>
                        </div> -->
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <!-- <th scope="col">Name</th> -->
                                        <th scope="col">Request status</th>
                                        <th scope="col">Date created</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center" v-for="(editrequests, index) in editrequests.data" :key="editrequests.id">
                                        <!-- <td>{{ editrequests.surname }}, {{ editrequests.firstname }} {{ editrequests.nameextension }}</td> -->
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
                        <table class="table table-striped table-responsive-sm">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Section</th>
                                        <th scope="col">Field</th>
                                        <th scope="col">Old input</th>
                                        <th scope="col">New input</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center" v-for="(edit, index) in edits" :key="edit.id">
                                        <td>{{ edit.model }}</td>
                                        <td>{{ edit.field }}</td>
                                        <td>{{ edit.oldValue }}</td>
                                        <td>{{ edit.newValue }}</td>
                                        <td>{{ edit.status }}</td>
                                    </tr>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- modal -->

</div> <!-- row -->

</template>

<script>


export default {

    data()
    {
        return {
            editrequests: {},
            edits: {}
        }
    },
    beforeRouteEnter (to, from, next) {
        axios.get('api/getPdsEdits')
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
            this.edits = this.editrequests.data[index]['employee_edits']
        },
        getSearchResults: function(page = 1)
        {
            axios.get('api/getPdsEdits?page=' + page)
            .then(({data}) => {
                this.editrequests = data;
            }).catch(error => {
                console.log(error.reponse.data.message);
            });
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
