@extends('layouts.inc.user.app')


@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3>Owner</h3> <a href="{{ route('owner.create') }}" class="btn btn-primary float-end">Create owner</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>Invested</th>
                        <th>Withdrawn</th>
                        <th>Balance</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($owners as $key=>$owner)
                        <tr>
                            <td>{{ $key+1 }} </td>
                            <td>{{ $owner->name }} </td>
                            <td>{{ $owner->phone }} </td>
                            <td>{{ $owner->address }} </td>
                            <td>{{ $owner->invested }} </td>
                            <td>{{ $owner->withdrawn }} </td>
                            <td>{{ $owner->invested - $owner->withdrawn  }} </td>
                            <td>
                                <a href="{{ route('owner.edit',$owner->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <a href="{{ route('owner.destroy',$owner->id) }}" class="btn btn-danger delete btn-sm">Delete</a>
                            </td>
                        </tr>
                        @empty
                        <tfoot>
                            <tr class="text-center">
                                <td colspan="8">No record found</td>
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

