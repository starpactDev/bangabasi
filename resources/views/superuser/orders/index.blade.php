@extends('superuser.layouts.master')

@section('head')
	<!-- Data Tables -->
	<link href='admin/assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='admin/assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>

@endsection

@section('content')
<div class="ec-content-wrapper">
	<div class="content">
		<div class="breadcrumb-wrapper breadcrumb-wrapper-2">
			<h1>Manage Orders</h1>
			<p class="breadcrumbs"><span><a href="{{route('admin_dashboard')}}">Home</a></span>
				<span><i class="mdi mdi-chevron-right"></i></span>Manage Orders
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
										<th>Order Item ID</th>
										<th>Product Name</th>
										<th class="d-none d-lg-table-cell">Units</th>
										<th class="d-none d-lg-table-cell">Order Date</th>										
										<th class="d-none d-lg-table-cell">Price</th>										
										<th>Status</th>
										<th class="d-none d-lg-table-cell">Payment</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@if(count($orderItems)>0)
										@foreach($orderItems as $order)
											@php
												$badgeClass = '';

												switch ($order->order_status) {
													case 'initiated':
														$badgeClass = 'badge-primary';
														break;
													case 'On Hold':
														$badgeClass = 'badge-warning';
														break;
													case 'Completed':
														$badgeClass = 'badge-success';
														break;
													case 'Cancelled':
														$badgeClass = 'badge-danger';
														break;
													default:
														$badgeClass = 'badge-secondary'; // fallback for unknown status
														break;
												}
											@endphp										
											<tr>
												<td>{{$order->order->unique_id ?? 'null'}}</td>
												<td>
													<a class="text-dark" href="{{ route('superuser_orders.show', ['id' => $order->id]) }}"> {{$order->product->name}}</a>
												</td>
												<td class="d-none d-lg-table-cell">{{$order->quantity}} Unit</td>
												<td class="d-none d-lg-table-cell" title="{{$order->created_at}}">{{ date('M d, Y', strtotime($order->created_at)) }}</td>
												<td class="d-none d-lg-table-cell">{{'₹'.$order->unit_price*$order->quantity}}</td>
												<td>
													<span class="badge d-inline-block {{$badgeClass}}" style=" min-width: 18ch;">{{$order->order_status }}</span>
												</td>
												<td class="d-none d-lg-table-cell text-uppercase">{{$order->order->payment_method ?? 'null'	}}</td>
												<td class="text-right">
													<div class="dropdown show d-inline-block widget-dropdown">
														<a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
														<ul class="dropdown-menu dropdown-menu-right">
															<li class="dropdown-item"> <a href="{{ route('superuser_orders.show', $order->id) }}">View</a> </li>
														</ul>
													</div>
												</td>
											</tr>
										@endforeach
									@else
										<h6>No Orders To Display</h6>
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
