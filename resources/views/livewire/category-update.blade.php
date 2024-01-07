<div>
    <div class="card">
        <div class="card-header">Edit Category</div>
        <div class="card-body">
            <form wire:submit.prevent="updateCategory" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="categoryname" class="form-label">Category name</label>
                    <input type="text" wire:model="name" value="{{ $name }}"
                        class="form-control @error('name')  is-invalid @enderror" id="categoryname"
                        placeholder="Category name">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }} </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="Categoryimage" class="form-label">Category image</label>
                    <input type="file" wire:model.live="image"
                        class="form-control @error('image')  is-invalid @enderror" id="Categoryimage"
                        accept="image/png, image/gif, image/jpeg">
                    @error('image')
                        <span class="invalid-feedback">{{ $message }} </span>
                    @enderror

                    @if ($oldimage && empty($image))
                        Photo Preview:
                        @if (!is_null($oldimage))
                            <img width="80px" src="{{ asset($oldimage) }}">
                        @endif
                    @endif

                    @if ($image)
                        Photo Preview:
                        <img width="80px" src="{{ $image->temporaryUrl() }}">
                    @endif
                </div>
                <div>
                    <button wire:loading.attr="disabled" wire:target="updateCategory" type="submit"
                        class="btn btn-primary">Update

                        <div wire:loading wire:target="updateCategory" class="spinner-border spinner-border-sm"
                            role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>

                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
