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
		<div class="col-span-12 lg:col-span-5 flex items-center justify-center bg-slate-100 max-h-svh overflow-y-auto">
			<form class="w-full max-w-md p-6" method="POST" action="{{ route('seller_gstverify')}}">
				@csrf
				<h1 class="text-2xl font-bold text-gray-800 mb-2">Welcome to Bangabasi</h1>
				<p class="text-gray-600 mb-6">Verify Your GST Number to start selling</p>
				<!-- Success Message -->

				@if(session('success'))
					<div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
						{{ session('success') }}
					</div>
				@endif

				<!-- GST Number Section -->
				<label class="block text-sm font-medium text-gray-700">Enter GST Number</label>
				<div class="flex items-center space-x-2 mt-1">
					<input id="gstNumber" name="gst_number" type="text" placeholder="Enter GST Number" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
					<button class="bg-orange-500 text-white px-4 py-2 w-36 rounded-md hover:bg-orange-600" type="button" onclick="verifyGSTNumber(event)">Verify</button>
				</div>
				<p class="text-xs text-red-500 mt-1 hidden" id="error-message">This field is required.</p>

				<!-- Business Details Section -->
				<div id="businessDetails" class="mt-6 p-4 rounded-lg animate-pulse bg-gray-50 relative">
					<div class="space-y-4" id="successContainer">
						<div class="flex flex-col gap-1">
							<label for="businessName" class="text-sm text-gray-500">Business Name:</label>
							<input id="businessName" name="business_name" type="text" class="text-sm font-semibold w-72 h-4 bg-neutral-300 rounded focus:outline-none" readonly />
						</div>

						<div class="flex flex-col gap-1">
							<label for="legalName" class="text-sm text-gray-500">Legal Name:</label>
							<input id="legalName" name="legal_name" type="text" class="text-sm font-semibold w-64 h-4 bg-neutral-300 rounded focus:outline-none" readonly />
						</div>

						<div class="flex flex-col gap-1">
							<label for="businessType" class="text-sm text-gray-500">Business Type:</label>
							<input id="businessType" name="business_type" type="text" class="text-sm font-semibold w-40 h-4 bg-neutral-300 rounded focus:outline-none" readonly />
						</div>

						<div class="flex flex-col gap-1 pb-4">
							<label for="businessAddress" class="text-sm text-gray-500">Address:</label>
							<input id="businessAddress" name="address"  class="text-sm font-semibold w-80 h-4 bg-neutral-300 rounded focus:outline-none" readonly />
						</div>
					</div>
					<div class="absolute top-10 right-4 w-2 h-2 rounded-full bg-neutral-300 animate-pulse " id="gst_status"></div>
				</div>

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


	<script>
		async function verifyGSTNumber(event) {
			event.preventDefault();
			const gstNumber = document.getElementById('gstNumber').value.trim();
			const errorMessage = document.getElementById('error-message');
			
			// Validate GST number input
			if (!gstNumber) {
				errorMessage.classList.remove('hidden');
				return;
			} else {
				errorMessage.classList.add('hidden');
			}

			const apiKey = `{{env('GSTIN_API_KEY')}}`; // Ensure this is set in your environment
			const apiUrl = `https://sheet.gstincheck.co.in/check/${apiKey}/${gstNumber}`;

			try {
				const response = await fetch(apiUrl);
				const data = await response.json();

				if (data.flag) {
					// Extract necessary values from the response
					const gstDetails = data.data;

					document.getElementById('successContainer').classList.remove('hidden');
					
					document.getElementById('businessName').value = gstDetails.tradeNam || 'N/A';
					document.getElementById('legalName').value = gstDetails.lgnm || 'N/A'; // Assuming GSTIN is being used as PAN Number
					document.getElementById('businessType').value = gstDetails.ctb || 'N/A';
					document.getElementById('businessAddress').value = gstDetails.pradr?.adr || 'N/A';
					

					// Remove the skeleton loader class (animate-pulse) from individual fields
					document.getElementById('businessDetails').classList.remove('animate-pulse');
					document.getElementById('businessName').classList.remove('bg-neutral-300');
					document.getElementById('legalName').classList.remove('bg-neutral-300');
					document.getElementById('businessType').classList.remove('bg-neutral-300');
					document.getElementById('businessAddress').classList.remove('bg-neutral-300');

					// Set the color of GST Status
					if(gstDetails.sts === 'Active') {
						document.getElementById('gst_status').classList.remove('bg-neutral-300');
						document.getElementById('gst_status').classList.add('bg-green-500');
					}
					else{
						document.getElementById('gst_status').classList.remove('bg-green-500', 'bg-neutral-300');
						document.getElementById('gst_status').classList.add('bg-red-500');
					}


					document.getElementById('businessName').classList.add('bg-transparent');
					document.getElementById('legalName').classList.add('bg-transparent');
					document.getElementById('businessType').classList.add('bg-transparent');
					document.getElementById('businessAddress').classList.add('bg-transparent');
				} else {
					document.getElementById('successContainer').classList.add('hidden');
					// Display error without removing original structure
					let errorContainer = document.getElementById('error-container');
					if (!errorContainer) {
						errorContainer = document.createElement('div');
						errorContainer.id = 'error-container';
						errorContainer.className = 'mt-4 bg-red-100 text-red-700 p-4 rounded-lg';
						document.getElementById('businessDetails').appendChild(errorContainer);
					}

					errorContainer.innerHTML = `
						<p class="text-sm font-medium">Error: ${data.message || 'GST Number not found or invalid.'}</p>
						<p class="text-xs mt-2">${data.errorCode || ''}</p>`;
				}
			} catch (error) {
				document.getElementById('successContainer').classList.add('hidden');
				// Display network error without removing original structure
				let errorContainer = document.getElementById('error-container');
				if (!errorContainer) {
					errorContainer = document.createElement('div');
					errorContainer.id = 'error-container';
					errorContainer.className = 'mt-4 bg-yellow-100 text-yellow-700 p-4 rounded-lg';
					document.getElementById('businessDetails').appendChild(errorContainer);
				}

				errorContainer.innerHTML = `
					<p class="text-sm font-medium">An unexpected error occurred. Please try again later.</p>
					<p class="text-xs mt-2">Error: ${error.message}</p>`;
			}
		}
	</script>

</body>

</html>