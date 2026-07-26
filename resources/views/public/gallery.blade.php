@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="fw-bold mb-4">Gallery</h1>
    <div class="row g-4">
        @for($i = 1; $i <= 4; $i++)
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 p-3 text-center">
                    <h5>Event Sample {{ $i }}</h5>
                    <p class="text-muted">Sample showcase for a catering setup.</p>
                </div>
            </div>
        @endfor
    </div>
</div>
@endsection
