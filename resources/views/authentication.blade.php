@extends("layouts.master")

@section("content")

<section class="auth-body min-h-screen flex justify-center items-center py-8">
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
                <form action="" method="POST" id="Reset" autocomplete="on">
                    @csrf
                    <h2 class="w-full text-lg font-medium border-b-2 py-2 hover:text-orange-500 mb-2">
                        <span class="border-b-4 border-orange-500 px-4 py-2">Forgot Password?</span>
                    </h2>

                    <p class="text-sm text-neutral-700 my-2">Enter the email address associated with your account</p>
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

@endpush