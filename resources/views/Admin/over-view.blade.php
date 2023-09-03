<base href="/public">
@extends('layouts.base')
@section('content')

    <div class="container mx-auto my-4">
        <div class="card p-2 my-3">
            <div class="d-flex justify-content-between ">
                <h3>Overview</h3>
                <a href="javascript:history.back()" class="text-decoration-none">< Back</a>
            </div>
        </div>
        <div class="card p-3 shadow-sm">
            <div class="row">
                
                <div class="col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                <div class="card shadow-lg bg-primary text-light" style="height: 200px">
                    <div class="card-body">
                        @php
                        use App\Models\User;
                    @endphp
                        <h3>Users</h3>
                        <h2 class="text-center">{{User::count()}}</h2>
                    </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                        <div class="card shadow-lg bg-secondary text-light" style="height: 200px">
                            <div class="card-body">
                                @php
                                use App\Models\Advert;
                            @endphp
                                <h3>Total Ads</h3>
                                <h2 class="text-center">{{Advert::where('draft', false)->count()}}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                        <div class="card shadow-lg bg-success text-light" style="height: 200px">
                            <div class="card-body">
                                <h3>Listed Ads</h3>
                                <h2 class="text-center">{{Advert::where(['draft' => false, 'active' => true])->count()}}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                        <div class="card shadow-lg bg-danger text-light" style="height: 200px">
                            <div class="card-body">
                                <h3>De-listed Ads</h3>
                                <h2 class="text-center">{{Advert::where(['expiration_date' => null, 'draft' => false, 'active' => false])->count()}}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                        <div class="card shadow-lg bg-warning text-light" style="height: 200px">
                            <div class="card-body">
                                @php
                                use App\Models\Location;
                            @endphp
                                    <h3>States</h3>
                                    <h2 class="text-center">{{Location::count()}}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                            <div class="card shadow-lg bg-primary text-light" style="height: 200px">
                                <div class="card-body">
                                    @php
                                    use App\Models\School;
                                @endphp
                                        <h3>Schools</h3>
                                        <h2 class="text-center">{{School::count()}}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                                <div class="card shadow-lg bg-secondary text-light" style="height: 200px">
                                    <div class="card-body">
                                        @php
                                        use App\Models\SchoolArea;
                                    @endphp
                                            <h3>School Areas</h3>
                                            <h2 class="text-center">{{SchoolArea::count()}}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                                    <div class="card shadow-lg bg-success text-light" style="height: 200px">
                                        <div class="card-body">
                                            @php
                                            use App\Models\Lodge;
                                        @endphp
                                                <h3>Lodges</h3>
                                                <h2 class="text-center">{{Lodge::count()}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                                        <div class="card shadow-lg bg-danger text-light" style="height: 200px">
                                            <div class="card-body">
                                                @php
                                                use App\Models\Service;
                                            @endphp
                                                    <h3>Services</h3>
                                                    <h2 class="text-center">{{Service::count()}}</h2>
                                                </div>
                                            </div>
                                        </div>
            
            </div>
        </div>
    </div>
@endsection