@extends('layouts.inc.user.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Select Product</label>
                        <select name="product_id" id="product" class="form-select">
                            <option value="">Select Prodcut</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="">Product code</label>
                        <input type="text" name="code" class="form-control">
                    </div>
                    <div class="col-md-6 mt-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('damage.index') }}" class="btn btn-secondary">Rest</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Damages</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Code</th>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                </thead>
                @forelse ($damages as $damage)
                    <tr>
                        <td>{{ ++$i }} </td>
                        <td>{{ $damage->product->code }} </td>
                        <td>{{ formatedate($damage->date) }} </td>
                        <td>{{ $damage->product?->name }} </td>
                        <td>{{ getTotalAvailAbleStock($damage->product, $damage->qty) }} </td>
                        <td>{{ $damage->note }} </td>
                        <td> <a href="{{ route('damage.destroy', $damage->id) }}"
                                class="btn btn-danger delete btn-sm">Delete</a> </td>

                    </tr>
                @empty
                    <tfoot>
                        <tr class="text-center">
                            <td colspan="6">No record found!</td>
                        </tr>
                    </tfoot>
                @endforelse
            </table>
            {{ $damages->links() }}
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">No. Back
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
