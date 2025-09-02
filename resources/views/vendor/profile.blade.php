@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Welcome, {{ $vendor->name }}</h2>
    <p><strong>Total Uploaded Videos:</strong> {{ $videos->count() }}</p>
    <p><strong>Wallet Amount (Received):</strong> ₹{{ number_format($wallet, 2) }}</p>

    <h4>Your Uploaded Videos</h4>
    @forelse($videos as $video)
        <div class="card mb-3">
            <div class="card-body">
                <h4 style="color: #007bff;"><strong>Video Uploaded Details:</strong> {{ $video->title }}</h4>
                <strong>Author Name:</strong> {{ $vendor->name }}<br>
                <strong>Category:</strong> {{ $video->category->name ?? 'N/A' }}<br>
                <strong>Price:</strong> ₹{{ $video->price ?? 'N/A' }}<br>
                <strong>Vendor Receives (70%):</strong> ₹{{ $video->price ? number_format($video->price * 0.7, 2) : 'N/A' }}<br>
                <strong>Description:</strong> {{ $video->description }}<br>
                <strong>Uploaded At:</strong> {{ $video->created_at->format('d M Y H:i') }}<br>
                <hr>
                <strong>Purchase Status:</strong>
                @if($video->purchases->count() > 0 || $video->subscriptions->count() > 0)
                    <span style="color: green; font-weight: bold;">Purchased</span>
                @else
                    <span style="color: red; font-weight: bold;">Not Purchased</span>
                @endif
                <br>
                <strong>Purchase History:</strong>
                @if($video->purchases->count())
                    <ul>
                        @foreach($video->purchases as $purchase)
                            <li>User: {{ $purchase->user->name ?? 'Unknown' }} ({{ $purchase->user->email ?? 'Unknown' }}) - Purchased on {{ $purchase->created_at->format('d M Y H:i') }} | Vendor Receives: ₹{{ $video->price ? number_format($video->price * 0.7, 2) : 'N/A' }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No purchases yet.</p>
                @endif
                <strong>Subscription History:</strong>
                @if($video->subscriptions->count())
                    <ul>
                        @foreach($video->subscriptions as $subscription)
                            <li>User: {{ $subscription->user->name ?? 'Unknown' }} ({{ $subscription->user->email ?? 'Unknown' }}) - Subscribed on {{ $subscription->created_at->format('d M Y H:i') }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No subscriptions yet.</p>
                @endif
            </div>
        </div>
    @empty
        <p>No videos uploaded yet.</p>
    @endforelse
</div>
@endsection
