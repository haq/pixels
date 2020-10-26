<div class="container">
    @if($video->processed())
        <video controls
               crossorigin
               playsinline
               poster="{{ $video->thumbnail() }}"
               id="video">
        </video>
        @livewire('videos.show-video-data', ['video' => $video])
    @else
        <div class="alert alert-info">
            Video is currently being processed and will be available shortly
        </div>
    @endif
</div>

@if($video->processed())

@section('js')
    <script src="https://cdn.plyr.io/3.6.2/plyr.polyfilled.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const source = "{{ $video->video() }}";
            const video = document.querySelector('video');

            // For more options see: https://github.com/sampotts/plyr/#options
            // captions.update is required for captions to work with hls.js
            const player = new Plyr(video, {
                tooltips: {
                    controls: true,
                    seek: true
                },
                storage: {
                    enabled: true,
                    key: 'plyr'
                }
            });

            if (Hls.isSupported()) {
                // For more Hls.js options, see https://github.com/dailymotion/hls.js
                const hls = new Hls();
                hls.loadSource(source);
                hls.attachMedia(video);
                window.hls = hls;
            } else {
                video.src = source;
            }

            // Expose player so it can be used from the console
            window.player = player;
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.2/plyr.css"/>
@endsection

@endif
