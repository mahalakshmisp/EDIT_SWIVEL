@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Welcome, {{ auth('vendor')->user()->name }}!</h2>
    <div class="mt-4">
        <a href="{{ route('courses.upload') }}" class="btn btn-primary mr-2">Upload Your Courses</a>
        <a href="{{ route('vendor.profile') }}" class="btn btn-secondary">Profile Page</a>
    </div>
</div>
@endsection