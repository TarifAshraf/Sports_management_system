@extends('layouts.player')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Agent Options</h1>
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
        <div class="col-lg-4">
            <div class="card p-3">
                <h3>Current Agent</h3>
                <hr>
                @if(!$current)
                <h5>Agent Not Available Yet</h5>
                @else
                <h3><b>Agent Name: </b></h3>
                <h5>{{ $current->aname }}</h5>
                @endif
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card p-3">
                <table id="agenttable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Agent Name</th>
                            <th>Experience</th>
                            <th>Market Value</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $item->aname }}</td>
                            <td>{{ $item->experience }}</td>
                            <td>{{ $item->marketvalue }}</td>
                            <td>
                                @if($current)
                                <button type="button" {{ ($item->aid == $current->aid) ? 'disabled' : '' }} class="btn btn-success" data-toggle="modal" data-target="#AddModal{{ $item->aid }}">Add As Agent</button>
                                @else
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#AddModal{{ $item->aid }}">Add As Agent</button>
                                @endif
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
<div class="modal fade" id="AddModal{{ $item->aid }}" tabindex="-1" aria-labelledby="AddModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="AddModalLabel">Add As Agent</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('playerBookAgent') }}" id="addForm{{ $item->aid }}">
                @csrf
                <h3>Please Add Payment Confirmation Info To Ensure Booking</h3>
                <input type="hidden" value="{{ $item->aid }}" name="aid">
                <input type="hidden" value="{{ $playerid }}" name="pid">
                <div class="form-group">
                    <label><b>Pay Amount</b></label>
                    <input type="number" class="form-control" value="{{ $item->marketvalue }}" readonly />
                </div>
                <div class="form-group">
                    <label><b>Transaction ID</b></label>
                    <input required type="text" name="txnid" class="form-control"  />
                </div>
                <div class="form-group">
                    <label><b>Payment Method</b></label>
                    <select name="paymethod" class="custom-select" required>
                        <option value="">--Select One Option--</option>
                        <option value="PayPal">PayPal</option>
                        <option value="Venmo">Venmo</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="addForm{{ $item->aid }}" class="btn btn-success">Add Agent</button>
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
