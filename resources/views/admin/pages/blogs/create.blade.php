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
                <h1>Manage Blogs</h1>
                <p class="breadcrumbs">
                    <span><a href="{{ route('admin_dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Manage Blogs
                </p>
            </div>
            <div class="row">
				<div class="col-xl-12 col-lg-12">
                    <div class="ec-cat-list card card-default">
                        <div class="card-body">
							<h3>Create a New Blog</h3>
							<form class="row g-3" id="createBlogForm">
								<div class="col-md-6 mb-3 mt-3">
									<label class="form-label">Title</label>
									<input type="text" class="form-control" name="title" value="">
									<span class="error-message" id="error-title" style="color: red;"></span>
								</div>
								
								<div class="col-md-6 mb-3 mt-3">
									<label class="form-label">Image</label>
									<input type="file" class="form-control" name="image" value="">
									<span class="error-message" id="error-image" style="color: red;"></span>
								</div>
								<div class="col-md-6 mb-3 mt-3">
									<label class="form-label">Author</label>
									<input type="text" class="form-control" name="author" value="">
									<span class="error-message" id="error-author" style="color: red;"></span>
								</div>
                                <div class="col-md-6 mb-3 mt-3">
                                    <label class="form-label">Tags</label>
                                    <textarea class="form-control" rows="4" id="tags" name="tags" placeholder="Enter tags separated by commas"></textarea>
                                    <span class="error-message" id="error-tags" style="color: red;"></span>
                                </div>
								<div class="col-md-12 mb-3 mt-3">
									<label class="form-label">Blogs Description</label>
									<textarea class="form-control summernote" rows="4" id="summernote" name="blogs_description"></textarea>
									<span class="error-message" id="error-blogs_description" style="color: red;"></span>
								</div>
								<div class="col-md-9 mb-3 mt-3">
								</div>
								<div class="col-md-3 mb-3 mt-3">
									<button type="submit" class="btn btn-primary">Create Blog</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
@endsection
@push('script')

<script id="submitBlog">
    $('#createBlogForm').on('submit', function(e) {
        e.preventDefault();

        // Clear previous error messages
        $('.error-message').text('');

        $.ajax({
            url: "{{ route('admin.blogs.create') }}",
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                }).then(function() {
                    $('#saleBannerModal').modal('hide');
                    window.location.href = "{{ route('admin.blogs.index') }}";
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Display validation errors
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        $('#error-' + field).text(messages[0]);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An unexpected error occurred. Please try again.',
                    });
                }
            }
        });
    });
</script>


@endpush