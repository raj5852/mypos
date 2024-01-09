@extends('layouts.inc.user.app')
@section('content')
    <div class="card">
        <div class="card-header"><h3>All products</h3></div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Cost</th>
                        <th>Action</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
@endsection
