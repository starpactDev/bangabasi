<div class="container bg-orange-700 my-6 swiper4 marquee overflow-x-hidden">
    <div class="swiper-wrapper">
    @if($marquees->isNotEmpty())
        @foreach($marquees as $marquee)
        <p class="swiper-slide text-center text-white py-2 font-semibold">{!! $marquee->text !!}</p>
        @endforeach
    @endif
    </div>
</div>