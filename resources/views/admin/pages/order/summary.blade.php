@extends('admin.layouts.master')

@section('head')
	<!-- Data Tables -->
	<link href='admin/assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='admin/assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>

@endsection

@section('content')
<div class="ec-content-wrapper">
	<div class="content">
		<div class="breadcrumb-wrapper breadcrumb-wrapper-2">
			<h1>Order Summary</h1>
			<p class="breadcrumbs"><span><a href="{{route('admin_dashboard')}}">Home</a></span>
				<span><i class="mdi mdi-chevron-right"></i></span>Order Summary
			</p>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card card-default">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table card-table table-responsive table-responsive-large" id="responsive-data-table" style="width:100%">
								<thead>
									<tr>
										<th>Order ID</th>
										<th class="d-none d-lg-table-cell">Date</th>                                        
										<th>Paid</th>
										<th>Admin</th>
										<th>Seller</th>                    
										<th class="d-none d-lg-table-cell">Payment</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@if($orders->count() > 0)
										@foreach($orders as $order)       
											@php
												$badgeClass = match ($order->order_status) {
													'initiated' => 'badge-primary',
													'On Hold' => 'badge-warning',
													'Completed' => 'badge-success',
													'Cancelled' => 'badge-danger',
													default => 'badge-secondary',
												};
											@endphp    
											<tr>
												<td class="text-success">
													<span class="p-1 mr-2 {{ $badgeClass }}"></span>
													{{ $order->unique_id ?? 'N/A' }}
												</td>
												<td class="d-none d-lg-table-cell" title="{{ $order->created_at }}">
													{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
												</td>
												<td>
													₹{{ number_format($order->amountBreakdown?->total_paid_by_customer ?? 0, 2) }}
												</td>
												<td>
													₹{{ number_format($order->amountBreakdown?->admin_fee ?? 0, 2) }}
												</td>
												<td>
													₹{{ number_format($order->amountBreakdown?->amount_to_seller ?? 0, 2) }}
												</td>
												<td class="d-none d-lg-table-cell text-uppercase">
													{{ $order->payment_method ?? 'N/A' }}
												</td>
												<td class="text-right">
													<div class="dropdown show d-inline-block widget-dropdown">
														<a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdown-recent-order1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
														<ul class="dropdown-menu dropdown-menu-right">
															<li class="dropdown-item"><a href="{{ route('admin_order_summary', ['order' => $order->id])}}">View</a></li>
														</ul>
													</div>
												</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td colspan="7" class="text-center"><h6>No Orders To Display</h6></td>
										</tr>
									@endif
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
