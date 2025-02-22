
<div class=" col-span-4 blog-card group pb-6">
    <div class="bg-black border-2">
        <img src="/user/uploads/blogs/{{ $imageUrl}}" alt="{{ $title}}" class=" object-cover">
        <div class="absolute top-2 right-2 bg-white rounded-full text-center p-4 flex flex-col items-center justify-center  shadow-md">
            <h6 class="text-2xl font-bold leading-3">{{ \Carbon\Carbon::parse($date)->format('d') }}</h6>
            <p class="text-sm text-red-500 mt-1 leading-3">{{ \Carbon\Carbon::parse($date)->format('M') }}</p>
        </div>

    </div>

    <h4 class="font-md font-bold py-2">{{ Str::limit($title, 42, '...') }} </h4>
    <p class="line-clamp-3">{!! Str::limit($description, 155, '...') !!}</p>
    <a href="{{route('blog', ['id'=>$id,'slug'=>$slug])}}" class="text-orange-600 py-4 group-hover:text-orange-700">Continue Reading</a>
</div>