@extends('superuser.layouts.master')

@section('head')
<link href="{{ url('/') }}/admin/assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet">
@endsection

@section('content')
	<div class="ec-content-wrapper">
		<div class="content">
			<!-- Top Statistics -->
			<div class="row">
				<div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
					<div class="card card-mini dash-card card-1" style="background-color: aliceblue; border:none;">
						<div class="card-body">
							<h2 class="mb-1">{{ number_format($userCount) }}</h2>
							<p>Total Signups</p>
							<span class="mdi mdi-account-arrow-left"></span>
						</div>
					</div>
				</div>

				<div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
					<div class="card card-mini dash-card card-3" style="background-color: beige; border:none;">
						<div class="card-body">
							<h2 class="mb-1">15,503</h2>
							<p>Total Order</p>
							<span class="mdi mdi-package-variant"></span>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
					<div class="card card-mini dash-card card-4" style="background-color: lavenderblush; border:none;">
						<div class="card-body">
							<h2 class="mb-1">&#8377;98,503</h2>
							<p>Total Revenue</p>
							<span class="mdi mdi-currency-inr"></span>
						</div>
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-12 p-b-15">
					<!-- Recent Order Table -->
					<div class="card card-table-border-none card-default recent-orders" id="recent-orders">
						<div class="card-header justify-content-between">
							<h2>Recent Orders</h2>
						</div>
						<div class="card-body pt-0 pb-5">
							<table class="table card-table table-responsive table-responsive-large" style="width:100%">
								<thead>
									<tr>
										<th>Order ID</th>
										<th>Product Name</th>
										<th class="d-none d-lg-table-cell">Units</th>
										<th class="d-none d-lg-table-cell">Order Date</th>										
										<th class="d-none d-lg-table-cell">Price</th>
										<th class="d-none d-lg-table-cell">Payment</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									@if(count($orderItems)>0)
										@foreach($orderItems as $order)
											@php
												$badgeClass = '';

												switch ($order->order_status) {
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
												<td>{{$order->order->unique_id}}</td>
												<td>
													<a class="text-dark" href="{{ route('superuser_orders.show', ['id' => $order->id])}}"> {{$order->product->name}}</a>
												</td>
												<td class="d-none d-lg-table-cell">{{$order->quantity}} Unit</td>
												<td class="d-none d-lg-table-cell" title="$order->created_at">{{ date('M d, Y', strtotime($order->created_at)) }}</td>
												<td class="d-none d-lg-table-cell">{{'₹'.$order->unit_price*$order->quantity}}</td>
												<td>
													<span class="badge d-inline-block {{$badgeClass}}" style=" min-width: 18ch;">{{$order->order_status }}</span>
												</td>
												<td class="d-none d-lg-table-cell text-uppercase">{{$order->order->payment_method	}}</td>
											</tr>
										@endforeach
									@else
										<h6>No Orders To Display</h6>
									@endif
									
								</tbody>
							</table>
							<div class="text-center mt-3">
                                <a href="{{ route('admin_orderlist') }}" class="btn btn-info">
                                    View More
                                </a>
                            </div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xl-5">
					<!-- New Customers -->
					<div class="card ec-cust-card card-table-border-none card-default">
						<div class="card-header justify-content-between ">
							<h2>New Customers</h2>
							<h2>{{ $usersWithSalesAndPrice->count() ?? 0 }} Listed</h2>
						</div>
						<div class="card-body pt-0 pb-15px">
							<table class="table ">
								<thead>
									<tr>
										<th>Name</th>
										<th class="d-none d-md-block">Total Orders</th>
										<th>Total Price</th>
									</tr>
								</thead>
								<tbody>
									@foreach($usersWithSalesAndPrice as $user)
										<tr>
											<td>
												<div class="media">
													<div class="media-image mr-3 rounded-circle">
														<a href=""><img class="profile-img rounded-circle w-45" src="admin/assets/img/user/u1.jpg" alt="customer image"></a>
													</div>
													<div class="media-body align-self-center">
														<a href="">
															<h6 class="mt-0 text-dark font-weight-medium">{{ $user->firstname.' '.$user->lastname }}</h6>
														</a>
														<small class="text-truncate d-inline-block" style="width: 15ch" title="{{$user->email}}">{{ $user->email }}</small>
													</div>
												</div>
											</td>
											<td>{{ $user->sales . ' '.'Orders'}}</td>
											<td class="text-dark d-none d-md-block">{{'₹'.$user->total_price}}</td>
										</tr>
									@endforeach
									
									
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="col-xl-7">
					<!-- Top Products -->
					<div class="card card-default ec-card-top-prod">
						<div class="card-header justify-content-between">
							<h2>Top Products</h2>
						</div>
						<div class="card-body mt-10px mb-10px py-0">
						@if(count($purchasedProducts) > 0)

                            @foreach ($purchasedProducts as $index => $products)
								@if (!$products->product)
									@continue
								@endif
								<div class="row media d-flex pt-15px pb-15px">
									<div class="col-lg-3 col-md-3 col-2 media-image align-self-center rounded">
										<a href="#">
											@if ($products->product->productImages->isNotEmpty())

											<img src="{{ asset('user/uploads/products/images/' . $products->product->productImages->first()->image) }}" alt="customer image">

											@else
										
												<img src="admin/assets/img/products/p1.jpg" alt="customer image">
											@endif
										</a>
									</div>
									<div class="col-lg-9 col-md-9 col-10 media-body align-self-center ec-pos">
										<a href="#">
											<h6 class="mb-10px text-dark font-weight-medium w-75">{{ $products->product->name }}
											</h6>
										</a>
										<p class="float-md-right sale"><span class="mr-2">{{ $products->purchase_count }}</span>Sales</p>
										<p class="d-none d-md-block">Category : {{ $products->product->categoryDetails->name ?? ''}}</p>
										<p class="d-none d-md-block">Sub Category : {{ $products->product->subCategoryDetails->name ?? ''}}</p>
										<p class="mb-0 ec-price">
											<span class="text-dark">₹{{ $products->product->offer_price }}</span>
											<del>₹{{ $products->product->original_price }}</del>
										</p>
									</div>
								</div>
                            @endforeach
						@else 
							<h6 class="text-center fw-bold">No Purchased Products</h6>
						@endif
							<div class="text-center mt-3">
                                <a href="{{ route('purchasedProducts.viewMore') }}" class="btn btn-info">
                                    View More
                                </a>
                            </div>
                        </div>
					</div>
				</div>
			</div>

			<div class="row py-4">
				<div class="col-xl-6">
					<!-- New Sellers -->
					<div class="card ec-cust-card card-table-border-none card-default">
						<div class="card-header justify-content-between ">
							<h2>New Sellers</h2>
							<h2>{{$sellerCount ?? 0}} Listed</h2>
						</div>
						<div class="card-body pt-0 pb-15px">
							<table class="table ">
								<thead>
									<tr>
										<th>Name</th>
										<th class="d-none d-md-block">Total Products</th>
										<th>Total Orders</th>
										<th>Total Amount</th>
									</tr>
								</thead>
								<tbody>
									@foreach($newSellers as $user)
										<tr>
											<td>
												<div class="media">
													<div class="media-image mr-3 rounded-circle">
														<a href=""><img class="profile-img rounded-circle w-45" src="admin/assets/img/user/u1.jpg" alt="customer image"></a>
													</div>
													<div class="media-body align-self-center">
														<a href="">
															<h6 class="mt-0 text-dark font-weight-medium">{{ $user->firstname.' '.$user->lastname }}</h6>
														</a>
														<small class="text-truncate d-inline-block" style="width: 15ch" title="{{$user->email}}">{{ $user->email }}</small>
													</div>
												</div>
											</td>
											<td class="text-dark d-none d-md-block">{{$user->total_products ?? 0}}</td>
											<td>{{ $user->total_sales ?? 0}}</td>
											<td>{{ '₹'.$user->total_sale_price ?? 0 }}</td>
										</tr>
									@endforeach
									
									
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="col-xl-6">
					<!-- Top Products -->
					<div class="card card-default ec-card-top-prod">
						<div class="card-header justify-content-between">
							<h2>Top Products</h2>
						</div>
						<div class="card-body mt-10px mb-10px py-0">
						@if(count($purchasedProducts) > 0)

                            @foreach ($purchasedProducts as $index => $products)
								@if (!$products->product)
									@continue
								@endif
								<div class="row media d-flex pt-15px pb-15px">
									<div class="col-lg-3 col-md-3 col-2 media-image align-self-center rounded">
										<a href="#">
											@if ($products->product->productImages->isNotEmpty())

											<img src="{{ asset('user/uploads/products/images/' . $products->product->productImages->first()->image) }}" alt="customer image">

											@else
										
												<img src="admin/assets/img/products/p1.jpg" alt="customer image">
											@endif
										</a>
									</div>
									<div class="col-lg-9 col-md-9 col-10 media-body align-self-center ec-pos">
										<a href="#">
											<h6 class="mb-10px text-dark font-weight-medium w-75">{{ $products->product->name }}
											</h6>
										</a>
										<p class="float-md-right sale"><span class="mr-2">{{ $products->purchase_count }}</span>Sales</p>
										<p class="d-none d-md-block">Category : {{ $products->product->categoryDetails->name ?? ''}}</p>
										<p class="d-none d-md-block">Sub Category : {{ $products->product->subCategoryDetails->name ?? ''}}</p>
										<p class="mb-0 ec-price">
											<span class="text-dark">₹{{ $products->product->offer_price }}</span>
											<del>₹{{ $products->product->original_price }}</del>
										</p>
									</div>
								</div>
                            @endforeach
						@else 
							<h6 class="text-center fw-bold">No Purchased Products</h6>
						@endif
							<div class="text-center mt-3">
                                <a href="{{ route('purchasedProducts.viewMore') }}" class="btn btn-info">
                                    View More
                                </a>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div> <!-- End Content -->
	</div>
@endsection

@push('script')
<!-- Chart -->
<script src="{{ url('/') }}/admin/assets/plugins/charts/Chart.min.js"></script>
<script src="{{ url('/') }}/admin/assets/js/chart.js"></script>

<!-- Google map chart -->
<script src="{{ url('/') }}/admin/assets/plugins/charts/google-map-loader.js"></script>
<script src="{{ url('/') }}/admin/assets/plugins/charts/google-map.js"></script>

<!-- Date Range Picker -->
<script src="{{ url('/') }}/admin/assets/plugins/daterangepicker/moment.min.js"></script>
<script src="{{ url('/') }}/admin/assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="{{ url('/') }}/admin/assets/js/date-range.js"></script>
@endpush

