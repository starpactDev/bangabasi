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
                    <h1>Collections</h1>
                    <p class="breadcrumbs"><span><a href="{{ route('admin_dashboard') }}">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span> Collections
                    </p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modal-add-member">Add Collections
                    </button>
                </div>
            </div>

            <div class="product-brand card card-default p-24px">
                <div class="row mb-m-24px">
                    @foreach ($collections as $collection)
                        <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6">
                            <div class="card card-default">
                                <div class="card-body text-center p-24px">


                                    <h5 class="card-title text-dark">{{ $collection->collection_name }}</h5>

                                    <span class="brand-edit mdi mdi-pencil-outline"
                                    style="cursor: pointer; margin-top:12px; border: 1px solid #ccc; border-radius: 4px; background-color: #e4ce0c; display: inline-flex; align-items: center; padding:10px;"
                                    data-bs-toggle="modal" data-bs-target="#editModal-{{ $collection->id }}"
                                    onclick="editBrand({{ $collection->id }}, '{{ $collection->collection_name }}', '{{ route('admin.collections.update', $collection->id) }}')">
                                  Edit
                              </span>
                              <span class="brand-delete mdi mdi-delete-outline" style="cursor: pointer;" onclick="confirmDelete({{ $collection->id }})"></span>

                                </div>
                            </div>
                        </div>

                          <!-- Edit Modal -->
                        <div class="modal fade" id="editModal-{{ $collection->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Collection</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form to edit brand name and image -->
                                        <form id="edit-brand-form-{{ $collection->id }}" enctype="multipart/form-data">
                                            <div class="form-group mb-3">
                                                <label for="edit-brand-name" class="form-label">Collection Name</label>
                                                <input type="text" class="form-control" id="edit-brand-name-{{ $collection->id }}" name="collection_name" required>
                                            </div>


                                        </form>
                                    </div>
                                    <div class="modal-footer px-4">
                                        <button type="button" class="btn btn-secondary btn-pill" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary btn-pill" onclick="updateBrand({{ $collection->id }})">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>



            <!-- Add Collecion Button  -->
            <div class="modal fade" id="modal-add-member" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Collecion</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form to upload brand name and image -->
                            <form id="add-member-form" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <label for="brand-name" class="form-label">Collection Name</label>
                                    <input type="text" class="form-control" id="brand-name" name="collection_name" required>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer px-4">
                            <button type="button" class="btn btn-secondary btn-pill"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary btn-pill" onclick="submitForm()">Add</button>
                        </div>
                    </div>
                </div>
            </div>


        </div> <!-- End Content -->
    </div> <!-- End Content Wrapper -->
@endsection

@push('script')
<script>
    function confirmDelete(id) {
    swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteBrand(id);
        }
    });
}

function deleteBrand(id) {
    $.ajax({
        url: "{{ route('admin.collections.destroy', '') }}/" + id, // Assuming the route name is brand.destroy
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if(response.status === 'success') {
                swal.fire(
                    'Deleted!',
                    response.message,
                    'success'
                ).then(() => {
                    location.reload(); // Reload the page or update the UI
                });
            }
        },
        error: function(xhr) {
            swal.fire(
                'Error!',
                'An error occurred while trying to delete the brand.',
                'error'
            );
        }
    });
}

  function editBrand(id, brandName,  routeUrl) {
    // Store the route URL in a data attribute for later use
    $('#edit-brand-form-' + id).data('route', routeUrl);

    // Populate the modal with existing data
    $('#edit-brand-name-' + id).val(brandName);


}

function updateBrand(id) {
    let formData = new FormData(document.getElementById('edit-brand-form-' + id));
    let routeUrl = $('#edit-brand-form-' + id).data('route'); // Retrieve the route URL

    $.ajax({
        url: routeUrl, // Use the route name-based URL
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-HTTP-Method-Override': 'PUT' // Laravel expects a PUT request for updates
        },
        success: function(response) {
            if(response.status === 'success') {
                Swal.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success",
                    button: "OK",
                }).then(() => {
                    $('#editModal-' + id).modal('hide');
                    location.reload(); // Or update the UI as needed
                });
            }
        },
        error: function(xhr) {
            let errors = xhr.responseJSON.errors;

            // Show validation errors in the modal
            $('.text-danger').remove();
            if(errors.brand_name) {
                $('#edit-brand-name-' + id).after('<span class="text-danger">'+errors.collection_name[0]+'</span>');
            }


            Swal.fire({
                title: "Error!",
                text: "Please correct the errors and try again.",
                icon: "error",
                button: "OK",
            });
        }
    });
}


</script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function submitForm() {
            let formData = new FormData(document.getElementById('add-member-form'));

            $.ajax({
                url: "{{ route('admin.collections.store') }}", // Route name
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,

                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() => {
                            $('#modal-add-member').modal('hide');
                            location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;

                    // Clear previous error messages
                    $('.text-danger').remove();

                    // Show validation errors
                    if (errors.collection_name) {
                        $('#brand-name').after('<span class="text-danger">' + errors.collection_name[0] + '</span>');
                    }


                    Swal.fire({
                        title: "Error!",
                        text: "Please correct the errors and try again.",
                        icon: "error",
                        button: "OK",
                    });
                }
            });
        }
    </script>
@endpush
