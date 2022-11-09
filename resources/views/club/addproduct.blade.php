@extends('layouts.club')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Add New Products</h1>
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
        <div class="col-lg-6 ml-auto mr-auto">
            <div class="card p-3">
                <form method="POST" action="{{ route('clubSaveProduct') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label><b>Product Name</b></label>
                        <input type="text" name="productname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><b>Product Price</b></label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><b>Product Image</b></label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- <script>
    $(function () {
      $("#agenttable").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#cattable_wrapper .col-md-6:eq(0)');
    });
</script> --}}

@endsection
