@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="text-center">
            {{ $video->title }}
        </h3>

        <div class="row mt-5">
            <div class="video">
                @if($video->processed())
                    <video controls crossorigin playsinline
                           poster="{{ $video->thumbnail() }}">
                    </video>
                @else
                    <div class="alert alert-info w-100">
                        Video is currently being processed and will be available shortly
                    </div>
                @endif
            </div>
        </div>
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