@extends('layouts.inc.user.app')
@section('css')
@endsection
@section('content')
    <div class="row">
        <div class="d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id="print-area">
                            <div class="row">
                                <div class="col-6">
                                    <h5>{{ $address?->company_name }} </h5>
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
                                        <td style="padding: 6px 20px!important;">Product</td>
                                        <td style="padding: 6px 20px!important;">Quantity</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->products as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }} </td>
                                            <td> {{ $product->name }} </td>
                                            <td>{{ getTotalAvailAbleStock($product, $product->pivot->qty) }} </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        <button class="col-12 btn btn-secondary btn-block" onclick="print_receipt('print-area')">
                            <i class="fa fa-print"></i>
                            Print
                        </button>
                        <div class="row mt-3">
                            <div class="col-12">
                                <a href="{{ route('sale') }}" class="col-12 btn btn-primary"><x-icon>reply</x-icon>Sale
                                    List</a>
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
