<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h2 style="margin:0.5rem 0 0 0;line-height:1.2rem;">Types of leave</h2>
                    <small style="margin-left: 2px;">Description Description Description Description Description</small>
                    <div class="row mt-3">
                        <div v-if="$gate.isAdministratorORAuthor()" class="col-md-12">
                            <button type="button" class="btn btn-primary" @click="addNewTypeModal()">Add New Type</button>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0" style="height: 650px;">
                    <table class="table text-nowrap table-striped custom-table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Max Duration</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="leavetype in leavetypes.data" :key="leavetype.id">
                                <td>{{ leavetype.title}} <span v-if="leavetype.abbreviation" class="text-muted">{{ ' (' + leavetype.abbreviation + ')' }}</span> </td>
                                <td class="text-muted">
                                    <span v-if="leavetype.description">{{ leavetype.description }}</span>
                                    <span v-else>No data</span>
                                </td>
                                <td>{{ leavetype.max_duration }}</td>
                                <td><span style="font-size: 100%;font-weight: normal;" :class="leavetype.status == 'active' ? 'badge bg-success' : 'badge bg-warning'">{{ leavetype.status }}</span></td>
                                <td v-if="$gate.isAdministrator()">
                                    <a style="float:right" class="btn btn-info btn-sm" href="" @click.prevent="editLeaveTypeModal(leavetype)">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <pagination size="default" :data="leavetypes" @pagination-change-page="getResults" :limit="5">
                        <span slot="prev-nav">&lt; Previous</span>
	                    <span slot="next-nav">Next &gt;</span>
                    </pagination>
                    <span style="margin-left: 10px;">Showing {{ leavetypes && leavetypes.from | validateCount }} to {{ leavetypes && leavetypes.to | validateCount }} of {{ leavetypes && leavetypes.total }} records</span>
                </div>
            </div>
        </div>
        
        <!-- Add Item Modal -->
        <div class="modal fade" id="add-leavetype-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ editmode ? 'Update Leave type' : 'Create Leave type' }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form autocomplete="off" @submit.prevent="editmode ? editLeaveType() : addLeaveType()">
                        <div class="modal-body">
                            <div class="form-group" style="margin-bottom: 0.3rem;">
                                <label for="title" style="margin: 0;">Type</label>
                                <input v-model="form.title" type="text" class="form-control form-control-border border-width-2" name="title" id="title" placeholder="Leave Type" requiredclass="form-control" 
                                    :class="{ 'is-invalid': form.errors.has('title') }">
                                <has-error :form="form" field="title"></has-error>
                            </div>
                            <div class="form-group" style="margin-bottom: 0.3rem;">
                                <label style="margin: 0;">Description</label>
                                <textarea v-model="form.description" name="description" class="form-control form-control-border border-width-2" rows="2" placeholder="Enter description. . ."></textarea>
                            </div>
                            <div class="row">
                                <div class="col-8" style="padding-right: 5px;">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="max_duration" style="margin: 0;">Max Duration</label>
                                        <input v-model="form.max_duration" type="text" class="form-control form-control-border border-width-2" name="max_duration" id="max_duration" placeholder="Max Duration" required>
                                    </div>
                                </div>
                                <div class="col-4" style="padding-left: 5px;">
                                    <div class="form-group" style="margin-bottom: 0.3rem;">
                                        <label for="abbreviation" style="margin: 0;">Abbreviation</label>
                                        <input v-model="form.abbreviation" type="text" class="form-control form-control-border border-width-2" name="abbreviation" id="abbreviation" placeholder="Abbreviation">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status" style="margin: 0;">Status</label>
                                <select v-model="form.status" name="status" class="custom-select form-control-border border-width-2" id="status">
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                editmode: false,
                leavetypes: {},
                form: new Form({
                    'id': '',
                    'title': '',
                    'description': '',
                    'abbreviation': '',
                    'max_duration': '',
                    'status': 'active'
                })
            }
        },
        methods: {
            getResults(page = 1) {
                axios.get('api/leavetype?page=' + page)
                    .then(({data}) => {
                        this.leavetypes = data;
                    }).catch(error => {
                        console.log(error.reponse.data.message);
                    });
            },
            editLeaveTypeModal(leavetype) {
                this.editmode = true;
                this.form.reset();
                this.form.fill(leavetype);
                $('#add-leavetype-modal').modal('show');
            },
            addNewTypeModal() {
                $('#add-leavetype-modal').modal('show');
            }, 
            addLeaveType() {
                this.$Progress.start();
                this.form.post('api/leavetype')
                    .then(({data}) => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'New leave type is created successfully',
                        })
                        this.loadContents();
                        $('#add-leavetype-modal').modal('hide');
                        this.$Progress.finish();
                    })
                    .catch(error => {
                        this.$Progress.fail();
                        console.log(error.response.data.message);
                    });
            },
            editLeaveType() {
                this.$Progress.start();
                this.form.put('api/leavetype/' + this.form.id)
                    .then(({data}) => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Leave type is updated successfully',
                        })
                        this.loadContents();
                        $('#add-leavetype-modal').modal('hide');
                        this.$Progress.finish();
                    })
                    .catch(error => {
                        this.$Progress.fail();
                        console.log(error.response.data.message);
                    });
            },
            loadContents() {
                this.$Progress.start();
                axios.get('api/leavetype ')
                    .then(({data}) =>{
                        this.leavetypes = data;
                        this.$Progress.finish();
                    })
                    .catch(error => {
                        this.$Progress.fail();
                        console.log(error.response.data.message);
                    });
            }
        },
        created() {
            this.loadContents();
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
