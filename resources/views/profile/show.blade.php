@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">My Profile</h2>
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <h4 class="card-title">{{ Auth::user()->name }}</h4>
            <p class="card-text"><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p class="card-text"><strong>Phone:</strong> {{ Auth::user()->phone }}</p>
            <p class="card-text"><strong>School:</strong> {{ Auth::user()->school }}</p>
            <p class="card-text"><strong>Department:</strong> {{ Auth::user()->department }}</p>
            <p class="card-text"><strong>Address:</strong> {{ Auth::user()->address }}</p>
            <p class="card-text"><strong>District:</strong> {{ Auth::user()->district }}</p>
            <p class="card-text"><strong>Gender:</strong> {{ Auth::user()->gender }}</p>
        </div>
    </div>
    <h4 class="mb-3">Courses Purchased</h4>
    <div class="row g-4">
        @foreach(Auth::user()->subscriptions as $subscription)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">{{ $subscription->course_name }}</h5>
                        <a href="{{ route('courses.show', $subscription->course_name) }}" class="btn btn-primary w-100">View Course</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
