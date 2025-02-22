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
                <h1>Manage Topbar</h1>
                <p class="breadcrumbs">
                    <span><a href="{{ route('admin_dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Manage Category Images
                </p>
            </div>
            <div class="row">

                <div class="col-xl-6 col-lg-6">
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
                                <table id="" class="table">
                                    <thead>
                                        <tr>
                                            <th>Sale Banner</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody style="vertical-align: middle;">
                                        @foreach ($topbars as $topbar)
                                            @if($topbar->layout_type == 'layout2')
                                                <tr>
                                                    <td>
                                                        <img src="{{ asset('user/uploads/banner/' . $topbar->section_1_image) }}" style="width:15rem"/>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary edit-topbar" data-id="{{ $topbar->id }}" data-column="section_1_image" data-type="image">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <img src="{{ asset('user/uploads/banner/' . $topbar->section_2_image) }}"  style="width:15rem"/>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary edit-topbar" data-id="{{ $topbar->id }}" data-column="section_2_image" data-type="image">Edit</button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
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
                                <table id="" class="table">
                                    <thead>
                                        <tr>
                                            <th>Small Banner</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody style="vertical-align: middle;">
                                        @foreach ($topbars as $topbar)
                                            @if($topbar->layout_type == 'layout1')
                                                <tr>
                                                    <td>
                                                        <img src="{{ asset('user/uploads/banner/' . $topbar->banner_image) }}" style="width:10rem"/>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary edit-topbar" data-id="{{ $topbar->id }}" data-column="banner_image" data-type="image">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>{{ $topbar->overlay_text_heading }}</p>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary edit-topbar" data-id="{{ $topbar->id }}" data-column="overlay_text_heading" data-type="text">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>{{ $topbar->overlay_text_body }}</p>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary edit-topbar" data-id="{{ $topbar->id }}" data-column="overlay_text_body" data-type="text"> Edit</button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 my-4">
                    <div class="ec-cat-list card card-default">
                        <h5 class="my-4 mx-4">Category</h5>
                        <div class="row mb-4 px-4">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @foreach ($topbars as $topbar)
                                @if($topbar->layout_type == 'layout1')
                                        @php    
                                            $key = 1;
                                        @endphp
                                    @foreach ($categories as $category)
                                        
                                        <div class="col-lg-3 col-md-6">
                                            <div class="card card-default">
                                                <div class="card-body text-center p-24px">
                                                    <img src="{{ asset('user/uploads/category/image/' . $category->images) }}" alt="">
                                                    <h6 class="" style="margin-top: 0.5rem; margin-bottom: 0.5rem">{{ $category->name }}</h6>
                                                    <span class="brand-edit mdi mdi-pencil-outline edit-topbar" style="cursor: pointer; border: 1px solid #ccc; border-radius: 4px; background-color: #e4ce0c; display: block; padding: 10px; width: fit-content; margin: 0.5rem auto;" data-bs-toggle="modal"  data-id="3" data-column="category_{{ $key }}_id" data-type="category" onclick="">Edit</span>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $key++;
                                        @endphp
                                    @endforeach
                                @endif
                            @endforeach   
                        </div>
                    </div>
                </div>

                <div class="col-xl-7 col-lg-7">
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
                                <table id="" class="table">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody style="vertical-align: middle;">
                                        @foreach ($topbars as $topbar)
                                            @if($topbar->layout_type == 'layout1')
                                                
                                                <tr>
                                                    <td>
                                                        <p>{{ $topbar->description_head }}</p>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary edit-topbar" data-id="{{ $topbar->id }}" data-column="description_head" data-type="text">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>{{ $topbar->description_text }}</p>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary edit-topbar" data-id="{{ $topbar->id }}" data-column="description_text" data-type="text">Edit</button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="ec-cat-list card card-default">
                        <div class="card-body">
                            @if (session('successDiscount'))
                                <div class="alert alert-success">
                                    {{ session('successDiscount') }}
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <h6 class="my-2">Currently Discounts Above: <span class="">{{ intval($saleDiscount->discount) }}</span>%</h6>
                            <form action="{{ route('admin_discount.update')}}" method="POST">
                                @csrf
                                <label for="customRange2" class="form-label">Discount Threshold</label>
                                <div class="my-4" style="display: flex; align-items: center; gap: 0.5rem;">
                                    <input type="hidden" name="id" value="{{$saleDiscount->id}}">
                                    <span id="minValue" style="min-width: 1.5rem;">0</span>
                                    <input type="range" class="form-range" min="0" max="100" value="{{ intval($saleDiscount->discount) }}" id="customRange2" oninput="updateRangeValue(this.value)" name="discount">
                                    <span id="maxValue" style="min-width: 2rem;">100</span>
                                </div>
                                <div class="mt-2">Threshold Set To: <span id="currentValue">{{ intval($saleDiscount->discount) }}</span>%</div>
                                <div class="text-right">
                                    <button class="btn btn-success">Apply</button>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="saleBannerModal" tabindex="-1" role="dialog" aria-labelledby="saleBannerModalLabel" aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="manageCategoryImagesModalLabel">Manage Category Images</h5>
                            <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editFieldForm" enctype="multipart/form-data" method="POST">
                                <div class="modal-body" id="formBody">
                                    <input type="hidden" id="fieldId" name="field_id">
                                    <input type="hidden" id="fieldColumn" name="field_column">
                                    
                                    <!-- will be populated by ajax -->
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
			<!-- Edit Image Modal -->
			

        </div> 
        <!-- End Content -->
    </div>
@endsection

@push('script')
<script id="rangeSlider">
    function updateRangeValue(value) {
        document.getElementById("currentValue").innerText = value;
    }
</script>

<script id="fetchCategories">
    let allCategories;

    //fetch the category list when the page will be loaded
    document.addEventListener("DOMContentLoaded", () => {
    fetch("{{ route('categories.list') }}") // Replace with your actual route
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); // Assuming the response is in JSON format
        })
        .then(data => {
            allCategories = data; // Save the fetched data to the array
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    });

    function appendCategories() {
        const categoryInput = document.getElementById('categoryInput')
        
        let options;
        categoryInput.innerHTML = '';

        allCategories.forEach(element => {
            options += `<option value="${element.id}">${element.name}</option>`
        });

        categoryInput.innerHTML = options;
    }


</script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Handle the click event for the "Manage" button
        $('.edit-topbar').on('click', function() {
            const fieldDiv = $('#fieldDiv')

            if(fieldDiv){
                fieldDiv.remove()
            }
            
            $('#saleBannerModal').modal('show');

            const type = $(this).data('type');
            const fieldId = $(this).data('id');
            const column = $(this).data('column');

            //  console.log(type, fieldId, column);

            $('#fieldId').val(fieldId);
            $('#fieldColumn').val(column);

            if(type == 'image'){
                $('#formBody').append('<div class="form-group" id="fieldDiv"><label for="imageInput">Select New Image</label><input type="file" id="imageInput" name="image" class="form-control"></div>');
            }
            else if(type == 'text'){
                $('#formBody').append('<div class="form-group" id="fieldDiv"> <label for="textInput">Enter New Text</label><input type="text" id="textInput" name="text" class="form-control"></div>')
            }
            else if(type == 'category'){
                $('#formBody').append('<div class="form-group" id="fieldDiv"> <label for="textInput">Select New Category</label><select id="categoryInput" name="category" class="form-control"><option value="">Select Category</option></select></div>')
                appendCategories();
            }
        });

        
        // Handle form submission for updating image
        $('#editFieldForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const column = $('#editFieldColumn').val(); // Get the column name
            let value;

            if ($('#imageInput').length > 0) { // Check if #imageInput exists
                value = $('#imageInput')[0].files[0]; // Access the first file if it exists
            } 

            if (value) {
                formData.append(column, value);
                console.log(value); // If it's an image, append it
            }

            $.ajax({
                url: "{{ route('admin_sale.update') }}",
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
                        $('#saleBannerModal').modal('hide');
                        location.reload();
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
        $(document).on('click', '#saleBannerModal .close-btn', function() {
            $('#saleBannerModal').modal('hide');
        });

        // Handle the close button for the edit image modal
        $(document).on('click', '#editImageModal .close-btn', function() {
            $('#editImageModal').modal('hide');
            $('#manageCategoryImagesModal .modal-content').removeClass('dim-content');
        });
    });
</script>

@endpush
