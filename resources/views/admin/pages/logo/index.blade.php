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
                    <h1>Logo</h1>
                    <p class="breadcrumbs"><span><a href="">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span> Logo
                    </p>
                </div>
                <div>

                </div>
            </div>

			<div class="row px-4 gap-4">
                @foreach ($logos as $index => $logo)
                <div class="col-md-12 border shadow mb-4">
                    <form action="{{ route('logos.update', $logo->id) }}" method="POST" class="d-flex align-items-center justify-content-between p-4" enctype="multipart/form-data">
                        @csrf
                        <div class="position-relative d-inline-block">
                            <input type="hidden" name="logo_id" id="" value="{{$logo->id}}">
                            <img id="uploadedImage-{{ $index }}" src="/user/uploads/logos/{{ $logo->image_path }}" alt="Uploaded Image" class="img-thumbnail " style=" height: 7rem; object-fit: cover; background-color:gray">
                            <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{ $index }}').click()" style="opacity: 0.8;">
                                Select
                            </button>
                            <input type="file" name="image" id="imageUpload-{{ $index }}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedImage-{{ $index }}')">
                        </div>
                        <div class="text-right">
                            <h4>{{ ucwords(str_replace('_', ' ', $logo->location)) }}</h4>
                            <button class="btn btn-success my-4">Update</button>
                        </div>
                    </form>
                </div>
                @endforeach

			</div>


        </div> <!-- End Content -->
    </div> <!-- End Content Wrapper -->
@endsection

@push('script')
<script id="interactiveImage">
    function previewImage(event, targetId) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById(targetId);
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Success Message
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        // Validation Errors
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                showConfirmButton: true
            });
        @endif
    });
</script>

@endpush
