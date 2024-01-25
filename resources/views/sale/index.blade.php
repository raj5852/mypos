@extends('layouts.inc.user.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Sales</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered top-summary">
                <tbody>
                    <tr>
                        <td class="bg-danger">Sold Today:</td>
                        <td class="bg-success">{{ SoldToday() }} Tk</td>
                        <td class="bg-warning">Today Received:</td>
                        <td class="bg-success">{{ TodayReceived() }} Tk</td>
                        <td class="bg-danger">Today Profit:</td>
                        <td class="bg-success">{{ TodayProfit() }} Tk</td>
                        <td class="bg-warning">Total Sold:</td>
                        <td class="bg-success">{{ totalSold() }} Tk</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('sale') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mt-3">
                            <label for="">Bill number</label>
                            <input type="text" name="bill" value="{{ request('bill') }}" placeholder="Bill number"
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-3">
                            <label for="">Start date</label>
                            <input type="date" value="{{ request('start_date') }}" name="start_date"
                                placeholder="Bill number" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-3">
                            <label for="">End date</label>
                            <input type="date" value="{{ request('end_date') }}" name="end_date"
                                placeholder="Bill number" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-3">
                            <label for="">Select Customer</label>
                            <select name="customer_id" class="form-select" id="">
                                <option value="">Select supplier</option>
                                @foreach ($sales as $sale)
                                    <option {{ request('customer_id') == $sale->id ? 'selected' : '' }}
                                        value="{{ $sale->id }}">{{ $sale->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-3">
                            <label for="">Select product</label>
                            <select name="product_id" class="form-select" id="">
                                <option value="">Select product</option>
                                @foreach ($products as $product)
                                    <option {{ request('product_id') == $product->id ? 'selected' : '' }}
                                        value="{{ $product->id }}">{{ $product->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-lg-5 mt-3">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('sale') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

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
                            <th>Customer.</th>
                            <th>Items</th>
                            <th>Date</th>
                            <th>Discount</th>
                            <th>Receivable</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Purchase Cost</th>
                            <th>Profit</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: 300">
                        @forelse ($orders as $order)
                            @php
                                $due = formatBalance(($order->receivable ?: 0) - ($order->paid ?: 0));
                            @endphp
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td>
                                    <ul style="padding: 0px 5px">
                                        @foreach ($order->products as $product)
                                            <li>{{ $product->name }} : {{ $product->code }} *
                                                {{ getTotalAvailAbleStock($product, $product->pivot->qty) }} </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ formatedate($order->date) }} </td>
                                <td>{{ formatBalance($order->discount ?: 0) }} TK </td>
                                <td>{{ formatBalance($order->receivable ?: 0) }} TK</td>
                                <td>{{ formatBalance($order->paid ?: 0) }} TK</td>
                                <td>{{ $due }} TK</td>
                                <td>{{ formatBalance($order->purchecost) }} TK</td>
                                <td>{{ formatBalance(($order->receivable ?: 0) - ($order->purchecost ?: 0)) }} TK</td>
                                <td>{{ $due <= 0 ? 'PAID' : 'UNPAID' }} </td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button"
                                            id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            Manage
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('sale.print', $order->id) }}">Print</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('sale.chalanprint', $order->id) }}">Chalan
                                                    print</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('sale.show', $order->id) }}">Show</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('sale.addpayment', $order->id) }}">Add Payment</a></li>
                                            <li><a class="dropdown-item delete"
                                                    href="{{ route('sale.delete', $order->id) }}">Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">No.
                            Back
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
    </script>
@endsection
