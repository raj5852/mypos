<div>
    <div class="card">
        <div class="card-header">
            <h3>New product</h3>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="productstore">
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
                            placeholder="Product code">
                        @error('code')
                            <span class="invalid-feedback">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category <span class="text-danger">*</span>
                        </label>
                        <div class="row">
                            <div class="col-6">
                                <select wire:model="category_id"
                                    class="form-control @error('category_id')  is-invalid @enderror" id="category">
                                    <option value="">Select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }} </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <span class="invalid-feedback">{{ $message }} </span>
                                @enderror
                            </div>

                            <div class="col-2">
                                <button type="button" class="btn btn-secondary">Add category</button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand
                        </label>
                        <div class="row">
                            <div class="col-6">
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
                            <div class="col-2">
                                <button type="button" class="btn btn-secondary">Add Brand</button>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Main Unit <span class="text-danger">*</span> </label>
                        <select wire:model.live="main_unit"
                            class="form-select @error('main_unit') is-invalid @enderror ">
                            <option value="">Select unit</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->unit_name }} </option>
                            @endforeach
                        </select>
                        @error('main_unit')
                            <span class="invalid-feedback">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="mainunit" class="form-label">Sub Unit</label>
                        <select wire:model.live="sub_unit" class="form-select @error('sub_unit') is-invalid @enderror">
                            <option value="">Select subunit</option>
                            @foreach ($subunits as $subunit)
                                <option value="{{ $subunit->id }}">{{ $subunit->unit_name }}</option>
                            @endforeach

                        </select>
                        @error('sub_unit')
                            <span class="invalid-feedback">{{ $message }} </span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <div class="row">
                            <label for="openingstock" class="form-label">Opening Stock</label>
                            <div class="col-{{ $sub_unit == '' ? '8' : '4' }} ">
                                <input wire:model="stock" type="text"
                                    class="form-control @error('stock') is-invalid @enderror" id="code"
                                    placeholder="{{ $main_unit == '' ? 'Opening stock' : $main_unit_name }} ">
                                @error('stock')
                                    <span class="invalid-feedback">{{ $message }} </span>
                                @enderror
                            </div>
                            <div class="col-4 {{ $sub_unit == '' ? 'd-none' : '' }} ">
                                <input type="text" wire:model="sub_stock"
                                    class="form-control @error('sub_stock') is-invalid @enderror" id="code"
                                    placeholder="{{ $sub_unit_value }}">
                                @error('sub_stock')
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
                        <label for="code" class="form-label @error('image') is-invalid @enderror ">Product image </label>
                        <input type="file" wire:model.live="image" class="form-control" accept="image/png, image/gif, image/jpeg">
                        @error('image')
                            <span class="invalid-feedback">{{ $message }} </span>
                        @enderror
                        @if ($image)
                            Photo Preview:
                            <img width="80px" src="{{ $image->temporaryUrl() }}">
                        @endif
                    </div>

                </div>

                <div>
                    <button wire:loading.attr="disabled" wire:target="productstore" type="submit"
                        class="btn btn-primary">Submit
                        <div wire:loading wire:target="productstore" class="spinner-border spinner-border-sm"
                            role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
