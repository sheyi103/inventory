@extends('layouts.master')
@section('title', 'Bank Transaction')

@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Add Transaction</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{ url('bank-account') }}">Accounts</a></li>
						<li class="breadcrumb-item active">Transaction</li>
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
						<form method="POST" action="{{ route('bank-transaction.store') }}">
							@csrf
							@include('pages.bank-transaction.form')
						</form>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
@endsection