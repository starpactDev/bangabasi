@extends('superuser.layouts.master')

@section('head')
    <!-- Data Tables -->
    <link href='admin/assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
    <link href='admin/assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>
@endsection

@section('content')
    <style>
      .dim-content {
    opacity: 0.5; /* Adjust this value for the desired dimming effect */
    pointer-events: none; /* Prevent interaction with the background modal */
}
        #categoryImageTitles li {
            margin-bottom: 10px;
            /* Adjust the space between list items */
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper breadcrumb-wrapper-2 breadcrumb-contacts">
                <h1>Manage Category Images for a Dynamic Header Dropdown</h1>
                <p class="breadcrumbs">
                    <span><a href="{{ route('admin_dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Manage Category Images
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
                                            <th>Manage Header Banner Images</th>

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
                                                    <button type="button"
                                                        class="btn btn-outline-success manage-category-images"
                                                        data-id="{{ $category->id }}"
                                                        style="border-radius: 0 15px 0 15px !important;">
                                                        Click To Manage
                                                    </button>
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
            <!-- Manage Category Images Modal -->
            <!-- Modal -->
            <div class="modal fade" id="manageCategoryImagesModal" tabindex="-1" role="dialog"
                aria-labelledby="manageCategoryImagesModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="manageCategoryImagesModalLabel">Manage Category Images</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table id="categoryImagesTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Images</th>
                                        <th>Sub-Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Content will be dynamically loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
<!-- Edit Image Modal -->
<div class="modal fade" id="editImageModal" tabindex="-1" role="dialog" aria-labelledby="editImageModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editImageModalLabel">Edit Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editImageForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="editImageId" name="image_id">
                    <div class="form-group">
                        <label for="subCategoryDropdown">Select Sub-Category</label>
                        <select id="subCategoryDropdown" name="sub_category_id" class="form-control" required>
                            <!-- Sub-categories will be loaded here -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="imageInput">Select New Image</label>
                        <input type="file" id="imageInput" name="image" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

            <!-- Edit Category Image Modal -->



        </div> <!-- End Content -->
    </div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Handle the click event for the "Manage" button
        $('.manage-category-images').on('click', function() {
            var categoryId = $(this).data('id'); // Get category ID from button
            var tableBody = $('#categoryImagesTable tbody'); // Table body where data will be loaded

            tableBody.empty(); // Clear previous content

            // Fetch the route with category ID dynamically
            var url = "{{ route('category.images', ':id') }}";
            url = url.replace(':id', categoryId);

            // Make an AJAX request to fetch the category images
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    if (data.length > 0) {
                        // Loop through the data and append rows to the table
                        $.each(data, function(index, item) {
                            var rowHtml = '<tr data-id="' + item.id + '">' +
                                '<td><img src="' + item.image_url +
                                '" alt="Image" style="width: 100px; height: auto;"></td>' +
                                '<td>' + item.sub_category_name + '</td>' +
                                '<td><button type="button" class="btn btn-primary edit-subcategory" data-id="' +
                                item.id + '">Edit</button></td>' +
                                '</tr>';
                            tableBody.append(rowHtml);
                        });
                    } else {
                        tableBody.append(
                            '<tr><td colspan="3">No images found for this category.</td></tr>'
                        );
                    }

                    // After successfully fetching data, show the modal
                    $('#manageCategoryImagesModal').modal('show');
                },
                error: function() {
                    tableBody.append(
                        '<tr><td colspan="3">Error fetching images. Please try again later.</td></tr>'
                    );
                    // Show modal even in case of error
                    $('#manageCategoryImagesModal').modal('show');
                }
            });
        });

        // Handle edit button click event
        $(document).on('click', '.edit-subcategory', function() {
            var imageId = $(this).data('id');

            // Fetch image details
            $.ajax({
                url: "{{ route('image.details', ':id') }}".replace(':id', imageId),
                method: 'GET',
                success: function(data) {
                    if (data) {
                        var imageId = data.id;
                        var categoryId = data.category_id;

                        // Fetch sub-categories for the category
                        $.ajax({
                            url: "{{ route('subcategories.byCategory', ':categoryId') }}".replace(':categoryId', categoryId),
                            method: 'GET',
                            success: function(subCategories) {
                                var subCategoryDropdown = $('#subCategoryDropdown');
                                subCategoryDropdown.empty();

                                $.each(subCategories, function(index, subCategory) {
                                    subCategoryDropdown.append(
                                        '<option value="' + subCategory.id + '">' + subCategory.name + '</option>'
                                    );
                                });

                                // Populate the modal form with image ID and other details
                                $('#editImageId').val(imageId);
                                $('#subCategoryDropdown').val(data.sub_category_id);

                                // Show the edit modal
                                $('#editImageModal').modal('show');
                                $('#manageCategoryImagesModal .modal-content').addClass('dim-content');

                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to fetch image details.',
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch image details.',
                    });
                }
            });
        });

        // Handle form submission for updating image
        $('#editImageForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('image.update') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    }).then(function() {
                        // Hide the edit modal
                        $('#editImageModal').modal('hide');
                        $('#manageCategoryImagesModal .modal-content').removeClass('dim-content');

                        // Update the specific row in the manageCategoryImagesModal
                        var updatedRow = $('tr[data-id="' + response.image.id + '"]');
                        updatedRow.find('td:first img').attr('src', response.image.image_url);
                        updatedRow.find('td:nth-child(2)').text(response.image.sub_category_name);
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update image. Please try again.',
                    });
                }
            });
        });

        // Handle the close button separately
        // Handle the close button for the manage images modal
        $(document).on('click', '#manageCategoryImagesModal .close', function() {
            $('#manageCategoryImagesModal').modal('hide');
        });

        // Handle the close button for the edit image modal
        $(document).on('click', '#editImageModal .close', function() {
            $('#editImageModal').modal('hide');
            $('#manageCategoryImagesModal .modal-content').removeClass('dim-content');
        });
    });
</script>


@endpush
