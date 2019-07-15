{{-- Name --}}
<div class="form-group">
	<label for="name">
		Name
	</label>

	<input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" value="{{ old('name', optional($flat)->name) }}" placeholder="Name">

	@if ($errors->has('name'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('name') }}</strong>
		</span>
	@endif
</div>

{{-- Tenant Name --}}
<div class="form-group">
	<label for="tenant_name">
		Tenant Name
	</label>

	<input type="text" class="form-control{{ $errors->has('tenant_name') ? ' is-invalid' : '' }}" name="tenant_name" id="tenant_name" value="{{ old('tenant_name', optional($flat)->tenant_name) }}" placeholder="Tenant Name">

	@if ($errors->has('tenant_name'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('tenant_name') }}</strong>
		</span>
	@endif
</div>

{{-- Tenant Mobile --}}
<div class="form-group">
	<label for="tenant_mobile">
		Tenant Mobile
	</label>

	<input type="text" class="form-control{{ $errors->has('tenant_mobile') ? ' is-invalid' : '' }}" name="tenant_mobile" id="tenant_mobile" value="{{ old('tenant_mobile', optional($flat)->tenant_mobile) }}" placeholder="Tenant Mobile">

	@if ($errors->has('tenant_mobile'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('tenant_mobile') }}</strong>
		</span>
	@endif
</div>

{{-- Details --}}
<div class="form-group">
	<label for="details">
		Remarks
	</label>

	<textarea name="details" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" id="details" cols="30" rows="5" placeholder="Remarks">{{ old('details', optional($flat)->details) }}</textarea>

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