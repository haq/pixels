@extends('layouts.app')

@section('css')
    <style>
        .top-left {
            position: absolute;
            top: 8px;
            left: 12px;
        }

        .bottom-left {
            position: absolute;
            bottom: 8px;
            left: 12px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h3 class="text-center">
            Videos
        </h3>
        <hr>
        <div class="row">
            @foreach($videos as $video)
                <div class="col-4">
                    <div class="card mb-3">
                        <a href="{{ route('videos.show', $video->slug) }}">
                            <img class="card-img-top" src="{{ $video->thumbnail() }}" alt="video thumbnail">
                        </a>
                        <div class="top-left">
                            <h4>
                                <a href="{{ route('users.show', $video->user->name) }}" style="text-decoration: none;">
                                    <img src="{{ $video->user->image() }}"
                                         class="rounded-circle"
                                         width="42"
                                         height="42"
                                         alt="user image">
                                </a>
                                <span class="badge badge-pill badge-light">
                                    {{ \Illuminate\Support\Str::limit($video->title, $limit = 25, $end = '...')  }}
                                </span>
                            </h4>
                        </div>
                        <div class="bottom-left">
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
@endSection
