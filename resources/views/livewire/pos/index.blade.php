@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
@endsection
<div>
    <div class="row">
        <div class="col-md-7">
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
                                <input type="date" wire:model="selectedDate" value="{{ $selectedDate }}"
                                    class="form-control">
                            </div>
                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-10">
                                        <select class="form-control" id="customer">
                                            <option value="">Select customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }} -
                                                    {{ $customer->phone }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                            data-bs-target="#customerModal">Add </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <table class="table table-bordered">
                                <thead class="bg-dark">
                                    <tr>
                                        <th style="width:80px">Name</th>
                                        <th style="min-width:220px;" class="text-center">Quantity</th>
                                        <th style="min-width:120px;">Price</th>
                                        <th style="max-width:90px;">SubT</th>
                                        <th style="max-width:90px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 13px">
                                    @foreach ($selectProducts as $index => $selectProduct)
                                        <tr wire:key="{{ $index }}">
                                            <td style="padding:9px 7px!important">{{ $selectProduct['name'] }}</td>
                                            <td style="padding:9px 7px!important">
                                                <div class="d-flex">
                                                    <p class="mt-2 me-1">{{ $selectProduct['main_unit_name'] }} </p>
                                                    <input type="number" class="form-control form-control-sm"
                                                        wire:change="updateMainQuantity({{ $index }}, $event.target.value)">
                                                    @if ($selectProduct['sub_unit'] != '')
                                                        <p class="mt-2 me-1">{{ $selectProduct['sub_unit_name'] }} </p>
                                                        <input type="number" class="form-control form-control-sm"
                                                            wire:change="updateSubQuantity({{ $index }}, $event.target.value)">
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" value="{{ $selectProduct['price'] }}"
                                                    class="form-control"
                                                    wire:change="updatePrice({{ $index }}, $event.target.value)">
                                            </td>
                                            <td>
                                                {{ $selectProduct['sub_total'] ?: 0 }}
                                            </td>
                                            <td>
                                                <div style="cursor: pointer;"
                                                    wire:click="deleteProduct({{ $index }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="20"
                                                        color="red" viewBox="0 -960 960 960" width="20">
                                                        <path
                                                            d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                                    </svg>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="text-center bg-danger">
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="3">Total : {{ $grandTotal }} </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <center>
                                <button wire:click="clickPaymentButton" class="btn btn-primary"
                                    {{ $totalItem > 0 ? '' : 'disabled' }} data-bs-toggle="modal"
                                    data-bs-target="#paymentModal">
                                    <x-icon>payments</x-icon> Payment</button>
                            </center>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h5>Product list</h5>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" wire:model="productsearch"
                                        class="form-control form-control-sm" placeholder="Search..."
                                        wire:change="search($event.target.value)">
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-primary btn-sm">Search</button>
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        wire:click="resetproductsearch">Reset</button>
                                </div>
                            </div>
                            <div class="row mt-3">
                                @foreach ($products as $product)
                                    <div wire:click="getproductId({{ $product->id }})"
                                        class="col-3 border p-1 text-center" style="cursor: pointer; font-size: 13px">
                                        <img width="80px" src="{{ $product->image->image }}" alt="">
                                        <p>{{ $product->name }} - {{ $product->code }} </p>
                                        <p><b>{{ formatBalance($product->sale_price) }}</b> TK</p>
                                        <P>Stock:
                                            {{ getTotalAvailAbleStock($product, productStock($product->purchased, $product->sell)) }}
                                        </P>
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

    <div wire:ignore.self class="modal fade" id="customerModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="storeCustomer">
                        <div class="mb-3 ">
                            <label for="" class="form-label">Customer Name <span class="text-danger">*</span>
                            </label>
                            <input wire:model="name" type="text"
                                class="form-control @error('name') is-invalid @enderror "
                                placeholder="Enter customer name">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input wire:model="email" type="text"
                                class="form-control @error('email') is-invalid @enderror "
                                placeholder="Enter customer email">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Address</label>
                            <textarea wire:model="address" class="form-control  @error('address') is-invalid @enderror" id=""
                                rows="3"></textarea>
                            @error('address')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" wire:model="phone"
                                class="form-control @error('phone') is-invalid @enderror" placeholder="Phone number">
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Opening Receivable</label>
                            <input type="text" wire:model="opening_receivable"
                                class="form-control @error('opening_receivable') is-invalid @enderror"
                                placeholder="Opening Receivable">
                            @error('opening_receivable')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Opening Payable</label>
                            <input type="text" wire:model="opening_payable"
                                class="form-control @error('opening_payable') is-invalid @enderror"
                                placeholder="Opening Payable">
                            @error('opening_payable')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>

                        <button wire:loading.attr="disabled" wire:target="customerStore" type="submit"
                            class="btn btn-primary">Submit

                            <div wire:loading wire:target="customerStore" class="spinner-border spinner-border-sm"
                                role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="paymentModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @error('customer_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <form wire:submit.prevent="order">

                        <table class="table table-bordered text-left">
                            <tbody>
                                <tr>
                                    <td width="50%">
                                        <strong class="float-start">Paying Items: </strong>
                                        <strong class="float-end">(<span id="items">{{ $totalItem }} TK
                                            </span>)</strong>
                                    </td>
                                    <td>
                                        <strong class="float-start">Total Receivable: </strong>
                                        <strong class="float-end"><span>{{ $grandTotal }} TK</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <strong class="float-start">After Discount total due: </strong>
                                        <strong class="float-end">(<span id="items"> {{ $afterDiscount }} TK
                                            </span>)</strong>
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Discount</label>
                                <input wire:change="discount($event.target.value)" wire:model.live="discountvalue"
                                    type="number" class="form-control" placeholder="0%">
                                @error('discountvalue')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label for="">Note</label>
                                <textarea wire:model="note" class="form-control"></textarea>
                            </div>

                            <div class="col-6">
                                <label for="">Transaction Account</label>

                                <select wire:model="selectedBank_id" class="form-select" id="product">
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedBank_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="pay_amount">Pay Amount</label>
                                <div class="input-group">
                                    <input type="number" step="any" min="0" class="form-control"
                                        wire:model="pay_amount" wire:change="payamount($event.target.value)"
                                        id="pay_amount" placeholder="Pay Amount...">
                                    @error('discountvalue')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <span class="input-group-btn">
                                        <button wire:click="paid" style="padding-top: 9px;padding-bottom: 8px;"
                                            class="btn btn-warning" type="button" id="paid_btn">PAID!</button>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <center>
                            <button wire:loading.attr="disabled" wire:target="order" type="submit"
                                class="btn btn-primary mt-3"><x-icon>shopping_cart</x-icon>
                                Order
                                <div wire:loading wire:target="order" class="spinner-border spinner-border-sm"
                                    role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </button>
                        </center>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

        $('#customer').on('change', function(e) {

            var data = $('#customer').select2("val");
            if ($("#customer").val() != null) {
                @this.call('setCustomer', data);
            }
        });


        window.addEventListener('product_already_added', event => {
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error('Product already added. Update quantity');
        })

        window.addEventListener('closeModal', event => {
            $('#customerModal').modal('hide');
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("Successfully created");

        })

        window.addEventListener('stock_not_available', event => {
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("Stock not available");

        })
    </script>
@endsection
