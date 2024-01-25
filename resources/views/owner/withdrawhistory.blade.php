@extends('layouts.inc.user.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Withdraw histories</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Bank account</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($withdrawhistories as $withdrawhistory)
                        <tr>
                            <td>{{ ++$i }} </td>
                            <td>{{ formatedate($withdrawhistory->date) }} </td>
                            <td class="text-danger"> - {{ formatBalance($withdrawhistory->amount) }} </td>
                            <td>{{ $withdrawhistory->bank?->name }} </td>
                            <td>{{ $withdrawhistory->note }} </td>
                        </tr>
                    @empty
                    <tr class="text-center">
                        <td colspan="5"> No record found! </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $withdrawhistories->links() }}
        </div>
    </div>
@endsection
