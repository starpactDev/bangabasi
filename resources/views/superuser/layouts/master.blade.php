<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Bongobasi - Seller Dashboard By Starpact">

	<title>Bangabasi {{ Auth::user()->usertype == 'admin' ? 'Admin' : 'Seller'}} Dashboard</title>

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

	<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

	<!-- PLUGINS CSS STYLE -->



	<link href="{{ url('/') }}/admin/assets/plugins/simplebar/simplebar.css" rel="stylesheet" />
    <link href="{{ url('/') }}/admin/assets/plugins/slick/slick.min.css" rel='stylesheet'>
	<link href="{{ url('/') }}/admin/assets/plugins/swiper/swiper-bundle.min.css" rel='stylesheet'>
	<!-- No Extra plugin used -->

	<link href="{{ url('/') }}/admin/assets/plugins/data-tables/datatables.bootstrap5.min.css" rel='stylesheet'>
	<link href="{{ url('/') }}/admin/assets/plugins/data-tables/responsive.datatables.min.css" rel='stylesheet'>
	<!-- Starpact CSS -->
	<link id="starpact-css" href="{{ url('/') }}/admin/assets/css/starpact.css" rel="stylesheet" />

	<!-- FAVICON -->
	<link href="{{ url('/') }}/admin/assets/img/bangabasi_favicon.png" rel="shortcut icon" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
	<!-- Yeild Head -->
	@yield('head')
</head>

<body class="ec-header-fixed ec-sidebar-fixed ec-sidebar-light ec-header-light" id="body">

	<!--  WRAPPER  -->
	<div class="wrapper">
		<!-- LEFT MAIN SIDEBAR -->
		
		@if(Auth::user()->usertype == 'admin')
			@include('admin.layouts.sidebar')
		@else
			@include('seller.layouts.sidebar')
		@endif

		<!--  PAGE WRAPPER -->
		<div class="ec-page-wrapper">
			<!-- Header -->
			<header class="ec-main-header" id="header">
				<nav class="navbar navbar-static-top">
					<!-- Sidebar toggle button -->
					<button id="sidebar-toggler" class="sidebar-toggle"></button>
					<!-- search form -->

					<!-- search form end -->

					<!-- navbar right -->
					<div class="navbar-right">
						<ul class="nav navbar-nav">
							<!-- User Account -->
							<li class="dropdown user-menu">
								<button class="dropdown-toggle nav-link ec-drop" data-bs-toggle="dropdown" aria-expanded="false">
									@if(Auth::user()->usertype == 'admin')
										<img src="{{ Auth::user()->image ? asset('user/uploads/profile/' . Auth::user()->image) : asset('admin/assets/img/user/u1.jpg') }}" class="user-image" alt="User Image" />
									@else
										<img src="{{ Auth::user()->image ? asset('user/uploads/seller/logo/' . Auth::user()->image) : asset('admin/assets/img/user/u1.jpg') }}" class="user-image" alt="User Image" />
									@endif
								</button>
								<ul class="dropdown-menu dropdown-menu-right ec-dropdown-menu">
									<!-- User image -->
									<li class="dropdown-header">
										@if(Auth::user()->usertype == 'admin')
											<img src="{{ Auth::user()->image ? asset('user/uploads/profile/' . Auth::user()->image) : asset('admin/assets/img/user/u1.jpg') }}" class="img-circle" alt="User Image" />
										@else
											<img src="{{ Auth::user()->image ? asset('user/uploads/seller/logo/' . Auth::user()->image) : asset('admin/assets/img/user/u1.jpg') }}" class="img-circle" alt="User Image" />
										@endif
										<div class="d-inline-block">
											{{ Auth::user()->firstname }} {{ Auth::user()->lastname }} <small class="pt-1">{{ Auth::user()->email }}</small>
										</div>
									</li>
									<li>
										<a href="{{route('admin_profile')}}">
											<i class="mdi mdi-account"></i> My Profile
										</a>
									</li>

									<li class="dropdown-footer">
										@if(Auth::user()->usertype == 'admin')
											<a href="{{route('admin_logout') }}"> <i class="mdi mdi-logout"></i> Log Out </a>
										@else
											<a href="{{route('seller_logout')}}"> <i class="mdi mdi-logout"></i> Log Out </a>
										@endif										
									</li>
								</ul>
							</li>

						</ul>
					</div>
				</nav>
			</header>
			<!-- End Header-->

			<!-- CONTENT WRAPPER -->

				@yield('content')

			<!-- End Content Wrapper -->

			<!-- Footer -->
			<footer class="footer mt-auto">
				<div class="copyright bg-white">
					<p>
						Copyright &copy; <span id="ec-year"></span><a class="text-primary"
						href="" target="_blank"> Starpact Admin Dashboard</a>. All Rights Reserved.
					  </p>
				</div>
			</footer>
			<!-- End Footer -->

		</div>
		<!-- End Page Wrapper -->

	</div>
	<!-- End Wrapper -->
	<!-- Common Javascript -->
    <script src="{{ url('/') }}/admin/assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

    <script src="{{ url('/') }}/admin/assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('/') }}/admin/assets/plugins/simplebar/simplebar.min.js"></script>
    <script src="{{ url('/') }}/admin/assets/plugins/jquery-zoom/jquery.zoom.min.js"></script>
    <script src="{{ url('/') }}/admin/assets/plugins/slick/slick.min.js"></script>
    <script src="{{ url('/') }}/admin/assets/plugins/swiper/swiper-bundle.min.js"></script>
    <!-- Data Tables -->
    <script src="{{ url('/') }}/admin/assets/plugins/data-tables/jquery.datatables.min.js"></script>
    <script src="{{ url('/') }}/admin/assets/plugins/data-tables/datatables.bootstrap5.min.js"></script>
    <script src="{{ url('/') }}/admin/assets/plugins/data-tables/datatables.responsive.min.js"></script>
    <script src="{{ url('/') }}/admin/assets/plugins/tags-input/bootstrap-tagsinput.js"></script>


    <!-- Chart -->
    <script src="{{ url('/') }}/admin/assets/plugins/charts/Chart.min.js"></script>
    <script src="{{ url('/') }}/admin/assets/js/chart.js"></script>

    <!-- Google map chart -->
    <script src="{{ url('/') }}/admin/assets/plugins/charts/google-map-loader.js"></script>
    <script src="{{ url('/') }}/admin/assets/plugins/charts/google-map.js"></script>

    <!-- Date Range Picker -->
    <script src="{{ url('/') }}/admin/assets/plugins/daterangepicker/moment.min.js"></script>
    <script src="{{ url('/') }}/admin/assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="{{ url('/') }}/admin/assets/js/date-range.js"></script>

    <!-- Option Switcher -->
    <script src="{{ url('/') }}/admin/assets/plugins/options-sidebar/optionswitcher.js"></script>

    <!-- Custom -->
    <script src="{{ url('/') }}/admin/assets/js/ekka.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>	<!-- Yeild Javascript -->
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300,  // Set the height of the editor
                minHeight: null,  // Set the minimum height
                maxHeight: null,  // Set the maximum height
                toolbar: [
                    // [groupName, [list of buttons]]
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather', 'Roboto'],
                fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '28', '32', '36', '48'],
            });
            $('.dropdown-toggle').dropdown();
        });
    </script>
		@stack('script')
	<!-- End Yeild Javascript -->
</body>

</html>
