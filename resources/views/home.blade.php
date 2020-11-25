@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-auto mr-auto row mr-0 ml-0">
                <h3>Feed</h3>
            </div>
            <div class="col-auto">
                <a role="button" href="{{ route('videos.create') }}" class="btn btn-primary">
                    Upload video
                </a>
            </div>
        </div>

        @if(count($today) > 0)
            <hr>
            <h5>Today</h5>
            <div class="row mt-3">
                @foreach($today as $video)
                    <x-video-card :video="$video" :show-user-image="true"/>
                @endforeach
            </div>
        @endif

        @if(count($yesterday) > 0)
            <hr>
            <h5>Yesterday</h5>
            <div class="row mt-3">
            @foreach($yesterday as $video)
                <x-video-card :video="$video" :show-user-image="true"/>
            @endforeach
            </div>
        @endif

        @if(count($week) > 0)
            <hr>
            <h5>Week</h5>
            <div class="row mt-3">
                @foreach($week as $video)
                    <x-video-card :video="$video" :show-user-image="true"/>
                @endforeach
            </div>
        @endif

    </div>
@endsection
