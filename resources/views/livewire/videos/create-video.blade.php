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
            <div x-data="{ isUploading: false, doneUploading: false, progress: 0 }"
                 x-on:livewire-upload-start="isUploading = true"
                 x-on:livewire-upload-finish="isUploading = false; doneUploading = true"
                 x-on:livewire-upload-error="isUploading = false"
                 x-on:livewire-upload-progress="progress = $event.detail.progress">
                <label for="video" class="form-label">Video</label>
                <input class="form-control @error('video') is-invalid @enderror"
                       type="file"
                       id="video"
                       wire:model="video"
                       accept=".mp4"
                       required>

                <div>
                    <progress max="100" x-bind:value="progress" x-show="isUploading"></progress>
                    <p x-show="doneUploading">
                        Done uploading video
                    </p>
                </div>

                @error('video')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        {{--TODO: add loading icon--}}
        <button type="submit" class="btn btn-primary">Create Video</button>
    </form>
</div>

@section('js')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
@endsection
