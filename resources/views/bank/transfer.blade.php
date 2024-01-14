@extends('layouts.inc.user.app')


@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Withdraw balance</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('bank.transferStore',$id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">Amount</label>
                            <input type="text" class="form-control" name="amount">
                            @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label for="">To Account</label>
                            <select name="bank" id="" class="form-control">
                                <option value="">Select Account</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->name }} </option>
                                @endforeach
                            </select>
                            @error('bank')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mt-3">
                            <label for="">Note</label>
                            <textarea name="note" class="form-control" id="" rows="5"></textarea>
                            @error('note')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary" type="submit">Transfer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
