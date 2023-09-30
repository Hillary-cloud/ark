<base href="/public">
@extends('layouts.base')
@section('content')

    <div class="container">
        <div class="card w-100 m-3 shadow-sm p-2">
            <div class="d-flex justify-content-between">
                <h3 class="fw-bold">Transactions</h3>
                <a href="javascript:history.back()" class="text-decoration-none">< Back</a>
            </div>
        </div>
        <div class="card w-100 p-2 m-3">
            @php
                use App\Models\Payment;
            @endphp
            @if (Payment::where('user_id',auth()->user()->id)->count() < 1)
                <p class="text-danger text-center">No transaction yet</p>
            @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover text-center">
                    <thead class="bg-success text-light">
                        <tr>
                            <th>Transaction Ref</th>
                            <th>Amount</th>
                            <th>Transaction Type</th>
                            <th>Transaction Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $payment->reference_number }}</td>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $payment->payment_for }}</td>
                                <td>{{ $payment->created_at }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            @endif
            </div>
        </div>
    </div>
        
@endsection
