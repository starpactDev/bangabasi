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
											<div class="btn-group mb-1 ">
												<form id="deleteUserForm{{ $user->id }}" action="{{ route('deleteUser', $user->id) }}" method="POST">
													@csrf
													@method('DELETE')
													<button type="button" class=" deleteButton btn btn-outline-danger" data-src="{{ $user->id }}">Delete</button>
												</form>
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
