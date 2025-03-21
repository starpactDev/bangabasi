@extends("layouts.master")

@section('head')
<title>Bangabasi | Authentication</title>
@endsection

@section("content")

<section class="auth-body md:min-h-screen flex justify-center items-center py-8">
    <div class="auth-container bg-transparent w-3/5 min-h-96 min-w-96 rounded-lg shadow-xl flex flex-wrap gap-y-4">
        <div class="flex-1 min-w-80 min-h-96 bg-white flex flex-col items-center justify-evenly p-6 order-2">
            @if(isset($logos['3']))
            <img src="{{ asset('user/uploads/logos/' . $logos['3']->image_path) }}" alt="This was a logo" class="h-20">
            @endif

            <div id="authUp" class="auth-cont hidden">
                <h2 class="w-full text-xl font-medium border-b-2 py-2 hover:text-orange-500">
                    <span class="border-b-4 border-orange-500 px-4 py-2">Register</span>
                </h2>

                {{-- Register Form --}}
                <form id="register_form" action="" class="my-4" autocomplete="on">
                    @csrf
                    <div class="w-full border leading-10 rounded my-4">
                        <label for="firstname-up" class="px-2 text-orange-500">
                            <img src="/images/icons/person.svg" alt="" class="inline text-range-500 w-4 h-4">
                        </label>
                        <input id="firstname-up" name="firstname" type="text" class="inline focus:outline-none" placeholder="First Name" autocomplete="given-name">
                    </div>

                    <div class="w-full border leading-10 rounded my-4">
                        <label for="lastname-up" class="px-2 text-orange-500">
                            <img src="/images/icons/person.svg" alt="" class="inline text-range-500 w-4 h-4">
                        </label>
                        <input id="lastname-up" name="lastname" type="text" class="inline focus:outline-none" placeholder="Last Name" autocomplete="family-name">
                    </div>
                    <p id="firstname_error" class="text-red-600 text-sm"></p>
                    <p id="lastname_error" class="text-red-600 text-sm"></p>

                    <div class="w-fit border leading-10 rounded mt-4">
                        <label for="phone_number-up" class="px-2 text-orange-500">
                            <img src="/images/icons/phone.svg" alt="" class="inline text-range-500 w-4 h-4">
                        </label>
                        <input id="phone_number-up" name="phone_number" type="tel" class="w-72 inline focus:outline-none" placeholder="Insert Your Phone Number" autocomplete="tel">
                    </div>

                    <p id="phone_number_error" class="text-red-600 text-sm"></p>

                    <div class="w-fit border leading-10 rounded mt-4">
                        <label for="email-up" class="px-2 text-orange-500">
                            <img src="/images/icons/email.svg" alt="" class="inline text-range-500 w-4 h-4">
                        </label>
                        <input id="email-up" name="email" type="email" class="w-72 inline focus:outline-none" placeholder="Insert Your Email" autocomplete="email">
                    </div>

                    <p id="email_error" class="text-red-600 text-sm"></p>

                    <div class="w-fit border leading-10 rounded my-4">
                        <label for="password-up" class="px-2 text-orange-500">
                            <img src="/images/icons/key.svg" alt="" class="inline text-range-500 w-4 h-4">
                        </label>
                        <input id="password-up" name="password" type="password" class="w-72 inline focus:outline-none" placeholder="Password" autocomplete="new-password">
                    </div>

                    <p id="password_error" class="text-red-600 text-sm"></p>

                    <div class="w-fit border leading-10 rounded my-4">
                        <label for="password_confirmation-up" class="px-2 text-orange-500">
                            <img src="/images/icons/lock.svg" alt="" class="inline text-range-500 w-4 h-4">
                        </label>
                        <input id="password_confirmation-up" name="password_confirmation" type="password" class="w-72 inline focus:outline-none" placeholder="Confirm Password" autocomplete="new-password">
                    </div>

                    <div class="w-80 leading-4 my-4 flex">
                        <input name="terms" type="checkbox" class="focus:outline-none" id="terms-up">
                        <label for="terms-up" class="px-2">I agree to <a href="{{ route('terms') }}" class="text-orange-500 hover:underline">terms and conditions</a>.</label>
                    </div>

                    <p id="terms_error" class="text-red-600 text-sm"></p>

                    <div class="w-full leading-16 rounded my-4">
                        <input type="submit" class="g-recaptcha w-full h-12 cursor-pointer border-orange-600 border-2 hover:bg-orange-600 hover:text-white leading-16" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" data-callback='onSubmit' data-action='submit' value="Create an Account">
                    </div>
                </form>
                {{-- Register Form --}}

                <p class="text-center text-slate-800 text-sm">You already have an account? <span class="text-orange-600 cursor-pointer" onClick="authLoad('In')">Sign In</span></p>
            </div>


            <div id="authIn" class="auth-cont">
                <h2 class="w-full text-xl font-medium border-b-2 py-2 hover:text-orange-500">
                    <span class="border-b-4 border-orange-500 px-4 py-2">Sign In</span>
                </h2>

                {{-- Login Form --}}
                <form id="login_form" action="" method="POST" class="my-4" autocomplete="on">
                    @csrf
                    <div class="w-fit border leading-10 rounded">
                        <label for="email-in" class="px-2 text-orange-500">
                            <img src="/images/icons/email.svg" alt="" class="inline text-range-500 w-4 h-4">
                        </label>
                        <input id="email-in" name="email" type="email" class="w-72 inline focus:outline-none" placeholder="Insert Your Email" autocomplete="email">
                    </div>

                    <div class="w-fit border leading-10 rounded my-4">
                        <label for="password-in" class="px-2 text-orange-500">
                            <img src="/images/icons/key.svg" alt="" class="inline text-range-500 w-4 h-4">
                        </label>
                        <input id="password-in" name="password" type="password" class="w-72 inline focus:outline-none" placeholder="Password" autocomplete="current-password">
                    </div>

                    <div id="authErr" class="p-1 text-red-600 text-sm hidden">
                        Error
                    </div>

                    <div class="w-80 leading-4 my-4 flex">
                        <input name="remember" type="checkbox" class="focus:outline-none" id="remember-in">
                        <label for="remember-in" class="px-2 text-orange-500">Remember me</label>
                    </div>

                    <div class="w-full leading-16 rounded my-4">
                        <input type="submit" class="w-full h-12 cursor-pointer border-orange-600 border-2 hover:bg-orange-600 hover:text-white leading-16" value="Sign In">
                    </div>
                </form>

                {{-- Register link --}}
                <p class="text-center text-slate-800 text-sm">New to Bangabasi? <span class="text-orange-600 cursor-pointer" onClick="authLoad('Up')">Register</span></p>
            </div>


            <div id="authReset" class="auth-cont hidden">
                <form action="{{ route('send-otp') }}" method="POST" id="Reset" autocomplete="on">
                    @csrf
                    <h2 class="w-full text-lg font-medium border-b-2 py-2 hover:text-orange-500 mb-2">
                        <span class="border-b-4 border-orange-500 px-4 py-2">Forgot Password?</span>
                    </h2>
                    <p class="text-sm text-neutral-700 mt-2 mb-4">Enter the email address associated with your account</p>
                    <div class="w-fit border leading-10 rounded">
                        <label for="email-reset" class="px-2 text-orange-500">
                            <img src="/images/icons/email.svg" alt="" class="inline text-range-500 w-4 h-4">
                        </label>
                        <input id="email-reset" name="email" type="email" class="w-72 inline focus:outline-none" placeholder="Insert Your Email" autocomplete="email">
                    </div>
                    <div class="w-full leading-16  rounded my-4">
                        <input type="submit" class="w-full h-12 cursor-pointer border-orange-600 border-2 hover:bg-orange-600 hover:text-white leading-16" value="Request OTP">
                    </div>
                </form>
            </div>


            <button class="text-sm text-blue-500" id="authResetBtn">Forgot Password?</button>
            @if(session('error'))
                <p class="text-red-600 text-sm">{{ session('error') }}</p>
            @endif
        </div>
        <div class="hidden md:block flex-1 min-w-80 min-h-96 right order-1">
            <div class="swiper welcome h-full">
                <div class="swiper-wrapper">
                    <div class="swiper-slide p-6">
                        <div class="h-full">
                            <div class="h-full max-w-full overflow-hidden">
                                <img src="/images/posters/poster_3.jpg" alt="" class="mx-auto w-auto rounded-md overflow-hidden">
                                <div class="my-16 text-white text-center">
                                    <h4 class="py-6 font-medium">Discover Indian Craftsmanship</h4>
                                    <p class="text-sm">Explore the finest of Indian craftsmanship, all in one place.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide p-6">
                        <div class="h-full">
                            <div class="h-full max-w-full overflow-hidden">
                                <img src="/images/posters/poster_2.png" alt="" class="mx-auto w-auto rounded-md overflow-hidden">
                                <div class="my-16 text-white text-center">
                                    <h4 class="py-6 ">Elevate Your Style.</h4>
                                    <p class="text-sm">Find trendy garments, jewelry, and home decor that embody Indian tradition</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide p-6">
                        <div class="h-full">
                            <div class="h-full max-w-full overflow-hidden">
                                <img src="/images/posters/poster_1.png" alt="" class="mx-auto w-auto rounded-md overflow-hidden">
                                <div class="my-16 text-white text-center">
                                    <h4 class="py-6 ">Revive Your Fashion</h4>
                                    <p class="text-sm">Join us and refresh your wardrobe with unique, handcrafted designs.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination "></div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')

<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#login_form").submit(function(e) {
        e.preventDefault();
        $("#authErr").hide();

        $.post("/login", $(this).serialize())
            .done(function(data) {
                if (data.message === "success") {
                    window.location = data.redirect_url || "/";
                } else {
                    $("#authErr").html(data.message).show();
                }
            })
            .fail(function(data) {
                let errorMessage = data.responseJSON?.message || "An error occurred.";
                $("#authErr").html(errorMessage).show();
                console.log("fail", data);
            });
    });

    $("#register_form").submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        console.log(formData)
    })
</script>


<script>
    function onSubmit(token) {
        let form = document.getElementById("register_form");
        if (!form) {
            console.error("Form not found");
            return;
        }

        // Add reCAPTCHA token as a hidden input
        let input = document.createElement("input");
        input.type = "hidden";
        input.name = "g-recaptcha-response";
        input.value = token;
        form.appendChild(input);

        // Manually trigger the existing form submission logic
        handleFormSubmit();
    }

    function handleFormSubmit() {
        let form = document.getElementById("register_form");
        let formData = new FormData(form);

        // First, clear any existing error messages
        clearErrors();

        fetch("/register", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.message === "success") {
                    window.location = "/myprofile";
                } else if (data.errors) { // Check for validation errors
                    // Display validation errors
                    Object.keys(data.errors).forEach(key => {
                        let errorElement = document.getElementById(`${key}_error`);
                        if (errorElement) {
                            errorElement.textContent = data.errors[key].join(' ');
                            errorElement.classList.remove('hidden'); // If using classes for visibility
                        }
                    });
                } else {
                    document.getElementById("authErr").innerHTML = data.message;
                }
            })
            .catch(error => {
                console.error("Request failed:", error);
                document.getElementById("authErr").innerHTML = "An unexpected error occurred.";
            });
    }

    // Helper function to clear errors
    function clearErrors() {
        const errorElements = document.querySelectorAll('[id$="_error"]');
        errorElements.forEach(element => {
            element.textContent = '';
            element.classList.add('hidden'); // If using classes for visibility
        });
    }

    document.getElementById("register_form").addEventListener("submit", function(e) {
        e.preventDefault();
        grecaptcha.execute();
    });
</script>

<script id="authResetScript">
    const authResetBtn = document.getElementById('authResetBtn');
    const authReset = document.getElementById('authReset');
    const authIn = document.getElementById('authIn');
    const authUp = document.getElementById('authUp');

    if (authResetBtn && authIn && authReset && authUp) {
        authResetBtn.addEventListener('click', () => {
            authIn.classList.add('hidden');
            authUp.classList.add('hidden');
            authResetBtn.classList.add('hidden');
            authReset.classList.remove('hidden');
        })
    }
</script>

<script id="authResetSubmit">
    // Add an event listener to the form to handle form submission
    document.getElementById('Reset').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get the email input value
        const email = document.getElementById('email-reset').value;
        const authReset = document.getElementById('authReset');

        const resetForm = document.getElementById('Reset');

        // Create an object to hold the data to be sent
        const formData = new FormData();
        formData.append('email', email);
        formData.append('_token', resetForm.querySelector('input[name="_token"]').value); // CSRF token

        // Use fetch to send the data
        fetch(resetForm.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // Assuming the server returns JSON
            .then(data => {
                if (data.success) {
                    // Handle success: Show OTP form, timer, and resend option
                    authReset.innerHTML = '';
                    showOtpForm(data);
                } else {
                    // Handle failure: Display error message
                    alert('Something went wrong. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
    });

    function showOtpForm(data) {
        // Get the DOM holder where we will display the OTP form
        const otpHolder = document.createElement('div');
        otpHolder.classList.add('otp-holder');

        // Create OTP input form and other elements
        otpHolder.innerHTML = `
            <div class="otp-form">
                <h2 class="text-lg font-medium border-b-2 py-2 mb-2">
                    <span class="border-b-4 border-orange-500 px-4 py-2">Enter OTP</span>
                </h2>
                <p class="text-sm text-green-600 mt-2 mb-4">OTP has sent successfully, OTP is ${data.otp}. </p>
                
                <!-- OTP Form -->
                <form id="otp-form" action="" method="POST" onsubmit="submitOtpForm(event)">
                    <div class="w-fit border leading-10 rounded">
                        <label for="otp-input" class="px-2 text-orange-500">
                            <img src="/images/icons/email.svg" alt="" class="inline w-4 h-4">
                        </label>
                        <input id="otp-input" name="otp" type="text" class="w-72 inline focus:outline-none" placeholder="Enter OTP sent to your email" autocomplete="off">
                    </div>
                    <div class="w-full leading-16 rounded my-4">
                        <input type="submit" class="w-full h-12 cursor-pointer border-orange-600 border-2 bg-orange-500 hover:bg-orange-600 text-white leading-16" value="Submit OTP">
                    </div>
                </form>
            </div>
            <div class="timer-and-resend">
                <p id="timer" class="text-sm text-neutral-700">You can request a new OTP in <span id="countdown">60</span> seconds.</p>
                <button id="resend-btn" class="w-full h-12 cursor-pointer border-orange-600 border-2 hover:bg-orange-600 hover:text-white leading-16 mt-2 hidden">Resend OTP</button>
            </div>
            `;

        // Append the OTP form holder to the DOM (to the existing parent element)
        document.getElementById('authReset').appendChild(otpHolder);

        // Start the countdown timer
        startCountdown();

        // Set up resend OTP button behavior
        document.getElementById('resend-btn').addEventListener('click', function() {
            // Send a request to resend OTP, similar to the first OTP request
            resendOtp(data);
        });
    }

    function startCountdown() {
        let timeLeft = 5;

        const timer = document.getElementById('timer');
        const countdownElement = document.getElementById('countdown');
        const resendButton = document.getElementById('resend-btn');

        const timerInterval = setInterval(function() {
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                countdownElement.textContent = '0';
                resendButton.classList.remove('hidden');
                timer.remove();
            } else {
                countdownElement.textContent = timeLeft;
                timeLeft--;
            }
        }, 1000);
    }

    function resendOtp(data) {
        const email = data.email; // Retrieve email from the data object
        const authReset = document.getElementById('authReset');

        // Send a fetch request to the same route to trigger the OTP resend
        fetch('/send-otp', { // Use the appropriate route (e.g., /send-otp)
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // CSRF token for Laravel
                },
                body: JSON.stringify({
                    email: email,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Handle success: Show a success message, reset the timer, and hide the resend button

                    // Reset the timer and hide the resend button
                    const resendButton = document.getElementById('resend-btn');
                    resendButton.classList.add('hidden'); // Hide the resend button

                    authReset.innerHTML = '',
                        showOtpForm(data);
                    // Restart the countdown
                    startCountdown();
                } else {
                    // Handle failure: Show an error message
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while resending OTP. Please try again.');
            });
    }

    function submitOtpForm() {
        event.preventDefault();
        const otpForm = document.getElementById('otp-form');
        const formData = new FormData(otpForm); // Collect form data
        const authReset = document.getElementById('authReset');

        fetch('/verify-otp', { // Adjust the route if necessary
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // CSRF token for Laravel
                },
                body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {


                // Clear the OTP form
                document.getElementById('authReset').innerHTML = '';

                // Create a new form to set the new password
                const newPasswordForm = `
                                <form id="new-password-form" method="POST">
                                    <h2 class="text-lg font-medium border-b-2 py-2 mb-2">
                                        <span class="border-b-4 border-orange-500 px-4 py-2">Set New Password</span>
                                    </h2>

                                    <div class="w-fit border leading-10 rounded">
                                        <label for="new-password" class="px-2 text-orange-500">
                                            <img src="/images/icons/email.svg" alt="" class="inline w-4 h-4">
                                        </label>
                                        <input id="new-password" name="new-password" type="password" class="w-72 inline focus:outline-none" placeholder="Enter your new password" autocomplete="off">
                                    </div>
                                    <div class="w-fit border leading-10 rounded mt-4">
                                        <label for="confirm-password" class="px-2 text-orange-500">
                                            <img src="/images/icons/email.svg" alt="" class="inline w-4 h-4">
                                        </label>
                                        <input id="new-password_confirmation" name="new-password_confirmation" type="password" class="w-72 inline focus:outline-none" placeholder="Confirm your new password" autocomplete="off">
                                    </div>
                                    <div class="w-full leading-16 rounded my-4">
                                        <input type="submit" class="w-full h-12 cursor-pointer border-orange-600 border-2 bg-orange-500 hover:bg-orange-600 text-white leading-16" value="Set New Password">
                                    </div>
                                </form>
                            `;

                // Insert the new form into the 'authReset' element
                authReset.innerHTML = newPasswordForm;

            } else {
                
                let errorMessage = document.getElementById('otp-error'); // Look for an existing error message

                if (errorMessage) {
                    // If the error message element exists, just update its textContent
                    errorMessage.textContent = data.message;
                } else {
                    // If no error message exists, create and append a new one
                    errorMessage = Object.assign(document.createElement('div'), {
                        textContent: data.message,
                        className: 'text-red-600 text-center mt-4',
                        id: 'otp-error'
                    });
                    authReset.appendChild(errorMessage);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('There was an error verifying the OTP');
        });
    }

    function submitNewPasswordForm(event) {
        alert('Submitting new password form');
        event.preventDefault(); // Prevent default form submission

        setTimeout(() => {
            const newPasswordForm = document.getElementById('new-password-form');
            if (!newPasswordForm) {
                console.error('New password form not found.');
                return;
            }

            const formData = new FormData(newPasswordForm);
            formData.append('_token', document.querySelector('input[name="_token"]').value); // CSRF token

            const authReset = document.getElementById('authReset');
            console.log(newPasswordForm);
            console.log(formData);

            fetch('/set-new-password', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    authReset.innerHTML = '<p class="text-green-600 text-center">Password has been successfully reset. You can now <a href="{{route('login')}}">log in</a>.</p>';
                } else {
                    let errorMessage = document.getElementById('password-error');
                    if (errorMessage) {
                        errorMessage.textContent = data.message;
                    } else {
                        errorMessage = Object.assign(document.createElement('div'), {
                            textContent: data.message,
                            className: 'text-red-600 text-center mt-4',
                            id: 'password-error'
                        });
                        authReset.appendChild(errorMessage);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('There was an error setting your new password.');
            });
        }, 100); // Delay execution slightly
    }


    // Attach event listener after the form is inserted dynamically
    document.addEventListener('submit', function(event) {
        if (event.target && event.target.id === 'new-password-form') {
            submitNewPasswordForm(event);
        }
    });
</script>


@endpush