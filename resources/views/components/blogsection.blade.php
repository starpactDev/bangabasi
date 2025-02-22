
<section class="blogs">
	<div class="container p-6 border-2">
		<div class="flex justify-between py-6">
			<h2 class="text-2xl font-bold">Most Popular Blog Post</h2>
			<a href="{{ route('blogs')}}" class="text-secondary text-sm font-semibold">View All Posts</a>
		</div>
		<div class="swiper6 blog relative overflow-hidden ">
			<div class="swiper-wrapper">
                   

				@foreach($blogs as $blog)
				<div class="swiper-slide ">
					@php
						$slug=$blog['slug'];
					@endphp
					<x-posts :id="$blog['id']" :slug="$slug" :imageUrl="$blog['image']" :title="$blog['blog_head']" :description="$blog['blog_description']" :date="$blog['published_at']" />
				</div>
				@endforeach
			</div>
			<!-- Pagination -->
			<div class="swiper-pagination"></div>
			<!-- Navigation Arrows -->
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
		</div>
	</div>
</section>