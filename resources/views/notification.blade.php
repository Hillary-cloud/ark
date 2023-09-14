<base href="/public">

@extends('layouts.base')

@section('content')
<style>
    /* Add this CSS class to change the color of read notifications */
.read-notification {
    color: #888; /* Change this color to the desired color for read notifications */
}

</style>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Notifications</div>

                <div class="card-body">
                    @if (count($notifications) > 0)
                        <ul class="list-group ">
                            @foreach ($notifications as $notification)
                                <li class="list-group-item ">
                                    <a class="text-decoration-none {{ $notification->read_at ? 'read-notification' : '' }} notification-link " data-notification-id="{{ $notification->id }}" href="{{route('view-my-ad', $notification->data['ad_uuid']) }}">{{ $notification->data['message'] }}</a>
                                    <p class="text-muted">{{$notification->created_at->diffForHumans()}}</p>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No notifications.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notificationLinks = document.querySelectorAll('.notification-link');

        notificationLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                const notificationId = link.getAttribute('data-notification-id');

                // Send an AJAX request to mark the notification as read
                fetch("{{ url('/mark-notification-as-read') }}/" + notificationId, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (response.ok) {
                        // Add the read-notification class to change the color
                        link.classList.add('read-notification');
                        // Redirect to the notification target URL or handle it as needed
                        window.location.href = link.getAttribute('href');
                    }
                })
                .catch(error => {
                    console.error(error);
                });
            });
        });
    });
</script>


@endsection
