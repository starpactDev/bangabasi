<div class="dropdown-content-sub-1 bg-white">
    <div class="px-2 py-2 w-full flex flex-wrap ">
        <div class="row m-4 mt-4 ">

            <div class="w-full p-4 flex bg-white gap-4 z-9999 opacity-100">
                
                <div class=" relative w-1/3 h-[280px] hover:cursor-pointer p-holder flex flex-col justify-between">
                    <div class="text-xl font-bold text-black pl-2 mb-6">
                        {{ $activeCategory->get(6)->name }}
                    </div>
                    <div>
                        @php
                            $subCategories = $activeCategory->get(6)->subCategories->take(5);
                            $cat_id = $activeCategory->get(6)->id;
                        @endphp
                        @foreach ($subCategories as $value)
                        <a href="{{ url('/products') }}?category={{ $cat_id }}&sub_category={{ $value->id }}">
                            <div class="menu-item1 ">
                                {{ $value->name }}
                                <div class="bottom-b"></div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @if(count($subCategories) < 4) 
                        <a href="mailto:info.bangabasi@gmail.com" class="block text-center px-6 py-2 border hover:bg-neutral-100"><i class="fa fa-envelope px-4 text-lg"></i>Mail Us</a>
                    @endif
                    @if(count($subCategories) < 5) 
                        <a href="tel:+919476168391" class="block text-center px-6 py-2 border hover:bg-neutral-100"><i class="fa fa-phone px-4 text-lg"></i>Call Us</a>
                    @endif
                </div>

                <div class=" flex gap-2 w-7/10 ">
                    <div class=" relative w-5/12 border h-[280px] hover:cursor-pointer p-holder">
                        <img src="{{ asset('user/uploads/header/' . $headerData['secondRow']['electronics']['bannerOne']['image']) }}" class="h-full w-full p-image" alt="mens product">
                        <div class="absolute  bottom-0  left-1/2 -translate-x-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                            <a href="{{$headerData['secondRow']['electronics']['bannerOne']['redirect']}}" class="text-lg font-bold text-black">{{$subCategories[0]->name}}</a>

                        </div>
                    </div>

                    <div class=" relative w-1/3  h-[280px] overflow-hidden hover:cursor-pointer p-holder">
                        <img src="{{ asset('user/uploads/header/' . $headerData['secondRow']['electronics']['bannerTwo']['image']) }}" class="h-full  p-image " alt="mens product">
                        <div class="absolute bottom-0  left-1/2 -translate-x-1/2 z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                            <a href="{{$headerData['secondRow']['electronics']['bannerTwo']['redirect']}}" class="text-lg font-bold text-black">{{$subCategories[1]->name}}</a>
                        </div>
                    </div>                   
    
                    <div class=" relative w-1/3 border h-[280px] hover:cursor-pointer p-holder">
                        <img src="{{ asset('user/uploads/header/' . $headerData['secondRow']['electronics']['bannerThree']['image']) }}" class="h-full w-full p-image " alt="mens product">
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 z-10 w-full bg-white py-4 text-center bg-opacity-80">
                            <a href="{{$headerData['secondRow']['electronics']['bannerThree']['redirect']}}" class="text-lg font-bold text-black">{{$subCategories[2]->name}}</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
