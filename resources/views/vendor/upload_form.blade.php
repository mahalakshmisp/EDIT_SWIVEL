@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Upload Information</h2>
    <form method="POST" action="{{ route('vendor.upload.submit') }}">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Upload</button>
    </form>
</div>
@endsection
