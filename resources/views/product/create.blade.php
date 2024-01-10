@extends('layouts.inc.user.app')


@section('content')

    <livewire:product.create lazy />
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
