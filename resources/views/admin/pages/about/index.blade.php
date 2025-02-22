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
                    <h1>About   </h1>
                    <p class="breadcrumbs"><span><a href="">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span> About Us
                    </p>
                </div>
                <div></div>
            </div>

            <div class="row px-4 gap-4">
                <!-- Breadcrumb Section -->
                <div class="col-md-12 border shadow mb-4">
                    <form action="{{ route('about.update') }}" method="POST" class="p-4" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="parentKey" value="breadcrumb">
                        <div class="mb-3">
                            <label for="head" class="form-label">Head</label>
                            <input type="text" class="form-control" id="head" name="head" value="{{ $about['breadcrumb']['head'] }}">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $about['breadcrumb']['description'] }}</textarea>
                        </div>
                        <div class="position-relative d-inline-block mb-3">
                            <img id="breadcrumbImage" src="/user/uploads/about/{{ $about['breadcrumb']['image'] }}" alt="Breadcrumb Image" class="img-thumbnail" style="height: 7rem; object-fit: cover; background-color:gray">
                            <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('breadcrumbImageUpload').click()" style="opacity: 0.8;">
                                Select
                            </button>
                            <input type="file" name="image" id="breadcrumbImageUpload" class="d-none" accept="image/*" onchange="previewImage(event, 'breadcrumbImage')">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
                <!-- Stories Section -->
                <div class="col-md-12 border shadow mb-4">
                    <form action="{{ route('about.stories.update') }}" method="POST" enctype="multipart/form-data" class="p-4">
                        @csrf
                        <!-- Hidden input for parentKey -->
                        <input type="hidden" name="parentKey" value="stories">

                        <div class="row gap-4">
                            @foreach ($about['stories'] as $key => $storyImage)
                            <div class="col-md-3 position-relative text-center">
                                <img id="uploadedStory-{{ $key }}" src="/user/uploads/about/{{ $storyImage }}" alt="Story Image" class="img-thumbnail mb-2" style="height: 7rem; object-fit: cover; background-color:gray">
                                <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('storyUpload-{{ $key }}').click()" style="opacity: 0.8;">
                                    Select
                                </button>
                                <input type="file" name="images[{{ $key }}]" id="storyUpload-{{ $key }}" class="d-none" accept="image/*" onchange="previewImage(event, 'uploadedStory-{{ $key }}')">
                                <h6>{{ ucwords(str_replace('_', ' ', $key)) }}</h6>
                            </div>
                            @endforeach
                        </div>

                        <!-- Submit button -->
                        <div class="text-right mt-4">
                            <button type="submit" class="btn btn-primary">Update All</button>
                        </div>
                    </form>
                </div>

				<!-- Team Members Section -->
				@php
					$key = 'founder';
					$member = $about['founder'];
				@endphp
				<div class="col-md-12 border shadow mb-4">
					<form action="{{ route('about.update') }}" method="POST" class="p-4" enctype="multipart/form-data">
						@csrf
                        <input type="hidden" name="parentKey" value="founder">
						<div class="mb-3">
							<label for="name-{{ $key }}" class="form-label">Name</label>
							<input type="text" class="form-control" id="name-{{ $key }}" name="name" value="{{ $member['name'] }}">
						</div>
						<div class="mb-3">
							<label for="role-{{ $key }}" class="form-label">Role</label>
							<input type="text" class="form-control" id="role-{{ $key }}" name="role" value="{{ $member['role'] }}">
						</div>
						<div class="mb-3">
							<label for="story-{{ $key }}" class="form-label">Story</label>
							<textarea class="form-control" id="story1-{{ $key }}" name="story1" rows="3">{{ $member['story1'] }}</textarea>
						</div>
                        <div class="mb-3">
							<label for="story-{{ $key }}" class="form-label">Story</label>
							<textarea class="form-control" id="story2-{{ $key }}" name="story2" rows="3">{{ $member['story2'] }}</textarea>
						</div>
						<div class="position-relative d-inline-block mb-3">
							<img id="image-{{ $key }}" src="/user/uploads/about/{{ $member['image'] }}" alt="{{ $member['name'] }} Image" class="img-thumbnail" style="height: 7rem; object-fit: cover; background-color:gray">
							<button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{ $key }}').click()" style="opacity: 0.8;">
								Select
							</button>
							<input type="file" name="image" id="imageUpload-{{ $key }}" class="d-none" accept="image/*" onchange="previewImage(event, 'image-{{ $key }}')">
						</div>
						<button type="submit" class="btn btn-primary">Update</button>
					</form>
				</div>
				@foreach(['member1', 'member2', 'member3', 'member4'] as $key)
                    @php
                        $member = $about[$key];
                    @endphp
                    <div class="col-md-12 border shadow mb-4">
                        <form action="{{ route('about.update') }}" method="POST" class="p-4" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="parentKey" value="{{ $key }}">
                            <div class="mb-3">
                                <label for="name-{{ $key }}" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name-{{ $key }}" name="name" value="{{ $member['name'] }}">
                            </div>
                            <div class="mb-3">
                                <label for="role-{{ $key }}" class="form-label">Role</label>
                                <input type="text" class="form-control" id="role-{{ $key }}" name="role" value="{{ $member['role'] }}">
                            </div>
                            <div class="mb-3">
                                <label for="story-{{ $key }}" class="form-label">Story</label>
                                <textarea class="form-control" id="story-{{ $key }}" name="story" rows="3">{{ $member['story'] }}</textarea>
                            </div>
                            <div class="position-relative d-inline-block mb-3">
                                <img id="image-{{ $key }}" src="/user/uploads/about/{{ $member['image'] }}" alt="{{ $member['name'] }} Image" class="img-thumbnail" style="height: 7rem; object-fit: cover; background-color:gray">
                                <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('imageUpload-{{ $key }}').click()" style="opacity: 0.8;">
                                    Select
                                </button>
                                <input type="file" name="image" id="imageUpload-{{ $key }}" class="d-none" accept="image/*" onchange="previewImage(event, 'image-{{ $key }}')">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                @endforeach

                <!-- our Story Section -->

                <div class="col-md-12 border shadow mb-4">
                    <form action="{{ route('about.update') }}" method="POST" class="p-4" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="parentKey" value="ourStory">
                        <div class="mb-3">
                            <label for="head" class="form-label">Heading</label>
                            <input type="text" class="form-control" id="head" name="head" value="{{ $about['ourStory']['head'] }}">
                        </div>
                        <div class="position-relative d-inline-block mb-3">
                            <img id="ourImage" src="/user/uploads/about/{{ $about['ourStory']['image'] }}" alt="our Story Image" class="img-thumbnail" style="height: 7rem; object-fit: cover; background-color:gray">
                            <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('ourImageUpload').click()" style="opacity: 0.8;">
                                Select
                            </button>
                            <input type="file" name="image" id="ourImageUpload" class="d-none" accept="image/*" onchange="previewImage(event, 'ourImage')">
                        </div>
                        <div class="mb-3">
                            <label for="text-1" class="form-label">Text 1</label>
                            <textarea class="form-control" id="text-1" name="text1" rows="2">{{ $about['ourStory']['text1'] }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="text-2" class="form-label">Text 2</label>
                            <textarea class="form-control" id="text-2" name="text2" rows="2">{{ $about['ourStory']['text2'] }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="text-3" class="form-label">Text 3</label>
                            <textarea class="form-control" id="text-3" name="text3" rows="2">{{ $about['ourStory']['text3'] }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="text-4" class="form-label">Text 4</label>
                            <textarea class="form-control" id="text-4" name="text4" rows="2">{{ $about['ourStory']['text4'] }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="list-1" class="form-label">List 1</label>
                            <input type="text" class="form-control" id="list1" name="list1" value="{{ $about['ourStory']['list1'] }}">
                        </div>
                        <div class="mb-3">
                            <label for="list-2" class="form-label">List 2</label>
                            <input type="text" class="form-control" id="list2" name="list2" value="{{ $about['ourStory']['list2'] }}">
                        </div>
                        <div class="mb-3">
                            <label for="list-3" class="form-label">List 3</label>
                            <input type="text" class="form-control" id="list3" name="list3" value="{{ $about['ourStory']['list3'] }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>

                <!-- We Do Section -->

                <div class="col-md-12 border shadow mb-4">
                    <form action="{{ route('about.update') }}" method="POST" class="p-4" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="parentKey" value="weDo">
                        <div class="position-relative d-inline-block mb-3">
                            <img id="weDoImage" src="/user/uploads/about/{{ $about['weDo']['image'] }}" alt="We Do Image" class="img-thumbnail" style="height: 7rem; object-fit: cover; background-color:gray">
                            <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('weDoImageUpload').click()" style="opacity: 0.8;">
                                Select
                            </button>
                            <input type="file" name="image" id="weDoImageUpload" class="d-none" accept="image/*" onchange="previewImage(event, 'weDoImage')">
                        </div>
                        <div class="mb-3">
                            <label for="weDoText" class="form-label">Head</label>
                            <input type="text" class="form-control" id="weDoHead" name="head" value="{{ $about['weDo']['head'] }}">
                        </div>
                        <div class="mb-3">
                            <label for="weDoText" class="form-label">Text</label>
                            <input type="text" class="form-control" id="weDoText" name="text" value="{{ $about['weDo']['text'] }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>


                <!-- Mission Vision Section -->

                <div class="col-md-12 border shadow mb-4">
                    <form action="{{ route('about.update') }}" method="POST" class="p-4" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="parentKey" value="missionVision">
                        <div class="position-relative d-inline-block mb-3">
                            <img id="missionVisionImage" src="/user/uploads/about/{{ $about['missionVision']['image'] }}" alt="Mission Vision Image" class="img-thumbnail" style="height: 7rem; object-fit: cover; background-color:gray">
                            <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('missionVisionImageUpload').click()" style="opacity: 0.8;">
                                Select
                            </button>
                            <input type="file" name="image" id="missionVisionImageUpload" class="d-none" accept="image/*" onchange="previewImage(event, 'missionVisionImage')">
                        </div>
                        <div class="mb-3">
                            <label for="missionVisionText" class="form-label">Head</label>
                            <input type="text" class="form-control" id="missionVisionHead" name="Head" value="{{ $about['missionVision']['head'] }}">
                        </div>
                        <div class="mb-3">
                            <label for="missionVisionText" class="form-label">Text</label>
                            <input type="text" class="form-control" id="missionVisionText" name="text" value="{{ $about['missionVision']['text'] }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>

                <!-- History Section -->

                <div class="col-md-12 border shadow mb-4">
                    <form action="{{ route('about.update') }}" method="POST" class="p-4" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="parentKey" value="history">
                        <div class="position-relative d-inline-block mb-3">
                            <img id="historyImage" src="/user/uploads/about/{{ $about['history']['image'] }}" alt="History Image" class="img-thumbnail" style="height: 7rem; object-fit: cover; background-color:gray">
                            <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('historyImageUpload').click()" style="opacity: 0.8;">
                                Select
                            </button>
                            <input type="file" name="image" id="historyImageUpload" class="d-none" accept="image/*" onchange="previewImage(event, 'historyImage')">
                        </div>
                        <div class="mb-3">
                            <label for="historyHead" class="form-label">Head</label>
                            <input type="text" class="form-control" id="historyText" name="text" value="{{ $about['history']['head'] }}">
                        </div>
                        <div class="mb-3">
                            <label for="historyText" class="form-label">Text</label>
                            <input type="text" class="form-control" id="historyText" name="text" value="{{ $about['history']['text'] }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>

                <!-- Schema Sections -->
                @foreach ([1, 2, 3, 4] as $schema)
                <div class="col-md-12 border shadow mb-4">
                    <form action="{{ route('about.update') }}" method="POST" class="p-4" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="parentKey" value="$schema{{ $schema }}">
                        <div class="position-relative d-inline-block mb-3">
                            <img id="schemaImage-{{ $schema }}" src="/user/uploads/about/{{ $about['$schema' . $schema]['image'] }}" alt="Schema {{ $schema }} Icon" class="img-thumbnail" style="height: 7rem; object-fit: cover; background-color:gray">
                            <button type="button" class="btn btn-primary btn-sm position-absolute top-50 start-50 translate-middle" onclick="document.getElementById('schemaImageUpload-{{ $schema }}').click()" style="opacity: 0.8;">
                                Select
                            </button>
                            <input type="file" name="image" id="schemaImageUpload-{{ $schema }}" class="d-none" accept="image" onchange="previewImage(event, 'schemaImage-{{ $schema }}')">
                        </div>
                        <div class="mb-3">
                            <label for="schemaHead-{{ $schema }}" class="form-label">Heading</label>
                            <input type="text" class="form-control" id="schemaHead-{{ $schema }}" name="head" value="{{ $about['$schema' . $schema]['head'] }}">
                        </div>
                        <div class="mb-3">
                            <label for="schemaDescription-{{ $schema }}" class="form-label">Description</label>
                            <textarea class="form-control" id="schemaDescription-{{ $schema }}" name="description" rows="2">{{ $about['$schema' . $schema]['description'] }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        
        forms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(form);
                //select the button with button type submit of that form
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.classList.remove('btn-primary');
                    submitButton.classList.add('btn-secondary');
                    submitButton.textContent = 'Submitting...'; // Change button text to "Submitting..."
                }
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        if (submitButton) {
                            submitButton.classList.remove('btn-secondary');
                            submitButton.classList.add('btn-success');
                            submitButton.textContent = 'Submitted'; // Change button text to "Submitted"
                            submitButton.disabled = true;
                        }
                        resetButtonState(submitButton);
                    } else {
                        console.error('Error submitting form');
                        if(submitButton) {
                            submitButton.classList.remove('btn-secondary');
                            submitButton.classList.add('btn-danger');
                            submitButton.textContent = 'Error'; // Change button text to "Error"
                            submitButton.disabled = true;
                        }
                        resetButtonState(submitButton);
                    }
                })
                .catch(() => {
                    console.error('Request failed');
                    if(submitButton) {
                        submitButton.classList.remove('btn-secondary');
                        submitButton.classList.add('btn-danger');
                        submitButton.textContent = 'Failed'; // Change button text to "Error"
                        submitButton.disabled = true;
                    }
                });
            });
        });
    });

    function resetButtonState(button) {
        setTimeout(() => {
            if (button) {
                button.classList.remove('btn-success', 'btn-danger');
                button.classList.add('btn-primary');
                button.textContent = 'Submit'; // Change button text back to "Submit"
                button.disabled = false;
            }
        }, 5000);
    }
</script>

@endpush