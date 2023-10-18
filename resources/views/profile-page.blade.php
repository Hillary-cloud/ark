<base href="/public">
@extends('layouts.base')
@section('content')
    <style>
        .link:hover .card-text {
            text-decoration: underline;
        }
    </style>


    <div class="container my-4">

        <div class="d-flex justify-content-between mb-3">
            <h3 class="">Dashboard</h3>
            <a href="javascript:history.back()" class="text-decoration-none">
                < Back</a>
        </div>
        <div class="card shadow-lg col-md-8 mx-auto">
            <div class="profile-icon text-center mt-4">
                <div class="d-flex justify-content-center">
                    <i class="bi bi-person-circle" style="font-size: 80px;"></i>
                </div>
                {{ ucfirst(Auth::user()->name) }}
                <p style="font-size:13px">{{ Auth::user()->email }}</p>
            </div>
            <div class="row p-3">
                <div class="col-md-6">
                    <a href="{{ route('profile.edit') }}" class="text-decoration-none text-dark link">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-person-up" style="font-size: 25px;"></i></h5>
                                <p class="card-text text-center">Update Profile</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('my-ads') }}" class="text-decoration-none text-dark link">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-badge-ad" style="font-size: 25px;"></i></h5>
                                <p class="card-text text-center">My Adverts</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row p-3">
                <div class="col-md-6">
                    <a href="{{ route('bookmarks') }}" class="text-decoration-none text-dark link">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-bookmark-fill" style="font-size: 25px;"></i></h5>
                                <p class="card-text text-center">Saved Adverts</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('draft') }}" class="text-decoration-none text-dark link">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-file-earmark-fill" style="font-size: 25px;"></i></h5>
                                <p class="card-text text-center">Draft</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row p-3">
                <div class="col-md-6">
                    <a href="{{ route('notification') }}" class="text-decoration-none text-dark link">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-bell-fill" style="font-size: 25px;"></i></h5>
                                <p class="card-text text-center">Notifications
                                    @if (auth()->user()->unreadNotifications->count() > 0)
                                        <span
                                            style="font-size: 10px; background-color:red; border-radius: 10%; color:white; padding:1px 5px;">{{ auth()->user()->unreadNotifications->count() }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('payment-history') }}" class="text-decoration-none text-dark link">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-credit-card-2-back" style="font-size: 25px;"></i>
                                </h5>
                                <p class="card-text text-center">Transactions</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
