@extends('superuser.layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .text-danger {
            color: red !important;
        }
        .active {
            background-color: #d4edda;
            color: #155724;
        }

        .inactive {
            background-color: #f8d7da;
            color: #721c24;
        }

        .amount-coupon {
            background-color: #e2e3e5;
        }

        .percentage-coupon {
            background-color: #cce5ff;
        }
    </style>
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
                <div>
                    <h1>Configuration</h1>
                    <p class="breadcrumbs"><span><a href="{{ route('admin_dashboard') }}">Home</a></span>
                        <span><i class="mdi mdi-chevron-right"></i></span> Configuration
                    </p>
                </div>

            </div>

            <div class="product-brand ">
                <div class="row my-4">
                    @forelse ($coupons as $coupon)
                        @php
                            $isActive = \Carbon\Carbon::parse($coupon->expiration_date)->isFuture();  // Check if the coupon is active
                        @endphp
                        <div class="col-md-4 mb-4">
                            <div class="card" style="border-left: 5px solid {{ $isActive ? '#28a745' : '#dc3545' }};">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $coupon->coupon_code }}</h5>
                                    <p class="card-text">
                                        @if ($coupon->discount_amount)
                                            <strong>Discount:</strong> ₹{{ number_format($coupon->discount_amount, 2) }}
                                        @else
                                            <strong>Discount:</strong> {{ $coupon->discount_percentage }}%
                                        @endif
                                    </p>
                                    <p class="card-text"><strong>Expiration Date:</strong> {{ \Carbon\Carbon::parse($coupon->expiration_date)->format('Y-m-d') }}</p>
                                    <p class="card-text"><strong>Status:</strong>
                                        <span class="badge {{ $isActive ? 'badge-success' : 'badge-danger' }}">
                                            {{ $isActive ? 'Active' : 'Inactive' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning">
                                No coupons found.
                            </div>
                        </div>
                    @endforelse
                </div>
                
                <div class="card p-4 my-4">
                    <h3 class="mb-4">Set Coupons</h3>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="row mb-m-24px">
                        <div class="col-md-6">
                            <form action="{{ route('admin.coupon.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="coupon_type" value="amount">
                                <div class="form-group">
                                    <label for="coupon_code">Coupon Code</label>
                                    <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Enter coupon code" required>
                                </div>
                    
                                <div class="form-group">
                                    <label for="discount_amount">Discount Amount</label>
                                    <input type="number" class="form-control" id="discount_amount" name="discount_amount" placeholder="Enter discount amount" required>
                                </div>
                    
                                <div class="form-group">
                                    <label for="expiration_date">Expiration Date</label>
                                    <input type="date" class="form-control" id="expiration_date" name="expiration_date" min="{{ now()->format('Y-m-d') }}" required>
                                </div>
                    
                                <button type="submit" class="btn btn-primary">Create Coupon</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('admin.coupon.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="coupon_type" value="percentage">
                                <div class="form-group">
                                    <label for="coupon_code">Coupon Code</label>
                                    <input type="text" class="form-control" id="percentage_coupon_code" name="coupon_code" placeholder="Enter coupon code" required>
                                </div>
                    
                                <div class="form-group">
                                    <label for="discount_percentage">Discount Percentage</label>
                                    <input type="number" class="form-control" id="percentage_discount_percentage" name="discount_percentage" placeholder="Enter discount percentage" required>
                                </div>
                    
                                <div class="form-group">
                                    <label for="expiration_date">Expiration Date</label>
                                    <input type="date" class="form-control" id="percentage_expiration_date" name="expiration_date" min="{{ now()->format('Y-m-d') }}" required>
                                </div>
                    
                                <button type="submit" class="btn btn-primary">Create Coupon</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            


        </div> <!-- End Content -->
    </div> <!-- End Content Wrapper -->
@endsection

@push('script')

@endpush
