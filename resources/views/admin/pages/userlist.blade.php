@extends('superuser.layouts.master')

@section('head')
	<!-- Data Tables -->
	<link href='admin/assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='admin/assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>=
@endsection

@section('content')
<div class="ec-content-wrapper">
	<div class="content">
		<div class="breadcrumb-wrapper breadcrumb-contacts">
			<div>
				<h1>User List</h1>
				<p class="breadcrumbs"><span><a href="{{route('admin_dashboard')}}">Home</a></span>
					<span><i class="mdi mdi-chevron-right"></i></span>User
				</p>
			</div>
			<div>
				<button type="button" class="btn btn-primary" data-bs-toggle="modal"
					data-bs-target="#addUser"> Add User
				</button>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="ec-vendor-list card card-default">
					<div class="card-body">
						<div class="table-responsive">
						<table id="responsive-data-table" class="table">
							<thead>
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Status</th>
									<th>Join On</th>
									<th>Action</th>
								</tr>
							</thead>

							<tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone_number }}</td>
                                        <td>{{ $user->status }}</td>
										<td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : '' }}</td>
                                        <td>
                                            <!-- Action buttons (e.g., Edit, Delete) can be added here -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
						</table>

						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Add User Modal  -->
		<div class="modal fade modal-add-contact" id="addUser" tabindex="-1" role="dialog"
			aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<form>
						<div class="modal-header px-4">
							<h5 class="modal-title" id="exampleModalCenterTitle">Add New User</h5>
						</div>

						<div class="modal-body px-4">


							<div class="row mb-2">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="firstName">First name</label>
										<input type="text" class="form-control" id="firstName" value="John">
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group">
										<label for="lastName">Last name</label>
										<input type="text" class="form-control" id="lastName" value="Deo">
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group mb-4">
										<label for="userName">User name</label>
										<input type="text" class="form-control" id="userName"
											value="johndoe">
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group mb-4">
										<label for="email">Email</label>
										<input type="email" class="form-control" id="email"
											value="johnexample@gmail.com">
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group mb-4">
										<label for="Birthday">Birthday</label>
										<input type="text" class="form-control" id="Birthday"
											value="10-12-1991">
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group mb-4">
										<label for="event">Address</label>
										<input type="text" class="form-control" id="event"
											value="Address here">
									</div>
								</div>
							</div>
						</div>

						<div class="modal-footer px-4">
							<button type="button" class="btn btn-secondary btn-pill"
								data-bs-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-primary btn-pill">Save Contact</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div> <!-- End Content -->
</div>
@endsection

@section('script')
	<!-- Data Tables -->
	<script src='admin/assets/plugins/data-tables/jquery.datatables.min.js'></script>
	<script src='admin/assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
	<script src='admin/assets/plugins/data-tables/datatables.responsive.min.js'></script>
@endsection
