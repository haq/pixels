@props(['video', 'showUserImage'])

@section('css')
    <style>
        .top-left {
            position: absolute;
            top: 8px;
            left: 12px;
        }

        .top-right {
            position: absolute;
            top: 5px;
            right: 16px;
        }

        .bottom-left {
            position: absolute;
            bottom: 5px;
            left: 16px;
        }
    </style>
@endsection

<div class="col-4">
    @if($showUserImage)
        <div class="card mb-3">
            <a href="{{ route('videos.show', $video->slug) }}">
                <img class="card-img-top" src="{{ $video->thumbnail }}" alt="video thumbnail">
            </a>
            <div class="top-left">
                <h4>
                    <a href="{{ route('users.show', $video->user->name) }}" style="text-decoration: none;">
                        <img src="{{ $video->user->image }}"
                             class="rounded-circle"
                             width="42"
                             height="42"
                             alt="user image">
                    </a>
                    <span class="badge rounded-pill bg-light text-dark">
                        {{ Str::limit($video->title, $limit = 25, $end = '...')  }}
                    </span>
                </h4>
            </div>
            <div class="bottom-left">
                <h5>
                    <span class="badge rounded-pill bg-light text-dark">{{ date("H:i:s", $video->duration / 1000) }}</span>
                </h5>
            </div>
        </div>
    @else
        <div class="card mb-3">
            <a href="{{ route('videos.show', $video->slug) }}">
                <img class="card-img-top" src="{{ $video->thumbnail }}" alt="video thumbnail">
            </a>
            <div class="bottom-left">
                <h4>
                <span class="badge rounded-pill bg-light text-dark">
                    {{ Str::limit($video->title, $limit = 25, $end = '...')  }}
                </span>
                </h4>
            </div>
            <div class="top-right">
                <h5>
                    <span class="badge rounded-pill bg-light text-dark">{{ date("H:i:s", $video->duration / 1000) }}</span>
                </h5>
            </div>
        </div>
    @endif
</div>
