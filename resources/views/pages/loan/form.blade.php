{{-- Name --}}
<div class="form-group">
	<label for="date">
		Sanction Date
	</label>

	<input type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="date" value="{{ old('date', optional($loan)->date) }}">

	@if ($errors->has('date'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('date') }}</strong>
		</span>
	@endif
</div>

<div class="form-group">
	<label for="amount">
		Loan Limit
	</label>

	<input type="number" min="0" step="any" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" id="amount" value="{{ old('amount', optional($loan)->amount) }}">

	@if ($errors->has('amount'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('amount') }}</strong>
		</span>
	@endif
</div>

{{-- balance --}}
<div class="form-group">
	<label for="balance">
		Balance
	</label>

	<input type="number" min="0" step="any" class="form-control{{ $errors->has('balance') ? ' is-invalid' : '' }}" name="balance" id="balance" value="{{ old('balance', optional($loan)->balance) }}">

	@if ($errors->has('balance'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('balance') }}</strong>
		</span>
	@endif
</div>

{{-- interest_rate --}}
<div class="form-group">
	<label for="interest_rate">
		Interest Rate
	</label>

	<input type="number" min="0" step="any" class="form-control{{ $errors->has('interest_rate') ? ' is-invalid' : '' }}" name="interest_rate" id="interest_rate" value="{{ old('interest_rate', optional($loan)->interest_rate) }}">

	@if ($errors->has('interest_rate'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('interest_rate') }}</strong>
		</span>
	@endif
</div>

{{-- extra_interest_rate --}}
<div class="form-group">
	<label for="extra_interest_rate">
		Over Interest Rate
	</label>

	<input type="number" min="0" step="any" class="form-control{{ $errors->has('extra_interest_rate') ? ' is-invalid' : '' }}" name="extra_interest_rate" id="extra_interest_rate" value="{{ old('extra_interest_rate', optional($loan)->extra_interest_rate) }}">

	@if ($errors->has('extra_interest_rate'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('extra_interest_rate') }}</strong>
		</span>
	@endif
</div>

{{-- Remarks --}}
<div class="form-group">
	<label for="details">
		Remarks
	</label>

	<textarea name="details" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" id="details" cols="30" rows="5">{{ old('details', optional($loan)->details) }}</textarea>

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
</script>
@endsection