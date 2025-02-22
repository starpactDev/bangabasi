@extends("layouts.master")
@section('head')
    <title>Bangabasi | Coming Soon </title>
@endsection
@section('content')




<!-- MAIN CSS -->
<link rel="stylesheet" href="{{ url('/') }}/coming_soon/css/templatemo-style.css">
<section id="home">
    <div class="overlay"></div>
      <div class="container">
           <div class="row">

                <div class="col-md-12 col-sm-12">
                    <div class="home-info">
                        <h1>
                            We are getting ready <br>
                            to launch the <b style="color:orange">{{ request()->get('page', 'this') }}</b> page soon!
                        </h1>
                        <ul class="countdown">
                            <h1 style="font-weight:600;font-size:75px!important">COMING SOON</h1>
                        </ul>
                    </div>
                </div>

           </div>
      </div>
 </section>


    
@endsection
