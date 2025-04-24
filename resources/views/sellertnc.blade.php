@extends("layouts.master")
@section('head')
<title>Bangabasi | Terms of Use</title>
@endsection
@section('content')
@php
    $xpage = 'Terms of Use';
    $xprv = 'home';
	use Carbon\Carbon;
@endphp
<x-bread-crumb :page="$xpage" :previousHref="$xprv" />

<section class="min-h-screen bg-neutral-50 my-8">
	<div class="container grid grid-cols-12 gap-4 py-8">
		<div class=" leading-relaxed col-span-12 lg:col-span-8">
            <h2 class=" text-3xl font-semibold my-4">Lorem ipsum dolor sit amet.</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt animi nemo, possimus accusamus consequuntur voluptatem dicta inventore obcaecati suscipit quo molestias sapiente iusto voluptas? Quibusdam, consequuntur quam eaque, molestias tempora nam deserunt unde molestiae quo aspernatur eligendi nobis explicabo maxime odio minima dolorum ut cum rem quae enim illum velit qui possimus ducimus! Facere laboriosam nesciunt aut odio placeat sunt explicabo libero iure obcaecati eveniet alias expedita et iste illum perspiciatis repellat sed illo ad quasi ex velit, inventore atque nihil! At recusandae iste, numquam modi et blanditiis a officia accusantium labore illum, nihil placeat vero, id exercitationem animi. Velit a laborum eos at non nisi labore iste. Quod, reiciendis repudiandae est error recusandae optio at porro saepe cumque veniam, necessitatibus quo ipsum perspiciatis temporibus minima similique veritatis aut quae nam! Assumenda laborum tempora minima esse, excepturi veritatis, atque voluptate, odit eos sunt deleniti provident illo doloribus perspiciatis! Perferendis minima sapiente labore quos eveniet qui placeat incidunt cumque consectetur voluptates vero vitae aperiam aliquid nemo voluptas molestiae, obcaecati laborum odit, quae laudantium! Qui odit libero officiis recusandae deleniti repellendus, error eligendi? Rem nisi quis facilis cumque deleniti asperiores quaerat, magni perspiciatis aut? Quisquam neque soluta maxime cupiditate debitis, odio numquam!</p>
        </div>
        <div class=" leading-relaxed col-span-12 lg:col-span-4">
            <h2 class=" text-3xl font-semibold my-4">Lorem ipsum dolor sit.</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident, vitae! Eaque vero magnam quibusdam asperiores debitis rem voluptatibus, iste dolorem praesentium fuga molestiae. Excepturi nobis vitae unde quia sed. Doloremque dolores cum consequuntur velit eos officia vero temporibus commodi optio sint alias, explicabo corrupti, voluptate at iusto aut quaerat illo quisquam illum. Totam dicta odio deserunt necessitatibus id autem cupiditate temporibus, dolorem ipsa nobis soluta? Soluta, vero possimus eligendi magnam nulla, dolor nobis labore obcaecati architecto corrupti sequi id voluptas? Molestiae doloribus omnis minima est fugiat quae tenetur itaque non dolores, minus modi voluptatum laborum nostrum quis eveniet eius placeat alias veniam accusantium! Beatae dolorem porro sit optio? Voluptatem optio sed eligendi placeat molestiae consequuntur excepturi cum quam odio. Aliquam nobis saepe expedita deleniti excepturi mollitia amet rerum consequatur vitae! Eveniet odio mollitia aliquam et voluptates dolore porro impedit soluta! Saepe, quidem expedita quas quam eveniet temporibus molestiae, laudantium ipsum reprehenderit eaque nesciunt delectus eligendi neque earum provident qui adipisci ipsa eius possimus. Libero, inventore optio soluta dolore, nemo veritatis, sed maiores beatae nulla pariatur voluptates ut rem ullam neque? At possimus harum, labore quidem quibusdam reiciendis, quaerat iste veritatis distinctio laborum ratione! Beatae quisquam quasi ducimus labore commodi sit.</p>
        </div>
    </div>
</section>

@endsection
@push('scripts')

@endpush