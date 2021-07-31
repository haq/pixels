<div class="container">
    <h3>Upload Video</h3>
    <form wire:submit.prevent="save">

        <div class="mb-3 mt-3">
            <label for="title" class="form-label">Title</label>
            <input type="text"
                   class="form-control @error('title') is-invalid @enderror"
                   id="title"
                   wire:model.defer="title"
                   placeholder="Enter video title">

            @error('title')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

        </div>

        <div class="mb-3">
            <label for="video" class="form-label">Video</label>
            <x-input.filepond wire:model="video" id="video" :allow-multiple="false"/>
        </div>

        {{--TODO: add loading icon--}}
        <button type="submit" class="btn btn-primary">Create Video</button>
    </form>
</div>
