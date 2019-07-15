{{-- Date --}}
<div class="form-group">
	<label for="date">
		Date
	</label>

	<input type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="date" value="{{ old('date', optional($purchase)->date) }}">

	@if ($errors->has('date'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('date') }}</strong>
	</span>
	@endif
</div>

{{-- Supplier --}}
<div class="form-group">
	<label for="supplier_id">Supplier</label>
	<select name="supplier_id" class="form-control{{ $errors->has('supplier_id') ? ' is-invalid' : '' }}" id="supplier_id">
		<option value="">Select</option>
		@foreach($suppliers as $supplier)
		<option value="{{ $supplier->id }}" {{old('supplier_id', optional($purchase)->supplier_id) == $supplier->id ? 'selected':''}}>{{ $supplier->name }}</option>
		@endforeach
	</select>
	@if ($errors->has('supplier_id'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('supplier_id') }}</strong>
	</span>
	@endif
</div>

{{-- Item --}}
<div class="form-group">
	<label for="rawMaterial_id">Item</label>
	<select name="rawMaterial_id" class="form-control{{ $errors->has('rawMaterial_id') ? ' is-invalid' : '' }}" id="rawMaterial_id">
		<option value="">Select</option>
		@foreach($rawMaterials as $rawMaterial)
		<option value="{{ $rawMaterial->id }}" {{old('rawMaterial_id', optional($purchase)->rawMaterial_id) == $rawMaterial->id ? 'selected':''}}>{{ $rawMaterial->name }}</option>
		@endforeach
	</select>
	@if ($errors->has('rawMaterial_id'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('rawMaterial_id') }}</strong>
	</span>
	@endif
</div>

{{-- Rate --}}
<div class="form-group">
	<label for="rate">
		Rate
	</label>

	<input type="number" min="0" step="any" class="form-control{{ $errors->has('rate') ? ' is-invalid' : '' }}" name="rate" id="rate" value="{{ old('rate', optional($purchase)->rate) }}">

	@if ($errors->has('rate'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('rate') }}</strong>
	</span>
	@endif
</div>

{{-- Quantity --}}
<div class="form-group">
	<label for="quantity">
		Quantity
	</label>

	<input type="number" min="0" class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity" id="quantity" value="{{ old('quantity', optional($purchase)->quantity) }}">

	@if ($errors->has('quantity'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('quantity') }}</strong>
	</span>
	@endif
</div>

{{-- Amount --}}
<div class="form-group">
	<label for="amount">
		Amount
	</label>

	<input type="number" min="0" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" id="amount" value="{{ old('amount', optional($purchase)->amount) }}" readonly="readonly">

	@if ($errors->has('amount'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('amount') }}</strong>
	</span>
	@endif
</div>

{{-- Invoice --}}
<div class="form-group">
	<label for="invoice">Invoice</label>
	<input type="text" class="form-control{{ $errors->has('invoice') ? ' is-invalid' : '' }}" name="invoice" id="invoice" value="{{ old('invoice', optional($purchase)->invoice) }}">

	@if ($errors->has('invoice'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('invoice') }}</strong>
	</span>
	@endif
</div>

{{-- Details --}}
<div class="form-group">
	<label for="details">
		Remarks
	</label>

	<textarea name="details" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" id="details" cols="30" rows="5">{{ old('details', optional($purchase)->details) }}</textarea>

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

	//amount calculation
	$(document).ready(function(){
		var rate=$("#rate");
		var quantity=$("#quantity");
		rate.keyup(function(){
			var total=isNaN(parseFloat(rate.val()* quantity.val())) ? 0 :(rate.val()* quantity.val())
			$("#amount").val(total);
		});
		quantity.keyup(function(){
			var total=isNaN(parseInt(rate.val()* quantity.val())) ? 0 :(rate.val()* quantity.val())
			$("#amount").val(total);
		});
	});

	$('#supplier_id').select2({
		placeholder: 'Select Supplier',

		ajax: {
			url: '{!!URL::route('supplier-autocomplete-search')!!}',
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