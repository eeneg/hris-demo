<style>
    .widget-user-header {
        background-position: center center !important;
        background-size: cover !important;
        height: 250px !important;
    }
</style>

<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header text-white" style="background: url('./storage/project_files/cover.png');">
                    <h3 class="widget-user-username text-left">{{ form.name }}</h3>
                    <h5 class="widget-user-desc text-left">{{ form.role }}</h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" :src="getAvatar()" alt="User Avatar">
                </div>
                <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                        <h5 class="description-header">3,200</h5>
                        <span class="description-text">SALES</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                        <h5 class="description-header">13,000</h5>
                        <span class="description-text">FOLLOWERS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        <div class="description-block">
                        <h5 class="description-header">35</h5>
                        <span class="description-text">PRODUCTS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                        <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">
                            <form @submit.prevent="updateUser()">
                                <div class="form-group row">
                                    <label for="profileInputName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input v-model="form.name" type="text" name="name" placeholder="Name"  id="profileInputName"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                        <has-error :form="form" field="name"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="profileInputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input v-model="form.email" type="email" name="email" class="form-control" id="profileInputEmail" placeholder="Email"
                                        :class="{ 'is-invalid': form.errors.has('email') }">
                                        <has-error :form="form" field="email"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="profileInputLandline" class="col-sm-2 col-form-label">Landline</label>
                                    <div class="col-sm-10">
                                        <input v-model="form.landline" type="text" name="landline" placeholder="Landline" id="profileInputLandline"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('landline') }">
                                        <has-error :form="form" field="landline"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="profileInputNewPassword" class="col-sm-2 col-form-label">New Password</label>
                                    <div class="col-sm-10">
                                        <input v-model="form.password" type="password" name="password" placeholder="New Password" id="profileInputNewPassword"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                        <has-error :form="form" field="password"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="profileInputConfirmPassword" class="col-sm-2 col-form-label">Confirm Password</label>
                                    <div class="col-sm-10">
                                        <input v-model="form.password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password" id="profileInputConfirmPassword"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirmation') }">
                                            <has-error :form="form" field="confirm"></has-error>
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <label for="profileInputAvatar" class="col-sm-2 col-form-label">Profile Picture</label>
                                    <div class="col-sm-10">
                                        <input type="file" @change="uploadPicture" name="avatar" ref="avatar" id="profileInputAvatar" accept="image/jpeg, image/png">
                                    </div>
                                </div>
                                <!-- <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                    <div class="checkbox">
                                        <label>
                                        <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                        </label>
                                    </div>
                                    </div>
                                </div> -->
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="activity">
                            <!-- /.post -->
                        </div>
                        
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    'id': '',
                    'name': '',
                    'email': '',
                    'password': '',
                    'password_confirmation': '',
                    'landline': '',
                    'role': '',
                    'avatar': '',
                    'status': ''
                })
            }
        },
        methods: {
            uploadPicture(e) {
                let file = e.target.files[0];
                let reader = new FileReader();
                if (file.size < 2111775) {
                    reader.onloadend = (file) => {
                        // console.log('RESULT', reader.result)
                        this.form.avatar = reader.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    // this.form.avatar = null;
                    this.$refs.avatar.value = null;
                    Swal.fire(
                        'Oops...',
                        'You are uploading a large file',
                        'error'
                    )
                }
                
            },
            updateUser() {
                this.$Progress.start();
                this.form.put('api/profile')
                    .then(({ data }) => {
                        toast.fire({
                            icon: 'success',
                            title: 'Information updated successfully'
                        });
                        Fire.$emit('ReloadProfile');
                        this.$Progress.finish();
                    })
                    .catch(error => {
                        this.$Progress.fail();
                        console.log(error.response.data.message);
                    });
            },
            getAvatar() {
                if (this.form.avatar != "profile.png") {
                    let prefix = (this.form.avatar.match(/\//) ? '' : '/storage/user_avatars/');
                    return prefix + this.form.avatar;
                } else {
                    let prefix = (this.form.avatar.match(/\//) ? '' : '/storage/project_files/');
                    return prefix + this.form.avatar;
                }
            }, 
            loadProfile() {
                axios.get('api/profile')
                .then( ({ data }) => {
                    this.form.fill(data);
                })
                .catch(error => {
                    console.log(error.response.data.message);
                }); ;
            }
        },
        created() {
            this.$Progress.start();
            this.loadProfile();
            Fire.$on('ReloadProfile', () => {
                this.loadProfile();
            });
            this.$Progress.finish();
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
