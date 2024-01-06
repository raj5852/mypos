<div class="card">

    <div class="card-body">
        <form wire:submit.prevent="unitstore">

            <div class="mb-3">
                <label for="unitname" class="form-label">Unit Name</label>
                <input type="text" class="form-control  @error('unit_name')  is-invalid @enderror"
                    wire:model.live="unit_name" id="unitname" placeholder="e.g KG">
                @error('unit_name')
                    <span class="invalid-feedback">{{ $message }} </span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="" class="form-label">Related To Unit</label>
                    <select wire:model.live="related_to_unit"
                        class="form-select @error('related_to_unit')  is-invalid @enderror ">
                        <option value="">Select unit</option>

                        @foreach ($units as $unit)
                            <option value="{{ $unit->id . '-' . $unit->unit_name }}">{{ $unit->unit_name }}</option>
                        @endforeach

                    </select>
                    @error('related_to_unit')
                        <span class="invalid-feedback">{{ $message }} </span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="Operator" class="form-label">Operator</label>
                        <select wire:model.live="operator" id="Operator"
                            class="form-select @error('operator')  is-invalid @enderror">
                            <option value="">Select Operator Sign</option>
                            <option value="*">(*) Multiply Operator</option>
                        </select>
                        @error('operator')
                            <span class="invalid-feedback">{{ $message }} </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="RelatedByValue" class="form-label">Related By Value</label>
                        <input wire:model.live="related_by_value" type="text"
                            class="form-control @error('related_by_value')  is-invalid @enderror" id="RelatedByValue">
                        @error('related_by_value')
                            <span class="invalid-feedback">{{ $message }} </span>
                        @enderror
                    </div>

                </div>
                @if ($related_to_unit != '' || $operator != '')
                    @php
                        if ($related_to_unit != '') {
                            $parts = explode('-', $related_to_unit);
                            $related_to_unitName = $parts[1];
                        } else {
                            $related_to_unitName = 'Select Unit';
                        }

                    @endphp


                    <h3 class="text-center"> 1 {{ $unit_name }} = {{ $related_by_value ?? 1 }}  {{ $related_to_unitName }} {{ $operator }}
                    </h3>
                @endif


                <div class="col-md-4">
                    <button wire:loading.attr="disabled" wire:target="unitstore"  type="submit" class="btn btn-primary">Add unit

                        <div wire:loading wire:target="unitstore"  class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>

                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
