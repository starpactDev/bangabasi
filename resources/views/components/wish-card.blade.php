@php
    $discount = 0;
    if ($originalPrice && $discountedPrice) {
        $discount = ceil((($originalPrice - $discountedPrice) / $originalPrice) * 100);
    }
@endphp

<div class="col-span-4 min-h-64 border border-orange-400 shadow-sm hover:shadow-md {{ $inStock ? '' : 'bnw' }}">
    <div class="card-img min-h-80 relative  border">
        <img src="{{ asset('user/uploads/products/images/' . $image->image) }}" alt="{{ $title }}" class="absolute h-full w-full object-cover">
        @if (!$inStock)
            <p class="absolute p-2 text-center w-full bg-white bg-opacity-60">Out of Stock <span class="px-4 cursor-pointer">&#10007;</span></p>
        @endif
    </div>

    <div class="min-h-24 py-1 px-2 bg-white">
        <h2 class="font-semibold text-gray-600">{{ $title }}</h2>
        <div class="flex items-center justify-between">
            <div class="text-[#388e3c] text-sm font-bold pr-4">{{ $discount }} % OFF</div>
        </div>
        <div class="flex gap-4">
            <del class="text-red-500">₹ {{ $originalPrice }}</del>
            <p class="font-semibold text-slate-700">₹ {{ $discountedPrice }}</p>
        </div>
        <div class="mx-auto w-full flex justify-around my-2 border-t">
            @if ($inStock)
                <button onclick="showSizeModal({{ $id }})" class="bg-orange-600 text-white my-2 w-3/6 leading-8 hover:bg-orange-800"> Cart </button>

                <!-- Hidden form that will be submitted after size selection -->
                <form id="wishlist_addToCart_{{ $id }}" action="{{ route('wishlist.addToCart') }}"
                    method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="wishlist_id" value="{{ $id }}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" id="selected_size_{{ $id }}" name="size" value="">
                    <input type="hidden" name="unit_price" value="{{ $discountedPrice }}">
                </form>

                <!-- Modal -->
                <div id="sizeModal_{{$id}}" class="fixed inset-0 z-10 hidden flex items-center justify-center">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl p-6 relative mx-auto text-left">
                        <!-- Close Button -->
                        <button onclick="closeSizeModal({{ $id }})" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
                            &times;
                        </button>

                        <!-- Modal Content -->
                        <h2 class="text-lg font-bold mb-4 text-center">Select Size</h2>

                        @if ($sizes)
                            <div class="flex flex-wrap gap-4 justify-center">
                                <!-- Clickable Sizes -->
                                @foreach ($sizes as $size)
                                    @if ($size->quantity > 0)
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name="size" value="{{ $size->size }}" data-quantity="{{ $size->quantity }}" class="sr-only peer size-radio" />
                                            <span class="px-2 h-8 flex items-center justify-center border-2 border-gray-300  hover:border-orange-500 peer-checked:bg-orange-500 peer-checked:text-white peer-checked:border-transparent cursor-pointer"> {{ $size->size }} </span>
                                        </label>
                                    @else
                                        <span class="w-12 h-12 flex items-center justify-center border-2 border-gray-300 rounded-full bg-gray-200 text-gray-500 cursor-not-allowed"> {{ $size->size }} </span>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-6 flex justify-center">
                            <button onclick="submitSize({{ $id }}, {{ $discountedPrice }})" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700"> Done </button>
                            <button onclick="closeSizeModal({{ $id }})" class="bg-gray-300 text-black px-6 py-2 rounded ml-4"> Cancel </button>
                        </div>
                    </div>
                </div>

                <script>
                    function showSizeModal(id) {
                        document.getElementById('sizeModal_' + id).style.display = 'flex';
                    }

                    function closeSizeModal(id) {
                        document.getElementById('sizeModal_' + id).style.display = 'none';
                    }

                    function submitSize(id, discountedPrice) {
                        const selectedSize = document.querySelector('#sizeModal_' + id + ' input[name="size"]:checked');
                        const availableQuantity = selectedSize ? parseInt(selectedSize.dataset.quantity) : 0;
                        const quantity = 1;

                        if (!selectedSize) {
                            Swal.fire({
                                title: 'No size selected',
                                text: 'Please select a size before proceeding.',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }

                        if (quantity > availableQuantity) {
                            Swal.fire({
                                title: 'Insufficient Stock',
                                text: `Only ${availableQuantity} item(s) available for this size.`,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }

                        // Prepare data for AJAX
                        const formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('wishlist_id', id);
                        formData.append('quantity', quantity);
                        formData.append('size', selectedSize.value);
                        formData.append('unit_price', discountedPrice);

                        fetch("{{ route('wishlist.addToCart') }}", {
                            method: 'POST',
                            body: formData,
                        })
                        .then(response => {
                            if (!response.ok) throw new Error("Network error");
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                closeSizeModal(id);
                                Swal.fire({
                                    title: 'Product added to cart!',
                                    text: 'Click OK to view your cart page.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.href = "{{ route('cart') }}";
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.message || 'Something went wrong!',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Could not add to cart. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                    }
                </script>
            @endif

            <button onclick="document.getElementById('wishlist_delete_{{ $id }}').submit()" class=" {{ $inStock ? 'bg-neutral-100' : 'bg-neutral-500' }} text-red-600 my-2 {{ $inStock ? 'w-2/6' : 'w-5/6' }} leading-8 hover:bg-red-600 hover:text-white " data-wishlist_id = "{{ $id }}"> &#10008; </button>
            <form id="wishlist_delete_{{ $id }}" action="{{ route('wishlist.delete') }}" method="POST">
                @csrf
                <input type="hidden" name="wishlist_id" value="{{ $id }}">
            </form>
        </div>
    </div>
</div>
