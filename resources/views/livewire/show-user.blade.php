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
        <x-follow-button :user="$user"/>
    </div>

    <hr>

    <select class="custom-select mr-sm-2" id="sort" wire:model="sortBy">
        <option value="desc">Sort by new</option>
        <option value="asc">Sort by old</option>
    </select>

    <div class="row mt-3">
        @foreach($videos as $video)
                <x-video-card :video="$video" :show-user-image="false"/>
        @endforeach
    </div>

</div>
