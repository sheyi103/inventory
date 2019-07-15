<div class="form-group">
	<label for="head_accounts_id">Select Head Account</label>
	<select name="head_account_id" class="form-control{{ $errors->has('head_accounts_id') ? ' is-invalid' : '' }}" id="head_accounts_id">
		<option value="">Select Type</option>
		@forelse($headAccounts as $headAccount)
			<option value="{{ $headAccount->id }}" 
				@if( old('head_account_id', optional($account)->head_account_id) == $headAccount->id )
					selected
				@endif
				>
				{{ $headAccount->name }}
			</option>
		@empty
			<option value="">No Head Account Found</option>
		@endforelse
	</select>
	@if ($errors->has('head_accounts_id'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('head_accounts_id') }}</strong>
		</span>
	@endif
</div>

{{-- Accounts Name --}}
<div class="form-group">
	<label for="name">
		{{ __('Name') }}
	</label>

	<input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" value="{{ old('name', optional($account)->name) }}">

	@if ($errors->has('name'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('name') }}</strong>
		</span>
	@endif
</div>

{{-- Opening balance --}}
<div class="form-group">
	<label for="open_balance">
		Opening Balance
	</label>

	<input type="number" class="form-control{{ $errors->has('open_balance') ? ' is-invalid' : '' }}" name="open_balance" id="open_balance" value="{{ old('open_balance', optional($account)->open_balance) }}" placeholder="0000" min="0" step="any">

	@if($errors->has('open_balance'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('open_balance') }}</strong>
		</span>
	@endif
</div>

<div class="form-group row mb-0">
	<div class="col-md-12">
		<button type="submit" class="btn btn-primary">
			{{ __('Save') }}
		</button>
	</div>
</div>