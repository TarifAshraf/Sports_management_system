@extends('layouts.club')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Current Players</h1>
        </div>
        @if (session('success'))
            <div class="col-lg-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        @if (session('failed'))
            <div class="col-lg-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('falied') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
      </div>
    </div><!-- /.container-fluid -->
</section>

  <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-3">
                <table id="agenttable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Player Name</th>
                            <th>Market Value</th>
                            <th>Age</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $item->pname }}</td>
                            <td>{{ $item->marketvalue }}</td>
                            <td>{{ $item->age }}</td>
                            <td>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#RemoveModal{{ $item->pid }}">Remove</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
@foreach($data as $item)
<div class="modal fade" id="RemoveModal{{ $item->pid }}" tabindex="-1" aria-labelledby="RemoveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="RemoveModalLabel">Delete Player</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('clubDeletePlayer') }}" id="removeForm{{ $item->pid }}">
                @csrf
                <h3>Are You Sure?</h3>
                <input type="hidden" value="{{ $item->pid }}" name="pid">
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="removeForm{{ $item->pid }}" class="btn btn-danger">Confirm</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endforeach

<script>
    $(function () {
      $("#agenttable").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#cattable_wrapper .col-md-6:eq(0)');
    });
</script>

@endsection
