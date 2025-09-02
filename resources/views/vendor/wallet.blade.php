@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h2>Vendor Wallet</h2>
    <p><strong>Vendor Name:</strong> {{ $vendor->name }}</p>
    <p><strong>Wallet Balance (Received):</strong> ₹{{ number_format($wallet, 2) }}</p>
    {{-- Add transaction history or withdrawal options here if needed --}}
</div>
@endsection