@extends('superuser.layouts.master')

@section('head')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
@endsection

@section('content')
<style>
	.border {
		border: 1px solid #e5e7eb;
	}

	.w-full {
		width: 100%;
	}

	.min-h-36 {
		min-height: 9rem;
	}

	.bg-slate-100 {
		background-color: #f1f5f9;
	}

	.my-6 {
		margin-top: 1.5rem;
		margin-bottom: 1.5rem;
	}

	.px-6 {
		padding-left: 1.5rem;
		padding-right: 1.5rem;
	}

	.flex {
		display: flex;
	}

	.items-center {
		align-items: center;
	}

	.gap-x-3 {
		column-gap: 0.75rem;
	}

	.py-4 {
		padding-top: 1rem;
		padding-bottom: 1rem;
	}

	.w-6 {
		width: 1.5rem;
	}
	.w-11-12 {
		width: 91.66%;
	} 
	.mx-auto{
		margin-left: auto;
		margin-right: auto;
	}
	.block {
		display: block;
	}

	.border-b-2 {
		border-bottom: 2px solid #e5e7eb;
	}

	.border-t-2 {
		border-top: 2px solid #e5e7eb;
	}

	.font-semibold {
		font-weight: 600;
	}

	.text-orange-600 {
		color: #e95d2a;
	}


</style>
	<div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
                <div>
                    <h1>Edit Sidebar</h1>
                    <p class="breadcrumbs"><span><a href="{{ route('admin_dashboard') }}">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>Sidebar
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin_viewproduct') }}" class="btn btn-primary"> View All Products
                    </a>
                </div>
            </div>
				
            <div class="row">
				<div class="col-xl-8 col-lg-6">
					<div class="row">
						<div class="col-xl-4 col-lg-12">
							<h4 class="mb-4 text-center">First Dialog</h4>
							<div id="quillEditor1" style="height: 100px;"></div>
							<button class="btn btn-primary my-2 mx-auto" data-editor="1">Submit</button>
						</div>
						<div class="col-xl-4 col-lg-12">
							<h4 class="mb-4 text-center">Second Dialog</h4>
							<div id="quillEditor2" style="height: 100px;"></div>
							<button class="btn btn-primary my-2 mx-auto" data-editor="2">Submit</button>
						</div>
						<div class="col-xl-4 col-lg-12">
							<h4 class="mb-4 text-center">Third Dialog</h4>
							<div id="quillEditor3" style="height: 100px;"></div>
							<button class="btn btn-primary my-2 mx-auto" data-editor="3">Submit</button>
						</div>
					</div>
					<form id="sidebarForm" enctype="multipart/form-data" class=" my-6 bg-slate-100 px-6 py-4">
						<div class="row">
							<div class="col-md-12 col-lg-6">
								<div class="mb-4">
									<label for="main_image" class="block font-semibold mb-2">Upload Main Image:</label>
									<input type="file" id="main_image" name="main_image" accept="image/*" class="w-full border border-gray-300 rounded px-3 py-2">
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="mb-4">
									<label for="svg_1" class="block font-semibold mb-2">Upload SVG for Dialog 1:</label>
									<input type="file" id="svg_1" name="svg_1" accept=".svg" class="w-full border border-gray-300 rounded px-3 py-2">
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="mb-4">
									<label for="svg_2" class="block font-semibold mb-2">Upload SVG for Dialog 2:</label>
									<input type="file" id="svg_2" name="svg_2" accept=".svg" class="w-full border border-gray-300 rounded px-3 py-2">
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="mb-4">
									<label for="svg_3" class="block font-semibold mb-2">Upload SVG for Dialog 3:</label>
									<input type="file" id="svg_3" name="svg_3" accept=".svg" class="w-full border border-gray-300 rounded px-3 py-2">
								</div>
							</div>
							<div class="col-md-12">
								<div class="text-center">
									<button type="submit" class="btn btn-primary">Upload</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				
				<div class="col-xl-4 col-lg-6 sticky-container" >
					<div class="w-11-12 mx-auto " id="rightSidebar">
						
					</div>
        		</div>
			</div>
        </div>
	</div>

<script id="loadSide">

	document.addEventListener('DOMContentLoaded', function() {
		fetch('/product-sidebar')
			.then(response => {
				if (!response.ok) {
					throw new Error('Network response was not ok');
				}
				return response.json();
			})
			.then(data => {
				// Populate the sidebar with the received data
				const sidebarContainer = document.getElementById('rightSidebar'); // Change this to your actual sidebar container ID
				if (sidebarContainer) {
					sidebarContainer.innerHTML = `
						<img src="${data.main_image}" alt="Main Image" class="w-full">
						<div class="min-h-36 bg-slate-100 my-6 px-6">
							${data.dialogs.map(dialog => `
								<div class="flex items-center gap-x-3 py-4">
									${dialog.svg}
									<p>${dialog.text}</p>
								</div>
							`).join('')}
						</div>
					`;
				}
			})
			.catch(error => {
				console.error('Error fetching sidebar data:', error);
			});
	});

</script>	
<script>
	const quillEditors = [];

	quillEditors[0] = new Quill('#quillEditor1', {
		theme: 'snow',
		placeholder: 'Get Free Shipping over all order above ₹500.',
		modules: {
			toolbar: [
				['bold', 'italic', 'underline'],
				[{ 'color': ['#ea580c'] }],
				['link'],
				['clean'] 
			]
		}
	});

	quillEditors[1] = new Quill('#quillEditor2', {
		theme: 'snow',
		placeholder: 'Gurranteed Money Back within 30 days return to your bank account.',
		modules: {
			toolbar: [
				['bold', 'italic', 'underline'],
				[{ 'color': ['#ea580c'] }],
				['link'],
				['clean'] 
			]
		}
	});

	quillEditors[2] = new Quill('#quillEditor3', {
		theme: 'snow',
		placeholder: '10 days return in case you change your mind.',
		modules: {
			toolbar: [
				['bold', 'italic', 'underline'],
				[{ 'color': ['#ea580c'] }],
				['link'],
				['clean'] 
			]
		}
	});

</script>

<script id="updateText">
	document.querySelectorAll('.btn-primary').forEach((button, index) => {
		button.addEventListener('click', () => {
			
			console.log(quillEditors)
			const dataEditor = button.getAttribute('data-editor');
			const editorIndex = dataEditor - 1;
			const quillEditor = quillEditors[editorIndex];
			
			const content = quillEditor.root.innerHTML;

			// Prepare the data to be sent
			const data = {
				content: content,
				editor: dataEditor, // To identify which editor is being submitted
			};

			// Send the data to the backend
			fetch("{{ route('admin_sidebar.updateText') }}", {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel CSRF token
				},
				body: JSON.stringify(data)
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					alert('Content submitted successfully!');
				} else {
					alert('Submission failed. Please try again.');
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('An error occurred. Please try again.');
			});
		});
	});
</script>

<script id="uploadImage">
	document.getElementById('sidebarForm').addEventListener('submit', function(event) {
		event.preventDefault();

		const formData = new FormData(this);

		fetch("{{ route('admin_sidebar.updateFiles') }}", {
			method: 'POST',
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			},
			body: formData
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				alert('Files uploaded successfully!');
			} else {
				alert('File upload failed. Please try again.');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			alert('An error occurred during file upload.');
		});
	});
</script>

@endsection