<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Employee Status</h3>
                            <p>Input Employee Status</p>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary float-right" @click="status_modal(1, null, false, null)"><i class="fas fa-save"></i> Add Status</button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row justify-content-between">

                    </div>
                    <div class="row">
                        <div class="card-body table-responsive p-0" style="height: 600px;">
                            <table class="table table-striped text-nowrap custom-table">
                                <thead>
                                    <tr>
                                        <th>Employee Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="data in status" :key="data.id">
                                        <td>{{data.status}}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary btn-info dropdown-toggle right" style="float: right; !important" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <a type="button" class="dropdown-item" @click="status_modal(2, data.status, true, data.id)">
                                                    Edit
                                                </a>
                                                <a class="dropdown-item" type="button" @click="delete_status(data.id)" aria-haspopup="true" aria-expanded="false" data-toggle="modal">
                                                    Delete
                                                </a>
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


        <!-- modal -->

        <div class="modal fade" id="status_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 p-2">
                                <input type="text" @input="clear_error" v-model="status_data" class="form-control" id="retirement_date" placeholder="Enter Status">
                                <p class="text-danger" v-for="data in error" :key="data.id">{{data[0]}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary float-right" data-toggle="modal" @click="edit_mode == false ? submit_status() : submit_edit_status()">Save <i class="fas fa-save"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal end -->

    </div> <!-- row -->
</template>
<script>
import axios from 'axios'
import { Toast } from 'bootstrap'
import Swal from 'sweetalert2'

export default {
  data()
    {
        return {
            status_id: null,
            edit_mode: false,
            status: [],
            status_data: null,
            error: []
        }
    },

    methods: {
        get_status: function()
        {
            axios.get('api/status')
            .then((data) => {
                this.status = data.data
            })
            .catch(e => {
                console.log(e)
            })
        },

        clear_error: function()
        {
            this.error = []
        },

        status_modal: function(mode, data, edit, id)
        {
            $('#status_modal').modal('show')
            this.edit_mode = edit
            this.status_id = id
            this.status_data = mode == 1 ? null : data
        },

        submit_status: function()
        {
            axios.post('api/status', {'status': this.status_data})
            .then(response => {

                this.get_status()
                $('#status_modal').modal('hide')
                toast.fire({
                    icon: 'success',
                    title: 'Success'
                })

            })
            .catch(e => {
                Swal.fire(
                    'Ooops!',
                    'Something went wrong!',
                    'error'
                )
                this.error = e.response.data.errors
            })
        },

        submit_edit_status: function()
        {
            axios.patch('api/status/'+this.status_id, {'status': this.status_data})
            .then(response => {

                this.get_status()
                $('#status_modal').modal('hide')
                toast.fire({
                    icon: 'success',
                    title: 'Success'
                })

            })
            .catch(e => {
                Swal.fire(
                    'Ooops!',
                    'Something went wrong!',
                    'error'
                )
                this.error = e.response.data.errors
            })
        },

        delete_status: function(id)
        {
            Swal.fire({
            title: 'Are you sure?',
            text: "You cannot revert this!!!",
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
                    axios.delete('api/status/' + id)
                    .then(response => {
                        this.get_status()
                        this.$Progress.finish()
                        toast.fire({
                            icon: 'success',
                            title: 'Deleted!'
                        });
                    })
                    .catch(e => {
                        console.log(e)
                        Swal.fire(
                            'Ooops!',
                            'Cannot delete status!',
                            'error'
                        )
                    })
                }
            })
        },
    },

    created: function() {

    },

    mounted: function() {
        this.get_status()
    }
}
</script>
