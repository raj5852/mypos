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
                                    <h4>{{ $address?->company_name }} </h4>
                                </div>
                                <div class="col-6">
                                    <span>Address: <strong>{{ $address?->address }} </strong> </span><br>
                                    <span>Phone: <strong>{{ $address?->phone }}</strong> </span><br>
                                    <span>Email: <strong>{{ $address?->email }} </strong> </span><br>
                                </div>
                            </div>
                            <table class="table table-bordered table-sm">
                                <tbody style="font-weight: 300">
                                    <tr>
                                        <td style="padding: 6px 20px!important;">Date:
                                            <strong>{{ formatedate($order->date) }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 20px!important;">Invoice No: <strong> {{ $order->id }}
                                            </strong> </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 20px!important;">Customer Name:
                                            <strong> {{ $order->customer->name }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 20px!important;">Address :
                                            <strong>{{ $order->customer->address }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 20px!important;">Mobile :
                                            <strong>{{ $order->customer->phone }} </strong>
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
                                    @foreach ($order->products as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }} </td>
                                            <td> {{ $product->name }} </td>
                                            <td>{{ getTotalAvailAbleStock($product, $product->pivot->qty) }} </td>
                                            <td>{{ formatBalance($product->pivot->sell_price) }} TK</td>
                                            <td>{{ formatBalance($product->pivot->total_sell_price) }} TK</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>

                                    @php
                                        $grandTotal = $order->totalsellprice - $order->discount;
                                    @endphp
                                    <tr>
                                        <td style="padding: 6px 20px!important;" colspan="4" class="text-end">
                                            <strong>Total</strong> :
                                        </td>
                                        <td style="padding: 6px 20px!important;" colspan="1">
                                            {{ formatBalance($order->totalsellprice) }} TK </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 20px!important;" colspan="4" class="text-end">
                                            <strong>Discount</strong> :
                                        </td>
                                        <td style="padding: 6px 20px!important;" colspan="1">
                                            {{ formatBalance($order->discount) }} TK
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 20px!important;" colspan="4" class="text-end">
                                            <strong>Grand Total</strong>:
                                        </td>

                                        <td style="padding: 6px 20px!important;" colspan="1">
                                            {{ formatBalance($grandTotal) }} TK
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 20px!important;" colspan="4" class="text-end">
                                            <strong>Total Paid</strong>:
                                        </td>
                                        <td style="padding: 6px 20px!important;" colspan="1">
                                            {{ formatBalance($order->paid) }} TK
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 20px!important;" colspan="4" class="text-end">
                                            <strong>Total Due</strong>:
                                        </td>
                                        <td style="padding: 6px 20px!important;" colspan="1">
                                            {{ formatBalance($grandTotal - $order->paid) }} TK
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="d-flex justify-content-between">
                                <h3>Payments</h3>
                                <a href="{{ route('sale.addpayment', $order->id) }}" class=" btn btn-primary">Add
                                    payment</a>
                            </div>
                            <div class="mt-3">

                                <table class="table table-bordered">
                                    <thead style="background: #e9e9e9">
                                        <tr>
                                            <td style="padding: 6px 20px!important;">Date</td>
                                            <td style="padding: 6px 20px!important;">Amount</td>
                                            <td style="padding: 6px 20px!important;">Actions</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->histories as $history)
                                            <tr>
                                                <td>{{ formatedate($history->date) }} </td>
                                                <td>{{ formatBalance($history->amount) }} </td>
                                                <td> <a href="{{ route('sale.addpayment.delete', $history->id) }}"
                                                        class="btn btn-danger delete btn-sm">Delete</a> </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class=" mb-3">
                        <button class="col-12 btn btn-secondary btn-block" onclick="print_receipt('print-area')">
                            <i class="fa fa-print"></i>
                            Print
                        </button>
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
        $('.delete').click(function(event) {
            event.preventDefault();
            var url = $(this).attr("href");

            $("#delete-form").attr('action', url);
            $("#confirm-modal").modal('show');
        });

        function print_receipt(divName) {
            let printDoc = $('#' + divName).html();
            let originalContents = $('body').html();
            $("body").html(printDoc);
            window.print();
            $('body').html(originalContents);
        }
    </script>
@endsection
