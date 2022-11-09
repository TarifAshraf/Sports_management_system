@extends('layouts.users')

@section('content')

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Buyable Merchandise</h1>
        </div>
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
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            @foreach($data as $item)
            <div class="col-lg-3">
                <div class="card text-center" style="box-shadow: 20px 20px 50px grey;">
                    <div class="card-header">
                        <img src="/products/{{ $item->image }}" class="img-thumbnail" alt="">
                    </div>
                    <div class="card-body">
                        <h3>{{ $item->productname }}</h3>
                        <h5>${{ $item->price }}</h5>
                        <hr>
                        <button type="button" class="btn btn-info" data-target="#BuyModal{{ $item->proid }}" data-toggle="modal">Buy Now</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@foreach($data as $item)
<div class="modal fade" id="BuyModal{{ $item->proid }}" tabindex="-1" aria-labelledby="BuyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="BuyModalLabel">Buy Item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('userMakeOrder') }}" id="buyForm{{ $item->proid }}">
                @csrf
                <input type="hidden" value="{{ $item->proid }}" name="proid">
                <div class="row">
                    <div class="col-lg-4">
                        <img src="/products/{{ $item->image }}" class="img-thumbnail" alt="">
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label><b>Quantity</b></label>
                            <input type="number" value="1" name="qty" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label><b>Size</b></label>
                            <select name="size" class="form-control" required>
                                <option value="S" selected>S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><b>Payment Method</b></label>
                            <select name="paymethod" class="form-control" required>
                                <option value="COD" selected>Cash On Delivery</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><b>Delivery Address</b></label>
                            <textarea name="delivery" class="form-control" required>{{ $info->address }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="buyForm{{ $item->proid }}" class="btn btn-success">Purchase</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endforeach

@endsection
