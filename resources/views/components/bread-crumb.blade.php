<section class="bg-slate-100">

    <div class="mx-auto container flex justify-between  py-3">
        <div>
            <a href="/" class="capitalize font-semibold text-green-600 px-1">Home &#11162;</a>
            <a href="" class="capitalize font-semibold text-slate-600 px-1 ">{{$page}}</a>
        </div>
        <div class="hidden md:block">
            <a href="{{ route('home') }}" class="capitalize font-semibold text-green-600 px-1"> &#129172; Return To Previous Page</a>
        </div>
    </div>
</section>