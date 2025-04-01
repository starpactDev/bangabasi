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
													<div class="btn-group">
														<a href="{{ route('admin_seller.details', ['id' => $seller->seller_id])}}" class="btn btn-outline-success">Info</a>
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

		</div> <!-- End Content -->
	</div>
@endsection

@section('script')
	<!-- Data Tables -->
	<script src='admin/assets/plugins/data-tables/jquery.datatables.min.js'></script>
	<script src='admin/assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
	<script src='admin/assets/plugins/data-tables/datatables.responsive.min.js'></script>
@endsection