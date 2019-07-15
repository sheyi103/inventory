{{-- Date --}}
<div class="form-group">
	<label for="withdraw_date">
		Withdraw Date
	</label>

	<input type="text" class="form-control{{ $errors->has('withdraw_date') ? ' is-invalid' : '' }}" name="withdraw_date" id="withdraw_date" value="{{ old('withdraw_date', optional($ccLoanDeposit)->withdraw_date) }}">

	@if ($errors->has('withdraw_date'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('withdraw_date') }}</strong>
	</span>
	@endif
</div>

<div class="form-group">
	<label for="deposit_date">
		Deposit Date
	</label>

	<input type="text" class="form-control{{ $errors->has('deposit_date') ? ' is-invalid' : '' }}" name="deposit_date" id="deposit_date" value="{{ old('deposit_date', optional($ccLoanDeposit)->deposit_date) }}">

	@if ($errors->has('deposit_date'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('deposit_date') }}</strong>
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
			@if( old('loan_id', optional($ccLoanDeposit)->loan_id) == $loan->id )
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

	<input type="number" min="0" step="any" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" id="amount" value="{{ old('amount', optional($ccLoanDeposit)->amount) }}">

	@if ($errors->has('amount'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('amount') }}</strong>
	</span>
	@endif
</div>

{{-- Amount --}}
<div class="form-group">
	<label for="interest_rate">
		Profit Rate
	</label>

	<input type="number" min="0" step="any" class="form-control{{ $errors->has('interest_rate') ? ' is-invalid' : '' }}" name="interest_rate" id="interest_rate" value="{{ old('interest_rate', optional($ccLoanDeposit)->interest_rate) }}">

	@if ($errors->has('interest_rate'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('interest_rate') }}</strong>
	</span>
	@endif
</div>

{{-- Amount --}}
<div class="form-group">
	<label for="interest">
		Profit
	</label>

	<input type="number" min="0" step="any" class="form-control{{ $errors->has('interest') ? ' is-invalid' : '' }}" name="interest" id="interest" value="{{ old('interest', optional($ccLoanDeposit)->interest) }}">

	@if ($errors->has('interest'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('interest') }}</strong>
	</span>
	@endif
</div>

{{-- Remarks --}}
<div class="form-group">
	<label for="details">Remarks</label>
	<textarea name="details" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" id="details" cols="30" rows="5">{{ old('details', optional($ccLoanDeposit)->details) }}</textarea>

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
		$( "#withdraw_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			onSelect: showDays
		});

		$( "#deposit_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			onSelect: showDays
		});

		var withdraw_date=$("#withdraw_date");
		var deposit_date=$("#deposit_date");
		var interest_rate=$("#interest_rate");
		var amount=$("#amount");

		function parseDate(str) {
		    var mdy = str.split('-');
		    return new Date(mdy);
		}

		function datediff(first, second) {
		    // Take the difference between the dates and divide by milliseconds per day.
		    // Round to nearest whole number to deal with DST.
		    return Math.round((second-first)/(1000*60*60*24));
		}

		function showDays() {
		    var days = (datediff(parseDate(withdraw_date.val()), parseDate(deposit_date.val())));
			//console.log(days);
			var interest = isNaN(parseFloat(((((interest_rate.val() * amount.val())/10)/365) *days))) ? 0 :((((interest_rate.val() * amount.val())/10)/365) *days);
			$("#interest").val(interest);
		}

		interest_rate.keyup(showDays);
		amount.keyup(showDays);
	});
</script>
@endsection