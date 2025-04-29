@extends("layouts.master")
@section('head')
<title>Bangabasi | Blogs</title>
@endsection
@section('content')
@php
    $xpage = 'Blogs';
    $xprv = 'home';
	use Carbon\Carbon;
@endphp
<x-bread-crumb :page="$xpage" :previousHref="$xprv" />
<section>
	<div class="container my-6">
		<div class="my-6">
			<div class="">
				<h3 class="text-2xl font-semibold my-4 text-center">All Blogs</h3>
				<hr>
				<ul class="mt-4 space-y-4 bg-slate-100">
					@foreach($blogs as $blog)
						<li class="grid grid-cols-12 gap-4 group py-8 bg-white">
							<div class="col-span-12 md:col-span-4 lg:col-span-3 relative">
								<div class="w-full h-full">
									<img src="{{asset('user/uploads/blogs/'.$blog->image)}}" alt="{{$blog->slug}}" class="w-full h-full object-cover rounded group-hover:rounded-none ">	
								</div>
								
							</div>
							<div class="col-span-12 md:col-span-8 lg:col-span-9 relative w-full">
								<a href="{{route('blog', ['id'=>$blog->id, 'slug'=>$blog->slug])}}" class="block w-11/12 text-orange-600 text-xl font-medium hover:text-orange-800">{{$blog->blog_head}}</a>
								<div>
									<p class="text-blue-800 text-sm mb-2 inline mr-4"><img src="{{ asset('images/icons/author.svg')}}" alt="" class="inline mr-4">{{$blog->author_name}}</p>
									<p class="text-blue-800 text-sm mt-2 inline"> <img src="{{ asset('images/icons/published.svg')}}" alt="" class="inline mr-4">{{ Carbon::parse($blog->published_at)->format('F j, Y') }}</p>
								</div>

								<p class="line-clamp-3 text-neutral-600 group-hover:text-neutral-900">{!! Str::limit($blog->blog_description, 200, '...') !!}</p>
								<a href="{{route('blog', ['id'=>$blog->id, 'slug'=>$blog->slug])}}" class="text-orange-600 py-4 group-hover:text-orange-700">Continue Reading</a>
								<p class="absolute top-0 right-0 text-neutral-600"><span class="text-xl">👁</span>{{$blog->view_count}}</p>
							</div>
						</li>
					@endforeach
				</ul>
			</div>
			<div class="border bg-slate-50 p-4">
				{{ $blogs->links() }}
			</div>
		</div>
	</div>
</section>
@endsection