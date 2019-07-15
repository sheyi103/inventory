{{-- Name --}}
<div class="form-group">
	<label for="date">
		Date
	</label>

	<input type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="date" value="{{ old('date', optional($glove)->date) }}">

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
		<option value="{{ $customer->id }}" {{old('customer_id', optional($glove)->customer_id) == $customer->id ? 'selected':''}}>{{ $customer->name }}</option>
		@endforeach
	</select>
	@if ($errors->has('customer_id'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('customer_id') }}</strong>
	</span>
	@endif
</div>

{{-- invoice --}}
<div class="form-group">
	<label for="invoice">
		Invoice
	</label>

	<input type="text" class="form-control{{ $errors->has('invoice') ? ' is-invalid' : '' }}" name="invoice" id="invoice" value="{{ old('invoice', optional($glove)->invoice) }}">

	@if ($errors->has('invoice'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('invoice') }}</strong>
	</span>
	@endif
</div>

{{-- quantity --}}
<div class="form-group">
	<label for="quantity">
		Quantity
	</label>

	<input type="number" min="0" class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity" id="quantity" value="{{ old('quantity', optional($glove)->quantity) }}">

	@if ($errors->has('quantity'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('quantity') }}</strong>
	</span>
	@endif
</div>

{{-- rate --}}
<div class="form-group">
	<label for="rate">
		Rate
	</label>

	<input type="number" step="any" min="0" class="form-control{{ $errors->has('rate') ? ' is-invalid' : '' }}" name="rate" id="rate" value="{{ old('rate', optional($glove)->rate) }}">

	@if ($errors->has('rate'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('rate') }}</strong>
	</span>
	@endif
</div>

{{-- Amount --}}
<div class="form-group">
	<label for="amount">
		Amount
	</label>

	<input type="text" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" id="amount" value="{{ old('amount', optional($glove)->amount) }}" readonly="readonly">

	@if ($errors->has('amount'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('amount') }}</strong>
	</span>
	@endif
</div>

{{-- paid --}}
<div class="form-group">
	<label for="paid">
		Paid
	</label>

	<input type="text" class="form-control{{ $errors->has('paid') ? ' is-invalid' : '' }}" name="paid" id="paid" value="{{ old('paid', optional($glove)->paid) }}">

	@if ($errors->has('paid'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('paid') }}</strong>
	</span>
	@endif
</div>

{{-- Remarks --}}
<div class="form-group">
	<label for="details">
		Remarks
	</label>

	<textarea name="details" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" id="details" cols="30" rows="5">{{ old('details', optional($glove)->details) }}</textarea>

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
</script>
@endsection