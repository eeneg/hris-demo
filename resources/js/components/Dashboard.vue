<template>
	<section class="content">
        <div class="row" v-if="$gate.isEmployee()">
            <div class="col-md-12 text-center">
                <not-authorized></not-authorized>
            </div>
        </div>
		<div v-else class="container-fluid">
			<!-- Small boxes (Stat box) -->
			<div class="row">
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-info">
						<div class="inner">
							<h3>{{ data_set.vacant_positions }}</h3>
							<p>Vacant Positions</p>
						</div>
						<div class="icon">
							<i class="ion ion-bag"></i>
						</div>
						<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-success">
						<div class="inner">
							<h3>{{ data_set.active_employees }}
								<sup style="font-size: 20px"></sup>
							</h3>
							<p>Active Employees</p>
						</div>
						<div class="icon">
							<i class="ion ion-stats-bars"></i>
						</div>
						<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-warning">
						<div class="inner">
							<h3>44</h3>
							<p>Newly Appointed</p>
						</div>
						<div class="icon">
							<i class="ion ion-person-add"></i>
						</div>
						<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-danger">
						<div class="inner">
							<h3>65</h3>
							<p>Retired Employees</p>
						</div>
						<div class="icon">
							<i class="ion ion-pie-graph"></i>
						</div>
						<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
				<!-- ./col -->
			</div>
			<!-- /.row -->
			<!-- Main row -->
			<div class="row">
				<section class="col-lg-6 connectedSortable ui-sortable">
					<div class="card">
						<div class="card-header ui-sortable-handle" style="cursor: move;">
							<h3 class="card-title">
								<i class="ion ion-clipboard mr-1"></i> Announcement Board
							</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<ul class="todo-list ui-sortable" data-widget="todo-list">
								<li>
									<!-- drag handle -->
									<span class="handle ui-sortable-handle">
										<i class="fas fa-bullhorn"></i>
									</span>
									<span class="text">Monday Convocation will be held at Capitol Lobby.</span>
									<!-- Emphasis label -->
									<small class="badge badge-danger">
										<i class="far fa-clock"></i> 2 mins </small>
								</li>
								<li>
									<!-- drag handle -->
									<span class="handle ui-sortable-handle">
										<i class="fas fa-bullhorn"></i>
									</span>
									<span class="text">Your announcement here!</span>
									<!-- Emphasis label -->
									<small class="badge badge-danger">
										<i class="far fa-clock"></i> 2 mins </small>
								</li>
								<li>
									<!-- drag handle -->
									<span class="handle ui-sortable-handle">
										<i class="fas fa-bullhorn"></i>
									</span>
									<span class="text">Your announcement here!</span>
									<!-- Emphasis label -->
									<small class="badge badge-warning">
										<i class="far fa-clock"></i> 2 mins </small>
								</li>
								<li>
									<!-- drag handle -->
									<span class="handle ui-sortable-handle">
										<i class="fas fa-bullhorn"></i>
									</span>
									<span class="text">Your announcement here!</span>
									<!-- Emphasis label -->
									<small class="badge badge-primary">
										<i class="far fa-clock"></i> 2 mins </small>
								</li>
								<li>
									<!-- drag handle -->
									<span class="handle ui-sortable-handle">
										<i class="fas fa-bullhorn"></i>
									</span>
									<span class="text">Your announcement here!</span>
									<!-- Emphasis label -->
									<small class="badge badge-success">
										<i class="far fa-clock"></i> 2 mins </small>
								</li>
							</ul>
						</div>
						<!-- /.card-body -->
						<div class="card-footer clearfix">
							<a href="javascript:void(0)" class="uppercase float-right">View All Announcement</a>
						</div>
					</div>
				</section>
				<section class="col-lg-6 connectedSortable ui-sortable">
					<!-- Events -->
					<div class="card card-margin">
						<div class="card-header">
							<h3 class="card-title">Upcoming Events</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body ">
							<div class="widget-49">
								<div class="widget-49-title-wrapper">
									<div class="widget-49-date-primary">
										<span class="widget-49-date-day">09</span>
										<span class="widget-49-date-month">apr</span>
									</div>
									<div class="widget-49-meeting-info">
										<span class="widget-49-pro-title">Awarding Ceremony for Retiree</span>
										<span class="widget-49-meeting-time">8:00 AM - Coliseum</span>
									</div>
								</div>
							</div>
							<hr>
							<div class="widget-49">
								<div class="widget-49-title-wrapper">
									<div class="widget-49-date-success">
										<span class="widget-49-date-day">20</span>
										<span class="widget-49-date-month">apr</span>
									</div>
									<div class="widget-49-meeting-info">
										<span class="widget-49-pro-title">Awarding Ceremony for Retiree</span>
										<span class="widget-49-meeting-time">8:00 AM - Coliseum</span>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer clearfix">
							<a href="javascript:void(0)" class="uppercase float-right">View All Announcement</a>
						</div>
					</div>
				</section>
				<!-- Left col -->
				<section class="col-lg-8 connectedSortable ui-sortable">
					<!-- Custom tabs (Charts with tabs)-->
					<div class="card">
						<div class="card-header border-transparent">
							<h3 class="card-title">Activity Logs</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="table-responsive">
								<table class="table m-0">
									<thead>
										<tr>
											<th>User</th>
											<th>Activity</th>
											<th style="text-align: right;">Status</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<a href="pages/examples/invoice.html">Vanessa Rellanos</a>
											</td>
											<td>Updated his plantilla</td>
											<td style="text-align: right;">
												<span class="badge badge-success">04/20/21</span>
											</td>
										</tr>
										<tr>
											<td>
												<a href="pages/examples/invoice.html">John Doe</a>
											</td>
											<td>Applied for leave</td>
											<td style="text-align: right;">
												<span class="badge badge-warning">Pending</span>
											</td>
										</tr>
										<tr>
											<td>
												<a href="pages/examples/invoice.html">Jane Doe</a>
											</td>
											<td>Updated his profile</td>
											<td style="text-align: right;">
												<span class="badge badge-danger">Delivered</span>
											</td>
										</tr>
										<tr>
											<td>
												<a href="pages/examples/invoice.html">Magic Johnson</a>
											</td>
											<td>Applied for leave</td>
											<td style="text-align: right;">
												<span class="badge badge-info">Processing</span>
											</td>
										</tr>
										<tr>
											<td>
												<a href="pages/examples/invoice.html">Jayson Castro</a>
											</td>
											<td>Salary grade increase</td>
											<td style="text-align: right;">
												<span class="badge badge-danger">06/11/21</span>
											</td>
										</tr>
										<tr>
											<td>
												<a href="pages/examples/invoice.html">Mark Hernan</a>
											</td>
											<td>Appointed as Vice Governor</td>
											<td style="text-align: right;">
												<span class="badge badge-success">06/15/21</span>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<!-- /.table-responsive -->
						</div>
						<!-- /.card-body -->
						<div class="card-footer clearfix">
							<a href="javascript:void(0)" class="uppercase float-right">View All Activities</a>
						</div>
						<!-- /.card-footer -->
					</div>
					<!-- /.card -->
					<!-- DIRECT CHAT -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Newly Appointed Employees</h3>
							<div class="card-tools">
								<span class="badge badge-danger">8 Newly Appointed</span>
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body p-0">
							<div class="col-md-12" style="display: flex; flex-wrap: wrap;">
								<div class="col-md-3 col-6" style="text-align: center; padding: 5px;">
									<img src="/storage/project_files/davsur.png" class="text-center" alt="avatar" width="100px" height="100px">
									<a class="users-list-name" href="#">John Doe</a>
									<span class="users-list-date" style="line-height: 1;">
										<i> Security Officer I </i>
									</span>
									<span class="users-list-date">PCSMO</span>
								</div>
								<div class="col-md-3 col-6" style="text-align: center; padding: 5px;">
									<img src="/storage/project_files/davsur.png" class="text-center" alt="avatar" width="100px" height="100px">
									<a class="users-list-name" href="#">Luca Doncic</a>
									<span class="users-list-date" style="line-height: 1;">
										<i> Executive Officer I </i>
									</span>
									<span class="users-list-date">PGO-Executive</span>
								</div>
								<div class="col-md-3 col-6" style="text-align: center; padding: 5px;">
									<img src="/storage/project_files/davsur.png" class="text-center" alt="avatar" width="100px" height="100px">
									<a class="users-list-name" href="#">Kyrie Irving</a>
									<span class="users-list-date" style="line-height: 1;">
										<i> Administrative Aide VI </i>
									</span>
									<span class="users-list-date">PTO</span>
								</div>
								<div class="col-md-3 col-6" style="text-align: center; padding: 5px;">
									<img src="/storage/project_files/davsur.png" class="text-center" alt="avatar" width="100px" height="100px">
									<a class="users-list-name" href="#">James Harden</a>
									<span class="users-list-date" style="line-height: 1;">
										<i> Computer Programmer I </i>
									</span>
									<span class="users-list-date">PPDO</span>
								</div>
							</div>
							<div class="col-md-12" style="display: flex; flex-wrap: wrap;">
								<div class="col-md-3 col-6" style="text-align: center; padding: 5px;">
									<img src="/storage/project_files/davsur.png" class="text-center" alt="avatar" width="100px" height="100px">
									<a class="users-list-name" href="#">Kevin Durant</a>
									<span class="users-list-date" style="line-height: 1;">
										<i> Administrative Officer II </i>
									</span>
									<span class="users-list-date">PACCO</span>
								</div>
								<div class="col-md-3 col-6" style="text-align: center; padding: 5px;">
									<img src="/storage/project_files/davsur.png" class="text-center" alt="avatar" width="100px" height="100px">
									<a class="users-list-name" href="#">Stephen Curry</a>
									<span class="users-list-date" style="line-height: 1;">
										<i> Accountant I </i>
									</span>
									<span class="users-list-date">PBO</span>
								</div>
								<div class="col-md-3 col-6" style="text-align: center; padding: 5px;">
									<img src="/storage/project_files/davsur.png" class="text-center" alt="avatar" width="100px" height="100px">
									<a class="users-list-name" href="#">Jason Tatum</a>
									<span class="users-list-date" style="line-height: 1;">
										<i> Human Resource Management Officer II </i>
									</span>
									<span class="users-list-date">PHRMO</span>
								</div>
								<div class="col-md-3 col-6" style="text-align: center; padding: 5px;">
									<img src="/storage/project_files/davsur.png" class="text-center" alt="avatar" width="100px" height="100px">
									<a class="users-list-name" href="#">Trae Young</a>
									<span class="users-list-date" style="line-height: 1;">
										<i> Assessment Clerk III </i>
									</span>
									<span class="users-list-date">PASSO</span>
								</div>
							</div>
							<!-- /.users-list -->
						</div>
						<!-- /.card-body -->
						<div class="card-footer text-center">
							<a href="javascript:" class="float-right">View All Newly Appointed</a>
						</div>
						<!-- /.card-footer -->
					</div>
					<!-- TO DO List -->
					<!-- /.card -->
				</section>
				<!-- /.Left col -->
				<!-- right col (We are only adding the ID to make the widgets sortable)-->
				<section class="col-lg-4 connectedSortable ui-sortable">
					<!-- On-leave Card -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">On-Leave Employees</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body p-0">
							<ul class="products-list product-list-in-card pl-2 pr-2">
								<li class="item">
									<div class="product-img">
										<img src="/storage/project_files/davsur.png" alt="avatar" class="img-size-50">
									</div>
									<div class="product-info">
										<a href="javascript:void(0)" class="product-title"> Vanessa Rellanos <small class="product-description"> 01/01/2021 - 01/15/2021 </small>
										</a>
										<span class="product-description"> Force Leave </span>
									</div>
								</li>
								<!-- /.item -->
								<li class="item">
									<div class="product-img">
										<img src="/storage/project_files/davsur.png" alt="avatar" class="img-size-50">
									</div>
									<div class="product-info">
										<a href="javascript:void(0)" class="product-title"> John Doe <small class="product-description"> 01/01/2021 - 01/15/2021 </small>
										</a>
										<span class="product-description"> Vacation Leave </span>
									</div>
								</li>
								<!-- /.item -->
								<li class="item">
									<div class="product-img">
										<img src="/storage/project_files/davsur.png" alt="avatar" class="img-size-50">
									</div>
									<div class="product-info">
										<a href="javascript:void(0)" class="product-title"> Jane Dela Cruz <small class="product-description"> 01/01/2021 - 01/15/2021 </small>
										</a>
										<span class="product-description"> Maternity Leave </span>
									</div>
								</li>
								<!-- /.item -->
								<li class="item">
									<div class="product-img">
										<img src="/storage/project_files/davsur.png" alt="avatar" class="img-size-50">
									</div>
									<div class="product-info">
										<a href="javascript:void(0)" class="product-title"> Jefferson White <small class="product-description"> 01/01/2021 - 01/15/2021 </small>
										</a>
										<span class="product-description"> Special Leave </span>
									</div>
								</li>
								<!-- /.item -->
							</ul>
						</div>
						<!-- /.card-body -->
						<div class="card-footer text-center">
							<a href="javascript:void(0)" class="uppercase">View All On-Leave Employees</a>
						</div>
						<!-- /.card-footer -->
					</div>
					<!-- /.card -->
					<!-- solid sales graph -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Birthday(s) Today</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body p-0">
							<ul class="products-list product-list-in-card pl-2 pr-2">
								<li class="item" v-for="employee in data_set.birthdays" :key="employee.fullName">
									<div class="product-img">
										<img src="/storage/project_files/employee.png" alt="avatar">
									</div>
									<div class="product-info">
										<h6 class="product-title">
											<span class="text-primary">{{ employee.fullName }}</span>
											<small class="product-description">
												<span class="d-block">{{ employee.birthdate | myDate }}</span>
                                                <span class="d-block">{{ employee.office }}</span>
                                                <span class="d-block">{{ employee.position }}</span>
											</small>
										</h6>
									</div>
								</li>
							</ul>
						</div>
						<!-- /.card-body -->
						<div class="card-footer text-center">
							<a href="javascript:void(0)" class="uppercase">View All Birthdays This Month</a>
						</div>
						<!-- /.card-footer -->
					</div>
					<!-- /.card -->
					<!-- Calendar -->
					<!-- <div class="card"><div class="card-header"><h3 class="card-title">Messages</h3><div class="card-tools"><button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button></div></div><div class="card-body p-0"><ul class="products-list product-list-in-card pl-2 pr-2"><li class="item"><div class="product-img"><img src="/storage/project_files/davsur.png" alt="avatar" class="img-size-50"></div><div class="product-info"><a href="javascript:void(0)" class="product-title">
                                Gene Gwapo
                                <span class="float-right users-list-date">35 mins</span></a><span class="product-description">
                               Nganong Gwapo kay ko? :(
                            </span></div></li><li class="item"><div class="product-img"><img src="/storage/project_files/davsur.png" alt="avatar" class="img-size-50"></div><div class="product-info"><a href="javascript:void(0)" class="product-title">
                                Gene Gwapo
                                <span class="float-right users-list-date">35 mins</span></a><span class="product-description">
                               Nganong Gwapo kay ko? :(
                            </span></div></li><li class="item"><div class="product-img"><img src="/storage/project_files/davsur.png" alt="avatar" class="img-size-50"></div><div class="product-info"><a href="javascript:void(0)" class="product-title">
                                Gene Gwapo
                                <span class="float-right users-list-date">35 mins</span></a><span class="product-description">
                               Nganong Gwapo kay ko? :(
                            </span></div></li><li class="item"><div class="product-img"><img src="/storage/project_files/davsur.png" alt="avatar" class="img-size-50"></div><div class="product-info"><a href="javascript:void(0)" class="product-title">
                                Gene Gwapo
                                <span class="float-right users-list-date">35 mins</span></a><span class="product-description">
                               Nganong Gwapo kay ko? :(
                            </span></div></li></ul></div><div class="card-footer text-center"><a href="javascript:void(0)" class="uppercase">View All Messages</a></div></div> -->
					<!-- /.card -->
				</section>
				<!-- right col -->
			</div>
			<!-- /.row (main row) -->
		</div>
		<!-- /.container-fluid -->
	</section>
</template>
<script>
	export default {
		data() {
			return {
				data_set: {
					vacant_positions: 0,
					active_employees: 0,
					birthdays: []
				}
			}
		},
		methods: {
			loadData() {
				axios.get('api/dashboard').then(({
					data
				}) => {
					this.data_set = data;
				}).catch(error => {
					console.log(error.response.data.message);
				});
			}
		},
		created() {
			this.$Progress.start();
			this.loadData();
			this.$Progress.finish();
		},
		mounted() {
			// console.log('Component mounted.')
		}
	}
</script>