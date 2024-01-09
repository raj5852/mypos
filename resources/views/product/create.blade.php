@extends('layouts.inc.user.app')


@section('content')
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <livewire:product.create />
@endsection

@section('js')
    <script>
        window.addEventListener('closeModal', event => {
            $('#categoryModal').modal('hide');
            $('#brandModal').modal('hide');

            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("Successfully created");

        })
    </script>
@endsection
