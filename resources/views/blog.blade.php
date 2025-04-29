@extends("layouts.master")
@section('head')
<title>Bangabasi | {{$mainBlog->blog_head}}</title>
@endsection
@section('content')
@php
    $xpage = $mainBlog->blog_head;
    $xprv = 'blogs';
	use Carbon\Carbon;
@endphp
<x-bread-crumb :page="$xpage" :previousHref="$xprv" />
<section>
	<div class="container my-6">
		<div class="grid grid-cols-12 gap-4 my-6">
			<div class="col-span-12 lg:col-span-8 border">
				<div class="overflow-hidden group ">
					<img src="{{ $mainBlog->image && file_exists(public_path('user/uploads/blogs/' . $mainBlog->image)) ? asset('user/uploads/blogs/' . $mainBlog->image) : asset('user/uploads/blogs/7.png') }}"  alt="{{$mainBlog->slug}}" class="w-full scale-100 group-hover:scale-125 transition-all duration-300">
				</div>
				<article class="p-4">
					<header class="mb-4">
						<h2 class="text-3xl mb-12 font-semibold">{{$mainBlog->blog_head}}</h2>
						<p class="text-gray-500 text-sm" title="{{$mainBlog->published_at}}">
							<span class="font-medium">Published on: </span> {{ optional($mainBlog->published_at) ? Carbon::parse($mainBlog->published_at)->format('F j, Y') : '' }}
						</p>
						<p class="text-gray-500 text-sm my-2">
							<span class="font-medium">By: </span> {{$mainBlog->author_name}}
						</p>
						<p class="text-gray-500 text-sm my-2 ">
							<span class="font-medium">Views: </span> <span id="viewCount">{{$mainBlog->view_count}}</span>
						</p>
					</header>
					<div class="text-gray-700">
						{!! $mainBlog->blog_description !!}
					</div>

					<div class="inline-block my-6">
						Tags: 
						@if($mainBlog->tags)
							@php
								$tagsArray = explode(',', $mainBlog->tags);
							@endphp
							@foreach($tagsArray as $tag)
								<a href="{{route('blogs.tags', trim($tag))}}" class="p-2 bg-slate-100 hover:bg-slate-200 text-orange-600">{{ trim($tag) }}</a>
							@endforeach
						@else
							<p>No tags available.</p>
						@endif
					</div>
					<div id="article-end"></div>
					<!-- Share Section -->
					<div id="share_section">
						<div class="my-6">
							<span class="font-medium">Share this post:</span>
							<div class="flex space-x-4 mt-2">
								<a href="https://wa.me/?text={{ urlencode(route('blog', ['id' => $mainBlog->id, 'slug' => $mainBlog->slug])) }}" target="_blank" class="p-2 bg-green-500 hover:bg-green-600 text-white rounded-md">
									WhatsApp
								</a>
								<a href="mailto:?subject={{ urlencode($mainBlog->blog_head) }}&body={{ urlencode(route('blog', ['id' => $mainBlog->id, 'slug' => $mainBlog->slug])) }}" target="_blank" class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">
									Email
								</a>
								<a href="sms:?body={{ urlencode(route('blog', ['id' => $mainBlog->id, 'slug' => $mainBlog->slug])) }}" target="_blank" class="p-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">
									SMS
								</a>
								<a href="https://twitter.com/share?url={{ urlencode(route('blog', ['id' => $mainBlog->id, 'slug' => $mainBlog->slug])) }}&text={{ urlencode($mainBlog->blog_head) }}" target="_blank" class="p-2 bg-blue-400 hover:bg-blue-500 text-white rounded-md">
									Twitter
								</a>
								<a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog', ['id' => $mainBlog->id, 'slug' => $mainBlog->slug])) }}" target="_blank" class="p-2 bg-blue-700 hover:bg-blue-800 text-white rounded-md">
									Facebook
								</a>
							</div>
						</div>
					</div>
				</article>
				<div class="space-y-4 my-6 px-4">
					@if($mainBlog->comments->isEmpty())
						<h4>No comments yet</h4>
						<p class="text-gray-600">Be the first to comment!</p>
					@else
						<h4>All Comments</h4>
						@foreach($mainBlog->comments as $comment)
							<div class="flex items-start p-4 bg-gray-100 rounded">
								<img src="{{ asset('user/uploads/profile/'. ($comment->user->image ?? 'default_dp.png') )}}" alt="Profile Image" class="w-10 h-10 rounded-full mr-3">
								<div>
									<p class="text-gray-800 font-medium">{{ $comment->user->firstname.' '.$comment->user->lastname }}</p>
									<p class="text-gray-600 text-sm">{{ $comment->comment }}</p>
								</div>
							</div>
						@endforeach
					@endif
				</div>
				<form method="POST" action="{{ route('blog_comments.store', ['id' => $mainBlog->id]) }}">
					@csrf
					<div class="p-4 my-4">
						@if (session('success'))
							<div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
								{{ session('success') }}
							</div>
						@endif
				
						@if (session('error'))
							<div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
								{{ session('error') }}
							</div>
						@endif
						<input type="hidden" name="blogId" value="{{$mainBlog->id}}">
						<textarea name="comment" rows="3" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-orange-500" placeholder="Add a comment..."></textarea>
						<button type="submit" class=" text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition duration-300  {{ !auth()->check() ? 'opacity-50 cursor-not-allowed bg-gray-500' : 'bg-orange-500' }}" {{ !auth()->check() ? 'disabled' : '' }}>Submit</button>
						@guest
							<p class="text-sm text-red-500 mt-2">You must be <a href="{{ route('login') }}" class="underline">logged in</a> to post a comment.</p>
						@endguest
					</div>
				</form>
			</div>

			<div class="col-span-12 lg:col-span-4 border bg-slate-50 p-4">
				<h3 class="text-xl font-semibold my-2">Related Posts</h3>
				<hr>
				<ul class="mt-4 space-y-4">
				@if($relatedBlogs->isEmpty())
					<li class="text-gray-500">No related blogs to show.</li>
				@else
					@foreach($relatedBlogs as $rBlog)
					<li class="flex items-start space-x-4">
						<img src="{{ $rBlog->image && file_exists(public_path('user/uploads/blogs/' . $rBlog->image)) ? asset('user/uploads/blogs/' . $rBlog->image) : asset('user/uploads/blogs/7.png') }}" alt="{{$rBlog->slug}}" class="w-16 h-16 object-cover rounded">
						<div class="relative">
							<a href="{{route('blog', ['id'=>$rBlog->id, 'slug'=>$rBlog->slug ])}}" class="text-blue-600 font-medium hover:underline">{{$rBlog->blog_head}}</a>
							<p class="text-gray-500 text-sm">{{ Carbon::parse($rBlog->published_at)->format('F j, Y') }}</p>
							<p class="absolute top-5 right-5 text-neutral-500">👁{{$rBlog->view_count}}</p>
						</div>
					</li>
					@endforeach
				@endif
				</ul>
			</div>
		</div>
	</div>
</section>
<script>
    // Function to update view count
    function updateViewCount() {
        // Send AJAX request to update view count
        fetch('{{ route('blogs.updateViewCount', $mainBlog->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}', // CSRF token for security
            },
            body: JSON.stringify({
                blog_id: '{{ $mainBlog->id }}', // Send the blog ID to update views
            }),
        })
        .then(response => response.json())
        .then(data => {
			const viewCount = document.getElementById('viewCount');
			viewCount.innerHTML = data.view_count;
        })
        .catch(error => {
            console.error('Error updating view count:', error);
        });
    }

    // Create an IntersectionObserver to check when the article ends in the viewport
    const articleEndElement = document.getElementById('article-end'); // Make sure the end of the article has this ID

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
				
                updateViewCount();
                observer.unobserve(entry.target); // Stop observing once the end of the article is in view
            }
        });
    }, {
        threshold: 1.0 // Trigger when 100% of the element is visible
    });

    // Start observing the end of the article
    observer.observe(articleEndElement);
</script>
@endsection


