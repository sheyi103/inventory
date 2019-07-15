@extends('layouts.master')
@section('title', 'Production')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Add Production</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{ url('production') }}">Productions</a></li>
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
					<form method="POST" action="{{ route('production.store') }}">
						@csrf
						{{-- Date --}}
						<div class="form-group">
							<label for="date">
								Date
							</label>

							<input type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="date" value="{{ old('date', optional($production)->date) }}">

							@if ($errors->has('date'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('date') }}</strong>
							</span>
							@endif
						</div>

						{{-- product --}}
						<div class="form-group">
							<label for="product_id">Product</label>
							<select name="product_id" class="form-control{{ $errors->has('product_id') ? ' is-invalid' : '' }}" id="product_id">
								<option value="">Select</option>
								@foreach($products as $product)
								<option value="{{ $product->id }}" {{old('product_id', optional($production)->product_id) == $product->id ? 'selected':''}}>{{ $product->name }}</option>
								@endforeach
							</select>
							@if ($errors->has('product_id'))
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

							<input type="number" min="0" class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity" id="quantity" value="{{ old('quantity', optional($production)->quantity) }}">

							@if ($errors->has('quantity'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('quantity') }}</strong>
							</span>
							@endif
						</div>
						<h5>Raw Materials Used</h5>
						<div class="row">
							<div class="col-md-1">
								<button id="add_more" class="btn btn-info mt-4"><i class="fa fa-plus" title="Add More"></i></button>
							</div>
							<div class="col-md-11">
								<div id="more_materials">
									<div class="row">
										<div class="col-md-6">
											{{-- Raw Materials --}}
											<div class="form-group">
												<label for="raw_materials">Raw Material</label>
												<select name="raw_materials[]" class="form-control" id="raw_materials" required="required">
													<option value="">Select</option>
													@forelse($rawMaterials as $rawMaterial)
													<option value="{{ $rawMaterial->id }}" >
														{{ $rawMaterial->name }}
													</option>
													@empty
													<option value="">No Raw Material Found</option>
													@endforelse
												</select>
											</div>
										</div>

										<div class="col-md-5">
											{{-- Quantity --}}
											<div class="form-group">
												<label for="raw_materials_quantity">
													Quantity
												</label>

												<input type="number" min="0" step="any" class="form-control" name="raw_materials_quantity[]" id="raw_materials_quantity" required="required">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						{{-- Details --}}
						<div class="form-group">
							<label for="details">
								Remarks
							</label>

							<textarea name="details" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" id="details" cols="30" rows="5">{{ old('details', optional($production)->details) }}</textarea>

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

	$(document).ready(function() {
		var max_fields      = 150;
		var wrapper         = $("#more_materials");
		var add_button      = $("#add_more");

		var x = 1;
		$(add_button).click(function(e){
			e.preventDefault();
			if(x < max_fields){
				x++;
				$(wrapper).append('<div class="row"><div class="col-md-5">{{-- Product --}}<div class="form-group"><label for="raw_materials">Raw Material</label><select name="raw_materials[]" class="form-control raw_materials" id="raw_materials" required="required"><option value="">Select</option>@forelse($rawMaterials as $rawMaterial)<option value="{{ $rawMaterial->id }}" >{{ $rawMaterial->name }}</option>@empty<option value="">No Raw Material Found</option>@endforelse </select></div></div><div class="col-md-5">{{-- Quantity --}}<div class="form-group"><label for="raw_materials_quantity">Quantity</label><input type="number" min="0" step="any" class="form-control" name="raw_materials_quantity[]" id="raw_materials_quantity" required="required"></div></div><div class="col-sm-1"><a href="#" class="remove_field"><button style="margin-top: 30px;" class="btn btn-info"><i class="fa fa-minus" title="Remove Item"></i></button></a></div></div>');
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

