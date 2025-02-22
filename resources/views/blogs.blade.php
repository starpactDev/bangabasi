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
		<div class="grid grid-cols-12 gap-4 my-6">
			<div class="col-span-12 lg:col-span-12  px-6">
				<h3 class="text-2xl font-semibold my-4 text-center">All Blogs</h3>
				<hr>
				<ul class="mt-4 space-y-4 bg-slate-100">
					@foreach($blogs as $blog)
						<li class="flex items-start space-x-4 group px-4 py-8 bg-white">
							<img src="{{asset('user/uploads/blogs/'.$blog->image)}}" alt="{{$blog->slug}}" class="w-72 object-cover rounded group-hover:rounded-none ">
							<div class="relative w-full">
								<a href="{{route('blog', ['id'=>$blog->id, 'slug'=>$blog->slug])}}" class="text-orange-600 text-xl font-medium hover:text-orange-800">{{$blog->blog_head}}</a>
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
			<div class="col-span-12 lg:col-span-12 border bg-slate-50 p-4">
			{{ $blogs->links() }}
			</div>
		</div>
	</div>
</section>
@endsection