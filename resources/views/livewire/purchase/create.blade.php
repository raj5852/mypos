@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
@endsection
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <h3>Add purchase</h3>
            </div>
            <div class="col-6">
                <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#supplierModal"
                    type="button">Add supplier</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="">
            <div class="row">
                <div class="col-md-6">
                    <div class="mt-3" wire:ignore>
                        <label for="">Supplier</label>
                        <select id="supplierlist" class="form-select">
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mt-3">
                        <label for="">Purchase date</label>
                        <input wire:model="selectedDate" type="date" class="form-control">
                    </div>
                </div>
                <div class="col-md-6" wire:ignore>
                    <div class="mt-3">
                        <label for="">Product</label>
                        <select class="form-select" id="product"></select>
                    </div>
                </div>

            </div>
            <br>
            <hr>


            <div class="table-responsive">
                <table class="table table-bordered ">
                    <thead class="bg-dark">
                        <tr>
                            <th>#SL</th>
                            <th>Product</th>
                            <th>Rate</th>
                            <th>Qty</th>
                            <th>Sub Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>


                    @forelse ($addproducts as $index=>$products)
                        <tr wire:key="{{ $index }}">
                            <td>{{ $index + 1 }} </td>
                            <td>{{ $products['name'] }} </td>
                            <td style="width:15%"><input type="number" min="0" class="form-control"
                                    value="{{ $products['purchase_cost'] }}"
                                    wire:change="updateRate({{ $index }}, $event.target.value)"> </td>
                            <td style="width:33%">
                                <div class="d-flex">
                                    <p class="mt-2 me-2">{{ $products['main_unit_name'] }}:</p> <input min="0" type="number"
                                        class="form-control"
                                        wire:change="updateMainQuantity({{ $index }}, $event.target.value)">
                                    @if ($products['is_subunit'] != null)
                                        <p class="mt-2 me-2 ms-2">{{ $products['sub_unit_name'] }}: </p> <input
                                            type="number" class="form-control"
                                            wire:change="updateSubQuantity({{ $index }}, $event.target.value)">
                                    @endif
                                </div>
                            </td>
                            <td style="font-weight: 500"> {{ $products['sub_total'] }} TK
                            </td>
                            <td>
                                <button wire:click="deleteProduct({{ $index }})" type="button"
                                    class="btn btn-danger btn-sm bg-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tfoot>
                            <tr>
                                <td colspan="4"></td>
                                <td colspan="2">Grand Total:0 TK </td>
                            </tr>
                        </tfoot>
                    @endforelse

                    @if (count($addproducts) > 0)
                        <tfoot>
                            <tr>
                                <td colspan="4"></td>
                                <td style="font-weight: 500" colspan="2">Grand Total: {{ $grand_total }} TK </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
            <button {{ $paying_item == 0 ? 'disabled' : '' }} type="button" class="btn btn-primary"
                data-bs-toggle="modal" data-bs-target="#paymentModal" wire:click="paymentModal"  ><x-icon>payments</x-icon> Payment</button>
        </form>
    </div>

    <div wire:ignore.self class="modal fade" id="supplierModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="supplierStore">
                        <div class="mb-3">
                            <label for="" class="form-label">Supplier Name <span class="text-danger">*</span>
                            </label>
                            <input wire:model="name" type="text"
                                class="form-control @error('name') is-invalid @enderror "
                                placeholder="Enter supplier name">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input wire:model="email" type="text"
                                class="form-control @error('email') is-invalid @enderror "
                                placeholder="Enter supplier email">
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



                        <button wire:loading.attr="disabled" wire:target="supplierStore" type="submit"
                            class="btn btn-primary">Submit

                            <div wire:loading wire:target="supplierStore" class="spinner-border spinner-border-sm"
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
                    <form wire:submit.prevent="purchase" >

                        <table class="table table-bordered text-left">
                            <tbody>
                                <tr>
                                    <td width="50%">
                                        <strong class="float-start">Paying Items: </strong>
                                        <strong class="float-end">(<span id="items"> {{ $paying_item }}
                                            </span>)</strong>
                                    </td>
                                    <td>
                                        <strong class="float-start">Total Payable: </strong>
                                        <strong class="float-end"><span id="payable">{{ $grand_total }} </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <strong class="float-start pl-3">Due</strong>
                                        <strong class="float-end pr-3">
                                            (<span id="due">{{ $due }} </span> Tk)
                                        </strong>
                                        <input type="hidden" id="due_input" name="due_amount" value="0">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="note">Note</label>
                                <textarea wire:model="note" class="form-control" placeholder="Enter Note (Optional) "></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-6">
                                <label for="">Transaction Account</label>
                                <select  wire:model="bank_account_id"  class="form-control" required>
                                    @foreach ($banks as $key=>$bank)
                                        <option value="{{$bank->id}}">{{$bank->name}}</option>
                                    @endforeach
                                </select>
                                @error('bank_account_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="pay_amount">Pay Amount</label>
                                <div class="input-group">
                                    <input type="number" step="any" min="0" class="form-control"
                                        wire:model="pay_amount" wire:change="payamount($event.target.value)"
                                        id="pay_amount" placeholder="Pay Amount...">
                                    <span class="input-group-btn">
                                        <button wire:click="paid" style="padding-top: 9px;padding-bottom: 8px;"
                                            class="btn btn-warning" type="button" id="paid_btn">PAID!</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button wire:loading.attr="disabled" wire:target="purchase" type="submit" class="btn btn-primary"><x-icon>shopping_cart</x-icon>
                            Purchase
                            <div wire:loading wire:target="purchase" class="spinner-border spinner-border-sm"
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


</div>
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>

        $('#supplierlist').on('change', function(e) {
            var data = $('#supplierlist').select2("val");
            @this.set('supplier_id', data);

        });


        $('#product').on('change', function(e) {

            var data = $('#product').select2("val");
            if ($("#product").val() != null) {
                if ($('#supplierlist').val() == null) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true
                    }
                    toastr.warning('Please select supplier first!');
                    $('#product').val([]).trigger('change');
                    return false;
                }

                @this.call('getproductId', data);
            }

        });

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
        let supplierRoutePath = "{{ route('supplier-list') }}"
        $('#supplierlist').select2({
            placeholder: 'Select supplier',
            ajax: {
                url: supplierRoutePath,
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name + ' - ' + item.phone,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });


        window.addEventListener('closeModal', event => {
            $('#supplierModal').modal('hide');

            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("Successfully created");

        })
        window.addEventListener('productexists', event => {
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning('Product already added!');
            $('#product').val([]).trigger('change');

        })

        window.addEventListener('wrong', event => {
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning('Something is wrong!');
        })

        window.addEventListener('productremove', event => {
            $('#product').val([]).trigger('change');
        })
    </script>
@endsection
