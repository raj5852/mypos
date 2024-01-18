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
                                            <strong>{{ formatedate($purchase->date) }} </strong>
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
                                            {{ formatBalance($purchase->payable ?? 0 ) }} TK </td>
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
                                        <td style="padding: 6px 20px!important;" colspan="1">{{  $purchase->payable - $purchase->paid }} TK
                                        </td>
                                    </tr>
                                </tfoot>

                            </table>
                            <p>Note: {{ $purchase->note }} </p>

                        </div>

                        <button class="col-12 btn btn-secondary btn-block" onclick="print_receipt('print-area')">
                            <i class="fa fa-print"></i>
                            Print
                        </button>
                        <div class="row mt-3">
                            <div class="col-6">
                                <a href="{{ route('purchase.create') }}" class="col-12 btn btn-primary"><x-icon>reply</x-icon> New purchase</a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('purchase.index') }}" class="col-12 btn btn-primary"><x-icon>reply</x-icon>Purchase list</a>
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
