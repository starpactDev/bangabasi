@extends("layouts.master")
@section('head')
<title>Bangabasi | About US</title>
@endsection
@section('content')
<section class="breadcrumb h-96 bg-pink-100 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('user/uploads/about/'.$about->breadcrumb->image) }}');">
	<div class="container flex flex-col justify-center items-center h-full ">
		<div class="text-center max-w-xs md:max-w-2xl lg:max-w-4xl">
			<h1 class="text-4xl font-bold text-secondary">{{ $about->breadcrumb->head ?? 'About Us'}}</h1>
			<p class="text-slate-600 my-4">{{ $about->breadcrumb->description ?? 'No Description' }} </p>
		</div>
	</div>
</section>

<section class="p-4 my-12">
	<div class="flex flex-wrap justify-center gap-x-8 gap-y-8  ">
		<img src="{{ asset('user/uploads/about/'.$about->stories->image1)}}" alt="" class="w-36 h-36 object-cover border" style="border-radius: 100% 1rem 1rem 1rem">
		<img src="{{ asset('user/uploads/about/'.$about->stories->image2)}}" alt="" class="w-96 h-36 object-cover border" style="border-radius: 18rem">
		<img src="{{ asset('user/uploads/about/'.$about->stories->image3)}}" alt="" class="w-36 h-36 object-cover border" style="border-radius: 1rem">
		<img src="{{ asset('user/uploads/about/'.$about->stories->image4)}}" alt="" class="w-36 h-36 object-cover border" style="border-radius: 18rem">
		<div class="w-80 h-36 object-cover p-4 bg-amber-600 border" style="border-radius: 1rem">
			<p style="color:#b56405 ">SINCE</p>
			<h2 class="ml-8 font-bold"  style="color:#f3d2a4; font-size: 6.5rem;line-height: 5.5rem;">2024</h2>
		</div>
		<div class="w-80 h-36 object-cover p-4 bg-fuchsia-600 cursor-pointer border" style="border-radius: 1rem" onclick="scrollToSection('pandavas')">
			<p class="text-fuchsia-950 text-xl tracking-wide ">Meet Our Pandavas</p>
			<p class="text-fuchsia-950 text-3xl text-right mt-8">↓</p>
		</div>
		<img src="{{ asset('user/uploads/about/'.$about->stories->image5)}}" alt="" class="w-36 h-36 object-cover border" style="border-radius: 18rem">
		<img src="{{ asset('user/uploads/about/'.$about->stories->image6)}}" alt="" class="w-36 h-36 object-cover border" style="border-radius: 1rem">
		<img src="{{ asset('user/uploads/about/'.$about->stories->image7)}}" alt="" class="w-96 h-36 object-cover border" style="border-radius: 18rem">
		<img src="{{ asset('user/uploads/about/'.$about->stories->image8)}}" alt="" class="w-36 h-36 object-cover border" style="border-radius: 1rem 100% 1rem 1rem">
	</div>
</section>

<section class="my-4 p-4" id="pandavas">
	<div class="grid grid-cols-8">
		<div class="col-span-8 lg:col-span-1"></div>
		<div class="grid col-span-8 lg:col-span-6 grid-cols-3 grid-rows-3 gap-4">
			<div class="relative col-span-3 md:col-span-2 row-span-1 md:row-span-2 bg-sky-200 aspect-square bg-cover bg-no-repeat group" style="background-image: url('{{ asset('user/uploads/about/'.($about->founder->image ?? 'no-image.png')) }}')">
				<div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
				</div>
				<div class="absolute inset-0 backdrop-blur-sm opacity-0 group-hover:opacity-100 bg-white/10 rounded-lg p-4 text-white flex flex-col justify-center items-center gap-2 transition-all duration-300">
					<h2 class="text-xl font-semibold">{{ $about->founder->name ?? 'Arnal | Das'}}</h2>
					<h3 class="text-lg text-orange-50">{{ $about->founder->role ?? 'Founder'}}</h3>
					<p class="text-sm text-center w-[95%] md:w-3/4 mx-auto">{{$about->founder->story1 ?? 'No Description'}}</p>
					<p class="text-sm text-center w-3/4 mx-auto hidden md:block">{{$about->founder->story2 ?? 'No Description'}}</p>
				</div>
			</div>
			<div class="relative col-span-3 md:col-span-1 row-span-1  bg-sky-200 aspect-square bg-cover bg-no-repeat group overflow-hidden" style="background-image: url('{{ asset('user/uploads/about/'.($about->member1->image ?? 'no-image.png')) }}')">
				<div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
				</div>
				<div class="absolute inset-0 backdrop-blur-sm opacity-0 group-hover:opacity-100 bg-white/10 rounded-lg p-4 text-white flex flex-col justify-center items-center gap-2 transition-all duration-300">
					<h2 class="text-xl font-semibold">{{ $about->member1->name ?? 'No Name' }}</h2>
					<h3 class="text-lg text-orange-50">{{ $about->member1->role ?? 'Member' }}</h3>
					<p class="text-sm text-center">{{ $about->member1->story ?? 'No Description' }}</p>
				</div>
			</div>
			<div class="relative col-span-3 md:col-span-1 row-span-1  bg-sky-200 aspect-square bg-cover bg-no-repeat group overflow-hidden" style="background-image: url('{{ asset('user/uploads/about/'.($about->member2->image ?? 'no-image.png')) }}')">
				<div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
				</div>
				<div class="absolute inset-0 backdrop-blur-sm opacity-0 group-hover:opacity-100 bg-white/10 rounded-lg p-4 text-white flex flex-col justify-center items-center gap-2 transition-all duration-300">
					<h2 class="text-xl font-semibold">{{ $about->member2->name ?? 'No Name'}}</h2>
					<h3 class="text-lg text-orange-50">{{ $about->member2->role ?? 'Member'}}</h3>
					<p class="text-sm text-center">{{ $about->member2->story ?? 'No Description' }}</p>
				</div>
			</div>
			<div class="relative col-span-3 md:col-span-1 row-span-1  bg-sky-200 aspect-square bg-cover bg-no-repeat group overflow-hidden" style="background-image: url('{{ asset('user/uploads/about/'.($about->member3->image ?? 'no-image.png')) }}')">
				<div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
				</div>
				<div class="absolute inset-0 backdrop-blur-sm opacity-0 group-hover:opacity-100 bg-white/10 rounded-lg p-4 text-white flex flex-col justify-center items-center gap-2 transition-all duration-300">
					<h2 class="text-xl font-semibold">{{ $about->member3->name ?? 'No Name' }}</h2>
					<h3 class="text-lg text-orange-50">{{ $about->member3->role ?? 'Member' }}</h3>
					<p class="text-sm text-center">{{ $about->member3->story ?? 'No Description'}}</p>
				</div>
			</div>
			<div class="relative col-span-3 md:col-span-1 row-span-1  bg-sky-200 aspect-square bg-cover bg-no-repeat group overflow-hidden" style="background-image: url('{{ asset('user/uploads/about/'.($about->member4->image ?? 'no-image.png')) }}')">
				<div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
				</div>
				<div class="absolute inset-0 backdrop-blur-sm opacity-0 group-hover:opacity-100 bg-white/10 rounded-lg p-4 text-white flex flex-col justify-center items-center gap-2 transition-all duration-300">
					<h2 class="text-xl font-semibold">{{ $about->member4->name ?? 'No Name'}}</h2>
					<h3 class="text-lg text-orange-50">{{ $about->member4->role ?? 'Member' }}</h3>
					<p class="text-sm text-center">{{ $about->member4->story ?? 'No Description' }}</p>
				</div>
			</div>
			
			<div class="relative col-span-3 md:col-span-1 row-span-1  bg-sky-200 aspect-square bg-cover bg-no-repeat group overflow-hidden" style="background-image: url('{{ asset('user/uploads/about/'.($about->member5->image ?? 'no-image.png')) }}')">
				<div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
				</div>
				<div class="absolute inset-0 backdrop-blur-sm opacity-0 group-hover:opacity-100 bg-white/10 rounded-lg p-4 text-white flex flex-col justify-center items-center gap-2 transition-all duration-300">
					<h2 class="text-xl font-semibold">{{ $about->member5->name ?? 'No Name'}}</h2>
					<h3 class="text-lg text-orange-50">{{ $about->member5->role ?? 'Member' }}</h3>
					<p class="text-sm text-center">{{ $about->member5->story ?? 'No Description' }}</p>
				</div>
			</div>
		</div>
		<div class="col-span-8 lg:col-span-1"></div>
	</div>
	
</section>

<section class="my-16 p-4">
	<div class="relative h-96">
		<h2 class="w-24 absolute z-10 left-0 top-32 text-4xl md:text-6xl lg:text-8xl font-bold ">{{$about->ourStory->head ?? "Connecting Bengal's Artisans to the World"}}</h2>
	</div>
	<div class="min-h-dvh ">
		<div class="relative">
			<img src="{{ asset('user/uploads/about/'.($about->ourStory->image ?? 'statue_1.jpg'))}}" alt="" class="absolute w-3/4 md:w-3/6 right-8 md:right-16 -bottom-16 md:-bottom-32 bottom">
		</div>
		
		<div class="w-full bg-rose-500 h-full grid-cols-12 grid gap-x-8 gap-y-4">
			<div class="col-span-12 lg:col-span-3 p-4 text-slate-50">
				
			</div>
			<div class="col-span-12 lg:col-span-4 p-4 text-slate-50">
				<p class=" mb-6 md:mt-32 text-justify">{{ $about->ourStory->text1 ?? ' '}}</p>
				<p class="text-justify">{{ $about->ourStory->text2 ?? ' '}}</p>
			</div>
			<div class="col-span-12 lg:col-span-5 p-4 text-slate-50">
				<p class=" mb-6 md:mt-32 text-justify">{{ $about->ourStory->text3 ?? ' '}}</p>
				<p class="text-justify">{{ $about->ourStory->text4 ?? ' '}}</p>
				<ul class="my-4 space-y-2">
					<li><span class="mr-4">֍</span>{{ $about->ourStory->list1 ?? 'No Description' }}</li>
					<li><span class="mr-4">֍</span>{{ $about->ourStory->list2 ?? 'No Description' }}</li>
					<li><span class="mr-4">֍</span>{{ $about->ourStory->list3 ?? 'No Description' }}</li>
				</ul>
			</div>

		</div>
	</div>
</section>

<section class="p-4 my-8">
	<div class="grid grid-cols-3 gap-4">
		<!-- Section 1: What We Do -->
		<div class="col-span-3 lg:col-span-1 p-2 group">
			<div class="w-full h-64 overflow-hidden">
				<img src="{{ asset('user/uploads/about/'.($about->weDo->image ?? 'no-image.jpg')) }}" alt="Image" class="h-64 w-full object-cover scale-125 group-hover:scale-100 transition-transform duration-300">
			</div>

			<h2 class="text-center mt-4 text-xl font-semibold">{{ $about->weDo->head ?? "What We Do?" }}</h2>
			<div class="text-slate-600 mt-2 text-justify">
				<!-- Truncated text -->
				<p id="weDoText" class="text-truncated">
					{{ Str::limit($about->weDo->text ?? 'No Description', 150) }} 
				</p>
				
				<!-- Full text (initially hidden) -->
				<p id="weDoFullText" class="hidden mt-2 text-justify">
					{{ $about->weDo->text ?? 'No Description' }}
				</p>
				
				<!-- Toggle Button -->
				<button class="text-blue-500 mt-2 text-sm cursor-pointer" id="weDoToggleBtn" onclick="toggleText('weDo')">Continue Reading</button>
			</div>
		</div>

		<!-- Section 2: Mission & Vision -->
		<div class="col-span-3 lg:col-span-1 p-2 group">
			<div class="w-full h-64 overflow-hidden">
				<img src="{{ asset('user/uploads/about/'.($about->missionVision->image ?? 'no-image.jpg')) }}" alt="Image" class="h-64 w-full object-cover scale-125 group-hover:scale-100 transition-transform duration-300">
			</div>
			<h2 class="text-center mt-4 text-xl font-semibold">{{ $about->missionVision->head ?? "Our Mission and Vision" }}</h2>
			<div class="text-slate-600 mt-2 text-justify">
				<!-- Truncated text -->
				<p id="missionVisionText" class="text-truncated">
					{{ Str::limit($about->missionVision->text ?? 'No Description', 150) }} 
				</p>

				<!-- Full text (initially hidden) -->
				<p id="missionVisionFullText" class="hidden mt-2 text-justify">
					{{ $about->missionVision->text ?? 'No Description' }}
				</p>
				
				<!-- Toggle Button -->
				<button class="text-blue-500 mt-2 text-sm cursor-pointer" id="missionVisionToggleBtn" onclick="toggleText('missionVision')">Continue Reading</button>
			</div>
		</div>

		<!-- Section 3: Our Story -->
		<div class="col-span-3 lg:col-span-1 p-2 group">
			<div class="w-full h-64 overflow-hidden">
				<img src="{{ asset('user/uploads/about/'.($about->history->image ?? 'shirts.jpg')) }}" alt="Image" class="h-64 w-full object-cover scale-125 group-hover:scale-100 transition-transform duration-300">
			</div>
			<h2 class="text-center mt-4 text-xl font-semibold">{{ $about->history->head ?? "Our Story" }}</h2>
			<div class="text-slate-600 mt-2 text-justify">
				<!-- Truncated text -->
				<p id="historyText" class="text-truncated">
					{{ Str::limit($about->history->text ?? 'No Description', 150) }} 
				</p>

				<!-- Full text (initially hidden) -->
				<p id="historyFullText" class="hidden mt-2 text-justify">
					{{ $about->history->text ?? 'No Description' }}
				</p>

				<!-- Toggle Button -->
				<button class="text-blue-500 mt-2 text-sm cursor-pointer" id="historyToggleBtn" onclick="toggleText('history')">Continue Reading</button>
			</div>
		</div>
	</div>
</section>

<section class="text-center p-4 my-8">
	<div class="mx-auto p-4 border-2 grid grid-cols-4">
		@for ($i = 1; $i <= 4; $i++)
			<div class="col-span-4 md:col-span-2 lg:col-span-1 flex justify-center items-center">
				<div class="w-1/4 flex justify-center">
					<img src="{{ asset('user/uploads/about/' . $about->{'$schema' . $i}->image) }}" alt="icon" class="w-12 h-12 object-contain">
				</div>
				<div class="w-3/4">
					<h2 class="text-lg font-semibold mb-2 text-left">{{ $about->{'$schema' . $i}->head }}</h2>
					<p class="text-gray-600 leading-relaxed text-sm text-left">{{ $about->{'$schema' . $i}->description }}</p>
				</div>
			</div>
		@endfor
	</div>
</section>
@endsection
@push('scripts')
<script id="continueReading">
	function toggleText(section) {
		// Select the text elements and button for the clicked section
		let truncatedText = document.getElementById(section + 'Text');
		let fullText = document.getElementById(section + 'FullText');
		let toggleBtn = document.getElementById(section + 'ToggleBtn');

		// If the full text is hidden, show it and change button text
		if (fullText.classList.contains('hidden')) {
			// Hide the truncated text
			truncatedText.classList.add('hidden');

			// Show the full text
			fullText.classList.remove('hidden');

			// Change button text to "Collapse"
			toggleBtn.innerText = "Collapse";
		} else {
			// Show the truncated text again
			truncatedText.classList.remove('hidden');

			// Hide the full text
			fullText.classList.add('hidden');

			// Change button text back to "Continue Reading"
			toggleBtn.innerText = "Continue Reading";
		}
	}


</script>
@endpush
