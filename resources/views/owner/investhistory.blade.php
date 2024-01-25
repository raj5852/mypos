@extends('layouts.inc.user.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Invested histories</h3>
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
                    @forelse ($investhistories as $investhistory)
                        <tr>
                            <td>{{ ++$i }} </td>
                            <td>{{ formatedate($investhistory->date) }} </td>
                            <td class="text-success">+ {{ formatBalance($investhistory->amount) }} </td>
                            <td>{{ $investhistory->bank?->name }} </td>
                            <td>{{ $investhistory->note }} </td>
                        </tr>
                    @empty
                    <tr class="text-center">
                        <td colspan="5"> No record found! </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $investhistories->links() }}
        </div>
    </div>
@endsection
