@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="d-flex align-items-center mb-4">
        <img src="{{ $user->profile_image ?? '/default-profile.png' }}" alt="Profile" style="width:60px;height:60px;border-radius:50%;margin-right:15px;">
        <h2>{{ $user->name }}</h2>
    </div>
    <h4>Your Purchase History</h4>
    <ul>
        @forelse($purchases as $purchase)
            <li>
                <strong>Video:</strong> {{ $purchase->video->title ?? 'Unknown' }}<br>
                <strong>Price:</strong> ₹{{ $purchase->video->price ?? 'N/A' }}<br>
                <strong>Purchased At:</strong> {{ $purchase->created_at->format('d M Y H:i') }}
            </li>
        @empty
            <li>No purchases yet.</li>
        @endforelse
    </ul>
</div>
@endsection
