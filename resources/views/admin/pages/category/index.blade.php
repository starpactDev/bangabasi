@extends('superuser.layouts.master')

@section('head')
    <!-- Data Tables -->
    <link href='admin/assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
    <link href='admin/assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>
@endsection

@section('content')
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper breadcrumb-wrapper-2 breadcrumb-contacts">
                <h1>Manage Category</h1>
                <p class="breadcrumbs">
                    <span><a href="{{ route('admin_dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Manage Category
                </p>
            </div>
            <div class="row">

                <div class="col-xl-12 col-lg-12">
                    <div class="ec-cat-list card card-default">
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table id="responsive-data-table" class="table">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Sub Categories</th>
                                            <th>Product</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td>
                                                    @if ($category->images != null)
                                                        <img class="cat-thumb"
                                                            src=" {{ asset('user/uploads/category/image/' . $category->images) }}"
                                                            alt="Product Image" />
                                                    @else
                                                        <img class="cat-thumb" src="admin/assets/img/products/50.jpg"
                                                            alt="Product Image" />
                                                    @endif
                                                </td>
                                                <td>{{ $category->name }}</td>
                                                <td>
                                                    <span class="ec-sub-cat-list">
                                                        <span class="ec-sub-cat-count"
                                                            title="Total Sub Categories">{{ $category->subcategories->count() }}</span>
                                                        @foreach ($category->subcategories as $subcategory)
                                                            <span class="ec-sub-cat-tag">{{ $subcategory->name }}</span>
                                                        @endforeach

                                                    </span>
                                                </td>
                                                <td>{{ $category->product_count }}</td>
                                                {{-- @if ($category->status == 'active')
                                                    <td><span class="badge bg-success">Active</span></td>
                                                @else
                                                    <td><span class="badge bg-danger">InActive</span></td>
                                                @endif --}}


                                                <td>
                                                    <div class="btn-group mb-1">
                                                        <button type="button" class="btn btn-outline-success edit-category"
                                                            data-id="{{ $category->id }}"
                                                            style="border-radius: 0 15px 0 15px !important;">Edit</button>
                                                        <button type="button" class="btn btn-outline-danger"
                                                            onclick="confirmDelete('{{ route('admin_category.delete', ['id' => $category->id]) }}')"
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
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm">
                        @csrf
                        <input type="hidden" name="id" id="editCategoryId">

                        <div class="form-group row">
                            <label for="editName" class="col-12 col-form-label">Name</label>
                            <div class="col-12">
                                <input id="editName" name="name" class="form-control here" type="text">
                            </div>
                        </div>


                        <div class="ec-vendor-uploads">
                            <div class="ec-vendor-img-upload mb-5">
                                <h6 class="mb-2">Add Image</h6>
                                <div class="ec-vendor-main-img">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type="file" name="image" id="editImageUpload"
                                                class="ec-image-upload" accept=".png, .jpg, .jpeg">
                                            <label for="editImageUpload"><img src="admin/assets/img/icons/edit.svg"
                                                    class="svg_img header_svg" alt="edit"></label>
                                        </div>
                                        <div class="avatar-preview ec-preview">
                                            <div class="imagePreview ec-div-preview">

                                                <img class="ec-image-preview" name="image"
                                                    src="admin/assets/img/products/50.jpg" alt="edit"
                                                    id="editImagePreview">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="editSubCategory" class="col-12 col-form-label">Add Sub Category</label>
                            <div class="col-12" id="subCategoryContainer">
                                <!-- Subcategories will be appended here -->
                                <div class="input-group mb-2">
                                    <input id="editSubCategory" name="sub_category[]" class="form-control here"
                                        type="text">
                                    <button type="button" class="btn btn-outline-secondary add-sub-category">+ Add
                                        More</button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
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
        $(document).ready(function() {
            $('.delete-product-btn').on('click', function(e) {
                e.preventDefault();

                let form = $(this).closest('.delete-product-form');
                let productId = form.data('id');
                let url = form.attr('action');


                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'GET',

                            data: form.serialize(),
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'Category has been deleted.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Optionally, remove the deleted product from the UI or reload the page
                                            location.reload();
                                        }
                                    });
                                }
                            },
                            error: function(xhr) {
                                if (xhr.status === 404) {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Product not found.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'An error occurred while deleting the product. Please try again.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Handle adding new subcategory input
            // Function to add a new subcategory input
            function addSubCategoryInput(value = '') {
                const subCategoryInput = `
            <div class="input-group mb-2">
                <input name="sub_category[]" class="form-control here" type="text" value="${value}">
                <button type="button" class="btn btn-outline-secondary remove-sub-category">-</button>
            </div>`;
                $('#subCategoryContainer').append(subCategoryInput);
            }

            // Add new subcategory input when clicking the add button
            $(document).on('click', '.add-sub-category', function() {
                addSubCategoryInput();
            });

            // Remove subcategory input when clicking the remove button
            $(document).on('click', '.remove-sub-category', function() {
                $(this).closest('.input-group').remove();
            });
            $('.edit-category').on('click', function() {
                const categoryId = $(this).data('id');

                // Fetch the category data using AJAX
                $.ajax({
                    url: `{{ route('admin_category.show', ':id') }}`.replace(':id', categoryId),
                    method: 'GET',
                    success: function(response) {
                        // Populate the form with the category data
                        $('#editCategoryId').val(response.category.id);
                        $('#editName').val(response.category.name);
                        $('#editStatus').val(response.category.status);


                        // Clear existing subcategory inputs
                        $('#subCategoryContainer').html('');

                        // Add existing subcategories, if any
                        response.subcategories.forEach(function(subCategory) {
                            addSubCategoryInput(subCategory.name);
                        });

                        // If no subcategories exist, add one empty input
                        if (response.subcategories.length === 0) {
                            addSubCategoryInput();
                            const addMoreButton = `
        <div class="input-group mb-2">
            <button type="button" class="btn btn-outline-secondary add-sub-category">+ Add More</button>
        </div>`;
                            $('#subCategoryContainer').append(addMoreButton);
                        } else {
                            // Add only "Add More" button if subcategories exist
                            const addMoreButton = `
        <div class="input-group mb-2">
            <button type="button" class="btn btn-outline-secondary add-sub-category">+ Add More</button>
        </div>`;
                            $('#subCategoryContainer').append(addMoreButton);
                        }








                        // Show the modal
                        $('#editCategoryModal').modal('show');
                    },
                    error: function() {
                        alert('Failed to fetch category data');
                    }
                });
            });

            // Handle the form submission
            $('#editCategoryForm').on('submit', function(event) {
                event.preventDefault();
                const id = $('#editCategoryId').val();
                var url = "{{ route('admin_category.update', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                const formData = new FormData(this);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // If there are deleted subcategories, display them first
                            if (response.deletedSubCategories.length > 0) {
                                const deletedSubCategoriesList = response.deletedSubCategories
                                    .join(', ');
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Deleted Subcategories',
                                    text: `The following subcategories have been deleted: ${deletedSubCategoriesList}. They contained ${response.productCount} products.`,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    // Show success message after displaying deleted subcategories
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Category Updated',
                                        text: 'Category updated successfully'
                                    }).then(() => {
                                        location.reload();
                                    });
                                });
                            } else {
                                // If no subcategories were deleted, just show success message
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Category Updated',
                                    text: 'Category updated successfully'
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed to Update',
                                text: 'Failed to update category'
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Handle validation errors (422 status code)
                            var errorMessage = xhr.responseJSON.message ||
                                'Validation error occurred.';
                            if (errorMessage.includes(
                                'Image dimensions must be 50x50 pixels')) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error',
                                    text: 'Image dimensions must be 50x50 pixels'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error',
                                    text: errorMessage
                                });
                            }
                        } else if (xhr.status === 500) {
                            // Handle server error (500 status code)
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error',
                                text: 'Failed to update category: Internal Server Error'
                            });
                        } else {
                            // Handle other errors
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update category'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
