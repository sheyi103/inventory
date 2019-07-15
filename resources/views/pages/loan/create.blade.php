@extends('layouts.master')
@section('title', 'Loan')

@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Add Loan</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{ url('loan') }}">Loans</a></li>
						<li class="breadcrumb-item active">Create</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<div class="card">
					<div class="card-body">
						<form method="POST" action="{{ route('loan.store') }}">
							@csrf
							@include('pages.loan.form')
						</form>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
@endsection