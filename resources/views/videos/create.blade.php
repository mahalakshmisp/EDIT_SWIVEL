@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">Upload Course Videos</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <form action="{{ route('courses.upload.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="category_id" class="form-label">Subject</label>
                    <select name="category_id" id="subjectDropdown" class="form-control" required>
                        <option value="">Select Subject</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="course_name" class="form-label">Course Name</label>
                    <select name="course_name" id="courseDropdown" class="form-control mb-2" style="display:none;">
                        <option value="">Select Existing Course</option>
                        @foreach(App\Models\Video::all() as $video)
                            <option value="{{ $video->course_name }}" data-category="{{ $video->category_id }}" data-price="{{ $video->price }}">{{ $video->course_name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="new_course_name" class="form-control" placeholder="Or enter new course name">
                </div>
                <div class="mb-3">
                    <label for="author_name" class="form-label">Author Name</label>
                    <select name="author_name" id="authorDropdown" class="form-control mb-2" style="display:none;">
                        <option value="">Select Existing Author</option>
                        @foreach(App\Models\Video::all() as $video)
                            <option value="{{ $video->author_name }}" data-category="{{ $video->category_id }}">{{ $video->author_name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="new_author_name" class="form-control" placeholder="Or enter new author name">
                </div>
                <div class="mb-3">
                    <label for="author_description" class="form-label">Author Description</label>
                    <textarea name="author_description" class="form-control" rows="3" placeholder="Enter author description"></textarea>
                </div>
                <div class="mb-3">
                    <label for="course_description" class="form-label">Course Description</label>
                    <textarea name="course_description" class="form-control" rows="3" placeholder="Enter course description"></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Course Price</label>
                    <input type="number" name="price" id="priceInput" class="form-control" required step="0.01">
                </div>
                <div class="mb-3">
                    <label for="videos" class="form-label">Upload Videos (up to 5)</label>
                    <div class="row g-2">
                        <div class="col-12 col-md-6">
                            <input type="file" name="videos[]" class="form-control mb-2" accept="video/*">
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="file" name="videos[]" class="form-control mb-2" accept="video/*">
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="file" name="videos[]" class="form-control mb-2" accept="video/*">
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="file" name="videos[]" class="form-control mb-2" accept="video/*">
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="file" name="videos[]" class="form-control mb-2" accept="video/*">
                        </div>
                    </div>
                    <small class="text-muted">You may upload 1 to 5 videos. Leave unused inputs empty.</small>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('subjectDropdown').addEventListener('change', function() {
        var selectedCategory = this.value;
        var courseDropdown = document.getElementById('courseDropdown');
        var authorDropdown = document.getElementById('authorDropdown');
        var courseOptions = courseDropdown.options;
        var authorOptions = authorDropdown.options;
        if (selectedCategory) {
            courseDropdown.style.display = '';
            authorDropdown.style.display = '';
            for (var i = 0; i < courseOptions.length; i++) {
                var option = courseOptions[i];
                if (!option.value || option.getAttribute('data-category') === selectedCategory) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            }
            for (var i = 0; i < authorOptions.length; i++) {
                var option = authorOptions[i];
                if (!option.value || option.getAttribute('data-category') === selectedCategory) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            }
        } else {
            courseDropdown.style.display = 'none';
            authorDropdown.style.display = 'none';
        }
    });
    document.getElementById('courseDropdown').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var price = selectedOption.getAttribute('data-price');
        if (price) {
            document.getElementById('priceInput').value = price;
        } else {
            document.getElementById('priceInput').value = '';
        }
    });
</script>
@endsection
