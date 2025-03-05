@extends('superuser.layouts.master')

@section('head')
	<!-- Data Tables -->
	<link href='admin/assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='admin/assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>
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
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser"> Add User </button>
			</div>
		</div>
		@if(session('success'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Success!</strong> {{ session('success') }}
			</div>
		@endif
		
		@if(session('error'))
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Error!</strong> {{ session('error') }}
			</div>
		@endif

		<div class="row">
			<div class="col-12">
				<div class="ec-vendor-list card card-default">
					<div class="card-body">
						<div class="table-responsive">
							<table id="responsive-data-table" class="table">
								<thead>
									<tr>
										<th>Name</th>
										<th>Phone</th>
										<th>Contact</th>
										<th>Verified</th>
										<th>Join On</th>
										<th>Action</th>
									</tr>
								</thead>

								<tbody id="userTableBody">
									@foreach($users as $user)
									<tr>
										<td>
											<div class="media">
												<div class="media-image mr-3 rounded-circle">
													<img class="profile-img rounded-circle w-45" src="{{'user/uploads/profile/'. ($user->image ?? 'default_dp.png')}}" data-src="admin/assets/img/user/u1.jpg" alt="customer image">
												</div>
												<div class="media-body align-self-center">
														<h6 class="mt-0 text-dark font-weight-medium">{{ $user->firstname.' '.$user->lastname }}</h6>
													<small class="text-truncate d-inline-block" style="width: 20ch" title="{{$user->email}}">{{ $user->email }}</small>
												</div>
											</div>
										</td>
										<td>{{ $user->phone_number }}</td>
										<td>{{ $user->contact_number }}</td>
										<td>{{ $user->email_verified_at ? 'Yes' : 'No'}}</td>
										<td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : '' }}</td>
										<td>
											<div class="btn-group mb-1">
												<a href="" class="btn btn-outline-success">Info</a>
												<button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
													<span class="sr-only">Info</span>
												</button>

												<div class="dropdown-menu">
													<a class="dropdown-item " href="">Edit</a>
													<form id="deleteUserForm{{ $user->id }}" action="{{ route('deleteUser', $user->id) }}" method="POST">
														@csrf
														@method('DELETE')
														<button type="button" class="dropdown-item deleteButton" data-src="{{ $user->id }}">Delete</button>
													</form>
												</div>
											</div>
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
		<div class="modal fade modal-add-contact" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
							<button type="button" class="btn btn-secondary btn-pill" data-bs-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-primary btn-pill">Save Contact</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div> <!-- End Content -->
</div>
@endsection

@push('script')
	<!-- Data Tables -->
	<script src='admin/assets/plugins/data-tables/jquery.datatables.min.js'></script>
	<script src='admin/assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
	<script src='admin/assets/plugins/data-tables/datatables.responsive.min.js'></script>

	<script id="deleteUser">

			document.getElementById('userTableBody').addEventListener('click', function(event) {
			if (event.target && event.target.classList.contains('deleteButton')) {
				
				// Get the user ID from data-src
				let userId = event.target.getAttribute('data-src');
				let form = document.getElementById(`deleteUserForm${userId}`);

				console.log(userId, form);
				
				// Show the SweetAlert confirmation popup using SweetAlert2
				Swal.fire({
					title: "Are you sure?",
					text: "You won't be able to revert this!",
					icon: "warning",
					showCancelButton: true,  // This shows the cancel button
					confirmButtonText: 'Yes, delete it!',
					cancelButtonText: 'No, cancel!',
					dangerMode: true
				}).then((result) => {
					if (result.isConfirmed) {
						// Submit the form to delete the user
						form.submit();
					}
				});

			}
		});
	</script>	
@endpush
