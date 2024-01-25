@extends('layouts.inc.user.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Sell history</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sell Date</th>
                        <th>Sale#</th>
                        <th>Name</th>
                        <th>Unit Price: </th>
                        <th>Quantity</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orderDetails as $orderDetail)
                        <tr>
                            <td>{{ ++$i }} </td>
                            <td>{{ formateDate($orderDetail->date) }} </td>
                            <td><a href="{{ route('sale.print', $orderDetail->order_id) }}">#Pos{{ $orderDetail->order_id }}
                                </a> </td>
                            <td>{{ $orderDetail->product->name }} </td>
                            <td> {{ formatBalance($orderDetail->sell_price) }} </td>
                            <td> {{ getTotalAvailAbleStock($orderDetail->product, $orderDetail->qty) }} </td>
                            <td> {{ formatBalance($orderDetail->total_sell_price) }} </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="7">No record found!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $orderDetails->links() }}
        </div>
    </div>
@endsection
