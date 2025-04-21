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
			<div class="card-header bg-info text-white d-flex align-items-center justify-content-between px-4">
				<div class="">
					<h5 class="mb-1 fw-bold">{{ $transaction->user->firstname }} {{ $transaction->user->lastname }}</h5>
					<span class="small"><i class="fas fa-envelope"></i> {{ $transaction->user->email }}</span>
				</div>
				<div>
					<h5 class="mb-1 fw-bold">{{ $transaction->user->contact_number ?? 'N/A' }}</span></h5>
					<span class="small"><i class="fas fa-envelope"></i> {{ $transaction->user->phone_number ?? 'N/A' }}</span>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<img src="{{ asset('user/uploads/profile/' . ($transaction->user->image ?? 'default-user.png')) }}" class="rounded-circle border border-3 border-light me-3" alt="User Image" width="120" height="120">
					</div>
					<div class="col-md-6">
						<div class="d-flex align-items-center">
							<i class="fas fa-map-marker-alt text-danger me-2"></i>
							<span class="text-muted">Address:</span>
						</div>
						<div class="border rounded p-2 bg-light mt-1">
							<p class="mb-0 fw-bold">{{ optional($transaction->address)->firstname }} {{ optional($transaction->address)->lastname }}</p>
							<p class="mb-0">{{ optional($transaction->address)->street_name }}, {{ optional($transaction->address)->apartment }}</p>
							<p class="mb-0">{{ optional($transaction->address)->city }}, {{ optional($transaction->address)->state }}</p>
							<p class="mb-0">{{ optional($transaction->address)->country }} - {{ optional($transaction->address)->pin }}</p>
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
									Order ID <span class="fw-bold">{{ $transaction->unique_id }}</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Status 
									<span class="badge 
										@if($transaction->status === 'pending') bg-warning 
										@elseif($transaction->status === 'completed') bg-success 
										@elseif($transaction->status === 'cancelled') bg-danger 
										@else bg-secondary @endif">
										{{ ucfirst($transaction->status) }}
									</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Payment Method <span class="fw-bold text-capitalize">{{ $transaction->payment_method ?? 'N/A' }}</span>
								</li>
                                @if($transaction->online_payment_id)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
									Payment Id <span class="fw-bold text-capitalize">{{ $transaction->online_payment_id ?? 'N/A' }}</span>
								</li>
                                @endif
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Total Price <span class="fw-bold text-success">₹{{ number_format($transaction->price, 2) }}</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Order Date <span class="text-muted">{{ date('M d, Y', strtotime($transaction->created_at)) }}</span>
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
									<span class="fw-bold text-danger">₹{{ number_format(optional($transaction->amountBreakdown)->platform_fee, 2) }}</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Shipping Charge 
									<span class="fw-bold">₹{{ number_format(optional($transaction->amountBreakdown)->shipping_charge, 2) }}</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center text-danger">
									Coupon Discount 
									<span class="fw-bold text-primary">- ₹{{ number_format(optional($transaction->amountBreakdown)->coupon_discount, 2) }}</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Admin Fee 
									<span class="fw-bold text-danger">₹{{ number_format(optional($transaction->amountBreakdown)->admin_fee, 2) }}</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Amount to Seller 
									<span class="fw-bold text-success">₹{{ number_format(optional($transaction->amountBreakdown)->amount_to_seller, 2) }}</span>
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
							<div class="table-responsive">
								<table class="table table-hover table-bordered align-middle">
									<thead class="">
										<tr>
											<th>Product</th>
											<th class="d-none d-md-table-cell">Size</th>
											<th>Seller</th>
											<th>Quantity</th>
											<th>Total Price</th>
											<th>Amount to Seller</th>
											<th class="d-none d-md-table-cell">Commission</th>
											<th class="d-none d-md-table-cell">Status</th>
										</tr>
									</thead>
									<tbody>
										@foreach($transaction->orderItems as $item)
											<tr>
												<td>
													<strong>{{ $item->product->name ?? 'N/A' }}</strong> <br>
													<small class="text-muted">₹{{ number_format($item->unit_price, 2) }}</small>
												</td>
												<td class="d-none d-md-table-cell">{{ $item->sku ?? 'N/A' }}</td>
												<td>{{ $item->product->seller->store_name ?? 'Unknown Seller' }}</td>
												<td>{{ $item->quantity }}</td>
												<td>₹{{ number_format($item->unit_price * $item->quantity, 2) }}</td>
												<td>₹{{ number_format(optional($item->breakdown)->amount_to_seller, 2) ?? '0.00' }}</td>
												<td class="d-none d-md-table-cell">
													₹{{ number_format(optional($item->breakdown)->item_total - optional($item->breakdown)->amount_to_seller, 2) ?? '0.00' }}
												</td>
												<td class="d-none d-md-table-cell">
													<span class="badge {{ $item->order_status == 'pending' ? 'bg-warning' : 'bg-success' }}">{{ ucfirst($item->order_status) }}</span>
												</td>
											</tr>
										@endforeach
									</tbody>
									<tfoot class="table-light">
										<tr>
											<th colspan="4" class="text-end">Products Total:</th>
											<th>
												₹{{ number_format($transaction->orderItems->sum(fn($item) => $item->unit_price * $item->quantity), 2) }}
											</th>
											<th>
												₹{{ number_format($transaction->orderItems->sum(fn($item) => optional($item->breakdown)->amount_to_seller), 2) }}
											</th>
											<th class="d-none d-md-table-cell">
												₹{{ number_format($transaction->orderItems->sum(fn($item) => optional($item->breakdown)->item_total - optional($item->breakdown)->amount_to_seller), 2) }}
											</th>
											<th class="d-none d-md-table-cell"></th>
										</tr>
									</tfoot>
								</table>
							</div>
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
