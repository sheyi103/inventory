{{-- Name --}}
<div class="form-group">
	<label for="name">
		Name
	</label>

	<input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" value="{{ old('name', optional($user)->name) }}" placeholder="Name">

	@if ($errors->has('name'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('name') }}</strong>
		</span>
	@endif
</div>

{{-- Email --}}
<div class="form-group">
	<label for="email">
		Email
	</label>

	<input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" value="{{ old('email', optional($user)->email) }}" placeholder="Email">

	@if($errors->has('email'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('email') }}</strong>
		</span>
	@endif
</div>

{{-- Password --}}
<div class="form-group">
	<label for="password">
		Password
	</label>

	<input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password" value="{{ old('password') }}" placeholder="Password">

	@if($errors->has('password'))
		<span class="invalid-feedback">
			<strong>{{ $errors->first('password') }}</strong>
		</span>
	@endif
</div>

{{-- Show Image --}}
@if( optional($user)->image ) 
	<div class="form-group" id="showImage">
		<img src="{{ asset('images/users/'.$user->image) }}" alt="" class="img-thumbnail" width="200">
		<input type="hidden" value="{{ $user->image }}" name="oldimage">
	</div>	
@endif

{{-- Upload Image --}}
<div class="form-group" style="display: none;" id="uploadImage">
	<img id="upload" class="img-thumbnail" width="200" src="#" alt="" />
</div>

{{-- Image --}}
<div class="form-group">
	<label for="image">
		Image
	</label>

	<input type="file" class="form-control-file" name="image" id="image" accept="image/*" onchange="handleFiles(this.files)">
	<small id="fileHelp" class="form-text text-muted">(JPEG or PNG Format)</small>

	@if ($errors->has('image'))
		<span class="invalid-feedback" style="display: block;">
			<strong>{{ $errors->first('image') }}</strong>
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
	<script src="{{ asset('js/library/image-upload.js') }}"></script>
@endsection	