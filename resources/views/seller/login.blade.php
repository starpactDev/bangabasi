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
	<section class="min-h-screen grid grid-cols-12">
		<!-- Left Section -->
		<div class="col-span-12 lg:col-span-5 flex items-center justify-center bg-slate-100 h-dvh">
			<form class="w-full max-w-md p-6" action="{{ route('seller_login_submit') }}" method="POST">
				@csrf
				<h1 class="text-2xl font-bold text-gray-800 mb-2">Welcome Back to Bangabasi</h1>
				<p class="text-gray-600 mb-6">Login to your account to continue</p>

				<!-- Show error message if it exists -->
				@if (session('error'))
					<div class="text-red-500 text-xs mb-4">
						{{ session('error') }}
					</div>
				@endif
				
				<!-- Mobile Number Section -->
				<label class="block text-sm font-medium text-gray-700">Enter Mobile Number</label>
				<div class="flex items-center space-x-2 mt-1">
					<input type="text" name="phone_number" placeholder="Enter Mobile Number" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
				</div>
				@error('phone_number')
					<p class="text-xs text-red-500 mt-1">{{ $message }}</p>
				@enderror

				<!-- Password Section -->
				<label class="block text-sm font-medium text-gray-700 mt-4">Enter Password</label>
				<div class="flex items-center space-x-2 mt-1 relative">
					<input type="password" id="password" name="password" placeholder="Enter Password" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 " />
					<button id="togglePassword" class="text-sm text-orange-500 hover:underline absolute right-2">Show</button>
				</div>
				@error('password')
					<p class="text-xs text-red-500 mt-1">{{ $message }}</p>
				@enderror

				@if ($errors->has('login_error'))
					<p class="text-xs text-red-500 mt-1">{{ $errors->first('login_error') }}</p>
				@endif

				<!-- Forgot Password Link -->
				<div class="flex justify-end mt-2">
					<a href="#" class="text-sm text-orange-500 hover:underline">Forgot Password?</a>
				</div>

				<!-- Terms and Conditions -->
				<p class="text-xs text-gray-500 mt-4">
					By clicking you agree to our <a href="#" class="text-orange-500 hover:underline">Terms & Conditions</a> and <a href="#" class="text-orange-500 hover:underline">Privacy Policy</a>
				</p>

				<!-- Login Button -->
				<button type="submit" class="w-full my-6 p-4 text-white font-semibold bg-orange-600 hover:bg-orange-500">Login</button>

				<!-- Register Link -->
				<div class="text-center">
					<p class="text-sm text-gray-700">Don't have an account? <a href="{{ route('seller_registration')}}" class="text-orange-500 hover:underline">Create an account</a></p>
				</div>
			</form>
		</div>


		<!-- Right Section -->
		<div class="col-span-12 lg:col-span-7 flex items-end ">
			<img src="{{asset('user/uploads/seller/seller-hero.png')}}" alt="" class="object-cover w-full">
		</div>
	</section>
	<script id="passwordToggle">
		document.getElementById('togglePassword').addEventListener('click', function(event) {
			event.preventDefault();  // Prevent the default button behavior (form submission)

			const passwordInput = document.getElementById('password');
			const buttonText = document.getElementById('togglePassword');

			// Toggle the input type between password and text
			if (passwordInput.type === 'password') {
				passwordInput.type = 'text';
				buttonText.textContent = 'Hide';  // Change button text to "Hide"
			} else {
				passwordInput.type = 'password';
				buttonText.textContent = 'Show';  // Change button text to "Show"
			}
		});
	</script>
</body>

</html>