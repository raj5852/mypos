@extends('layouts.inc.user.app')


@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Withdraw balance</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('bank.withdrawStore',$id) }}" method="POST">
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
                            <label for="">Owner</label>
                            <select name="owner" id="" class="form-control">
                                <option value="">Select owner</option>
                                @foreach ($owners as $owner)
                                    <option value="{{ $owner->id }}">{{ $owner->name }} </option>
                                @endforeach
                            </select>
                            @error('owner')
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
                        <button class="btn btn-primary" type="submit">Withdraw</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
