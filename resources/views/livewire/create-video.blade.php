<div class="container">
    <h3>Upload Video</h3>
    <form wire:submit.prevent="save">
        <div class="form-group">
            <label for="title">Title</label>
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

        <div class="form-group">

            <div
                x-data="{ isUploading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false"
                x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
            >
                <!-- File Input -->
                <label for="video">Video File</label>
                <input type="file"
                       class="form-control-file @error('video') is-invalid @enderror"
                       wire:model="video">

                @error('video')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <!-- Progress Bar -->
                <div x-show="isUploading">
                    <progress max="100" x-bind:value="progress"></progress>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Create Video</button>
    </form>
</div>

@section('js')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.2/dist/alpine.min.js" defer></script>
@endsection
