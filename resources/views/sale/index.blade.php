@extends('layouts.inc.user.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Sale</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice No.</th>
                            <th>Items</th>
                            <th>Date</th>
                            <th>Discount</th>
                            <th>Receivable</th>
                            <th>Paid</th>
                            <th>Product Returned</th>
                            <th>Due</th>
                            <th>Purchase Cost</th>
                            <th>Profit</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            @php

                                $due = formatBalance(($order->receivable ?: 0) - ($order->paid ?: 0));
                            @endphp
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $order->id }}</td>
                                <td>
                                    {{-- <ul>
                                    @foreach ($order->order_details as $orderdetails)
                                        <li>{{$orderdetails->}} </li>
                                    @endforeach
                                   </ul> --}}
                                    product item
                                </td>
                                <td>{{ formatedate($order->date) }} </td>
                                <td>{{ formatBalance($order->discount ?: 0) }} TK </td>
                                <td>{{ formatBalance($order->receivable ?: 0) }} TK</td>
                                <td>{{ formatBalance($order->paid ?: 0) }} TK</td>
                                <td class="text-danger"> retrun </td>
                                <td>{{$due }} TK</td>
                                <td>{{ formatBalance($order->purchecost) }} TK</td>
                                <td>{{ formatBalance(($order->receivable ?: 0) - ($order->purchecost ?: 0)) }} TK</td>
                                <td>{{ $due <= 0 ?"PAID":"UNPAID" }} </td>

                            </tr>
                        @empty
                    <tfoot>
                        <tr class="text-center">
                            <td colspan="13">No record found!</td>
                        </tr>
                    </tfoot>
                    @endforelse
                    </tbody>

                </table>
                {{ $orders->links() }}
            </div>

        </div>
    </div>
@endsection
