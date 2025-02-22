<section class="brands py-12">
    <h2 class="text-2xl text-center font-bold">Brands Connected with Bangabasi</h2>
    <div class="container swiper5 brand overflow-hidden">
        <div class="swiper-wrapper">
            @php 
                $brands = App\Models\Brand::all();
            @endphp
            @foreach ($brands as $brand)
                <div class="swiper-slide mx-auto  brand-col py-8" title="{{ $brand->brand_name }}">
                    <div class="border-l-2  border-gray-300">
                        <img src="/user/uploads/brand/images/{{ $brand->brand_image }}" alt="{{ $brand->brand_name }}" class="block mx-auto hover:opacity-80 ">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>