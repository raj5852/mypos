<div>
    <div class="card">
        <div class="card-header">New Category</div>
        <div class="card-body">
            <form wire:submit.prevent="categorystore" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="categoryname" class="form-label">Category name</label>
                    <input type="text" wire:model="name" class="form-control @error('name')  is-invalid @enderror"
                        id="categoryname" placeholder="Category name">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }} </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="Categoryimage" class="form-label">Category image</label>
                    <input type="file" wire:model.live="image" class="form-control @error('image')  is-invalid @enderror"
                        id="Categoryimage" accept="image/png, image/gif, image/jpeg">
                    @error('image')
                        <span class="invalid-feedback">{{ $message }} </span>
                    @enderror
                    @if ($image)
                        Photo Preview:
                        <img width="100px" src="{{ $image->temporaryUrl() }}">
                    @endif
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

</div>
