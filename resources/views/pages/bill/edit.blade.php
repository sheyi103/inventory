@extends('layouts.master')
@section('title', 'Bill')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Edit Bill</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{ url('bill') }}">Bills</a></li>
						<li class="breadcrumb-item active">Edit</li>
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
					<form method="POST" action="{{ route('bill.update', $bill->id) }}">
						@csrf
						@method('PUT')
						{{-- Date --}}
						<div class="form-group">
							<label for="date">
								Date
							</label>

							<input type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="date" value="{{ old('date', optional($bill)->date) }}">

							@if ($errors->has('date'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('date') }}</strong>
							</span>
							@endif
						</div>

						{{-- Product --}}
						<div class="form-group">
							<label for="product_id">Select Product</label>
							<select name="product_id" class="form-control {{ $errors->has('product_id') ? ' is-invalid' : '' }}" id="product_id" required="required">
								<option value="">Select Product</option>
								@forelse($products as $product)
								<option value="{{ $product->id }}" {{old('product_id', optional($bill)->product_id) == $product->id ? 'selected':''}}>
									{{ $product->name }}
								</option>
								@empty
								<option value="">No Product Found</option>
								@endforelse
							</select>
							@if ($errors->has('product_id'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('product_id') }}</strong>
							</span>
							@endif
						</div>

						{{-- Rate --}}
						<div class="form-group">
							<label for="rate">
								Rate
							</label>
							<input type="number" min="0" step="any" class="form-control {{ $errors->has('rate') ? ' is-invalid' : '' }}" name="rate" id="rate" required="required" value="{{ $bill->rate }}">

							@if ($errors->has('rate'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('rate') }}</strong>
							</span>
							@endif
						</div>

						{{-- Quantity --}}
						<div class="form-group">
							<label for="vat">
								Vat
							</label>

							<input type="number" min="0" step="any" class="form-control {{ $errors->has('vat') ? ' is-invalid' : '' }}" name="vat" id="vat" required="required" value="{{ $bill->vat }}">
							@if ($errors->has('vat'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('vat') }}</strong>
							</span>
							@endif
						</div>
						{{-- Quantity --}}
						<div class="form-group">
							<label for="quantity">
								Quantity
							</label>

							<input type="number" min="0" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity" id="quantity" required="required" value="{{ $bill->quantity }}">

							@if ($errors->has('quantity'))
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

							<textarea name="details" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" id="details" cols="30" rows="5">{{ old('details', optional($bill)->details) }}</textarea>

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

	$('#product_id').select2({
		placeholder: 'Select Product',

		ajax: {
			url: '{!!URL::route('product-autocomplete-search')!!}',
			dataType: 'json',
			delay: 250,
			processResults: function (data) {
				return {
					results: data
				};
			},
			cache: true
		},
		theme: "bootstrap"
	});
</script>
@endsection