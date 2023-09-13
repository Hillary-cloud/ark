<base href="/public">

@extends('layouts.base')

@section('content')
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
                                    <a class="text-decoration-none" href="{{route('view-my-ad', $notification->data['ad_uuid']) }}">{{ $notification->data['message'] }}</a>
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
@endsection
