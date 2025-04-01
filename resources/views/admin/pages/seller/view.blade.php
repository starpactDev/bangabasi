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
                <h1 class="fw-bold">Seller Details</h1>
                <p class="breadcrumbs"><span><a href="{{route('admin_dashboard')}}">Home</a></span><span><i class="mdi mdi-chevron-right"></i></span>Vendor</p>
            </div>
        </div>

        <div class="container py-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="mdi mdi-storefront me-2"></i> Seller Information</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <img src="{{ asset('user/uploads/seller/logo/'.($seller->logo ?? 'default-logo.png')) }}" class="img-fluid rounded-circle shadow-sm border p-2" alt="Seller Logo">
                        </div>
                        <div class="col-md-8">
                            <h4 class="fw-bold text-primary mb-3">{{ $seller->store_name ?? 'N/A' }}</h4>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center border-bottom">
                                    Email <span class="text-muted">{{ $seller->email ?? 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-bottom " style="gap:1rem;">
                                    <span >Description</span> <span class="text-muted">{{ $seller->description ?? 'No description available' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-bottom">
                                    Status 
                                    <span class="badge px-3 py-2 rounded-pill {{ $seller->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $seller->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-secondary text-primary">
                            <h5 class="mb-0"><i class="mdi mdi-account-circle me-2"></i> User Information</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center border-bottom">
                                    Name <span class="text-muted">{{ $seller->user->firstname ?? 'N/A' }} {{ $seller->user->lastname ?? '' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-bottom">
                                    Contact <span class="text-muted">{{ $seller->user->contact_number ?? 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-bottom">
                                    Email <span class="text-muted">{{ $seller->user->email ?? 'N/A' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="mdi mdi-certificate-outline me-2"></i> GST Details</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center border-bottom">
                                    GST Number <span class="text-muted">{{ $seller->user->gstDetails->gst_number ?? 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-bottom">
                                    Business Name <span class="text-muted">{{ $seller->user->gstDetails->business_name ?? 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-bottom">
                                    Business Type <span class="text-muted">{{ $seller->user->gstDetails->business_type ?? 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-bottom " style="gap:1rem;">
                                    Address <span class="text-muted">{{ $seller->user->gstDetails->address ?? 'N/A' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="mdi mdi-bank me-2"></i> Bank Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom">
                            Bank Name <span class="text-muted">{{ $seller->user->bank->bank_name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom">
                            Branch <span class="text-muted">{{ $seller->user->bank->branch_name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom">
                            IFSC Code <span class="text-muted">{{ $seller->user->bank->ifsc_code ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-bottom">
                            Account Holder <span class="text-muted">{{ $seller->user->bank->account_holder_name ?? 'N/A' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection


@section('script')
	<!-- Data Tables -->
	<script src='admin/assets/plugins/data-tables/jquery.datatables.min.js'></script>
	<script src='admin/assets/plugins/data-tables/datatables.bootstrap5.min.js'></script>
	<script src='admin/assets/plugins/data-tables/datatables.responsive.min.js'></script>
@endsection