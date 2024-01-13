@extends('layouts.inc.user.app')

@section('content')
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
                                        <li><a class="dropdown-item" href="{{ route('purchase.invoice', $purchase->id) }} ">
                                                <i class="material-icons-two-tone"
                                                    style="font-size: 25px;margin-top:2px">print</i>
                                                Invoice</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
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

        </div>
    </div>
@endsection
