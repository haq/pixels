@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="text-center">
            Videos
        </h3>
        <hr>
        <div class="row">
            @foreach($months as $month => $videos)
                <h5>{{ \Carbon\Carbon::parse($month)->format('F, Y') }}</h5>
                @foreach($videos as $video)
                    <x-video-card :video="$video" :show-user-image="true"/>
                @endforeach
            @endforeach
        </div>
    </div>
@endSection
