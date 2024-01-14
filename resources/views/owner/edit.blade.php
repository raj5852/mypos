@extends('layouts.inc.user.app')


@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Edit Owner</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('owner.update', $owner->id) }}" method="post">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Owner name</label>
                            <input type="text" value="{{ $owner->name }}" name="name" class="form-control"
                                placeholder="Name">
                            @error('name')
                                <span class="text-danger">{{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Mobile</label>
                            <input type="text" name="phone" value="{{ $owner->phone }}" class="form-control"
                                placeholder="Mobile">
                            @error('phone')
                                <span class="text-danger">{{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mt-3">
                            <label for="">Address</label>
                            <textarea name="address" id="" class="form-control" rows="5">{{ $owner->address }}</textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <center>
                        <button class="btn btn-primary"><x-icon>save</x-icon> Update owner</button>
                    </center>

                </div>
        </div>
        </form>
    </div>
    </div>
@endsection
