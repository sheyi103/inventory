@extends('layouts.master')
@section('title', 'Order')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Update Order</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{ url('order') }}">Orders</a></li>
						<li class="breadcrumb-item active">Update</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="card card-warning">
				<div class="card-body">
					<form method="POST" action="{{ route('order.update', $order->id) }}" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						{{-- Name --}}
						<div class="form-group">
							<label for="quantity">
								Quantity
							</label>

							<input type="text" class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity" id="quantity" value="{{ old('quantity', optional($order)->quantity) }}" placeholder="Quantity">

							@if ($errors->has('quantity'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('quantity') }}</strong>
							</span>
							@endif
						</div>

						{{-- Rate --}}
						<div class="form-group">
							<label for="rate">
								Rate
							</label>

							<input type="text" class="form-control{{ $errors->has('rate') ? ' is-invalid' : '' }}" name="rate" id="rate" value="{{ old('rate', optional($order)->rate) }}" placeholder="Rate">

							@if ($errors->has('rate'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('rate') }}</strong>
							</span>
							@endif
						</div>

						{{-- Vat --}}
						<div class="form-group">
							<label for="vat">
								Vat
							</label>

							<input type="text" class="form-control{{ $errors->has('vat') ? ' is-invalid' : '' }}" name="vat" id="vat" value="{{ old('vat', optional($order)->vat) }}" placeholder="Vat">

							@if ($errors->has('vat'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('vat') }}</strong>
							</span>
							@endif
						</div>

						{{-- Save --}}
						<div class="form-group row mb-0">
							<div class="col-md-12">
								<button type="submit" class="btn btn-primary">
									{{ __('Save') }}
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection