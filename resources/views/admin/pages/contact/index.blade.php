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
                        <span><i class="mdi mdi-chevron-right"></i></span> Message
                    </p>
                </div>
                <div>
                    <small>
                        Showing {{ $message->count() }} of {{ $message->total() }} messages
                    </small>
                </div>

            </div>

            @php
                // Count non-responded messages (responsed = 0)
                $nonRespondedCount = $message->where('responsed', 0)->count();
            @endphp

            @if($nonRespondedCount > 0)
            <div class="alert alert-warning text-center">
                <strong>{{ $nonRespondedCount }}</strong> non-responded message{{($nonRespondedCount > 1) ? 's' : ''}}.
            </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert"> {{ session('success') }} </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert"> {{ session('error') }} </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="product-brand card card-default p-24px">
                <div class="row">
                    @foreach ($message as $msg)
            
                        <div class="col-md-6 mb-4 ">
                            <div class="card" style="min-height: 25rem;">
                                <div class="card-header flex-column justify-content-start align-items-start" >
                                    <h5 class="card-title">{{ $msg->name }}</h5>
                                    <h6 class="card-subtitle text-muted">{{ $msg->email }}</h6>
                                </div>
                                <div class="card-body ">
                                    <div class="message-preview">
                                        <p class="card-text d-inline">
                                            <span id="message-content-{{ $msg->id }}" class="message-content" style="display: none;">
                                                {{ $msg->message }}
                                            </span>
                                            <span id="message-preview-{{ $msg->id }}" class="message-preview-text">
                                                {{ Str::limit($msg->message, 200) }}
                                            </span>
                                        </p>
                                        @if(strlen($msg->message) > 150)
                                        <button  class="d-inline text-primary" style="color: blue;" onclick="toggleMessage(this, {{ $msg->id }})">More</button>
                                        @endif
                                    </div>
                                    <!-- If the message has not been responded to -->
                                    @if (!$msg->responsed)
                                        <form action="{{ route('admin.contact.respond', $msg->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="replyMessage"></label>
                                                <textarea class="form-control" id="replyMessage" name="replyMessage" placeholder="Reply to this message." rows="2" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Send Reply</button>
                                        </form>
                                    @else
                                        <span class="badge badge-success my-4 ">Replied</span>
                                    @endif
                                </div>
                                <div class="card-footer  text-muted">
                                    Received at: {{ $msg->created_at->format('Y-m-d H:i') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <!-- Pagination links -->

            <div class="d-flex justify-content-center">
                <!-- Inline CSS for custom pagination -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination" style="display: flex; list-style-type: none; padding-left: 0; justify-content: center; margin: 20px 0;">
                        <li class="page-item" style="margin: 0 5px; {{ $message->currentPage() == 1 ? 'filter : grayscale(1); cursor-event:none' : '' }}">
                            <a class="page-link" href="{{ $message->previousPageUrl() }}" style="color: #007bff; background-color: #fff; border: 1px solid #ddd; padding: 8px 15px; font-size: 16px; border-radius: 4px; text-decoration: none;">Previous</a>
                        </li>
                        @for ($i = 1; $i <= $message->lastPage(); $i++)
                            <li class="page-item " style="margin: 0 5px; ">
                                <a class="page-link" href="{{ $message->url($i) }}" style=" {{ $message->currentPage() == $i ? 'border: 1px solid #007bff !important;' : 'border: 1px solid #ddd !important;' }} color: #007bff; background-color: #fff;  padding: 8px 15px; font-size: 16px; border-radius: 4px; text-decoration: none;">
                                    {{ $i }}
                                </a>
                            </li>
                        @endfor
                        <li class="page-item" style="margin: 0 5px; {{ $message->currentPage() == $message->lastPage() ? 'filter : grayscale(1); cursor-event:none' : '' }}">
                            <a class="page-link" href="{{ $message->nextPageUrl() }}" style="color: #007bff; background-color: #fff; border: 1px solid #ddd; padding: 8px 15px; font-size: 16px; border-radius: 4px; text-decoration: none;">Next</a>
                        </li>
                    </ul>
                </nav>
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
@endpush
