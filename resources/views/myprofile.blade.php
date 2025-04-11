@extends('layouts.master')
@section('head')
    <title>Bangabasi | My profile</title>
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        use Illuminate\Support\Facades\Auth;
        $xpage = 'myprofile';
        $xprv = 'home';
        $user = Auth::user();
    @endphp
    <x-bread-crumb :page="$xpage" :previousHref="$xprv" />

    <x-navigation-tabs />

    <section id="profile" class="p-2 md:p-6 bg-gray-100 min-h-screen">
        <div class="container p-2 md:p-6 grid grid-cols-12 gap-12 overflow-x-hidden">
            <div class="col-span-12 lg:col-span-5 w-fit">
                <div class="flex p-2 md:p-4 justify-between items-center min-h-20 max-w-sm">
                    <h2 class="text-lg font-medium">My Profile</h2>
                    <button type="button" id="editButton" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-700">Edit Profile</button>
                </div>

                <!-- Profile Info -->
                <form id="updateProfileForm" class="mx-auto space-y-4 bg-white md:p-4  max-w-xs md:max-w-lg">
                    <!-- Profile Image Section -->
                    <div class="flex flex-col items-center py-4">
                        <label for="profileImage" class="relative">
                            <img id="profileImagePreview" src="{{ $user->image ? asset('user/uploads/profile/' . $user->image) : asset('admin/assets/img/user/u1.jpg') }}" alt="Profile Image" class="w-32 h-32 rounded-full border border-gray-300 object-cover">
                            <input id="profileImage" name="image" type="file" onchange="previewImage(event)" class="absolute inset-0 opacity-0 cursor-pointer" />
                        </label>
                    </div>
                    <!-- Name Fields (Side by Side) -->
                    <div class="md:flex gap-4">
                        <!-- First Name Box -->
                        <div class="input-container flex-1 border border-transparent rounded-lg px-4 py-2">
                            <label for="firstName" class="flex items-center px-2 text-orange-500">
                                <img src="/images/icons/person.svg" alt="Person Icon" class="w-4 h-4">
                            </label>
                            <input id="firstName" name="firstname" type="text" class="w-full p-2 focus:outline-none bg-transparent" placeholder="John" value="{{ $user->firstname }}" readonly />
                        </div>

                        <!-- Last Name Box -->
                        <div class="input-container flex-1 border border-transparent rounded-lg px-4 py-2">
                            <label for="lastName" class="flex items-center px-2 text-orange-500">
                                <img src="/images/icons/person.svg" alt="Person Icon" class="w-4 h-4">
                            </label>
                            <input id="lastName" name="lastname"type="text" class="w-full p-2 focus:outline-none bg-transparent" placeholder="Doe" value="{{ $user->lastname }}" readonly />
                        </div>
                    </div>

                    <!-- Phone Field -->
                    <div class="input-container flex border border-transparent rounded-lg px-4 py-2">
                        <label for="phone" class="flex items-center px-2 text-orange-500">
                            <img src="/images/icons/phone.svg" alt="Phone Icon" class="w-4 h-4">
                        </label>
                        <input id="phone" type="tel" class="flex-1 p-2 focus:outline-none bg-transparent" placeholder="123-456-7890" name="phone_number" value="{{ $user->phone_number }}" readonly />
                    </div>
                    <!-- Contact Number Field -->
                    <div class="input-container flex border border-transparent rounded-lg px-4 py-2">
                        <label for="contact" class="flex items-center px-2 text-orange-500">
                            <img src="/images/icons/phone.svg" alt="Phone Icon" class="w-4 h-4">
                        </label>
                        <input id="contact" type="tel" class="flex-1 p-2 focus:outline-none bg-transparent" placeholder="Contact Number" name="contact_number" value="{{ $user->contact_number }}" readonly />
                    </div>

                    <!-- Email Field -->
                    <div class="input-container flex border border-transparent rounded-lg px-4 py-2">
                        <label for="email" class="flex items-center px-2 text-orange-500">
                            <img src="/images/icons/email.svg" alt="Email Icon" class="w-4 h-4">
                        </label>
                        <input id="email" type="email" class="flex-1 p-2 focus:outline-none bg-transparent" placeholder="Insert Your Email" name="email" value="{{ $user->email }}" readonly />
                    </div>

                    <!-- Password Field -->
                    <div class="input-container flex border border-transparent rounded-lg px-4 py-2">
                        <label for="oldPassword" class="flex items-center px-2 text-orange-500">
                            <img src="/images/icons/key.svg" alt="Password Icon" class="w-4 h-4">
                        </label>
                        <input id="oldPassword" type="password" class="flex-1 p-2 focus:outline-none bg-transparent" placeholder="Old Password" value="" name="old_password" readonly />
                    </div>
                    <div class="input-container flex border border-transparent rounded-lg px-4 py-2">
                        <label for="newPassword" class="flex items-center px-2 text-orange-500">
                            <img src="/images/icons/key.svg" alt="Password Icon" class="w-4 h-4">
                        </label>
                        <input id="newPassword" type="password" class="flex-1 p-2 focus:outline-none bg-transparent" placeholder="New Password" value="" name="new_password" readonly />
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="input-container flex border border-transparent rounded-lg px-4 py-2">
                        <label for="conPassword" class="flex items-center px-2 text-orange-500">
                            <img src="/images/icons/lock.svg" alt="Confirm Password Icon" class="w-4 h-4">
                        </label>
                        <input id="conPassword" type="password" class="flex-1 p-2 focus:outline-none bg-transparent" placeholder="Confirm Password" name="con_password" value="" readonly />
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-4">
                        <div id="actionButtons" class="hidden">
                            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600">Update</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-span-12 lg:col-span-7  w-fit">
                <div class="flex md:p-4 justify-between items-center min-h-20 max-w-sm">
                    <h2 class="text-lg font-medium">Address</h2>
                    <button id="open-form-button" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none"> Add Address </button>
                </div>

                <!-- Saved Addresses Section -->
                <div id="saved-addresses" class="md:px-4 w-fit">
                    <div class="space-y-4">
                        @if (count($saved_address) == 0)
                            <h1 class="text-3xl font-bold text-center text-gray-500">No Saved Address There!</h1>
                        @else
                            <p>You have {{ count($saved_address) }} saved address</p>
                            @foreach ($saved_address as $address)
                                <article class="relative p-4 border rounded-md bg-gray-50 max-w-xs md:max-w-lg">
                                    <!-- Buttons for Edit and Remove -->
                                    <button class="absolute top-2 right-2 border border-blue-500 text-white px-2 py-1 rounded hover:bg-blue-100 focus:outline-none" onclick="editAddress(this)" data-id="{{ $address->id }}">
                                        <img src="/images/icons/pencil.svg" alt="" class="h-4">
                                    </button>
                                    <button class="absolute top-2 right-16 border border-red-500 text-white px-2 py-1 rounded hover:bg-red-100 focus:outline-none" data-id="{{ $address->id }}" onclick="removeAddress(this)">
                                        <img src="/images/icons/bin.svg" alt="" class="h-4">
                                    </button>

                                    <address class="max-w-72">
                                        <p class="font-semibold">{{ $address->firstname }} {{ $address->lastname }}</p>
                                        <p>{{ $address->street_name }}{{ $address->apartment ? ', Apt ' . $address->apartment : '' }}
                                        </p>
                                        <p>{{ $address->city }}, {{ $address->state }} {{ $address->pin }}</p>
                                        <p>{{ $address->country }}</p>
                                    </address>
                                    <div class="text-gray-600">
                                        <p>Phone: {{ $address->phone }}</p>
                                        <p>Email: {{ $address->email }}</p>
                                    </div>
                                </article>
                            @endforeach
                        @endif
                        <!-- Address Item -->

                        <!-- Repeat for additional addresses -->
                        <!-- Address Item -->

                    </div>
                </div>

                <!-- Address Input Form (Initially hidden) -->
                <div id="address-form" class="hidden bg-white p-4">
                    <h3 class="text-sm uppercase font-medium py-4">Add Address</h3>
                    <input type="text" id="first_name" class="w-full my-2 px-4 bg-transparent rounded-md leading-10 border focus:outline-none" placeholder="Enter your First Name">
                    <input type="hidden" id="address_id" value="">
                    <input type="text" id="last_name" class="w-full my-2 px-4 bg-transparent rounded-md leading-10 border focus:outline-none" placeholder="Enter your Last Name">
                    <input type="text" id="country" class="w-full my-2 px-4 bg-transparent rounded-md leading-10 border focus:outline-none" placeholder="Country">

                    <input type="text" id="street_name" class="w-full my-2 px-4 bg-transparent rounded-md leading-10 border focus:outline-none" placeholder="House number and street name">
                    <input type="text" id="apartment" class="w-full my-2 px-4 bg-transparent rounded-md leading-10 border focus:outline-none" placeholder="Apartment, suite, unit, etc (optional)">
                    <input type="text" id="city" class="w-full my-2 px-4 bg-transparent rounded-md leading-10 border focus:outline-none" placeholder="Town / City">
                    <input type="text" id="state" class="w-full my-2 px-4 bg-transparent rounded-md leading-10 border focus:outline-none" placeholder="State">
                    <input type="tel" id="address_phone" class="w-full my-2 px-4 bg-transparent rounded-md leading-10 border focus:outline-none" placeholder="Phone">
                    <input type="number" id="postcode" pattern="^\d{6}$"  class="w-full my-2 bg-transparent px-4 rounded-md leading-10 border focus:outline-none" placeholder="Postcode">
                    <input type="email" id="address_email"  class="w-full my-2 bg-transparent px-4 rounded-md leading-10 border focus:outline-none" placeholder="Email">
                    <input type="submit" id="submit_address" value="Add Address" class="w-full my-2 bg-orange-500 text-white px-4 rounded-md leading-10 hover:bg-orange-700 border focus:outline-none">
                </div>
            </div>

        </div>
    </section>
@endsection
@push('scripts')
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('profileImagePreview');

            // Check if a file was selected
            if (file) {
                const reader = new FileReader();
                
                // Event listener to update the image preview once the file is loaded
                reader.onload = function(e) {
                    preview.src = e.target.result; // Update the image preview with the selected file
                };
                
                // Read the selected file as a data URL
                reader.readAsDataURL(file);
            }
        }
    </script>
    <script>
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
                const formData = new FormData(this);

                // Submit the form using AJAX
                $.ajax({
                    url: '{{ route('user.updateProfile') }}', // The route where form will be submitted
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

    <script>
        function removeAddress(button) {
            var addressId = $(button).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to delete this address?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/user-address/${addressId}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                // Remove the address article from the DOM
                                $('#address-' + addressId).remove();
                                Swal.fire(
                                    'Deleted!',
                                    'Address deleted successfully.',
                                    'success'
                                );
                                // Optionally, reload the page to reflect the changes
                                window.location.reload();
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.error ||
                                    'An error occurred while deleting the address.',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'An error occurred. Please try again.',
                                'error'
                            );
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#submit_address').on('click', function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Determine if we're adding or updating an address
                var addressId = $('#address_id').val(); // Hidden input for the address ID
                var url = '';
                var type = '';

                if (addressId) {
                    // If address ID exists, we are updating
                    url = '/user-address-update/' + addressId; // Adjust to your update route
                    type = 'PUT'; // HTTP method for update
                } else {
                    // If no address ID, we are adding a new address
                    url = '/user-address-save'; // Adjust to your add route
                    type = 'POST'; // HTTP method for add
                }

                // Gather form data
                var formData = {
                    first_name: $('#first_name').val(),
                    last_name: $('#last_name').val(),
                    country: $('#country').val(),
                    street_name: $('#street_name').val(),
                    apartment: $('#apartment').val(),
                    city: $('#city').val(),
                    state: $('#state').val(),
                    phone: $('#address_phone').val(),
                    postcode: $('#postcode').val(),
                    email: $('#address_email').val(),
                };

                $.ajax({
                    url: url,
                    type: type,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: addressId ? 'Address updated successfully.' :
                                    'Address added successfully.', // Dynamic message
                            }).then(() => {
                                // Optionally reload the page or update the UI
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        var response = xhr.responseJSON;
                        if (response && response.errors) {
                            displayValidationErrors(response.errors);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred. Please try again.',
                            });
                        }
                    }
                });
            });

            function displayValidationErrors(errors) {
                // Clear previous errors
                $('.error').remove();

                // Iterate over errors and display under respective fields
                $.each(errors, function(field, messages) {
                    var input = $('#' + field);
                    input.addClass('border-red-500'); // Highlight the input field with an error class

                    // Append error messages under the field
                    messages.forEach(function(message) {
                        input.after('<div class="error text-red-500">' + message + '</div>');
                    });
                });
            }
        });
    </script>

    <script>
        function editAddress(button) {
            var addressId = $(button).data('id');

            // Use AJAX to fetch the address data based on the ID
            $.ajax({
                url: `/user-address/${addressId}/edit`, // Route to fetch the address data
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        console.log(response.data.email);
                        // Populate the form with the fetched data
                        $('#first_name').val(response.data.firstname);
                        $('#last_name').val(response.data.lastname);
                        $('#country').val(response.data.country);
                        $('#street_name').val(response.data.street_name);
                        $('#apartment').val(response.data.apartment);
                        $('#city').val(response.data.city);
                        $('#state').val(response.data.state);
                        $('#address_phone').val(response.data.phone);
                        $('#postcode').val(response.data.pin);
                        $('#address_email').val(response.data.email);

                        // Set the hidden address ID for updating
                        $('#address_id').val(addressId);
                        // Change the heading text to "Edit Address"
                        $('h3').text('Edit Address');
                        // Update the form action or handle the update in the submit function
                        $('#submit_address').val('Update Address');
                        $('#submit_address').data('id', addressId); // Save the ID for the update action

                        // Show the form for editing
                        $('#address-form').removeClass('hidden');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.error || 'Unable to fetch address data.'
                        });
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while fetching the address data.'
                    });
                }
            });
        }
    </script>
@endpush