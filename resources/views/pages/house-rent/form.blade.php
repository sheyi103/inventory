{{-- Name --}}
<div class="form-group">
	<label for="date">
		Date
	</label>

	<input type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="date" value="{{ old('date', optional($houseRent)->date) }}" placeholder="Date">

	@if ($errors->has('date'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('date') }}</strong>
		</span>
	@endif
</div>

{{-- houseRent Type --}}
<div class="form-group">
	<label for="flat_id">Flat Name</label>
	<select name="flat_id" class="form-control{{ $errors->has('flat_id') ? ' is-invalid' : '' }}" id="flat_id">
		<option value="">Select</option>
		@forelse($flats as $flat)
			<option value="{{ $flat->id }}" 
				@if( old('flat_id', optional($houseRent)->flat_id) == $flat->id )
					selected
				@endif
				>
				{{ $flat->name }}
			</option>
		@empty
			<option value="">No Flat Found</option>
		@endforelse
	</select>
	@if ($errors->has('flat_id'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('flat_id') }}</strong>
		</span>
	@endif
</div>

{{-- Amount --}}
<div class="form-group">
	<label for="amount">
		Amount
	</label>

	<input type="number" step="any" min="0" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" id="amount" value="{{ old('amount', optional($houseRent)->amount) }}" placeholder="Amount">

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

	<textarea name="details" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" id="details" cols="30" rows="5" placeholder="Remarks">{{ old('details', optional($houseRent)->details) }}</textarea>

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