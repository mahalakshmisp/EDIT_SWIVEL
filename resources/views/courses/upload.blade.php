{{-- ...existing code... --}}
<form method="POST" action="{{ route('courses.upload.store') }}" enctype="multipart/form-data">
    @csrf
    {{-- ...existing form fields... --}}
</form>
{{-- ...existing code... --}}