{{-- Name --}}
<div class="form-group">
	<label for="name">
		Name
	</label>

	<input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" value="{{ old('name', optional($supplier)->name) }}" placeholder="Name">

	@if ($errors->has('name'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('name') }}</strong>
		</span>
	@endif
</div>

{{-- Mobile --}}
<div class="form-group">
	<label for="mobile">
		Mobile
	</label>

	<input type="text" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" id="mobile" value="{{ old('mobile', optional($supplier)->mobile) }}" placeholder="Mobile">

	@if ($errors->has('mobile'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('mobile') }}</strong>
		</span>
	@endif
</div>

{{-- Address --}}
<div class="form-group">
	<label for="address">
		Address
	</label>

	<textarea name="address" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" id="address" cols="30" rows="5" placeholder="Address">{{ old('address', optional($supplier)->address) }}</textarea>

	@if( $errors->has('address'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('address') }}</strong>
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