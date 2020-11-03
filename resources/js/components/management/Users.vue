<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title" style="margin-bottom: 0;font-size: 1.8rem;">System Users</h2>

                    <div class="card-tools">
                        <!-- <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div> -->
                        <button v-if="$gate.isAdministrator()" class="btn btn-success" @click="newUserModal">
                            <i class="fas fa-user-plus"></i>
                            Add New
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap users-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Landline</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Registered At</th>
                                <th v-if="$gate.isAdministrator()">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users.data" :key="user.id">
                                <!-- <td>{{ user.name | capitalize }}</td> -->
                                <td><img style="width: 35px;" class="img-circle mr-2" :src="getAvatar(user.avatar)" alt="User Avatar">{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.landline }}</td>
                                <td><span class="tag tag-success">{{ user.role }}</span></td>
                                <td>{{ user.status }}</td>
                                <td>{{ user.created_at | myDate }}</td>
                                <td v-if="$gate.isAdministrator()">
                                    <a class="btn btn-info btn-sm" href="" @click.prevent="editUserModal(user)">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a class="btn btn-danger btn-sm" href="" @click.prevent="deleteUser(user.id)">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right" style="display: inherit; align-items: baseline;">
                    <pagination :data="users" @pagination-change-page="getResults">
                        <span slot="prev-nav">&lt; Previous</span>
	                    <span slot="next-nav">Next &gt;</span>
                    </pagination>
                    <span style="margin-left: 10px;">Showing {{ users.from | validateCount }} to {{ users.to | validateCount }} of {{ users.total }} records</span>
                </div>
                
                <!-- /.card-body -->
            </div>
        <!-- /.card -->
        </div>

        <!-- Modal -->
        <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ editmode ? 'Update User' : 'Create User' }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="form-group">
                                <select name="role" v-model="form.role" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('role') }">
                                    <option value="">Select User Role</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Office User">Office User</option>
                                    <option value="Author">Author</option>
                                </select>
                                <has-error :form="form" field="role"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name" placeholder="Name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.email" type="text" name="email" placeholder="Email Address"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.password" type="password" name="password" placeholder="Password"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.landline" type="text" name="landline" placeholder="Landline"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('landline') }">
                                <has-error :form="form" field="landline"></has-error>
                            </div>

                            <!-- <button :disabled="form.busy" type="submit" class="btn btn-primary">Log In</button> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
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
                users: {},
                form: new Form({
                    'id': '',
                    'name': '',
                    'email': '',
                    'password': '',
                    'landline': '',
                    'role': '',
                    'avatar': '',
                    'status': ''
                })
            }
        },
        methods: {
            getResults(page = 1) {
                axios.get('api/user?page=' + page + '&query=' + this.$parent.search)
                    .then(response => {
                        this.users = response.data;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            },
            newUserModal() {
                this.editmode = false;
                this.form.reset();
                $('#userModal').modal('show');   
            },
            editUserModal(user) {
                this.editmode = true;
                this.form.reset();
                $('#userModal').modal('show');
                this.form.fill(user);
            },
            getAvatar(avatar) {
                if (avatar != "profile.png") {
                    let prefix = (avatar.match(/\//) ? '' : '/storage/user_avatars/');
                    return prefix + avatar;
                } else {
                    let prefix = (avatar.match(/\//) ? '' : '/storage/project_files/');
                    return prefix + avatar;
                }
            }, 
            loadUsers() {
                // if (this.$gate.isAdministratorORAuthor()) {
                    axios.get('api/user')
                    .then( ({ data }) => (this.users = data) )
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
                // }
            },
            updateUser() {
                this.$Progress.start();
                this.form.put('api/user/' + this.form.id)
                    .then(() => {
                        Fire.$emit('ReloadUsers');
                        toast.fire({
                            icon: 'success',
                            title: 'User updated successfully'
                        });
                        $('#userModal').modal('hide');    
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });
            },
            createUser() {
                this.$Progress.start();
                this.form.post('api/user')
                    .then(() => {
                        Fire.$emit('ReloadUsers');
                        toast.fire({
                            icon: 'success',
                            title: 'User added successfully'
                        });
                        $('#userModal').modal('hide');     
                        this.$Progress.finish();
                    })
                    .catch(error => {
                        this.$Progress.fail();
                    });
            },
            deleteUser(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$Progress.start();
                        // Send delete request
                        this.form.delete('api/user/' + id)
                            .then(({ data }) => {
                                Fire.$emit('ReloadUsers');
                                Swal.fire(
                                    'Deleted!',
                                    data.message,
                                    'success'
                                )
                                this.$Progress.finish();
                            })
                            .catch(() => {
                                Swal.fire(
                                    'Failed!',
                                    'An error occured while trying to delete the record.',
                                    'warning'
                                )
                                this.$Progress.fail();
                            });
                    }
                });
            }
        },
        created() {
            Fire.$on('searching', () => {
                this.getResults();
            });
            this.$Progress.start();
            this.loadUsers();
            Fire.$on('ReloadUsers', () => {
                this.loadUsers();
            });
            this.$Progress.finish();

            // Refresh table every 3 seconds (not recommended ni siya, for test only)
            // setInterval(() => this.loadUsers(), 3000);
        }
    }
</script>
