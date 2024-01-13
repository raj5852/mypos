@extends('layouts.inc.user.app')
@section('css')

@endsection
@section('content')
    <div class="row">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4>{{ $address->company_name }} </h4>
                            </div>
                            <div class="col-6">
                                <span>Address: <strong>{{$address->address}} </strong> </span><br>
                                <span>Phone: <strong>{{$address->phone}}</strong> </span><br>
                                <span>Email: <strong>{{$address->email}} </strong> </span><br>
                            </div>
                        </div>
                        <table class="table table-bordered table-sm">
                            <tbody style="font-weight: 300">
                                <tr>
                                    <td style="padding: 6px 20px!important;" >Date: <strong>{{  formatedate($purchase->created_at) }} </strong> </td>
                                </tr>
                                <tr>
                                    <td style="padding: 6px 20px!important;" >Invoice No: <strong>{{$purchase->id}} </strong> </td>
                                </tr>
                                <tr>
                                    <td style="padding: 6px 20px!important;">Supplier Name: <strong>{{$purchase->supplier->name}} </strong></td>
                                </tr>
                                <tr>
                                    <td style="padding: 6px 20px!important;">Address : <strong>{{$purchase->supplier->address}}</strong></td>
                                </tr>
                                <tr>
                                    <td style="padding: 6px 20px!important;">Mobile : <strong>{{$purchase->supplier->phone}}</strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <thead style="background: #e9e9e9">
                                <tr>
                                    <td >#</td>
                                    <td>Details</td>
                                    <td>Qty</td>
                                    <td>Price</td>
                                    <td>Net.A</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchase->products as $key=>$product)
                                <tr>
                                    <td>{{ $key+1 }} </td>
                                    <td>{{$product->name}} | {{$product->code}}</td>
                                    {{-- <td>{{$product->pivot->}}</td> --}}
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr >
                                    <td style="padding: 6px 20px!important;" colspan="4" class="text-end" ><strong>Grand Total</strong> : </td>
                                    <td style="padding: 6px 20px!important;" colspan="1">12 </td>
                                </tr>
                                <tr>
                                    <td  style="padding: 6px 20px!important;" colspan="4" class="text-end"><strong>Paid</strong> : </td>
                                    <td style="padding: 6px 20px!important;" colspan="1">12 </td>
                                </tr>
                                <tr>
                                    <td style="padding: 6px 20px!important;" colspan="4" class="text-end"><strong>Due</strong>: </td>
                                    <td style="padding: 6px 20px!important;" colspan="1">12 </td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
