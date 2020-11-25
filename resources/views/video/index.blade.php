@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="text-center">
            Videos
        </h3>
        <hr>
        <div class="row">
            @foreach($videos as $video)
                <x-video-card :video="$video" :show-user-image="true"/>
            @endforeach
        </div>
    </div>
@endSection
