@extends('superuser.layouts.master')



@section('content')
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
                <div>
                    <h1>Product Detail</h1>
                    <p class="breadcrumbs"><span><a href="{{ route('admin_dashboard') }}">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>Product
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin_products.edit', $product->id) }}" class="btn btn-primary"> Edit
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-header card-header-border-bottom">
                            <h2>Product Detail</h2>
                        </div>
                        @php
                            $images = $product->productImages; // Assuming you are retrieving product images from the relationship
                        @endphp
                        <div class="card-body product-detail">
                            <div class="row">
                                <div class="col-xl-4 col-lg-6">
                                    <div class="row">
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
                                                                        'https://www.youtube.com/embed/' . $youtubeId;
                                                                @endphp
                                                                <iframe class="img-responsive" width="100%" height="350"
                                                                    src="{{ $embedURL }}" frameborder="0"
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
                                                            return 'https://www.youtube.com/embed/' . $matches[1];
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
                                <div class="col-xl-8 col-lg-6">
                                    <div class="row product-overview">
                                        <div class="col-12">
                                            <h5 class="product-title fw-bold" style="color:rgb(10, 13, 58);font-size: 25px">
                                                {{ $product->name }}</h5>
                                            <p class="product-price mt-4">Category: {{ $product->categoryDetails->name ?? ''}}</p>
                                            <p class="product-price ">Sub-Category: {{ $product->subCategoryDetails->name ?? '' }}</p>
                                            <p class="product-price ">Item Code: {{ $product->item_code ?? '' }}</p>
                                            <p class="product-price ">Tags: {{ $product->tags ?? '' }}</p>
                                            <p class="product-price ">Collection: {{ $product->collection->collection_name ?? 'No Collection Added' }}</p>
                                            <p class="product-rate">
                                                @php
                                                    // Assuming $averageRating is the average rating value passed from the controller
                                                    $rating = $averageRating;
                                                    $count = $reviewCount;
                                                @endphp

                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="mdi mdi-star {{ $i <= $rating ? 'is-rated' : '' }}"></i>
                                                @endfor
                                                <span class="review-count"
                                                    style="color:rgb(5, 112, 20); font-size: 0.875rem; font-weight:600;">({{ $count }}
                                                    {{ Str::plural('person', $count) }} rated)</span>
                                            </p>
                                            <p class="product-desc ">{!! $product->short_description !!}</p>


                                            {{-- <div class="ec-ofr">
                                                <h6>Available offers</h6>
                                                <ul>
                                                    <li><b>Special Price :</b> Get extra 16% off (price
                                                        inclusive of discount) <a href="#">T&C</a> </li>
                                                    <li><b>Bank Offer :</b> 10% off on XYZ Bank Cards, up to
                                                        $12. On orders of $200 and above <a href="#">T&C</a>
                                                    </li>
                                                    <li><b>Bank Offer :</b> 5% Unlimited Cashback on Ekka XYZ
                                                        Bank Credit Card <a href="#">T&C</a></li>
                                                    <li><b>Bank Offer :</b> Flat $50 off on first Ekka Pay Later
                                                        order of $200 and above <a href="#">T&C</a></li>
                                                </ul>
                                            </div> --}}
                                            <p class="product-price mt-5">Original Price: <span style="color:red">&#8377;
                                                    {{ $product->original_price }}</span></p>
                                            <p class="product-price">Offer Price: <span
                                                    style="color:rgb(12, 95, 30)">&#8377;
                                                    {{ $product->offer_price }}</span>
                                            </p>
                                            {{-- <p class="product-sku">SKU#: WH12</p> --}}
                                            @php
                                                $sizes = $product->productSizes; // Assuming `productSizes` is a relationship or attribute with sizes
                                                $colors = $product->productColours; // Assuming `productColours` is a relationship or attribute with colors
                                            @endphp

                                            <ul class="product-size">

                                                @foreach ($sizes as $size)
                                                    <li class="size">
                                                        <span class="fw-bold">Size <br>{{ $size->size }}</span><br>
                                                        <span class="fw-bold ml-4">Stock <br>{{ $size->quantity }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>

                                            <ul class="product-color">

                                                @foreach ($colors as $color)
                                                    <li class="color">
                                                        <span style="background-color: {{ $color->colour_name }};"></span>
                                                    </li>
                                                @endforeach
                                            </ul>

                                            <div class="product-stock">

                                                {{-- <div class="stock">
                                                    <p class="title">Pending</p>
                                                    <p class="text">50</p>
                                                </div>
                                                <div class="stock">
                                                    <p class="title">InOrder</p>
                                                    <p class="text">20</p>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-xl-3 col-lg-12 u-card">
                                    <div class="card card-default seller-card">
                                        <div class="card-body text-center">
                                            <a href="javascript:0" class="text-secondary d-inline-block">
                                                <div class="image mb-3">
                                                    <img src="{{ url('/') }}/admin/assets/img/user/u-xl-4.jpg"
                                                        class="img-fluid rounded-circle" alt="Avatar Image">
                                                </div>

                                                <h5 class="text-dark">John Karter</h5>
                                                <p class="product-rate">
                                                    <i class="mdi mdi-star is-rated"></i>
                                                    <i class="mdi mdi-star is-rated"></i>
                                                    <i class="mdi mdi-star is-rated"></i>
                                                    <i class="mdi mdi-star is-rated"></i>
                                                    <i class="mdi mdi-star"></i>
                                                </p>

                                                <ul class="list-unstyled">
                                                    <li class="d-flex mb-1">
                                                        <i class="mdi mdi-map mr-1"></i>
                                                        <span>321/2, rio street, usa.</span>
                                                    </li>
                                                    <li class="d-flex mb-1">
                                                        <i class="mdi mdi-email mr-1"></i>
                                                        <span>example@email.com</span>
                                                    </li>
                                                    <li class="d-flex">
                                                        <i class="mdi mdi-whatsapp mr-1"></i>
                                                        <span>+00 987-654-3210</span>
                                                    </li>
                                                </ul>
                                            </a>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>

                            <div class="row review-rating mt-4">
                                <div class="col-12">
                                    <ul class="nav nav-tabs" id="myRatingTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="product-detail-tab" data-bs-toggle="tab"
                                                data-bs-target="#productdetail" href="#productdetail" role="tab"
                                                aria-selected="true">
                                                <i class="mdi mdi-library-books mr-1"></i> Detail</a>
                                        </li>



                                        <li class="nav-item">
                                            <a class="nav-link" id="product-reviews-tab" data-bs-toggle="tab"
                                                data-bs-target="#productreviews" href="#productreviews" role="tab"
                                                aria-selected="false">
                                                <i class="mdi mdi-star-half mr-1"></i> Reviews</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent2">
                                        <div class="tab-pane pt-3 fade show active" id="productdetail" role="tabpanel">

                                            <p class="mt-5">{!! $product->full_details !!}
                                            </p>

                                        </div>



                                        <div class="tab-pane pt-3 fade" id="productreviews" role="tabpanel">
                                            <div class="ec-t-review-wrapper">
                                                @foreach ($reviews as $review)
                                                    <div class="ec-t-review-item">
                                                        <div class="ec-t-review-avtar">

                                                            <!-- Default avatar image -->
                                                            <img src="{{ url('/') }}/admin/assets/img/review-image/Default_pfp.jpg"
                                                                alt="Default Avatar">

                                                        </div>
                                                        <div class="ec-t-review-content">
                                                            <div class="ec-t-review-top">
                                                                <p class="ec-t-review-name">{{ $review->name }}</p>
                                                                <div class="ec-t-rate">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <i
                                                                            class="mdi mdi-star {{ $i <= $review->rating ? 'is-rated' : '' }}"></i>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <div class="ec-t-review-bottom">
                                                                <p>{{ $review->review_message }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
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
