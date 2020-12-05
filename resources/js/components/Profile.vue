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
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       :src="getAvatar()"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ form.name }}</h3>

                <p class="text-muted text-center">{{ form.role }}</p>
                <nav class="mt-2">
                    <ul class="list-group list-group-unbordered mb-3 nav nav-pills nav-sidebar flex-column "data-widget="treeview" role="menu" data-accordion="false">
                        <router-link to="Profile-Settings" class="list-group-item nav-link has-treeview">
                            <a href="#" class="nav-link" style="padding: 0 !important;">
                            <b>Timeline</b>
                            </a>
                        </router-link>
                        <li class="list-group-item nav-item has-treeview">
                            <a href="#" class="nav-link" style="padding: 0 !important;">
                            <b>Inbox</b> <span class="float-right badge badge-info right">6</span>
                            </a>
                        </li>
                        <li class="list-group-item nav-item has-treeview">
                            <a href="#" class="nav-link" style="padding: 0 !important;">
                            <b>Settings</b>
                            </a>
                        </li>
                    </ul>
                </nav>
                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- timeLine -->
          <div class="col-md-9">
              <div class="card">
              <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Timeline</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Profile</a></li>
              <li class="breadcrumb-item active">Timeline</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <!-- Timelime example  -->
        <div class="row">
          <div class="col-md-12">
            <!-- The time line -->
            <div class="timeline">
              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-red">10 Feb. 2014</span>
              </div>
              <!-- /.timeline-label -->
              <!-- timeline item -->
              <div>
                <i class="fas fa-envelope bg-blue"></i>
                <div class="timeline-item">
                  <span class="time"><i class="fas fa-clock"></i> 12:05</span>
                  <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                  <div class="timeline-body">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                    quora plaxo ideeli hulu weebly balihoo...
                  </div>
                  <div class="timeline-footer">
                    <a class="btn btn-primary btn-sm">Read more</a>
                    <a class="btn btn-danger btn-sm">Delete</a>
                  </div>
                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline item -->
              <div>
                <i class="fas fa-user bg-green"></i>
                <div class="timeline-item">
                  <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
                  <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline item -->
              <div>
                <i class="fas fa-comments bg-yellow"></i>
                <div class="timeline-item">
                  <span class="time"><i class="fas fa-clock"></i> 27 mins ago</span>
                  <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                  <div class="timeline-body">
                    Take me to your leader!
                    Switzerland is small and neutral!
                    We are more like Germany, ambitious and misunderstood!
                  </div>
                  <div class="timeline-footer">
                    <a class="btn btn-warning btn-sm">View comment</a>
                  </div>
                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-green">3 Jan. 2014</span>
              </div>
              <!-- /.timeline-label -->
              <!-- timeline item -->
              <div>
                <i class="fa fa-camera bg-purple"></i>
                <div class="timeline-item">
                  <span class="time"><i class="fas fa-clock"></i> 2 days ago</span>
                  <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                  <div class="timeline-body">
                    <img src="http://placehold.it/150x100" alt="...">
                    <img src="http://placehold.it/150x100" alt="...">
                    <img src="http://placehold.it/150x100" alt="...">
                    <img src="http://placehold.it/150x100" alt="...">
                    <img src="http://placehold.it/150x100" alt="...">
                  </div>
                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline item -->
              <div>
                <i class="fas fa-video bg-maroon"></i>

                <div class="timeline-item">
                  <span class="time"><i class="fas fa-clock"></i> 5 days ago</span>

                  <h3 class="timeline-header"><a href="#">Mr. Doe</a> shared a video</h3>

                  <div class="timeline-body">
                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tMWkeBIohBs" frameborder="0" allowfullscreen=""></iframe>
                    </div>
                  </div>
                  <div class="timeline-footer">
                    <a href="#" class="btn btn-sm bg-maroon">See comments</a>
                  </div>
                </div>
              </div>
              <!-- END timeline item -->
              <div>
                <i class="fas fa-clock bg-gray"></i>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.timeline -->

    </section>
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
