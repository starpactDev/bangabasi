@extends("layouts.master")
@section('head')
<title>Bangabasi | Terms of Use</title>
@endsection
@section('content')
@php
    $xpage = 'Terms of Use';
    $xprv = 'home';
	use Carbon\Carbon;
@endphp
<x-bread-crumb :page="$xpage" :previousHref="$xprv" />
<style>
  .cursor::after {
    content: "|";
    display: inline-block;
    margin-left: 2px;
    animation: blink 0.7s step-end infinite;
  }

  @keyframes blink {
    from, to {
      opacity: 1;
    }
    50% {
      opacity: 0;
    }
  }
</style>
<section class="min-h-screen bg-neutral-50 my-8">
	<div class="container grid grid-cols-12 gap-4 py-8">
		<div  class="font-mono leading-relaxed col-span-12 lg:col-span-12">
			<div class="max-w-3xl px-8 py-4 mx-auto bg-slte-100 shadow-md my-4">
				<h2 class=" text-3xl font-semibold my-4">Refund & Cancellation Policy</h2>
				<p class="typewriter" data-text=""></p>
			</div>
		</div>
		<div class="font-mono leading-relaxed col-span-12 lg:col-span-12">
			<div class="max-w-3xl px-8 py-4 mx-auto bg-slte-100 shadow-md my-4">
				<h2 class=" text-3xl font-semibold my-4">Return Policy</h2>
				<p class="typewriter" data-text=""></p>
			</div>
		</div>
		<div  class="font-mono leading-relaxed col-span-12 lg:col-span-12">
			<div class="max-w-3xl px-8 py-4 mx-auto bg-slte-100 shadow-md my-4">
				<h2 class=" text-3xl font-semibold my-4">Terms & Conditions</h2>
				<p class="typewriter" data-text=""></p>
			</div>
		</div>
		<div  class="font-mono leading-relaxed col-span-12 lg:col-span-12">
			<div class="max-w-3xl px-8 py-4 mx-auto bg-slte-100 shadow-md my-4">
				<h2 class=" text-3xl font-semibold my-4">Privacy Policy</h2>
				<p class="typewriter" data-text=""></p>
			</div>
		</div>
		<div  class="font-mono leading-relaxed col-span-12 lg:col-span-12">
			<div class="max-w-3xl px-8 py-4 mx-auto bg-slte-100 shadow-md my-4">
				<h2 class=" text-3xl font-semibold my-4">The Privacy Policy covers the following areas :</h2>
				<p class="typewriter font-semibold" data-text=""></p>
				<p class="typewriter ml-8" data-text=""></p>
  				<p class="typewriter ml-16" data-text=""></p>
  				<p class="typewriter ml-16" data-text=""></p>
				<p class="typewriter ml-16" data-text=""></p>
				<p class="typewriter ml-16" data-text=""></p>
				<p class="typewriter font-semibold" data-text=""></p>	
				<p class="typewriter ml-4" data-text=""></p>
  				<p class="typewriter" data-text=""></p>
			</div>
		</div>
		<div  class="font-mono leading-relaxed col-span-12 lg:col-span-12">
			<div class="max-w-3xl px-8 py-4 mx-auto bg-slte-100 shadow-md my-4">
				<h2 class=" text-3xl font-semibold my-4">Security</h2>
				<p class="typewriter" data-text=""></p>
			</div>
		</div>
	</div>
</section>
@endsection
@push('scripts')

@endpush