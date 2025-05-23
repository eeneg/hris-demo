<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>HRIS</title>{{-- old value:HRIS - Davao del Sur --}}

		{{-- <script src="https://unpkg.com/pdfobject@2.2.4/pdfobject.min.js"></script> --}}
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/project_files/davsurian.ico') }}" />

		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/master.css') }}" rel="stylesheet">
	</head>
	<body class="hold-transition sidebar-mini">
		@auth
		<div class="wrapper" id="app">
			<!-- Navbar -->
			<nav class="main-header navbar navbar-expand navbar-white navbar-light">
				<!-- Left navbar links -->
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
					</li>
					<li class="nav-item d-none d-md-inline-block">
						<a href="/" class="nav-link">Home</a>
					</li>
					<li class="nav-item d-none d-md-inline-block">
						<a href="#" class="nav-link">Contact</a>
					</li>
				</ul>
				<!-- SEARCH FORM -->
				{{--
				<div class="form-inline ml-3">
					<div class="input-group input-group-md" style="width: 400px;">
						<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
						<div class="input-group-append">
							<button class="btn btn-navbar" type="submit">
							<i class="fas fa-search"></i>
							</button>
						</div>
					</div>
				</div>
				--}}
				<!-- Right navbar links -->
				<ul class="navbar-nav ml-auto">
					<ul class="navbar-nav">
						{{--
						<li class="nav-item d-none d-sm-inline-block">
							<a href="{{ route('logout') }}"
								onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link">
							{{ __('Logout') }}&nbsp;<i class="fas fa-power-off"></i>
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
						</li>
						--}}
					</ul>
				</ul>
			</nav>
			<!-- /.navbar -->
			<!-- Main Sidebar Container -->
			<aside class="main-sidebar sidebar-light-primary elevation-4 fix">
				<!-- Brand Logo -->
				<a href="/" class="brand-link">
					<img src="{{ asset('/storage/project_files/davsurian.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
					<div style="line-height: 1.3;margin-bottom: -5px;">
						<span class="brand-text font-weight-light" style="font-size: 13px;display: block;">Human Resource</span>
						<span class="brand-text font-weight-light" style="font-size: 13px;display: block;">Information System</span>
					</div>
				</a>
				<!-- Sidebar -->
				<div class="sidebar">
					<!-- Sidebar user panel (optional) -->
                    @can('employee')
                    @else
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="align-items: center;">
						<div class="image">
                            <img src="{{ auth()->user()->avatar == "profile.png" ?  asset('/storage/project_files/profile.png') : asset('/storage/user_avatars/' . auth()->user()->avatar) }}" class="img-circle elevation-2" alt="User Image">
						</div>
						<div class="info">
							<router-link to="/profile" class="d-block" style="background-color: unset !important;color: #3f3f3f !important;">
								{{ auth()->user()->name }}
								<p style="margin: 0;line-height: 0.6rem;font-size: 0.7rem;">{{ auth()->user()->role }}</p>
							</router-link>
						</div>
					</div>
                    @endcan

					<!-- Sidebar Menu -->
					<nav class="mt-2">
						<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
							<!-- Add icons to the links using the .nav-icon class
                                with font-awesome or any other icon font library -->
                            @cannot('employee')
							<li class="nav-item">
								<router-link to="/" exact class="nav-link">
									<i class="nav-icon fas fa-tachometer-alt blue"></i>
									<p>Dashboard</p>
								</router-link>
							</li>
							@endcannot
							@cannot('employee')
							<li class="nav-item has-treeview">
								<a href="" class="nav-link">
									<i class="nav-icon fas fa-user-tie green"></i>
									<p>
										Employees
										<i class="right fas fa-angle-left"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/employees" class="nav-link">
											<i class="nav-icon fas fa-list"></i>
											<p>Employee List</p>
										</router-link>
									</li>
                                    @can('isAdministratorORAuthor')
									<li class="nav-item">
										<router-link to="/requests" class="nav-link">
											<i class="nav-icon fas fa-file-signature"></i>
											<p>PDS Edit Requests</p>
										</router-link>
									</li>
                                   <li class="nav-item">
                                        <router-link to="/employee-reappointments" class="nav-link">
                                            <i class="nav-icon fas fa-briefcase"></i>
                                            <p>Reassignment</p>
                                        </router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link to="/employee-status" class="nav-link">
                                            <i class="nav-icon fas fa-user"></i>
                                            <p>Employee status</p>
                                        </router-link>
                                    </li>
                                   @endcan
								</ul>
                            </li>
                            @endcannot
							@can('isAdministratorORAuthor')
                            <li class="nav-item">
								<router-link to="/dtr" exact class="nav-link">
									<i class="nav-icon fas fa-fingerprint purple"></i>
									<p>DTR</p>
								</router-link>
							</li>
							<li class="nav-item has-treeview">
								<a href="" class="nav-link">
									<i class="nav-icon fas fa-book orange"></i>
									<p>
										Plantilla
										<i class="right fas fa-angle-left"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/plantilla" class="nav-link">
											<i class="fas fa-book-open nav-icon"></i>
											<p>Annual Plantilla</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/salaryschedule" class="nav-link">
											<i class="fas fa-coins nav-icon"></i>
											<p>Salary Schedule</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/departments" class="nav-link">
											<i class="fas fa-building nav-icon"></i>
											<p>Departments & Positions</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/appointments" class="nav-link">
											<i class="fas fa-clipboard-list nav-icon"></i>
											<p>Appointments</p>
										</router-link>
									</li>
                                    <li class="nav-item">
										<router-link to="/separations" class="nav-link">
											<i class="fas fa-edit nav-icon"></i>
											<p>Separation</p>
										</router-link>
									</li>
                                    <li class="nav-item">
										<router-link to="/qualification-standards" class="nav-link">
											<i class="fas fa-clipboard-list nav-icon"></i>
											<p>Qualification Standards</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/job-descriptions" class="nav-link">
											<i class="fas fa-user-nurse nav-icon"></i>
											<p>Job Descriptions</p>
										</router-link>
									</li>
								</ul>
                            </li>
                            @endcan
                            @cannot('employee')
                            <li class="nav-item has-treeview">
								<a href="" class="nav-link">
									<i class="nav-icon fas fa-folder blue"></i>
									<p>
										Leave Records
										<i class="right fas fa-angle-left"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/leave-credits" class="nav-link">
											<i class="fas fa-download nav-icon"></i>
											<p>Credits</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/leave-applications" class="nav-link">
											<i class="fas fa-file nav-icon"></i>
											<p>Applications</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/leave-types" class="nav-link">
											<i class="fas fa-list nav-icon"></i>
											<p>Leave Types</p>
										</router-link>
									</li>
                                    <li class="nav-item">
										<router-link to="/leave-reports" class="nav-link">
											<i class="fas fa-print nav-icon"></i>
											<p>Leave Reports</p>
										</router-link>
									</li>
								</ul>
                            </li>
                            @endcannot
                            @can('isAdministratorORAuthor')
							<li class="nav-item">
                                <a href="" class="nav-link">
									<i class="nav-icon fas fa-print blue"></i>
									<p>
										Reports
										<i class="right fas fa-angle-left"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/nosi" class="nav-link">
											<i class="fas fa-file-word nav-icon"></i>
											<p>NOSI</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/nosa" class="nav-link">
											<i class="fas fa-file-word nav-icon"></i>
											<p>NOSA</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/loyalty" class="nav-link">
											<i class="fas fa-file-word nav-icon"></i>
											<p>Loyalty Benefits</p>
										</router-link>
									</li>
                                    <li class="nav-item">
										<router-link to="/employee-service-record" class="nav-link">
											<i class="fas fa-file-word nav-icon"></i>
											<p>Service Record</p>
										</router-link>
									</li>
                                    {{-- <li class="nav-item">
										<router-link to="/service-record" class="nav-link">
											<i class="fas fa-file-word nav-icon"></i>
											<p>Service Record</p>
										</router-link>
									</li> --}}
									<li class="nav-item">
										<router-link to="/reports" class="nav-link">
											<i class="fas fa-list nav-icon"></i>
											<p>Others</p>
										</router-link>
									</li>
								</ul>
							</li>
							@endcan
                            @can('isAdministratorORAuthor')
							<li class="nav-item has-treeview">
								<a href="" class="nav-link">
									<i class="nav-icon fas fa-bell purple"></i>
									<p>
										Activities
										<i class="right fas fa-angle-left"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/activities" class="nav-link">
											<i class="nav-icon fas fa-bullhorn"></i>
											<p>All Activities</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/activities-create" class="nav-link">
											<i class="nav-icon fas fa-plus-circle"></i>
											<p>New Activity</p>
										</router-link>
									</li>
								</ul>
                            </li>
							@endcan
							@can('isAdministrator')
							<li class="nav-item has-treeview">
								<a href="" class="nav-link">
									<i class="nav-icon fas fa-users-cog orange"></i>
									<p>
										Management
										<i class="right fas fa-angle-left"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<router-link to="/settings" class="nav-link">
											<i class="fas fa-tools nav-icon"></i>
											<p>Settings</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/users" class="nav-link">
											<i class="fas fa-users nav-icon"></i>
											<p>Users</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/developer" class="nav-link">
											<i class="fas fa-laptop-code nav-icon"></i>
											<p>Developer</p>
										</router-link>
									</li>
									<li class="nav-item">
										<router-link to="/audits" class="nav-link">
											<i class="fas fa-file-signature nav-icon"></i>
											<p>Activity Logs</p>
										</router-link>
									</li>
								</ul>
							</li>
                            @endcan
                            @cannot('employee')
							<li class="nav-item">
								<router-link to="/profile" class="nav-link">
									<i class="nav-icon fas fa-user blue"></i>
									<p>Profile</p>
								</router-link>
							</li>
                            @endcannot
                            @can('employee')
                            <li class="nav-item">
								<router-link to="/employees-pds-view" class="nav-link">
									<i class="nav-icon fas fa-user blue"></i>
									<p>PDS</p>
								</router-link>
                            </li>
                            <li class="nav-item">
								<router-link to="/employee-pds-edit-requests" class="nav-link">
									<i class="nav-icon fas fa-file-signature green"></i>
									<p>PDS Status</p>
								</router-link>
                            </li>
                            <li class="nav-item">
								<router-link to="/employee-view-service-record" class="nav-link">
									<i class="nav-icon fas fa-clipboard-list blue"></i>
									<p>Service Record</p>
								</router-link>
                            </li>
                            <li class="nav-item">
								<router-link to="/employee-leave-applications" class="nav-link">
									<i class="nav-icon fas fa-file purple"></i>
									<p>Leave Applications</p>
								</router-link>
                            </li>
                            <li class="nav-item">
								<router-link to="/employee-view-leave-card" class="nav-link">
									<i class="nav-icon fas fa-list purple"></i>
									<p>Leave Card</p>
								</router-link>
                            </li>
                            <li class="nav-item">
								<router-link :to="{ path: '/employees-saln', query: {id: '{{auth()->user()->id}}'} }" class="nav-link">
									<i class="nav-icon fas fa-file orange"></i>
									<p>SALN</p>
								</router-link>
                            </li>
                            @endcan
							<li class="nav-item">
								<a href="{{ route('logout') }}"
								@click.prevent="logout"
								{{-- onclick="event.preventDefault();document.getElementById('logout-form').submit();" --}}
								class="nav-link">
								<i class="nav-icon fas fa-power-off red"></i>
								<p>{{ __('Logout') }}</p>
								</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
								</form>
							</li>
						</ul>
					</nav>
					<!-- /.sidebar-menu -->
				</div>
				<!-- /.sidebar -->
			</aside>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Main content -->
				<div class="content pt-4">
					<div class="container-fluid">
						<router-view></router-view>
						<vue-progress-bar></vue-progress-bar>
					</div>
					<!-- /.container-fluid -->
				</div>
				<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->
			<!-- Control Sidebar -->
			<aside class="control-sidebar control-sidebar-dark">
				<!-- Control sidebar content goes here -->
				<div class="p-3">
					<h5>Title</h5>
					<p>Sidebar content</p>
				</div>
			</aside>
			<!-- /.control-sidebar -->
			<!-- Main Footer -->
			<footer class="main-footer">
				<!-- To the right -->
				<div class="float-right d-none d-sm-inline">
					Powered by <b>Provincial Information & Communications Technology Office</b>
				</div>
				<!-- Default to the left -->
				<strong>For the theme: </strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>. All rights reserved.
			</footer>
		</div>
		<!-- ./wrapper -->
		<script>
			window.user = @json(auth()->user())
		</script>
		@endauth
		<!-- REQUIRED SCRIPTS -->
		<script src="{{ asset('js/app.js') }}"></script>
	</body>
</html>
