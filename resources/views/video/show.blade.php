@extends('layouts.app')

@section('content')
    <div class="container">
        @if($video->processed())
            <video controls crossorigin playsinline
                   poster="{{ $video->thumbnail() }}">
            </video>
            <div class="mt-3">
                <h3>{{ $video->title }}</h3>
                <h6 class="text-muted">999 views • {{ $video->created_at->format('F d, Y') }}</h6>
            </div>
            <hr>
            <div class="float-left row mr-0 ml-0">
                <img src="{{ $video->user->image() }}" class="rounded-circle" width="64" height="64" alt="user image">
                <div style="position: relative;">
                    <h3 class="ml-3">
                        <a href="{{ route('user.show', $video->user->name) }}"
                           style="color: #343a40;text-decoration:none;">
                            {{ $video->user->name }}
                        </a>
                    </h3>
                    <h5 class="ml-3 text-muted">{{ $video->user->followers()->count() }} followers</h5>
                </div>
            </div>
            <div class="float-right">
                @if($video->user->id === auth()->id())
                    <button type="button" class="btn btn-primary">Edit Video</button>
                @else
                    <button type="button" class="btn btn-secondary">Follow</button>
                @endif
            </div>
        @else
            <div class="alert alert-info">
                Video is currently being processed and will be available shortly
            </div>
        @endif
    </div>
@endSection

@section('js')
    <script src="https://cdn.plyr.io/3.5.3/plyr.polyfilled.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const source = "{{ $video->video() }}";
            const video = document.querySelector('video');

            // For more options see: https://github.com/sampotts/plyr/#options
            // captions.update is required for captions to work with hls.js
            const player = new Plyr(video, {captions: {active: true, update: true, language: 'en'}});

            if (!Hls.isSupported()) {
                video.src = source;
            } else {
                // For more Hls.js options, see https://github.com/dailymotion/hls.js
                const hls = new Hls();
                hls.loadSource(source);
                hls.attachMedia(video);
                window.hls = hls;
            }

            // Expose player so it can be used from the console
            window.player = player;
        });
    </script>
@endsection
