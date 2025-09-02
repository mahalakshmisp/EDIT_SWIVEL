@extends('layouts.app')
@section('content')
<style>
    .video-thumb { width:100%; height:90px; overflow:hidden; border-radius:6px; background:#000; }
    .video-thumb video { width:100%; height:100%; object-fit:cover; display:block; }
    .play-overlay { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; pointer-events:none; }
    .play-overlay i { font-size:36px; color:rgba(255,255,255,0.9); text-shadow:0 2px 6px rgba(0,0,0,0.6); }
</style>

<div class="container py-5">
    <h2 class="mb-4 fw-bold">Course: {{ $course }}</h2>

    <h4 class="mb-3">Videos</h4>
    <div class="row flex-row flex-nowrap overflow-auto mb-4" style="gap: 1rem;">
        @foreach($videos as $video)
            @php
                $streamUrl = route('video.stream', $video->id) . '?path=' . urlencode($video->video_path);
                $modalId = 'videoModal' . $loop->index;
            @endphp
            <div class="col-3">
                <div class="card h-100 border-0 shadow">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">{{ pathinfo($video->video_path, PATHINFO_BASENAME) }}</h5>

                        @if(Auth::check() && $subscribed)
                            <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" data-video-src="{{ $streamUrl }}">
                                <div class="video-thumb position-relative">
                                    <video muted playsinline preload="metadata">
                                        <source src="{{ $streamUrl }}" type="video/mp4">
                                    </video>
                                    <div class="play-overlay"><i class="bi bi-play-circle-fill"></i></div>
                                </div>
                            </button>
                            <!-- Play button below thumbnail -->
                            <button type="button" class="btn btn-primary mt-2 w-100" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" data-video-src="{{ $streamUrl }}">Play Video</button>
                        @else
                            <div class="video-thumb position-relative" style="opacity:0.7;">
                                <video muted playsinline preload="metadata">
                                    <source src="{{ $streamUrl }}" type="video/mp4">
                                </video>
                                <div class="play-overlay"><i class="bi bi-lock-fill"></i></div>
                            </div>
                            <div class="text-center mt-2 text-muted">Subscribe to enable full video</div>
                            <!-- Purchase button below thumbnail -->
                            <a href="{{ route('courses.purchase', $course) }}" class="btn btn-outline-primary mt-2 w-100">Purchase to Play</a>
                        @endif

                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade video-modal" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="{{ $modalId }}Label">{{ pathinfo($video->video_path, PATHINFO_BASENAME) }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0 bg-black d-flex align-items-center justify-content-center">
                            @if(Auth::check() && $subscribed)
                                <video class="modal-video" width="100%" height="100%" controls playsinline preload="metadata">
                                    <source src="" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @else
                                <div class="text-center text-white p-4">Subscribe to enable full video</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // When a thumbnail or Play button is clicked, set the modal video's source immediately
    document.querySelectorAll('[data-video-src]').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            var src = btn.getAttribute('data-video-src');
            var targetSelector = btn.getAttribute('data-bs-target');
            if (!targetSelector) return;
            var modalEl = document.querySelector(targetSelector);
            if (!modalEl) return;
            var video = modalEl.querySelector('.modal-video');
            if (video) {
                var sourceEl = video.querySelector('source');
                if (sourceEl) {
                    sourceEl.setAttribute('src', src);
                    try { video.load(); } catch (err) {}
                }
            }
        });
    });

    // Also handle modal show/hide for play/pause and fallback setting
    var modals = document.querySelectorAll('.video-modal');
    modals.forEach(function(modalEl) {
        modalEl.addEventListener('show.bs.modal', function (event) {
            var trigger = event.relatedTarget;
            if (!trigger) return;
            var src = trigger.getAttribute('data-video-src');
            var video = modalEl.querySelector('.modal-video');
            if (video && src) {
                var sourceEl = video.querySelector('source');
                if (sourceEl && !sourceEl.getAttribute('src')) {
                    sourceEl.setAttribute('src', src);
                    try { video.load(); } catch (e) { }
                }
                video.play().catch(function(err){
                    console.debug('Autoplay prevented', err);
                });
            }
        });

        modalEl.addEventListener('hide.bs.modal', function () {
            var video = modalEl.querySelector('.modal-video');
            if (video) {
                try { video.pause(); } catch (e) { }
                var sourceEl = video.querySelector('source');
                if (sourceEl) {
                    sourceEl.setAttribute('src', '');
                    try { video.load(); } catch (e) { }
                }
            }
        });
    });
});
</script>
@endsection
