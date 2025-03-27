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
					<h1>Vendor List</h1>
					<p class="breadcrumbs"><span><a href="{{route('admin_dashboard')}}">Home</a></span><span><i class="mdi mdi-chevron-right"></i></span>Vendor</p>
				</div>
				<div>
					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVendor"> Add Vendor
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
											<th>Status</th>
											<th>Join On</th>
											<th>Net Earning</th>
											<th>Action</th>
										</tr>
									</thead>

									<tbody>
										@foreach ($sellers as $seller)
											<tr>
												<td>{{ $seller->name }}</td>
												<td>{{ $seller->email }}</td>
												<td>{{ $seller->status ? 'Active' : 'Inactive' }}</td>
												<td>{{ $seller->join_on }}</td>
												<td>{{ $seller->total_earnings }}</td>
												<td>
													<div class="btn-group">
														<button type="button" class="btn btn-outline-success">Info</button>
														<button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
															<span class="sr-only">Info</span>
														</button>
														<div class="dropdown-menu">
															<a class="dropdown-item" href="{{ route('admin_sellerlist.toggle_status', ['id' => $seller->seller_id]) }}"onclick="return confirm('Are you sure you want to toggle the status?');">Toggle Status </a>
															<a class="dropdown-item" href="#">Delete</a>
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

			<!-- Add Vendor Modal  -->
			<div class="modal fade modal-add-contact" id="addVendor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<form >
							<div class="modal-header px-4">
								<h5 class="modal-title" id="exampleModalCenterTitle">Add New Vendor</h5>
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
											<input type="text" class="form-control" id="userName" value="johndoe">
										</div>
									</div>

									<div class="col-lg-6">
										<div class="form-group mb-4">
											<label for="email">Email</label>
											<input type="email" class="form-control" id="email" value="johnexample@gmail.com">
										</div>
									</div>

									<div class="col-lg-6">
										<div class="form-group mb-4">
											<label for="Birthday">Birthday</label>
											<input type="text" class="form-control" id="Birthday" value="10-12-1991">
										</div>
									</div>

									<div class="col-lg-6">
										<div class="form-group mb-4">
											<label for="event">Address</label>
											<input type="text" class="form-control" id="event" value="Address here">
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

@section('script')
	<!-- Data Tables -->
	<script src='admin/assets/plugins/data-tables/jquery.datatables.min.js'></script>
	<script src='admin/assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
	<script src='admin/assets/plugins/data-tables/datatables.responsive.min.js'></script>
@endsection