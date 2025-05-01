<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="/images/bangabasi_favicon.png" sizes="32x32" />
	<title>Bangabasi | Seller</title>
	@vite('resources/css/app.css')
	@stack('css')
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
	<style>
		/* Universal scrollbar styles */
		html {
			scrollbar-width: thin;
			scrollbar-color: #90caf9 #f0f4f8;
			scroll-behavior: smooth;
		}

		html,
		body,
		* {
			scrollbar-width: thin;
		}

		html::-webkit-scrollbar {
			width: 0.5rem;
			height: 0.5rem;
		}

		html::-webkit-scrollbar-track {
			background: #f0f4f8;
		}

		html::-webkit-scrollbar-thumb {
			background-color: #90caf9;
			border-radius: 0.25rem;
			border: none;
		}

		html::-webkit-scrollbar-thumb:hover {
			background-color: #64b5f6;
		}
	</style>
	<section class="min-h-screen grid grid-cols-12">
		<!-- Left Section -->
		@php
			$otpSent = session('otp_sent', false);
			$phoneNumber = session('phone_number', '');
		@endphp
		<div class="col-span-12 lg:col-span-5 flex items-center justify-center bg-slate-100 max-h-screen overflow-y-auto">
			<div class="w-full max-w-md p-6" >
				
				<h1 class="text-2xl font-bold text-gray-800 mb-2">Welcome to Bangabasi</h1>
				<p class="text-gray-600 mb-6">Create your account to start selling</p>
				
				<!-- Show error message if it exists -->
				@if (session('error'))
					<div class="text-red-500 text-xs mb-4">
						{{ session('error') }}
					</div>
				@endif
				<form action="{{ route('seller.send-otp') }}" method="POST" id="phone_number_section">
					@csrf
					<!-- Mobile Number Section -->
					<label class="block text-sm font-medium text-gray-700"></label>
					<div class="flex items-center space-x-2 mt-1">
						<input type="text" placeholder="Enter Mobile Number" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500" name="phone_number" value="{{ $phoneNumber }}"/>
						<button type="{{ $otpSent ? 'button' : 'submit' }}" class="w-max whitespace-nowrap text-white px-4 py-2 rounded-md  {{ $otpSent ? 'bg-green-400 cursor-not-allowed hover:bg-green-600' : 'bg-orange-500 hover:bg-orange-600'}}" id="send_otp" @if($otpSent) disabled @endif>{{ $otpSent ? 'OTP Sent!' : 'Send OTP' }}</button>
					</div>
					@error('phone_number')
						<p class="text-xs text-red-500 mt-1 ">{{$message}}</p>
					@enderror
					<p id="validationError" class="hidden text-sm text-red-600"></p>
				</form>

				<!-- OTP Section -->
				<form action="{{ route('seller.verify-otp') }}" id="otp_section" class="grayscale {{ $errors->has('otp') || $otpSent ? '' : 'hidden' }}">
					@csrf
					<!-- Inside the #otp_section form -->
					<input type="hidden" name="phone_number" id="hidden_phone_number" value="{{ $phoneNumber ?? '' }}">
					<label class="block text-sm font-medium text-gray-700 mt-4"></label>
					<div class="flex items-center space-x-2 mt-1 ">
						<input type="text" id="otp_input" placeholder="Enter OTP" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 {{ $otpSent ? '' :'cursor-not-allowed'}}" name="otp" {{ $otpSent ? '' : 'disabled' }}/>
						<button type="submit" class="w-max whitespace-nowrap bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 {{$otpSent ? '' : 'cursor-not-allowed'}}" id="verify_otp" {{ $otpSent ? '' : 'disabled' }}>Verify OTP</button>
					</div>
					<p class="text-xs text-red-500 mt-1 hidden" id="otp_error">OTP is not verified.</p>
					@error('otp')
						<p class="text-xs text-red-500 mt-1 ">{{$message}}</p>
					@enderror
				</form>
				
				<form action="{{ route('seller.register') }}" method="POST" enctype="multipart/form-data">
					@csrf

					<input type="hidden" name="phone_number" id="hidden_phone_number_at_main_form" value="{{ $phoneNumber ?? '' }}">
					<!-- Email Section -->
					<label class="block text-sm font-medium text-gray-700 mt-4"></label>
					<input type="email" placeholder="Email Id" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500" name="email"/>
					@error('email')
						<p class="text-xs text-red-500 mt-1 ">{{$message}}</p>
					@enderror

					<!-- Image Upload Section -->
					<label class="block text-sm font-medium text-gray-700 mt-4">Upload User Image</label>
					<div class="flex items-center space-x-4 mt-2">
						<div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border">
							<img id="logo_preview" src="{{ asset('images/bangabasi_logo_short.png') }}" alt="Logo Preview" class="object-cover w-full h-full">
						</div>
						<input type="file" id="logo_input" class="hidden" name="image" accept="image/*">
						<button type="button" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600" onclick="document.getElementById('logo_input').click()">Choose Image</button>
					</div>

					@error('logo')
						<p class="text-xs text-gray-500 mt-1">Allowed formats: JPG, JPEG, PNG (Max: 1MB)</p>
						<p class="text-xs text-red-500 mt-1">{{ $message }}</p>
					@enderror

					<!-- Password Section -->
					<label class="block text-sm font-medium text-gray-700 mt-4"></label>
					<div class="flex items-center space-x-2 mt-1 relative">
						<input type="password" placeholder="Set Password" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500" name="password"/>
						<button class="text-gray-500 hover:text-orange-500  absolute right-2">👁</button>
					</div>
					@error('password')
						<p class="text-xs text-red-500 mt-1 ">{{$message}}</p>
						<ul class="text-xs text-gray-500 mt-2 space-y-1">
							<li>Minimum 8 characters (letters & numbers)</li>
							<li>Minimum 1 special character (@ # $ % ! ^ & *)</li>
							<li>Minimum 1 capital letter (A-Z)</li>
							<li>Minimum 1 number (0-9)</li>
						</ul>
					@enderror

					<!-- Confirm Password Section -->
					<label class="block text-sm font-medium text-gray-700 mt-4"></label>
					<div class="flex items-center space-x-2 mt-1 relative">
						<input type="password" name="confirm_password" placeholder="Confirm Password" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
					</div>
					@error('confirm_password')
						<p class="text-xs text-red-500 mt-1">{{$message}}</p>
					@enderror
					@if ($errors->has('confirm_password'))
						<p class="text-xs text-red-500 mt-1">{{ $errors->first('confirm_password') }}</p>
					@endif
					

					

					<!-- Terms and Conditions -->
					<p class="text-xs text-gray-500 mt-4">
						By clicking you agree to our <a href="#" class="text-orange-500 hover:underline">Terms & Conditions</a> and <a href="#" class="text-orange-500 hover:underline">Privacy Policy</a>
					</p>
					<button type="submit" class="w-full my-6 p-4 text-white font-semibold bg-orange-600 hover:bg-orange-500">Create Account</button>
				
				</form>
			</div>

		</div>

		<!-- Right Section -->
		<div class="col-span-12 lg:col-span-7 h-dvh overflow-hidden relative py-4 md:px-12">
			<div class="text-right p-6">
				<p class="inline">Already a user?</p>
				<a href="{{ route('seller_login')}}" class="border border-orange-600 rounded px-6 py-2 mx-4 hover:bg-orange-100">Login</a >
			</div>
			<div class="w-full p-6 pt-0">
				<h2 class="text-2xl font-semibold text-gray-800 mb-6">Frequently Asked Questions</h2>
				<div class="space-y-4">
					<details class="group border border-gray-300 rounded-lg p-2 hover:bg-slate-100 transition-all duration-300">
						<summary class="text-lg font-medium text-gray-700 cursor-pointer flex justify-between items-center">
							<span>How do I register as a seller?</span>
							<span class="transition-transform duration-300 group-open:rotate-180">▼</span>
						</summary>
						<p class="text-sm text-gray-600 mt-2 pl-4">
							To register as a seller, click on the "Register" button on the homepage, fill out the form with your details, and submit.
						</p>
					</details>

					<details class="group border border-gray-300 rounded-lg p-2 hover:bg-slate-100 transition-all duration-300">
						<summary class="text-lg font-medium text-gray-700 cursor-pointer flex justify-between items-center">
							<span>What documents are required?</span>
							<span class="transition-transform duration-300 group-open:rotate-180">▼</span>
						</summary>
						<p class="text-sm text-gray-600 mt-2 pl-4">
							You need a valid ID, proof of business registration, and bank account details to complete your registration.
						</p>
					</details>

					<details class="group border border-gray-300 rounded-lg p-2 hover:bg-slate-100 transition-all duration-300">
						<summary class="text-lg font-medium text-gray-700 cursor-pointer flex justify-between items-center">
							<span>Is there a registration fee?</span>
							<span class="transition-transform duration-300 group-open:rotate-180">▼</span>
						</summary>
						<p class="text-sm text-gray-600 mt-2 pl-4">
							No, registration as a seller is completely free. You only pay a commission on successful sales.
						</p>
					</details>

					<details class="group border border-gray-300 rounded-lg p-2 hover:bg-slate-100 transition-all duration-300">
						<summary class="text-lg font-medium text-gray-700 cursor-pointer flex justify-between items-center">
							<span>How long does approval take?</span>
							<span class="transition-transform duration-300 group-open:rotate-180">▼</span>
						</summary>
						<p class="text-sm text-gray-600 mt-2 pl-4">
							Approval typically takes 1-2 business days after submitting all required documents.
						</p>
					</details>
				</div>
			</div>
			<img src="{{ asset('user/uploads/seller/seller-hero.png') }}" alt="" class="absolute bottom-0 right-1/2 translate-x-1/2 w-1/3">
		</div>
	</section>
</body>
<script id="otpInteraction" type="module">
	document.addEventListener("DOMContentLoaded", function() {
		const sendOtpButton = document.getElementById('send_otp'); // "Send OTP" button
		const otpField = document.getElementById('otp_input'); // OTP input field
		const verifyOtpButton = document.getElementById('verify_otp'); // "Verify OTP" button
		const otpSection = document.getElementById('otp_section'); // OTP section container
		const otpErrorMessage = document.getElementById('otp_error'); // OTP error message
		const otpSuccessMessage = document.createElement('p'); // Create success message
		otpSuccessMessage.textContent = "OTP Verified!";
		otpSuccessMessage.classList.add('text-xs', 'text-green-500', 'mt-1'); // Style success message

		const phoneNumberInput = document.querySelector('input[name="phone_number"]');
		const phoneNumberForm = document.getElementById('phone_number_section');
		const validationError = document.getElementById('validationError');

		const hiddenPhoneInput = document.getElementById('hidden_phone_number');
		const hidden_phone_number_at_main_form = document.getElementById('hidden_phone_number_at_main_form');

		// Hide OTP input field initially
		//otpField.disabled = true;

		// Handle Send OTP button click
		sendOtpButton.addEventListener("click", async function(event) {
			event.preventDefault();

			const phoneNumber = phoneNumberInput.value;

					// Basic frontend validation
			if (!/^\d{10}$/.test(phoneNumber)) {
				validationError.textContent = 'Please enter a valid 10-digit phone number.';
				validationError.classList.remove('hidden');
				return;
			} 
			else {
				validationError.classList.add('hidden');
				hiddenPhoneInput.value = phoneNumber;
			}

			try {
				const response = await fetch(phoneNumberForm.action, {
					method: 'POST',
					headers : {
						'Content-Type': 'application/json',
						'X-CSRF-TOKEN': '{{ csrf_token() }}'
					},
					body: JSON.stringify({ phone_number: phoneNumber })
				});

				const data = await response.json();

				if(response.ok){
					sendOtpButton.textContent = "OTP Sent!";
					sendOtpButton.disabled = true;
					sendOtpButton.classList.add("bg-green-400", "cursor-not-allowed");

					otpSection.classList.remove("hidden");
					otpSection.classList.remove("grayscale", "cursor-not-allowed");
					otpField.disabled = false;
					otpField.classList.remove("cursor-not-allowed");
					verifyOtpButton.disabled = false;
					verifyOtpButton.classList.remove("cursor-not-allowed", "bg-gray-400");
				}
				else{
					otpErrorMessage.textContent = error.message;
					otpErrorMessage.classList.remove('hidden');
				}
			}
			catch {
				otpErrorMessage.textContent = error.message;
				otpErrorMessage.classList.remove('hidden');
			}


		});


		// Handle Verify OTP button click
		verifyOtpButton.addEventListener("click", async function(event) {
			event.preventDefault();
			// Check if OTP is correct

			const response = await fetch(otpSection.action, {
				method : 'POST',
				headers : {
					'Content-Type': 'application/json',
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				},
				body: JSON.stringify({ otp: otpField.value, phone_number: hiddenPhoneInput.value })
			})
			const data = await response.json();

			if(response.ok){
				otpSection.appendChild(otpSuccessMessage);
				verifyOtpButton.textContent = "Verified!";
				verifyOtpButton.disabled = true;
				verifyOtpButton.classList.add("bg-green-500", "cursor-not-allowed");
				otpErrorMessage.classList.add('hidden'); // Hide error message if OTP is correct
				hidden_phone_number_at_main_form.value = hiddenPhoneInput.value;
			}
			else{
				otpErrorMessage.textContent = data.message;
				otpErrorMessage.classList.remove('hidden');
				
			}

		});

		
		// Interactive feedback on OTP field
		otpField.addEventListener("input", function() {
			if (otpField.value.length === 4) {
				otpSection.classList.remove("grayscale");
				verifyOtpButton.classList.add("bg-green-500");
				verifyOtpButton.textContent = "Verify";
			} else {
				verifyOtpButton.classList.remove("bg-green-500");
				verifyOtpButton.textContent = "Verify OTP";
			}
		});
  	});
</script>



<script id="togglePassword">
  document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.querySelector('input[type="password"]');
    const toggleButton = document.querySelector('.text-gray-500');

    toggleButton.addEventListener("click", function (event) {
      event.preventDefault();
      const isPasswordVisible = passwordInput.getAttribute("type") === "text";
      passwordInput.setAttribute("type", isPasswordVisible ? "password" : "text");
      toggleButton.textContent = isPasswordVisible ? "👁" : "🔒"; // Change icon if desired
    });
  });
</script>

<script id="previewImage">
    document.getElementById('logo_input').addEventListener('change', function (event) {
        const [file] = event.target.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                document.getElementById('logo_preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>

</html>