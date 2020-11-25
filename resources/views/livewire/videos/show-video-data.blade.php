<div>

    <div class="mt-3">
        @if($editMode)
            <input type="text"
                   class="form-control @error('title') is-invalid @enderror"
                   id="title"
                   wire:model.defer="title">

            @error('title')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        @else
            <h3>{{ $video->title }}</h3>
        @endif
        <h6 class="text-muted">999 views • {{ $video->created_at->format('F d, Y') }}</h6>
    </div>

    <hr>

    <div class="row">

        <div class="col-auto mr-auto row mr-0 ml-0">
            <img src="{{ $video->user->image() }}" class="rounded-circle" width="64" height="64" alt="user image">
            <div style="position: relative;">
                <h4 class="ml-3">
                    <a href="{{ route('users.show', $video->user->name) }}"
                       style="color: #343a40;text-decoration:none;">
                        {{ $video->user->name }}
                    </a>
                </h4>
                <h6 class="ml-3 text-muted">{{ $video->user->followers()->count() }} followers</h6>
            </div>
        </div>

        <div class="col-auto">
            @if(auth()->id() === $video->user->id)
                @if($editMode)
                    <button type="button" class="btn btn-outline-secondary" wire:click="$set('editMode', false)">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-success" wire:click="submit">
                        Save
                    </button>
                @else
                    <button type="button" class="btn btn-primary" wire:click="enableEditMode">
                        Edit Video
                    </button>
                @endif
            @else
                <x-follow-button :user="$video->user"/>
            @endif
        </div>
    </div>

</div>
