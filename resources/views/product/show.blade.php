@extends('layouts.inc.user.app')
@section('content')
    <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="p-3">
                        <img src="{{ asset($product->image->image) }}" id="image" width="120"
                            class="p_img" alt="">
                    </div>
                </div>
                <div class="col-md-8">
                    <div>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Code</td>
                                    <td id="code">{{$product->code}} </td>
                                </tr>
                                <tr>
                                    <td>Category</td>
                                    <td id="category">{{$product->category->name}}</td>
                                </tr>
                                <tr>
                                    <td>Brand</td>
                                    <td id="brand">{{ $product->brand->name }} </td>
                                </tr>
                                <tr>
                                    <td>Price</td>
                                    <td id="price">{{ $product->sale_price }} </td>
                                </tr>
                                <tr>
                                    <td>Cost</td>
                                    <td id="cost">{{ $product->purchase_cost }}</td>
                                </tr>
                                <tr>
                                    <td>Stock</td>
                                    <td id="stock">{{ getTotalAvailAbleStock($product, productStock($product->purchased,$product->damage, $product->sell)) }}</td>
                                </tr>
                                <tr>
                                    <td>Details</td>
                                    <td id="details">

                                        {{$product->details}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
