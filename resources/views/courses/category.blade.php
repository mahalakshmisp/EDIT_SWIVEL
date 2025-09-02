@extends('layouts.app')
@section('content')
<div class="container">
    <h2>{{ $category->name }} Courses</h2>
    <ul>
        @foreach($courses as $course)
            <li>
                <a href="{{ route('courses.show', $course->course_name) }}">{{ $course->course_name }}</a>
                (Author: {{ $course->author_name }}, Price: ${{ $course->price }})
            </li>
        @endforeach
    </ul>
</div>
@endsection
