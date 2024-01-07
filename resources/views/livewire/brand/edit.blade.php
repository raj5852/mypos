<div>
    <div class="card">
        <div class="card-header"><h3>Edit Brand</h3></div>
        <div class="card-body">
            <form wire:submit.prevent="updateBrand">
                <div class="mb-3">
                    <label for="brandname" class="form-label">Brand name <span class="text-danger">*</span> </label>
                    <input type="text" wire:model="name" value="{{ $name }}"
                        class="form-control @error('name')  is-invalid @enderror" id="brandname"
                        placeholder="Brand name">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }} </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Brand description</label>
                    <textarea wire:model="description" class="form-control @error('description')  is-invalid @enderror" id="description"
                        cols="" rows="3">{{ $description }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }} </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Brand Logo</label>
                    <input type="file" wire:model.live="image"
                        class="form-control @error('image')  is-invalid @enderror" id="image"
                        accept="image/png, image/gif, image/jpeg">
                    @error('image')
                        <span class="invalid-feedback">{{ $message }} </span>
                    @enderror
                    @if ($image)
                        Photo Preview:
                        <img width="100px" src="{{ $image->temporaryUrl() }}">
                    @endif
                    @if ($oldimage != '')
                        @if ($image == '')
                            Photo Preview:
                            <img width="100px" src="{{ asset($oldimage) }}">
                        @endif

                    @endif
                </div>

                <div>
                    <button wire:loading.attr="disabled" wire:target="updateBrand"  type="submit" class="btn btn-primary">Update


                        <div wire:loading wire:target="updateBrand" class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>

                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
