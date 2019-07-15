{{-- Date --}}
<div class="form-group">
	<label for="date">
		Date
	</label>

	<input type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="date" value="{{ old('date', optional($purchaseTransaction)->date) }}">

	@if ($errors->has('date'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('date') }}</strong>
	</span>
	@endif
</div>

{{-- Customer --}}
<div class="form-group">
	<label for="supplier_id">Select Supplier</label>
	<select name="supplier_id" class="form-control{{ $errors->has('supplier_id') ? ' is-invalid' : '' }}" id="supplier_id">
		<option value="">Select</option>
		@forelse($suppliers as $supplier)
		<option value="{{ $supplier->id }}" 
			@if( old('supplier_id', optional($purchaseTransaction)->supplier_id) == $supplier->id )
			selected
			@endif
			>
			{{ $supplier->name }}
		</option>
		@empty
		<option value="">No Supplier Found</option>
		@endforelse
	</select>
	@if ($errors->has('supplier_id'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('supplier_id') }}</strong>
	</span>
	@endif
</div>

{{-- Amount --}}
<div class="form-group">
	<label for="amount">
		Amount
	</label>

	<input type="number" min="0" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" id="amount" value="{{ old('amount', optional($purchaseTransaction)->amount) }}">

	@if ($errors->has('amount'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('amount') }}</strong>
	</span>
	@endif
</div>

{{-- Payment Type --}}

<div class="form-group">
	<label for="payment_type">Payment Type</label>
	<select name="payment_type" class="form-control{{ $errors->has('payment_type') ? ' is-invalid' : '' }}" id="payment_type">
		<option value="">Select</option>
		<option value="1" {{old('payment_type', optional($purchaseTransaction)->payment_type) =='1' ? 'selected':''}}>Cash</option>
		<option value="2" {{old('payment_type', optional($purchaseTransaction)->payment_type) =='2' ? 'selected':''}}>Due</option>
		<option value="3" {{old('payment_type', optional($purchaseTransaction)->payment_type) =='3' ? 'selected':''}}>Advance</option>
	</select>
	@if ($errors->has('payment_type'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('payment_type') }}</strong>
	</span>
	@endif
</div>

{{-- Payment Mode --}}

<div class="form-group">
	<label for="payment_mode">Payment Mode</label>
	<select name="payment_mode" class="form-control{{ $errors->has('payment_mode') ? ' is-invalid' : '' }}" id="payment_mode">
		<option value="">Select</option>
		<option value="1" {{old('payment_mode', optional($purchaseTransaction)->payment_mode) =='1' ? 'selected':''}}>Hand Cash</option>
		<option value="2" {{old('payment_mode', optional($purchaseTransaction)->payment_mode) =='2' ? 'selected':''}}>Regular Banking</option>
		<option value="3" {{old('payment_mode', optional($purchaseTransaction)->payment_mode) =='3' ? 'selected':''}}>Mobile Banking</option>
	</select>
	@if ($errors->has('payment_mode'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('payment_mode') }}</strong>
	</span>
	@endif
</div>

{{-- Banking Section --}}
<div id="banking_section">
	<div class="form-group">
		<label for="bank_account_id">Select Account</label>
		<select name="bank_account_id" class="form-control{{ $errors->has('bank_account_id') ? ' is-invalid' : '' }}" id="bank_account_id">
			<option value="">Select</option>
			@forelse($accounts as $account) 
			<option value="{{ $account->id }}" @if( old('bank_account_id', optional($purchaseTransaction)->bank_account_id) == $account->id ) selected @endif> {{ $account->account_no }} 
			</option> 
			@empty 
			<option value="">No Account Found</option> 
			@endforelse
		</select> 
		@if ($errors->has('bank_account_id'))
			<span class="invalid-feedback">
				<strong>{{ $errors->first('bank_account_id') }}</strong> 
			</span> 
		@endif 
	</div> 
	{{-- account number --}}
{{-- 	<div class="form-group">
		<label for="bank_account_number">Account Number</label>
		<input type="text" class="form-control{{ $errors->has('bank_account_number') ? ' is-invalid' : '' }}" name="bank_account_number" id="bank_account_number" value="{{ old('bank_account_number', optional($purchaseTransaction)->bank_account_number) }}">
		@if ($errors->has('bank_account_number'))
			<span class="invalid-feedback">
				<strong>{{ $errors->first('bank_account_number') }}</strong>
			</span>
		@endif
	</div> --}}
	<div class="form-group">
		<label for="cheque_number">Cheque Number</label>
		<input type="text" class="form-control{{ $errors->has('cheque_number') ? ' is-invalid' : '' }}" name="cheque_number" id="cheque_number" value="{{ old('cheque_number', optional($purchaseTransaction)->cheque_number) }}">
		@if ($errors->has('cheque_number'))
			<span class="invalid-feedback">
				<strong>{{ $errors->first('cheque_number') }}</strong>
			</span>
		@endif
	</div>	
</div>

{{-- Mobile Banking Section --}}
<div id="mobile_banking_section">
	<div class="form-group">
		<label for="mobile_banking_id">Select Mobile Banking</label>
		<select name="mobile_banking_id" class="form-control{{ $errors->has('mobile_banking_id') ? ' is-invalid' : '' }}" id="mobile_banking_id">
			<option value="">Select Mobile Banking</option> 
			@forelse($mobileBankings as $mobileBanking) 
			<option value="{{ $mobileBanking->id }}" @if( old('mobile_banking_id', optional($purchaseTransaction)->mobile_banking_id) == $mobileBanking->id ) selected @endif> 
				{{ $mobileBanking->name }} 
			</option> 
			@empty 
			<option value="">No Mobile Banking Found</option> 
			@endforelse 
		</select> 
		@if ($errors->has('mobile_banking_id')) 
			<span class="invalid-feedback"> 
				<strong>{{ $errors->first('mobile_banking_id') }}</strong> 
			</span> 
		@endif 
	</div> 
	{{-- phone number --}}
	<div class="form-group">
		<label for="phone_number">Phone  Number</label>
		<input type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" id="phone_number" value="{{ old('phone_number', optional($purchaseTransaction)->phone_number) }}">
		@if ($errors->has('phone_number'))
			<span class="invalid-feedback">
				<strong>{{ $errors->first('phone_number') }}</strong>
			</span>
		@endif
	</div>
</div>

{{-- Receiver --}}
<div class="form-group">
	<label for="receiver">
		Receiver
	</label>

	<input type="text" class="form-control{{ $errors->has('receiver') ? ' is-invalid' : '' }}" name="receiver" id="receiver" value="{{ old('receiver', optional($purchaseTransaction)->receiver) }}">

	@if ($errors->has('receiver'))
	<span class="invalid-feedback">
		<strong>{{ $errors->first('receiver') }}</strong>
	</span>
	@endif
</div>

{{-- Remarks --}}
<div class="form-group">
	<label for="details">Remarks</label>
	<textarea name="details" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" id="details" cols="30" rows="5">{{ old('details', optional($purchaseTransaction)->details) }}</textarea>

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
		$( "#date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	});

	//show or hide banking and mobile banking section on page load
	$(document).ready(function(){
		var payment_mode = $('#payment_mode').val();
		if (payment_mode == 2) {
			$('#mobile_banking_section').hide();
			$('#banking_section').show();
		}

		else if (payment_mode == 3) {
			$('#banking_section').hide();
			$('#mobile_banking_section').show();
		}
		else{
			$('#mobile_banking_section').hide();
			$('#banking_section').hide();
		}
	});

	$('#supplier_id').select2({
		placeholder: 'Select Supplier',

		ajax: {
			url: '{!!URL::route('supplier-autocomplete-search')!!}',
			dataType: 'json',
			delay: 250,
			processResults: function (data) {
				return {
					results: data
				};
			},
			cache: true
		},
		theme: "bootstrap"
	});

	$('#payment_mode').on('change', function(){
		var payment_mode = $('#payment_mode').val();
		if (payment_mode == 2) {
			$('#mobile_banking_section').hide();
			$('#banking_section').show();
		}

		else if (payment_mode == 3) {
			$('#banking_section').hide();
			$('#mobile_banking_section').show();
		}
		else{
			$('#mobile_banking_section').hide();
			$('#banking_section').hide();
		}
	});
</script>
@endsection