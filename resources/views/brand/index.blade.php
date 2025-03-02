@extends('layouts.inc.user.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Brands</h3>
        </div>
        <div class="card-body">
           <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Brand</th>
                        <th>Description</th>
                        <th>Logo</th>
                        <th>Count Products</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($brands as $key=>$brand)
                        <tr>
                            <td>{{ $key+1 }} </td>
                            <td>{{ $brand->name }} </td>
                            <td>{{ $brand->description }} </td>
                            <td>
                                @if ($brand->image->image != '')
                                    <img width="40px" src="{{ asset($brand->image->image) }}" alt="">
                                @endif
                            </td>
                            <td> {{ $brand->products_count }} </td>
                            <td>
                                <div class="">
                                    <a class="btn btn-default btn-sm" href="{{ route('brand.edit', $brand->id) }}">
                                        <i class="material-icons-two-tone">edit</i>
                                    </a>
                                    <a class="btn btn-default btn-sm delete"
                                        href="{{ route('brand.destroy', $brand->id) }}">
                                        <i class="material-icons-two-tone">delete</i>
                                    </a>
                                </div>

                            </td>
                        </tr>
                    @empty
                <tfoot>
                    <tr class="text-center">
                        <td colspan="6">No record found!</td>
                    </tr>
                </tfoot>
                @endforelse

                </tbody>
            </table>
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
                        <div class="d-flex">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">No. Back
                                !</button>
                            <button type="submit" class="btn btn-primary" style="margin-left: 3px">Yes, Delete</button>
                        </div>

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
