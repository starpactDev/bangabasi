@extends('superuser.layouts.master')

@section('head')
	<!-- Data Tables -->
	<link href='admin/assets/plugins/data-tables/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='admin/assets/plugins/data-tables/responsive.datatables.min.css' rel='stylesheet'>
@endsection

@section('content')
	<div class="ec-content-wrapper">
		<div class="content">
			<div class="breadcrumb-wrapper breadcrumb-contacts">
				<div>
					<h1>Vendor List</h1>
					<p class="breadcrumbs"><span><a href="{{route('admin_dashboard')}}">Home</a></span><span><i class="mdi mdi-chevron-right"></i></span>Vendor</p>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="ec-vendor-list card card-default">
						<div class="card-body">
							
						</div>
					</div>
				</div>
			</div>

		</div> <!-- End Content -->
	</div>
@endsection

@section('script')
	<!-- Data Tables -->
	<script src='admin/assets/plugins/data-tables/jquery.datatables.min.js'></script>
	<script src='admin/assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
	<script src='admin/assets/plugins/data-tables/datatables.responsive.min.js'></script>
@endsection