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
	<section class=" grid grid-cols-12">
		<!-- Left Section -->
		<div class="col-span-12 lg:col-span-5 flex items-center justify-center max-h-screen overflow-y-auto bg-slate-100">
			<form class="w-full max-w-md p-6 pt-20" action="{{ route('seller_bankverify')}}" method="POST">
				@csrf
				<h1 class="text-2xl font-bold text-gray-800 mb-2">Welcome to Bangabasi</h1>
				<p class="text-gray-600 mb-6">Verify Your Bank Details to continue</p>
				<!-- Bank Name -->
				<label class="block text-sm font-medium text-gray-700">Bank Name</label>
				<input type="text" name="bank_name" placeholder="Enter Bank Name" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-1" required/>
				@if ($errors->has('bank_name'))
					<p class="text-xs text-red-500 mb-4">{{ $errors->first('bank_name') }}</p>
				@endif
				
				<!-- Branch Name -->
				<label class="block text-sm font-medium text-gray-700">Branch Name</label>
				<input type="text" name="branch_name" placeholder="Enter Branch Name" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-1" required/>
				@if ($errors->has('branch_name'))
					<p class="text-xs text-red-500 mb-4">{{ $errors->first('branch_name') }}</p>
				@endif

				<!-- IFSC Code -->
				<label class="block text-sm font-medium text-gray-700">IFSC Code</label>
				<input type="text" name="ifsc_code" placeholder="Enter IFSC Code" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-1" required/>
				@if ($errors->has('ifsc_code'))
					<p class="text-xs text-red-500 mb-4">{{ $errors->first('ifsc_code') }}</p>
				@endif

				<!-- Account Number -->
				<label class="block text-sm font-medium text-gray-700">Account Number</label>
				<input type="text" name="account_number" placeholder="Enter Account Number" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-1" required/>
				@if ($errors->has('account_number'))
					<p class="text-xs text-red-500 mb-4">{{ $errors->first('account_number') }}</p>
				@endif

				<!-- Re-enter Account Number -->
				<label class="block text-sm font-medium text-gray-700">Re-enter Account Number</label>
				<input type="text" name="confirm_account_number" placeholder="Re-enter Account Number" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-1" required/>
				@if ($errors->has('confirm_account_number'))
					<p class="text-xs text-red-500 mb-4">{{ $errors->first('confirm_account_number') }}</p>
				@endif

				<!-- Account Holder Name -->
				<label class="block text-sm font-medium text-gray-700">Account Holder Name</label>
				<input type="text" name="account_holder_name" placeholder="Enter Account Holder Name" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-1" required/>
				@if ($errors->has('account_holder_name'))
					<p class="text-xs text-red-500 mb-4">{{ $errors->first('account_holder_name') }}</p>
				@endif

				

				<div class="flex items-center mt-4">
					<input type="checkbox" id="terms" name="terms" class="h-4 w-4 text-orange-500 focus:ring-orange-500 border-gray-300 rounded" required/>
					<label for="terms" class="ml-2 text-sm text-gray-700">I hereby declare that the details furnished above are true and correct</label>
				</div>
				@if ($errors->has('terms'))
					<p class="text-xs text-red-500 mt-1">{{ $errors->first('terms') }}</p>
				@endif

				<button type="submit" class="w-full my-6 p-4 text-white font-semibold bg-orange-600 hover:bg-orange-500">Continue</button>
				
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