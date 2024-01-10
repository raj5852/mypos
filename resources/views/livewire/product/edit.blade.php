<div>
    <div class="card">
        <div class="card-header">
            <h3>New product</h3>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="updateProduct">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="name" class="form-label">Product name <span class="text-danger">*</span> </label>
                        <input type="text" wire:model="name" class="form-control @error('name')  is-invalid @enderror"
                            id="name" placeholder="Product name">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="code" class="form-label">Product Code</label>
                        <input type="text" wire:model="code"
                            class="form-control @error('code')  is-invalid @enderror" id="code"
                            placeholder="Product code" readonly>
                        @error('code')
                            <span class="invalid-feedback">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category <span class="text-danger">*</span>
                        </label>
                        <div class="row">
                            <div class="col-8">
                                <select wire:model="category_id"
                                    class="form-select @error('category_id')  is-invalid @enderror" id="category">
                                    <option value="">Select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }} </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <span class="invalid-feedback">{{ $message }} </span>
                                @enderror
                            </div>


                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand
                        </label>
                        <div class="row">
                            <div class="col-8">
                                <select wire:model="brand_id"
                                    class="js-states form-select  @error('brand_id')  is-invalid @enderror"
                                    id="brand">
                                    <option value="">Select brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }} </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <span class="invalid-feedback">{{ $message }} </span>
                                @enderror
                            </div>

                        </div>

                    </div>




                    <div class="col-md-8 mb-3">
                        <label for="code" class="form-label">Sale price <span class="text-danger">*</span> </label>
                        <input type="text" wire:model="sale_price"
                            class="form-control @error('sale_price')  is-invalid @enderror" placeholder="Sale price">
                        @error('sale_price')
                            <span class="invalid-feedback">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="code" class="form-label">Purchase Cost <span class="text-danger">*</span>
                        </label>
                        <input type="text" wire:model="purchase_cost"
                            class="form-control @error('purchase_cost')  is-invalid @enderror"
                            placeholder="Purchase Cost">
                        @error('purchase_cost')
                            <span class="invalid-feedback">{{ $message }} </span>
                        @enderror
                    </div>

                    <div class="col-md-8 mb-3">
                        <label for="code" class="form-label">Product details </label>
                        <textarea id="summernote" wire:model="details" class="form-control @error('details') is-invalid @enderror"
                            rows="5"></textarea>
                        @error('details')
                            <span class="invalid-feedback">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="code" class="form-label @error('image') is-invalid @enderror ">Product image
                        </label>
                        <input type="file" wire:model.live="image" class="form-control"
                            accept="image/png, image/gif, image/jpeg">
                        @error('image')
                            <span class="invalid-feedback">{{ $message }} </span>
                        @enderror
                        @if ($image)
                            Photo Preview:
                            <img width="80px" src="{{ $image->temporaryUrl() }}">
                        @endif
                        @if ($image == '')
                            Photo Preview:
                            <img width="80px" src="{{ asset($oldimage) }}">
                        @endif
                    </div>

                </div>

                <div>
                    <button wire:loading.attr="disabled" wire:target="updateProduct" type="submit"
                        class="btn btn-primary">Update
                        <div wire:loading wire:target="updateProduct" class="spinner-border spinner-border-sm"
                            role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>


</div>
