@extends('layouts.inc.user.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('product.stock') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Select product">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <input type="text" class="form-control" value="{{ request('code', '') }}"
                                placeholder="Product code" name="code">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <input type="text" class="form-control" value="{{ request('name', '') }}"
                                placeholder="Product name" name="name">

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <select name="category_id" class="form-select">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option {{ request('category_id') == $category->id ? 'selected' : '' }}
                                        value="{{ $category->id }}">{{ $category->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <select name="brand_id" class="form-select">
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option {{ request('brand_id') == $brand->id ? 'selected' : '' }}
                                        value="{{ $brand->id }}">{{ $brand->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('product.stock') }}" class="btn btn-secondary">Reset</a>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Product Stock</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Purchased</th>
                            <th>Sold</th>
                            <th>Damaged</th>
                            <th>Returned</th>
                            <th>Available Stock</th>
                            <th>Sell Value</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: 500">


                        @forelse ($products as $product)
                            <tr>
                                <td>{{ ++$i }} </td>
                                <td>
                                    <img src="{{ asset($product->image->image) }}" width="40px" alt="">
                                </td>
                                <td>{{ $product->name }} </td>
                                <td>{{ $product->category->name }} </td>
                                <td>{{ $product->sale_price }} </td>
                                <td>{{ $product->total_purchased }} </td>

                                <td>sold </td>
                                <td>Damaged </td>
                                <td>Returned </td>
                                <td>{{ $product->available_stock }} </td>
                                <td> {{ formatBalance($product->stock * $product->sale_price) }} TK</td>
                            </tr>
                        @empty
                    <tfoot>
                        <tr class="text-center">
                            <td colspan="11">No recored found! </td>
                        </tr>
                    </tfoot>
                    @endforelse
                    </tbody>
                </table>

            </div>
            {{ $products->links() }}

        </div>
    </div>
@endsection
