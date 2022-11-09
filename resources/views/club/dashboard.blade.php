@extends('layouts.club')

@section('content')

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Welcome <span style="color: green">{{ Auth()->user()->name }}</span></h1>
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
@if(Auth()->user()->status == 'active')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>150</h3>
                        <p>New Approval Requests</p>
                    </div>
                    <div class="icon">
                        <i class="nav-icon fas fa-thumbs-up"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@else
<section class="content">
    <div class="container">
        <div class="jumbotron" style="box-shadow: 20px 20px 50px grey; background: white">
            <form method="POST" action="{{ route('clubSaveInfo') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-12 pt-2">
                        <h3 style="color: red">Please Provide Following Information To Proceed</h3>
                        <hr>
                    </div>
                    <div class="col-lg-4 pt-3">
                        <label for="">Club Name</label>
                        <input type="text" name="cname" class="form-control" required value="{{ Auth()->user()->name }}">
                    </div>
                    <div class="col-lg-4 pt-3">
                        <label for="">Location</label>
                        <input type="text" name="location" class="form-control" required >
                    </div>
                    <div class="col-lg-4 pt-3">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control" required value="{{ Auth()->user()->email }}" readonly>
                    </div>
                    <div class="col-lg-4 pt-3">
                        <label for="">League</label>
                        <input type="text" name="league" class="form-control" required >
                    </div>
                    <div class="col-lg-4 pt-3">
                        <label for="">Grade</label>
                        <input type="text" name="grade" class="form-control" required >
                    </div>
                    <div class="col-lg-12 pt-3 text-center">
                        <button type="submit" class="btn btn-primary">Submit Info</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endif

@endsection
