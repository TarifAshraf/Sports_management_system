@extends('layouts.player')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Requests For Approval</h1>
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
                <table id="requesttable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Category</th>
                            <th>From</th>
                            <th>Offer Amount</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $item->created_at }}</td>
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
                            <td>${{ $item->offerprice }}</td>
                            <td>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#AcceptModal{{ $item->bid }}">Accept</button>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#RejectModal{{ $item->bid }}">Reject</button>
                            </td>
                        </tr>
                        @endforeach
                        {{-- @foreach($data2 as $item2)
                        <tr>
                            <td>{{ $item2->created_at }}</td>
                            <td>{{ $item2->bookfor }}</td>
                            <td>
                                @if($item2->bookfor == 'agent')
                                @php
                                  $name = DB::table('agentinfos')->where('aid', $item2->bookerid)->pluck('aname')->first();
                                @endphp
                                {{ $name }}
                              @endif
                            </td>
                            <td>${{ $item2->offerprice }}</td>
                            <td>{{ $item2->status }}</td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
@foreach($data as $item)
<div class="modal fade" id="AcceptModal{{ $item->bid }}" tabindex="-1" aria-labelledby="AcceptModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="AcceptModalLabel">Accept Request</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('playerAcceptRequest') }}" id="acceptForm{{ $item->bid }}">
                @csrf
                <input type="hidden" value="{{ $item->bid }}" name="bid">
                <h3>Are You Sure?</h3>
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="acceptForm{{ $item->bid }}" class="btn btn-success">Accept</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="RejectModal{{ $item->bid }}" tabindex="-1" aria-labelledby="DeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="DeleteModalLabel">Delete Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('playeRejectRequest') }}" id="deleteForm{{ $item->bid }}">
                @csrf
                <input type="hidden" value="{{ $item->bid }}" name="bid">
                <h3>Are You Sure?</h3>
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="deleteForm{{ $item->bid }}" class="btn btn-danger">Delete</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endforeach

<script>
    $(function () {
      $("#requesttable").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#cattable_wrapper .col-md-6:eq(0)');
    });
</script>

@endsection
