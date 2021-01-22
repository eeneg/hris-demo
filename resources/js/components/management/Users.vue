<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h2>System Users</h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input v-model="search" @keyup.prevent="searchit" type="text" class="form-control" placeholder="Search">
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-3">
                            <button v-if="$gate.isAdministrator()" class="btn btn-success" @click="newUserModal" style="float: right;">
                                <i class="fas fa-user-plus"></i>
                                Add New
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table text-nowrap table-striped custom-table">
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
                                <td>
                                    <img style="width: 35px; height: 35px;" class="img-circle mr-2" :src="getAvatar(user.avatar)" alt="User Avatar">
                                    <span style="vertical-align: middle;">{{ user.name }}</span>
                                </td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.landline }}</td>
                                <td>
                                    <span class="tag tag-success">{{ user.role }}<p class="text-muted" style="margin: 0;">{{ user.userassignment && user.userassignment.department.address }}</p></span>
                                </td>
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
                            <div class="form-group" style="margin-bottom: 0.3rem;">
                                <label style="font-weight: normal; margin: 0;">User Role</label>
                                <select name="role" v-model="form.role" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('role') }" @change="showDepartments()" id="user_role_combo">
                                    <option value="">Select User Role</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Author">Author</option>
                                    <option value="Office Head">Office Head</option>
                                    <option value="Office User">Office User</option>
                                </select>
                                <has-error :form="form" field="role"></has-error>
                            </div>

                            <div class="form-group" style="margin-bottom: 0.3rem;display: none;" id="department_user_select">
                                <label style="font-weight: normal; margin: 0;">Department</label>
                                <select name="department_id" v-model="form.department_id" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('department_id') }">
                                    <option value="">Select Department</option>
                                    <option v-for="department in departments" :key="department.id" :value="department.id">{{ department.address }}</option>
                                </select>
                                <has-error :form="form" field="role"></has-error>
                            </div>

                            <div class="form-group" style="margin-bottom: 0.3rem;">
                                <label for="user_name" style="font-weight: normal; margin: 0;">Fullname</label>
                                <input id="user_name" v-model="form.name" type="text" name="name" placeholder="Name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group" style="margin-bottom: 0.3rem;">
                                <label for="user_email" style="font-weight: normal; margin: 0;">Email Address</label>
                                <input id="user_email" v-model="form.email" type="text" name="email" placeholder="eg. user@gmail.com"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>

                            <div class="form-group" style="margin-bottom: 0.3rem;">
                                <label for="user_password" style="font-weight: normal; margin: 0;">User password</label>
                                <input id="user_password" v-model="form.password" type="password" name="password" placeholder="Password"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>

                            <div class="form-group" style="margin-bottom: 0.3rem;">
                                <label for="user_landline" style="font-weight: normal; margin: 0;">Landline #</label>
                                <input id="user_landline" v-model="form.landline" type="text" name="landline" placeholder="Landline"
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
                search: '',
                departments: [],
                selectedDepartment: '',
                form: new Form({
                    'id': '',
                    'name': '',
                    'email': '',
                    'password': '',
                    'landline': '',
                    'role': '',
                    'avatar': '',
                    'status': '',
                    'department_id': ''
                })
            }
        },
        methods: {
            searchit: _.debounce(function(){
                this.getResults();
            }, 400),
            getResults(page = 1) {
                axios.get('api/user?page=' + page + '&query=' + this.search)
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
                $('#department_user_select').css('display', 'none');
                $('#userModal').modal('show');   
            },
            editUserModal(user) {
                this.editmode = true;
                this.form.reset();
                $('#department_user_select').css('display', 'none');
                $('#userModal').modal('show');
                this.form.fill(user);
                this.form.department_id = user.userassignment && user.userassignment.department.id;
                if (this.form.department_id != null) {
                    this.loadDepartments();
                    $('#department_user_select').toggle('slide');
                }
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
            showDepartments(value) {
                var value = $('#user_role_combo').val();
                if ((value == 'Office User' || value == 'Office Head') && $('#department_user_select').is(":hidden")) {
                    if (this.departments.length == 0) {
                        this.loadDepartments();
                    }
                    $('#department_user_select').toggle('slide');
                } else if(value != 'Office User' && value != 'Office Head' && $('#department_user_select').is(":visible")) {
                    $('#department_user_select').toggle('slide');
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
            },
            loadDepartments() {
                axios.get('api/department')
                    .then(({data}) => {
                        this.departments = data.data;
                        this.selectedDepartment = data.data[0].id;
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                    });
            }
        },
        created() {
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
