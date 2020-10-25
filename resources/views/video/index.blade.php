@extends('layouts.app')

@section('css')
    <style>
        .bottom-left {
            position: absolute;
            bottom: 8px;
            left: 16px;
        }

        .bottom-right {
            position: absolute;
            bottom: 8px;
            right: 16px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h3 class="text-center">
            Videos
        </h3>
        <div class="row">
            @foreach($videos as $video)
                <div class="col-sm-6">
                    <div class="card mb-3">
                        <a href="{{ route('videos.show', $video->slug) }}">
                            <img class="card-img-top" src="{{ $video->thumbnail() }}" alt="Card image cap">
                        </a>
                        <div class="bottom-left">
                            <h3>
                                <img src="{{ $video->user->image() }}" class="rounded-circle" width="42" height="42"
                                     alt="user image">
                                <span class="badge badge-pill badge-light">
                                    {{ $video->title  }}
                                </span>
                            </h3>
                        </div>
                        <div class="bottom-right">
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
    </div>
@endSection
