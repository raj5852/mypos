@extends('layouts.inc.user.app')
@section('css')
@endsection
@section('content')
    <div class="row">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div id="print-area">
                            <div class="row">
                                <div class="col-6">
                                    <h4>{{ $address->company_name }} </h4>
                                </div>
                                <div class="col-6">
                                    <span>Address: <strong>{{ $address->address }} </strong> </span><br>
                                    <span>Phone: <strong>{{ $address->phone }}</strong> </span><br>
                                    <span>Email: <strong>{{ $address->email }} </strong> </span><br>
                                </div>
                            </div>
                            <table class="table table-bordered table-sm">
                                <tbody style="font-weight: 300">
                                    <tr>
                                        <td style="padding: 6px 20px!important;">Date:
                                            <strong>{{ formatedate($purchase->created_at) }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 20px!important;">Invoice No: <strong>{{ $purchase->id }}
                                            </strong> </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 20px!important;">Supplier Name:
                                            <strong>{{ $purchase->supplier->name }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 20px!important;">Address :
                                            <strong>{{ $purchase->supplier->address }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 20px!important;">Mobile :
                                            <strong>{{ $purchase->supplier->phone }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered">
                                <thead style="background: #e9e9e9">
                                    <tr>
                                        <td style="padding: 6px 20px!important;">#</td>
                                        <td style="padding: 6px 20px!important;">Details</td>
                                        <td style="padding: 6px 20px!important;">Qty</td>
                                        <td style="padding: 6px 20px!important;">Price</td>
                                        <td style="padding: 6px 20px!important;">Net.A</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase->products as $key => $product)
                                        <tr>
                                            <td style="padding: 6px 20px!important;">{{ $key + 1 }} </td>
                                            <td style="padding: 6px 20px!important;">{{ $product->name }} |
                                                {{ $product->code }}</td>
                                            <td style="padding: 6px 20px!important;">
                                                {{ formateStock($product->mainunit, $product->subunit, $product->pivot->qty) }}
                                            </td>
                                            <td style="padding: 6px 20px!important;">{{ $product->pivot->price }} TK</td>
                                            <td style="padding: 6px 20px!important;">
                                                {{ totalstockvalue($product->mainunit, $product->subunit, $product->pivot->qty, $product->pivot->price) }}
                                                TK</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td style="padding: 6px 20px!important;" colspan="4" class="text-end">
                                            <strong>Grand
                                                Total</strong> :
                                        </td>
                                        <td style="padding: 6px 20px!important;" colspan="1">
                                            {{ formatBalance($purchase->payable ?? 0) }} TK </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 20px!important;" colspan="4" class="text-end">
                                            <strong>Paid</strong> :
                                        </td>
                                        <td style="padding: 6px 20px!important;" colspan="1">{{ $purchase->paid ?? 0 }} TK
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 20px!important;" colspan="4" class="text-end">
                                            <strong>Due</strong>:
                                        </td>
                                        <td style="padding: 6px 20px!important;" colspan="1">{{ $purchase->payable - $purchase->paid  }} TK
                                        </td>
                                    </tr>
                                </tfoot>

                            </table>
                            <div class="mt-3 mb-3 d-flex justify-content-between">
                                <h3>Payments</h3>
                                <a class="btn btn-primary" href="{{ route('purchase.addpayment', $purchase->id) }}">Add
                                    payment</a>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase->histories as $purchasepayment)
                                        <tr>
                                            <td>{{ formatedate($purchasepayment->date) }} </td>
                                            <td>{{ formatBalance($purchasepayment->amount) }} </td>
                                            <td> <a href="{{ route('purchase.delete',$purchasepayment->id) }}" class="btn btn-danger delete btn-sm">Delete</a> </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade show" id="confirm-modal" tabindex="-1" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">You want to delete ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="delete-form" action="" method="POST">
                    @csrf
                    @method('delete')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">No. Back
                            !</button>
                        <button type="submit" class="btn btn-primary">Yes, Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function print_receipt(divName) {
            let printDoc = $('#' + divName).html();
            let originalContents = $('body').html();
            $("body").html(printDoc);
            window.print();
            $('body').html(originalContents);
        }

        $('.delete').click(function(event) {
            event.preventDefault();
            var url = $(this).attr("href");

            $("#delete-form").attr('action', url);
            $("#confirm-modal").modal('show');
        });
    </script>
@endsection
