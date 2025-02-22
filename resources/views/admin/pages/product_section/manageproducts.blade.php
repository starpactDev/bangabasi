@extends('superuser.layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .text-danger {
            color: red !important;
        }
    </style>
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
                <div>
                    <h1>Manage Products for {{ ucfirst($section) }}</h1>

                </div>

            </div>

            <div class="product-brand card card-default p-24px">
                <div class="row mb-m-24px">

<!-- Display success message -->
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!-- Display error message -->
@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
                    <div class="col-12">
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <!-- Filter Form (Top Left) -->
                                   
                                        <div class="form-group me-2">
                                            <label for="category" class="form-label">Filter by Category</label>
                                            <select id="category" name="category" class="form-select">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ request('category') == $category->name ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <a href="{{ route('manage.products', ['section' => $section]) }}" class="btn btn-secondary mt-2 ms-2">Reset</a>
                                        </div>
                                       
                                        
                                   

                                    <!-- Save Changes Form (Top Right) -->
                                    <form action="{{ route('manage.products.save') }}" method="POST" id="product-form" class="d-flex align-items-center">
                                        @csrf
                                        <input type="hidden" name="section" value="{{ $section }}">
                                        <input type="hidden" id="selected-products" name="selected_products" value="">
                                        <button type="submit" class="btn btn-success btn-lg">Save Changes</button>
                                    </form>
                                </div>
<div class="mb-5"><span style="color:blueviolet; font-weight:bold">Total Products Selected:</span> <span style="color:brown;font-weight:bold">{{ count($selectedProductIds) }}</span></div>
                                <table class="table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center fw-bold">Product</th>
                                            <th class="text-center fw-bold">Name</th>
                                            <th class="text-center fw-bold">Category</th>
                                            <th class="text-center fw-bold">Sub-Category</th>
                                            <th class="text-center fw-bold">Select</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($products as $product)
                                        <tr class="text-center" data-category-id="{{ $product->category }}">
                                            <td>
                                                @if ($product->productImages->isNotEmpty())
                                                    <img class="tbl-thumb"
                                                        src="{{ asset('user/uploads/products/images/' . $product->productImages->first()->image) }}"
                                                        alt="Product Image">
                                                @endif
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->categoryDetails->name }}</td>
                                            <td>{{ $product->subCategoryDetails->name }}</td>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="products[]" value="{{ $product->id }}"
                                                        id="product-{{ $product->id }}"
                                                        {{ in_array($product->id, $selectedProductIds) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="product-{{ $product->id }}"></label>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-danger fw-bold" style="font-size: 1.5rem;">
                                                No products to show
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal -->





                </div>
            </div>



            <!-- Add Brand Button  -->



        </div> <!-- End Content -->
    </div> <!-- End Content Wrapper -->
@endsection

@push('script')
<script>
$(document).ready(function() {
    $('#category').change(function() {
        var selectedCategory = $(this).val(); // Get the selected category ID

        $('tbody tr').each(function() {
            // Get the category ID from the table row (assuming it's stored in a data attribute)
            var productCategoryId = $(this).data('category-id'); // Get the category ID from a data attribute

            // Check if the selected category matches the product category ID
            if (selectedCategory === "" || productCategoryId == selectedCategory) {
                $(this).show(); // Show the row if it matches
            } else {
                $(this).hide(); // Hide the row if it doesn't match
            }
        });
    });
});
</script>
<script>
    $(document).ready(function() {
        $('#product-form').on('submit', function(e) {
            // Create an array to hold selected product IDs
            var selectedProducts = [];

            // Iterate over each checked checkbox and add its value to the array
            $('input[name="products[]"]:checked').each(function() {
                selectedProducts.push($(this).val());
            });

            // Set the value of the hidden input field to the selected product IDs
            $('#selected-products').val(selectedProducts.join(','));

            // Optionally, you can prevent the default form submission for testing
            // e.preventDefault();
        });
    });
</script>
@endpush
