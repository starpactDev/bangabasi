@extends('superuser.layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .is-rated {
        color: #ffc107;
        /* Star color (gold) */
        font-size: 18px;
        margin-left: 2px;
    }

    .badge {
        cursor: pointer;
    }

    .custom-dropdown {
        position: relative;
    }

    .custom-dropdown .dropdown-menu {
        width: 100%;
        /* Match the width of the dropdown button */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        /* Add a subtle shadow for depth */
        border-radius: 5px;
        /* Slightly round the corners */
        margin-top: 5px;
        /* Add a small margin between the button and the dropdown */
        padding: 0;
        /* Remove default padding */
        overflow: hidden;
        /* Ensure rounded corners are preserved */
    }

    .custom-dropdown .dropdown-menu .dropdown-item {
        padding: 10px 15px;
        /* Add padding for better spacing */
        border-bottom: 1px solid #eaeaea;
        /* Separate items with a light border */
        display: flex;
        align-items: center;
        white-space: nowrap;
    }

    .custom-dropdown .dropdown-menu .dropdown-item:last-child {
        border-bottom: none;
        /* Remove border from the last item */
    }

    .custom-dropdown .dropdown-menu .dropdown-item img {
        width: 40px;
        height: 40px;
        margin-right: 10px;
        /* Space between image and text */
        border-radius: 4px;
        /* Optional: round the corners of the image */
    }

    .custom-dropdown .dropdown-menu .dropdown-item:hover {
        background-color: #f8f9fa;
        /* Change background on hover */
    }
</style>


@section('content')
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper breadcrumb-wrapper-2 d-flex align-items-center justify-content-between">
                <h1>Review</h1>
                {{-- <p class="breadcrumbs"><span><a href="{{ route('admin_dashboard') }}">Home</a></span>
                <span><i class="mdi mdi-chevron-right"></i></span>Review
            </p> --}}
                <div>
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReviewModal">Add Review</a>
                </div>
            </div>
            <div class="modal fade" id="addReviewModal" tabindex="-1" aria-labelledby="addReviewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addReviewModalLabel">Add Review</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="reviewForm" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select" id="category" name="category">
                                        <option value="">Select Category</option>
                                        <!-- Categories will be populated here -->
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="subcategory" class="form-label">Sub Category</label>
                                    <select class="form-select" id="subcategory" name="subcategory" disabled>
                                        <option value="">Select Sub Category</option>
                                        <!-- Subcategories will be populated here -->
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="product" class="form-label">Product</label>
                                    <input type="hidden" id="product_id" name="product_id">
                                    <div class="custom-dropdown">
                                        <button class="btn btn-secondary dropdown-toggle w-100" type="button"
                                            id="productDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            Select Product
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="productDropdown" id="productDropdownMenu">
                                            <!-- Products will be dynamically populated here -->
                                        </ul>
                                    </div>
                                </div>
                                <div id="productPreview" class="mb-3"></div>
                                <div id="reviewFields"></div>
                                <!-- Additional form fields like review content, rating, etc. can go here -->
                                <button type="submit" class="btn btn-primary">Submit Review</button>
                            </form>
                        </div>
                    </div>
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
                                            <th>Customer Name</th>
                                            <th>Customer Email</th>
                                            <th>Reviews</th>
                                            <th>Ratings</th>
                                            <th>Images</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($reviews as $review)
                                            <tr>
                                            
                                                <td>
                                                    @if ($review->product && $review->product->productImages->isNotEmpty())
                                                        <img class="tbl-thumb"
                                                            src="{{ asset('user/uploads/products/images/' . $review->product->productImages->first()->image) }}"
                                                            alt="Product Image">
                                                    @else
                                                        <span>No Image Available</span>
                                                    @endif
                                                </td>
                                                <td  class="name-field">{{ $review->product->name }}</td>
                                                <td>{{ $review->name }}</td>
                                                <td>{{ $review->email }}</td>
                                                <td>{{ $review->review_message }}</td>

                                                <td>
                                                    <div class="ec-t-rate">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i
                                                                class="mdi mdi-star {{ $i <= $review->rating ? 'is-rated' : '' }}"></i>
                                                        @endfor
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($review->review_images)
                                                        @foreach ($review->review_images as $image)
                                                            <img class="tbl-thumb"
                                                                src="{{ asset('user/uploads/review_images/' . $image->image_path) }}"
                                                                alt="Review Image">
                                                        @endforeach
                                                    @endif
                                                </td>

                                                <td data-id="{{ $review->id }}">
                                                    @if ($review->status == 'active')
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>

                                                <td>{{ $review->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <div class="btn-group mb-1">
                                                        <button type="button" class="btn btn-outline-danger"
                                                            onclick="confirmDelete('{{ route('admin_review.delete', ['id' => $review->id]) }}')"
                                                            style="border-top-left-radius: 0; border-bottom-left-radius: 0;">Delete
                                                        </button>
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
    </div> <!-- End Content Wrapper -->
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Event listener for the status span
            $('.badge').on('click', function() {
                var $this = $(this);
                var reviewId = $this.closest('td').data(
                    'id'); // Assuming the review ID is stored in the row's data-id attribute

                var currentStatus = $this.text().trim();
                var newStatus = currentStatus === 'Active' ? 'inactive' : 'active';
                var statusText = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);

                // SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to change the status to " + statusText + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, make the AJAX request
                        $.ajax({
                            url: '{{ route('admin_review.status_update', ':id') }}'
                                .replace(
                                    ':id', reviewId),
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}', // Laravel CSRF token
                                status: newStatus
                            },
                            success: function(response) {
                                // Update the status badge on success
                                if (response.success) {
                                    $this.text(statusText)
                                        .removeClass('bg-success bg-danger')
                                        .addClass(newStatus === 'active' ?
                                            'bg-success' : 'bg-danger');
                                    Swal.fire(
                                        'Updated!',
                                        'The status has been updated.',
                                        'success'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error!',
                                    'There was an error updating the status.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script>
        function confirmDelete(deleteUrl) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this data!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, redirect to the delete URL
                    window.location.href = deleteUrl;
                }
            });
        }
        @if (session('success'))
            Swal.fire({
                title: 'Deleted!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
    <script>
        $(document).ready(function() {
            // Fetch categories on modal open
            $('#addReviewModal').on('show.bs.modal', function() {
                $.ajax({
                    url: '{{ route('categories.list') }}',
                    method: 'GET',
                    success: function(categories) {
                        $('#category').empty().append(
                            '<option value="">Select Category</option>');
                        $.each(categories, function(index, category) {
                            $('#category').append('<option value="' + category.id +
                                '">' + category.name + '</option>');
                        });
                    }
                });
            });

            // Fetch subcategories based on selected category
            $('#category').on('change', function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        url: '{{ route('subcategories.fetch', ':categoryId') }}'.replace(
                            ':categoryId', categoryId),
                        method: 'GET',
                        success: function(subcategories) {
                            $('#subcategory').empty().append(
                                '<option value="">Select Sub Category</option>').prop(
                                'disabled', false);
                            $.each(subcategories, function(index, subcategory) {
                                $('#subcategory').append('<option value="' + subcategory
                                    .id + '">' + subcategory.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#subcategory').empty().append('<option value="">Select Sub Category</option>').prop(
                        'disabled', true);
                    $('#product').empty().append('<option value="">Select Product</option>').prop(
                        'disabled', true);
                }
            });

            // Fetch products based on selected subcategory
            $('#subcategory').on('change', function() {
                var subcategoryId = $(this).val();
                if (subcategoryId) {
                    $.ajax({
                        url: '{{ route('products.list', ':subcategoryId') }}'.replace(
                            ':subcategoryId', subcategoryId),
                        method: 'GET',
                        success: function(products) {
                        
                            $('#productDropdownMenu').empty();
                            $.each(products, function(index, product) {
                                console.log('product : ', product)
                                var productItem = '<li>' +
                                    '<a class="dropdown-item d-flex align-items-center w-100" href="#" data-product-id="' +
                                    product.id + '">' +
                                    '<img src="' + product.image_url + '" alt="' +
                                    product.name +
                                    '" class="img-thumbnail me-2" style="width: 60px; height: 60px;">' +
                                    '<span class="flex-grow-1">' + product.name +
                                    '</span>' +
                                    '</a>' +
                                    '</li>';
                                $('#productDropdownMenu').append(productItem);
                                
                            });

                            // Handle product selection
                            $('#productDropdownMenu a').on('click', function(e) {
                                e.preventDefault();
                                var selectedProduct = $(this).text();
                                $('#productDropdown').text(selectedProduct);
                                $('#productDropdown').attr('data-selected-product-id',
                                    $(this).data('product-id'));
                            });
                        }
                    });
                } else {
                    $('#productDropdownMenu').empty();
                    $('#productDropdown').text('Select Product');
                }
            });
        });
    </script>
    <script>
        $('#productDropdownMenu').on('click', 'a.dropdown-item', function() {
            var selectedProductId = $(this).data('product-id');
            var selectedProductName = $(this).text();
            $('#productDropdown').text(selectedProductName);
            // Store the product ID in a hidden input field
            $('#product_id').val(selectedProductId);

            // Clear any existing review fields
            $('#reviewFields').empty();

            // Append review fields dynamically
            var reviewFields = `
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <div id="ratingOptions">
                                    ${generateRatingOptions()}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="review_message" class="form-label">Review Message</label>
                                <textarea class="form-control" id="review_message" name="review_message" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label">Upload Images</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                            </div>
                                `;
            $('#reviewFields').append(reviewFields);
        });

        function generateRatingOptions() {
            let ratingOptions = '';
            for (let i = 1; i <= 5; i++) {
                ratingOptions += `
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rating" id="rating${i}" value="${i}">
                        <label class="form-check-label" for="rating${i}">
                            ${i} ${generateStars(i)}
                        </label>
                    </div>
                `;
            }
            return ratingOptions;
        }

        function generateStars(count) {
            let stars = '';
            for (let i = 0; i < count; i++) {
                stars += '<i class="mdi mdi-star is-rated"></i>';
            }
            return stars;
        }
    </script>
    <script>
        var productDetailsUrl = "{{ route('product.show', ['id' => '__ID__']) }}";
    </script>
    <script>
        // Function to handle the product dropdown item click
        $('#productDropdownMenu').on('click', 'a.dropdown-item', function() {
            var selectedProductId = $(this).data('product-id');

            // Construct the URL with the selected product ID
            var url = productDetailsUrl.replace('__ID__', selectedProductId);

            // Fetch product details
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    if (response.error) {
                        console.error('Error:', response.error);
                        return;
                    }

                    var product = response.product;

                    // Ensure product.productImages is defined and is an array
                    var images = Array.isArray(product.productImages) ? product.productImages : [];

                    // Build the product preview HTML
                    var productPreviewHtml = `
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Sub-Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        ${images.length > 0 ?
                                            '<img class="tbl-thumb" src="' + images[0].image_url + '" alt="Product Image">' :
                                            'No Image'}
                                    </td>
                                    <td>${product.name}</td>
                                    <td>${product.category}</td>
                                    <td>${product.sub_category}</td>
                                </tr>
                            </tbody>
                        </table>
                    `;

                    // Add the product preview HTML to the modal
                    $('#productPreview').html(productPreviewHtml);

                    // Update the product dropdown button text
                    $('#productDropdown').text(product.name);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching product details:', error);
                }
            });
        });



        // Handle form submission
        $('#reviewForm').on('submit', function(e) {
            e.preventDefault();

            // Clear previous errors
            $('.text-danger').empty();
            // Set CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData(this);
            $.ajax({
                url: '{{ route('reviews.store') }}', // Update this route to your actual route
                method: 'POST',
                data: formData,
                processData: false, 
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Review submitted successfully.',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        $('#addReviewModal').modal('hide');
                        $('#reviewForm')[0].reset();
                        $('#productDropdown').text('Select Product');
                        $('#productPreview').empty();
                        $('#reviewFields').empty();
                        location.reload(); // Reload the current page
                    });
                },
                error: function(xhr) {
                    // Handle validation errors
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key + 'Error').text(value[0]);
                    });
                }
            });
        });
    </script>
@endpush
