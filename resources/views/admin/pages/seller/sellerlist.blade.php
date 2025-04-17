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
					<h1>Vendor List</h1>
					<p class="breadcrumbs"><span><a href="{{route('admin_dashboard')}}">Home</a></span><span><i class="mdi mdi-chevron-right"></i></span>Vendor</p>
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
											<th>Join On</th>
											<th>Sold</th>
											<th>Earning</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>

									<tbody>
										@foreach ($sellers as $seller)
											<tr style="{{ $seller->status ? '' : 'color:darkgrey; filter:grayscale(1)' }}">
												<td style="{{ $seller->status ? 'color:green' : 'color:darkgrey' }}">{{ $seller->name }}</td>
												<td>{{ $seller->email }}</td>
												<td>{{ $seller->join_on }}</td>
												<td>{{ $seller->total_products_sold }}</td>
												<td>{{ $seller->total_earnings }}</td>
												<td>
													<form action="{{ route('admin_sellerlist.toggle_status', $seller->seller_id) }}" method="POST" id="toggleForm-{{ $seller->seller_id }}">
														@csrf
														<div class="form-check form-switch">
															<input class="form-check-input {{ $seller->status ? 'bg-success' : '' }}" type="checkbox" role="switch" id="statusSwitch-{{ $seller->seller_id }}" name="status" {{ $seller->status ? 'checked' : '' }} onchange="document.getElementById('toggleForm-{{ $seller->seller_id }}').submit();">
														</div>
													</form>
												</td>
												<td>
													<div class="btn-group">
														<a href="{{ route('admin_seller.details', ['id' => $seller->seller_id])}}" class="btn btn-outline-info py-0">Info</a>
														
														<form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this seller?');">
															@csrf
															@method('DELETE')
															<button type="submit" class="btn btn-outline-danger">Delete</button>
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

@section('script')
	<!-- Data Tables -->
	<script src='admin/assets/plugins/data-tables/jquery.datatables.min.js'></script>
	<script src='admin/assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
	<script src='admin/assets/plugins/data-tables/datatables.responsive.min.js'></script>
@endsection