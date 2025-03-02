@extends('layouts.inc.user.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>User and role edit</h3>
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

            <form action="{{ route('userrole.update',$user->id) }}" method="POST">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name', $user->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email', $user->email) }}" required>
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
                                <input type="checkbox" id="selectAllRoles" {{ $roles->pluck('id')->count() == $user->roles->pluck('id')->count() ? 'checked':'' }} > <label for="selectAllRoles" style="margin-left: 3px;font-weight: bold;">Select All</label>
                            </div>
                            <div class="row">
                                @foreach ($roles as $role)
                                    <div class="col-6">
                                        <div class="d-flex">
                                            <input type="checkbox" id="{{ $role->name }}" name="role[]" value="{{ $role->id }}" {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'checked':'' }} > <label for="{{ $role->name }}"
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
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </div>

                </div>
            </form>
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
