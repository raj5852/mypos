@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
@endsection
<div>
    <div class="card">
        <div class="card-header">
            <h3> Add Damage</h3>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="storeDamage">
                <div class="row">
                    <div class="col-12">
                        <div class="mt-3" wire:ignore>
                            <label for="">Select product</label>
                            <select class="form-select" id="product"></select>
                        </div>
                        @if ($main_unit_name)
                            <div class="col-12">
                                <div class="mt-3">
                                    <label for="">{{ $main_unit_name }} </label>
                                    <input wire:model.live="main_unit_value" type="text" class="form-control">
                                    @error('main_unit_value')
                                        <span class="text-danger">{{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                        @endif
                        @if ($sub_unit_name)
                            <div class="col-12">
                                <div class="mt-3">
                                    <label for="">KG</label>
                                    <input wire:model.live="sub_unit_value" type="text" class="form-control">
                                    @error('sub_unit_value')
                                        <span class="text-danger">{{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <div class="col-12">
                            <div class="mt-3">
                                <label for="">Date</label>
                                <input type="date" wire:model="selectedDate" class="form-control">
                                @error('selectedDate')
                                    <span class="text-danger">{{ $message }} </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mt-3">
                                <label for="">Note</label>
                                <textarea wire:model="note" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button {{ $productId == '' ? "disabled":'' }}  type="submit" class="btn btn-primary" >Add damage</button>
                        </div>
                    </div>

            </form>
        </div>
    </div>
</div>
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $('#product').select2();
        $('select').select2({
            width: '100%'
        });

        var path = "{{ route('product-list') }}";

        $('#product').select2({
            placeholder: 'Select Product',
            ajax: {
                url: path,
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name + ' - ' + item.code,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('#product').on('change', function(e) {

            var data = $('#product').select2("val");
            if ($("#product").val() != null) {
                @this.call('getproductId', data);
            }
        });
        window.addEventListener('stock_not_available', event => {
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("Stock not available");

        })
    </script>
@endsection
