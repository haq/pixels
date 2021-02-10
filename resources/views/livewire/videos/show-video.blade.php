<div class="container">
    @if($video->processed())
        <div wire:ignore>
            <video id="video"
                   poster="{{ $video->thumbnail }}"
                   controls
                   crossorigin
                   playsinline>
            </video>
        </div>

        <div class="mt-3">
            @if($editMode)
                <input type="text"
                       class="form-control @error('title') is-invalid @enderror"
                       id="title"
                       wire:model.defer="title">

                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            @else
                <h3>{{ $video->title }}</h3>
            @endif
            <h6 class="text-muted">999 views • {{ $video->created_at->format('F d, Y') }}</h6>
        </div>

        <hr>

        <div class="row">
            <div class="col-auto">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ $video->user->image }}"
                             class="rounded-circle"
                             width="64"
                             height="64"
                             alt="user image">
                    </div>
                    <div class="col-md-8">
                        <h4>
                            <a href="{{ route('users.show', $video->user->name) }}"
                               style="color: #343a40;text-decoration:none;">
                                {{ $video->user->name }}
                            </a>
                        </h4>
                        <h6 class="text-muted ms-1">{{ $video->user->followers()->count() }} followers</h6>
                    </div>
                </div>
            </div>
            <div class="col-auto ms-auto">
                @if(auth()->id() === $video->user->id)
                    @if($editMode)
                        <button type="button" class="btn btn-outline-secondary"
                                wire:click="$set('editMode', false)">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-success" wire:click="submit">
                            Save
                        </button>
                    @else
                        <button type="button" class="btn btn-primary" wire:click="enableEditMode">
                            Edit Video
                        </button>
                    @endif
                @else
                    <x-follow-button :user="$video->user"/>
                @endif
            </div>
        </div>
    @else
        <div class="alert alert-info">
            Video is currently being processed and will be available shortly
        </div>
    @endif
</div>


@section('js')
    <script src="https://cdn.plyr.io/3.6.4/plyr.polyfilled.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script type="application/javascript">
        document.addEventListener('DOMContentLoaded', () => {
            const source = "{{ $video->video }}";
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
    <style>
        .plyr {
            border-radius: 6px;
        }
    </style>
@endsection
