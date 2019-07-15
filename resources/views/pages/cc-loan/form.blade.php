{{-- Name --}}
<div class="form-group">
	<label for="loan_from">
		Loan From
	</label>

	<input type="text" class="form-control{{ $errors->has('loan_from') ? ' is-invalid' : '' }}" name="loan_from" id="loan_from" value="{{ old('loan_from', optional($ccLoan)->loan_from) }}">

	@if ($errors->has('loan_from'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('loan_from') }}</strong>
	</span>
	@endif
</div>

{{-- limit --}}
<div class="form-group">
	<label for="limit">
		Limit
	</label>

	<input type="number" min="0" step="any" class="form-control{{ $errors->has('limit') ? ' is-invalid' : '' }}" name="limit" id="limit" value="{{ old('limit', optional($ccLoan)->limit) }}">

	@if ($errors->has('limit'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('limit') }}</strong>
	</span>
	@endif
</div> 

{{-- available --}}
<div class="form-group">
	<label for="available">
		Available
	</label>

	<input type="number" min="0" step="any" class="form-control{{ $errors->has('available') ? ' is-invalid' : '' }}" name="available" id="available" value="{{ old('available', optional($ccLoan)->available) }}">

	@if ($errors->has('available'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('available') }}</strong>
	</span>
	@endif
</div> 


{{-- Amount --}}
<div class="form-group">
	<label for="interest_rate">
		Profit Rate
	</label>

	<input type="number" min="0" step="any" class="form-control{{ $errors->has('interest_rate') ? ' is-invalid' : '' }}" name="interest_rate" id="interest_rate" value="{{ old('interest_rate', optional($ccLoan)->interest_rate) }}">

	@if ($errors->has('interest_rate'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('interest_rate') }}</strong>
	</span>
	@endif
</div> 

{{-- Remarks --}}
<div class="form-group">
	<label for="details">
		Remarks
	</label>

	<textarea name="details" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" id="details" cols="30" rows="5">{{ old('details', optional($ccLoan)->details) }}</textarea>

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