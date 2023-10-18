<base href="/public">
@extends('layouts.base')
@section('content')
    <style>
        p {
            margin-bottom: 20px;
        }
    </style>

    <div class="container my-4">

        <div class="d-flex justify-content-between mb-3">
            <h3 class="">Welcome, {{ ucfirst(auth()->user()->name) }}</h3>
            <a href="javascript:history.back()" class="text-decoration-none">
                < Back</a>
        </div>
        <div class="card shadow-lg col-md-8 mx-auto">

            <div class="p-4">
                <h1>Dear {{ ucfirst(auth()->user()->name) }},</h1>

                <p>A heartfelt welcome to Tetmart!</p>

                <p>We're thrilled to have you join our community, where we specialize in connecting individuals with the
                    perfect lodgings and services tailored to their unique needs.</p>

                <p>{{ ucfirst(auth()->user()->name) }}, your decision to be a part of Tetmart marks the beginning of an
                    exciting journey. Whether you're a student seeking a comfortable place near your campus or a
                    professional in search of the best way to render your service, Tetmart is here to simplify and enhance
                    your experience.</p>

                <p>Explore our listings to discover a diverse range of options, from cozy living spaces to essential
                    amenities. Tetmart is more than just an ad listing website; it's a dynamic platform designed to cater to
                    the needs of our diverse user community.</p>

                <p>We're committed to continually improving Tetmart to meet the expectations of our diverse user base.</p>

                <p>Once again, welcome to Tetmart, {{ ucfirst(auth()->user()->name) }}. We're here to help you find not just
                    lodgings and services but a community that understands and supports your unique requirements.</p>

                <p>Happy exploring!</p>

                <p>Warm regards,<br>
                    Tetmart Team</p>
            </div>

        </div>
    </div>
@endsection
