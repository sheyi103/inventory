@extends('layouts.master')
@section('title', 'Purchase')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">View Purchase</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{ url('purchase') }}">Purchases</a></li>
						<li class="breadcrumb-item active">View</li>
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
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							<tbody>
								<tr>
									<td>Date</td>
									<td>{{ $purchase->date }}</td>
								</tr>
								<tr>
									<td>Invoice</td>
									<td>{{ $purchase->invoice }}</td>
								</tr>
								<tr>
									<td>Item</td>
									<td>{{ $purchase->rawMaterial->name }}</td>
								</tr>

								<tr>
									<td>Supplier</td>
									<td>{{ $purchase->supplier->name }}</td>
								</tr>
								<tr>
									<td>Quantity</td>
									<td>{{ $purchase->quantity }}</td>
								</tr>
								<tr>
									<td>Rate</td>
									<td>{{ $purchase->rate }}</td>
								</tr>
								<tr>
									<td>Amount</td>
									<td>{{ $purchase->amount }}</td>
								</tr>
								<tr>
									<td>Remarks</td>
									<td>{{ $purchase->details }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection