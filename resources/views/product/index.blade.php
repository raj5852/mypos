@extends('layouts.inc.user.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mt-3">
                            <input type="text" name="code" value="{{ request('code', '') }}" placeholder="Product code"
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-3">
                            <input type="text" name="name" value="{{ request('name', '') }}"
                                placeholder="Product name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-3">
                            <select name="category_id" class="form-select" id="">
                                <option value="">Select category</option>
                                @foreach ($categories as $category)
                                    <option {{ $category->id == request('category_id') ? 'selected' : '' }}
                                        value="{{ $category->id }}">{{ $category->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-3">
                            <select name="brand_id" class="form-select" id="">
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option {{ $brand->id == request('brand_id') ? 'selected' : '' }}
                                        value="{{ $brand->id }}">{{ $brand->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary"> <x-icon>tune</x-icon> Filter</button>
                            <a class="btn btn-secondary" href="{{ route('product.index') }}">Reset</a>

                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>All products</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Cost</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>


                    @forelse ($products as $product)
                        <tr>
                            <td style="width: 2%">{{ ++$i }} </td>
                            <td style="width: 4%">
                                <img src="{{ asset($product->image->image) }}" width="40px" alt="">
                            </td>
                            <td>{{ $product->code }} </td>
                            <td>{{ $product->name }} </td>
                            <td>{{ $product->category->name }} </td>
                            <td>{{ $product->brand->name }} </td>
                            <td>{{ $product->sale_price }} </td>
                            <td>{{ $product->purchase_cost }} </td>
                            <td class="d-flex">
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-default btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960"
                                        width="24">
                                        <path
                                            d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z" />
                                    </svg>
                                </a>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle btn-sm"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="material-icons-two-tone">settings</i>
                                    </button>
                                    <ul class="dropdown-menu ">
                                        <li>
                                            <div class="d-flex">
                                                <i class="material-icons-two-tone mt-2">edit</i>
                                                <a class="dropdown-item "
                                                    href="{{ route('product.edit', $product->id) }}">Edit</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex">
                                                <i class="material-icons-two-tone mt-2">history</i>
                                                <a class="dropdown-item "
                                                    href="{{ route('product.sellhistory', $product->id) }}">Sell
                                                    history</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex">
                                                <i class="material-icons-two-tone mt-2">delete</i>
                                                <a class="dropdown-item delete"
                                                    href="{{ route('product.destroy', $product->id) }}">Delete</a>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                                <a href="{{ route('product.barcode', $product->id) }}"
                                    class="btn btn-default text-center btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960"
                                        width="24">
                                        <path
                                            d="M40-200v-560h80v560H40Zm120 0v-560h80v560h-80Zm120 0v-560h40v560h-40Zm120 0v-560h80v560h-80Zm120 0v-560h120v560H520Zm160 0v-560h40v560h-40Zm120 0v-560h120v560H800Z" />
                                    </svg>
                                </a>

                                <a href="{{ route('product.qrcode', $product->id) }}"
                                    class="btn btn-default text-center btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960"
                                        width="24">
                                        <path
                                            d="M520-120v-80h80v80h-80Zm-80-80v-200h80v200h-80Zm320-120v-160h80v160h-80Zm-80-160v-80h80v80h-80Zm-480 80v-80h80v80h-80Zm-80-80v-80h80v80h-80Zm360-280v-80h80v80h-80ZM180-660h120v-120H180v120Zm-60 60v-240h240v240H120Zm60 420h120v-120H180v120Zm-60 60v-240h240v240H120Zm540-540h120v-120H660v120Zm-60 60v-240h240v240H600Zm80 480v-120h-80v-80h160v120h80v80H680ZM520-400v-80h160v80H520Zm-160 0v-80h-80v-80h240v80h-80v80h-80Zm40-200v-160h80v80h80v80H400Zm-190-90v-60h60v60h-60Zm0 480v-60h60v60h-60Zm480-480v-60h60v60h-60Z" />
                                    </svg>
                                </a>

                            </td>
                        </tr>
                    @empty
                <tfoot>
                    <tr class="text-center">
                        <td colspan="9">No product found!</td>
                    </tr>
                </tfoot>
                @endforelse
                </tbody>
            </table>
            {{ $products->links() }}


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
