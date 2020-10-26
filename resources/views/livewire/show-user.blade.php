@section('css')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.2/plyr.css"/>
@endsection

<div class="container">
    <video
           crossorigin
           playsinline
           id="video">
    </video>
</div>

@section('js')
    <script src="https://cdn.plyr.io/3.6.2/plyr.polyfilled.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const source = "http://127.0.0.1:8080/f1858d04946835c342068bbc99973d14da7c790721958eb6b5012f58be75.m3u8";
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
