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
                    <h1>Message</h1>
                    <p class="breadcrumbs"><span><a href="{{route('admin_dashboard')}}">Home</a></span>
                        <i class="mdi mdi-chevron-right"></i><span>NewsLetter</span> 
                    </p>
                </div>
                <div>
                    <small>
                        Showing {{ $newsletterUsers->count() }} of {{ $newsletterUsers->total() }} messages
                    </small>
                </div>
            </div>

            <div class="product-brand card card-default p-24px">
                <div class="row">
                    <h4>List of NewsLetter Users</h4>
                    <form method="POST" action="">
                        @csrf
                        <!-- User List -->
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="form-check-input" id="select-all"></th>
                                        <th>Email</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Status</th>
                                        <th>Updated At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($newsletterUsers as $user)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input" name="users[]" value="{{ $user->id }}" id="user-{{ $user->id }}">
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td class="{{ $user->first_name ?? 'text-center'}}">{{ $user->first_name ?? '- -' }}</td>
                                        <td class="{{ $user->last_name ?? 'text-center'}}">{{ $user->last_name ?? '- -' }}</td>
                                        <td>
                                            <span class="badge {{ $user->is_subscribed ? 'badge-success' : 'badge-danger' }}">
                                                {{ $user->is_subscribed ? 'Subscribed' : 'Unsubscribed' }}
                                            </span>
                                        </td>
                                        <td title="{{$user->updated_at}}">{{ $user->updated_at->format('d M, y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
    
                        <!-- Message Textarea -->
                        <div class="form-group mt-3">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter your message"></textarea>
                        </div>
    
                        <!-- Send Button -->
                        <button type="submit" class="btn btn-primary mt-3">Send Message</button>
                    </form>
                </div>
                <div class="d-flex justify-content-center">
                    <!-- Inline CSS for custom pagination -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination" style="display: flex; list-style-type: none; padding-left: 0; justify-content: center; margin: 20px 0;">
                            <li class="page-item" style="margin: 0 5px; {{ $newsletterUsers->currentPage() == 1 ? 'filter : grayscale(1); pointer-events:none; ' : '' }}">
                                <a class="page-link" href="{{ $newsletterUsers->previousPageUrl() }}" style="color: #007bff;  border: 1px solid #ddd; padding: 8px 15px; font-size: 16px; border-radius: 4px; text-decoration: none; {{ $newsletterUsers->currentPage() == 1 ? 'background-color: #ddd;' : 'background-color: #fff' }}">Previous</a>
                            </li>
                            @for ($i = 1; $i <= $newsletterUsers->lastPage(); $i++)
                                <li class="page-item " style="margin: 0 5px; ">
                                    <a class="page-link" href="{{ $newsletterUsers->url($i) }}" style=" {{ $newsletterUsers->currentPage() == $i ? 'border: 1px solid #007bff !important;' : 'border: 1px solid #ddd !important;' }} color: #007bff; background-color: #fff;  padding: 8px 15px; font-size: 16px; border-radius: 4px; text-decoration: none;">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor
                            <li class="page-item" style="margin: 0 5px; {{ $newsletterUsers->currentPage() == $newsletterUsers->lastPage() ? 'filter : grayscale(1); pointer-events:none;' : '' }}">
                                <a class="page-link" href="{{ $newsletterUsers->nextPageUrl() }}" style="color: #007bff; border: 1px solid #ddd; padding: 8px 15px; font-size: 16px; border-radius: 4px; text-decoration: none;{{ $newsletterUsers->currentPage() == $newsletterUsers->lastPage() ? 'background-color: #ddd;' : 'background-color: #fff;'}}">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="product-brand card card-default p-24px">
                <div class="row">
                    <h3>Newsletter History</h3>
            
                    <!-- Loop through each newsletter and display in email-like format -->
                    <div class="row mt-4">
                        @foreach($newsLetters as $newsletter)
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <!-- Subject (centered) -->
                                    <h6 class="text-center mb-3">{{ $newsletter->subject }}</h6>
            
                                    <!-- Content (Body) -->
                                    <div class="newsletter-body">
                                        <p>{!! nl2br(e($newsletter->content)) !!}</p>
                                    </div>
                                    
                                    <div class="text-right">
                                        <p><strong>Sent At:</strong> {{ $newsletter->sent_at ? $newsletter->sent_at->format('d M Y, H:i') : 'Not Sent Yet' }}</p>
                                        <p><strong>From:</strong> {{ $newsletter->from_name }}</p>
                                        <small style="color:#007bff;">{{ $newsletter->from_email }}</small>
                                    </div>
                                    <hr>
                                    <!-- Additional Info below the content -->
                                    <div class="d-flex justify-content-between mt-4">
                                        <div>
                                            <p><strong>Recipient Count:</strong> {{ $newsletter->recipient_count }}</p>
                                            <p><strong>Type:</strong> {{ ucfirst($newsletter->type) }}</p>
                                        </div>
                                        <div>
                                            <p><strong>Success Count:</strong> {{ $newsletter->success_count }}</p>
                                            <p><strong>Failure Count:</strong> {{ $newsletter->failure_count }}</p>
                                        </div>
                                    </div>
                                    
                                </div>
                                <p class=" text-center text-white overflow-hidden
                                    @if($newsletter->status == 'sent') bg-success 
                                    @elseif($newsletter->status == 'queued') bg-warning 
                                    @elseif($newsletter->status == 'failed') bg-danger 
                                    @else bg-secondary 
                                    @endif">
                                    {{ ucfirst($newsletter->status) }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
            
                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center">
                        <!-- Inline CSS for custom pagination -->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination" style="display: flex; list-style-type: none; padding-left: 0; justify-content: center; margin: 20px 0;">
                                <li class="page-item" style="margin: 0 5px; {{ $newsLetters->currentPage() == 1 ? 'filter : grayscale(1); pointer-events:none; ' : '' }}">
                                    <a class="page-link" href="{{ $newsLetters->previousPageUrl() }}" style="color: #007bff;  border: 1px solid #ddd; padding: 8px 15px; font-size: 16px; border-radius: 4px; text-decoration: none; {{ $newsLetters->currentPage() == 1 ? 'background-color: #ddd;' : 'background-color: #fff' }}">Previous</a>
                                </li>
                                @for ($i = 1; $i <= $newsLetters->lastPage(); $i++)
                                    <li class="page-item " style="margin: 0 5px; ">
                                        <a class="page-link" href="{{ $newsLetters->url($i) }}" style=" {{ $newsLetters->currentPage() == $i ? 'border: 1px solid #007bff !important;' : 'border: 1px solid #ddd !important;' }} color: #007bff; background-color: #fff;  padding: 8px 15px; font-size: 16px; border-radius: 4px; text-decoration: none;">
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endfor
                                <li class="page-item" style="margin: 0 5px; {{ $newsLetters->currentPage() == $newsLetters->lastPage() ? 'filter : grayscale(1); pointer-events:none;' : '' }}">
                                    <a class="page-link" href="{{ $newsLetters->nextPageUrl() }}" style="color: #007bff; border: 1px solid #ddd; padding: 8px 15px; font-size: 16px; border-radius: 4px; text-decoration: none;{{ $newsLetters->currentPage() == $newsLetters->lastPage() ? 'background-color: #ddd;' : 'background-color: #fff;'}}">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            
        </div> <!-- End Content -->
    </div> <!-- End Content Wrapper -->

@endsection
@push('script')
<script id="moreText">
    function toggleMessage(link, messageId) {
        const messageContent = document.querySelector(`#message-content-${messageId}`);
        const previewText = document.querySelector(`#message-preview-${messageId}`);
        const isExpanded = messageContent.style.display === "block";

        if (isExpanded) {
            messageContent.style.display = "none";
            previewText.style.display = "inline";
            link.textContent = "More";
        } else {
            messageContent.style.display = "block";
            previewText.style.display = "none";
            link.textContent = "Less";
        }
    }

</script>
<script id="selectAll">
    // Select All functionality
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="users[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endpush

