@extends('layouts.inc.user.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Units</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive" >
                <table class="table table-bordered tableBottomGap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Related To</th>
                            <th>Related Sign</th>
                            <th>Related By</th>
                            <th>Result</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($units as $ey=>$unit)
                            <tr>
                                <td>{{ $ey + 1 }} </td>
                                <td>{{ $unit->unit_name }} </td>
                                <td>{{ $unit->relatedtodata->unit_name ?? '-' }} </td>
                                <td>{{ $unit->operator ?? '-' }} </td>
                                <td>{{ $unit->related_by_value ?? '-' }} </td>
                                <td>
                                    @if ($unit->related_by_value != '')
                                        {{ $unit->unit_name }} = 1 {{ $unit->relatedtodata->unit_name }} *
                                        {{ $unit->related_by_value }}
                                    @endif

                                </td>
                                <td>
                                    <!-- Example single danger button -->
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-light dropdown-toggle btn-sm"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="material-icons-two-tone">settings</i>
                                        </button>
                                        <ul class="dropdown-menu ">
                                            <li>
                                                <div class="d-flex">
                                                    <i class="material-icons-two-tone mt-2">delete</i>
                                                    <a class="dropdown-item delete"
                                                        href="{{ route('units.destroy', $unit->id) }}">

                                                        Delete</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                </td>
                            </tr>
                        @empty
                    <tfoot>
                        <tr class="text-center">
                            <td colspan="7">No record found </td>
                        </tr>
                    </tfoot>
                    @endforelse


                    </tbody>

                </table>
            </div>
        </div>
    </div>



    <div class="modal fade show" id="confirm-modal" tabindex="-1" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">You want to delete ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="delete-form" action="" method="POST">
                    @csrf
                    @method('delete')
                    <div class="modal-footer">
                        <div class="d-flex">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">No. Back
                                !</button>
                            <button type="submit" class="btn btn-primary" style="margin-left: 3px">Yes, Delete</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.delete').click(function(event) {
            event.preventDefault();
            var url = $(this).attr("href");

            $("#delete-form").attr('action', url);
            $("#confirm-modal").modal('show');
        });
    </script>
@endsection
