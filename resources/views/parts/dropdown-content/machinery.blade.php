<div class="dropdown-content-sub-1 bg-white">
    <div class="px-2 py-2 w-full flex flex-wrap f-container">

        <div class="row m-4 mt-4 ">

            <div class="w-full p-4 flex bg-white gap-8 z-9999 opacity-100">
                @php
                    $subCategories = $activeCategory->get(5)->subCategories->take(5);
                    $cat_id = $activeCategory->get(6)->id;
                @endphp
                <div class=" relative w-1/4 h-[360px] hover:cursor-pointer p-holder">
                    <img src="{{ asset('user/uploads/header/'.$headerData['secondRow']['machinery']['bannerOne']['image']) }}" class="h-full w-full p-image" alt="mens product">
                    <div class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[115%] bg-white py-4 text-center bg-opacity-80">
                        <div class="text-lg font-bold text-black">
                            {{$subCategories[0]->name}}
                        </div>
                        <div class="text-sm">
                            @php
                                $count_product = \App\Models\Product::where('sub_category',$subCategories[0]->id)->count();
                            @endphp

                            @if ($count_product == 1)
                                1 product available
                            @elseif ($count_product == 0)
                                No product available
                            @else
                                {{$count_product}} products available
                            @endif
                        </div>
                    </div>
                </div>

                <div class=" relative w-1/4 h-[360px] hover:cursor-pointer p-holder">
                    <img src="{{ asset('user/uploads/header/'.$headerData['secondRow']['machinery']['bannerTwo']['image']) }}" class="h-full w-full p-image" alt="mens product">
                    <div
                        class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[115%] bg-white py-4 text-center bg-opacity-80">
                        <div class="text-lg font-bold text-black">
                            {{$subCategories[1]->name}}
                        </div>
                        <div class="text-sm">
                            @php
                                $count_product = \App\Models\Product::where('sub_category',$subCategories[1]->id)->count();
                            @endphp

                            @if ($count_product == 1)
                                1 product available
                            @elseif ($count_product == 0)
                                No product available
                            @else
                                {{$count_product}} products available
                            @endif
                        </div>
                    </div>
                </div>

                <div class=" relative w-1/4 h-[360px] hover:cursor-pointer p-holder">
                    <img src="{{ asset('user/uploads/header/'.$headerData['secondRow']['machinery']['bannerThree']['image'] ) }}" class="h-full w-full p-image" alt="mens product">
                    <div class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[115%] bg-white py-4 text-center bg-opacity-80">
                        <div class="text-lg font-bold text-black">
                            {{$subCategories[2]->name}}
                        </div>
                        <div class="text-sm">
                            @php
                                $count_product = \App\Models\Product::where('sub_category',$subCategories[2]->id)->count();
                            @endphp

                            @if ($count_product == 1)
                                1 product available
                            @elseif ($count_product == 0)
                                No product available
                            @else
                                {{$count_product}} products available
                            @endif
                        </div>
                    </div>
                </div>

                <div class=" relative w-1/4 h-[360px] hover:cursor-pointer p-holder">
                    <img src="{{ asset('user/uploads/header/'.$headerData['secondRow']['machinery']['bannerFour']['image']) }}" class="h-full w-full p-image" alt="mens product">
                    <div class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[115%] bg-white py-4 text-center bg-opacity-80">
                        <div class="text-lg font-bold text-black">
                            {{$subCategories[2]->name}}
                        </div>
                        <div class="text-sm">
                            @php
                                $count_product = \App\Models\Product::where('sub_category',$subCategories[2]->id)->count();
                            @endphp

                            @if ($count_product == 1)
                                1 product available
                            @elseif ($count_product == 0)
                                No product available
                            @else
                                {{$count_product}} products available
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
