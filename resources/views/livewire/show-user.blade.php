<div class="container">

    <div class="row">
        <div class="col-auto">
            <img src="{{ $user->image }}" class="rounded-circle" width="64" height="64" alt="user image">
            <div style="position: relative;">
                <h3 class="ml-3">
                    {{ $user->name }}
                </h3>
                <h5 class="ml-3 text-muted">{{ $user->followers()->count() }} followers</h5>
            </div>
        </div>
        <div class="col-auto ms-auto">
            <x-follow-button :user="$user"/>
        </div>
    </div>

    <hr>

    <select class="form-select mr-sm-2" id="sort" wire:model="sortBy">
        <option value="desc">Sort by new</option>
        <option value="asc">Sort by old</option>
    </select>

    <div class="row mt-3">
        @foreach($videos as $video)
            <x-video-card :video="$video" :show-user-image="false"/>
        @endforeach
    </div>

</div>
