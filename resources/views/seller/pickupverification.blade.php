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
		<div class="col-span-12 lg:col-span-5 flex items-center justify-center max-h-screen overflow-y-auto">
			<form class="w-full max-w-md p-6 pt-32" action="{{ route('seller_pickup_submit')}}" method="POST">
				@csrf
				<h1 class="text-2xl font-bold text-gray-800 mb-2">Welcome to Bangabasi</h1>
				<p class="text-gray-600 mb-6">Verify Your Pickup Address to continue</p>
				<!-- Building/House Number -->
				<label class="block text-sm font-medium text-gray-700">Building/House Number</label>
				<input type="text" name="building" placeholder="Enter Building/House Number" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-4" required/>
				@error('building')
					<p class="text-xs text-red-500 mt-1">{{ $message }}</p>
				@enderror

				<!-- Street Address -->
				<label class="block text-sm font-medium text-gray-700">Street Address</label>
				<input type="text" name="street" placeholder="Enter Street Address"  class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-4" required/>
				@error('street')
					<p class="text-xs text-red-500 mt-1">{{ $message }}</p>
				@enderror

				<!-- Locality/Area -->
				<label class="block text-sm font-medium text-gray-700">Locality/Area</label>
				<input type="text" name="locality" placeholder="Enter Locality/Area" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-4" required/>
				@error('locality')
					<p class="text-xs text-red-500 mt-1">{{ $message }}</p>
				@enderror

				<!-- Landmark -->
				<label class="block text-sm font-medium text-gray-700">Landmark (Optional)</label>
				<input type="text" name="landmark" placeholder="Enter Nearby Landmark" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-4" required/>
				@error('landmark')
					<p class="text-xs text-red-500 mt-1">{{ $message }}</p>
				@enderror

				<!-- Pincode -->
				<label class="block text-sm font-medium text-gray-700">Pincode</label>
				<input type="text" name="pincode" placeholder="Enter Pincode" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-4" required/>
				@error('pincode')
					<p class="text-xs text-red-500 mt-1">{{ $message }}</p>
				@enderror

				<!-- City -->
				<label class="block text-sm font-medium text-gray-700">City</label>
				<input type="text" name="city" placeholder="Enter City" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-4" required/>
				@error('city')
					<p class="text-xs text-red-500 mt-1">{{ $message }}</p>
				@enderror

				<!-- State -->
				<label class="block text-sm font-medium text-gray-700" required>State</label>
				<select name="state" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-4">
					<option value="">Select State</option>
					<option value="West Bengal">West Bengal</option>
				</select>
				@error('state')
					<p class="text-xs text-red-500 mt-1">{{ $message }}</p>
				@enderror

				<button type="submit" class="w-full my-6 p-4 text-white font-semibold bg-orange-600 hover:bg-orange-500">Continue</button>
				
				@if($errors->any())
					<div class="text-sm text-red-500 mb-4">
						<ul>
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
			</form>
		</div>

		<!-- Right Section -->
		<div class="col-span-12 lg:col-span-7 h-dvh overflow-hidden relative">
			<div class="text-right p-8">
				<p class="inline">Already a user?</p>
				<a href="{{ route('seller_login')}}" class="border border-orange-600 rounded px-6 py-2 mx-4 hover:bg-orange-100">Login</a>
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

</html>