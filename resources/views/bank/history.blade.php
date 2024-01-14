@extends('layouts.inc.user.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Transaction History</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">Account Name:</div>
                <div class="col-6">{{$bank->name}}</div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Date</td>
                        <td>Amount</td>
                        <td>Type</td>
                        <td>Note</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($histories as $history)
                        <tr>
                            <td>{{ ++$i }} </td>
                            <td>{{ formatedate($history->date) }} </td>
                            <td class="{{ $history->type == '+' ? 'text-success':'text-danger' }} ">{{ $history->amount }} </td>
                            <td>{{ $history->type == '+' ? 'Received':'Spent / Withdraw' }} </td>
                            <td>{{$history->note }} </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            {{ $histories->links() }}
        </div>
    </div>
@endsection
