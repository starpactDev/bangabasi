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
							<form class="row g-3" id="editBlogForm" enctype="multipart/form-data">
								@csrf
								@method('PUT') 
								<input type="hidden" name="id" value="{{ $blog->id }}"> <!-- Include the blog ID -->

								<div class="row">
									<div class="col-md-12 col-lg-6">
										<div class="col-sm-12 mb-3 mt-3">
											<label class="form-label">Title</label>
											<input type="text" class="form-control" name="title" value="{{ old('title', $blog->blog_head) }}" required>
										</div>
										<div class="col-sm-12 mb-3 mt-3">
											<label class="form-label">Slug</label>
											<input type="text" class="form-control" name="slug" value="{{ old('slug', $blog->slug) }}" required>
										</div>
										<div class="col-sm-12 mb-3 mt-3">
											<label class="form-label">Tags</label>
											<textarea class="form-control" rows="4" id="tags" name="tags" placeholder="Enter tags separated by commas">{{ old('tags', $blog->tags) }}</textarea>
											<span class="error-message" id="error-tags" style="color: red;"></span>
										</div>
									</div>
									<div class="col-md-12 col-lg-6">
										<div class="col-sm-12 mb-3 mt-3">
											<label class="form-label">Current Image</label>
											<div>
												@if($blog->image)
													<img src="{{ asset('user/uploads/blogs/'.$blog->image) }}" alt="Current Image" style="max-width: 100%; height: auto;">
												@else
													<p>No image uploaded.</p>
												@endif
											</div>
										</div>
									</div>
									<div class="col-md-6 mb-3 mt-3">
										<label class="form-label">New Image (optional)</label>
										<input type="file" class="form-control" name="image">
									</div>
									<div class="col-md-6 mb-3 mt-3">
										<label class="form-label">Author</label>
										<input type="text" class="form-control" name="author" value="{{ old('author', $blog->author_name) }}" required>
									</div>
									<div class="col-md-12 mb-3 mt-3">
										<label class="form-label">Blog Description</label>
										<textarea class="form-control summernote" rows="4" id="summernote" name="blogs_description" required>{{ old('blogs_description', $blog->blog_description) }}</textarea>
									</div>
									<div class="col-md-9 mb-3 mt-3">
									</div>
								</div>
								<div class="col-md-3 mb-3 mt-3">
									<button type="submit" class="btn btn-primary">Update Blog</button>
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
	<script id="editBlog">
		document.getElementById('editBlogForm').addEventListener('submit', function(e) {
			e.preventDefault();

			// Get the blog ID from the hidden input field
			const blogId = document.querySelector('input[name="id"]').value;

			// Create FormData from the form
			const formData = new FormData(this);

			// Make the AJAX request
			fetch(`/admin/blogs/update/${blogId}`, {
				method: 'POST', // Note: Laravel requires a POST method with `_method: PUT`
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}',
				},
				body: formData,
			})
			.then(response => response.json())
			.then(data => {
				if (data.status === 'success') {
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: data.message,
					}).then(() => {
						location.reload();
					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'Failed to update blog. Please try again.',
					});
				}
			})
			.catch(error => {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'An error occurred. Please try again.',
				});
			});
		});

	</script>
@endpush
