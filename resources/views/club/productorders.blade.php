@extends('layouts.club')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Order List</h1>
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
                            <th>Qty</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $item->productname }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#DetailsModal{{ $item->oid }}">Details</button>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ConfirmModal{{ $item->oid }}">Mark As Delivered</button>
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
<div class="modal fade" id="DetailsModal{{ $item->oid }}" tabindex="-1" aria-labelledby="DetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DetailsModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4">
                        <img src="/products/{{ $item->image }}" class="img-thumbnail" alt="">
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <h4><b>Customer Name</b></h4>
                            <h5>{{ $item->uname }}</h5>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <h4><b>Item Name</b></h4>
                            <h5>{{ $item->productname }}</h5>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <h4><b>Quantity</b></h4>
                            <h5>{{ $item->qty }}</h5>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <h4><b>Total</b></h4>
                            <h5>{{ $item->qty * $item->unitprice }}</h5>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <h4><b>Contact</b></h4>
                            <h5>{{ $item->contactno }}</h5>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <h4><b>Address</b></h4>
                            <h5>{{ $item->delivery }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ConfirmModal{{ $item->oid }}" tabindex="-1" aria-labelledby="ConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ConfirmModalLabel">Confirm Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('clubConfirmDelivery') }}" id="confirmForm{{ $item->oid }}">
                @csrf
                <h3>Are You Sure?</h3>
                <input type="hidden" value="{{ $item->oid }}" name="oid">
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="confirmForm{{ $item->oid }}" class="btn btn-success">Confirm</button>
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
