<div class="dropdown-content-sub-1 bg-white">
    <div class="px-2 py-2 w-full flex flex-wrap ">
        <div class="row m-4 mt-4 ">

            <div class="w-full p-4 flex bg-white gap-4 z-9999 opacity-100">
                <div class=" relative w-5/12  h-[280px] hover:cursor-pointer p-holder  ">
                    <img src="{{ asset('user/uploads/header/'.$headerData['secondRow']['comboOffer']['bannerOne']['image']) }}" class="h-full w-full p-image" alt="mens product">
                    <div class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10  bg-white py-4 text-center bg-opacity-80 " style="width: 101%;">
                        <div class="text-lg font-bold text-black">
                            {{ $headerData['secondRow']['comboOffer']['bannerOne']['head'] }}
                        </div>
                        <div class="text-md font-bold text-orange-600">
                            <a href="{{$headerData['secondRow']['comboOffer']['bannerOne']['redirect']}}">{{ $headerData['secondRow']['comboOffer']['bannerOne']['button'] }}</a>
                            
                        </div>
                    </div>
                </div>

                <div class=" flex gap-2 w-7/10 ">

                    <div class=" relative w-1/3 h-[280px] hover:cursor-pointer p-holder">
                        <div class="text-xl text-black font-bold pl-2">
                           Grooming
                        </div>

                        <div class="menu-item1 mt-6">
                            Dark to Bright
                            <div class="bottom-b"></div>
                        </div>
    
                        <div class="menu-item1 ">
                            Poor to Rich
                            <div class="bottom-b"></div>
                        </div>
    
                        <div class="menu-item1">
                            Loafers to Proffessionals
                            <div class="bottom-b"></div>
                        </div>
    
                        <div class="menu-item1">
                            Gift Items
                            <div class="bottom-b"></div>
                        </div>
    
                    </div>

                    <div class=" relative w-1/3  h-[280px] overflow-hidden hover:cursor-pointer p-holder">
                        <img src="{{ asset('user/uploads/header/'. $headerData['secondRow']['comboOffer']['bannerTwo']['image']) }}" class="h-full  p-image "  alt="mens product">
                        <div class="absolute bottom-0  left-1/2 -translate-x-1/2  text white z-10 w-[105%] bg-white py-4 text-center bg-opacity-80">
                            <div class="text-lg font-bold text-black">
                                <a href="{{$headerData['secondRow']['comboOffer']['bannerTwo']['redirect']}}">{{$headerData['secondRow']['comboOffer']['bannerOne']['head']}}</a>
                               
                            </div>
                        </div>
                    </div>                   
    
    
                    <div class=" relative w-1/3 border h-[280px] hover:cursor-pointer p-holder">
                        <img src="{{ asset('user/uploads/header/'.$headerData['secondRow']['comboOffer']['bannerThree']['image']) }}" class="h-full w-full p-image " alt="mens product">
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 text white z-10 w-[101%] bg-white py-4 text-center bg-opacity-80">
                            <div class="text-lg font-bold text-black">
                                <a href="{{$headerData['secondRow']['comboOffer']['bannerThree']['head']}}">{{$headerData['secondRow']['comboOffer']['bannerThree']['head']}}</a>
                            </div>
                        </div>
                    </div>
                </div>
     
            </div>

        </div>
    </div>
</div>