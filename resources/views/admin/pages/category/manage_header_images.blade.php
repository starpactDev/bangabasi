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
                <h1>Manage Header Images for Category: {{ $category->name }}</h1>
                <p class="breadcrumbs">
                    <span><a href="{{ route('admin_dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Manage Category Images
                </p>
            </div>
            <div class="container">
             
            
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            
                <form action="{{ route('category.update.images', ['category' => $category->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        @foreach ($subCategories as $subCategory)
                            <div class="col-md-6 mb-4">
                                <div class="card p-3">
                                    <h5>{{ $subCategory->name }}</h5>
                
                                    {{-- Show Existing Image if Available --}}
                                    @php
                                        $existingImage = \App\Models\CategoryHeaderImage::where('category_id', $category->id)
                                                        ->where('sub_category', $subCategory->id)
                                                        ->first();
                                    @endphp
                
                                    @if ($existingImage)
                                        <div class="mb-2">
                                            <img src="{{ asset('user/uploads/category/header_image/' . $existingImage->title) }}" 
                                                 alt="Existing Image" 
                                                 class="img-fluid rounded" 
                                                 style="max-height: 150px;">
                                        </div>
                                    @endif
                
                                    {{-- Upload New Image --}}
                                    <input type="file" name="images[{{ $subCategory->id }}]" class="form-control mt-2">
                                </div>
                            </div>
                        @endforeach
                    </div>
                
                    <button type="submit" class="btn btn-primary">Save Images</button>
                </form>
            </div>
            <!-- Manage Category Images Modal -->
            <!-- Modal -->
         
<!-- Edit Image Modal -->

            <!-- Edit Category Image Modal -->



        </div> <!-- End Content -->
    </div>
@endsection

@push('script')



@endpush
