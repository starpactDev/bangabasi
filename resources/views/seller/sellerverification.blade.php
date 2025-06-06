
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
		<div class="col-span-12 lg:col-span-5 flex items-center justify-center max-h-screen overflow-y-auto bg-slate-100">
			<form class="w-full max-w-md p-6 pt-48" method="POST" action="{{ route('seller_verify') }}" enctype="multipart/form-data">
                @csrf
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Welcome to Bangabasi</h1>
                <p class="text-gray-600 mb-6">Provide Seller Details to continue</p>

                <!-- Store Name -->
                <label class="block text-sm font-medium text-gray-700">Store Name</label>
                <input name="store_name" type="text" value="{{ old('store_name') }}" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-1" />
                @error('store_name')
                    <p class="text-xs text-red-500 mb-4">{{ $message }}</p>
                @enderror

                <!-- First Name -->
                <label class="block text-sm font-medium text-gray-700">Seller First Name</label>
                <input name="first_name" type="text" value="{{ old('first_name') }}" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-1" />
                @error('first_name')
                    <p class="text-xs text-red-500 mb-4">{{ $message }}</p>
                @enderror

                <!-- Last Name -->
                <label class="block text-sm font-medium text-gray-700">Seller Last Name</label>
                <input name="last_name" type="text" value="{{ old('last_name') }}" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-1" />
                @error('last_name')
                    <p class="text-xs text-red-500 mb-4">{{ $message }}</p>
                @enderror

                <!-- Contact Number -->
                <label class="block text-sm font-medium text-gray-700">Store Contact Number</label>
                <input name="contact_number" type="tel" value="{{ old('contact_number') }}" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-1" />
                @error('contact_number')
                    <p class="text-xs text-red-500 mb-4">{{ $message }}</p>
                @enderror

                <!-- Store Email -->
                <label class="block text-sm font-medium text-gray-700">Store Email</label>
                <input name="email" type="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-1" />
                @error('email')
                    <p class="text-xs text-red-500 mb-4">{{ $message }}</p>
                @enderror

                <!-- Description -->
                <label class="block text-sm font-medium text-gray-700">Store Description</label>
                <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-1">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-500 mb-4">{{ $message }}</p>
                @enderror

                <!-- Logo Upload -->
                <label class="block text-sm font-medium text-gray-700">Store Logo</label>
                <div class="flex items-center space-x-4 mt-1">
                    <div class="relative">
                        <input name="logo" type="file" id="logo-upload" accept="image/*" class="hidden" onchange="previewLogo(event)" />
                        <label for="logo-upload" class="cursor-pointer">
                            <div class="w-24 h-24 bg-gray-200 border-2 border-dashed border-gray-300 rounded-lg flex justify-center items-center">
                                <span class="text-gray-600 text-center">Upload Logo 300x300</span>
                            </div>
                        </label>
                        <div id="logo-preview" class="absolute top-0 left-0 w-24 h-24 bg-gray-200 border-2 border-dashed border-gray-300 rounded-lg hidden"></div>
                    </div>
                </div>
                @error('logo')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <!-- Terms & Conditions -->
                <div class="flex items-center mt-4">
                    <input name="terms" type="checkbox" id="terms" class="h-4 w-4 text-orange-500 focus:ring-orange-500 border-gray-300 rounded" {{ old('terms') ? 'checked' : '' }}>
                    <label for="terms" class="ml-2 text-sm text-gray-700">I agree to the Terms and Conditions and confirm that all provided information is accurate</label>
                </div>
                @error('terms')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <!-- Submit -->
                <button type="submit" class="w-full my-6 p-4 text-white font-semibold bg-orange-600 hover:bg-orange-500">Submit</button>
            </form>
		</div>

		<!-- Right Section -->
		<div class="col-span-12 lg:col-span-7 flex items-end ">
			<img src="{{asset('user/uploads/seller/seller-hero.png')}}" alt="" class="object-cover w-full">
		</div>
	</section>
</body>
<script id="previewImage">
    function previewLogo(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('logo-preview');
        const error = document.getElementById('logo-error');

        // Check if the file is an image
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.style.backgroundImage = `url(${e.target.result})`;
                preview.style.backgroundSize = 'cover';
                preview.style.backgroundPosition = 'center';
                preview.classList.remove('hidden');
                error.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('hidden');
            error.classList.remove('hidden');
        }
    }
</script>
</html>