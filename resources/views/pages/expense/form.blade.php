{{-- Name --}}
<div class="form-group">
	<label for="date">
		Date
	</label>

	<input type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="date" value="{{ old('date', optional($expense)->date) }}">

	@if ($errors->has('date'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('date') }}</strong>
		</span>
	@endif
</div>

{{-- Expense Type --}}
<div class="form-group">
	<label for="expense_item_id">Expense Type</label>
	<select name="expense_item_id" class="form-control{{ $errors->has('expense_item_id') ? ' is-invalid' : '' }}" id="expense_item_id">
		<option value="">Select</option>
		@forelse($items as $item)
			<option value="{{ $item->id }}" 
				@if( old('expense_item_id', optional($expense)->expense_item_id) == $item->id )
					selected
				@endif
				>
				{{ $item->name }}
			</option>
		@empty
			<option value="">No Expense Type Found</option>
		@endforelse
	</select>
	@if ($errors->has('expense_item_id'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('expense_item_id') }}</strong>
		</span>
	@endif
</div>

{{-- Amount --}}
<div class="form-group">
	<label for="amount">
		Amount
	</label>

	<input type="text" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" id="amount" value="{{ old('amount', optional($expense)->amount) }}">

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

	<textarea name="details" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" id="details" cols="30" rows="5">{{ old('details', optional($expense)->details) }}</textarea>

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