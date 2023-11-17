@extends('layouts.inc.user.app')

@section('content')
    <x-modal-button id="exampleModal">
        Launch demo modal
    </x-modal-button>

    <x-modal id="exampleModal" title="Category">
        <form action="/store" method="POST" enctype="multipart/form-data">
            @csrf
            <x-file-input type="file" id="image" name="image" title="Image (optional)" />
            <x-text-input type="text" id="image" name="image" title="Category name" />

            <x-button type="submit" class="btn btn-primary">
                Submit
            </x-button>

        </form>
    </x-modal>
@endsection
