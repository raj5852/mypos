@extends('layouts.inc.user.app')

@section('content')
    <div class="card">
        <div class="card-header">Add payment</div>
        <div class="card-body">
            <form action="{{ route('sale.store') }}" method="POST">
                @csrf
                <input type="hidden" name="orderid" value="{{$orderid}}">
                <div class="row">
                    <div class="mt-3">
                        <label for="">Payment Date</label>
                        <input type="date" name="date" value="{{currentdateFormate()}}" class="form-control" >
                        @error('date')
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="">Transaction Account</label>
                        <select name="bank" class="form-control">
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                        @error('bank')
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="">Amount</label>
                        <input type="text" value="{{orderDue($orderid)}}" class="form-control" name="amount">
                        @error('amount')
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>

                    <div class="mt-3">
                        <label for="">Note</label>
                        <textarea name="note" class="form-control" rows="3"></textarea>
                        @error('note')
                            <span class="text-danger">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Add payment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
