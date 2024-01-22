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
                                        <td style="padding: 6px 20px!important;">Invoice No: <strong> {{ $order->id }} </strong> </td>
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
                                            <strong>{{$order->customer->phone}} </strong>
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
                            <p>Note: {{$order?->history?->note}} </p>

                        </div>

                        <button class="col-12 btn btn-secondary btn-block" onclick="print_receipt('print-area')">
                            <i class="fa fa-print"></i>
                            Print
                        </button>
                        <div class="row mt-3">
                            <div class="col-6">
                                <a href="{{ route('pos') }}"
                                    class="col-12 btn btn-primary"><x-icon>reply</x-icon> New sale</a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('sale') }}"
                                    class="col-12 btn btn-primary"><x-icon>reply</x-icon>Sale list</a>
                            </div>
                        </div>
                    </div>
                </div>
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
    </script>
@endsection
