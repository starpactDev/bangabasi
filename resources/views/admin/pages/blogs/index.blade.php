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
							
                            <div class="d-flex justify-content-between">
                                <h3>All Blogs</h3>
                                <a href="{{ route('admin.blogs.add') }}" class="btn btn-primary"> Add Blog</a>
                            </div>
							<div class="table-responsive">
								<table id="blogs-data-table" class="table" style="width:100%">
									<thead>
										<tr>
											<th>Image</th>
											<th>Blog Head</th>
                                            <th>Status</th>
											<th>Publish Date</th>
											<th>Action</th>
										</tr>
									</thead>

									<tbody>
										@foreach ($blogs as $blog)
										<tr>
											<!-- Blog Image Column -->
											<td>
												@if ($blog->image)
													<img class="tbl-thumb" src="{{ asset('user/uploads/blogs/' . $blog->image) }}" alt="Blog Image" style="width: 50px; height: 50px;">
												@else
													<p>No image available</p>
												@endif
											</td>

											<!-- Blog Head Column -->
											<td>{{ $blog->blog_head }}</td>

                                            <!-- Blog Status Column -->
                                            <td>
                                                <form action="{{ route('toggle.status', $blog->id) }}" method="POST" id="statusForm-{{ $blog->id }}">
                                                    @csrf
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input {{ $blog->status === 'published' ? 'bg-success' : '' }}" type="checkbox" role="switch" id="flexSwitchCheckDefault-{{ $blog->id }}" name="status"
                                                            {{ $blog->status === 'published' ? 'checked' : '' }} onchange="document.getElementById('statusForm-{{ $blog->id }}').submit();">
                                                        <label class="form-check-label" for="flexSwitchCheckDefault-{{ $blog->id }}">
                                                            <!-- No text, just a toggle -->
                                                        </label>
                                                    </div>
                                                </form>
                                            </td>


											<!-- Publish Date Column -->
											<td>
                                                @if ($blog->published_at)
                                                    {{ \Carbon\Carbon::parse($blog->published_at)->format('Y-m-d') }}
                                                @else
                                                    <form action="{{ route('publish.blog', $blog->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                                        <button type="submit" class="btn btn-success">Publish</button>
                                                    </form>
                                                @endif
                                            </td>


											<!-- Action Buttons Column -->
											<td>
												<div class="btn-group">
													<!-- View Button -->
													<a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-outline-primary">Edit</a>
													
													<!-- Delete Button in a Form with Confirmation -->
													<form id="deleteBlogForm{{ $blog->id }}" action="{{ route('admin.blogs.delete', $blog->id) }}" method="POST" style="display: inline-block;">
														@csrf
														@method('DELETE')
														<button type="button" class="btn btn-outline-danger deleteButton" data-form-id="{{ $blog->id }}">Delete</button>
													</form>
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

		</div>
	</div>
@endsection
@push('script')
<script>
    // JavaScript for handling delete confirmation
    document.querySelectorAll('.deleteButton').forEach(button => {
        button.addEventListener('click', function () {
            const blogId = this.getAttribute('data-form-id');
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform AJAX request for deletion
                    fetch(`/admin/blogs/delete/${blogId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: data.message,
                            });
                            location.reload();

                            // Remove the deleted blog's row from the table
                            const row = document.querySelector(`tr[data-id="blog-${blogId}"]`);
                            if (row) row.remove();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to delete blog. Please try again.',
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred. Please try again later.',
                        });
                    });
                }
            });
        });
    });
</script>

@endpush