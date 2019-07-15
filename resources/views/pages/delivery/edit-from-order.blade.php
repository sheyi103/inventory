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
					<h1 class="m-0 text-dark">Edit Product Delivery</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{ url('order') }}">Orders</a></li>
						<li class="breadcrumb-item active">Delivery</li>
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
					<form method="POST" action="{{ url('order/delivery/edit', $delivery->id) }}">
						@csrf
						{{-- Date --}}
						<div class="form-group">
							<label for="date">
								Date
							</label>

							<input type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="date" value="{{ old('date', optional($delivery)->date) }}">

							@if ($errors->has('date'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('date') }}</strong>
							</span>
							@endif
						</div>

						{{-- challan_no --}}
						<div class="form-group">
							<label for="challan_no">
								Challan No
							</label>

							<input type="text" class="form-control{{ $errors->has('challan_no') ? ' is-invalid' : '' }}" name="challan_no" id="challan_no" value="{{ old('challan_no', optional($delivery)->challan_no) }}">

							@if ($errors->has('challan_no'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('challan_no') }}</strong>
							</span>
							@endif
						</div>


						{{-- Product --}}
						<div class="form-group">
							<label for="product_id">Select Product</label>
							<select name="product_id" class="form-control" id="product_id" required="required">
								<option value="">Select Product</option>
								@forelse($products as $product)
								<option value="{{ $product->id }}" {{ old('product_id', optional($delivery)->product_id) == $product->id ? 'selected':''}}>
									{{ $product->name }}
								</option>
								@empty
								<option value="">No Product Found</option>
								@endforelse
							</select>

							@if( $errors->has('product_id'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('product_id') }}</strong>
							</span>
							@endif
						</div>

						{{-- Quantity --}}
						<div class="form-group">
							<label for="quantity">
								Quantity
							</label>

							<input type="number" min="0" class="form-control" name="quantity" id="quantity" required="required" value="{{ old('quantity', optional($delivery)->quantity) }}">

							@if( $errors->has('quantity'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('quantity') }}</strong>
							</span>
							@endif
						</div>

						{{-- Details --}}
						<div class="form-group">
							<label for="details">
								Remarks
							</label>

							<textarea name="details" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" id="details" cols="30" rows="5">{{ old('details', optional($delivery)->details) }}</textarea>

							@if( $errors->has('details'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('details') }}</strong>
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
@section('script')
<script>
	{{-- jquery datepicker --}}
	$( function() {
		$( "#date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	});
</script>
@endsection