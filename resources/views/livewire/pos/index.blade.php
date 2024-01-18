@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
@endsection
<div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="row">
                            {{-- <div class="input-group mt-3">
                                <span class="input-group-text" ><x-icon><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M40-200v-560h80v560H40Zm120 0v-560h80v560h-80Zm120 0v-560h40v560h-40Zm120 0v-560h80v560h-80Zm120 0v-560h120v560H520Zm160 0v-560h40v560h-40Zm120 0v-560h120v560H800Z"/></svg></x-icon> </span>
                                <input type="text" class="form-control" >
                            </div> --}}

                            <div class="mt-3" wire:ignore>
                                <select class="form-select" id="product"></select>
                            </div>
                            <div class="mt-3">
                                <input type="date" wire:model="selectedDate" value="{{$selectedDate}}" class="form-control">
                            </div>
                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-10">
                                        <select class="form-control" name="" id="">
                                            <option value="">Select customer</option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-primary ">Add </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <table class="table table-bordered">
                                <thead class="bg-dark">
                                    <tr>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Sub T</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot class="text-center bg-danger">
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="3">Total : 0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <h5>Category</h5>
                            <hr>
                            hello hello world world
                        </div>
                        <div class="col-9">
                            <h5>Product list</h5>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" class="form-control form-control-sm" placeholder="Search...">
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-primary btn-sm">Search</button>
                                    <button class="btn btn-secondary btn-sm">Reset</button>
                                </div>
                            </div>
                            <div class="row mt-3">
                                @foreach ($products as $product)
                                    <div class="col-md-3 border p-1">
                                        Lorem ipsum, dolor sit amet co amet co amet co
                                        Lorem ipsum,
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-3">
                                {{ $products->onEachSide(0)->links() }}
                            </div>

                        </div>

                    </div>
                </div>
            </div>
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
    </script>
@endsection
