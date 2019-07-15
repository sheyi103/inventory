{{-- Date --}}
<div class="form-group">
	<label for="date">
		Date
	</label>

	<input type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="date" value="{{ old('date', optional($ccLoanWithdraw)->date) }}">

	@if ($errors->has('date'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('date') }}</strong>
	</span>
	@endif
</div>

{{-- Loan --}}
<div class="form-group">
	<label for="loan_id">Select Loan</label>
	<select name="loan_id" class="form-control{{ $errors->has('loan_id') ? ' is-invalid' : '' }}" id="loan_id">
		<option value="">Select Loan</option>
		@forelse($ccLoans as $loan)
		<option value="{{ $loan->id }}" 
			@if( old('loan_id', optional($ccLoanWithdraw)->loan_id) == $loan->id )
			selected
			@endif
			>
			{{ $loan->loan_from.', '.$loan->limit }}
		</option>
		@empty
		<option value="">No Loan Found</option>
		@endforelse
	</select>
	@if ($errors->has('loan_id'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('loan_id') }}</strong>
	</span>
	@endif
</div>

{{-- Amount --}}
<div class="form-group">
	<label for="amount">
		Amount
	</label>

	<input type="number" min="0" step="any" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" id="amount" value="{{ old('amount', optional($ccLoanWithdraw)->amount) }}">

	@if ($errors->has('amount'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('amount') }}</strong>
	</span>
	@endif
</div>

{{-- Remarks --}}
<div class="form-group">
	<label for="details">Remarks</label>
	<textarea name="details" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" id="details" cols="30" rows="5">{{ old('details', optional($ccLoanWithdraw)->details) }}</textarea>

	@if ($errors->has('details'))
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