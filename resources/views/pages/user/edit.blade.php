@extends('layouts.master')
@section('title', 'User')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('user') }}">Users</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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

                        {{-- Mobile --}}
                        <div class="form-group">
                            <label for="mobile">
                                Mobile
                            </label>

                            <input type="text" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" id="mobile" value="{{ old('mobile', optional($user)->mobile) }}" placeholder="Mobile">

                            @if ($errors->has('mobile'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('mobile') }}</strong>
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
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('script')
    <script src="{{ asset('js/library/image-upload.js') }}"></script>
@endsection 
