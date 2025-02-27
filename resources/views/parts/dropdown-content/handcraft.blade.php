<div class="dropdown-content-sub-1 bg-white">
    <div class="px-2 py-2 w-full flex flex-wrap f-container">
        
        <div class="row m-4 mt-4 ">                   
                    
            <div class="w-full p-8 flex bg-white gap-8 z-9999 opacity-100">

                <div class=" relative w-3/7 border h-[340px] shadow-lg hover:cursor-pointer p-holder ">
                    <img src="{{ asset('user/uploads/header/' . $headerData['secondRow']['handCrafts']['bannerOne']['image']) }}" class="h-full w-full p-image"
                        alt="mens product">
                    <div
                        class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-full bg-white py-4 text-center bg-opacity-80">
                        <div class="text-lg font-bold text-black">
                            {{$headerData['secondRow']['handCrafts']['bannerOne']['head']}}
                        </div>
                        <div class="text-sm ">
                            <a href="{{$headerData['secondRow']['handCrafts']['bannerOne']['redirect']}}" class="text-orange-600"> {{$headerData['secondRow']['handCrafts']['bannerOne']['button']}} </a>
                        </div>
                    </div>
                </div>

                <div class=" relative w-2/7  hover:cursor-pointer p-holder">
                    <div class="text-xl font-bold text-black  pl-2">
                       <a href="{{ route('user.products' , ['category' => 4]) }}">Handcrafts</a>
                    </div>

                    <div class="menu-item1 mt-6">
                        <a href="{{ route('user.products' , ['category' => 4]) }}">Holy Jewellery</a>
                        <div class="bottom-b"></div>
                    </div>

                    <div class="menu-item1">
                       <a href="{{ route('user.products' , ['category' => 4]) }}">Handmade</a>
                        <div class="bottom-b"></div>
                    </div>

                    <div class="menu-item1">
                        <a href="{{ route('user.products' , ['category' => 4]) }}">Special</a>
                        <div class="bottom-b"></div>
                    </div>

                </div>                

                <div class=" relative w-2/7 border h-[340px] shadow-lg  hover:cursor-pointer p-holder">
                    <img src="{{ asset('images/site-images/home_decor.png') }}" class="h-full w-full p-image " alt="mens product">
                    <div class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-full bg-white py-4 text-center bg-opacity-80">
                        <div class="text-lg font-bold text-black">
                            {{$headerData['secondRow']['handCrafts']['bannerTwo']['head']}}
                        </div>
                        <div class="text-sm">
                            <a href="{{$headerData['secondRow']['handCrafts']['bannerTwo']['redirect']}}" class="text-orange-600"> {{$headerData['secondRow']['handCrafts']['bannerTwo']['button']}} </a>
                        </div>
                    </div>
                </div>

               
                
            </div>
       
    </div>
        
    </div>
</div>