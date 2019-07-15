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
					<h1 class="m-0 text-dark">Add Order</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{ url('order') }}">Orders</a></li>
						<li class="breadcrumb-item active">Create</li>
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
					<form method="POST" action="{{ route('order.store') }}">
						@csrf
						{{-- Date --}}
						<div class="form-group">
							<label for="date">
								Date
							</label>

							<input type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="date" value="{{ old('date', optional($order)->date) }}">

							@if ($errors->has('date'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('date') }}</strong>
							</span>
							@endif
						</div>

						{{-- customer --}}
						<div class="form-group">
							<label for="customer_id">Customer</label>
							<select name="customer_id" class="form-control{{ $errors->has('customer_id') ? ' is-invalid' : '' }}" id="customer_id">
								<option value="">Select</option>
								@foreach($customers as $customer)
								<option value="{{ $customer->id }}" {{old('customer_id', optional($order)->customer_id) == $customer->id ? 'selected':''}}>{{ $customer->name }}</option>
								@endforeach
							</select>
							@if ($errors->has('customer_id'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('customer_id') }}</strong>
							</span>
							@endif
						</div>

						<div class="row">
							<div class="col-md-1">
								<button id="add_more" class="btn btn-info mt-4"><i class="fa fa-plus" title="Add More Product"></i></button>
							</div>
							<div class="col-md-11">
								<div id="more_product">
									<div class="row">
										<div class="col-md-3">
											{{-- Product --}}
											<div class="form-group">
												<label for="product_id">Select Product</label>
												<select name="product_id[]" class="form-control" id="product_id" required="required">
													<option value="">Select Product</option>
													@forelse($products as $product)
													<option value="{{ $product->id }}" >
														{{ $product->name }}
													</option>
													@empty
													<option value="">No Product Found</option>
													@endforelse
												</select>
											</div>
										</div>
										<div class="col-md-3">
											{{-- Rate --}}
											<div class="form-group">
												<label for="rate">
													Rate
												</label>
												<input type="number" min="0" step="any" class="form-control" name="rate[]" id="rate" required="required">
											</div>
										</div>

										<div class="col-md-3">
											{{-- Quantity --}}
											<div class="form-group">
												<label for="vat">
													Vat
												</label>

												<input type="number" min="0" step="any" class="form-control" name="vat[]" id="vat" required="required">
											</div>
										</div>
										<div class="col-md-3">
											{{-- Quantity --}}
											<div class="form-group">
												<label for="quantity">
													Quantity
												</label>

												<input type="number" min="0" class="form-control" name="quantity[]" id="quantity" required="required">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						{{-- workOrder_id --}}
						<div class="form-group">
							<label for="workOrder_id">Work Order No</label>
							<input type="text" class="form-control{{ $errors->has('workOrder_id') ? ' is-invalid' : '' }}" name="workOrder_id" id="workOrder_id" value="{{ old('workOrder_id', optional($order)->workOrder_id) }}">

							@if ($errors->has('workOrder_id'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('workOrder_id') }}</strong>
							</span>
							@endif
						</div>

						{{-- Payment Type --}}

				{{-- <div class="form-group">
					<label for="payment">Payment</label>
					<select name="payment" class="form-control{{ $errors->has('payment') ? ' is-invalid' : '' }}" id="payment">
						<option value="">Select Payment</option>
						<option value="1">Cash</option>
						<option value="2">Due</option>
					</select>
					@if ($errors->has('payment'))
					<span class="invalid-feedback">
						<strong>{{ $errors->first('payment') }}</strong>
					</span>
					@endif
				</div> --}}


				{{-- Details --}}
				<div class="form-group">
					<label for="details">
						Remarks
					</label>

					<textarea name="details" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" id="details" cols="30" rows="5">{{ old('details', optional($order)->details) }}</textarea>

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

	
	$('#customer_id').select2({
		placeholder: 'Select Customer',

		ajax: {
			url: '{!!URL::route('customer-autocomplete-search')!!}',
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

	$(document).ready(function() {
		var max_fields      = 150;
		var wrapper         = $("#more_product");
		var add_button      = $("#add_more");

		var x = 1;
		$(add_button).click(function(e){
			e.preventDefault();
			if(x < max_fields){
				x++;
				$(wrapper).append('<div class="row"><div class="col-md-3">{{-- Product --}}<div class="form-group"><label for="product_id">Select Product</label><select name="product_id[]" class="form-control product_id" id="product_id" required="required"><option value="">Select Product</option>@forelse($products as $product)<option value="{{ $product->id }}" >{{ $product->name }}</option>@empty<option value="">No Product Found</option>@endforelse </select></div></div><div class="col-md-3">{{-- Rate --}}<div class="form-group"><label for="rate">Rate</label><input type="number" min="0" step="any" class="form-control" name="rate[]" id="rate" required="required"></div></div><div class="col-md-2">{{-- vat --}}<div class="form-group"><label for="vat">Vat</label><input type="number" min="0" step="any" class="form-control" name="vat[]" id="vat" required="required"></div></div><div class="col-md-3">{{-- Quantity --}}<div class="form-group"><label for="quantity">Quantity</label><input type="number" min="0" class="form-control" name="quantity[]" id="quantity" required="required"></div></div><div class="col-sm-1"><a href="#" class="remove_field"><button style="margin-top: 30px;" class="btn btn-info"><i class="fa fa-minus" title="Remove Item"></i></button></a></div></div>');

				$('.product_id').select2({
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
			}
		});

		$(wrapper).on("click",".remove_field", function(e){
			e.preventDefault(); 
			$(this).parent().parent('div').remove(); 
			x--;
		})
	});
</script>
@endsection