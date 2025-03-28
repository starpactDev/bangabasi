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

		<div class="card shadow-sm mb-4 border-0">
			<div class="card-header bg-info text-white d-flex align-items-center justify-content-between">
				<div class="ml-5">
					<h5 class="mb-1 fw-bold">{{ $order->user->firstname }} {{ $order->user->lastname }}</h5>
					<span class="small"><i class="fas fa-envelope"></i> {{ $order->user->email }}</span>
				</div>
				<div>
					<h5 class="mb-1 fw-bold">{{ $order->user->contact_number ?? 'N/A' }}</span></h5>
					<span class="small"><i class="fas fa-envelope"></i> {{ $order->user->phone_number ?? 'N/A' }}</span>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<img src="{{ asset('user/uploads/profile/' . ($order->user->image ?? 'default-user.png')) }}" class="rounded-circle border border-3 border-light me-3" alt="User Image" width="120" height="120">
					</div>
					<div class="col-md-6">
						<div class="d-flex align-items-center">
							<i class="fas fa-map-marker-alt text-danger me-2"></i>
							<span class="text-muted">Address:</span>
						</div>
						<div class="border rounded p-2 bg-light mt-1">
							<p class="mb-0 fw-bold">{{ optional($order->address)->firstname }} {{ optional($order->address)->lastname }}</p>
							<p class="mb-0">{{ optional($order->address)->street_name }}, {{ optional($order->address)->apartment }}</p>
							<p class="mb-0">{{ optional($order->address)->city }}, {{ optional($order->address)->state }}</p>
							<p class="mb-0">{{ optional($order->address)->country }} - {{ optional($order->address)->pin }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="container mt-4">
			<div class="row">
				<!-- Order Details -->
				<div class="col-md-6">
					<div class="card shadow-sm border-0">
						<div class="card-header bg-primary text-white">
							<h5 class="mb-0"><i class="fas fa-receipt me-2"></i> Order Details</h5>
						</div>
						<div class="card-body">
							<ul class="list-group list-group-flush">
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Order ID <span class="fw-bold">{{ $order->unique_id }}</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Status 
									<span class="badge 
										@if($order->status === 'pending') bg-warning 
										@elseif($order->status === 'completed') bg-success 
										@elseif($order->status === 'cancelled') bg-danger 
										@else bg-secondary @endif">
										{{ ucfirst($order->status) }}
									</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Payment Method <span class="fw-bold text-capitalize">{{ $order->payment_method ?? 'N/A' }}</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Total Price <span class="fw-bold text-success">₹{{ number_format($order->price, 2) }}</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Order Date <span class="text-muted">{{ date('M d, Y', strtotime($order->created_at)) }}</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			
				<!-- Amount Breakdown -->
				<div class="col-md-6">
					<div class="card shadow-sm border-0">
						<div class="card-header bg-success text-white">
							<h5 class="mb-0"><i class="fas fa-chart-line me-2"></i> Amount Breakdown</h5>
						</div>
						<div class="card-body">
							<ul class="list-group list-group-flush">
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Platform Fee 
									<span class="fw-bold text-danger">₹{{ number_format(optional($order->amountBreakdown)->platform_fee, 2) }}</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Shipping Charge 
									<span class="fw-bold">₹{{ number_format(optional($order->amountBreakdown)->shipping_charge, 2) }}</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center text-danger">
									Coupon Discount 
									<span class="fw-bold text-primary">- ₹{{ number_format(optional($order->amountBreakdown)->coupon_discount, 2) }}</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Admin Fee 
									<span class="fw-bold text-danger">₹{{ number_format(optional($order->amountBreakdown)->admin_fee, 2) }}</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Amount to Seller 
									<span class="fw-bold text-success">₹{{ number_format(optional($order->amountBreakdown)->amount_to_seller, 2) }}</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			
		
			<!-- Order Items -->
			<div class="row mt-4">
				<div class="col-md-12">
					<div class="card shadow-sm">
						<div class="card-header bg-info text-white">
							<h5 class="mb-0">Order Items Breakdown</h5>
						</div>
						<div class="card-body">
							<table class="table table-hover table-bordered align-middle">
								<thead class="">
									<tr>
										<th>Product</th>
										<th>Size</th>
										<th>Quantity</th>
										<th>Total Price</th>
										<th>Amount to Seller</th>
										<th>Commission</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									@foreach($order->orderItems as $item)
										<tr>
											<td>
												<strong>{{ $item->product->name ?? 'N/A' }}</strong> <br>
												<small class="text-muted">₹{{ number_format($item->unit_price, 2) }}</small>
											</td>
											<td>{{ $item->sku ?? 'N/A' }}</td>
											<td>{{ $item->quantity }}</td>
											<td>₹{{ number_format($item->unit_price * $item->quantity, 2) }}</td>
											<td>
												₹{{ number_format(optional($item->breakdown)->amount_to_seller, 2) ?? '0.00' }}
											</td>
											<td>
												₹{{ number_format(optional($item->breakdown)->item_total - optional($item->breakdown)->amount_to_seller, 2) ?? '0.00' }}
											</td>
											<td>
												<span class="badge {{ $item->order_status == 'pending' ? 'bg-warning' : 'bg-success' }}">{{ ucfirst($item->order_status) }}</span>
											</td>
										</tr>
									@endforeach
								</tbody>
								<tfoot class="table-light">
									<tr>
										<th colspan="4" class="text-end">Products Total:</th>
										<th>
											₹{{ number_format($order->orderItems->sum(fn($item) => $item->unit_price * $item->quantity), 2) }}
										</th>
										<th>
											₹{{ number_format($order->orderItems->sum(fn($item) => optional($item->breakdown)->amount_to_seller), 2) }}
										</th>
										<th>
											₹{{ number_format($order->orderItems->sum(fn($item) => optional($item->breakdown)->item_total - optional($item->breakdown)->amount_to_seller), 2) }}
										</th>
										<th></th>
									</tr>
								</tfoot>
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
