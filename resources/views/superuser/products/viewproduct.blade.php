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
                <h1>Product</h1>
                <p class="breadcrumbs"><span><a href="{{ Auth::user()->usertype == 'admin' ? route('admin_dashboard') : route('seller_dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Product
                </p>
            </div>
            <div>
                <a href="{{ route('superuser_addproduct') }}" class="btn btn-primary"> Add Porduct</a>
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
                                        
                                        <th>Price &#8377;</th>

                                        <th>Purchased</th>
                                        <th>Size & Stock</th>
                                        <th>Colour</th>
                                        <th>Status</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($products as $product)
                                    <tr >
                                        <td>
                                            @if ($product->productImages->isNotEmpty())
                                            <img class="tbl-thumb"
                                                src="{{ asset('user/uploads/products/images/' . $product->productImages->first()->image) }}"
                                                alt="Product Image">
                                            @endif
                                        </td>
                                        <td>{{ $product->name ?? '' }}</td>
                                        <td>{{ $product->categoryDetails->name ?? ''}} <small class="text-truncate d-inline-block" style="width: 15ch; color:gray" title="{{ $product->subCategoryDetails->name ?? '' }}">{{ $product->subCategoryDetails->name ?? '' }}</small></td>
                                        
                                        <td >
                                            <small style="display:block; color:rgb(219, 9, 9); text-decoration: line-through;">{{ $product->original_price ?? '' }}</small>
                                            <span style="display:block; color:rgb(7, 82, 29); font-weight:600">{{ $product->offer_price ?? '' }}</span>
                                        </td>



                                        <td><span class="badge bg-info fw-bold" style="font-size: 18px">0</span>
                                        </td>
                                        <td>
                                            @foreach ($product->productSizes as $size)
                                            <span
                                                style="color: rgb(21, 21, 105); font-weight:600;margin-bottom:8px">{{ $size->size }}</span>
                                            ( <b>{{ $size->quantity }}</b> )<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($product->productColours as $color)
                                            <div
                                                style="margin-bottom:10px;width: 30px; height: 30px; background-color: {{ $color->colour_name }}; border: 1px solid #000; display: inline-block; margin-right: 5px;">
                                            </div>
                                            @endforeach
                                        </td>


                                        @if ($product->is_active == 1)
                                        <td data-id="{{ $product->id }}">
                                            <span class="badge bg-success status-badge">Active</span>
                                        </td>
                                        @else
                                        <td data-id="{{ $product->id }}">
                                            <span class="badge bg-danger status-badge">Inactive</span>
                                        </td>
                                        @endif


                                        <td>
                                            <div class="btn-group mb-1">
                                                <a href="{{ route('admin_products.info', $product->id) }}" class="btn btn-outline-success">Info</a>
                                                <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                                    <span class="sr-only">Info</span>
                                                </button>

                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item " href="{{ route('admin_products.edit', $product->id) }}">Edit</a>
                                                    <form id="deleteProductForm{{ $product->id }}" action="{{ route('admin_products.delete', $product->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" id="deleteConfirmation{{ $product->id }}" name="deleteConfirmation" value="">
                                                        <button type="button" class="dropdown-item deleteButton" data-form-id="{{ $product->id }}">Delete</button>
                                                    </form>

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
</div> <!-- End Content Wrapper -->
@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Event listener for the status badge
        $(document).on('click', '.status-badge', function() {
           
            var $this = $(this);
            var productId = $this.closest('td').data('id');

            if (!productId) {
                alert('Product ID not found');
                return;
            }

            var currentStatus = $this.text().trim();
            var newStatus;
            var statusText;
            var newClass;

            if (currentStatus === 'Active') {
                newStatus = 0; // Set to 'Inactive'
                statusText = 'Inactive';
                newClass = 'bg-danger'; // Class for Inactive
            } else {
                newStatus = 1; // Set to 'Active'
                statusText = 'Active';
                newClass = 'bg-success'; // Class for Active
            }

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
                    // Make the AJAX request to update the status
                    $.ajax({
                        url: '{{ route("admin_product.status_update", ":id") }}'.replace(':id', productId),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // Laravel CSRF token
                            status: newStatus
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update the status badge text and color
                                $this.text(statusText)
                                    .removeClass('bg-success bg-danger') // Remove existing classes
                                    .addClass(newClass); // Add the new class

                                Swal.fire(
                                    'Updated!',
                                    'The product status has been updated.',
                                    'success'
                                );
                            } else {
                               
                                Swal.fire(
                                    'Error!',
                                    response.message || 'An unknown error occurred.',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseJSON.message);
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON.message ||'There was an error updating the status.',
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
    document.querySelectorAll('.deleteButton').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formId = this.getAttribute('data-form-id');
            const form = document.getElementById(`deleteProductForm${formId}`);
            const confirmationField = document.getElementById(`deleteConfirmation${formId}`);

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set a custom parameter before submitting
                    confirmationField.value = 'confirmed';
                    form.submit();
                }
            });
        });
    });

    @if(session('success'))
    Swal.fire({
        title: 'Deleted!',
        text: '{{ session('
        success ') }}',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    @endif
</script>
@endpush