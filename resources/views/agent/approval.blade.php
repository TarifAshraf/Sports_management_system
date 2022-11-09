@extends('layouts.agent')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Approval Requests</h1>
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
                            <th>Request For</th>
                            <th>Type</th>
                            <th>Request From</th>
                            <th>Offer Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->pname }}</td>
                                <td>{{ $item->bookfor }}</td>
                                <td>
                                    @if($item->bookfor == 'club')
                                        @php
                                            $name = DB::table('clubinfos')->where('cid', $item->bookerid)->pluck('cname')->first();
                                        @endphp
                                        {{ $name }}
                                    @endif
                                    @if($item->bookfor == 'sponsor')
                                        @php
                                            $name = DB::table('sponsors')->where('sid', $item->bookerid)->pluck('sname')->first();
                                        @endphp
                                        {{ $name }}
                                    @endif
                                </td>
                                <td>{{ $item->offerprice }}</td>
                                <td>
                                    @if($item->status == 'rejected')
                                        {{ $item->status }}
                                    @else
                                        @if($item->status == 'paid')
                                        <button type="button" class="btn btn-info" data-target="#DetailsModal{{ $item->bid }}" data-toggle="modal">Details</button>
                                        <button type="button" class="btn btn-success" data-target="#AcceptModal{{ $item->bid }}" data-toggle="modal">Accept</button>
                                        @elseif ($item->status == 'forwarded')
                                        <button type="button" class="btn btn-primary" disabled>Forward</button>
                                        @else
                                        <button type="button" class="btn btn-primary" data-target="#ConfirmModal{{ $item->bid }}" data-toggle="modal">Forward</button>
                                        @endif
                                        <button type="button" class="btn btn-danger" data-target="#RejectModal{{ $item->bid }}" data-toggle="modal">Reject</button>
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
<div class="modal fade" id="ConfirmModal{{ $item->bid }}" tabindex="-1" aria-labelledby="ConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ConfirmModalLabel">Forward Approval</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('agentForwardRequests') }}" id="confirmForm{{ $item->bid }}">
                @csrf
                <h3>Are You Sure?</h3>
                <input type="hidden" value="{{ $item->bid }}" name="bid">
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="confirmForm{{ $item->bid }}" class="btn btn-primary">Forward</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="AcceptModal{{ $item->bid }}" tabindex="-1" aria-labelledby="AcceptModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="AcceptModalLabel">Forward Approval</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('agentAcceptPayment') }}" id="acceptForm{{ $item->bid }}">
                @csrf
                <h3>Are You Sure?</h3>
                <input type="hidden" value="{{ $item->bid }}" name="bid">
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="acceptForm{{ $item->bid }}" class="btn btn-success">Accept</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="DetailsModal{{ $item->bid }}" tabindex="-1" aria-labelledby="DetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="DetailsModalLabel">Payment Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h3><b>Transaction ID</b></h3>
            <h5>{{ $item->txnid }}</h5>
            <hr>
            <h3><b>Amount</b></h3>
            <h5>{{ $item->offerprice }}</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="RejectModal{{ $item->bid }}" tabindex="-1" aria-labelledby="RejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="RejectModalLabel">Reject Approval</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('agentRejectRequests') }}" method="POST" id="rejectForm{{ $item->bid }}">
                @csrf
                <h3>Are You Sure?</h3>
                <input type="hidden" name="bid" value="{{ $item->bid }}">
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger" form="rejectForm{{ $item->bid }}">Reject</button>
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
