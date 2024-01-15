@extends('layouts.inc.user.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Setting</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('setting.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Company name</label>
                            <input type="text" value="{{$setting?->company_name}}" class="form-control" name="company_name" placeholder="Company name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Email address</label>
                            <input type="email" value="{{$setting?->email}}" class="form-control" name="email" placeholder="Email address">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Phone</label>
                            <input type="text" value="{{$setting?->phone}}" class="form-control" name="phone" placeholder="Phone">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Address</label>
                            <input type="text" value="{{$setting?->address}}" class="form-control" name="address" placeholder="address">
                        </div>
                    </div>

                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Save</button>

                </div>
            </form>

        </div>
    </div>
@endsection
