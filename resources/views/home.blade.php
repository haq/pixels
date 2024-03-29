@extends('layouts.app')

@section('content')
    <div class="container">

        <h3>Feed</h3>

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

        @if(count($past) > 0)
            <hr>
            <h5>Past</h5>
            <div class="row mt-3">
                @foreach($past as $video)
                    <x-video-card :video="$video" :show-user-image="true"/>
                @endforeach
            </div>
        @endif

    </div>
@endsection
