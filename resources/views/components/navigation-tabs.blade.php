<div class="flex flex-wrap justify-center gap-4 px-8 py-4 bg-slate-50 my-4">
    <div class="min-w-80 text-center py-4">
        <a href="{{ route('myprofile') }}" 
           class="uppercase text-xl font-normal cursor-pointer 
                  {{ Route::currentRouteName() === 'myprofile' ? 'text-green-600' : 'text-gray-500' }} 
                  hover:text-black">
            <svg class="h-7 inline align-top mx-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ Route::currentRouteName() === 'myprofile' ? 'currentColor' : 'none' }}" stroke="currentColor" role="img" aria-labelledby="personIconTitle" stroke-width="2" stroke-linecap="square" stroke-linejoin="miter">
                <title id="personIconTitle">Person</title>
                <path d="M4,20 C4,17 8,17 10,15 C11,14 8,14 8,9 C8,5.667 9.333,4 12,4 C14.667,4 16,5.667 16,9 C16,14 13,14 14,15 C16,17 20,17 20,20" />
            </svg>
            My Profile
        </a>
    </div>
    <div class="min-w-80 text-center py-4">
        <a href="{{ route('myorders') }}" 
           class="uppercase text-xl font-normal cursor-pointer 
                  {{ Route::currentRouteName() === 'myorders' ? 'text-green-600' : 'text-gray-500' }} 
                  hover:text-black">
            <svg class="order-icon h-7 inline mx-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ Route::currentRouteName() === 'myorders' ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 6h15l1.5 9H7.5L6 6z" />
                <circle cx="8" cy="21" r="1" />
                <circle cx="17" cy="21" r="1" />
                <path d="M1 1h4l1 4h14l1 4H4l-1-4H1V1z" />
            </svg>
            All Orders
        </a>
    </div>
    <div class="min-w-80 text-center py-4">
        <a href="{{ route('wishlist') }}" 
           class="uppercase text-xl font-normal cursor-pointer 
                  {{ Route::currentRouteName() === 'wishlist' ? 'text-green-600' : 'text-gray-500' }} 
                  hover:text-black">
            <svg class="heart-icon h-7 inline mx-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ Route::currentRouteName() === 'wishlist' ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
            </svg>
            Wish List
        </a>
    </div>
</div>
