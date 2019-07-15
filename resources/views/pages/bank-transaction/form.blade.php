{{-- Name --}}
<div class="form-group">
	<label for="date">
		Date
	</label>

	<input type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="date" value="{{ old('date', optional($bankTransaction)->date) }}">

	@if ($errors->has('date'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('date') }}</strong>
		</span>
	@endif
</div>

{{-- Account --}}
<div class="form-group">
	<label for="bankAccount_id">Account Number</label>
	<select name="bankAccount_id" class="form-control{{ $errors->has('bankAccount_id') ? ' is-invalid' : '' }}" id="bankAccount_id">
		<option value="">Select</option>
		@forelse($bankAccounts as $bankAccount)
			<option value="{{ $bankAccount->id }}" 
				@if( old('bankAccount_id', optional($bankTransaction)->bankAccount_id) == $bankAccount->id )
					selected
				@endif
				>
				{{ $bankAccount->bank->name.', '.$bankAccount->account_no }}
			</option>
		@empty
			<option value="">No Account Found</option>
		@endforelse
	</select>
	@if ($errors->has('bankAccount_id'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('bankAccount_id') }}</strong>
		</span>
	@endif
</div>

{{-- Amount --}}
<div class="form-group">
	<label for="amount">
		Amount
	</label>

	<input type="number" min="0" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" id="amount" value="{{ old('amount', optional($bankTransaction)->amount) }}">

	@if ($errors->has('amount'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('amount') }}</strong>
		</span>
	@endif
</div>

{{-- Purpose --}}
<div class="form-group">
	<label for="purpose">Purpose</label>
	<select name="purpose" class="form-control{{ $errors->has('purpose') ? ' is-invalid' : '' }}" id="purpose">
		<option value="">Select</option>
		<option value="1" @if( old('purpose', optional($bankTransaction)->purpose) == '1' )
					selected
				@endif >Deposit</option>
		<option value="2" @if( old('purpose', optional($bankTransaction)->purpose) == '2' )
					selected
				@endif>Withdraw</option>
	</select>
	@if ($errors->has('purpose'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('purpose') }}</strong>
		</span>
	@endif
</div>

{{-- Amount --}}
<div class="form-group">
	<label for="cheque_number">
		Cheque Number
	</label>

	<input type="number" min="0" class="form-control{{ $errors->has('cheque_number') ? ' is-invalid' : '' }}" name="cheque_number" id="cheque_number" value="{{ old('cheque_number', optional($bankTransaction)->cheque_number) }}">

	@if ($errors->has('cheque_number'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('cheque_number') }}</strong>
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