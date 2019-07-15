{{-- Name --}}
<div class="form-group">
	<label for="account_no">
		Aaccount Number
	</label>

	<input type="text" class="form-control{{ $errors->has('account_no') ? ' is-invalid' : '' }}" name="account_no" id="account_no" value="{{ old('account_no', optional($bankAccount)->account_no) }}">

	@if ($errors->has('account_no'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('account_no') }}</strong>
		</span>
	@endif
</div>

{{-- Name --}}
<div class="form-group">
	<label for="account_holder_name">
		Aaccount Holder
	</label>

	<input type="text" class="form-control{{ $errors->has('account_holder_name') ? ' is-invalid' : '' }}" name="account_holder_name" id="account_holder_name" value="{{ old('account_holder_name', optional($bankAccount)->account_holder_name) }}">

	@if ($errors->has('account_holder_name'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('account_holder_name') }}</strong>
		</span>
	@endif
</div>

<div class="form-group">
	<label for="bank_id">Select Bank</label>
	<select name="bank_id" class="form-control{{ $errors->has('bank_id') ? ' is-invalid' : '' }}" id="bank_id">
		<option value="">Select Bank</option>
		@forelse($banks as $bank) 
		<option value="{{ $bank->id }}" @if( old('bank_id', optional($bankAccount)->bank_id) == $bank->id ) selected @endif> {{ $bank->name }} 
		</option> 
		@empty 
		<option value="">No Bank Found</option> 
		@endforelse
	</select> 
	@if ($errors->has('bank_id'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('bank_id') }}</strong> 
	</span> 
	@endif 
</div>

{{-- Amount --}}
<div class="form-group">
	<label for="amount">
		Current Amount
	</label>

	<input type="number" min="0" step="any" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" id="amount" value="{{ old('amount', optional($bankAccount)->amount) }}">

	@if ($errors->has('amount'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('amount') }}</strong>
	</span>
	@endif
</div> 

{{-- Remarks --}}
<div class="form-group">
	<label for="details">
		Remarks
	</label>

	<textarea name="details" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" id="details" cols="30" rows="5">{{ old('details', optional($bankAccount)->details) }}</textarea>

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