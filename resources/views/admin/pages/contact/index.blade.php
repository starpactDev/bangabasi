@extends('superuser.layouts.master')
@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Messages</h2>
    @php
        // Count non-responded messages (responsed = 0)
        $nonRespondedCount = $message->where('responsed', 0)->count();
    @endphp

    @if($nonRespondedCount > 0)
    <div class="alert alert-warning text-center">
        <strong>{{ $nonRespondedCount }}</strong> non-responded message(s)
    </div>
    @endif
    <div class="row">
        @foreach ($message as $msg)

            <div class="col-md-4 mb-4 ">
                <div class="card" style="min-height: 25rem;">
                    <div class="card-header ">
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
                                    {{ Str::limit($msg->message, 150) }}
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
                                    <textarea class="form-control" id="replyMessage" name="replyMessage" placeholder="Reply to this message." rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Reply</button>
                            </form>
                        @else
                            <span class="badge badge-success my-4 ">Replied</span>
                        @endif
                    </div>
                    <div class="card-footer  text-muted">
                        Sent at: {{ $msg->created_at->format('Y-m-d H:i') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

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
