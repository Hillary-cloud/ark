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
                <div class="d-flex justify-content-between p-2">
                    <div class="fw-bold">Notification</div>
                    <a href="javascript:history.back()" class="text-decoration-none">
                        < Back</a>
                </div>

                <div class="card-body">
                    @if (count($notifications) > 0)
                        <ul class="list-group ">
                            @foreach ($notifications as $notification)
                                <li class="list-group-item ">
                                    @if ($notification->type == 'App\Notifications\AdCreatedNotification')
                                    <div class="d-flex justify-content-between">
                                        <p class="bg-success text-light p-2 text-center" style="border-radius: 10px; width:150px">Advert listed</p>  
                                        <a href="{{ route('delete-notification', $notification->id) }}"
                                            onclick="event.preventDefault(); {{ route('delete-notification', $notification->id) }}"><i class="bi bi-x-circle" style="color: black"></i></a> 
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="text-decoration-none {{ $notification->read_at ? 'read-notification' : '' }} notification-link " data-notification-id="{{ $notification->id }}" href="{{route('view-my-ad', $notification->data['ad_uuid']) }}">{{ $notification->data['message'] }}</a>
                                            <p class="text-muted">{{$notification->created_at->diffForHumans()}}</p>
                                        </div>
                                        
                                    </div>
                                    @elseif($notification->type == 'App\Notifications\AdExpired')
                                    <div class="d-flex justify-content-between">
                                    <p class="bg-danger text-light p-2 text-center" style="border-radius: 10px; width:150px">Advert delisted</p>   
                                    <a href="{{ route('delete-notification', $notification->id) }}"
                                        onclick="event.preventDefault(); {{ route('delete-notification', $notification->id) }}"><i class="bi bi-x-circle" style="color: black"></i></a>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="text-decoration-none {{ $notification->read_at ? 'read-notification' : '' }} notification-link " data-notification-id="{{ $notification->id }}" href="{{route('view-my-ad', $notification->data['ad_uuid']) }}">{{ $notification->data['message'] }}</a>
                                            <p class="text-muted">{{$notification->created_at->diffForHumans()}}</p>
                                        </div>
                                        
                                    </div>
                                    @else
                                    <div class="d-flex justify-content-between">
                                        <p class="bg-primary text-light p-2 text-center" style="border-radius: 10px; width:150px">Welcome</p>   
                                        <a href="{{ route('delete-notification', $notification->id) }}"
                                            onclick="event.preventDefault(); {{ route('delete-notification', $notification->id) }}"><i class="bi bi-x-circle" style="color: black"></i></a>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <a class="text-decoration-none {{ $notification->read_at ? 'read-notification' : '' }} notification-link " data-notification-id="{{ $notification->id }}" href="{{route('welcome-notification', $notification->id) }}">{{ $notification->data['message'] }}</a>
                                                <p class="text-muted">{{$notification->created_at->diffForHumans()}}</p>
                                            </div>
                                            
                                        </div>
                                    @endif
                                   
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
