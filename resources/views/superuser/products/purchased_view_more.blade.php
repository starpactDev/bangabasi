@extends('superuser.layouts.master')

<style>
	.status-badge {
		cursor: pointer;
	}
</style>

@section('content')
<!-- CONTENT WRAPPER -->
<div class="ec-content-wrapper">
	<div class="content">
		<div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
			<div>
				<h1>Purchased Product</h1>
				<p class="breadcrumbs"><span><a href="{{ route('admin_dashboard') }}">Home</a></span>
					<span><i class="mdi mdi-chevron-right"></i></span>Product
				</p>
			</div>

		</div>
		<div class="row">
			<div class="col-12">
				<div class="card card-default">
					<div class="card-body">
						<div class="table-responsive">
							<table id="responsive-data-table" class="table" style="width:100%">
								<thead>
									<tr>
										<th>Product</th>
										<th>Name</th>
										<th>Category</th>
										<th>Sub-Category</th>
										<th>Original Price &#8377;</th>
										<th>Offer Price &#8377;</th>
										<th>Purchased</th>
									</tr>
								</thead>

								<tbody>
									@foreach ($purchasedProducts as $index => $products)
									@if (!$products->product)
									@continue
									@endif
									<tr>
										<td>
											@if ($products->product->productImages->isNotEmpty())
											<img class="tbl-thumb"
												src="{{ asset('user/uploads/products/images/' . $products->product->productImages->first()->image) }}"
												alt="Product Image">
											@endif
										</td>
										<td>{{ $products->product->name ?? '' }}</td>
										<td>{{ $products->product->categoryDetails->name ?? '' }}</td>
										<td>{{ $products->product->subCategoryDetails->name ?? '' }}</td>
										<td style="color:rgb(219, 9, 9);font-weight:600">
											{{ $products->product->original_price ?? '' }}
										</td>
										<td style="color:rgb(7, 82, 29);font-weight:600">
											{{ $products->product->offer_price ?? '' }}
										</td>


										<td><span class="badge bg-info fw-bold"
												style="font-size: 18px">{{ $products->purchase_count }}</span>
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
</div> <!-- End Content Wrapper -->
@endsection

@push('script')
@endpush