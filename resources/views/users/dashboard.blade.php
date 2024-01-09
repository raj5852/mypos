@extends('layouts.inc.user.app')

@section('content')
    <x-modal-button id="exampleModal">
        Launch demo modal
    </x-modal-button>

    {{-- <x-modal id="exampleModal" title="Category">
        <form action="/store" method="POST" enctype="multipart/form-data">
            @csrf
            <x-file-input type="file" id="image" name="image" title="Image (optional)" />
            <x-text-input type="text" id="image" name="image" title="Category name" />

            <x-button type="submit" class="btn btn-primary">
                Submit
            </x-button>
        </form>
    </x-modal> --}}

    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/store" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="Mo8wMv3chWmWJ5guSmo5bW2kj3XmIWMJ8vmMVJ1B"
                            autocomplete="off">
                        <div class="mb-3">
                            <label for="image" class="form-label">Image (optional)</label>
                            <input type="file" class="form-control" id="image" name="image" placeholder="">
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="image" name="image" placeholder="">
                            <label for="image">Category name</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
