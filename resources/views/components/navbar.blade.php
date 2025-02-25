<div class="lg:hidden w-full h-16 bg-orange-600 text-white sticky bottom-0 z-50 flex justify-between items-center px-4 gap-6">
    <a href="{{ route('home') }}" class="flex-1 text-center ">
        <i class="fa fa-home block"></i>
        <span class="text-xs">Home</span>
    </a>
    
    <a href="{{ route('sellers.index') }}" class="flex-1 text-center ">
        <i class="fa fa-users block"></i>
        <span class="text-xs">Sellers</span>
    </a>
    <a href="{{ route('cart') }}" class="flex-1 text-center relative">
        <i class="fa fa-shopping-cart block"></i>
        <span class="text-xs">Cart</span>
        @if($cartCount > 0)
            <span class="absolute -top-2 right-4 inline-flex items-center justify-center w-4 h-4 ms-2 text-xs font-semibold text-gray-800 bg-yellow-300 rounded-full">
                {{ $cartCount }}
            </span>
        @endif
    </a>
    <a href="{{ route('myprofile') }}" class="flex-1 text-center ">
        <i class="fa fa-user block"></i>
        <span class="text-xs">Profile</span>
    </a>
</div>