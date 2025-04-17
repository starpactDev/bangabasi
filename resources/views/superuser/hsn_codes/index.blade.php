@extends('superuser.layouts.master')

@section('content')
<!-- CONTENT WRAPPER -->
<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
            <div>
                <h1>HSN Codes</h1>
                <p class="breadcrumbs">
                    <span><a href="{{ Auth::user()->usertype == 'admin' ? route('admin_dashboard') : route('seller_dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>HSN Codes
                </p>
            </div>
        </div>

        <!-- Form to Add/Edit HSN Code -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title" id="form-title">Add HSN Code</h3>
                    </div>
                    <div class="card-body">
                        <form id="hsnForm" action="{{ route('superuser.hsn.store') }}" method="POST">
                            @csrf
                            <input type="hidden" id="hsn_id" name="hsn_id">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="hsn_code">HSN Code</label>
                                    <input type="text" name="hsn_code" id="hsn_code" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="description">Description</label>
                                    <input type="text" name="description" id="description" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="gst">GST (%)</label>
                                    <input type="number" step="0.01" name="gst" id="gst" class="form-control" required>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary" id="form-submit-btn">Add HSN</button>
                                <button type="button" class="btn btn-secondary d-none" id="cancel-edit">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Validation Error:</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Table to display HSN Codes -->
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="responsive-data-table" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>HSN Code</th>
                                        <th>Description</th>
                                        <th>GST (%)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hsns as $hsn)
                                    <tr id="hsn-row-{{ $hsn->id }}">
                                        <td class="hsn-code">{{ $hsn->hsn_code }}</td>
                                        <td class="description">{{ $hsn->description }}</td>
                                        <td class="gst">{{ $hsn->gst }}</td>
                                        <td>
                                            <div class="btn-group">
                                                
                                                <button class="btn btn-outline-success edit-hsn" data-id="{{ $hsn->id }}">Edit</button>
                                                <form action="{{ route('superuser.hsn.destroy', $hsn->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this HSN code?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                                </form>
                                                <button></button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Content -->
</div> <!-- End Content Wrapper -->


@endsection

@push('script')
<!-- Inline Script to Handle Edit -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById('hsnForm');
        const cancelBtn = document.getElementById('cancel-edit');

        document.querySelectorAll('.edit-hsn').forEach(button => {
            button.addEventListener('click', function () {
                const row = document.getElementById('hsn-row-' + this.dataset.id);
                const code = row.querySelector('.hsn-code').innerText;
                const desc = row.querySelector('.description').innerText;
                const gst = row.querySelector('.gst').innerText;

                document.getElementById('form-title').innerText = 'Edit HSN Code';
                document.getElementById('form-submit-btn').innerText = 'Update HSN';
                cancelBtn.classList.remove('d-none');

                document.getElementById('hsn_id').value = this.dataset.id;
                document.getElementById('hsn_code').value = code;
                document.getElementById('description').value = desc;
                document.getElementById('gst').value = gst;

                form.action = `{{ url('/superuser/hsn-code/update') }}/${this.dataset.id}`;
                const hiddenMethod = document.createElement('input');
                hiddenMethod.type = 'hidden';
                hiddenMethod.name = '_method';
                hiddenMethod.value = 'PUT';
                hiddenMethod.id = 'method-spoof';
                form.appendChild(hiddenMethod);
            });
        });

        cancelBtn.addEventListener('click', function () {
            document.getElementById('form-title').innerText = 'Add HSN Code';
            document.getElementById('form-submit-btn').innerText = 'Add HSN';
            cancelBtn.classList.add('d-none');
            form.action = `{{ route('superuser.hsn.store') }}`;
            document.getElementById('hsn_id').value = '';
            document.getElementById('hsn_code').value = '';
            document.getElementById('description').value = '';
            document.getElementById('gst').value = '';
            const methodSpoof = document.getElementById('method-spoof');
            if (methodSpoof) methodSpoof.remove();
        });
    });
</script>
@endpush