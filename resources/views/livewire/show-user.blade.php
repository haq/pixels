@section('css')
    <style>
        .bottom-left {
            position: absolute;
            bottom: 5px;
            left: 16px;
        }

        .top-right {
            position: absolute;
            top: 5px;
            right: 16px;
        }
    </style>
@endsection

<div class="container">
    <div class="row">
        <div class="col-auto mr-auto row mr-0 ml-0">
            <img src="{{ $user->image() }}" class="rounded-circle" width="64" height="64" alt="user image">
            <div style="position: relative;">
                <h3 class="ml-3">
                    {{ $user->name }}
                </h3>
                <h5 class="ml-3 text-muted">{{ $user->followers()->count() }} followers</h5>
            </div>
        </div>
        @include('includes.follow-button')
    </div>

    <hr>

    <select class="custom-select mr-sm-2" id="sort" wire:model="sortBy">
        <option value="desc">Sort by new</option>
        <option value="asc">Sort by old</option>
    </select>

    <div class="row mt-3">
        @foreach($videos as $video)
            <div class="col-4">
                <div class="card mb-3">
                    <a href="{{ route('videos.show', $video->slug) }}">
                        <img class="card-img-top" src="{{ $video->thumbnail() }}" alt="video thumbnail">
                    </a>
                    <div class="bottom-left">
                        <h4>
                            <span class="badge badge-pill badge-light">
                                    {{ \Illuminate\Support\Str::limit($video->title, $limit = 25, $end = '...')  }}
                            </span>
                        </h4>
                    </div>
                    <div class="top-right">
                        <h5>
                            <span class="badge badge-pill badge-light">
                                {{ date("H:i:s", $video->duration / 1000) }}
                            </span>
                        </h5>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
