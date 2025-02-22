@extends('superuser.layouts.master')



@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper breadcrumb-contacts">
                <div>
                    <h1>User Profile</h1>
                    <p class="breadcrumbs"><span><a href="index.html">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>Profile
                    </p>
                </div>
                <div>
                    <a href="user-list.html" class="btn btn-primary">Edit</a>
                </div>
            </div>
            <div class="card bg-white profile-content">
                <div class="row">
                    <div class="col-lg-4 col-xl-3">
                        <div class="profile-content-left profile-left-spacing">
                            <div class="text-center widget-profile px-0 border-0">
                                <div class="card-img mx-auto rounded-circle">
                                    <!-- Check if the user has an image; if not, show default image -->
                                    <img src="{{ $user->image ? asset('user/uploads/profile/' . $user->image) : asset('admin/assets/img/user/u1.jpg') }}"
                                        alt="user image" class="rounded-circle">
                                </div>
                                <div class="card-body">
                                    <!-- Check if the user has a first and last name -->
                                    @if ($user->firstname || $user->lastname)
                                        <h4 class="py-2 text-dark">{{ $user->firstname }} {{ $user->lastname }}</h4>
                                    @else
                                        <h4 class="py-2 text-dark">No Name Available</h4>
                                    @endif

                                    <!-- Check if the user has an email -->
                                    @if ($user->email)
                                        <p>{{ $user->email }}</p>
                                    @else
                                        <p>No Email Available</p>
                                    @endif
                                </div>
                            </div>

                            <hr class="w-100">

                            <div class="contact-info pt-4">
                                <h5 class="text-dark">Contact Information</h5>

                                <!-- Check if the user has an email -->
                                @if ($user->email)
                                    <p class="text-dark font-weight-medium pt-24px mb-2">Email address</p>
                                    <p>{{ $user->email }}</p>
                                @endif

                                <!-- Check if the user has a phone number -->
                                @if ($user->phone)
                                    <p class="text-dark font-weight-medium pt-24px mb-2">Phone Number</p>
                                    <p>{{ $user->phone }}</p>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-8 col-xl-9">
                        <div class="profile-content-right profile-right-spacing py-5">
                            <ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myProfileTab" role="tablist">

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="settings-tab" data-bs-toggle="tab"
                                        data-bs-target="#settings" type="button" role="tab" aria-controls="settings"
                                        aria-selected="false">Settings</button>
                                </li>
                            </ul>
                            <div class="tab-content px-3 px-xl-5" id="myTabContent">



                                <div class="tab-pane fade  show active" id="settings" role="tabpanel"
                                    aria-labelledby="settings-tab">
                                    <div class="tab-pane-content mt-5">
                                        <form id="updateProfileForm">
                                            <!-- User Image -->
                                            <div class="form-group row mb-6">
                                                <label for="coverImage" class="col-sm-4 col-lg-2 col-form-label">User Image</label>
                                                <div class="col-sm-8 col-lg-10">
                                                    <div class="custom-file mb-1">
                                                        <input type="file" class="custom-file-input" id="coverImage" name="image">
                                                        <label class="custom-file-label" for="coverImage">Choose file...</label>
                                                        <div class="invalid-feedback">Example invalid custom file feedback</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- First Name & Last Name -->
                                            <div class="row mb-2">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="firstName">First Name</label>
                                                        <input type="text" class="form-control" id="firstName"
                                                            name="firstname" value="{{ $user->firstname }}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="lastName">Last Name</label>
                                                        <input type="text" class="form-control" id="lastName"
                                                            name="lastname" value="{{ $user->lastname }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="form-group mb-4">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $user->email }}">
                                            </div>

                                            <!-- Contact Number -->
                                            <div class="form-group mb-4">
                                                <label for="contactNumber">Contact Number</label>
                                                <input type="text" class="form-control" id="contactNumber"
                                                    name="contact_number" value="{{ $user->contact_number }}">
                                            </div>

                                            <!-- Phone Number (Optional) -->
                                            <div class="form-group mb-4">
                                                <label for="phoneNumber">Phone Number (Optional)</label>
                                                <input type="text" class="form-control" id="phoneNumber"
                                                    name="phone_number" value="{{ $user->phone_number }}">
                                            </div>

                                            <!-- Old Password -->
                                            <div class="form-group mb-4">
                                                <label for="oldPassword">Old Password</label>
                                                <input type="password" class="form-control" id="oldPassword"
                                                    name="old_password">
                                            </div>

                                            <!-- New Password -->
                                            <div class="form-group mb-4">
                                                <label for="newPassword">New Password</label>
                                                <input type="password" class="form-control" id="newPassword"
                                                    name="new_password">
                                            </div>

                                            <!-- Confirm Password -->
                                            <div class="form-group mb-4">
                                                <label for="conPassword">Confirm Password</label>
                                                <input type="password" class="form-control" id="conPassword"
                                                    name="con_password">
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="d-flex justify-content-end mt-5">
                                                <button type="submit" class="btn btn-primary mb-2 btn-pill">Update
                                                    Profile</button>
                                            </div>
                                        </form>

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
    <script>
        // JavaScript to handle file input label change
        document.addEventListener('DOMContentLoaded', function() {
    var fileInput = document.getElementById('coverImage');
    var fileLabel = document.querySelector('label.custom-file-label[for="coverImage"]');
    

    fileInput.addEventListener('change', function() {
        var fileName = fileInput.files.length > 0 ? fileInput.files[0].name : 'Choose file...';
        fileLabel.textContent = fileName;
    });
});
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Handle form submission
            $('#updateProfileForm').on('submit', function(e) {
                e.preventDefault();

                // Basic validation
                var oldPassword = $('#oldPassword').val();
                var newPassword = $('#newPassword').val();
                var conPassword = $('#conPassword').val();

                if (newPassword || conPassword) {
                    if (!oldPassword) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please enter your old password to change the password!',
                        });
                        return;
                    }

                    if (newPassword !== conPassword) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'New password and confirm password do not match!',
                        });
                        return;
                    }

                    if (newPassword.length < 6) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'New password must be at least 6 characters long!',
                        });
                        return;
                    }
                }

                // Prepare form data
                var formData = new FormData(this);

                // Submit the form using AJAX
                $.ajax({
                    url: '{{ route('admin.updateProfile') }}', // The route where form will be submitted
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Profile Updated',
                                text: response.message,
                            }).then(() => {
                                // Optionally reload or redirect after success
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessages = '';

                            $.each(errors, function(key, value) {
                                errorMessages += value[0] +
                                '\n'; // Concatenate all error messages
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Errors',
                                text: errorMessages,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while updating your profile.',
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
