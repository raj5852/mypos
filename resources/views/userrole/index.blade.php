@extends('layouts.inc.user.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>User and role managment</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-danger">{{ $error }} </li>
                @endforeach
            </ul>

            @endif

            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>

            @endif

            <form action="{{ route('userrole.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Roles <span class="text-danger">*</span></label>
                            <div class="d-flex">
                                <input type="checkbox" id="selectAllRoles"> <label for="selectAllRoles" style="margin-left: 3px;font-weight: bold;">Select
                                    All</label>
                            </div>
                            <div class="row">
                                @foreach ($roles as $role)
                                    <div class="col-6">
                                        <div class="d-flex">
                                            <input type="checkbox" id="{{ $role->name }}" name="role[]" value="{{ $role->id }}" > <label for="{{ $role->name }}"
                                                style="margin-left: 3px" >

                                                {{ $role->name == 'user_and_role' ? 'user and role': $role->name }}

                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <h3>User lists</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>{{$user->id }} </td>
                            <td>{{$user->name }} </td>
                            <td>{{$user->email }} </td>
                            <td>{{$user->email }} </td>
                            <td>
                                <a href="{{ route('userrole.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <a href="{{ route('userrole.destroy', $user->id) }}" class="btn btn-danger btn-sm delete">Delete</a>

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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">No.
                                Back
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
        $('#selectAllRoles').on('change', function () {
            $('.row input[type="checkbox"]').prop('checked', this.checked);
            // alert(1);
        });
    </script>
@endsection
