@extends('superuser.layouts.master')



@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper breadcrumb-contacts">
                <div>
                    <h1>User Profile</h1>
                    <p class="breadcrumbs"><span><a href="">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span>Profile
                    </p>
                </div>
                <div>
                    
                </div>
            </div>
            <div class="card bg-white profile-content">
                <div class="row">
                    <div class="col-lg-4 col-xl-3">
                        <div class="profile-content-left profile-left-spacing">
                            <div class="text-center widget-profile px-0 border-0">
                                <div class="card-img mx-auto rounded-circle">
                                    <!-- Check if the user has an image; if not, show default image -->
                                    <img src="{{ $user->image ? asset('user/uploads/profile/' . $user->image) : asset('admin/assets/img/user/u1.jpg') }}" alt="user image" class="rounded-circle">
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
                        <div class="profile-content-left profile-left-spacing mt-4">
                            <div class="text-center widget-profile px-0 border-0">
                                <div class="card-img mx-auto rounded-circle">
                                    <!-- Check if the seller has a logo; if not, show a default image -->
                                    <img src="{{ optional($user->seller)->logo ? asset('user/uploads/seller/logo/' . optional($user->seller)->logo) : asset('admin/assets/img/default-store.png') }}" alt="store logo" class="rounded-circle" height="100">                                </div>
                                <div class="card-body">
                                    <!-- Store Name -->
                                    @if(optional($user->seller)->store_name)
                                        <h4 class="py-2 text-dark">{{ optional($user->seller)->store_name }}</h4>
                                    @else
                                        <h4 class="py-2 text-dark">No Store Name</h4>
                                    @endif
                        
                                    <!-- Store Email -->
                                    @if(optional($user->seller)->email)
                                        <p>{{ optional($user->seller)->email }}</p>
                                    @else
                                        <p>No Seller Email</p>
                                    @endif
                                </div>
                            </div>
                        
                            <hr class="w-100">
                        
                            <div class="contact-info pt-4">
                                <h5 class="text-dark">Seller Details</h5>
                        
                                @if(optional($user->seller)->description)
                                    <p class="text-dark font-weight-medium pt-24px mb-2">Description</p>
                                    <p>{{ optional($user->seller)->description }}</p>
                                @endif
                        
                                <p class="text-dark font-weight-medium pt-24px mb-2">Registration Step</p>
                                <p>{{ optional($user->seller)->registration_step ?? 'Not Started' }}</p>
                        
                                <p class="text-dark font-weight-medium pt-24px mb-2">Status</p>
                                <p>
                                    @if(optional($user->seller)->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        

                    </div>

                    <div class="col-lg-8 col-xl-9">
                        <div class="profile-content-right profile-right-spacing py-5">
                            <ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myProfileTab" role="tablist">

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Settings</button>
                                </li>
                            </ul>
                            <div class="tab-content px-3 px-xl-5" id="myTabContent">
                                <div class="tab-pane fade  show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                                    <div class="tab-pane-content mt-5">
                                        <form id="updateProfileForm" method="POST" action="{{ route('superuser.updateProfile') }}" enctype="multipart/form-data">

                                            @csrf
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
                                                        <input type="text" class="form-control" id="firstName" name="firstname" value="{{ $user->firstname }}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="lastName">Last Name</label>
                                                        <input type="text" class="form-control" id="lastName" name="lastname" value="{{ $user->lastname }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="form-group mb-4">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                            </div>

                                            <!-- Contact Number -->
                                            <div class="form-group mb-4">
                                                <label for="contactNumber">Contact Number</label>
                                                <input type="text" class="form-control" id="contactNumber" name="contact_number" value="{{ $user->contact_number }}">
                                            </div>

                                            <!-- Phone Number (Optional) -->
                                            <div class="form-group mb-4">
                                                <label for="phoneNumber">Phone Number (Optional)</label>
                                                <input type="text" class="form-control" id="phoneNumber" name="phone_number" value="{{ $user->phone_number }}">
                                            </div>

                                            @if($user->usertype === 'seller')
                                                <hr>
                                                <h4 class="mb-3">Seller Information</h4>
                                                
                                                <!-- Store Name -->
                                                <div class="form-group mb-4">
                                                    <label for="store_name">Store Name</label>
                                                    <input type="text" class="form-control" id="store_name" name="store_name" value="{{ optional($user->seller)->store_name ?? '' }}">
                                                </div>
                                                
                                                <!-- Seller Email -->
                                                <div class="form-group mb-4">
                                                    <label for="seller_email">Seller Email</label>
                                                    <input type="email" class="form-control" id="seller_email" name="seller_email" value="{{ optional($user->seller)->email ?? '' }}">
                                                </div>
                                                
                                                <!-- Description -->
                                                <div class="form-group mb-4">
                                                    <label for="description">Store Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3">{{ optional($user->seller)->description ?? '' }}</textarea>
                                                </div>
                                                
                                                <!-- Seller Logo Upload -->
                                                <div class="form-group row mb-6">
                                                    <label for="logo" class="col-sm-4 col-lg-2 col-form-label">Store Logo</label>
                                                    <div class="col-sm-8 col-lg-10">
                                                        <div class="custom-file mb-1">
                                                            <input type="file" class="custom-file-input" id="logo" name="logo">
                                                            <label class="custom-file-label" for="logo">Choose file...</label>
                                                            <div class="invalid-feedback">Please upload a valid logo file.</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                

                                                <!-- GST Details -->
                                                @if ($gst)
                                                    <h5 class="mt-4">GST / UID Details</h5>
                                                    @if ($gst->gst_number)
                                                        <div class="form-group mb-3">
                                                            <label for="gst_number">GST Number</label>
                                                            <input type="text" class="form-control" id="gst_number" name="gst_number" value="{{ optional($gst)->gst_number ?? '' }}">
                                                        </div>
                                                    @endif
                                                    @if ($gst->business_name)
                                                        <div class="form-group mb-3">
                                                            <label for="business_name">Business Name</label>
                                                            <input type="text" class="form-control" id="business_name" name="business_name" value="{{ optional($gst)->business_name ?? '' }}">
                                                        </div>
                                                    @endif
                                                    @if ($gst->business_type)
                                                        <div class="form-group mb-3">
                                                            <label for="business_type">Business Type</label>
                                                            <input type="text" class="form-control" id="business_type" name="business_type" value="{{ optional($gst)->business_type ?? '' }}">
                                                        </div>
                                                    @endif
                                                    @if ($gst->legal_name)
                                                        <div class="form-group mb-4">
                                                            <label for="legal_name">Legal Name</label>
                                                            <input type="text" class="form-control" id="legal_name" name="legal_name" value="{{ optional($gst)->legal_name ?? '' }}">
                                                        </div>
                                                    @endif
                                                    @if ($gst->uin)
                                                        <div class="form-group mb-4 mt-4">
                                                            <label for="legal_name">UID Number</label>
                                                            <input type="text" class="form-control" id="legal_name" name="legal_name" value="{{ optional($gst)->uin ?? '' }}">
                                                        </div>
                                                    @endif
                                                @endif

                                                <!-- Bank Details -->
                                                @if($bank)
                                                    <h5 class="mt-4">Bank Details</h5>
                                                    <div class="form-group mb-3">
                                                        <label for="bank_name">Bank Name</label>
                                                        <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ optional($bank)->bank_name ?? '' }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label for="branch_name">Branch Name</label>
                                                        <input type="text" class="form-control" id="branch_name" name="branch_name" value="{{ optional($bank)->branch_name ?? '' }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label for="ifsc_code">IFSC Code</label>
                                                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" value="{{ optional($bank)->ifsc_code ?? '' }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label for="account_number">Account Number</label>
                                                        <input type="text" class="form-control" id="account_number" name="account_number" value="{{ optional($bank)->account_number ?? '' }}">
                                                    </div>

                                                    <div class="form-group mb-4">
                                                        <label for="account_holder_name">Account Holder Name</label>
                                                        <input type="text" class="form-control" id="account_holder_name" name="account_holder_name" value="{{ optional($bank)->account_holder_name ?? '' }}">
                                                    </div>
                                                @endif

                                                <!-- Pickup Address -->
                                                @if($pickupAddress)
                                                    <h5 class="mt-4">Pickup Address</h5>
                                                
                                                    <!-- Building -->
                                                    <div class="form-group mb-3">
                                                        <label for="building">Building</label>
                                                        <input type="text" class="form-control" id="building" name="building" value="{{ optional($pickupAddress)->building ?? '' }}">
                                                    </div>
                                                
                                                    <!-- Street -->
                                                    <div class="form-group mb-3">
                                                        <label for="street">Street</label>
                                                        <input type="text" class="form-control" id="street" name="street" value="{{ optional($pickupAddress)->street ?? '' }}">
                                                    </div>
                                                
                                                    <!-- Locality -->
                                                    <div class="form-group mb-3">
                                                        <label for="locality">Locality</label>
                                                        <input type="text" class="form-control" id="locality" name="locality" value="{{ optional($pickupAddress)->locality ?? '' }}">
                                                    </div>
                                                
                                                    <!-- Landmark (Optional) -->
                                                    <div class="form-group mb-3">
                                                        <label for="landmark">Landmark (Optional)</label>
                                                        <input type="text" class="form-control" id="landmark" name="landmark" value="{{ optional($pickupAddress)->landmark ?? '' }}">
                                                    </div>
                                                
                                                    <!-- Pincode -->
                                                    <div class="form-group mb-3">
                                                        <label for="pincode">Pincode</label>
                                                        <input type="text" class="form-control" id="pincode" name="pincode" value="{{ optional($pickupAddress)->pincode ?? '' }}">
                                                    </div>
                                                
                                                    <!-- City -->
                                                    <div class="form-group mb-3">
                                                        <label for="city">City</label>
                                                        <input type="text" class="form-control" id="city" name="city" value="{{ optional($pickupAddress)->city ?? '' }}">
                                                    </div>
                                                
                                                    <!-- State -->
                                                    <div class="form-group mb-4">
                                                        <label for="state">State</label>
                                                        <input type="text" class="form-control" id="state" name="state" value="{{ optional($pickupAddress)->state ?? '' }}">
                                                    </div>
                                                @endif
                                            
                                            @endif

                                        
                                            <!-- Old Password -->
                                            <div class="form-group mb-4">
                                                <label for="oldPassword">Old Password</label>
                                                <input type="password" class="form-control" id="oldPassword" name="old_password">
                                            </div>

                                            <!-- New Password -->
                                            <div class="form-group mb-4">
                                                <label for="newPassword">New Password</label>
                                                <input type="password" class="form-control" id="newPassword" name="new_password">
                                            </div>

                                            <!-- Confirm Password -->
                                            <div class="form-group mb-4">
                                                <label for="conPassword">Confirm Password</label>
                                                <input type="password" class="form-control" id="conPassword" name="con_password">
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="d-flex justify-content-end mt-5">
                                                <button type="submit" class="btn btn-primary mb-2 btn-pill">Update Profile</button>
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
            const url = $(this).attr('action');

            const oldPassword = $('#oldPassword').val().trim();
            const newPassword = $('#newPassword').val().trim();
            const conPassword = $('#conPassword').val().trim();

            //  Only validate if any password field is touched
            const isChangingPassword = oldPassword || newPassword || conPassword;

            if (isChangingPassword) {
                if (!oldPassword) {
                    return Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Please enter your old password to change the password!',
                    });
                }

                if (newPassword.length < 6) {
                    return Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'New password must be at least 6 characters long!',
                    });
                }

                if (newPassword !== conPassword) {
                    return Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'New password and confirm password do not match!',
                    });
                    }
                    }
                
            

            // 🔃 Loading Spinner
            Swal.fire({
                title: 'Updating...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Prepare form data
            const formData = new FormData(this);

            // Submit the form using AJAX
            $.ajax({
                url: url,

                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),},
                success: function(response) {
                    console.log("AJAX Success Response:", response); // 
                    if (response.success) {
                        console.log(response.message);
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
                        console.log(xhr.responseJSON);

                            var errorMessages = '';
                            var errorMessages = '';

                        var errorMessages = '';

                        $.each(errors, function(key, value) {
                            errorMessages += value[0] + '<br>';
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Errors',
                            html: errorMessages,
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
