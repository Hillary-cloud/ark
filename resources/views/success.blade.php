<base href="/public">
@extends('layouts.base')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-success">Payment Success</div>

                <div class="card-body">
                    <p>Your payment was successful and your ad has been listed successfully!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="successModalLabel">Payment Successful</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Your payment was successful and your ad has been listed successfully!
            </div>
            <div class="modal-footer">
                <a href="{{ route('/') }}" class="btn btn-primary">OK</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Show the success modal automatically
    $(document).ready(function () {
        $('#successModal').modal('show');
    });
</script>

@endsection
