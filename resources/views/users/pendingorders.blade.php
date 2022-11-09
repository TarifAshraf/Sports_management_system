@extends('layouts.users')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Pending Order List</h1>
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
                            <th>Product Name</th>
                            <th>Order Date</th>
                            <th>Qty</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $item->productname }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->qty * $item->unitprice}}</td>
                            <td>{{ $item->status}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
{{-- @foreach($data as $item)
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
            <form method="POST" action="{{ route('sponsorConfirmPayment') }}" id="confirmForm{{ $item->bid }}">
                @csrf
                <input type="hidden" value="{{ $item->bid }}" name="bid">
                <div class="form-group">
                    <label><b>Offer Price</b></label>
                    <input type="number" name="offerprice" class="form-control" required />
                </div>
                <div class="form-group">
                    <label><b>Transaction ID</b></label>
                    <input type="text" name="txnid" class="form-control" required />
                </div>
                <div class="form-group">
                    <label><b>Payment Method</b></label>
                    <select name="paymethod" class="form-control" required>
                        <option value="" selected>--Select One Option--</option>
                        <option value="Paypal">Paypal</option>
                        <option value="Venmo">Venmo</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="confirmForm{{ $item->bid }}" class="btn btn-success">Confirm</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endforeach--}}

<script>
    $(function () {
      $("#agenttable").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#cattable_wrapper .col-md-6:eq(0)');
    });
</script>

@endsection
