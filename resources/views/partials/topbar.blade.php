@foreach($topbars as $topbar)
	@if($layout === 'layout1')
		<div class="container grid grid-cols-12  gap-4 border-4">
			<div class="col-span-12 md:col-span-6 xl:col-span-3 min-h-64 p-6 relative ">
				<img src="/user/uploads/banner/{{ $topbar->banner_image }}" alt="" srcset="" class="h-full object-cover w-full">
				<div class="absolute p-6 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-5  w-full h-full flex flex-col justify-center banner-shirt">
					<h6 class="text-xl font-semibold text-center text-white">{{ $topbar->overlay_text_heading }}</h6>
					<p class="text-sm text-gray-100 text-center">{{ $topbar->overlay_text_body }}</p>
				</div>
			</div>
			<div class="col-span-12 md:col-span-6 xl:col-span-3 min-h-64 p-6 flex flex-wrap flex-row items-center justify-between ">
				<h2 class="text-2xl font-semibold">{{ $topbar->description_head }}</h2>
				<p class="text-slate-800">{{ $topbar->description_text }}</p>
			</div>
			<div class="col-span-12 xl:col-span-6 grid grid-cols-6 sm:grid-cols-12 md:grid-cols-12 lg:grid-cols-12 h-fit lg:h-full gap-4 items-center">
				@foreach([$topbar->category1, $topbar->category2, $topbar->category3, $topbar->category4] as $category)
					@if($category)
						<div class="col-span-3 p-2 lg:p-6 mx-auto aspect-square cursor-pointer hover:shadow-lg">
							<a href="">
								<img src="/user/uploads/category/image/{{ $category->images }}" alt="" class="text-center mx-auto mb-2">
								<p class="text-center">{{ $category->name }}</p>
							</a>
						</div>
					@endif
				@endforeach
			</div>
		</div>
	@else
	<div class="container grid grid-cols-12 gap-4 border-4 p-4">
        <div class="col-span-12 md:col-span-6 min-h-64 ">
            <img src="/user/uploads/banner/{{ $topbar->section_1_image }}" alt="" srcset="" class="h-full object-cover ">
        </div>
        <div class="col-span-12 md:col-span-6 min-h-64 ">
            <img src="/user/uploads/banner/{{ $topbar->section_2_image }}" alt="" srcset="" class="h-full object-cover ">
        </div>
    </div>
	@endif
@endforeach