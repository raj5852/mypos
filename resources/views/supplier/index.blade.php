@extends('layouts.inc.user.app')


@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('supplier.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <input type="text" name="name" value="{{ request('name', '') }}" class="form-control"
                                placeholder="Name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <input type="text" name="phone" value="{{ request('phone', '') }}" class="form-control"
                                placeholder="Mobile number">
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <button class="btn btn-primary"><x-icon>tune</x-icon> Filter</button>
                        <a class="btn btn-secondary" href="{{ route('supplier.index') }}"> Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>All supplier list</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Payable</th>
                        <th>Paid</th>
                        <th>Purchase Due</th>
                        <th>Wallet Balance</th>
                        <th>Total Due</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>


                    @forelse ($suppliers as $supplier)
                        <tr>
                            <td>{{ ++$i }} </td>
                            <td>{{ $supplier->name }} </td>
                            <td>{{ $supplier->email }} </td>
                            <td>{{ $supplier->phone }} </td>
                            <td>{{ $supplier->address }} </td>
                            <td>{{ $supplier->payable ?? 0 }} TK </td>
                            <td>{{ $supplier->paid ?? 0 }} TK </td>
                            <td>{{ ($supplier->payable ?? 0 )- ($supplier->paid ?? 0) }} TK</td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle btn-sm"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <x-setting-icon />
                                    </button>
                                    <ul class="dropdown-menu ">
                                        <li>
                                            <div class="d-flex">
                                                <i class="material-icons-two-tone mt-2">edit</i>
                                                <a class="dropdown-item "
                                                    href="{{ route('supplier.edit', $supplier->id) }}">Edit</a>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="d-flex">
                                                <i class="material-icons-two-tone mt-2">delete</i>
                                                <a class="dropdown-item delete"
                                                    href="{{ route('supplier.destroy', $supplier->id) }}">Delete</a>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                            </td>
                        </tr>
                    @empty
                <tfoot>
                    <tr class="text-center">
                        <td colspan="11">No record found!</td>
                    </tr>
                </tfoot>
                @endforelse
                </tbody>
            </table>
            {{ $suppliers->links() }}
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
