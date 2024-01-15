@extends('layouts.inc.user.app')


@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('bank.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="mt-3">
                            <label for="">Enter account name</label>
                            <input type="text" class="form-control" name="name" placeholder="Account name">
                            @error('name')
                                <span class="text-danger">{{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mt-3">
                            <label for="">Opening balance</label>
                            <input type="text" name="opening_balance" class="form-control" placeholder="Opening balance">
                            @error('opening_balance')
                                <span class="text-danger">{{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mt-lg-5 mt-3">
                            <button class="btn btn-primary">Create </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3>Accounts</h3>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Opening Balance </th>
                        <th>Current Balance </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($banks as $key=>$bank)
                        <tr>
                            <td>{{ $key + 1 }} </td>
                            <td>{{ $bank->name }} </td>
                            <td>{{ $bank->opening_balance }} </td>
                            <td>{{ $bank->opening_balance + ($bank->current_balance-$bank->withdraw)}} </td>
                            <td>
                                <a href="{{ route('bank.addbalance',$bank->id) }}" class="btn btn-outline-primary "><x-icon>add</x-icon>  Add balance</a><br>
                                <a href="{{ route('bank.withdraw',$bank->id) }}" class="btn btn-outline-primary"> <x-icon>shopping_cart_checkout</x-icon> Withdraw balance</a><br>
                                <div class="d-flex">
                                    <a href="{{ route('bank.transfer',$bank->id) }}" class="btn btn-outline-primary me-1"> <x-icon>move_up</x-icon> Transfer</a>
                                <a href="{{ route('bank.transaction',$bank->id) }}" class="btn btn-primary"> <x-icon>history</x-icon> History</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                <tfoot>
                    <tr class="text-center">
                        <td colspan="5">No record found</td>
                    </tr>
                </tfoot>
                @endforelse
                </tbody>


            </table>
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
