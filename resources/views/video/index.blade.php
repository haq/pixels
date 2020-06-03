@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="text-center">
            Videos
        </h3>
        <div class="row">
            @foreach($videos as $video)
                <div class="col-sm-6">
                    <div class="card mb-3">
                        <img class="card-img-top" src="{{ $video->thumbnail() }}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{ $video->title }}</h5>
                            <a href="{{ $video->url() }}" class="btn btn-primary">Watch</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endSection
