@extends('layouts.agent')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Payment Requests</h1>
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
                            <th>Payer Type</th>
                            <th>Requester Name</th>
                            <th>Pay Type</th>
                            <th>Txn ID</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>
                                @php
                                    $role = DB::table('users')->where('id', $item->uid)->pluck('role')->first();
                                @endphp
                                {{ $role }}
                            </td>
                            <td>{{ $item->pname }}</td>
                            <td>{{ $item->paymethod }}</td>
                            <td>{{ $item->txnid }}</td>
                            <td>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ConfirmModal{{ $item->bid }}">Confirm</button>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#RejectModal{{ $item->bid }}">Reject</button>
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
<div class="modal fade" id="ConfirmModal{{ $item->bid }}" tabindex="-1" aria-labelledby="ConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ConfirmModalLabel">Confirm Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('agentAcceptPayRequests') }}" id="confirmForm{{ $item->bid }}">
                @csrf
                <h3>Are You Sure?</h3>
                <input type="hidden" value="{{ $item->bid }}" name="bid">
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="confirmForm{{ $item->bid }}" class="btn btn-success">Confirm</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="RejectModal{{ $item->bid }}" tabindex="-1" aria-labelledby="RejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="RejectModalLabel">Confirm Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('agentRejectPayRequests') }}" id="rejectForm{{ $item->bid }}">
                @csrf
                <h3>Are You Sure?</h3>
                <input type="hidden" value="{{ $item->bid }}" name="bid">
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="rejectForm{{ $item->bid }}" class="btn btn-danger">Reject</button>
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
