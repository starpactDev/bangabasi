@extends('superuser.layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .text-danger {
            color: red !important;
        }
    </style>
    <!-- CONTENT WRAPPER -->
    <div class="ec-content-wrapper">
        <div class="content">
            <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
                <div>
                    <h1>Manage Product Under This Particular Section</h1>

                </div>

            </div>

            <div class="product-brand card card-default p-24px">
                <div class="row mb-m-24px">


                    <div class="col-12">
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="table">
                                    <table class="table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center fw-bold">Section</th>
                                                <th class="text-center fw-bold">Manage Products</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($section as  $sec)
                                            <tr class="text-center">
                                                <td >
                                                    {{ $sec->name }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('manage.products', ['section' => $sec->slug]) }}" class="btn btn-outline-success"
                                                        style="border-radius: 0 15px 0 15px !important;">Manage</a>

                                                </td>
                                            </tr>
                                            @endforeach



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal -->





                </div>
            </div>



           


        </div> <!-- End Content -->
    </div> <!-- End Content Wrapper -->
@endsection

@push('script')
@endpush
