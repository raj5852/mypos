@extends('layouts.inc.user.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Add Payment</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('purchase.addpaymentStore',$purchase->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Payment Date</label>
                            <input type="date" name="date" class="form-control" value="{{ currentdateFormate() }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Transaction Account</label>
                            <select name="account" id="" class="form-control">
                                @foreach ($banks as $bank)
                                    <option value="{{$bank->id}}">{{$bank->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Amount</label>
                            <input type="text" name="amount" class="form-control" value="{{$purchase->due}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Note</label>
                            <textarea name="note" name="note" id="" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <button class="btn btn-primary">Add payment</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
