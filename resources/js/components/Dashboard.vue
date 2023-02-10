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
							<h3>{{data_set.newlyAppointedEmployeesCount}}</h3>
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
								<li v-for="announcement in data_set.announcements">
									<!-- drag handle -->
									<a :href="'activities-edit?id=' + announcement.id">
										<span class="handle ui-sortable-handle">
											<i class="fas fa-bullhorn"></i>
										</span>
										<div class="text"> {{ announcement.title }} </div>
									</a>
								</li>
							</ul>
						</div>
						<!-- /.card-body -->
						<div class="card-footer clearfix">
							<a href="/announcements" class="uppercase float-right">View All Announcement</a>
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
							<template v-for="(event, i) in data_set.events">
								<div class="widget-49">
									<div class="widget-49-title-wrapper">
										<div class="widget-49-date-primary">
											<span class="widget-49-date-day">{{ moment(event.time).format('DD') }}</span>
											<span class="widget-49-date-month">{{ moment(event.time).format('MMM') }}</span>
										</div>
										<div class="widget-49-meeting-info">
											<span class="widget-49-pro-title">{{ event.title }}</span>
											<span class="widget-49-meeting-time text-monospace">{{ `${moment(event.time).format('LT')} — ${event.info.substring(0,30)}` }}</span>
										</div>
									</div>
								</div>
								<hr v-if="i !== data_set.events.length - 1">
							</template>
						</div>
						<div class="card-footer clearfix">
							<a href="/events" class="uppercase float-right">View All Events</a>
						</div>
					</div>
				</section>
				<!-- Left col -->
				<section class="col-lg-8 connectedSortable ui-sortable">
					<!-- Custom tabs (Charts with tabs)-->

					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Newly Appointed Employees</h3>
							<div class="card-tools">
								<span class="badge badge-danger">{{data_set.newlyAppointedEmployeesCount}} Newly Appointed Employees</span>
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body p-0">
							<div class="col-md-12" style="display: flex; flex-wrap: wrap; max-height: 339.6px; overflow: auto;">
								<div v-for="(employee, index) in data_set.newlyAppointedEmployees" :key="index" class="col-md-3 col-6" style="text-align: center; padding: 5px;">
									<img :src="getAvatar(employee.avatar)" class="text-center rounded-circle" alt="avatar" width="100px" height="100px">
									<a class="users-list-name" href="#">{{ employee.name }}</a>
									<span class="users-list-date" style="line-height: 1;">
										<i> {{ employee.position }} </i>
									</span>
									<span class="users-list-date">{{ employee.department }}</span>
								</div>
							</div>
							<!-- /.users-list -->
						</div>
						<!-- /.card-body -->
						<div class="card-footer text-center">
                            <router-link to="/appointments" class="nav-link float-right">View All Newly Appointed</router-link>
						</div>
						<!-- /.card-footer -->
					</div>
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
								<table class="table m-0 table-hover table-sm">
									<thead>
										<tr>
											<th>User</th>
											<th>Activity</th>
											<th>IP Address</th>
											<th>Time</th>
										</tr>
									</thead>
									<tbody>
										<tr class="cursor-pointer" v-for="audit in data_set.audits">
											<td>
												{{ audit.user.name }}
											</td>
											<td>
												<span class="text-capitalize">{{ audit.event }}</span>
												{{ audit.audited }}.
											</td>
											<td>
												{{ audit.ip_address }}
											</td>
											<td class="text-monospace">
												{{ moment(audit.created_at).format('llll') }}
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
								<li class="item" v-for="employees in data_set.onLeaveEmployees" :key="employees.id">
									<div class="product-img">
										<img :src="getAvatar(employees.avatar)" alt="avatar" class="img-size-50">
									</div>
									<div class="product-info">
										<a href="javascript:void(0)" class="product-title"> {{ employees.name }} <small class="product-description"> {{ employees.dates }} </small>
										</a>
										<span class="product-description"> {{ employees.leaveType }} </span>
									</div>
								</li>
								<!-- /.item -->
							</ul>
						</div>
						<!-- /.card-body -->
						<div class="card-footer text-center">
							<router-link to="leave-applications" class="uppercase">View All On-Leave Employees</router-link>
						</div>
						<!-- /.card-footer -->
					</div>
					<!-- /.card -->
					<!-- solid sales graph -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Birthday(s) this week</h3>
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
							<!-- <a href="javascript:void(0)" class="uppercase">View All Birthdays This Month</a> -->
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
	import moment from 'moment';

	export default {
		data() {
			return {
				data_set: {
					vacant_positions: 0,
					active_employees: 0,
					birthdays: [],
                    onLeaveEmployees: [],
                    newlyAppointedEmployees: [],
                    newlyAppointedEmployeesCount: 0
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
			},
            getAvatar(picture) {
                if (picture != null) {
                    let prefix = (picture.match(/\//) ? '' : '/storage/employee_pictures/');
                    return prefix + picture;
                } else {
                    return '/storage/project_files/employee.png';
                }
            },
			moment: function () {
				return moment();
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
