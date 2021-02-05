<style>
    .widget-user-header {
        background-position: center center !important;
        background-size: cover !important;
        height: 250px !important;
    }
</style>

<template>
            <div class="row">
              <div class="col-md-3">
                  <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                      <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" :src="getAvatar()" alt="User profile picture">
                      </div>

                      <h3 class="profile-username text-center">{{ form.name }}</h3>

                      <p class="text-muted text-center">{{ form.role }}</p>

                      <ul class="nav list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                          <a class="nav-link2 active" href="#timeline" data-toggle="tab">Timeline</a>
                        </li>
                        <li class="list-group-item ">
                          <a class="nav-link2" href="#messages" data-toggle="tab">Messages<span class="badge2 badge badge-warning float-right">69</span></a>

                        </li>
                        <li class="list-group-item">
                          <a class="nav-link2" href="#notification" data-toggle="tab">Notifications<span class="badge3 badge badge-danger float-right">69</span></a>
                        </li>
                        <li class="list-group-item">
                          <a class="nav-link2" href="#settings" data-toggle="tab">Settings</a>
                        </li>
                      </ul>
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
              <div class="col-md-9">

                    <div class="card">
                      <div class="card-body">
                        <div class="tab-content">
                          <div class="tab-pane" id="messages">
                                  <div class="row mb-2">
                            <div class="col-md-6 align-middle">
                              <h3>Messages</h3>
                      <!-- <ul class="nav">
                        <li class="nav-item">
                          <a href="compose.html" class="nav-link btn btn-success btn-block">Compose <i class="nav-icon fas fa-edit"></i></a>

                        </li>
                        <li class="nav-item active">
                          <a href="#" class="nav-link">
                            <i class="fas fa-inbox"></i> Inbox
                            <span class="badge bg-warning float-right">12</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="#" class="nav-link">
                            <i class="far fa-envelope"></i> Sent
                          </a>
                        </li>
                      </ul> -->

                            </div>
                            <div class="col-md-6">
                              <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/profile">Profile</a></li>
                                <li class="breadcrumb-item active">Messages</li>
                              </ol>
                            </div>
                            </div>
                              <section class="content">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="chat_container">
                              <div class="job-box" style="padding-bottom: 0 !important;">
                                <div class="job-box-filter" style="margin-bottom: 5px !important;">
                                  <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                    <label>Show 
                                    <select name="datatable_length" class="form-control input-sm">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    </select>
                                    entries</label>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                      <div class="filter-search-box text-right">
                                        <label>Search:<input type="search" class="form-control input-sm" placeholder=""></label>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="inbox-message">
                                  <ul>
                                    <li>
                                      <a href="#">
                                        <div class="message-avatar">
                                          <img :src="getAvatar()" alt="User Profile">
                                        </div>
                                        <div class="message-body">
                                          <div class="message-body-heading">
                                            <strong>Daniel Dock</strong>
                                            <span>7 hours ago</span>
                                          </div>
                                          <p>Hello, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolor....</p>
                                        </div>
                                      </a>
                                    </li>
                                    <li>
                                      <a href="#">
                                        <div class="message-avatar">
                                          <img :src="getAvatar()" alt="User Profile">
                                        </div>
                                        <div class="message-body">
                                          <div class="message-body-heading">
                                            <strong>Daniel Dock</strong>
                                            <span>7 hours ago</span>
                                          </div>
                                          <p>Hello, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolor....</p>
                                        </div>
                                      </a>
                                    </li>
                                    <li>
                                      <a href="#">
                                        <div class="message-avatar">
                                          <img :src="getAvatar()" alt="User Profile">
                                        </div>
                                        <div class="message-body">
                                          <div class="message-body-heading">
                                            <strong>Daniel Dock</strong>
                                            <span>7 hours ago</span>
                                          </div>
                                          <p>Hello, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolor....</p>
                                        </div>
                                      </a>
                                    </li>
                                    <li>
                                      <a href="#">
                                        <div class="message-avatar">
                                          <img :src="getAvatar()" alt="User Profile">
                                        </div>
                                        <div class="message-body">
                                          <div class="message-body-heading">
                                            <strong>Daniel Dock</strong>
                                            <span>7 hours ago</span>
                                          </div>
                                          <p>Hello, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolor....</p>
                                        </div>
                                      </a>
                                    </li>
                                    <li>
                                      <a href="#">
                                        <div class="message-avatar">
                                          <img :src="getAvatar()" alt="User Profile">
                                        </div>
                                        <div class="message-body">
                                          <div class="message-body-heading">
                                            <strong>Daniel Dock</strong>
                                            <span>7 hours ago</span>
                                          </div>
                                          <p>Hello, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolor....</p>
                                        </div>
                                      </a>
                                    </li>
                                    <li>
                                      <a href="#">
                                        <div class="message-avatar">
                                          <img :src="getAvatar()" alt="User Profile">
                                        </div>
                                        <div class="message-body">
                                          <div class="message-body-heading">
                                            <strong>Daniel Dock</strong>
                                            <span>7 hours ago</span>
                                          </div>
                                          <p>Hello, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolor....</p>
                                        </div>
                                      </a>
                                    </li>
                                    <li>
                                      <a href="#">
                                        <div class="message-avatar">
                                          <img :src="getAvatar()" alt="User Profile">
                                        </div>
                                        <div class="message-body">
                                          <div class="message-body-heading">
                                            <strong>Daniel Dock</strong>
                                            <span>7 hours ago</span>
                                          </div>
                                          <p>Hello, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolor....</p>
                                        </div>
                                      </a>
                                    </li>
                                  </ul>
                                </div>
                                  
                            </div>
                            <div class="card-tools" style="margin-top: 20px;">
                                    <ul class="pagination pagination-sm float-right">
                                      <li class="page-item"><a class="page-link" href="#">«</a></li>
                                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                                      <li class="page-item"><a class="page-link" href="#">»</a></li>
                                    </ul>
                                  </div>
                              </div>
                </div>
                <!-- message menu -->


                <!-- end message menu -->
                
                
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </section>
                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane active" id="timeline">
                     <div class="row mb-2">
                     <div class="col-md-6">
                       <h3>Timeline</h3>
                     </div>
                     <div class="col-md-6">
                       <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/profile">Profile</a></li>
                        <li class="breadcrumb-item active">Timeline</li>
                      </ol>
                     </div>
                     </div>
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">

                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-danger">
                          10 Feb. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-envelope bg-primary"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 12:05</span>

                          <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                          <div class="timeline-body">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                            quora plaxo ideeli hulu weebly balihoo...
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-user bg-info"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                          <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                          </h3>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-comments bg-warning"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                          <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                          <div class="timeline-body">
                            Take me to your leader!
                            Switzerland is small and neutral!
                            We are more like Germany, ambitious and misunderstood!
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-success">
                          3 Jan. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-camera bg-purple"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                          <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                          <div class="timeline-body">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form @submit.prevent="updateUser()">
                      <div class="form-group row">
                          <label for="profileInputName" class="col-sm-2 col-form-label">Name</label>
                          <div class="col-sm-10">
                              <input v-model="form.name" type="text" name="name" placeholder="Name"  id="profileInputName"
                              class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('name') }">
                              <has-error :form="form" field="name"></has-error>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="profileInputEmail" class="col-sm-2 col-form-label">Email</label>
                          <div class="col-sm-10">
                              <input v-model="form.email" type="email" name="email" class="form-control form-control-border border-width-2" id="profileInputEmail" placeholder="Email"
                              :class="{ 'is-invalid': form.errors.has('email') }">
                              <has-error :form="form" field="email"></has-error>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="profileInputLandline" class="col-sm-2 col-form-label">Landline</label>
                          <div class="col-sm-10">
                              <input v-model="form.landline" type="text" name="landline" placeholder="Landline" id="profileInputLandline"
                              class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('landline') }">
                              <has-error :form="form" field="landline"></has-error>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="profileInputNewPassword" class="col-sm-2 col-form-label">New Password</label>
                          <div class="col-sm-10">
                              <input v-model="form.password" type="password" name="password" placeholder="New Password" id="profileInputNewPassword"
                                  class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('password') }">
                              <has-error :form="form" field="password"></has-error>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="profileInputConfirmPassword" class="col-sm-2 col-form-label">Confirm Password</label>
                          <div class="col-sm-10">
                              <input v-model="form.password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password" id="profileInputConfirmPassword"
                                  class="form-control form-control-border border-width-2" :class="{ 'is-invalid': form.errors.has('password_confirmation') }">
                                  <has-error :form="form" field="confirm"></has-error>
                              </div>
                      </div>
                      <div class="form-group row">
                          <label for="profileInputAvatar" class="col-sm-2 col-form-label">Profile Picture</label>
                          <div class="col-sm-10">
                              <input type="file" @change="uploadPicture" name="avatar" ref="avatar" id="profileInputAvatar" accept="image/jpeg, image/png">
                          </div>
                      </div>
                      <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                              <button type="submit" class="btn btn-success">Submit</button>
                          </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                  <!-- tab pane Notif -->
                  <div class="tab-pane" id="notification">
                    <div class="">
                      <div class="row mb-2">
                            <div class="col-md-6 align-middle">
                              <h3>Notifications</h3>
                            </div>
                            <div class="col-md-6">
                              <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/profile">Profile</a></li>
                                <li class="breadcrumb-item active">Notifications</li>
                              </ol>
                            </div>
                      </div>
                      <ul class="list-group">

                        <a href="" class="list-group-item list-group-item-action border-top-0 border-left-0 border-right-0">
                          <span class="float-left" style="margin-right: 20px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                          <li class="d-flex justify-content-between align-items-center">
                          Cras justo odio
                            <span >08/08/08</span>
                          </li>
                        </a>
                        <a href="" class="list-group-item list-group-item-action border-top-0 border-left-0 border-right-0">
                          <span class="float-left" style="margin-right: 20px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                          <li class="d-flex justify-content-between align-items-center">
                          Cras justo odio
                            <span >08/08/08</span>
                          </li>
                        </a>
                        <a href="" class="list-group-item list-group-item-action border-top-0 border-left-0 border-right-0">
                          <span class="float-left" style="margin-right: 20px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                          <li class="d-flex justify-content-between align-items-center">
                          Cras justo odio
                            <span >08/08/08</span>
                          </li>
                        </a>
                        <a href="" class="list-group-item list-group-item-action border-top-0 border-left-0 border-right-0">
                          <span class="float-left" style="margin-right: 20px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                          <li class="d-flex justify-content-between align-items-center">
                          Cras justo odio
                            <span >08/08/08</span>
                          </li>
                        </a>
                        <a href="" class="list-group-item list-group-item-action border-top-0 border-left-0 border-right-0">
                          <span class="float-left" style="margin-right: 20px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                          <li class="d-flex justify-content-between align-items-center">
                          Cras justo odio
                            <span >08/08/08</span>
                          </li>
                        </a>
                        <a href="" class="list-group-item list-group-item-action border-top-0 border-left-0 border-right-0">
                         <span class="float-left" style="margin-right: 20px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                         <li class="d-flex justify-content-between align-items-center">
                          Cras justo odio
                            <span >08/08/08</span>
                          </li>
                        </a>
                      </ul>
                            <div class="card-tools" style="margin-top: 20px;">
                              <ul class="pagination pagination-sm float-right">
                                <li class="page-item"><a class="page-link" href="#">«</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">»</a></li>
                              </ul>
                            </div>
                    </div>
                  </div>
                  <!-- end tab pane -->

                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <!-- image resize modal -->

            <div class="modal" id="image-modal" data-backdrop="static" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Resize</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <clipper-fixed  class="my-clipper" :round="true" ref="clipper" preview="my-preview" :src="getAvatar()" ><div class="placeholder" slot="placeholder">No image</div></clipper-fixed>
                                </div>

                                <div class="col-md-6">
                                    <clipper-preview name="my-preview" class="my-clipper">
                                        <div class="placeholder" slot="placeholder">preview area</div>
                                    </clipper-preview>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="getResult">Confirm</button>
                        </div>
                    </div>
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
                        $('#image-modal').modal('show')
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
            getResult: function () {
                const canvas = this.$refs.clipper.clip();
                this.form.avatar = canvas.toDataURL("image/png", 1);
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
            // console.log('Component mounted.')
        }
    }
</script>
