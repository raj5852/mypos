@extends('layouts.inc.user.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('purchase.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mt-3">
                            <label for="">Bill number</label>
                            <input type="text" name="bill" value="{{ request('bill') }}" placeholder="Bill number" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-3">
                            <label for="">Start date</label>
                            <input type="date" value="{{ request('start_date') }}" name="start_date" placeholder="Bill number" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-3">
                            <label for="">End date</label>
                            <input type="date" value="{{ request('end_date') }}" name="end_date" placeholder="Bill number" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-3">
                            <label for="">Select Supplier</label>
                            <select name="supplier_id" class="form-select" id="">
                                <option value="">Select supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option {{ request('supplier_id') == $supplier->id ?'selected':'' }}  value="{{$supplier->id}}">{{$supplier->name}}</option>
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
                                    <option {{ request('product_id') == $product->id ?'selected':'' }} value="{{ $product->id }}">{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-lg-5 mt-3">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('purchase.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>Purchases</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Bill NO</th>
                        <th>Supplier</th>
                        <th>Purchase Date</th>
                        <th>Items</th>
                        <th>Payable</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody style="font-weight: 300">
                    @forelse ($purchases as $purchase)
                        <tr>
                            <td>{{ ++$i }} </td>
                            <td>{{ $purchase->id }} </td>
                            <td>{{ $purchase->supplier->name }} </td>
                            <td>{{ formatedate($purchase->purchase_date) }} </td>
                            <td style="width: 200px">
                                <ul>
                                    @foreach ($purchase->products as $product)
                                        <li>{{ $product->name }} | {{ $product->code }} </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td> {{ formatBalance($purchase->payable) }} TK </td>
                            <td> {{ formatBalance($purchase->paid) }} TK </td>
                            <td> {{ formatBalance($purchase->due) }} TK </td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-primary dropdown-toggle" href="#" role="button"
                                        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                        Manage
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('purchase.invoice', $purchase->id) }} ">
                                                <div class="d-flex">
                                                    <i class="material-icons-two-tone"
                                                        style="font-size: 22px;margin-top:2px">print </i>
                                                    <p class="me-2">Invoice</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('purchase.show', $purchase->id) }}">
                                                <div class="d-flex">
                                                    <x-icon>desktop_windows</x-icon>
                                                    <p class="me-2">Show</p>
                                                </div>


                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                    @empty
                <tfoot>
                    <tr>
                        <td colspan="9">No record found</td>
                    </tr>
                </tfoot>
                @endforelse
                </tbody>
            </table>
            {{ $purchases->links() }}
        </div>
    </div>


@endsection
