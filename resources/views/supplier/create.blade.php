@extends('layouts.inc.user.app')


@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Add Supplier</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('supplier.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Supplier name <span class="text-danger">*</span> </label>
                            <input type="text" name="name" placeholder="Name"
                                class="form-control @error('name')   is-invalid @enderror">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Email</label>
                            <input type="email" name="email" placeholder="Email"
                                class="form-control @error('email')   is-invalid @enderror">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Address</label>
                            <textarea name="address" id="" rows="3" class="form-control @error('address')   is-invalid @enderror"></textarea>
                            @error('address')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control @error('phone')   is-invalid @enderror"
                                placeholder="Phone number">
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Opening Receivable</label>
                            <input type="text" name="opening_receivable"
                                class="form-control  @error('opening_receivable')   is-invalid @enderror"
                                placeholder="Opening Receivable">
                            @error('opening_receivable')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>
                    </div> --}}
                    {{-- <div class="col-md-12">
                        <div class="mt-3">
                            <label for="">Opening Payable</label>
                            <input type="text" name="opening_payable"
                                class="form-control @error('opening_payable')   is-invalid @enderror"
                                placeholder="Opening Payable">
                            @error('opening_payable')
                                <span class="invalid-feedback">{{ $message }} </span>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="col-md-6">
                        <div class="mt-3">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
