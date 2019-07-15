@extends('layouts.master')
@section('title', 'Purchase Payment')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Purchase Payment Details</h1>
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
									<td>{{ $purchaseTransaction->date }}</td>
								</tr>
								<tr>
									<td>Supplier</td>
									<td>{{ $purchaseTransaction->supplier->name }}</td>
								</tr>

								<tr>
									<td>Amount</td>
									<td>{{ $purchaseTransaction->amount }}</td>
								</tr>
								<tr>
									<td>Payment Type</td>
									@if($purchaseTransaction->payment_type == 1)
									<td>{{ 'Cash' }}</td>
									@elseif($purchaseTransaction->payment_type == 2)
									<td>{{ 'Due' }}</td>
									@else 
									<td>{{ 'Advance' }}</td>
									@endif
								</tr>
								<tr>
									<td>Payment Mode</td>
									@if($purchaseTransaction->payment_mode == 1)
									<td>{{ 'Hand Cash' }}</td>
									@elseif($purchaseTransaction->payment_mode == 2)
									<td>{{ 'Regular Banking' }}</td>
									@else 
									<td>{{ 'Mobile Banking' }}</td>
									@endif
								</tr>
								@if($purchaseTransaction->payment_mode == 2)
								<tr>
									<td>Account</td>
									<td>{{ $purchaseTransaction->account->account_no }}</td>
								</tr>
								<tr>
									<td>Cheque Number</td>
									<td>{{ $purchaseTransaction->cheque_number }}</td>
								</tr>
								@endif

								@if($purchaseTransaction->payment_mode == 3)
								<tr>
									<td>Mobile Banking</td>
									<td>{{ $purchaseTransaction->mobileBanking->name }}</td>
								</tr>
								<tr>
									<td>Phone Number</td>
									<td>
										{{ $purchaseTransaction->phone_number }}
									</td>
								</tr>
								@endif
								<tr>
									<td>Receiver</td>
									<td>{{ $purchaseTransaction->receiver }}</td>
								</tr>
								<tr>
									<td>Remarks</td>
									<td>{{ $purchaseTransaction->details }}</td>
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