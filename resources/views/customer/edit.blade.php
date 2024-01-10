@extends('layouts.inc.user.app')


@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Edit customer</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('customer.update',$customer->id) }}" method="post">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Customer name <span class="text-danger">*</span> </label>
                            <input type="text" name="name" placeholder="Name" value="{{$customer->name }}"
                                class="form-control @error('name')   is-invalid @enderror">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Email</label>
                            <input type="email" name="email" placeholder="Email" value="{{$customer->email }}"
                                class="form-control @error('email')   is-invalid @enderror">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Address</label>
                            <textarea name="address" id="" rows="3" class="form-control @error('address')   is-invalid @enderror">{{ $customer->address }}</textarea>
                            @error('address')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" value="{{ $customer->phone }}" class="form-control @error('phone')   is-invalid @enderror"
                                placeholder="Phone number">
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mt-3">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
