<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="{{asset('user/uploads/logos/bangabasi_icon.png')}}" sizes="32x32" />
	<title>Bangabasi | Seller</title>
	@vite('resources/css/app.css')
	@stack('css')
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
	<style>
		.animate-blink {
			animation: animate-blink 1s infinite;

		}

		@keyframes animate-blink {
			0% {
				background-color: #fff;
				color: #ea580c;
			}

			100% {
				background-color: #ea580c;
				color: #fff;
			}
		}
		summary::marker {
			content: "☰";
			color: #ea580c;
		}
		details[open] summary::marker {
			content: "✖";
			color: #ea580c;
		}
	</style>
	
	<header class="sticky top-0 z-50 p-1 md:p-4 bg-white shadow border-b ">
		<div class="container mx-auto px-4 py-2 md:flex items-center justify-between">
			<!-- Left: Logo -->
			<div class="text-lg font-bold">
				<a href="#">
					<img src="{{ asset('images/bangabasi_logo_black.png') }}" alt="" class="w-32">
				</a>
			</div>
			<!-- Center: Navigation Links -->
			<nav class="hidden lg:flex space-x-6 text-gray-700">
				<a href="#sell-online" class="font-semibold hover:text-orange-600 ">Sell Online</a>
				<a href="#how-it-works" class="font-semibold hover:text-orange-600">How it works</a>
				<a href="#pricing" class="font-semibold hover:text-orange-600">Pricing & Commission</a>
				<a href="#shipping" class="font-semibold hover:text-orange-600">Shipping & Returns</a>
			</nav>
			<!-- Right: Buttons -->
			<div class="flex justify-end items-center space-x-4 ">
				<div class="flex space-x-4">
					<a class="border border-orange-600 text-orange-600 px-4 py-2 rounded hover:bg-orange-100" href="{{ route('seller_login') }}"> Login </a>
					<a class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700" href="{{ route('seller_registration') }}" >Start Selling</a>
				</div>
				<details class="block lg:hidden relative">
					<summary class="w-4"></summary>
					<nav class="absolute top-16 right-0 w-48 h-full  border">
						<ul class="border bg-white ">
							<li class="text-orange-600 hover:bg-orange-100 border-b py-2 px-4"><a href="">Sell Online</a></li>
							<li class="text-orange-600 hover:bg-orange-100 border-b py-2 px-4"><a href="">How it works</a></li>
							<li class="text-orange-600 hover:bg-orange-100 border-b py-2 px-4"><a href="">Pricing & Commission</a></li>
							<li class="text-orange-600 hover:bg-orange-100 border-b py-2 px-4"><a href="">Shipping & Returns</a></li>
						</ul>
					</nav>
				</details>
			</div>
		</div>
	</header>

	<section class="min-h-[70dvh] bg-sky-50 content-end" id="sell-online">
		<div class="container h-full grid grid-cols-12 mx-auto ">
			<div class="col-span-12 lg:col-span-6 min-h-96 order-2 lg:order-1 px-6 space-y-4">
				<h1 class="text-4xl font-bold">Sell online to 14 Cr+ customers at <br /> <span class="text-orange-600">0% Commission</span></h1>
				<p class="my-6">Become a Bangabasi seller and grow your business across India</p>
				<p>
					<span class="px-2 py-1 border border-orange-600 text-white rounded mr-4 animate-blink">New!</span>Don't have a GSTIN or have a Composition GSTIN?
					<br />You can still sell on Bangabasi. Click <a href="" class="text-orange-600 hover:text-orange-500 font-semibold">here</a> to know more.
				</p>
				<form action="{{ route('seller.phone.submit') }}" method="POST" class="hidden md:block">
					@csrf
					<div class="my-6 w-fit border rounded-md overflow-hidden bg-white">
						<span class="px-2 ">+91</span>
						<input type="tel" name="phone" placeholder="Enter Your Mobile Number" class="leading-10 px-4 focus:outline-none w-fit ">
						<button type="submit" class="bg-orange-600 text-white px-4 py-2 hover:bg-orange-700"> Start Selling </button>
					</div>
				</form>
				<a href="{{ route('seller_registration') }}" class="block md:hidden bg-orange-600 text-white px-4 py-2 hover:bg-orange-700 w-fit rounded"> Start Selling </a>
			</div>
			<div class="col-span-12 lg:col-span-6  h-96  order-1 lg:order-2 relative">
				<img src="{{ asset('user/uploads/seller/bangabasi_growth.png') }}" alt="">
			</div>
		</div>
	</section>

	<section class=" py-16">
		<div class="container mx-auto flex flex-wrap justify-around gap-4">
			<div class="min-w-64 lg:flex-1 h-48 py-6 px-4 bg-sky-50 rounded-lg">
				<h2 class="text-orange-600 text-3xl font-bold">11 Lakh+</h2>
				<h6 class="text-xl font-bold">Lorem, ipsum dolor sit amet consectetur </h6>
			</div>
			<div class="min-w-64 lg:flex-1 h-48 py-6 px-4 bg-sky-50 rounded-lg">
				<h2 class="text-orange-600 text-3xl font-bold">14 Crore+</h2>
				<h6 class="text-xl font-bold">Lorem, ipsum dolor sit amet consectetur </h6>
			</div>
			<div class="min-w-64 lg:flex-1 h-48 py-6 px-4 bg-sky-50 rounded-lg">
				<h2 class="text-orange-600 text-3xl font-bold">19000+</h2>
				<h6 class="text-xl font-bold">Lorem, ipsum dolor sit amet consectetur </h6>
			</div>
			<div class="min-w-64 lg:flex-1 h-48 py-6 px-4 bg-sky-50 rounded-lg">
				<h2 class="text-orange-600 text-3xl font-bold">700+</h2>
				<h6 class="text-xl font-bold">Lorem, ipsum dolor sit amet consectetur </h6>
			</div>
		</div>
	</section>

	<section class="py-16 ny-4" id="pricing">
		<div class="container mx-auto grid grid-cols-12 gap-4">
			<div class="col-span-12 lg:col-span-4 p-4 text-center border rounded-lg shadow">
				<img src="{{asset('images/icons/icon-14.svg')}}" alt="" class="mx-auto">
				<h3 class="my-4 text-lg font-semibold text-center">No Registration Fee</h3>
				<p class="text-neutral-800">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Numquam voluptate sint enim molestiae. Saepe, consectetur!</p>
			</div>
			<div class="col-span-12 lg:col-span-4 p-4 text-center border rounded-lg shadow">
				<img src="{{asset('images/icons/icon-15.svg')}}" alt="" class="mx-auto">
				<h3 class="my-4 text-lg font-semibold text-center">No Collection Fee</h3>
				<p class="text-neutral-800">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam animi eos dolorum tempore, libero aliquid?</p>
			</div>
			<div class="col-span-12 lg:col-span-4 p-4 text-center border rounded-lg shadow">
				<img src="{{asset('images/icons/icon-16.svg')}}" alt="" class="mx-auto">
				<h3 class="my-4 text-lg font-semibold text-center">No Penalty Fee</h3>
				<p class="text-neutral-800">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam animi eos dolorum tempore, libero aliquid?</p>
			</div>
		</div>
	</section>

	<section class="bg-gray-100 py-12" id="how-it-works">
		<div class="container mx-auto px-4">
			<h2 class="text-center text-3xl font-bold text-gray-800 mb-12">How It Works</h2>
			<div class="relative flex flex-col items-center gap-12 md:flex-row md:justify-between">
				<!-- Step 1 -->
				<div class="flex flex-col flex-1 min-h-48  relative">
					<div class="w-16 h-16 lg:mx-auto bg-orange-600 text-white text-xl font-bold flex items-center justify-center rounded-full">
						1
					</div>
					<div class="absolute hidden lg:block w-3/4 top-[2rem] -right-[8rem] border-b border-orange-500 z-10" ></div>
					<h3 class="mt-4 text-xl font-semibold text-gray-800 text-center">Create Account</h3>
					<p class="text-gray-600 mt-2 text-sm">
						All you need is:
					<ul class="list-disc ml-4 mt-2 text-left">
						<li class="text-sm">GSTIN (for GST sellers) or Enrolment ID / UIN (for non-GST sellers)</li>
						<li class="text-sm">Bank Account</li>
					</ul>
					</p>
				</div>

				<!-- Step 2 -->
				<div class="flex flex-col flex-1 min-h-48 lg:items-center  relative">
					<div class="w-16 h-16 bg-orange-600 text-white text-xl font-bold flex items-center justify-center rounded-full">
						2
					</div>
					<div class="absolute hidden lg:block w-3/4 top-[2rem] -right-[8rem] border-b border-orange-500 z-10" ></div>
					<h3 class="mt-4 text-xl font-semibold text-gray-800">List Products</h3>
					<p class="text-gray-600 mt-2 text-sm">
						List the products you want to sell in your supplier panel.
					</p>
				</div>

				<!-- Step 3 -->
				<div class="flex flex-col flex-1 min-h-48 lg:items-center  relative">
					<div class="w-16 h-16 bg-orange-600 text-white text-xl font-bold flex items-center justify-center rounded-full">
						3
					</div>
					<div class="absolute hidden lg:block w-3/4 top-[2rem] -right-[8rem] border-b border-orange-500 z-10" ></div>
					<h3 class="mt-4 text-xl font-semibold text-gray-800">Get Orders & Shipping</h3>
					<p class="text-gray-600 mt-2 text-sm">
						Start getting orders from crores of Indians actively shopping on our platform. Products are shipped to customers at the lowest costs.
					</p>
				</div>

				<!-- Step 4 -->
				<div class="flex flex-col flex-1 min-h-48 lg:items-center">
					<div class="w-16 h-16 bg-orange-600 text-white text-xl font-bold flex items-center justify-center rounded-full">
						4
					</div>
					
					<h3 class="mt-4 text-xl font-semibold text-gray-800">Receive Payments</h3>
					<p class="text-gray-600 mt-2 text-sm">
						Payments are deposited directly to your bank account following a 7-day payment cycle from order delivery.
					</p>
				</div>
			</div>
		</div>
	</section>

	<section class="min-h-dvh ">
		<div class="container mx-auto px-4 py-8 grid grid-cols-12 items-center justify-center">
			<div class="col-span-12 lg:col-span-6">
				<h2 class="text-3xl font-bold">Why Sellers Love Bangabasi</h2>
				<p class="my-4 max-w-96">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque saepe at consequuntur quia fuga qui voluptas unde optio eum dicta!</p>
			</div>
			<div class="col-span-12 lg:col-span-6 px-4 lg:px-8 py-4 border-2  border-slate-200 rounded-2xl">
				<div class="border-b-2 border-slate-200 py-4">
					<img src="{{ asset('images/icons/icon-10.svg') }}" alt="" class="inline mr-4">
					<h3 class="text-xl font-bold inline">0% Commission Fee</h3>
					<p class="mx-12">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Provident quisquam omnis nemo quia ipsum explicabo harum tempore, odit veniam laborum maiores? Explicabo nostrum quibusdam earum?</p>
				</div>
				<div class="border-b-2 border-slate-200 py-4">
					<img src="{{ asset('images/icons/icon-11.svg') }}" alt="" class="inline mr-4">
					<h3 class="text-xl font-bold inline">0% Commission Fee</h3>
					<p class="mx-12">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Provident quisquam omnis nemo quia ipsum explicabo harum tempore, odit veniam laborum maiores? Explicabo nostrum quibusdam earum?</p>
				</div>
				<div class="border-b-2 border-slate-200 py-4">
					<img src="{{ asset('images/icons/icon-16.svg') }}" alt="" class="inline mr-4">
					<h3 class="text-xl font-bold inline">0% Commission Fee</h3>
					<p class="mx-12">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Provident quisquam omnis nemo quia ipsum explicabo harum tempore, odit veniam laborum maiores? Explicabo nostrum quibusdam earum?</p>
				</div>
				<div class=" py-4">
					<img src="{{ asset('images/icons/icon-12.svg') }}" alt="" class="inline mr-4">
					<h3 class="text-xl font-bold inline">0% Commission Fee</h3>
					<p class="mx-12">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Provident quisquam omnis nemo quia ipsum explicabo harum tempore, odit veniam laborum maiores? Explicabo nostrum quibusdam earum?</p>
				</div>
			</div>
		</div>
	</section>

	<section class="bg-gray-100 py-12" id="shipping">
		<div class="container mx-auto px-4">
			<h2 class="text-center text-3xl font-bold text-gray-800 mb-12 w-fit px-6 mx-auto border-l-4 border-orange-600 rounded">How to Ship Your Orders in 3 simple steps</h2>
			<div class="relative flex flex-col items-center gap-12 md:flex-row md:justify-between">
				<!-- Step 1 -->
				<div class="flex flex-col flex-1 min-h-72  relative">
					<div class="w-16 h-16 lg:mx-auto bg-orange-600 text-white text-xl font-bold flex items-center justify-center rounded-full">
						1
					</div>
					<div class="absolute hidden lg:block w-3/4 top-[2rem] -right-[10rem] border-b border-orange-500 z-10" ></div>
					<h3 class="mt-4 text-lg font-semibold text-gray-800 text-center">Manage and process your orders through Bangabasi Panel</h3>
					<p class="text-gray-600 mt-2 text-sm">
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet repellendus quis architecto tenetur dolore voluptate.
						Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odit quisquam vitae tempore non? Aspernatur veniam, labore perferendis impedit sed inventore.
					</p>
				</div>

				<!-- Step 2 -->
				<div class="flex flex-col flex-1 min-h-72 lg:items-center  relative">
					<div class="w-16 h-16 bg-orange-600 text-white text-xl font-bold flex items-center justify-center rounded-full">
						2
					</div>
					<div class="absolute hidden lg:block w-3/4 top-[2rem] -right-[10rem] border-b border-orange-500 z-10" ></div>
					<h3 class="mt-4 text-lg font-semibold text-gray-800">Pack your product and keep it ready for pickup</h3>
					<p class="text-gray-600 mt-2 text-sm">
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus aperiam itaque natus? Dignissimos, quisquam pariatur!
						Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odit quisquam vitae tempore non? Aspernatur veniam, labore perferendis impedit sed inventore.
					</p>
				</div>

				<!-- Step 3 -->
				<div class="flex flex-col flex-1 min-h-72 lg:items-center  relative">
					<div class="w-16 h-16 bg-orange-600 text-white text-xl font-bold flex items-center justify-center rounded-full">
						3
					</div>
					<h3 class="mt-4 text-lg font-semibold text-gray-800">Hand over the product to Bangabasi Delivery Partner</h3>
					<p class="text-gray-600 mt-2 text-sm">
						Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quia quos dolorem, ipsum saepe fuga ipsam?
						Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odit quisquam vitae tempore non? Aspernatur veniam, labore perferendis impedit sed inventore.
					</p>
				</div>

			
			</div>
		</div>
	</section>

	<section class="bg-slate-50 my-8">
		<div class="container mx-auto px-4 py-8 grid grid-cols-12 items-center">
			<div class="col-span-12 lg:col-span-6">
				<h2 class="text-3xl font-bold">Bangabasi Seller Support 24/7</h2>
			</div>
			<div class="col-span-12 lg:col-span-6">
				<p class="text-sm">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis culpa aliquam corporis tempore pariatur magnam deleniti nulla ipsa dolor suscipit tenetur unde possimus, aspernatur sed.</p>
				<div class="flex items-center gap-x-4 justify-between my-4">
					<div class="inline-flex justify-between my-4 w-fit gap-x-4">
						<button class="p-2 bg-orange-600">
							<img src="{{asset('images/icons/mail_bangabasi.png')}}" alt="" class="w-8 invert">
						</button>
						<div>
							<p>You can reach out to</p>
							<a href="mailto:info@starpactglobal.com" class="text-orange-600 hover:text-orange-500">info@starpactglobal.com</a>
						</div>
					</div>
					<button class="px-8 py-2 my-4 border rounded  border-orange-600 hover:bg-orange-600 hover:text-white">Visit Tutorial</button>
				</div>
				
			</div>
		</div>
	</section>

	<section class="my-8 py-8">
		<h2 class="my-4 text-3xl font-semibold text-center ">Experiences sellers love to talk about</h2>
		<div class="container flex flex-wrap justify-center items-center mx-auto my-8 gap-8">
			<div class="min-h-96 min-w-80 lg:flex-1 p-4 rounded-xl hover:shadow-md relative">
				<img src="{{ asset('user/uploads/seller/seller1.jpg') }}" alt="" class="w-full h-40 rounded-xl object-cover">
				<div class="absolute top-42 left-8 w-16 aspect-square border-4 border-white rounded-full -translate-y-1/2 bg-orange-600 text-center content-center text-xl text-white hover:text-2xl drop-shadow-sm hover:drop-shadow-lg cursor-pointer">▶</div>
				<h3 class="text-lg font-semibold mt-8">John Doe</h3>
				<address class="text-xs my-2">Durgapur, West Bengal</address>
				<p class=" my-4 text-sm text-neutral-900">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo tempore explicabo doloremque ullam ab. Perspiciatis. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione magnam amet, dolores beatae culpa veniam sapiente officia blanditiis placeat ipsa!</p>
			</div>
			<div class="min-h-96 min-w-80 lg:flex-1 p-4 rounded-xl hover:shadow-md relative">
				<img src="{{ asset('user/uploads/seller/seller2.jpg') }}" alt="" class="w-full h-40 rounded-xl object-cover">
				<div class="absolute top-42 left-8 w-16 aspect-square border-4 border-white rounded-full -translate-y-1/2 bg-orange-600 text-center content-center text-xl text-white hover:text-2xl drop-shadow-sm hover:drop-shadow-lg cursor-pointer">▶</div>
				<h3 class="text-lg font-semibold mt-8">John Doe</h3>
				<address class="text-xs my-2">Durgapur, West Bengal</address>
				<p class=" my-4 text-sm text-neutral-900">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo tempore explicabo doloremque ullam ab. Perspiciatis. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione magnam amet, dolores beatae culpa veniam sapiente officia blanditiis placeat ipsa!</p>
			</div>
			<div class="min-h-96 min-w-80 lg:flex-1 p-4 rounded-xl hover:shadow-md relative">
				<img src="{{ asset('user/uploads/seller/seller3.jpg') }}" alt="" class="w-full h-40 rounded-xl object-cover">
				<div class="absolute top-42 left-8 w-16 aspect-square border-4 border-white rounded-full -translate-y-1/2 bg-orange-600 text-center content-center text-xl text-white hover:text-2xl drop-shadow-sm hover:drop-shadow-lg cursor-pointer">▶</div>
				<h3 class="text-lg font-semibold mt-8">John Doe</h3>
				<address class="text-xs my-2">Durgapur, West Bengal</address>
				<p class=" my-4 text-sm text-neutral-900">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo tempore explicabo doloremque ullam ab. Perspiciatis. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione magnam amet, dolores beatae culpa veniam sapiente officia blanditiis placeat ipsa!</p>
			</div>
		</div>
	</section>

	<section class="bg-slate-50">
		<div class="container mx-auto p-6 lg:p-16 flex flex-wrap gap-8 items-center justify-center">
			<div class="lg:flex-1  min-w-80 w-1/2 ">
				<div class="w-fit">
					<img src="{{ asset('user/uploads/logos/logo.png') }}" alt="" class="block mx-auto">
					<h4 class="text-2xl font-semibold w-fit">Learn how to sell and grow your <br> business on Bangabasi</h4>
				</div>

			</div>
			<div class="lg:flex-1  min-w-80 w-1/2  text-center">
				<button class="px-10 py-4 border rounded-md border-orange-600 hover:bg-orange-600 hover:text-white">
				<img src="{{asset('images/svg/play.svg')}}" alt="" class="inline drop-shadow-sm hover:drop-shadow">	
				Visit Learning Hub</button>
			</div>
		</div>
	</section>

	<footer class="my-8 pb-16">
		<div class="container px-4 md:px-8 mx-auto grid grid-cols-12 border-b">
			<div class="col-span-12 lg:col-span-4 py-4">
				<img src="{{ asset('user/uploads/logos/logo.png') }}" alt="banagabasi logo">
				<p class="w-4/5 my-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum pariatur dolores tenetur saepe architecto maxime!</p>
				<button class="my-4 px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded">Start Selling</button>
			</div>
			<div class="col-span-12 lg:col-span-4 py-4">
				<div class="w-fit mx-auto">
					<h6 class="text-lg  font-semibold my-6" >Sell On Bangabasi</h6>
					<ul>
						<li class="py-1"><a href="" class="hover:text-orange-600 text-neutral-900">Sell Online</a></li>
						<li class="py-1"><a href="" class="hover:text-orange-600 text-neutral-900">Pricing & Commission</a></li>
						<li class="py-1"><a href="" class="hover:text-orange-600 text-neutral-900">How it works</a></li>
						<li class="py-1"><a href="" class="hover:text-orange-600 text-neutral-900">Shipping & Returns</a></li>
						<li class="py-1"><a href="" class="hover:text-orange-600 text-neutral-900">Grow Your Business</a></li>
						<li class="py-1"><a href="" class="hover:text-orange-600 text-neutral-900">Learning Hub</a></li>
						<li class="py-1"><a href="" class="hover:text-orange-600 text-neutral-900">Bangabsi Ads</a></li>
						<li class="py-1"><a href="" class="hover:text-orange-600 text-neutral-900">Shop Online on Bangabasi</a></li>
					</ul>
				</div>
			</div>
			<div class="col-span-12 lg:col-span-4 py-4">
				<div class="w-fit mx-auto">
					<h6 class="text-lg  font-semibold my-6" >Contact Us</h6>
					<a href="mailto:contact@starpactglobal.com" class="text-orange-600 hover:text-orange-500">contact@starpactglobal.com</a>
					<div class="my-4 flex justify-start gap-2 py-2 bg-white w-fit ">
                        <a href="https://www.facebook.com/bangabasi.co" class="p-2 bg-orange-500 hover:bg-orange-700">
                            <img src="{{asset('images/icons/facebook_bangabasi.png')}}" alt="" class="w-4 invert" data-src="http://127.0.0.1:8000/images/icons/facebook_bangabasi.png">
                        </a>
                        <a href="https://www.instagram.com/bangabasiindia/" class="p-2 bg-orange-500 hover:bg-orange-700">
                            <img src="{{asset('images/icons/instagram_bangabasi.png')}}" alt="" class="w-4 invert" data-src="http://127.0.0.1:8000/images/icons/instagram_bangabasi.png">
                        </a>
                        <a href="https://www.youtube.com/@Bangabasiindia" class="p-2 bg-orange-500 hover:bg-orange-700">
                            <img src="{{asset('images/icons/youtube_bangabasi.png')}}" alt="" class="w-4 invert" data-src="http://127.0.0.1:8000/images/icons/youtube_bangabasi.png">
                        </a>
                        <a href="https://in.pinterest.com/bangabasiindia/ " class="p-2 bg-orange-500 hover:bg-orange-700">
                            <img src="{{asset('images/icons/pinterest_bangabasi.png')}}" alt="" class="w-4 invert" data-src="http://127.0.0.1:8000/images/icons/pinterest_bangabasi.png">
                        </a>
                        <a href="https://maps.app.goo.gl/BekqTPMAGE6CqbfC8" class="p-2 bg-orange-500">
                            <img src="{{asset('images/icons/location_bangabasi.png')}}" alt="" class="w-4 invert" data-src="http://127.0.0.1:8000/images/icons/location_bangabasi.png">
                        </a>
                        <a href="https://whatsapp.com/channel/0029VakhvrpL2AU4lilJCV3R" class="p-2 bg-orange-500 hover:bg-orange-700">
                            <img src="{{asset('images/icons/whatsapp_bangabasi.png')}}" alt="" class="w-4 invert" data-src="http://127.0.0.1:8000/images/icons/whatsapp_bangabasi.png">
                        </a>
                    </div>
				</div>
			</div>
		</div>
		<p class="my-6 text-sm w-fit mx-auto">© Starpact Global Services | All rights reserved</p>
	</footer>

</body>

</html>