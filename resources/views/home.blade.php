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

        <hr>

        

    </div>
@endsection
