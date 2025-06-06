<div class="dropdown-content-sub-1 bg-white">
    <div class="px-12 py-12 w-full flex flex-wrap f-container">
        @foreach($headerData['secondRow']['dashaKarma'] as $sticker)
            <a href="{{ $sticker['redirect'] }}" class="flex flex-col justify-center items-center w-1/4 px-12 py-6 hover:cursor-pointer border-r">
                <!-- Dynamic Image -->
                <img src="{{ asset('user/uploads/header/' . $sticker['image']) }}" class="w-18">
                <!-- Dynamic Subcategory Name -->
                <span >{{ $sticker['subCategory'] }}</span>
            </a>
        @endforeach
    </div>
</div>