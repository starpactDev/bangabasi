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
			<h1>Transaction History</h1>
			<p class="breadcrumbs"><span><a href="{{route('admin_dashboard')}}">Home</a></span>
				<span><i class="mdi mdi-chevron-right"></i></span>Transactions
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
										<th class="d-none d-lg-table-cell">Order Date</th>										
										<th class="d-none d-lg-table-cell">Price</th>
										<th class="d-none d-lg-table-cell">Payment</th>
										<th>Method</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@if(count($transactions)>0)
										@foreach($transactions as $order)		
															
											@php
												$badgeClass = '';

												switch ($order->status) {
													case 'Delayed':
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
												<td>{{$order->unique_id}}</td>
												
												
												<td class="d-none d-lg-table-cell" title="{{ $order->created_at }}">{{ date('M d, Y', strtotime($order->created_at)) }}</td>
												<td class="d-none d-lg-table-cell">{{'₹'.$order->price}}</td>
												<td>
													<span class="badge d-inline-block {{$badgeClass}}" style=" min-width: 18ch;">{{$order->status }}</span>
												</td>
												<td class="d-none d-lg-table-cell text-uppercase">{{$order->payment_method	}}</td>
												<td class="text-center">
													<div class="show d-inline-block ">
														<a class="" href="{{ route('admin_transaction_view', ['order' => $order->id])}}" >View</a>
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
