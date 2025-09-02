@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">Purchase Subscription for: <span class="text-primary">{{ $course }}</span></h2>
    <div class="card mb-4 border-0 shadow">
        <div class="card-body">
            <h5 class="card-title">Course: {{ $course }}</h5>
            <p class="card-text">Price: ₹{{ $videos->first()->price ?? 'N/A' }}</p>
        </div>
    </div>
    <h4 class="mb-3">Select Payment Method</h4>
    <div class="card border-0 shadow">
        <div class="card-body">
            <form action="{{ route('courses.subscribe', $course) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <select name="payment_method" class="form-control" required>
                        <option value="">Choose a payment method</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="upi">UPI</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Purchase & Subscribe</button>
            </form>
        </div>
    </div>
</div>
@endsection
