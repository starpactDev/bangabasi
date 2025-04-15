<div class="dropdown-content-sub-1 bg-white">
    <div class="px-12 py-12 w-full flex flex-wrap f-container">
        <a href="{{ route('user.products', ['category' => 2]) }}" class=" flex flex-col justify-center  w-1/4 px-12 py-8 hover:cursor-pointer border-r">
            <img src="{{ asset('user/uploads/header/' . $headerData['secondRow']['foodItem']['stickerOne']['image']) }}" class="w-10" >
            {{ $headerData['secondRow']['foodItem']['stickerOne']['subCategory'] ?? 'Unknown' }}
        </a>

        <a href="{{ route('user.products', ['category' => 2]) }}" class=" flex flex-col justify-center  w-1/4 px-12 py-8 hover:cursor-pointer border-r">
            <img src="{{ asset('user/uploads/header/' . $headerData['secondRow']['foodItem']['stickerTwo']['image']) }}" class="w-10" >

            {{ $headerData['secondRow']['foodItem']['stickerTwo']['subCategory'] ?? 'Unknown' }}
        </a>

        <a href="{{ route('user.products', ['category' => 2]) }}" class=" flex flex-col justify-center  w-1/4 px-12 py-8 hover:cursor-pointer border-r">
            <img src="{{ asset('user/uploads/header/' . $headerData['secondRow']['foodItem']['stickerThree']['image']) }}" class="w-10" >
            
            {{ $headerData['secondRow']['foodItem']['stickerThree']['subCategory'] ?? 'Unknown' }}
        </a>

        <a href="{{ route('user.products', ['category' => 2]) }}" class=" flex flex-col justify-center  w-1/4 px-12 py-8 hover:cursor-pointer ">
            <img src="{{ asset('user/uploads/header/' . $headerData['secondRow']['foodItem']['stickerFour']['image']) }}" class="w-10" >

            {{ $headerData['secondRow']['foodItem']['stickerFour']['subCategory'] ?? 'Unknown' }}
        </a>

        
    </div>
</div>