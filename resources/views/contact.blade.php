@extends("layouts.master")
@section('head')
<title>Bangabasi | Contact US</title>
@endsection
@section('content')
<div class="container mx-auto px-6 py-12">
    <!-- Hero Section -->
    <div class="text-center">
        <h1 class="text-4xl font-bold text-orange-500">Contact Us</h1>
        <p class="text-lg text-gray-600 mt-2">We would love to hear from you!</p>
    </div>

    <!-- Contact Details Section -->
    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div>
            <h2 class="text-2xl font-semibold text-blue-600">Get in Touch</h2>
            <p class="text-gray-700 mt-3">Reach out to us via phone, email, or visit our office.</p>
            <div class="mt-5 space-y-3">
                <strong class="text-orange-500">Address: </strong>
                <p class="text-md text-gray-900 "><strong class="text-black">Office Address: </strong> 0050 Gita Kuthir, Burdwan, WB 713125, India</p>
                <p class="text-md text-gray-900 "><strong class="text-black">Durgapur Office : </strong> B-II/29, Netaji Subhas Road, Dhobighat A Zone, Durgapur, (WB), 713204</p>
                <p class="text-md text-gray-900 "><strong class="text-black">Burdwan Office : </strong> Nawab Dost N. D. Kayem Lane, B. C.Road, Nearby Bardhaman Sadar Police Station, Bardhaman, (WB), 713101</p>
                <p class="text-md text-gray-900"><strong class="text-orange-500">Phone & WhatsApp:</strong> +91 94761 68391</p>
            </div>
        </div>
        <div>
            <img src="{{ asset('user/uploads/about/Bangabasi_Team.png') }}" alt="Office Image" class="rounded-lg shadow-lg">
        </div>
    </div>

    <!-- Social Media Links Section -->
    <div class="mt-12 text-center">
        <h2 class="text-2xl font-semibold text-blue-600">Follow Us</h2>
        <p class="text-gray-700 mt-3">Stay connected with us on social media.</p>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mt-6">
            <a href="https://www.facebook.com/bangabasi.co" target="_blank" class="flex flex-col items-center p-4 border rounded-lg shadow-lg hover:shadow-xl transition">
                <img src="{{ asset('user/uploads/about/facebook.webp') }}" alt="Facebook" class="w-12 h-12">
                <span class="text-orange-500 mt-2">Facebook</span>
            </a>
            <a href="https://www.instagram.com/bangabasiindia/" target="_blank" class="flex flex-col items-center p-4 border rounded-lg shadow-lg hover:shadow-xl transition">
                <img src="{{ asset('user/uploads/about/instagram.jpg') }}" alt="Instagram" class="w-12 h-12">
                <span class="text-orange-500 mt-2">Instagram</span>
            </a>
            <a href="https://www.youtube.com/@Bangabasiindia" target="_blank" class="flex flex-col items-center p-4 border rounded-lg shadow-lg hover:shadow-xl transition">
                <img src="{{ asset('user/uploads/about/youtube.webp') }}" alt="YouTube" class="w-12 h-12">
                <span class="text-orange-500 mt-2">YouTube</span>
            </a>
            <a href="https://whatsapp.com/channel/0029VakhvrpL2AU4lilJCV3R" target="_blank" class="flex flex-col items-center p-4 border rounded-lg shadow-lg hover:shadow-xl transition">
                <img src="{{ asset('user/uploads/about/whatsapp.webp') }}" alt="WhatsApp" class="w-12 h-12">
                <span class="text-orange-500 mt-2">WhatsApp</span>
            </a>
            <a href="https://in.pinterest.com/bangabasiindia/" target="_blank" class="flex flex-col items-center p-4 border rounded-lg shadow-lg hover:shadow-xl transition">
                <img src="{{ asset('user/uploads/about/pinterest.webp') }}" alt="Pinterest" class="w-12 h-12">
                <span class="text-orange-500 mt-2">Pinterest</span>
            </a>
        </div>
    </div>

    <!-- Contact Form Section -->
    <div class="mt-12">
        <h2 class="text-2xl font-semibold text-blue-600 text-center">Send Us a Message</h2>
    
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4">
                {{ session('success') }}
            </div>
        @else
            <div class="max-w-2xl mx-auto mt-6 bg-white p-6 shadow-lg rounded-lg">
                <form method="post" action="{{ route('contact.submit') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-semibold">Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your Name" class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:border-blue-600" autocomplete="on" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-semibold">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:border-blue-600" autocomplete="on" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block text-gray-700 font-semibold">Message</label>
                        <textarea id="message" name="message" placeholder="Enter your query" class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:border-blue-600" rows="5" required>{{ old('message') }}</textarea>
                        @error('message')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600">Send Message</button>
                </form>
            </div>
        @endif
    </div>

    <!-- Google Map Section -->
    <div class="mt-12">
        <h2 class="text-2xl font-semibold text-blue-600 text-center">Find Us Here</h2>
        <div class="mt-6">
		<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d174284.0910474209!2d87.91133702202424!3d23.35513181812547!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f9b3fd3331e5fd%3A0xda5bedb35199dac5!2sBangabasi!5e1!3m2!1sen!2sin!4v1738822763299!5m2!1sen!2sin" width="100%"  height="450"  style="border:0;"  allowfullscreen=""  loading="lazy"  referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>
@endsection