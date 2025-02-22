@extends("layouts.master")

@section("content")
<div class="min-h-screen bg-slate-50 flex items-center justify-center">
    
    <form action="" method="POST">
        @csrf
<h4>
    We will have content here
</h4>
        <!-- State Selection -->
        <div class="form-group">
            <label for="state">State</label>
            <select id="state" name="state" class="form-control">
                <option value="">Select State</option>
                <!-- States will be dynamically added here -->
            </select>
        </div>

        <!-- Pin Code Range -->
        <div class="form-group">
            <label for="pin_code_range">Pin Code Range</label>
            <select id="pin_code_range" name="pin_code_range[]" class="form-control" multiple>
                <!-- Pin codes will be dynamically added here -->
            </select>
        </div>

        <!-- Exclude District -->
        <div class="form-group">
            <label for="exclude_district">Exclude District</label>
            <input type="text" id="exclude_district" name="exclude_district" class="form-control" placeholder="Enter district to exclude">
        </div>

        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>


</div>
<section class="handpicked ">
	<h2 class="text-center text-2xl font-semibold capitalize py-6">Handpicked Products for You</h2>
	<div class="container border-4 p-6">
		<div class="handcrafts grid grid-cols-12 min-h-60 items-center" style="background-image: url('{{ asset('user/uploads/homepage/'.$homeData['handpickedSection']['image']) }}')">
			<div class="col-span-12 md:col-span-6 mx-auto lg-mx-0 lg:px-16 ">
				<h3 class="text-2xl font-bold py-2">{!! $homeData['handpickedSection']['head'] !!}</h3>
				<p class="my-4">{!! $homeData['handpickedSection']['description'] !!}</p>
				<a href="{{ $homeData['handpickedSection']['redirect'] }}" class="text-orange-500 text-semibold capitalize interactive-border my-8">{{ $homeData['handpickedSection']['button'] }}</a>
			</div>
			<div class="hidden md:col-span-6">

			</div>
		</div>
		<div class="w-full">
			@foreach ($handpicked->chunk(4) as $chunk)
			<div class="my-4 flex flex-wrap justify-around gap-4">
				@foreach ($chunk as $product)

				@php
				$averageRating = App\Helpers\ReviewHelper::getAverageRating($product->section_product->id);
				@endphp

				@if ($product->section_product->productImages->isNotEmpty())
				@php
				$image = $product->section_product->productImages->first()->image;
				@endphp
				@else
				@php
				$image = null;
				@endphp
				@endif

				@if ($product->section_product)

				<x-product-card
					:image="$image"
					:category="$product->section_product->categoryDetails->name"
					:title="$product->section_product->name"
					:rating="$averageRating" {{-- Ensure xRating is passed here --}}
					:originalPrice="$product->section_product->original_price"
					:discountedPrice="$product->section_product->offer_price"
					:id="$product->section_product->id" />
				@endif

				@endforeach
			</div>
			@endforeach
		</div>

	</div>
</section>


<script>
   document.addEventListener('DOMContentLoaded', function() {
    const stateSelect = document.getElementById('state');
    
    // Add loading state
    stateSelect.disabled = true;
    const loadingOption = document.createElement('option');
    loadingOption.textContent = 'Loading states...';
    stateSelect.appendChild(loadingOption);

    // Fetch states
    fetch('/fetch-states')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Clear loading state
            stateSelect.innerHTML = '<option value="">Select State</option>';
            stateSelect.disabled = false;

            if (data.data && Array.isArray(data.data)) {
                data.data.forEach(state => {
                    const option = document.createElement('option');
                    option.value = state.id;
                    option.textContent = state.name;
                    stateSelect.appendChild(option);
                });
            } else {
                throw new Error('Invalid data format received');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            stateSelect.innerHTML = '<option value="">Error loading states</option>';
            stateSelect.disabled = true;
            alert('Failed to load states. Please try again later.');
        });
});
</script>
@endsection