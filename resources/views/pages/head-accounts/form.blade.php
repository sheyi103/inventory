<div class="form-group">
	<label for="account_type_id">Select Account Type</label>
	<select name="account_type_id" class="form-control{{ $errors->has('account_type_id') ? ' is-invalid' : '' }}" id="account_type_id">
		<option value="">Select Type</option>
		@forelse($accountTypes as $accountType)
			<option value="{{ $accountType->id }}" 
				@if( old('account_type_id', optional($headAccount)->account_type_id) == $accountType->id )
					selected
				@endif
				>
				{{ $accountType->name }}
			</option>
		@empty
			<option value="">No Type Found</option>
		@endforelse
	</select>
	@if ($errors->has('account_type_id'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('account_type_id') }}</strong>
		</span>
	@endif
</div>

{{-- Head-accounts Name --}}
<div class="form-group">
	<label for="name">
		{{ __('Name') }}
	</label>

	<input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" value="{{ old('name', optional($headAccount)->name) }}">

	@if ($errors->has('name'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('name') }}</strong>
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