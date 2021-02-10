<div class="container">

    <div class="row">

        <div class="col-auto">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ $user->image }}"
                         class="rounded-circle"
                         width="64"
                         height="64"
                         alt="user image">
                </div>
                <div class="col-md-8">
                    <h4>
                        <a href="{{ route('users.show', $user->name) }}"
                           style="color: #343a40;text-decoration:none;">
                            {{ $user->name }}
                        </a>
                    </h4>
                    <h6 class="text-muted ms-1">{{ $user->followers()->count() }} followers</h6>
                </div>
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

    <div class="justify-content-center mt-3" wire:loading.flex>
        <div class="la-line-scale la-dark la-2x">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div class="row mt-3" wire:loading.remove>
        @foreach($videos as $video)
            <x-video-card :video="$video" :show-user-image="false"/>
        @endforeach
    </div>

</div>
