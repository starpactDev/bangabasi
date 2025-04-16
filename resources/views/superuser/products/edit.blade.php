@extends('superuser.layouts.master')



@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }
        .custom-table, .custom-table th, .custom-table td, .custom-table tr {
            border: 2px solid lightblue; /* Light blue border for table, rows, and cells */
        }
        .custom-table th, .custom-table td {
            text-align: center; /* Center alignment */
            padding: 10px;
        }
        .custom-table th {
            background-color: #f0f8ff; /* Light background for header */
        }
        .custom-table td {
            vertical-align: top; /* Vertically center text */
        }
        .form-check-2 {
            display: block; /* Stack each div vertically */
            margin-bottom: 10px; /* Space between each checkbox */
            padding: 8px 8px; /* Padding around checkbox and label */
            background-color: #f9f9f9; /* Light background */
            border: 1px solid #007bff; /* Button border color */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer;
            font-size: 14px;
        }
    </style>

    <style>
        .btn-lg {
            font-size: 1.25rem;
            padding: .75rem 2.25rem;
            border-radius: .3rem;
            background-color: #33317d !important;
        }

        .text-danger {
            color: red !important;
        }
        /* Loader Overlay covering the entire page */
        #loaderOverlay {
            display: none;
            /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Darkish overlay */
            z-index: 9999;
            /* Ensure it's above all content */
        }

        .avatar-edit .thumb-delete {


            /* Adjust this value to align the delete icon correctly */
            cursor: pointer;
            width: 40px;
            /* Adjust icon size if needed */
            height: 40px;
            /* Box styling */
            background-color: #ffffff;
            /* Light background color */
            border: 1px solid #ccc;
            /* Border */
            border-radius: 5px;
            /* Optional: rounded corners */
            padding: 5px;
            /* Space around the icon */
            box-shadow: 0px 2px 5px rgba(245, 241, 241, 0.747);
            /* Optional: add some shadow */
        }

        /* Loader gif centered */
        #loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

    </style>

    <div class="ec-content-wrapper">
        <div id="loaderOverlay"
            style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999;">
            <!-- Loader GIF centered -->
            <div id="loader" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <img src="{{ asset('admin/loader/loader.gif') }}" alt="Loading...">
            </div>
        </div>
        <div class="content">
            <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
                <div>
                    <h1>Edit Product</h1>
                    <p class="breadcrumbs"><span><a href="{{ route('admin_dashboard') }}">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>Product
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin_viewproduct') }}" class="btn btn-primary"> View All </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-header card-header-border-bottom">
                            <h2>Edit Product</h2>
                        </div>
                        <div class="card-body">
                            <div class="row ec-vendor-uploads">
                                <form class="row g-3" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-lg-4">
                                        <div>
                                            <a href="{{ route('admin_products.edit_image', $product->id) }}"
                                                class="btn btn-warning mb-4"> Edit Images
                                            </a>
                                        </div>
                                        <div class="ec-vendor-img-upload">
                                            <div class="row">
                                                @php
                                                    $images = $product->productImages; // Assuming you are retrieving product images from the relationship
                                                @endphp
                                                <div class="single-pro-img">
                                                    <div class="single-product-scroll">
                                                        <div class="single-product-cover">
                                                            @foreach ($images as $image)
                                                                <div class="single-slide zoom-image-hover">
                                                                    @php
                                                                        $extension = pathinfo(
                                                                            $image->image,
                                                                            PATHINFO_EXTENSION,
                                                                        );
                                                                        $isVideo = in_array($extension, [
                                                                            'mp4',
                                                                            'mkv',
                                                                            'avi',
                                                                            'gif',
                                                                        ]);
                                                                        $isYouTubeUrl = preg_match(
                                                                            '/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/',
                                                                            $image->image,
                                                                        );
                                                                    @endphp

                                                                    @if ($isYouTubeUrl)
                                                                        @php
                                                                            // Convert YouTube URL to embeddable format
                                                                            $youtubeId = '';
                                                                            if (
                                                                                preg_match(
                                                                                    '/[\\?\\&]v=([^\\?\\&]+)/',
                                                                                    $image->image,
                                                                                    $matches,
                                                                                )
                                                                            ) {
                                                                                $youtubeId = $matches[1];
                                                                            } elseif (
                                                                                preg_match(
                                                                                    '/youtu.be\/([^\\?\\&]+)/',
                                                                                    $image->image,
                                                                                    $matches,
                                                                                )
                                                                            ) {
                                                                                $youtubeId = $matches[1];
                                                                            }
                                                                            $embedURL =
                                                                                'https://www.youtube.com/embed/' .
                                                                                $youtubeId;
                                                                        @endphp
                                                                        <iframe class="img-responsive" width="100%"
                                                                            height="350" src="{{ $embedURL }}"
                                                                            frameborder="0"
                                                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                                            allowfullscreen>
                                                                        </iframe>
                                                                    @elseif ($isVideo)
                                                                        <video class="img-responsive" controls
                                                                            style="max-width: 100%;">
                                                                            <source
                                                                                src="{{ asset('user/uploads/products/images/' . $image->image) }}"
                                                                                type="video/{{ $extension }}">
                                                                            Your browser does not support the video tag.
                                                                        </video>
                                                                    @else
                                                                        <img class="img-responsive"
                                                                            src="{{ asset('user/uploads/products/images/' . $image->image) }}"
                                                                            alt="Product Image">
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        @php
                                                            // Function to convert YouTube URL to embed URL
                                                            function convertYouTubeURLToEmbed($url)
                                                            {
                                                                $pattern =
                                                                    '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
                                                                preg_match($pattern, $url, $matches);
                                                                if (isset($matches[1])) {
                                                                    return 'https://www.youtube.com/embed/' .
                                                                        $matches[1];
                                                                }
                                                                return $url;
                                                            }
                                                        @endphp
                                                        @if (count($images) > 1)
                                                            <div class="single-nav-thumb">
                                                                @foreach ($images as $image)
                                                                    <div class="single-slide">
                                                                        @php
                                                                            $extension = pathinfo(
                                                                                $image->image,
                                                                                PATHINFO_EXTENSION,
                                                                            );
                                                                            $isVideo = in_array($extension, [
                                                                                'mp4',
                                                                                'mkv',
                                                                                'avi',
                                                                            ]);
                                                                            $isYouTubeUrl = preg_match(
                                                                                '/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/',
                                                                                $image->image,
                                                                            );
                                                                        @endphp

                                                                        @if ($isYouTubeUrl)
                                                                            @php
                                                                                $embedURL = convertYouTubeURLToEmbed(
                                                                                    $image->image,
                                                                                );
                                                                            @endphp
                                                                            <iframe class="img-responsive" width="100%"
                                                                                height="40px" src="{{ $embedURL }}"
                                                                                frameborder="0"
                                                                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                                                allowfullscreen>
                                                                            </iframe>
                                                                        @elseif ($isVideo)
                                                                            <video class="img-responsive" controls
                                                                                style="max-width: 100%;">
                                                                                <source
                                                                                    src="{{ asset('user/uploads/products/images/' . $image->image) }}"
                                                                                    type="video/{{ $extension }}">
                                                                                Your browser does not support the video tag.
                                                                            </video>
                                                                        @else
                                                                            <img class="img-responsive"
                                                                                src="{{ asset('user/uploads/products/images/' . $image->image) }}"
                                                                                alt="Product Thumbnail">
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="ec-vendor-upload-detail">
                                            <div class="row">
                                                <div class="col-md-12 mb-3 mt-3">
                                                    <label for="inputEmail4" class="form-label">Product Name</label>
                                                    <input type="text" class="form-control slug-title" name="name" value="{{ old('name', $product->name) }}" id="inputEmail4">
                                                </div>
                                                <div class="col-md-12 mb-3 mt-3">
                                                    <label for="tags" class="form-label">Product Tags</label>
                                                    <input type="text" class="form-control slug-title" name="tags" value="{{ old('tags', $product->tags) }}" id="tags">
                                                </div>
                                                <div class="col-md-6 mb-3 mt-3">
                                                    <label class="form-label">Select Categories</label>
                                                    <select name="categories" id="Categories" class="form-select">
                                                        <option selected disabled> -- Select -- </option>
                                                        @foreach ($categories as $cat)
                                                            <option value="{{ $cat->id }}"
                                                                {{ $cat->id == $product->category ? 'selected' : '' }}>
                                                                {{ $cat->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3 mt-3">
                                                    <label class="form-label">Select Sub Categories</label>
                                                    <select name="subcategories" id="subCategories" class="form-select">
                                                        @foreach ($subcategories as $subcat)
                                                            <option value="{{ $subcat->id }}" {{ $subcat->id == $product->subcategory ? 'selected' : '' }}> {{ $subcat->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3 mt-3">
                                                    <label class="form-label">Choosen Brand</label>
                                                    <select name="brand" id="brand" class="form-select">
                                                        <option selected disabled> -- Select -- </option>
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}" @if ($product->productBrand) {{ $brand->id == $product->productBrand->brand_id ? 'selected' : '' }} @endif> {{ $brand->brand_name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3 mt-3">
                                                    <label class="form-label">Select Collections </label>
                                                    <select name="collection" id="collection" class="form-select">
                                                        <option selected disabled> -- Select -- </option>
                                                        @foreach ($collections as $collection)
                                                            <option value="{{ $collection->id }}" @if ($product->collections) {{ $collection->id == $product->collection->id ? 'selected' : '' }} @endif >
                                                                {{ $collection->collection_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-12 mb-3 mt-3">
                                                    <label class="form-label">Select HSN Code </label>
                                                    <select name="hsn_code" id="hsn_code" class="form-select">
                                                        @foreach ($hsnCodes as $hsn)
                                                            <option value="{{ $hsn->id }}" @if ($product->productHsn) {{ $hsn->id == $product->productHsn->hsn_code ? 'selected' : '' }} @endif data-gst="{{ $hsn->gst }}">
                                                                {{ $hsn->hsn_code." - ".$hsn->description." (" .$hsn->gst. " %)" }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @php
                                                    $gstRate = $hsnCodes->where('id', $product->hsn_id)->first()->gst;
                                                @endphp
                                                <div class="col-md-6 mb-3 mt-3">
                                                    <label for="gst_rate" class="form-label">GST Rate (%)</label>
                                                    <input type="text" class="form-control slug-title" name="gst_rate" value="{{ old('gst_rate', $gstRate) }}" id="gst_rate" readonly>
                                                </div>
                                                <div class="col-md-6 mb-3 mt-3">
                                                    <label for="item_code" class="form-label">Item Code</label>
                                                    <input type="text" class="form-control slug-title" name="item_code" value="{{ old('item_code', $product->item_code) }}" id="item_code" readonly>
                                                </div>
                                                <div class="col-md-6 mb-3 mt-3">
                                                    <label class="form-label">Original Price <span>( In Rupee )</span></label>
                                                    <input type="number" name="original_price" class="form-control" id="price1" value="{{ old('original_price', $product->original_price) }}">
                                                </div>
                                                <div class="col-md-6 mb-3 mt-3">
                                                    <label class="form-label">Offer Price <span>( In Rupee )</span></label>
                                                    <input type="number" name="offer_price" class="form-control" id="offerPrice" value="{{ old('offer_price', $product->offer_price) }}">
                                                </div>
                                                <div class="col-md-6 mb-3 mt-3">
                                                    <label class="form-label">Discount Percentage <span>( % )</span></label>
                                                    <input type="number" name="discount_percentage" class="form-control" id="discountPercentage" readonly value="{{ old('discount_percentage', $product->discount_percentage) }}">
                                                </div>
                                                <div class="col-md-12 mb-3 mt-3">
                                                    <label class="form-label">Short Description</label>
                                                    <textarea class="form-control summernote" rows="4" id="summernote" name="short_description">{{ old('short_description', $product->short_description) }}</textarea>
                                                </div>
                                                <div class="col-md-12 mb-25 mb-3 mt-3">
                                                    <label class="form-label">Selected Colors</label>
                                                    <div id="colorInputsContainer">
                                                        @if ($product->productColours)
                                                            @foreach ($product->productColours as $color)
                                                                <div class="color-input-group mb-2" id="color-{{ $loop->index }}">
                                                                    <input type="color" class="form-control form-control-color" name="colors[]" value="{{ $color->colour_name }}" title="Choose your color">
                                                                    <button type="button" class="btn btn-sm btn-danger remove-color-btn mt-2" data-index="{{ $loop->index }}">Remove</button>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-primary mt-2" id="addColorInput">Add Color</button>
                                                </div>

                                                <div class="col-md-12 mb-25">
                                                    <label class="form-label">Size</label>
                                                    <br>
                                                    <button type="button" class="btn btn-sm btn-info mt-2 mb-4" id="addSizeInput">Add More Size option</button>
                                                    <button type="button" class="btn btn-sm btn-success mt-2 mb-4" id="manageSizeInput" data-bs-toggle="modal" data-bs-target="#sizeModal"> Manage Size </button>
                                                    <div class="form-checkbox-box">
                                                        <table class="custom-table">
                                                            <thead>
                                                                <tr>
                                                                @foreach ($groupedSizes as $categoryName => $sizes)
                                                                    <th data-key="{{ $sizes->first()->key }}">{{ $categoryName }}</th> <!-- Display Category Name in thead -->
                                                                @endforeach
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    @foreach ($groupedSizes as $sizes)
                                                                        <td>
                                                                            @foreach ($sizes as $size)
                                                                                <div class="form-check-2">
                                                                                    <input type="checkbox" name="sizes[]"
                                                                                        value="{{ $size->name }}"
                                                                                        class="size-checkbox {{ $size->name == 'FREE' ? 'free-checkbox' : '' }}"
                                                                                        @if ($product->productSizes->contains('size', $size->name)) checked @endif
                                                                                        >
                                                                                    <label>{{ $size->name }}</label>
                                                                                </div>
                                                                            @endforeach
                                                                        </td>
                                                                    @endforeach
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- Container to display size and quantity inputs -->
                                                <div class="col-md-12" id="sizeQuantityContainer">
                                                    @foreach ($product->productSizes as $key => $size)
                                                        <div class="row mb-3 size-quantity"
                                                            id="size-{{ $size->size }}">
                                                            <div class="col-md-6">
                                                                <label>Size: {{ $size->size }}</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" name="size_quantity[{{ $size->size }}]" class="form-control" value="{{ $size->quantity }}" placeholder="Quantity for {{ $size }}">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>


                                                <div class="col-md-12 mb-3 mt-3">
                                                    <label class="form-label">Full Details</label>
                                                    <textarea class="form-control summernote" rows="4" id="full_summernote" name="full_details">{{ old('full_details', $product->full_details) }}</textarea>
                                                </div>
                                                <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                                                <div class="col-md-12 mb-3 mt-3">
                                                    <div class="row">
                                                        <div class="col-md-3 mb-3">
                                                            <label for="length" class="form-label">Length (cm)</label>
                                                            <input type="number" step="0.01" class="form-control" id="length" name="length" value="{{ old('length', optional($dimensions)->length ?? '') }}" placeholder="Enter length" required>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="width" class="form-label">Width (cm)</label>
                                                            <input type="number" step="0.01" class="form-control" id="width" name="width" value="{{ old('width', optional($dimensions)->width ?? '') }}" placeholder="Enter width" required>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="height" class="form-label">Height (cm)</label>
                                                            <input type="number" step="0.01" class="form-control" id="height" name="height" value="{{ old('height', optional($dimensions)->height ?? '') }}" placeholder="Enter height" required>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="weight" class="form-label">Weight (kg)</label>
                                                            <input type="number" step="0.01" class="form-control" id="weight" name="weight" value="{{ old('weight', optional($dimensions)->weight ?? '') }}" placeholder="Enter weight" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-center mt-5">
                                        <button type="submit" class="btn btn-primary btn-lg">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Content -->

        <div class="modal fade" id="addSizeModal" tabindex="-1" aria-labelledby="addSizeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSizeModalLabel">Add New Size</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger d-none" id="error-message"></div>
                        <form id="addSizeForm">
                            <div class="col-sm-12 mb-3 mt-3">
                                <label class="form-label">Select Categories</label>
                                <select name="key" id="newCategories" class="form-select">
                                    <option selected disabled> -- Select -- </option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="sizeName" class="form-label">Size Name</label>
                                <input type="text" class="form-control" id="sizeName" name="sizeName" required>
                            </div>
                            <button type="button" class="btn btn-primary" id="addSizeButton">Add Size</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="sizeModal" tabindex="-1" aria-labelledby="sizeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sizeModalLabel">Manage Sizes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" style="color:rgb(16, 16, 63);font-weight:600">Size</th>
                                    <th class="text-center" style="color:rgb(16, 16, 63);font-weight:600">Action</th>
                                </tr>
                            </thead>
                            <tbody id="sizesTableBody">
                                <!-- Size rows will be dynamically inserted here -->
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    // for discount
    $(document).ready(function() {
        function calculateDiscount() {
            let originalPrice = parseFloat($('#price1').val());
            let offerPrice = parseFloat($('#offerPrice').val());
            let discountPercentageField = $('#discountPercentage');

            // Log values to debug
            console.log("Original Price:", originalPrice);
            console.log("Offer Price:", offerPrice);

            // Reset validation message
            $('.validation-error').remove();

            if (isNaN(originalPrice) || isNaN(offerPrice)) {
                discountPercentageField.val(0);
                return;
            }

            if (offerPrice > originalPrice) {
                $('#offerPrice').closest('.col-md-6').append(
                    '<span class="text-danger validation-error">Offer price cannot be higher than original price.</span>'
                );
                discountPercentageField.val(0);
            } else {
                console.log('Calculating discount...');
                let discountPercentage = ((originalPrice - offerPrice) / originalPrice) * 100;
                discountPercentageField.val(discountPercentage.toFixed(2)); // Update discount percentage
            }
        }

        $('#offerPrice, #originalPrice').on('input', function() {
            calculateDiscount();
        });

    });
</script>

<script>
    // for videos/ youtube url

    $(document).ready(function() {

        // Validate video duration for the file input
        $(document).on('change', '#videoUpload', function() {
            let file = this.files[0];
            let videoMessage = $('#videoMessage');

            // Validate if the user selects a file
            if (file) {
                let video = document.createElement('video');
                video.preload = 'metadata';

                video.onloadedmetadata = function() {
                    window.URL.revokeObjectURL(video.src);

                    // Check the duration
                    if (video.duration > 15) {
                        videoMessage.text('The video duration should not be more than 15 seconds.')
                            .show();
                        $('#videoUpload').val(''); // Clear the file input
                    } else {
                        videoMessage
                            .hide(); // Hide the message if the video is within the allowed duration
                    }
                };

                video.src = URL.createObjectURL(file);
            }
        });
    });

    // for color

    $(document).ready(function() {
        // Remove color input
        $(document).on('click', '.remove-color-btn', function() {
            let index = $(this).data('index');
            $('#color-' + index).remove();
        });
        $('#addColorInput').click(function() {
            // Add a new color input
            $('#colorInputsContainer').append(`
        <div class="color-input-wrapper mt-2">
            <input type="color" class="form-control form-control-color" name="colors[]" value="#33317d" title="Choose your color">
            <button type="button" class="btn btn-sm btn-danger remove-color-input">Remove</button>
        </div>
                                            `);
        });

        // Remove color input when the "Remove" button is clicked
        $(document).on('click', '.remove-color-input', function() {
            $(this).closest('.color-input-wrapper').remove();
        });

        // Update input value when a new color is selected from the color picker
        $(document).on('input', '.form-control-color', function() {
            $(this).attr('value', $(this).val()); // Update the value attribute dynamically
        });
    });



    // for size
    $(document).ready(function() {
        let freeCheckbox = $('.size-checkbox[value="FREE"]');
        let otherCheckboxes = $('.size-checkbox').not('[value="FREE"]');
        let sizeContainer = $('#sizeQuantityContainer');

        // On page load, check if "FREE" is selected and disable other checkboxes
        if (freeCheckbox.is(':checked')) {
            otherCheckboxes.prop('disabled', true);
        }
        let freeAlertShown = false;
        // Handle checkbox change events
        $(document).on('change', '.size-checkbox', function() {
            let size = $(this).val();
            let sizeId = `size-${size.replace(/\s+/g, "_")}`; // Sanitize the 'size' value to create a valid ID

            let freeCheckbox = $('.free-checkbox');
            let sizeContainer = $('#sizeQuantityContainer');
            let anyOtherChecked = $('.size-checkbox').not('.free-checkbox').is(':checked');

            if (size === "FREE") {
                if ($(this).is(':checked')) {
                    // Disable all other checkboxes and uncheck them
                    $('.size-checkbox').not(this).prop('disabled', true).prop('checked', false);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Selection Alert',
                        text: 'You cannot select other sizes when "FREE" is selected.'
                    });

                    // Add quantity input for "FREE" size
                    let quantityInput = `
            <div class="row mb-3 size-quantity" id="${sizeId}" >
                <div class="col-md-6">
                    <label>Size: ${size}</label>
                </div>
                <div class="col-md-6">
                    <input type="number" name="size_quantity[${size}]" class="form-control" placeholder="Quantity for ${size}">
                </div>
            </div>
            `;
                    sizeContainer.append(quantityInput);
                } else {
                    // Re-enable all checkboxes when "FREE" is unchecked
                    $('.size-checkbox').prop('disabled', false);
                    // Remove the quantity input for "FREE" size
                    $(`#${sizeId}`).remove();
                }
            } else {
                // Disable the "FREE" checkbox and show message when any other size is selected
                if (freeCheckbox.is(':checked')) {
                    freeCheckbox.prop('checked', false).prop('disabled', true);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Selection Alert',
                        text: 'Selecting another size disables the "FREE" option.'
                    });
                }

                // Disable the "FREE" checkbox
                if (!freeAlertShown) {
                    freeCheckbox.prop('disabled', true);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Selection Alert',
                        text: 'Selecting another size disables the "FREE" option.'
                    });
                    freeAlertShown = true; // Set the flag to prevent further alerts
                }
                // Add quantity input for selected size
                if ($(this).is(':checked')) {
                    
                    let quantityInput = `
            <div class="row mb-3 size-quantity" id="${sizeId}">
                <div class="col-md-6">
                    <label>Size: ${size}</label>
                </div>
                <div class="col-md-6">
                    <input type="number" name="size_quantity[${size}]" class="form-control" placeholder="Quantity for ${size}">
                </div>
            </div>
            `;
                    sizeContainer.append(quantityInput);
                } else {
                    // Remove quantity input when size is unchecked
                    $(`#${sizeId}`).remove();
                }
            }

            // Check if any checkbox other than "FREE" is checked
            if ($('.size-checkbox').not('.free-checkbox').is(':checked')) {
                // Ensure the "FREE" checkbox remains disabled
                freeCheckbox.prop('disabled', true);
            } else {
                // If no checkboxes are selected, enable the "FREE" checkbox
                freeCheckbox.prop('disabled', false);
            }
        });
    });
</script>

<script>
    $(document).ready(function() {

        $('#Categories').on('change', function() {
            var categoryId = $(this).val();
            // Define the route URL with a placeholder for the category_id
            var fetchSubcategoriesUrl =
                '{{ route('subcategories.fetch', ['category_id' => ':category_id']) }}';
            if (categoryId) {
                // Replace the placeholder with the actual category ID
                var url = fetchSubcategoriesUrl.replace(':category_id', categoryId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var $subCategorySelect = $('#subCategories');
                        $subCategorySelect.empty();

                        if (data.length) {
                            // Clear existing options
                            $subCategorySelect.empty();

                            // Add default option for selecting a subcategory
                            $subCategorySelect.append('<option value="" disabled selected>Select Subcategory</option>');

                            // Append subcategory options
                            $.each(data, function(key, subcategory) {
                                $subCategorySelect.append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                            });
                        } else {
                            // Clear existing options and show no subcategories available
                            $subCategorySelect.empty();
                            $subCategorySelect.append('<option value="" selected disabled>No Subcategories Available</option>');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#subCategories').html(
                    '<option value="" selected disabled>Choose Category First</option>');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("form").submit(function(event) {
            // Prevent the default form submission
            event.preventDefault();

            // Clear any previous validation messages
            $(".validation-error").remove();

            // Get form values
            var productName = $("#inputEmail4").val().trim();
            var hsnCode = $("#hsn_code").val();
            var category = $("#Categories").val();
            var subcategory = $("#subCategories").val();
            var brand = $("#brand").val();
            var originalPrice = $("#price1").val().trim();
            var offerPrice = $("#offerPrice").val().trim();
            var discount_percentage = $("#discountPercentage").val().trim();
            var shortDescription = $("textarea").val().trim();
            var product_id = $("#product_id").val(); // Add this if you need the product ID for updating





            // Size checkboxes
            var isSizeSelected = $(".size-checkbox:checked").length > 0;

            // Initialize a flag for form validation
            var isValid = true;

            // Check if any size is selected
            $('.size-checkbox:checked').each(function() {
                let size = $(this).val();
                let quantityInput = $(`input[name="size_quantity[${size}]"]`);

                // Check if the quantity input for the selected size has a value
                if (quantityInput.length && quantityInput.val() === '') {
                    isValid = false;
                    quantityInput.addClass('is-invalid'); // Highlight the invalid field
                } else {
                    quantityInput.removeClass('is-invalid'); // Remove highlight if valid
                }
            });

            // Validate Product Name
            if (productName === "") {
                isValid = false;
                $("#inputEmail4").after(
                    '<span class="validation-error text-danger">Product name is required.</span>');
            }

            // Validate Categories
            if (category === null) {
                isValid = false;
                $("#Categories").after(
                    '<span class="validation-error text-danger">Please select a category.</span>');
            }

            // Validate Sub Categories
            if (subcategory === null) {
                isValid = false;
                $("#subCategories").after(
                    '<span class="validation-error text-danger">Please select a subcategory.</span>'
                );
            }

            // Validate Original Price
            if (originalPrice === "" || isNaN(originalPrice) || parseFloat(originalPrice) <= 0) {
                isValid = false;
                $("#price1").after(
                    '<span class="validation-error text-danger">Please enter a valid original price.</span>'
                );
            }

            // Validate Offer Price
            if (offerPrice === "" || isNaN(offerPrice) || parseFloat(offerPrice) < 0) {
                isValid = false;
                $("#offerPrice").after(
                    '<span class="validation-error text-danger">Please enter a valid offer price.</span>'
                );
            }

            // Validate Short Description
            if (shortDescription === "") {
                isValid = false;
                $("textarea").after(
                    '<span class="validation-error text-danger">Short description is required.</span>'
                );
            }



            // Validate Sizes (At least one size must be checked)
            

            // Check if the form is valid before submitting via AJAX
            if (isValid) {
                $("#loaderOverlay").fadeIn(); // Show the loader overlay
                // Collect form data
                var formData = new FormData(this);
                console.log(formData);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('admin_product_update') }}", // Update this to your route for editing
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#loaderOverlay").fadeOut(); // Show the loader overlay
                        // Handle success
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Form updated successfully!',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect to the route after clicking "OK"
                                window.location.href =
                                    "{{ route('admin_products.info', ['id' => $product->id]) }}";
                            }
                        });
                    },
                    error: function(xhr) {
                        $("#loaderOverlay").fadeOut(); // Show the loader overlay
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            var fieldElement = $(`#${field}`);
                            fieldElement.addClass('is-invalid');
                            $.each(messages, function(index, message) {
                                fieldElement.after(
                                    `<span class="validation-error text-danger">${message}</span>`
                                );
                            });
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There were validation errors. Please check the form.',
                        });
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#Categories, #subCategories').change(function() {
            const categoryId = $('#Categories').val();
            const subcategoryId = $('#subCategories').val();

            if (categoryId && subcategoryId) {
                $.ajax({
                    url: "{{ route('generate.item.code') }}",
                    type: 'GET',
                    data: {
                        category_id: categoryId,
                        subcategory_id: subcategoryId
                    },
                    success: function(data) {
                        $('#item_code').val(data.item_code);
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Show the modal when the button is clicked
        $('#addSizeInput').on('click', function() {
            $('#addSizeModal').modal('show');
        });

        // Handle the form submission via AJAX
        $('#addSizeButton').click(function() {
            

            // Get the size name from the input field
            let sizeName = $('#sizeName').val();
            let key = $('#newCategories').val();

            // Clear previous error message
            $('#error-message').addClass('d-none').text('');

            // Perform AJAX request to add the size
            $.ajax({
                url: '{{ route('sizes.store') }}', // Assuming a route named sizes.store
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: sizeName,
                    key : key
                },
                success: function(response) {

                    // Close the modal
                    $('#addSizeModal').modal('hide');

                    

                    // Show success Swal alert
                    Swal.fire({
                        title: 'Success!',
                        text: 'New size has been added successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    // Extract the size and key from the response
                    // Extract the size and key from the response
                    let size = response.size;
                    let categoryId = size.key;

                    // Find the table column with matching data-key
                    let categoryColumn = $(`table.custom-table thead th[data-key="${categoryId}"]`);

                    if (categoryColumn.length > 0) {
                        // Find the corresponding <td> in the table body
                        let columnIndex = categoryColumn.index();
                        let targetCell = $(`table.custom-table tbody tr td`).eq(columnIndex);

                        // Append the new size to the found <td>
                        targetCell.append(`
                            <div class="form-check-2">
                                <input type="checkbox" name="sizes[]"
                                    value="${size.name}"
                                    class="size-checkbox ${size.name === 'FREE' ? 'free-checkbox' : ''}">
                                <label>${size.name}</label>
                            </div>
                        `);
                    } else {
                        // Log error if the category is not found
                        console.error(`Category column with ID "${categoryId}" not found.`);
                    }

                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation error occurred
                        let errors = xhr.responseJSON.errors;
                        $('#error-message').removeClass('d-none').text(errors.name[0]);
                    } else {
                        // Handle other errors
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#manageSizeInput').on('click', function() {
            fetchSizesAndUpdateCheckboxes();
        });

        // Handle delete button click
        $(document).on('click', '.delete-size-btn', function() {
            let sizeId = $(this).data('id');
            let sizeName = $(this).data('name');
            let deleteUrl = `{{ route('sizes.delete', ':id') }}`;
            deleteUrl = deleteUrl.replace(':id', sizeId);
            // AJAX call to delete the size
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Remove the quantity field for the deleted size
                    $(`button[data-id="${sizeId}"]`).closest('tr').remove();

                    // Find the corresponding checkbox and label in the table
            let categoryId = response.size.key; // Extract categoryId from response
            let sizeName = response.size.name;  // Extract size name from response

            console.log(`categoryId: ${categoryId}, sizeName: ${sizeName}`);

            // Find the table column with matching data-key
            let categoryColumn = $(`table.custom-table thead th[data-key="${categoryId}"]`);

            if (categoryColumn.length > 0) {
                // Find the corresponding <td> in the table body
                let columnIndex = categoryColumn.index();
                let targetCells = $(`table.custom-table tbody tr td:nth-child(${columnIndex + 1})`); // +1 for 1-based index
                
                // Loop through each cell in the column and remove the checkbox if it matches the size
                targetCells.each(function() {
                    let cell = $(this);
                    let checkbox = cell.find(`.size-checkbox[value="${sizeName}"]`);
                    
                    if (checkbox.length > 0) {
                        checkbox.closest('.form-check-2').remove();  // Remove the checkbox and label wrapper
                    }
                });
            } else {
                console.error(`Category column with ID "${categoryId}" not found.`);
            }

            
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'The size has been deleted.',
                    });
                    // Close the modal
            $('#sizeModal').modal('hide');
                    
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'There was a problem deleting the size.',
                    });
                }
            });
        });
    });


    // Function to update the size checkboxes in the form
    function updateModalTable(sizes) {
        let sizesTableBody = $('#sizesTableBody');
        sizesTableBody.empty(); // Clear the existing rows

        // Group sizes by key
        let groupedSizes = sizes.reduce((groups, size) => {
            let key = size.key; // Assuming 'key' is the grouping property in your Size model
            if (!groups[key]) {
                groups[key] = [];
            }
            groups[key].push(size);
            return groups;
        }, {});

        // Loop through the grouped sizes and render them
        Object.keys(groupedSizes).forEach(function(key) {
            // Add a heading for the group
            let headingHtml = `
                <tr>
                    <th colspan="2" class="text-center" style="background-color: #f8f9fa;">
                        <strong>${key}</strong>
                    </th>
                </tr>
            `;
            sizesTableBody.append(headingHtml);

            // Render each size in the group
            groupedSizes[key].forEach(function(size) {
                let rowHtml = `
                    <tr>
                        <td class="text-center">${size.name}</td>
                        <td class="text-center">
                            <button class="btn btn-danger btn-sm delete-size-btn" data-id="${size.id}" data-name="${size.name}">Delete</button>
                        </td>
                    </tr>
                `;
                sizesTableBody.append(rowHtml);
            });
        });
    }

    let getSizesUrl = @json(route('sizes.index'));
    // Function to fetch the updated sizes and update the checkboxes
    function fetchSizesAndUpdateCheckboxes() {
        $.ajax({
            url: getSizesUrl,
            type: 'GET',
            success: function(sizes) {
                updateModalTable(sizes); // Update the checkboxes with the new data
            },
            error: function(xhr) {
                console.error('Error fetching sizes:', xhr);
            }
        });
    }
    // Function to update the table inside the modal
    function updateModalTable(sizes) {

        let sizesTableBody = $('#sizesTableBody');
        sizesTableBody.empty(); // Clear the existing rows
        // Group sizes by key
        let groupedSizes = sizes.reduce((groups, size) => {
            let categoryName = size.category_details ? size.category_details.name : 'Uncategorized'; // Group by category name or fallback to 'Uncategorized'


            let key = size.key; // Assuming 'key' is the grouping property in your Size model
            if (!groups[categoryName]) {
                groups[categoryName] = [];
            }
            groups[categoryName].push(size);
            return groups;
        
        }, {});
        Object.keys(groupedSizes).forEach(function(key) {
            // Add a heading for the group
            let headingHtml = `
                <tr>
                    <th colspan="2" class="text-center" style="background-color: #f8f9fa;">
                        <strong>${key}</strong>
                    </th>
                </tr>
            `;
            sizesTableBody.append(headingHtml);

            // Render each size in the group
            groupedSizes[key].forEach(function(size) {
                let rowHtml = `
                    <tr>
                        <td class="text-center">${size.name}</td>
                        <td class="text-center">
                            <button class="btn btn-danger btn-sm delete-size-btn" data-id="${size.id}" data-name="${size.name}">Delete</button>
                        </td>
                    </tr>
                `;
                sizesTableBody.append(rowHtml);
            });
        });
    }
</script>

<script id="populate-hsn-codes" type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const hsnSelect = document.getElementById('hsn_code');
        const gstInput = document.getElementById('gst_rate');

        // Prevent fetching multiple times
        let fetched = {{ $hsnCodes->isEmpty() ? 'false' : 'true' }};

        hsnSelect.addEventListener('click', function () {
            if (fetched) return;
            fetched = true;

            fetch('/hsn-codes')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch HSN codes');
                    }
                    return response.json();
                })
                .then(data => {
                    // Clear previous options (except first)
                    hsnSelect.length = 1;

                    data.forEach(hsn => {
                        const option = document.createElement('option');
                        option.value = hsn.id;
                        option.textContent = `${hsn.hsn_code} - ${hsn.description} (${hsn.gst}%)`;
                        option.dataset.gst = hsn.gst;
                        hsnSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error(error);
                    alert('Could not load HSN codes. Please try again later.');
                });
        });

        hsnSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const gst = selectedOption.dataset.gst;
            gstInput.value = gst ? gst : '';
        });
    });
</script>

@endpush
